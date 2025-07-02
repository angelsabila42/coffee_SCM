<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InvoiceExportController extends Controller
{
    public function exportCsv($id)
    {
        $invoice = Invoice::findOrFail($id);
        $items = InvoiceItem::where('invoice_id', $id)->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="invoice_' . $invoice->invoice_number . '.csv"',
        ];

        $columns = ['Description', 'Quantity', 'Unit Price'];

        return new StreamedResponse(function () use ($invoice, $items, $columns) {
            $handle = fopen('php://output', 'w');
            // Invoice header
            fputcsv($handle, ['Invoice Number', $invoice->invoice_number]);
            fputcsv($handle, ['Invoice Date', $invoice->invoice_date]);
            fputcsv($handle, ['Vendor Name', $invoice->vendor_name]);
            fputcsv($handle, ['Total', $invoice->total]);
            fputcsv($handle, []); // Empty line
            // Items header
            fputcsv($handle, $columns);
            foreach ($items as $item) {
                fputcsv($handle, [
                    $item->description,
                    $item->quantity,
                    $item->unit_price,
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }
} 