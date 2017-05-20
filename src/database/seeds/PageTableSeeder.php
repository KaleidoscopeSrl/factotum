<?php

use Illuminate\Database\Seeder;

use Factotum\ContentType;
use Factotum\ContentField;
use Factotum\Capability;
use Factotum\Role;
use Factotum\User;
use Factotum\Content;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$contentType = new ContentType;
		$contentType->content_type = 'page';
		$contentType->editable = false;
		$contentType->save();


		$adminRole = Role::where('role', 'admin')->first();
		$capability = new Capability;
		$capability->content_type_id = $contentType->id;
		$capability->role_id = $adminRole->id;
		$capability->configure = 1;
		$capability->edit      = 1;
		$capability->publish   = 1;
		$capability->save();


		// Page Templates
		$contentField = new ContentField;
		$contentField->content_type_id = $contentType->id;
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
		$contentField->content_type_id = $contentType->id;
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
		$contentField->content_type_id = $contentType->id;
		$contentField->name  = 'content_type_to_list';
		$contentField->label = 'Content Type To List';
		$contentField->type  = 'select';
		$contentField->save();


		// Single Content to show
		$contentField = new ContentField;
		$contentField->content_type_id = $contentType->id;
		$contentField->name  = 'content_to_show';
		$contentField->label = 'Content To Show';
		$contentField->type  = 'select';
		$contentField->save();


		// Content List Pagination
		$contentField = new ContentField;
		$contentField->content_type_id = $contentType->id;
		$contentField->name  = 'content_list_pagination';
		$contentField->label = 'Content List Pagination';
		$contentField->type  = 'text';
		$contentField->save();


		// Content List Order
		$contentField = new ContentField;
		$contentField->content_type_id = $contentType->id;
		$contentField->name  = 'content_list_order';
		$contentField->label = 'Content List Order';
		$contentField->type  = 'select';

		$operations = array(
			'id-asc'              => 'BY ID ASC',
			'id-desc'             => 'BY ID DESC',
			'data_created-asc'    => 'BY DATA CREATION ASC',
			'data_created-desc'   => 'BY DATA CREATION DESC',
			'order_no-asc'        => 'BY ORDER No. ASC',
			'order_no-desc'       => 'BY ORDER No. DESC',
			'title-asc'           => 'BY TITLE ASC',
			'title-desc'          => 'BY TITLE DESC',
		);
		$tmp = array();
		foreach ($operations as $value => $label) {
			$tmp[] = $value . ':' . $label;
		}
		$contentField->options = join(';', $tmp);
		$contentField->save();


		// Action
		$contentField = new ContentField;
		$contentField->content_type_id = $contentType->id;
		$contentField->name  = 'action';
		$contentField->label = 'Action';
		$contentField->type  = 'text';
		$contentField->save();






		// Insert homepage
		$user = User::whereEmail( 'factotum@kaleidoscope.it' )->first();
		$content = new Content;
		$content->content_type_id = $contentType->id;
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
			'content_type_id'  => $contentType->id,
			'page_template'    => 'home',
			'page_operation'   => 'show_content'
		);
		DB::table( $contentType->content_type )->insert( $additionalValues );

    }
}
