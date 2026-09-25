<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictOperator
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()?->role === 'operator') {
            // Only dashboard workflows; deployment, voucher creation and other pages are denied.
            abort_unless($request->routeIs(
                'dashboard', 'logout', 'product.index', 'product.create', 'product.store',
                'product.show', 'product.edit', 'product.update', 'product.destroy',
                'product.template.update', 'product.template.preview', 'voucher.redeem',
                'highlight.store', 'highlight.update', 'highlight.destroy', 'highlight.multiple',
                'highlight.available', 'highlight.bulk-update',
                'product-gallery.store', 'product-gallery.destroy'
            ), 403);
        }

        return $next($request);
    }
}
