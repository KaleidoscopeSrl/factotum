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
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$adminRole = Role::where('role', 'admin')->first();
		$user = User::whereEmail( 'factotum@kaleidoscope.it' )->first();

    	// Create content type page
		$pageContentType = new ContentType;
		$pageContentType->content_type = 'page';
		$pageContentType->editable = false;
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
		$contentField->name  = 'page_template';
		$contentField->label = 'Page Template';
		$contentField->type  = 'select';
		$templates = array(
			'basic'         => 'Basic Page Template',
			'content_list'  => 'Content List Page Template',
			'ajax'          => 'Ajax Page Template',
			'contact_us'    => 'Contact Us Page Template',
			'thankyou_page' => 'Thank You Page Template'
		);
		$tmp = array();
		foreach ($templates as $value => $label) {
			$tmp[] = $value . ':' . $label;
		}
		$contentField->options = join(';', $tmp);
		$contentField->save();


		// Page Operation
		$contentField = new ContentField;
		$contentField->content_type_id = $pageContentType->id;
		$contentField->name  = 'page_operation';
		$contentField->label = 'Page Operation';
		$contentField->type  = 'select';

		$operations = array(
			'show_content'   => 'Show Page Content',
			'single_content' => 'Show Related Content',
			'content_list'   => 'Show Content List',
			'link'           => 'Link',
			'action'         => 'Action',
		);
		$tmp = array();
		foreach ($operations as $value => $label) {
			$tmp[] = $value . ':' . $label;
		}
		$contentField->options = join(';', $tmp);
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

		$operations = array(
			'contents.id-asc'              => 'BY ID ASC',
			'contents.id-desc'             => 'BY ID DESC',
			'contents.created_at-asc'      => 'BY DATA CREATION ASC',
			'contents.created_at-desc'     => 'BY DATA CREATION DESC',
			'contents.order_no-asc'        => 'BY ORDER No. ASC',
			'contents.order_no-desc'       => 'BY ORDER No. DESC',
			'contents.title-asc'           => 'BY TITLE ASC',
			'contents.title-desc'          => 'BY TITLE DESC',
		);
		$tmp = array();
		foreach ($operations as $value => $label) {
			$tmp[] = $value . ':' . $label;
		}
		$contentField->options = join(';', $tmp);
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

		$additionalValues = array(
			'content_id'       => $content->id,
			'content_type_id'  => $pageContentType->id,
			'page_template'    => 'home',
			'page_operation'   => 'show_content'
		);
		DB::table( $pageContentType->content_type )->insert( $additionalValues );

		// Create content type news
		$contentType = new ContentType;
		$contentType->content_type = 'news';
		$contentType->editable = false;
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

		$additionalValues = array(
			'content_id'              => $content->id,
			'content_type_id'         => $pageContentType->id,
			'page_template'           => 'content_list',
			'page_operation'          => 'content_list',
			'content_type_to_list'    => $contentType->id,
			'content_list_pagination' => 10,
			'content_list_order'      => 'created_at-desc'
		);
		DB::table( $pageContentType->content_type )->insert( $additionalValues );
    }
}
