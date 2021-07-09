<?php
namespace Kaleidoscope\Factotum\Library;

use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Models\OrderProduct;
use Kaleidoscope\Factotum\Models\Invoice;


define('EURO', chr(128));

class InvoicePdf extends Fpdf\FPDF
{

	protected $companyName;
	protected $invoice;
	protected $order;
	protected $customer;
	protected $products;

	protected $primaryColor;
	protected $secondaryColor;
	protected $thirdColor;
	protected $_debug;


	public $headerCopy;
	public $footerCopy;
	public $footerGenerator;

	protected $_printingProductTable;
	protected $_productTableHeaders;
	protected $_productTableHeaderWidths;
	protected $_productTableRowHeight;


	public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
	{
		parent::__construct($orientation, $unit, $size);

		$this->_debug = false;

		$this->primaryColor   = '#000000';
		$this->secondaryColor = '#3B3B3B';
		$this->thirdColor     = '#934644';

		// TODO:
		$this->_printingProductTable  = false;
		$this->_productTableRowHeight = 8;

		$this->_productTableHeaders   = [
			Lang::get('factotum::ecommerce_invoice.product'),
			Lang::get('factotum::ecommerce_invoice.quantity'),
			Lang::get('factotum::ecommerce_invoice.single_price'),
			Lang::get('factotum::ecommerce_invoice.price'),
		];

		$this->_productTableHeaderWidths = [
			90,
			30,
			30,
			30
		];


		$this->SetLineWidth(.1);
		$this->SetFont('Helvetica');
		$this->SetAutoPageBreak( true, 30 );

		$this->_setHeaderAndFooterCopy();
	}


	public function SetTextColor( $color, $g = null, $b = null )
	{
		if ( substr($color, 0, 1) == '#' ) {
			$color = substr($color, 1);
		}

		$red   = hexdec( substr($color, 0, 2) );
		$green = hexdec( substr($color, 2, 2) );
		$blue  = hexdec( substr($color, 4, 2) );

		parent::SetTextColor( $red, $green, $blue );
	}


	public function SetDrawColor( $color, $g = null, $b = null )
	{
		if ( substr($color, 0, 1) == '#' ) {
			$color = substr($color, 1);
		}

		$red   = hexdec( substr($color, 0, 2) );
		$green = hexdec( substr($color, 2, 2) );
		$blue  = hexdec( substr($color, 4, 2) );

		parent::SetDrawColor( $red, $green, $blue );
	}

	public function SetFillColor( $color, $g = null, $b = null )
	{
		if ( substr($color, 0, 1) == '#' ) {
			$color = substr($color, 1);
		}

		$red   = hexdec( substr($color, 0, 2) );
		$green = hexdec( substr($color, 2, 2) );
		$blue  = hexdec( substr($color, 4, 2) );

		parent::SetFillColor( $red, $green, $blue );
	}


	public function Header()
	{
		$logo = config('factotum.invoice_logo');

		if ( file_exists( public_path($logo) ) ) {
			$this->Image(public_path($logo), 10, 12, 0, 10 );
		}

		$this->SetXY( 100, 5 );
		$this->SetTextColor( $this->primaryColor );
		$this->SetFont('Helvetica', 'B', 10);
		$this->Cell(100, 4, $this->companyName, $this->_debug, 0, 'R');

		$this->SetXY(100, 5);
		$this->SetTextColor( $this->secondaryColor );
		$this->SetFont('Helvetica', '', 8);
		$this->MultiCell(100,4, $this->headerCopy, $this->_debug,'R');

		if ( $this->_debug ) {
			$this->Line(0, 34, 210, 34 );
		}

		// Line break
		$this->Ln(34);
	}


	public function Footer()
	{
		if ( $this->_debug ) {
			$this->SetDrawColor( $this->thirdColor );
			$this->Line(0, 290, 210, 290 );
		}

		$this->SetXY( 5, 290 );
		$this->SetTextColor( $this->secondaryColor );
		$this->SetFont('Helvetica', 'B', 8);
		$this->Cell(200,7, $this->footerCopy, $this->_debug,0,'L');
	}


	public function AddPage($orientation = '', $size = '', $rotation = 0) {
		parent::AddPage($orientation, $size, $rotation);

		if ( $this->_printingProductTable ) {
			$this->_addProductsTableHeader();
		}
	}



