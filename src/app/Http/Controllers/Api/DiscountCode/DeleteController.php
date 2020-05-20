<?php

namespace App\Http\Controllers\Api\DiscountCode;

use Illuminate\Http\Request;

use App\DiscountCode;

class DeleteController extends Controller
{

	public function remove(Request $request, $id)
	{
// TODO: controllare se ci sono biglietti legati a questa tassa
// Se ci sono, verificare se i biglietti siano stati venduti; se venduti, non eliminare la tassa
return $this->_deleteModel(DiscountCode::class, $id );
    }


}
