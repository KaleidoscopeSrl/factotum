<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\DiscountCode;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;


class Controller extends ApiBaseController
{

//	protected function _save( $request, $discountCode )
//	{
//		$discountCode->event_id     = $request->input('event_id');
//		$discountCode->code         = $request->input('code');
//		$discountCode->discount     = $request->input('discount');
//		$discountCode->amount       = $request->input('amount');
//		$discountCode->type         = $request->input('type');
//		$discountCode->save();
//
//		$tickets = $request->input('tickets');
//
//		if ( isset($tickets) && count($tickets) > 0 ) {
//
//			// Remove all the previous discount codes attached to tickets
//			TicketDiscountCode::where( 'discount_code_id', $discountCode->id )->delete();
//
//			// Save all the new tax tickets
//			foreach ( $tickets as $ticketId ) {
//				$ticketDiscountCode                   = new TicketDiscountCode;
//				$ticketDiscountCode->ticket_id        = $ticketId;
//				$ticketDiscountCode->discount_code_id = $discountCode->id;
//				$ticketDiscountCode->save();
//			}
//
//		}
//
//		return $discountCode;
//	}

}
