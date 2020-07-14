<?php

namespace App\Http\Controllers\Api\CampaignAttachment;

use Illuminate\Http\Request;

use App\CampaignAttachment;

class DeleteController extends Controller
{

	public function remove(Request $request, $id)
	{

        return $this->_deleteModel(CampaignAttachment::class, $id );

	}

}
