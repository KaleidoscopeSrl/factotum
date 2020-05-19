<?php

use Illuminate\Database\Seeder;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\Role;



class EcommerceTableSeeder extends Seeder
{

	private function _setCustomerRole()
	{
		// RUOLO "CUSTOMER"
		$customer = new Role;
		$customer->fill([
			'role'                        => 'customer',
			'backend_access'              => 0,
			'manage_content_types'        => 0,
			'manage_users'                => 0,
			'manage_media'                => 0,
			'manage_settings'             => 0,
			'manage_brands'               => 0,
			'manage_products'             => 0,
			'manage_orders'               => 0,
			'manage_discount_codes'       => 0,
			'manage_product_categories'   => 0,
		]);
		$customer->save();
	}


	private function _changeAdminCapabilities()
	{
		$admin = Role::where('role', 'admin')->first();
		$admin->manage_brands             = 1;
		$admin->manage_products           = 1;
		$admin->manage_orders             = 1;
		$admin->manage_discount_codes     = 1;
		$admin->manage_product_categories = 1;
		$admin->manage_carts              = 1;
		$admin->manage_taxes              = 1;
		$admin->save();
	}

	private function _setOrder()
	{
		$orderContentType = new ContentType;
		$orderContentType->content_type = 'order';
		$orderContentType->label        = 'Ordine';
		$orderContentType->editable     = true;
		$orderContentType->visible      = true;
		$orderContentType->icon         = 'content';
		$orderContentType->save();

		$contentField = new ContentField;
		$contentField->content_type_id = $orderContentType->id;
		$contentField->name            = 'order_status';
		$contentField->label           = 'Stato Ordine';
		$contentField->type            = 'select';
		$contentField->mandatory       = true;
		$templates = [
			[ 'value' => 'waiting_payment',   'label' => 'In attesa di pagamento' ],
			[ 'value' => 'progress',          'label' => 'In lavorazione' ],
			[ 'value' => 'waiting',           'label' => 'In sospeso' ],
			[ 'value' => 'done',              'label' => 'Completato' ],
			[ 'value' => 'canceled',          'label' => 'Annullato' ],
			[ 'value' => 'refunded',          'label' => 'Rimborsato' ],
			[ 'value' => 'failed',            'label' => 'Fallito' ],
		];
		$contentField->options = json_encode( $templates );
		$contentField->save();
	}


    public function run()
    {
		$this->_setCustomerRole();
		$this->_changeAdminCapabilities();
    }

}
