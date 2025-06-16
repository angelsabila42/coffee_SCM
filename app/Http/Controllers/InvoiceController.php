<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::paginate(10); // Fetch invoices with pagination
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Generate a new unique invoice_number for the form, e.g., IN_XXXX
        $lastInvoice = Invoice::orderByDesc('id')->first();
        $newInvoiceNumber = 'IN_' . str_pad(($lastInvoice ? $lastInvoice->id : 0) + 1, 4, '0', STR_PAD_LEFT);

        return view('invoices.create', compact('newInvoiceNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedInvoice = $request->validate([
            'invoice_number' => 'required|unique:invoices,invoice_number|max:255',
            'invoice_date' => 'required|date',
            'vendor_name' => 'nullable|string|max:255',
            'vendor_po_box' => 'nullable|string|max:255',
            'vendor_city' => 'nullable|string|max:255',
            'vendor_country' => 'nullable|string|max:255',
            'bill_to_name' => 'required|string|max:255',
            'bill_to_po_box' => 'nullable|string|max:255',
            'bill_to_city' => 'nullable|string|max:255',
            'bill_to_country' => 'nullable|string|max:255',
            'sub_total' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'bank_account_no' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'recipient_phone' => 'nullable|string|max:255',
        ]);

        $validatedItems = $request->validate([
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validatedInvoice, $validatedItems) {
            $invoice = Invoice::create($validatedInvoice);

            foreach ($validatedItems['items'] as $itemData) {
                $invoice->items()->create($itemData);
            }
        });

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('items'); // Eager load the related invoice items
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load('items'); // Eager load the related invoice items
        return view('invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validatedInvoice = $request->validate([
            'invoice_date' => 'required|date',
            'vendor_name' => 'nullable|string|max:255',
            'vendor_po_box' => 'nullable|string|max:255',
            'vendor_city' => 'nullable|string|max:255',
            'vendor_country' => 'nullable|string|max:255',
            'bill_to_name' => 'required|string|max:255',
            'bill_to_po_box' => 'nullable|string|max:255',
            'bill_to_city' => 'nullable|string|max:255',
            'bill_to_country' => 'nullable|string|max:255',
            'sub_total' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'bank_account_no' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'purpose' => 'nullable|string|max:255',
            'recipient_phone' => 'nullable|string|max:255',
        ]);

        $validatedItems = $request->validate([
            'items.*.id' => 'nullable|exists:invoice_items,id',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validatedInvoice, $validatedItems, $invoice) {
            $invoice->update($validatedInvoice);

            // Sync invoice items
            $existingItemIds = $invoice->items->pluck('id')->toArray();
            $updatedItemIds = [];

            foreach ($validatedItems['items'] as $itemData) {
                if (isset($itemData['id']) && $itemData['id']) {
                    // Update existing item
                    $item = InvoiceItem::find($itemData['id']);
                    if ($item) {
                        $item->update($itemData);
                        $updatedItemIds[] = $item->id;
                    }
                } else {
                    // Create new item
                    $newItem = $invoice->items()->create($itemData);
                    $updatedItemIds[] = $newItem->id;
                }
            }

            // Delete items that were removed from the form
            $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
            if (!empty($itemsToDelete)) {
                InvoiceItem::whereIn('id', $itemsToDelete)->delete();
            }
        });

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete(); // This will also delete related invoice items due to `onDelete('cascade')` in migration

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully!');
    }
}
