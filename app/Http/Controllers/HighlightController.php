<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Highlight;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class HighlightController extends Controller
{
    private function ensureProductAccess(Product $product)
    {
        $user = Auth::user();

        if ($user && in_array($user->role, ['admin', 'superadmin'])) {
            return;
        }

        $hasAccess = Access::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        abort_unless($hasAccess, 403);
    }

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
        $product = Product::findOrFail($request->product_id);
        $this->ensureProductAccess($product);

        // dd($request);
        $newdata = new Highlight;

        $newdata->product_id = $request->product_id;
        $newdata->title = $request->title;
        $newdata->price = $request->price;
        $newdata->available = false;
        $newdata->description = $request->description;

        if ($request->hasFile('highlightimage')) {
            $image = $request->file('highlightimage');
            // Get the original filename without the extension
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            
            // Add the current date to the filename
            $currentDate = now()->format('YmdHis');
            
            // Create a new image name
            $imageName = $originalName . '_' . $currentDate;
            
            // Define the image storage path
            $imagePath = public_path('storage/images/product/highlight/');
            
            $manager = new ImageManager(new Driver());
            $imageOptimized = $manager->read($image->getPathname());
            $imageFullPath = $imagePath . $imageName . '.webp';
            $imageOptimized->save($imageFullPath);

            $newdata->image = $imageName . '.webp';
        }
        $newdata->save();

        return response()->json($newdata);
        
        // return redirect()->back()->with('highlight', 'highlight');
    }

    public function multiple(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $this->ensureProductAccess($product);

        $savedHighlights = [];
        $imageFiles = $request->file('images');

        foreach ($imageFiles as $index => $image) {
            $highlight = new Highlight;

            $highlight->product_id = $request->product_id;
            $highlight->title = 'Produk ' . ($index + 1); // Set title wajib
            $highlight->price = null;
            $highlight->available = false;
            $highlight->description = null;

            // Proses dan simpan gambar
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $currentDate = now()->format('YmdHis');
            $imageName = $originalName . '_' . $currentDate;

            $imagePath = public_path('storage/images/product/highlight/');
            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0755, true);
            }

            $manager = new ImageManager(new Driver());
            $imageOptimized = $manager->read($image->getPathname());
            $imageFullPath = $imagePath . $imageName . '.webp';
            $imageOptimized->save($imageFullPath);

            $highlight->image = $imageName . '.webp';
            $highlight->save();

            $savedHighlights[] = $highlight;
        }
        
        return response()->json($savedHighlights);
    }
    /**
     * Display the specified resource.
     */
    public function show(Highlight $highlight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Highlight $highlight)
    {
        //
    }

    public function available(Request $request, $id) {
        $highlight = Highlight::findOrFail($id);
        $this->ensureProductAccess($highlight->product);

        $highlight->available = !$highlight->available;

        $highlight->save();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Highlight $highlight)
    {
        $this->ensureProductAccess($highlight->product);

        // dd($request);
        if ($highlight) {
            $highlight->title = $request->title;
            $highlight->price = $request->price === 'null' ? null : $request->price;
            $highlight->description = $request->description === 'null' ? null : $request->description;
    
            if ($request->hasFile('highlightimage')) {
                if ($highlight->image) {
                    $path = public_path('storage/images/product/highlight/' . $highlight->image);
    
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $image = $request->file('highlightimage');
                // Get the original filename without the extension
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                
                // Add the current date to the filename
                $currentDate = now()->format('YmdHis');
                
                // Create a new image name
                $imageName = $originalName . '_' . $currentDate;
                
                // Define the image storage path
                $imagePath = public_path('storage/images/product/highlight/');
                
                $manager = new ImageManager(new Driver());
                $imageOptimized = $manager->read($image->getPathname());
                $imageFullPath = $imagePath . $imageName . '.webp';
                $imageOptimized->save($imageFullPath);
    
                $highlight->image = $imageName . '.webp';
            }
            $highlight->save();

        } else {
            return response()->json([
                'message' => 'Data tidak bisa di update.'.$highlight
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Highlight $highlight)
    {
        $this->ensureProductAccess($highlight->product);

        // Delete the main product image if it exists
        $path = public_path('storage/images/product/highlight/' . $highlight->image);
        if (file_exists($path)) {
            unlink($path);
        }

        // Finally, delete the product
        $highlight->delete();

        return redirect()->back()->with('highlight', 'highlight');
    }
}
