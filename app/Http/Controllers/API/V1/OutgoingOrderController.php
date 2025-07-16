<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreOutgoingOrderRequest;
use App\Http\Resources\V1\OutgoingOrderStatusDropDownResource;
use App\Models\OutgoingOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;

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
    public function store(Request $request, OutgoingOrder $order){
        $validated= $request->validate([
            'declineReason' => 'required|string',
        ]);

        $order->declineReason = $validated['declineReason'];
        $order->save();

        return redirect()->route('vendor.orders')->with('success','Form Submitted!');
    }

    public function downloadVendor(OutgoingOrder $order){
        $pdf = Pdf::loadView('partials.vendor-order-pdf', [
            'order'=> $order
        ]);
        return $pdf->download("order-{{$order->id}}.pdf");
    }

    public function viewVendorOrder(OutgoingOrder $order){
        $order->load('workCenter');
        
        return view('view-vendor-order', [
            'order' => $order
        ]);
    }

    public function viewOutOrder(OutgoingOrder $order){
        $order->load('workCenter', 'vendor');
        
        return view('orders.view-outgoing-order', [
            'order' => $order
        ]);
    }

    public function downloadOutgoing(OutgoingOrder $order){
        $pdf = Pdf::loadView('partials.incoming-order-pdf', [
            'order'=> $order
        ]);
        return $pdf->download("order-{{$order->id}}.pdf");
    }

    public function dropdown(){
         return OutgoingOrderStatusDropDownResource::collection(OutgoingOrder::select('id', 'status')->get());
    }
}
