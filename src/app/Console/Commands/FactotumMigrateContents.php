<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\Media;


class FactotumMigrateContents extends Command
{

	protected $signature = 'factotum:migrate-contents {contentType}';


	protected $description = 'Migrate content type and fields from Factotum 1 to Factotum 4';


	public function handle()
	{
		$contentTypeName = $this->argument('contentType');

		$contentType = ContentType::where( 'content_type', $contentTypeName )->first();

		$this->info('Starting migration of Contents');

		if ( $contentType ) {

			$contentFields = ContentField::where( 'content_type_id', $contentType->id )->get();
			$fieldsToParse = [];
			$fieldsToCheck = [
				'image_upload',
				'file_upload',
				'gallery',
				'linked_content',
				'multiple_linked_content'
			];

			if ( $contentFields->count() > 0 ) {
				foreach ( $contentFields as $cf ) {
					if ( in_array( $cf['type'], $fieldsToCheck ) ) {
						$fieldsToParse[ $cf->type ] = $cf->name;
					}
				}
			}

			$contents = DB::connection('old_fm')
								->table('contents')
								->join( $contentType->content_type, 'contents.id', '=', $contentType->content_type . '.content_id')
								->orderBy('contents.id', 'DESC')
								->get();

			if ( $contents->count() > 0 ) {

				foreach ( $contents as $c ) {

					unset($c->id);
					unset($c->content_type_id);
					unset($c->content_id);

					$c->content_type_id = $contentType->id;

					$oldUser    = DB::connection('old_fm')->table( 'users' )->where( 'id', $c->user_id )->first();
					$user       = User::where( 'email', $oldUser->email )->first();
					$c->user_id = $user->id;

					if ( count($fieldsToParse) > 0 ) {

						foreach ( $fieldsToParse as $type => $f ) {

							if ( isset($c->{$f}) ) {

								switch ( $type ) {

									case 'image_upload':
									case 'file_upload':
										$oldMedia = DB::connection('old_fm')->table('media')->find( $c->{$f} );
										if ( $oldMedia ) {
											$media    = Media::where('filename', $oldMedia->filename )->first();
											if ( $media ) {
												$c->{$f} = $media->id;
											}
										} else {
											$c->{$f} = null;
										}
									break;

									case 'gallery':
										$oldMedia = explode( ';', $c->{$f} );
										$oldMedia = DB::connection('old_fm')->table('media')->whereIn( 'id', $oldMedia )->get();

										if ( $oldMedia->count() > 0 ) {
											$tmp = [];
											foreach ( $oldMedia as $om ) {
												$media = Media::where('filename', $om->filename)->first();
												if ( $media ) {
													$tmp[] = $media->id;
												}
											}
											if ( count($tmp) > 0 ) {
												$c->{$f} = join( ',', $tmp );
											}
										} else {
											$c->{$f} = null;
										}
									break;

									case 'linked_content':
										$oldContent = DB::connection('old_fm')->table('contents')->find( $c->{$f} );
										$content    = Content::where('abs_url', $oldContent->abs_url)->first();
										if ( $content ) {
											$c->{$f} = $content->id;
										}
									break;

									case 'multiple_linked_content':
										$oldContents = explode( ';', $c->{$f} );
										$oldContents = DB::connection('old_fm')->table('contents')->whereIn( 'id', $oldContents )->get();

										if ( $oldContents->count() > 0 ) {
											$tmp = [];
											foreach ( $oldContents as $oc ) {
												$content = Content::where('abs_url', $oc->abs_url)->first();
												if ( $content ) {
													$tmp[]   = $content->id;
												}
											}
											if ( count($tmp) > 0 ) {
												$c->{$f} = join( ',', $tmp );
											}
										}
									break;

								}

							}

						}

					}


					$c = (array) $c;

					request()->merge( $c );

					$newContent = new Content;
					$newContent->fill( $c );
					$newContent->save();

					$this->info('Content migrated');

				}

			}

		} else {
			$this->error('Content does not exist');
		}

	}

}