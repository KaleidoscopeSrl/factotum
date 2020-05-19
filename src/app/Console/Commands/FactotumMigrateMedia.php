<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Media;
use Kaleidoscope\Factotum\User;


class FactotumMigrateMedia extends Command
{

	protected $signature = 'factotum:migrate-media';


	protected $description = 'Migrate media from Factotum 1 to Factotum 4';


	public function handle()
	{
		$media = DB::connection('old_fm')->table( 'media' )->get();

		$this->info('Starting migration of Media');

		if ( $media->count() > 0 ) {

			foreach ( $media as $m ) {

				$mediaExist = Media::where( 'filename', $m->filename )->count();

				if ( $mediaExist == 0 ) {

					$oldUser = DB::connection('old_fm')->table( 'users' )->where( 'id', $m->user_id )->first();
					$user    = User::where( 'email', $oldUser->email )->first();

					if ( !$user ) {
						$this->error('User ' . $oldUser->email . ' not exist');
						die;
					}

					$newMedia              = new Media;
					$newMedia->id          = $m->id;
					$newMedia->filename    = $m->filename;
					$newMedia->thumb       = $m->url;
					$newMedia->url         = $m->url;
					$newMedia->user_id     = $user->id;
					$newMedia->mime_type   = $m->mime_type;
					$newMedia->caption     = $m->caption;
					$newMedia->alt_text    = $m->alt_text;
					$newMedia->description = $m->description;
					$newMedia->width       = 2000;
					$newMedia->height      = 2000;
					$newMedia->size        = 100;
					$newMedia->save();

					$this->info('Content Type ' . $newMedia->filename . ' created');
				}


			}


			$this->info('Media migrated');

		}

	}

}