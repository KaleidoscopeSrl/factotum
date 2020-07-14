<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CampaignTemplate;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\CampaignTemplate;


class ReadController extends Controller
{

	public function getList(Request $request)
	{
		$campaignTemplates = CampaignTemplate::orderBy('id','DESC')->get();

		return response()->json( [ 'result' => 'ok', 'campaign_templates' => $campaignTemplates ]);
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

		$query = CampaignTemplate::query();
		$query->orderBy($sort, $direction);

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		$campaignTemplates = $query->get();

		return response()->json( [ 'result' => 'ok', 'campaign_templates' => $campaignTemplates ]);
	}


	public function getDetail(Request $request, $id)
	{
		$campaignTemplate = CampaignTemplate::find($id);

		if ( $campaignTemplate ) {
			return response()->json( [ 'result' => 'ok', 'campaign_template'  => $campaignTemplate ] );
		}

		return $this->_sendJsonError( 'Template Campagna non trovato.', 404 );
	}

}
