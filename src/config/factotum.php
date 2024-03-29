<?php

return [

	// TODO: Aggiungere colonne non nominabili per ecommerce e modulo campagne

	'prohibited_content_types' => [
		'users', 'user',
		'profiles', 'profile',
		'roles', 'role',
		'capabilities', 'capability',
		'password_resets', 'password_reset',
		'migrations', 'migration',
		'media',
		'content_types', 'content_type',
		'content_fields', 'content_field',
		'contents', 'content',
		'pages', 'page',
		'categories', 'category',
		'content_categories', 'content_category',

		( env('FACTOTUM_ECOMMERCE_INSTALLED') ? 'brand' : '' ),
		( env('FACTOTUM_ECOMMERCE_INSTALLED') ? 'brands' : '' ),
		( env('FACTOTUM_ECOMMERCE_INSTALLED') ? 'product' : '' ),
		( env('FACTOTUM_ECOMMERCE_INSTALLED') ? 'products' : '' ),
		( env('FACTOTUM_ECOMMERCE_INSTALLED') ? 'discount_code' : '' ),
		( env('FACTOTUM_ECOMMERCE_INSTALLED') ? 'discount_codes' : '' ),
		( env('FACTOTUM_ECOMMERCE_INSTALLED') ? 'product_category' : '' ),
		( env('FACTOTUM_ECOMMERCE_INSTALLED') ? 'product_categories' : '' ),
		( env('FACTOTUM_ECOMMERCE_INSTALLED') ? 'cart' : '' ),
		( env('FACTOTUM_ECOMMERCE_INSTALLED') ? 'carts' : '' ),
	],


	'content_fields' => [
		'text'                       => 'Text',
		'textarea'                   => 'Textarea',
		'wysiwyg'                    => 'Wysiwyg Editor',
		'select'                     => 'Select',
		'multiselect'                => 'Multi Select',
		'checkbox'                   => 'Checkbox',
		'multicheckbox'              => 'Multi Checkbox',
		'radio'                      => 'Radio',
		'date'                       => 'Date',
		'datetime'                   => 'Date and Time',
		'file_upload'                => 'File Upload',
		'image_upload'               => 'Image Upload',
		'gallery'                    => 'Gallery',
		'linked_content'             => 'Linked Content',
		'multiple_linked_content'    => 'Multiple Linked Content',
	],


	'image_operations' => [
		'null'   => 'None',
		'resize' => 'Resize',
		'crop'   => 'Crop',
		'fit'    => 'Fit'
	],

	// TODO: Aggiungere colonne non nominabili per ecommerce e modulo campagne

	'prohibited_content_field_names' => [
		'id',
		'parent_id',
		'content_type_id',
		'user_id',
		'status',
		'parent_content_id',
		'title',
		'content',
		'abs_url',
		'url',
		'lang',
		'show_in_menu',
		'seo_description',
		'seo_canonical_url',
		'seo_robots_indexing',
		'seo_robots_following',
		'fb_title',
		'fb_description',
		'fb_image',
		'created_at',
		'updated_at'
	],

	'thumb_size' => [
		'width'  => 100,
		'height' => 100
	],

	'main_site_language' => 'it-IT',

	'site_languages' => [
		'en-GB' => 'English',
		'it-IT' => 'Italiano'
	],

	'analytics_client_id' => '',
	'analytics_site_id'   => '',


	// PIM CONFIGURATION

	'brands_via_pim'             => false,
	'product_categories_via_pim' => false,
	'products_via_pim'           => false,

	// ECOMMERCE CONFIGURATION
	
	// BASIC
	'shop_owner_vat_number'  => env('SHOP_OWNER_VAT_NUMBER', '0000000000'),
	'shop_owner_sdi'         => env('SHOP_OWNER_SDI',        '0000000'),

	'shop_base_url'        => 'shop',
	'guest_cart'           => false,
	'product_vat_included' => false,

	// PRODUCTS
	'product_resizes' => [
		0 => [
			'w' => 1920,
			'h' => 1080
		],
		1 => [
			'w' => 812,
			'h' => 812
		],
		2 => [
			'w'  => 487,
			'h' => 487
		],
		3 => [
			'w' => 220,
			'h' => 220
		],
		4 => [
			'w' => 300,
			'h' => 300
		]
	],
	'product_resize_operation' => 'fit',

	'product_gallery_resizes' => [
		0 => [
			'w' => 960,
			'h' => 960
		],
		1 => [
			'w' => 375,
			'h' => 375
		]
	],
	'product_gallery_resize_operation' => 'fit',

	
	// PAYMENTS
	'payment_methods' => [
		'stripe',
		'paypal',
		'scalapay',
		'bank-transfer',
		'custom-payment'
	],


	// SHIPPING
	'min_free_shipping'     => 65,
	'shipping_vat_included' => false,
	'shipping_options' => [
		'pick_up' => [
			'standard' => 0
		],
		'IT' => [
			'standard' => 7,
			'express'  => 14
		],
		'other'  => [
			'standard' => 30
		],
	],


	// INVOICES
	'invoice_start_number'   => 60,
	'invoice_logo'           => '/assets/media/img/invoice-logo.png',



	'version' => '6.0.10',

];
