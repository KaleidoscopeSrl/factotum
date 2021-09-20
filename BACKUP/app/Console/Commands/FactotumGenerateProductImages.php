<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;

use Kaleidoscope\Factotum\Models\Product;
use Kaleidoscope\Factotum\Models\ProductProductCategory;


class FactotumGenerateProductImages extends Command
{

    protected $signature = 'factotum:generate-product-images';

    protected $description = 'This command will re-generate all the products images';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
	    $timeStart = microtime(true);
	    $products = Product::all();

	    if ( $products->count() > 0 ) {
		    foreach ( $products as $product ) {

		    	$data = $product->toArray();

		    	if ( isset($data['image']) && is_array($data['image']) ) {
				    $data['image'] = [ $data['image'] ];
			    }

		    	$product->generateMainImage( $data );

			    $product->generateGalleryImages( $data );

			    sleep(.5);

			    $diff = microtime(true) - $timeStart;
			    $sec = intval($diff);
			    $micro = $diff - $sec;
			    $this->info('Product #' . $product->id . ' image generated. Time: ' . round($micro * 1000, 4) . ' ms');
		    }
	    }

        return 0;
    }
}
