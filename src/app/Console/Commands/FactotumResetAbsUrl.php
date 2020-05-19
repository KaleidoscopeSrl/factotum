<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\Media;


class FactotumResetAbsUrl extends Command
{

	protected $signature = 'factotum:reset-abs-url {contentType}';


	protected $description = 'Reset the abs url in the contents table';


	public function handle()
	{
		$contentTypeName = $this->argument('contentType');

		$contentType = ContentType::where( 'content_type', $contentTypeName )->first();

		$this->info('Starting reset abs url of Contents');

		if ( $contentType ) {

			$contents = Content::where( 'content_type_id', $contentType->id )->get();

			if ( $contents->count() > 0 ) {

				foreach ( $contents as $c ) {

					$c->abs_url = url('') . '/'
						. ( $c->lang != config('factotum.main_site_language') ? $c->lang . '/' : '' )
						. ( $c->url != '/' ? $c->url : '' );
					$c->save();

					$this->info('Asb Url resetted');

				}

			}

		} else {
			$this->error('Content does not exist');
		}

	}

}