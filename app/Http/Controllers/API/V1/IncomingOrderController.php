<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ImporterDropDownResource;
use App\Models\IncomingOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class IncomingOrderController extends Controller
{

    public function store(Request $request, IncomingOrder $order){
        $validated= $request->validate([
            'declineReason' => 'required|string',
        ]);

        $order->declineReason = $validated['declineReason'];
        $order->save();

        return redirect()->route('orders')->with('success','Form Submitted!');
    }
    public function download(IncomingOrder $order){
        $pdf = Pdf::loadView('partials.importer-order-pdf', [
            'order'=> $order
        ]);
        return $pdf->download("order-{{$order->id}}.pdf");
    }

    public function viewOrder(IncomingOrder $order){
        
        return view('orders.view-importer-order', [
            'order' => $order
        ]);
    }
    public function dropdown(){
    return ImporterDropDownResource::collection(IncomingOrder::select('id', 'destination', 'grade')->get());
}
}
