<?php

namespace Kaleidoscope\Factotum\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;

use Kaleidoscope\Factotum\Library\ContentSearch;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\Content;

use Kaleidoscope\Factotum\Mail\AuthForgottenPassword;
use Kaleidoscope\Factotum\User;


class FrontController extends Controller
{

	protected $currentLanguage;
	protected $uri;
	protected $uriParts;
	protected $origUriParts;
	protected $pageContentType;


	public function __construct()
	{
		$this->pageContentType = ContentType::where( 'content_type', 'page')->first();

		if ( $this->pageContentType ) {
			$this->pageContentType = $this->pageContentType->toArray();
		}

		$this->middleware(function ($request, $next) {
			// TODO: rilevare la lingua dall URI
			$this->currentLanguage = $request->session()->get('currentLanguage');

			View::share( 'availableLanguages', config('factotum.site_languages') );

			$uri = $request->path();
			$this->uri = trim($uri, '/');

			if ( $this->uri != '' ) {
				$this->uriParts     = explode('/', $this->uri);
				$this->origUriParts = $this->uriParts;
			}

			$checkLang = ( isset($this->uriParts) ? $this->uriParts[0] : '' );

			if ( strlen($checkLang) == 5 &&
				in_array( $checkLang, array_keys( config('factotum.site_languages') ) )  ) {
				$this->currentLanguage = $checkLang;
				// TODO: non gestire con la sessione la lingua
				$request->session()->put('currentLanguage', $checkLang);
				App::setLocale( $checkLang );
			} else {
				$this->currentLanguage = config('factotum.main_site_language');
			}

			View::share( 'currentLanguage', $this->currentLanguage );

			$menu = Content::with('childrenRecursive')
							->whereNull( 'parent_id' )
							->where( 'status', 'publish' )
							->where( 'lang', $this->currentLanguage )
							->where( 'show_in_menu', 1 )
							->orderBy('order_no', 'ASC')
							->get();

			View::share( 'menu', $menu );

			if ( method_exists( app('App\Http\Controllers\Controller'), 'registerViewShare' ) ) {
				app('App\Http\Controllers\Controller')->registerViewShare();
			}

			return $next($request);
		});
	}


	protected function _getContentByURI($uri)
	{
		$contentSearch = new ContentSearch( $this->pageContentType );

		$content = $contentSearch->addWhereCondition( 'abs_url', '=', url('') . '/' . $uri )
								 ->onlyPublished()
								 ->addLimit(1)
								 ->search();

		$content =  ( $content && $content->count() > 0 ? $content[0] : null );

		if ( !$content ) {

			$uriParts = explode( '/' , $uri );
			$uri = $uriParts[ count($uriParts) - 1 ];

			$content = DB::table('contents')
							->select(DB::raw('*'))
							->where('url', '=', $uri)
							->where('status', '=', 'publish')
							->first();

			if ( $content ) {

				$contentType = ContentType::find($content->content_type_id)->toArray();
				$contentSearch = new ContentSearch( $contentType );
				$content = $contentSearch->addWhereCondition( 'url', '=', $uri )
										 ->onlyPublished()
										 ->loadCategories(true)
										 ->search();

				return ( $content ? $content[0] : null );

			} else {

				return null;

			}

		} else {

			return $content;

		}

	}


	protected function _getCategoryByURIandContentType($uri, $contentTypeID)
	{
		return Category::whereName($uri)
						->whereContentTypeId($contentTypeID)
						->first();
	}


	protected function _switchContent( $content, $category = null )
	{
		if ($content) {

			if ( $content->status == 'publish' ) {

				$contentType = ContentType::find($content->content_type_id);

				if ( isset($content->page_operation) ) {

					switch ($content->page_operation) {

						case 'show_content':
							return [    'view' => $content->page_template,
										'data' => [
											'content' => $content
										]
							];
							break;

						case 'content_list':
							$contentType = ContentType::where( 'content_type', $content->content_type_to_list )->first()->toArray();

							list($orderBy, $sort) = explode('-', $content->content_list_order);

							$contentSearch = new ContentSearch($contentType);
							$contentSearch->onlyPublished();
							$contentSearch->loadCategories(true);

							if ( $category ) {
								$contentSearch->filterByCategories( $category );
							}

							$contentSearch->addWhereCondition('lang', '=', $this->currentLanguage);
							$contentSearch->addOrderBy( $orderBy, $sort);

							if ( $content->content_list_pagination ) {
								$contentSearch->addPagination($content->content_list_pagination);
							}

							$contentList = $contentSearch->search();

							return [  'view' => $content->page_template,
									  'data' => [
											'content'     => $content,
											'contentList' => $contentList,
											'currentCategory' => ( isset($category) ? $category : null )
									  ] ];
							break;

						case 'link':
							return [
								'data'   => [ 'content' => $content ],
								'link'   => $content->link
							];
							break;

						case 'action':
							return [
											'data'   => [ 'content' => $content ],
											'action' => $content->action,
											'view'   => $content->page_template,
								   ];
							break;
					}

				} else {
					return [
							'view' => $contentType->content_type,
							'data' => [ 'content' => $content ]
					];
				}

			} else {
				return [ 'view' => 'errors.404' ];
			}

		} else {
			return [ 'view' => 'errors.404' ];
		}
	}


	// Function for parsing URIs just for categories
	protected function _reparseUri()
	{
		if ( count($this->uriParts) > 0 ) {
			$uri = array_pop( $this->uriParts );
			$content = $this->_getContentByURI( join('/', $this->uriParts) );
			if (isset($content->page_operation) && $content->page_operation == 'content_list') {
				$uri = $this->origUriParts[ count($this->origUriParts) - 1 ];
				$category = $this->_getCategoryByURIandContentType( $uri, $content->content_type_to_list );
				return $this->_switchContent($content, $category);
			} else {
				return $this->_reparseUri();
			}
		} else {
			return $this->_switchContent( null );
		}
	}


	protected function _getHomepage( $lang )
	{
		$contentSearch = new ContentSearch( $this->pageContentType );
		$content = $contentSearch->addWhereCondition('is_home', '=', true )
								  ->addWhereCondition('lang', '=', $lang )
								  ->addLimit(1)
								  ->search()[0];
		return $this->_switchContent( $content );
	}


	protected function _extractContentOnIndex( $uri = '' )
	{
		$uri = trim( $uri, '/' );

		if ( $uri != '' ) {
			$checkLang = $this->uriParts[0];


			if ( strlen($uri) == 5 && strlen($checkLang) == 5 ) {
				if ( in_array( $checkLang, array_keys( config('factotum.site_languages') ) ) ) {
					$data = $this->_getHomepage( $checkLang );
				}
			}

			if ( !isset($data) ) {

				$content = $this->_getContentByURI( $uri );

				// Page or content exist
				if ( $content ) {

					$data = $this->_switchContent( $content );

				} else {

					// Check if is a series of categories
					$data = $this->_reparseUri();

				}

			}

		} else {

			$data = $this->_getHomepage( config('factotum.main_site_language') );

		}

		return $data;
	}


	public function index($uri = '', Request $request)
	{
		$data = $this->_extractContentOnIndex($uri);

		if ( isset($data['action']) ) {

			return app('App\Http\Controllers\Controller')->{$data['action']}($request, $data);

		} elseif ( isset($data['link']) ) {

			return redirect($data['link'], 301);

		} elseif ( isset( $data['data'] ) ) {

			return view( $data['view'] )->with( $data['data'] );

		} else {

			return view( $data['view'] );

		}
	}

}
