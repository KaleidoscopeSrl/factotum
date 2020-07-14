<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Campaign;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Campaign;


class DeleteController extends Controller
{

	public function remove(Request $request, $id)
	{
		$campaign = Campaign::find( $id );

		if ( $campaign ) {
			$deletedRows = $campaign->delete();

			if ( $deletedRows > 0 ) {
				return response()->json( [ 'result' => 'ok' ]);
			}

			return $this->_sendJsonError( 'Errore in fase di cancellazione.' );
		}

		return $this->_sendJsonError( 'Campagna non trovata', 404 );
	}


	public function removeCampaigns(Request $request)
	{
		$campaigns = $request->input('campaigns');

		if ( $campaigns && count($campaigns) > 0 ) {
			Campaign::whereIn( 'id', $campaigns )->delete();
		}

		return response()->json( [ 'result' => 'ok' ] );
	}

}
