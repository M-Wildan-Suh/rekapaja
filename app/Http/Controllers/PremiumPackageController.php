<?php

namespace App\Http\Controllers;

use App\Models\PremiumPackage;
use Illuminate\Http\Request;

class PremiumPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PremiumPackage::all();
        return view('admin.premium.index', compact('data'));
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
    public function show(PremiumPackage $premiumPackage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PremiumPackage $premiumPackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'desc' => ['required', 'string'],
        ]);

        $premiumPackage = PremiumPackage::findOrFail($id);

        $premiumPackage->name = $validated['name'];
        $premiumPackage->price = $validated['price'];
        $premiumPackage->desc = $validated['desc'];

        $premiumPackage->save();

        return redirect()->back();
        // dd($premiumPackage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PremiumPackage $premiumPackage)
    {
        //
    }
}
