<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Voucher;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class VoucherController extends Controller
{
    private function ensureAdmin(Request $request): void
    {
        abort_unless(in_array($request->user()->role, ['admin', 'superadmin']), 403);
    }

    public function index(Request $request)
    {
        $this->ensureAdmin($request);

        return view('admin.voucher.index', [
            'vouchers' => Voucher::with(['product', 'usedBy'])->latest()->paginate(20),
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureAdmin($request);
        $data = $request->validateWithBag('voucherCreate', [
            'quantity' => ['sometimes', 'required', 'integer', 'min:1', 'max:100'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'role' => ['required', 'in:user,premium'],
            'premium_type' => ['nullable', 'required_if:role,premium', 'in:month,year,lifetime'],
            'expired' => ['nullable', 'date', Rule::requiredIf(fn () => $request->role === 'premium' && $request->premium_type !== 'lifetime')],
        ]);
        $data['premium_type'] = $data['role'] === 'premium' ? $data['premium_type'] : null;
        $data['expired'] = $data['role'] === 'premium' && $data['premium_type'] !== 'lifetime' ? $data['expired'] : null;
        $quantity = $data['quantity'] ?? 1;
        unset($data['quantity']);
        $codes = DB::transaction(function () use ($data, $quantity) {
            $codes = [];
            for ($i = 0; $i < $quantity; $i++) {
                do {
                    $code = 'RKPJ-'.Str::upper(Str::random(16));
                } while (Voucher::where('code', $code)->exists());
                Voucher::create($data + ['code' => $code]);
                $codes[] = $code;
            }

            return $codes;
        });
        $request->session()->put('generated_vouchers', [
            'owner_id' => $request->user()->id,
            'product_name' => Product::findOrFail($data['product_id'])->name,
            'codes' => $codes,
        ]);

        return back()->with('open_generated_vouchers', true);
    }

    public function redeem(Request $request, VoucherService $service)
    {
        $data = $request->validate(['voucher' => ['required', 'string', 'max:64']]);
        $product = $service->redeem($data['voucher'], $request->user());

        return redirect()->route('product.show', $product)->with('success', 'Usaha berhasil dibuat dari voucher.');
    }
}
