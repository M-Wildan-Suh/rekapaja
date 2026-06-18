<?php

namespace App\Http\Controllers;

use App\Models\NoHandphone;
use Illuminate\Http\Request;

class NoHandphoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validated = $request->validate([
            'no_handphone' => ['required', 'string', 'max:20'],
        ]);

        $data = NoHandphone::first();
        // dd($request);
        if ($data) {
            $data->no_tlp = $validated['no_handphone'];

            $data->save();
        } else {
            $newdata = new NoHandphone;

            $newdata->no_tlp = $validated['no_handphone'];

            $newdata->save();
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(NoHandphone $noHandphone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NoHandphone $noHandphone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NoHandphone $noHandphone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NoHandphone $noHandphone)
    {
        //
    }
}
