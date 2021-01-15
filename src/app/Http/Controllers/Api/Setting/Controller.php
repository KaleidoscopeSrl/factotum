<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Lang;
use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;

use Kaleidoscope\Factotum\Traits\CartUtils;
use Kaleidoscope\Factotum\Http\Requests\StoreSetting;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Content;



class Controller extends ApiBaseController
{
	
	use CartUtils;


	public function getSettings( Request $request )
	{
		$settings = [
			'ecommerce'        => env('FACTOTUM_ECOMMERCE_INSTALLED')  ? true : false,
			'newsletter'       => env('FACTOTUM_NEWSLETTER_INSTALLED') ? true : false,
			'unlayer_id'       => ( env('FACTOTUM_NEWSLETTER_INSTALLED') && env('UNLAYER_PROJECT_ID') ? env('UNLAYER_PROJECT_ID') : null ),
			'version'          => config('factotum.version'),
			'default_language' => config('factotum.main_site_language')
		];
		
		if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {
			$settings['product_vat_included'] = config('factotum.product_vat_included');
		}
		return $settings;
	}


	public function brandsViaPim( Request $request )
	{
		return [
			'result' => config('factotum.brands_via_pim')
		];
	}


	public function productCategoriesViaPim( Request $request )
	{
		return [
			'result' => config('factotum.product_categories_via_pim')
		];
	}


	public function productsViaPim( Request $request )
	{
		return [
			'result' => config('factotum.products_via_pim')
		];
	}


	public function saveHomepageByLanguage( StoreSetting $request )
	{
		$contentType        = ContentType::where( 'content_type', 'page')->first();
		$availableLanguages = config('factotum.site_languages');

		if ( count($availableLanguages) > 0 ) {

			foreach ( $availableLanguages as $lang => $label ) {

				if ( $request->input('page_homepage_' . $lang ) ) {

					DB::table( 'contents' )
						->where( 'content_type_id', $contentType->id )
						->where( 'lang', $lang )
						->update( ['is_home' => 0] );

					$contentID = $request->input('page_homepage_' . $lang );
					$content = Content::find($contentID);
					$content->is_home = true;
					$content->save();

				}

			}

		}

		return response()->json(['result' => 'ok']);
	}
	
	
	public function getShippingOptions( Request $request )
	{
		return response()->json([ 'result' => 'ok', 'shipping_options' => $this->_getShippingOptions() ]);
	}


	public function getPaymentOptions( Request $request )
	{
		$paymentOptions = config('factotum.payment_methods');
		$tmp = [];

		if ( in_array( 'stripe', $paymentOptions ) ) {
			$tmp[ 'stripe' ] = Lang::get('factotum::ecommerce_checkout.credit_or_debit_cart');
		}
		
		if ( in_array( 'paypal', $paymentOptions ) ) {
			$tmp[ 'paypal' ] = 'PayPal';
		}
		
		if ( in_array( 'bank-transfer', $paymentOptions ) ) {
			$tmp[ 'bank-transfer' ] = Lang::get('factotum::ecommerce_checkout.bank_transfer');
		}
		
		if ( in_array( 'custom-payment', $paymentOptions ) ) {
			$tmp[ 'custom-payment' ] = Lang::get('factotum::ecommerce_checkout.custom_payment_in_agreement_with');
		}

		return response()->json([ 'result' => 'ok', 'payment_options' => $tmp ]);
	}

}
