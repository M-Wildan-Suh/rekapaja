<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Category;
use App\Models\Highlight;
use App\Models\NoHandphone;
use App\Models\PivotProductTag;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductTag;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    public function dashboard ()
    {
        if (Auth::user()->role === 'admin') {
            $no_tlp = NoHandphone::first()->no_tlp;
            $data = Product::all();
            $tag = ProductTag::all();
        } else {
            $productIds = Access::where('user_id', Auth::id())->pluck('product_id');
            $no_tlp = NoHandphone::first()->no_tlp;
            $data = Product::whereIn('id', $productIds)->get();
            $tag = ProductTag::all();
        }
        return view('dashboard', compact('data', 'no_tlp'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('dashboard');
        // dd(Auth::user()->role);
        if (Auth::user()->role === 'admin') {
            $no_tlp = NoHandphone::first()->no_tlp;
            $data = Product::all();
            $tag = ProductTag::all();
        } else {
            $productIds = Access::where('user_id', Auth::id())->pluck('product_id');
            $no_tlp = NoHandphone::first()->no_tlp;
            $data = Product::whereIn('id', $productIds)->get();
            $tag = ProductTag::all();
        }
        return view('admin.product.index', compact('data', 'no_tlp'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tag = ProductTag::all();
        $category = Category::all();
        $template = Template::all();
        $product = Product::all();
        return view('admin.product.create', compact('tag', 'template', 'product', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->tag);
        $newdata= new Product();

        $newdata->name = $request->name;
        $newdata->slug = Str::slug($newdata->name);
        $newdata->subtitle = $request->subtitle;
        $newdata->price = $request->price;
        $newdata->template_id = $request->template_id;
        $newdata->description = $request->description;
        $newdata->address = $request->address;
        $newdata->no_tlp = $request->no_tlp;
        $newdata->youtube = $request->link;
        $newdata->home_button = $request->home_button;
        $newdata->status = 'active';

        if ($request->hasFile('thumbnail')) {
            $imageFile = $request->file('thumbnail');
            $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imagePath = public_path('storage/images/product/');

            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageFile->getPathname());
            $imageFullPath = $imagePath . $imageName . '.webp';
            $image->save($imageFullPath);

            $newdata->image = $imageName . '.webp';
        }

        $newdata->save();

        if ($request->category) {
            $categoryIds = [];
            foreach ($request->category as $categoryName) {
                $category = Category::firstOrCreate(['category' => $categoryName]);
                $categoryIds[] = $category->id;
            }
            $newdata->category()->attach($categoryIds);

            Category::doesntHave('products')->delete();
        }

        if ($request->tag) {
            foreach ($request->tag as $item) {
                $tag = ProductTag::where('tag', $item)->first();
                
                if ($tag) {
                    $newpivot = new PivotProductTag;
    
                    $newpivot->tag_id = $tag->id;
                    $newpivot->product_id = $newdata->id;
    
                    $newpivot->save();
                } else {
                    $newtag = new ProductTag;

                    $newtag->tag = ucfirst($item);

                    $newtag->save();

                    $newpivot = new PivotProductTag;
    
                    $newpivot->tag_id = $newtag->id;
                    $newpivot->product_id = $newdata->id;
    
                    $newpivot->save();
                }
                
            }
        }
          
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $access = Access::where('user_id', Auth::id())->where('product_id', $product->id)->first();

        if (Auth::user()->role === 'admin') {
            # code...
        } elseif (!$access) {
            return redirect()->back();
        }
        $product->productTags->transform(function ($data) {
            $data->tag = $data->productTag->tag;
            return $data;
        });
        
        // Mengambil semua ID dari productTags yang harus dikecualikan
        $tagexist = $product->productTags->pluck('productTag.id');
        $categoryexist = $product->category->pluck('id');
        
        // Memfilter tag berdasarkan ID yang tidak ada di tagexist
        $tag = ProductTag::whereNotIn('id', $tagexist)->get();
        $category = Category::whereNotIn('id', $categoryexist)->get();
        // dd($tag);

        $template = Template::all();
        $data = Product::whereNotIn('id', [$product->id])->get();
        
        return view('admin.product.edit', compact('product', 'tag', 'template', 'category', 'data'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    public function productorder($id, Request $request)
    {
        // dd($request);
        $data = Product::find($id);

        $data->order_title = $request->order_title;

        $data->save();

        return redirect()->back()->with('highlight', 'highlight');
    }
    
    
    public function producttitle($id, Request $request)
    {
        // dd($request);
        $data = Product::find($id);

        $data->product_title = $request->product_title;

        $data->save();

        return redirect()->back()->with('highlight', 'highlight');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // dd($product);

        $product->name = $request->name;
        $product->slug = Str::slug($product->name);
        $product->subtitle = $request->subtitle;
        $product->price = $request->price;
        $product->template_id = $request->template_id;
        $product->description = $request->description;
        $product->address = $request->address;
        $product->no_tlp = $request->no_tlp;
        $product->home_button = $request->home_button;
        $product->youtube = $request->link;
        if ($request->status) {
            $product->status = $request->status;
        }

        if ($request->hasFile('thumbnail')) {
            if ($product->image) {
                $path = public_path('storage/images/product/' . $product->image);

                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $imageFile = $request->file('thumbnail');
            $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imagePath = public_path('storage/images/product/');

            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageFile->getPathname());
            $imageFullPath = $imagePath . $imageName . '.webp';
            $image->save($imageFullPath);

            $product->image = $imageName . '.webp';
        }

        $product->save();

        if ($request->category) {
            $categoryIds = [];
            foreach ($request->category as $categoryName) {
                $category = Category::firstOrCreate(['category' => $categoryName]);
                $categoryIds[] = $category->id;
            }

            $product->category()->sync($categoryIds);
        }

        PivotProductTag::where('product_id', $product->id)->delete();
        
        if ($request->tag) {
            // Hapus data pivot yang memiliki product_id sesuai
        
            foreach ($request->tag as $item) {
                $tag = ProductTag::where('tag', $item)->first();
        
                if ($tag) {
                    $newpivot = new PivotProductTag;
    
                    $newpivot->tag_id = $tag->id;
                    $newpivot->product_id = $product->id;
    
                    $newpivot->save();
                } else {
                    $newtag = new ProductTag;
        
                    $newtag->tag = ucfirst($item);
        
                    $newtag->save();
        
                    $newpivot = new PivotProductTag;
        
                    $newpivot->tag_id = $newtag->id;
                    $newpivot->product_id = $product->id;
        
                    $newpivot->save();
                }
            }
        }
        

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete the main product image if it exists
        $path = public_path('storage/images/product/' . $product->image);
        if (file_exists($path)) {
            unlink($path);
        }

        // Fetch associated product gallery images
        $productGalleries = ProductGallery::where('product_id', $product->id)->get();

        // Loop through each gallery image and delete it
        foreach ($productGalleries as $gallery) {
            $galleryPath = public_path('storage/images/product/gallery/' . $gallery->image); // Adjust the path as needed
            if (file_exists($galleryPath)) {
                unlink($galleryPath);
            }
            // Delete the gallery record from the database
            $gallery->delete();
        }

        $highlight = Highlight::where('product_id', $product->id)->get();

        foreach ($highlight as $item) {
            $galleryPath = public_path('storage/images/product/highlight/' . $item->image); // Adjust the path as needed
            if (file_exists($galleryPath)) {
                unlink($galleryPath);
            }
            // Delete the gallery record from the database
            $gallery->delete();
        }

        // Finally, delete the product
        $product->delete();

        return redirect()->back()->with('success', 'product and its gallery images deleted successfully.');
    }
}
