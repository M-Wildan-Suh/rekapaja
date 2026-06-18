<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function invoice($code)
    {
        $invoice = Invoice::where('invoice_code', $code)->firstOrFail();
        $data = Product::find($invoice->business_id);
        return view('invoice', compact('invoice', 'data'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $data = Invoice::latest()->get();
        } else {
            $data = Invoice::whereHas('product.access.user', function ($query) {
                $query->where('id', Auth::id());
            })->latest()->get();
        }
        
        $data->transform(function ($data) {
            $data->date = Carbon::parse($data->created_at)->locale('id')->translatedFormat('d m Y, H:i');
            $data->product;
            return $data;
        });
        // dd($data);
        return view('admin.invoice.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->back();
    }
}
