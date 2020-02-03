<?php

use Illuminate\Database\Seeder;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\Capability;
use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Content;

class PageTableSeeder extends Seeder
{

    public function run()
    {
		$adminRole = Role::where('role', 'admin')->first();
		$user = User::whereEmail( 'factotum@kaleidoscope.it' )->first();

    	// Create content type page
		$pageContentType = new ContentType;
		$pageContentType->content_type = 'page';
		$pageContentType->editable     = false;
		$pageContentType->icon         = 'content';
		$pageContentType->save();

		$capability = new Capability;
		$capability->content_type_id = $pageContentType->id;
		$capability->role_id         = $adminRole->id;
		$capability->configure = 1;
		$capability->edit      = 1;
		$capability->publish   = 1;
		$capability->save();


		// Page Templates
		$contentField = new ContentField;
		$contentField->content_type_id = $pageContentType->id;
		$contentField->name    = 'page_template';
		$contentField->label   = 'Page Template';
		$contentField->type    = 'select';
		$templates = [
			[ 'value' => 'basic',        'label' => 'Basic Page Template' ],
			[ 'value' => 'content_list',  'label' => 'Content List Page Template' ],
			[ 'value' => 'ajax',          'label' => 'Ajax Page Template' ],
			[ 'value' => 'contact_us',    'label' => 'Contact Us Page Template' ],
			[ 'value' => 'thankyou_page', 'label' => 'Thank You Page Template' ],
		];

		$contentField->options = json_encode( $templates );
		$contentField->save();


		// Page Operation
		$contentField = new ContentField;
		$contentField->content_type_id = $pageContentType->id;
		$contentField->name  = 'page_operation';
		$contentField->label = 'Page Operation';
		$contentField->type  = 'select';

		$operations = [
			[ 'value' => 'show_content',    'label' => 'Show Page Content' ],
			[ 'value' => 'single_content',  'label' => 'Show Related Content' ],
			[ 'value' => 'content_list',    'label' => 'Show Content List' ],
			[ 'value' => 'link',            'label' => 'Link' ],
			[ 'value' => 'action',          'label' => 'Action' ],
		];

		$contentField->options = json_encode( $operations );
		$contentField->save();


		// Content Type To List
		$contentField = new ContentField;
		$contentField->content_type_id = $pageContentType->id;
		$contentField->name  = 'content_type_to_list';
		$contentField->label = 'Content Type To List';
		$contentField->type  = 'select';
		$contentField->save();


		// Single Content to show
		$contentField = new ContentField;
		$contentField->content_type_id = $pageContentType->id;
		$contentField->name  = 'content_to_show';
		$contentField->label = 'Content To Show';
		$contentField->type  = 'select';
		$contentField->save();


		// Content List Pagination
		$contentField = new ContentField;
		$contentField->content_type_id = $pageContentType->id;
		$contentField->name  = 'content_list_pagination';
		$contentField->label = 'Content List Pagination';
		$contentField->type  = 'text';
		$contentField->save();


		// Content List Order
		$contentField = new ContentField;
		$contentField->content_type_id = $pageContentType->id;
		$contentField->name  = 'content_list_order';
		$contentField->label = 'Content List Order';
		$contentField->type  = 'select';

		$operations = [
			[ 'value' => 'contents.id-asc',            'label' => 'BY ID ASC' ],
			[ 'value' => 'contents.id-desc',           'label' => 'BY ID DESC' ],
			[ 'value' => 'contents.created_at-asc',    'label' => 'BY DATA CREATION ASC' ],
			[ 'value' => 'contents.created_at-desc',   'label' => 'BY DATA CREATION DESC' ],
			[ 'value' => 'contents.order_no-asc',      'label' => 'BY ORDER No. ASC' ],
			[ 'value' => 'contents.order_no-desc',     'label' => 'BY ORDER No. DESC' ],
			[ 'value' => 'contents.title-asc',         'label' => 'BY TITLE ASC' ],
			[ 'value' => 'contents.title-desc',        'label' => 'BY TITLE DESC' ],
		];

		$contentField->options = json_encode( $operations );
		$contentField->save();


		// Action
		$contentField = new ContentField;
		$contentField->content_type_id = $pageContentType->id;
		$contentField->name  = 'action';
		$contentField->label = 'Action';
		$contentField->type  = 'text';
		$contentField->save();


		// Insert homepage
		$content = new Content;
		$content->content_type_id = $pageContentType->id;
		$content->user_id         = $user->id;
		$content->status          = 'publish';
		$content->parent_id       = null;
		$content->title           = 'Homepage';
		$content->url             = '';
		$content->content         = '';
		$content->abs_url         = url('') . '/';
		$content->show_in_menu    = true;
		$content->lang            = 'en-GB';
		$content->is_home         = true;
		$content->save();

		$additionalValues = [
			'content_id'       => $content->id,
			'content_type_id'  => $pageContentType->id,
			'page_template'    => 'home',
			'page_operation'   => 'show_content'
		];
		DB::table( $pageContentType->content_type )->insert( $additionalValues );

		// Create content type news
		$contentType               = new ContentType;
		$contentType->content_type = 'news';
		$contentType->editable     = true;
		$contentType->icon         = 'news';
		$contentType->save();

		// Assign news capability to admin
		$capability = new Capability;
		$capability->content_type_id = $contentType->id;
		$capability->role_id         = $adminRole->id;
		$capability->configure = 1;
		$capability->edit      = 1;
		$capability->publish   = 1;
		$capability->save();

		// Add News Subtitle Field
		$contentField = new ContentField;
		$contentField->content_type_id = $contentType->id;
		$contentField->name  = 'news_subtitle';
		$contentField->label = 'News Subtitle';
		$contentField->type  = 'text';
		$contentField->save();

		// Insert news #1
		$content = new Content;
		$content->content_type_id = $contentType->id;
		$content->user_id         = $user->id;
		$content->status          = 'publish';
		$content->parent_id       = null;
		$content->title           = 'Hello World!';
		$content->url             = 'hello-world';
		$content->content         = 'Hello-ipsum';
		$content->abs_url         = url('') . '/hello-world';
		$content->show_in_menu    = false;
		$content->lang            = 'en-GB';
		$content->save();

		// Insert news #2
		$content = new Content;
		$content->content_type_id = $contentType->id;
		$content->user_id         = $user->id;
		$content->status          = 'publish';
		$content->parent_id       = null;
		$content->title           = 'Hello Galaxy!';
		$content->url             = 'hello-galaxy';
		$content->content         = 'Hello-Galaxy-ipsum';
		$content->abs_url         = url('') . '/hello-galaxy';
		$content->show_in_menu    = false;
		$content->lang            = 'en-GB';
		$content->save();

		// Insert news page
		$content = new Content;
		$content->content_type_id = $pageContentType->id;
		$content->user_id         = $user->id;
		$content->status          = 'publish';
		$content->parent_id       = null;
		$content->title           = 'News';
		$content->url             = 'news';
		$content->content         = 'News page';
		$content->abs_url         = url('') . '/news';
		$content->show_in_menu    = true;
		$content->lang            = 'en-GB';
		$content->save();

		$additionalValues = [
			'content_id'              => $content->id,
			'content_type_id'         => $pageContentType->id,
			'page_template'           => 'content_list',
			'page_operation'          => 'content_list',
			'content_type_to_list'    => $contentType->id,
			'content_list_pagination' => 10,
			'content_list_order'      => 'created_at-desc'
		];
		DB::table( $pageContentType->content_type )->insert( $additionalValues );
    }

}
