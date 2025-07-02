<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ImporterDropDownResource;
use App\Models\IncomingOrder;
use Illuminate\Http\Request;

class IncomingOrderController extends Controller
{
    public function dropdown(){
    return ImporterDropDownResource::collection(IncomingOrder::select('id', 'destination', 'grade')->get());
}
}
