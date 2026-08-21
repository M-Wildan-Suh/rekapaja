<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Gif\Exceptions\NotReadableException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductGalleryController extends Controller
{
    private function ensureProductAccess(Product $product)
    {
        $user = Auth::user();

        if ($user && in_array($user->role, ['admin', 'superadmin'])) {
            return;
        }

        $ownedProductId = Access::where('user_id', Auth::id())
            ->oldest('id')
            ->value('product_id');

        abort_unless((int) $ownedProductId === $product->id, 403);
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

        // Handle the file upload
        if ($request->hasFile('image_gallery')) {
            $image = $request->file('image_gallery');
            
            // Ensure the image is a valid instance of UploadedFile
            if ($image instanceof \Illuminate\Http\UploadedFile && $image->isValid()) {
                try {
                    // Get the original filename without the extension
                    $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    
                    // Add the current date to the filename
                    $currentDate = now()->format('YmdHis');
                    
                    // Create a new image name
                    $imageName = $originalName . '_' . $currentDate;
                    
                    // Define the image storage path
                    $imagePath = public_path('storage/images/product/gallery/');
                    
                    $manager = new ImageManager(new Driver());
                    $imageOptimized = $manager->read($image->getPathname());
                    $imageFullPath = $imagePath . $imageName . '.webp';
                    $imageOptimized->save($imageFullPath);
    
                    // Save the image to the database
                    $newImage = new ProductGallery();
                    $newImage->product_id = $request->product_id;
                    $newImage->image = $imageName . '.webp';
                    $newImage->save();
    
                    // Return the new image data (including ID for deletion) to the frontend
                    return response()->json([
                        'id' => $newImage->id,
                        'url' => asset('storage/images/product/gallery/' . $newImage->image),
                    ], 201);
    
                } catch (NotReadableException $e) {
                    return response()->json(['error' => 'Image processing error: ' . $e->getMessage()], 500);
                }
            }
        }
    
        return response()->json(['error' => 'Invalid image or upload failed'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductGallery $productGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductGallery $productGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductGallery $productGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $productGallery = ProductGallery::findOrFail($id);
        $this->ensureProductAccess($productGallery->product);

        $path = public_path('storage/images/product/gallery/' . $productGallery->image);
        if (file_exists($path)) {
            unlink($path);
        }

        // Finally, delete the auction
        $productGallery->delete();
    }
}
