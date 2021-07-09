<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\NewsletterSubscription;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller;

use Kaleidoscope\Factotum\NewsletterSubscription;


class ReadController extends Controller
{

	public function getListPaginated( Request $request )
	{
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$filters   = $request->input('filters', null);


		if ( !$sort ) {
			$sort = 'id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = NewsletterSubscription::query();

		if ( isset($filters) && count($filters) > 0 ) {
			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$query->whereRaw( 'LCASE(email) like "%' . $filters['term'] . '%"' );
			}
		}

		$query->orderBy($sort, $direction);

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		$newsletterSubscriptions = $query->get();

		return response()->json( [ 'result' => 'ok', 'newsletter_subscriptions' => $newsletterSubscriptions, 'total' => NewsletterSubscription::count() ]);
	}


	public function getDetail(Request $request, $id)
	{
		$newsletterSubscription = NewsletterSubscription::find( $id );

		if ( $newsletterSubscription ) {
			return response()->json( [ 'result' => 'ok', 'newsletter_subscription'  => $newsletterSubscription ] );
		}

		return $this->_sendJsonError( 'Iscrizione Newsletter non trovata.' );
	}

}
