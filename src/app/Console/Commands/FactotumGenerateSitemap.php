<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

use Carbon\Carbon;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


use Kaleidoscope\Factotum\ProductCategory;
use Kaleidoscope\Factotum\Product;

use Kaleidoscope\Factotum\Library\ContentSearch;
use Kaleidoscope\Factotum\ContentType;


class FactotumGenerateSitemap extends Command
{

	protected $signature = 'factotum:generate-sitemap';

	protected $description = 'Generate Sitemap';


	public function handle()
	{
		$this->info('Starting sitemap generation');

		$contentTypes = ContentType::where( 'sitemap_in', 1 )->get();

		$contentTypesInSitemap = [];
		$finalSitemapIndexes   = [];

		if ( $contentTypes->count() > 0 ) {

			foreach ( $contentTypes as $contentType ) {
				$contentSearch = new ContentSearch( $contentType->toArray() );
				$contentSearch->onlyPublished();

				$contentsToAdd = $contentSearch->search();

				if ( $contentsToAdd->count() > 0 ) {
					$contentTypesInSitemap[] = $contentType;

					$sitemap = Sitemap::create();

					foreach ( $contentsToAdd as $c ) {
						$sitemap
							->add(
								Url::create( $c->url)
									->setPriority(0.9)
									->setChangeFrequency('weekly')
									->setLastModificationDate( Carbon::createFromTimestamp( strtotime($c->updated_at) ) )
							);
					}

					$sitemap->writeToFile( public_path('sitemaps/' . $contentType->content_type . '_sitemap.xml' ));

					$this->info($contentType->content_type . '_sitemap.xml generated');
				}
			}

		}



		if ( count( $contentTypesInSitemap ) > 0 ) {
			foreach ( $contentTypesInSitemap as $ct ) {
				$finalSitemapIndexes[] = 'sitemaps/' . $ct->content_type . '_sitemap.xml';
			}
		}


		if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {
			$categories = ProductCategory::whereNull('parent_id')->get();

			if ( $categories->count() > 0 ) {
				$sitemap = Sitemap::create();

				foreach ( $categories as $cat ) {

					$childs = $cat->getFlatChildsArray();

					if ( count($childs) > 0 ) {
						foreach ($childs as $subCat ) {
							$sitemap
								->add(
									Url::create( $subCat->abs_url)
										->setPriority(0.8)
										->setLastModificationDate( Carbon::createFromTimestamp( strtotime($subCat->updated_at) ) )
								);
						}
					}

				}

				$finalSitemapIndexes[] = 'sitemaps/product_categories_sitemap.xml';
				$sitemap->writeToFile( public_path('sitemaps/product_categories_sitemap.xml' ));

				$this->info('product_categories_sitemap.xml generated');
			}

			$products = Product::all();
			if ( $products->count() > 0 ) {
				$sitemap = Sitemap::create();

				foreach ( $products as $product ) {
					$url = ( $product->abs_url ? $product->abs_url : $product->url );
					$sitemap
						->add(
							Url::create( $url )
								->setPriority(0.7)
								->setLastModificationDate( Carbon::createFromTimestamp( strtotime($product->updated_at) ) )
						);
				}

				$finalSitemapIndexes[] = 'sitemaps/products_sitemap.xml';
				$sitemap->writeToFile( public_path('sitemaps/products_sitemap.xml' ));

				$this->info('products_sitemap.xml generated');
			}
		}


		if ( count($finalSitemapIndexes) > 0 ) {
			$sitemapIndex = SitemapIndex::create();
			foreach( $finalSitemapIndexes as $index ) {
				$sitemapIndex->add( '/' . $index );
			}
			$sitemapIndex->writeToFile( public_path('sitemap.xml') );
			$this->info('sitemap.xml index generated');
		}


		$this->info('Finish sitemap generation');

		$this->info('Start ping Google for Sitemap');

		$result = $this->_pingGoogleForSitemap();

		if ( !$result ) {
			$this->error('Error on ping google for sitemap');
		} else {
			$this->info('Finish ping Google for Sitemap');
		}

	}


	private function _pingGoogleForSitemap()
	{
		try {

			$client = new Client([
				'base_uri' => 'https://www.google.com',
				'verify'   => false
			]);

			$response = $client->get( '/webmasters/sitemaps/ping?sitemap=' . env('APP_URL') . '/sitemap.xml' );

			if ( $response->getStatusCode() == 200 ) {
				return true;
			}

			return null;

		} catch ( RequestException $exception ) {

			throw new \Exception($exception->getMessage());

		}
	}

}