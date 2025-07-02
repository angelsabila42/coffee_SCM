<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Delivery;
use App\Models\Payment;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportExportController extends Controller
{
    public function salesCsv()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sales_report.csv"',
        ];
        $columns = ['Invoice #', 'Date', 'Vendor', 'Status', 'Total'];
        $invoices = Invoice::orderBy('invoice_date', 'desc')->get();
        return new StreamedResponse(function () use ($invoices, $columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);
            foreach ($invoices as $invoice) {
                fputcsv($handle, [
                    $invoice->invoice_number,
                    $invoice->invoice_date,
                    $invoice->vendor_name,
                    $invoice->status,
                    $invoice->total,
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    public function deliveryCsv()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="delivery_report.csv"',
        ];
        $columns = ['Delivery ID', 'Date Ordered', 'Destination', 'Status', 'Quantity'];
        $deliveries = Delivery::orderBy('date_ordered', 'desc')->get();
        return new StreamedResponse(function () use ($deliveries, $columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);
            foreach ($deliveries as $delivery) {
                fputcsv($handle, [
                    $delivery->delivery_id,
                    $delivery->date_ordered,
                    $delivery->delivery_destination,
                    $delivery->status,
                    $delivery->quantity,
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    public function paymentCsv()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="payment_report.csv"',
        ];
        $columns = ['Receipt #', 'Date Paid', 'Payer', 'Amount Paid', 'Status'];
        $payments = Payment::orderBy('date_paid', 'desc')->get();
        return new StreamedResponse(function () use ($payments, $columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);
            foreach ($payments as $payment) {
                fputcsv($handle, [
                    $payment->receipt_number,
                    $payment->date_paid,
                    $payment->payer,
                    $payment->amount_paid,
                    $payment->status,
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    public function receiptCsv($id)
    {
        $payment = Payment::findOrFail($id);
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="receipt_' . $payment->receipt_number . '.csv"',
        ];
        $columns = ['Receipt #', 'Invoice #', 'Payer', 'Amount Paid', 'Date Paid', 'Payment Mode', 'Status', 'Coffee Type', 'Description', 'Recipient Name'];
        return new StreamedResponse(function () use ($payment, $columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);
            fputcsv($handle, [
                $payment->receipt_number,
                optional($payment->invoice)->invoice_number,
                $payment->payer,
                $payment->amount_paid,
                $payment->date_paid,
                $payment->payment_mode,
                $payment->status,
                $payment->coffee_type,
                $payment->payment_description,
                $payment->recipient_name,
            ]);
            fclose($handle);
        }, 200, $headers);
    }
} 