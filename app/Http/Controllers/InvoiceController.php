<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Access;
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
        if (in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            $data = Invoice::with('product')->latest()->get();
        } else {
            $productId = Access::where('user_id', Auth::id())
                ->oldest('id')
                ->value('product_id');

            $data = Invoice::with('product')
                ->where('business_id', $productId ?? 0)
                ->latest()
                ->get();
        }
        
        $data->transform(function ($data) {
            $createdAt = Carbon::parse($data->created_at)->locale('id');
            $data->date = $createdAt->translatedFormat('d F Y');
            preg_match('/Total\s*Rp\s*([0-9.,]+)/u', strip_tags($data->invoice_text), $totalMatch);
            $total = isset($totalMatch[1]) ? (int) preg_replace('/[^0-9]/', '', $totalMatch[1]) : 0;
            $data->total_price = 'Rp' . number_format($total, 0, ',', '.');
            $data->status = $data->status ?: 'Pending';
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
    public function update(Request $request, Invoice $rekap)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Pending,Selesai'],
        ]);

        $ownedProductId = Access::where('user_id', Auth::id())
            ->oldest('id')
            ->value('product_id');

        $hasAccess = in_array(Auth::user()->role, ['admin', 'superadmin']) || (int) $ownedProductId === $rekap->business_id;

        abort_unless($hasAccess, 403);

        $rekap->status = $validated['status'];
        $rekap->save();

        return redirect()->back();
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
