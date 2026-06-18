<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\returnSelf;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::where('role', '!=', 'admin')->get();
        return view('admin.user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,premium'],
            'premium_type' => ['nullable', 'required_if:role,premium', 'in:month,year,lifetime'],
            'expired' => ['nullable', 'required_if:role,premium', 'date'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'premium_type' => $request->premium_type,
            'expired' => $request->expired,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'role' => ['required', 'in:user,premium'],
            'premium_type' => ['nullable', 'required_if:role,premium', 'in:month,year,lifetime'],
            'expired' => ['nullable', 'required_if:role,premium', 'date'],
        ]);

        $user = User::find($id);

        $user->role = $validated['role'];
        $user->premium_type = $validated['role'] === 'premium' ? $validated['premium_type'] : null;
        $user->expired = $validated['role'] === 'premium' && ($validated['premium_type'] ?? null) !== 'lifetime'
            ? $validated['expired']
            : null;

        $user->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);

        $data->delete();

        return redirect()->back();
    }
}