	protected function _setHeaderAndFooterCopy()
	{
		$this->footerGenerator = 'Document generated with Factotum v' . config('factotum.version');

		if ( env('SHOP_OWNER_NAME') ) {
			$this->companyName = env('SHOP_OWNER_NAME');
		} else {
			$this->companyName = env('APP_NAME');
		}


		$this->headerCopy = '';
		$this->footerCopy = $this->companyName;

		if ( env('SHOP_OWNER_ADDRESS') ) {
			$this->headerCopy .= "\n" . env('SHOP_OWNER_ADDRESS');
			$this->footerCopy .= ' - ' . env('SHOP_OWNER_ADDRESS');
		}

		if ( env('SHOP_OWNER_EMAIL') ) {
			$this->headerCopy .= "\n" . env('SHOP_OWNER_EMAIL');
			$this->footerCopy .= ' - ' . env('SHOP_OWNER_EMAIL');
		}

		if ( env('SHOP_OWNER_VAT_NUMBER') ) {
			$this->headerCopy .= "\n" . Lang::get('factotum::ecommerce_invoice.vat_number') . ': ' . env('SHOP_OWNER_VAT_NUMBER');
		}

		if ( env('SHOP_OWNER_PEC') ) {
			$this->headerCopy .= "\n" . Lang::get('factotum::ecommerce_invoice.pec') . ': ' . env('SHOP_OWNER_PEC');
		}

		if ( env('SHOP_OWNER_SDI') ) {
			$this->headerCopy .= "\n" . Lang::get('factotum::ecommerce_invoice.sdi') . ': ' . env('SHOP_OWNER_SDI');
		}

		$this->footerCopy .= ' - ' . $this->footerGenerator;
	}


	protected function _addProductsTableHeader()
	{
		$this->SetXY( 15, 110);
		$this->SetFillColor( $this->thirdColor );
		$this->SetTextColor( '#FFFFFF' );
		$this->SetDrawColor( $this->primaryColor );
		$this->SetLineWidth( .1 );
		$this->SetFont('Helvetica','B', 8);

		for ( $i = 0; $i < count( $this->_productTableHeaders ); $i++ ) {
			$this->Cell( $this->_productTableHeaderWidths[$i],$this->_productTableRowHeight, $this->_productTableHeaders[$i],1,0,'L',true);
		}
	}


	protected function _addProductsTableRow( $orderProduct )
	{
		$this->SetFont('Helvetica', '', 8);

		if ( $orderProduct->product ) {
			$productName = $orderProduct->product->name;

			if ( $orderProduct->product_variant ) {
				$productName .= ' (' . $orderProduct->product_variant->label . ')';
			}

			// Product Name
			$this->Cell(
				$this->_productTableHeaderWidths[0], $this->_productTableRowHeight,
				$productName,
				'LR', 0, 'L'
			);

			// Product Quantity
			$this->Cell(
				$this->_productTableHeaderWidths[1], $this->_productTableRowHeight,
				$orderProduct->quantity,
				'LR', 0, 'L'
			);

			// Product Single Price
			$this->Cell(
				$this->_productTableHeaderWidths[2], $this->_productTableRowHeight,
				EURO . ' ' . number_format( $orderProduct->product_price, 2, ',', '.' ),
				'LR', 0, 'L'
			);

			// Partial Total
			$this->Cell(
				$this->_productTableHeaderWidths[3], $this->_productTableRowHeight,
				EURO . ' ' . number_format( $orderProduct->product_price * $orderProduct->quantity, 2, ',', '.' ),
				'LR', 0, 'L'
			);

			$this->Ln();
			$this->SetX(15);
			$this->Line( $this->GetX(), $this->GetY(), 195, $this->GetY() );
		}

	}


	protected function printCustomerData()
	{
		$customerFullname = $this->customer->profile->first_name . ' '
						. $this->customer->profile->last_name;

		$customerCopy = "\n" . $this->order->invoice_address;

		if ( $this->order->invoice_address_line_2 ) {
			$customerCopy .= "\n" . $this->order->invoice_address_line_2;
		}

		$customerCopy .= "\n" . $this->order->invoice_city;
		$customerCopy .= ' - ' . $this->order->invoice_zip;

		$customerCopy .= "\n" . $this->order->invoice_province;
		$customerCopy .= ' - ' . $this->order->invoice_country;

		$customerCopy .= "\n" . $this->order->customer->email;
		$customerCopy .= "\n" . $this->order->phone;


		$this->SetFont('Helvetica', 'B', 10);
		$this->SetXY( 15, 54 );
		$this->Cell(60, 6, $customerFullname, $this->_debug, 0, 'L');

		$this->SetFont('Helvetica', '', 10);
		$this->SetXY( 15, 54 );
		$this->MultiCell(60, 6, $customerCopy, $this->_debug, 'L');
	}


