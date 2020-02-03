<?php

return [

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


	'main_site_language' => 'en-GB',

	'site_languages' => [
		'en-GB' => 'English',
		'it-IT' => 'Italiano'
	],

	'analytics_client_id' => '',
	'analytics_site_id'   => '',

	'css_version' => '1.0.0',
	'js_version'  => '1.0.0',
];
