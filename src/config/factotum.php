<?php

return [

	'prohibited_content_types' => array(
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
	),

	'prohibited_content_field_names' => array(
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
	),

	'thumb_size' => array(
		'width'  => 200,
		'height' => 200
	),

	'main_site_language' => 'en-GB',
	'site_languages' => array(
		'en-GB' => 'English',
		'it-IT' => 'Italiano'
	),

	'analytics_client_id' => '',
	'analytics_site_id'   => '',
];
