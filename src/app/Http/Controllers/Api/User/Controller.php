<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;
use Kaleidoscope\Factotum\Http\Requests\StoreUser;
use Kaleidoscope\Factotum\Profile;


class Controller extends ApiBaseController
{

	// TODO: check per rimozione
	private function _removeMedia( $filename )
	{
		$filename = parse_url($filename, PHP_URL_PATH);

		if ( file_exists( public_path( $filename ) ) ) {
			$filename = str_replace('/storage/users/', '', $filename);
			Storage::disk('users')->delete( $filename );
		}
	}


}
