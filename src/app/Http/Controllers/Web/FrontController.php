<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


use Kaleidoscope\Factotum\Brand;
use Kaleidoscope\Factotum\Library\ContentSearch;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\Notifications\NewOrderToCustomerNotification;
use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\ProductCategory;

use Kaleidoscope\Factotum\Mail\AuthForgottenPassword;
use Kaleidoscope\Factotum\Notifications\ResetPasswordNotification;
use Kaleidoscope\Factotum\User;


class FrontController extends Controller
{

	protected $currentLanguage;
	protected $uri;
	protected $uriParts;
	protected $origUriParts;
	protected $pageContentType;



	protected function _getContentByURI()
	{
		$contentSearch = new ContentSearch( $this->pageContentType );

		$content = $contentSearch->addWhereCondition( 'abs_url', '=', url('') . '/' . $this->uri )
								 ->onlyPublished()
								 ->addLimit(1)
								 ->search();

		$content =  ( $content && $content->count() > 0 ? $content[0] : null );

		if ( !$content ) {

			$uri = ( count($this->uriParts) > 1 ? $this->uriParts[ count($this->uriParts) - 1 ] : $this->uri );

			$content = DB::table('contents')
							->select( DB::raw('*') )
							->where([
								'status' => 'publish',
								'url'    => $uri
							])
							->first();

			if ( $content ) {

				$contentType   = ContentType::find($content->content_type_id)->toArray();
				$contentSearch = new ContentSearch( $contentType );
				$content       = $contentSearch->addWhereCondition( 'url', '=', $uri )
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


	/**
	 * Restituisce l'array che gestisce il contenuto da lavorare, a seconda di come si è impostato il contenuto
	 *
	 * @param $content
	 * @param null $category
	 * @return array
	 *
	 */
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
							$contentType = ContentType::where( 'content_type', $content->content_type_to_list )->first();
							$contentList = new LengthAwarePaginator( [], 0, 10, null );

							if ( $contentType ) {
								$contentType = $contentType->toArray();

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
							}



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

			if ( isset($content->page_operation) && $content->page_operation == 'content_list' ) {

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



	protected function _getHomepage( Request $request )
	{
		$contentSearch = new ContentSearch( $this->pageContentType );
		$content = $contentSearch->addWhereCondition('is_home', '=', true )
								  ->addWhereCondition('lang', '=', $this->_getCurrentLanguage( $request ) )
								  ->addLimit(1)
								  ->search();

		if ( $content->count() > 0 ) {
			return $this->_switchContent( $content[0] );
		}

		return null;
	}


	protected function _extractContentOnIndex( Request $request )
	{
		if ( $this->uri != '' ) {

			if ( in_array( $this->uri, array_keys( config('factotum.site_languages') ) ) ) {
				$data = $this->_getHomepage( $request );
			}

			// Non siamo su una homepage (nè principale, nè di lingua)
			if ( !isset($data) ) {

				// Check se è attivo ecommerce
				if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {

					// Check se prodotto
					$product = Product::where( 'abs_url', '/' . $this->uri )->first();

					if ( $product ) {
						$data['product'] = $product;
						return $data;
					}

					// Check se categoria prodotto
					$productCategory = ProductCategory::where( 'name', $this->uriParts[ count($this->uriParts) - 1 ] )->first();
					if ( $productCategory ) {
						$data['productCategory'] = $productCategory;
						return $data;
					}

					// Check se brand
					$brand = Brand::where( 'code', $this->uriParts[ count($this->uriParts) - 1 ] )->first();
					if ( $brand ) {
						$data['brand'] = $brand;
						return $data;
					}

				}

				$content = $this->_getContentByURI();

				// Page or content exist
				if ( $content ) {

					$data = $this->_switchContent($content);

				} else {


					// Check if is a series of categories
					$data = $this->_reparseUri();

				}

			}

		} else {

			$data = $this->_getHomepage( $request );

		}

		return $data;
	}


	public function index( Request $request, $uri = '' )
	{
		$this->uri = trim( $uri, '/' );

		$data = $this->_extractContentOnIndex( $request );

		if ( isset($data['product']) ) {

			if ( file_exists( app_path('Http/Controllers/Web/Ecommerce/Product/ReadController.php') ) ) {
				return app('App\Http\Controllers\Web\Ecommerce\Product\ReadController')->getProductDetail( $request );
			}

			return app('\Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Product\ReadController')->getProductDetail( $request );

		} elseif ( isset($data['productCategory']) ) {

			if ( file_exists( app_path('Http/Controllers/Web/Ecommerce/ProductCategory/ReadController.php') ) ) {
				return app('App\Http\Controllers\Web\Ecommerce\ProductCategory\ReadController')->getProductsByCategory($request, $this->uriParts[ count($this->uriParts) - 1 ]);
			}

			return app('\Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\ProductCategory\ReadController')->getProductsByCategory($request, $this->uriParts[ count($this->uriParts) - 1 ]);

		} elseif ( isset($data['brand']) ) {

			if ( file_exists( app_path('Http/Controllers/Web/Ecommerce/Brand/ReadController.php') ) ) {
				return app('App\Http\Controllers\Web\Ecommerce\Brand\ReadController')->getProductsByBrand($request, $this->uriParts[ count($this->uriParts) - 1 ]);
			}

			return app('\Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Brand\ReadController')->getProductsByBrand($request, $this->uriParts[ count($this->uriParts) - 1 ]);

		} elseif ( isset($data['action']) ) {

			return app('App\Http\Controllers\Controller')->{$data['action']}($request, $data);

		} elseif ( isset($data['link']) ) {

			return redirect($data['link'], 301);

		} elseif ( isset( $data['data'] ) ) {

			return view( $data['view'] )->with( $data['data'] );

		} else {

			return ( isset($data['view']) ? view( $data['view'] ) : view( 'errors.404' ) );

		}
	}


}
