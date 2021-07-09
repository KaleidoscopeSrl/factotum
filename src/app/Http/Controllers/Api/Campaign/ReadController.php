<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Campaign;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\Campaign;
use Kaleidoscope\Factotum\Models\CampaignEmail;


class ReadController extends ApiBaseController
{

	public function getList( Request $request )
	{
		$campaigns = Campaign::with('campaign_template')
								->withCount('campaign_emails')
								->get();

		return response()->json( [ 'result' => 'ok', 'campaigns' => $campaigns ]);
	}


	public function getListPaginated( Request $request )
	{
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');

		if ( !$sort ) {
			$sort = 'id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = Campaign::query();
		$query->with('campaign_template');
		$query->orderBy($sort, $direction);

		$total = $query->count();

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		$campaigns = $query->get();

		if ( $campaigns->count() ) {
			foreach ( $campaigns as $campaign ) {
				$campaign->recipients = CampaignEmail::where( 'campaign_id', $campaign->id )->count();
			}
		}

		return response()->json( [ 'result' => 'ok', 'campaigns' => $campaigns, 'total' => $total ]);
	}


	public function getDetail(Request $request, $id)
	{
		$campaign = Campaign::find($id);

		if ( $campaign ) {
			return response()->json( [ 'result' => 'ok', 'campaign'  => $campaign ] );
		}

		return $this->_sendJsonError( 'Campagna non trovata.' );
	}

}