	protected function printInvoiceData()
	{
		$this->SetXY( 105, 54 );

		$this->SetFont('Helvetica', '', 10);
		$this->Cell(45, 6, Lang::get('factotum::ecommerce_invoice.invoice_number') . ': ', $this->_debug, 0, 'L');
		$this->SetFont('Helvetica', 'B', 10);
		$this->Cell(45, 6, '#' . $this->invoice->number, $this->_debug, 0, 'L');

		$this->SetXY( 105, 60 );

		$this->SetFont('Helvetica', '', 10);
		$this->Cell(45, 6, Lang::get('factotum::ecommerce_invoice.invoice_date') . ': ', $this->_debug, 0, 'L');
		$this->SetFont('Helvetica', 'B', 10);
		$this->Cell(45, 6, date('F d, Y', $this->invoice->created_at/1000), $this->_debug, 0, 'L');

		$this->SetXY( 105, 66 );

		$this->SetFont('Helvetica', '', 10);
		$this->Cell(45, 6, Lang::get('factotum::ecommerce_invoice.order_number') . ': ', $this->_debug, 0, 'L');
		$this->SetFont('Helvetica', 'B', 10);
		$this->Cell(45, 6, '#' . $this->invoice->order_id, $this->_debug, 0, 'L');

		$this->SetXY( 105, 72 );

		$this->SetFont('Helvetica', '', 10);
		$this->Cell(45, 6, Lang::get('factotum::ecommerce_invoice.order_date') . ': ', $this->_debug, 0, 'L');
		$this->SetFont('Helvetica', 'B', 10);
		$this->Cell(45, 6, date('F d, Y', $this->order->created_at/1000), $this->_debug, 0, 'L');

		$this->SetXY( 105, 78 );

		$this->SetFont('Helvetica', '', 10);
		$this->Cell(45, 6, Lang::get('factotum::ecommerce_invoice.payment_method') . ': ', $this->_debug, 0, 'L');
		$this->SetFont('Helvetica', 'B', 10);
		$this->Cell(45, 6, Lang::get('factotum::ecommerce_invoice.' . $this->order->payment_type), $this->_debug, 0, 'L');

	}


	protected function printProductsTable()
	{
		$this->_printingProductTable = true;

		$this->_addProductsTableHeader();

		$this->Ln();
		$this->SetTextColor($this->primaryColor);
		$this->SetX(15);

		foreach ( $this->products as $orderProduct ) {
			$this->_addProductsTableRow( $orderProduct );
		}

		$this->_printingProductTable = false;
	}


	protected function printInvoiceSummary()
	{
		if ( $this->GetY() + 40 > 250 ) {
			$this->AddPage();
		}

		$this->SetY( $this->GetY() + 10 );

		$this->SetXY( 105, $this->GetY() );
		$this->Line( $this->GetX(), $this->GetY() , 195, $this->GetY() );

		$this->SetFont('Helvetica', '', 10);
		$this->Cell(45, 6, Lang::get('factotum::ecommerce_invoice.subtotal'), 0, 0, 'L');
		$this->SetFont('Helvetica', 'B', 10);
		$this->Cell(45, 6, EURO . ' ' . number_format( $this->invoice->total_net + $this->invoice->total_tax, 2, ',', '.' ), 0, 0, 'L');

		$this->SetY( $this->GetY() + 6 );

		$this->SetXY( 105, $this->GetY() );
		$this->Line( $this->GetX(), $this->GetY() , 195, $this->GetY() );

		$this->SetFont('Helvetica', '', 10);
		$this->Cell(45, 6, Lang::get('factotum::ecommerce_invoice.shipping'), 0, 0, 'L');
		$this->SetFont('Helvetica', 'B', 10);
		$this->Cell(45, 6, EURO . ' ' . number_format( $this->invoice->total_shipping_net + $this->invoice->total_shipping_tax, 2, ',', '.' ), 0, 0, 'L');

		$this->SetY( $this->GetY() + 6 );

		$this->SetXY( 105, $this->GetY() );
		$this->Line( $this->GetX(), $this->GetY() , 195, $this->GetY() );

		$this->SetFont('Helvetica', '', 10);
		$this->Cell(45, 6, Lang::get('factotum::ecommerce_invoice.total'), 0, 0, 'L');
		$this->SetFont('Helvetica', 'B', 10);
		$this->Cell(45, 6, EURO . ' ' . number_format( $this->invoice->total, 2, ',', '.' ), 0, 0, 'L');
	}



	public function generateInvoice( Invoice $invoice )
	{
		$this->invoice  = $invoice;
		$this->order    = $invoice->order;
		$this->customer = $this->order->customer;
		$this->products = OrderProduct::where('order_id', $this->order->id)->get();

//		echo '<pre>';
//		print_r($this->customer->toArray());
		$this->AddPage();

		$this->printCustomerData();
		$this->printInvoiceData();
		$this->printProductsTable();
		$this->printInvoiceSummary();
	}
}
