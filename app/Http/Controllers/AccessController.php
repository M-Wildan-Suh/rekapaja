<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Access::orderBy('user_id', 'asc')->get();

        $data = $data->map(function ($item) {
            $item->name = $item->user->name;
            $item->product_name = $item->product->name;
            return $item;
        });

        return view('admin.access.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::where('role', '!=', 'admin')->get();
        $access = Access::all();
        $product = Product::whereNotIn('id', $access->pluck('product_id'))->get();
        return view('admin.access.create', compact('user', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user' => ['required', 'exists:users,id'],
            'product' => ['required', 'exists:products,id'],
        ]);

        $newdata = new Access;

        $newdata->user_id = $validated['user'];
        $newdata->product_id = $validated['product'];

        $newdata->save();

        return redirect()->route('access.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Access $access)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Access $access)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Access $access)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Access $access)
    {
        // dd($access);
        $access->delete();

        return redirect()->back();
    }
}
