<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreOutgoingOrderRequest;
use App\Http\Resources\V1\OutgoingOrderStatusDropDownResource;
use App\Models\OutgoingOrder;
use Illuminate\Http\Request;

class OutgoingOrderController extends Controller
{
    /*public function store(StoreOutgoingOrderRequest $request){
        $data = $request->validated();
        $data['orderID']=  Helper::generateID(OutgoingOrder::class, 'orderID', 'OX', 5);
        $data['status'] = 'Requested';
        OutgoingOrder::create($data);

        return redirect()->route('orders');

    }

    public function create(){
        $orderID = Helper::generateID(OutgoingOrder::class, 'orderID', 'OX', 5);
        return view('partials.create-order-modal', compact('orderID'));
    }*/

    public function dropdown(){
         return OutgoingOrderStatusDropDownResource::collection(OutgoingOrder::select('id', 'status')->get());
    }
}
