<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Invoice;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\Invoice;


class ReadController extends ApiBaseController
{

    public function getListPaginated( Request $request )
    {
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$filters   = $request->input('filters', null);


		if ( !$sort || $sort == 'id' ) {
			$sort = 'invoices.id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = Invoice::with('order');

		$filtersActive = false;
		if ( isset($filters) && count($filters) > 0 ) {

			if ( isset($filters['from_date']) ) {
				$filtersActive = true;
				$query->where('invoices.created_at', '>=', $filters['from_date']);
			}

			if ( isset($filters['to_date']) ) {
				$filtersActive = true;
				$query->where('invoices.created_at', '<=', $filters['to_date']);
			}
		}


		$query->orderBy($sort, $direction);

		$total = $query->count();

        if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
        	$query->skip($offset);
		}

	    $invoices = $query->get();

        return response()->json( [ 'result' => 'ok', 'invoices' => $invoices, 'total' => $total ]);
    }


    public function getListGroupedByMonth( Request $request )
    {
    	$month = $request->input('month');
    	$year  = $request->input('year');

    	if ( $month < 10 ) {
    		$month = str_pad( $month, 2, '0', STR_PAD_LEFT );
	    }

    	$firstDayOfMonth = $year . '-' . $month . '-01';
	    $lastDayOfMonth  = date('Y-m-t', strtotime($firstDayOfMonth) );

	    $firstDay = 1;
	    $lastDay  = substr( $lastDayOfMonth, 8, 2);

	    $invoices = Invoice::where('created_at', '>=', $firstDayOfMonth)
	                    ->where('created_at', '<=', $lastDayOfMonth)
	                    ->get();

	    $invoicesGrouped = [];
	    $totals = [
		    'total_net' => 0,
		    'total_tax' => 0,
		    'total'     => 0
	    ];

	    for (; $firstDay <= $lastDay; $firstDay++ ) {

	    	if ( $firstDay < 10 ) {
			    $firstDay = str_pad($firstDay, 2, '0', STR_PAD_LEFT );
		    }

		    $invoicesGrouped[ $year . '-' . $month . '-' . $firstDay ] = [
		    	'date'      => strtotime( $year . '-' . $month . '-' . $firstDay ) * 1000,
			    'total_net' => 0,
			    'total_tax' => 0,
			    'total'     => 0
		    ];
	    }

	    if ( $invoices->count() > 0 ) {
		    foreach ( $invoices as $invoice ) {
		    	$day        = date('Y-m-d', $invoice->created_at/1000 );
		    	$invoiceDay = $invoicesGrouped[ $day ];

			    $invoiceDay['total_net'] += ( $invoice->total_net + $invoice->total_shipping_net );
			    $invoiceDay['total_tax'] += ( $invoice->total_tax + $invoice->total_shipping_tax );
			    $invoiceDay['total']     += $invoice->total;

			    $invoiceDay['total_net'] = $invoiceDay['total_net'];
			    $invoiceDay['total_tax'] = $invoiceDay['total_tax'];
			    $invoiceDay['total']     = $invoiceDay['total'];

			    $invoicesGrouped[ $day ] = $invoiceDay;
		    }
	    }

	    foreach ( $invoicesGrouped as $day ) {
		    $totals['total_net'] += $day['total_net'];
		    $totals['total_tax'] += $day['total_tax'];
		    $totals['total']     += $day['total'];
	    }

	    $totals['total_net'] = (float) $totals['total_net'];
	    $totals['total_tax'] = (float) $totals['total_tax'];
	    $totals['total']     = (float) $totals['total'];

	    return response()->json( [ 'result' => 'ok', 'invoices' => $invoicesGrouped, 'totals' => $totals ]);
    }

    public function getList( Request $request )
	{
		$invoices = Invoice::orderBy('id', 'DESC')->get();

		return response()->json( [ 'result' => 'ok', 'invoices' => $invoices ]);
	}


    public function getDetail(Request $request, $id)
    {
		$invoice = Invoice::with('order')->find($id);

        if ( $invoice ) {
            return response()->json( [ 'result' => 'ok', 'invoice' => $invoice ]);
        }

        return $this->_sendJsonError( 'Invoice not found', 404 );
    }

}
