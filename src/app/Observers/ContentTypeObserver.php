<?php

namespace Kaleidoscope\Factotum\Observers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Storage;

use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Capability;

class ContentTypeObserver
{
	/**
	 * Listen to the ContentType created event.
	 *
	 * @param  ContentType  $contentType
	 * @return void
	 */
	public function created(ContentType $contentType)
	{
		Schema::create( $contentType->content_type, function (Blueprint $table) {
			$table->increments('id');
			$table->integer('content_type_id')->unsigned();
			$table->foreign('content_type_id')->references('id')->on('content_types')->onDelete('cascade');
			$table->integer('content_id')->unsigned();
			$table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
		});

		$filename = 'models/' . $contentType->content_type . '.json';
		if ( !Storage::disk('local')->exists( $filename ) ) {
			Storage::disk('local')->put( $filename, '' );
		}

		$user = Auth::user();

		$capability = new Capability();
		$capability->role_id         = $user->role->id;
		$capability->content_type_id = $contentType->id;
		$capability->configure       = 1;
		$capability->edit            = 1;
		$capability->publish         = 1;
		$capability->save();
	}




	/**
	 * Listen to the ContentType updated event.
	 *
	 * @param  ContentType  $contentType
	 * @return void
	 */
	public function updated(ContentType $contentType)
	{
		Schema::rename( $contentType->old_content_type, $contentType->content_type);
		$oldFilename = 'models/' . $contentType->old_content_type . '.json';
		$newFilename = 'models/' . $contentType->content_type . '.json';

		if ( !Storage::disk('local')->exists( $oldFilename ) ) {
			Storage::disk('local')->put( $newFilename, '' );
		} else if ( Storage::disk('local')->exists( $oldFilename ) ) {
			Storage::move( $oldFilename, $newFilename );
		}
	}




	/**
	 * Listen to the ContentType deleting event.
	 *
	 * @param  ContentType  $contentType
	 * @return void
	 */
	public function deleting(ContentType $contentType)
	{
		Schema::drop( $contentType->content_type );

		$filename = 'models/' . $contentType->content_type . '.json';
		if ( Storage::disk('local')->exists( $filename ) ) {
			Storage::disk('local')->delete( $filename );
		}
	}
}