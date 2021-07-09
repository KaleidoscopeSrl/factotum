<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Invoice;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Library\InvoicePdf;
use Kaleidoscope\Factotum\Models\Invoice;


class PdfController extends ApiBaseController
{

    public function generateByMonth( Request $request )
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

	    if ( $invoices->count() > 0 ) {
		    $pdf      = new InvoicePdf();
		    $filename = 'export-invoices-' . date('Y-m-d_His') . '.pdf';

		    foreach ( $invoices as $invoice ) {
				$pdf->generateInvoice( $invoice );
			}

			$pdf->Output('F', storage_path('app/public/invoices/') . $filename);

		    return response()->json( [ 'result' => 'ok', 'pdf_url' => Storage::disk('invoices')->url($filename) ]);
	    }

	    return $this->_sendJsonError( 'Invoices not found', 404 );
    }


    public function viewInvoiceByOrderId( Request $request, $orderId )
    {
	    $invoice = Invoice::where('order_id', $orderId)->first();

	    if ( $invoice ) {
		    $pdf = new InvoicePdf();
		    $pdf->generateInvoice( $invoice );
		    $filename = 'invoice-' . $invoice->id . '.pdf';

		    $pdf->Output('I', $filename);
	    }

	    return $this->_sendJsonError( 'Invoice not found', 404 );
    }

}
