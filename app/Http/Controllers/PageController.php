<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Category;
use App\Models\Highlight;
use App\Models\Invoice;
use App\Models\NoHandphone;
use App\Models\PivotProductTag;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductTag;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PageController extends Controller
{
    public function home(Request $request) {
        // dd($request->filter);
        $no_tlp = NoHandphone::first()->no_tlp;
        $no_tlp = preg_replace('/^0/', '+62', $no_tlp);
        $data = Product::where('status', 'active')->inRandomOrder()->get();
        return view('welcome', compact('data', 'no_tlp'));
    }

    public function product(Request $request) {
        // dd($request->filter);
        Paginator::currentPageResolver(function () use ($request) {
            return $request->route('page', 1); // default ke halaman 1
        });

        $no_tlp = NoHandphone::first()->no_tlp;
        $no_tlp = preg_replace('/^0/', '+62', $no_tlp);
        if ($request->search) {
            $search = $request->search;
            
            $data = Product::where('status', 'active')
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhereHas('productTags', function ($q) use ($search) {
                            $q->whereHas('productTag', function ($q2) use ($search) {
                                $q2->where('tag', 'like', '%' . $search . '%');
                            });
                        })
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('category', 'like', '%' . $search . '%');
                        });
                })
                ->inRandomOrder()
                ->paginate(10);
        } else {
            $data = Product::where('status', 'active')->inRandomOrder()->paginate(10);
        }
        $data->withPath('/bisnis/page')->appends($request->only('search'));
        $category = Category::whereHas('products', function ($query) {
            $query->where('status', 'active');
        })->get();
        $template = Template::inRandomOrder()->get();
        return view('product', compact('data', 'no_tlp', 'template', 'category'));
    }

    public function categorybusiness($category, Request $request) {
        Paginator::currentPageResolver(function () use ($request) {
            return $request->route('page', 1); // default ke halaman 1
        });

        $no_tlp = NoHandphone::first()->no_tlp;
        $no_tlp = preg_replace('/^0/', '+62', $no_tlp);

        $filter = $category;

        $category = Category::where('category', $category)->first();

        $data = Product::where('status', 'active')->whereHas('category', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->paginate(10);

        $category->category = Str::lower($category->category);

        $data->withPath("/bisnis/kategori/{$category->category}/page");

        $category = Category::whereHas('products', function ($query) {
            $query->where('status', 'active');
        })->get();
        
        $template = Template::inRandomOrder()->get();
        return view('product', compact('data', 'no_tlp', 'template', 'category', 'filter'));
    }

    public function template(Request $request) {
        $no_tlp = NoHandphone::first()->no_tlp;
        $no_tlp = preg_replace('/^0/', '+62', $no_tlp);
        if ($request->search) {
            $data = Template::where('name', 'like', '%' . $request->search . '%')->get();
        } else {
            $data = Template::all();
        }
        $data = $data->map(function ($item) {
            $item->slug = Str::slug($item->name, '-');
            return $item;
        });
        return view('template', compact('data', 'no_tlp'));
    }

    public function detail($slug) {
        $data = Product::where('slug', $slug)->first();
        
        if (!$data) {
            return view('not-found');
        }

        $template = Template::find($data->template_id);

        $role = Access::where('product_id', $data->id)->first();

        // Role Validation
        if ($role) {
            // No Telephone
            if ($role->user->role === 'premium' && ($role->user->premium_type === 'lifetime' || Carbon::parse($role->user->expired)->isFuture())) {
                if ($data->no_tlp) {
                    $no_tlp = $data->no_tlp;
                } else {
                    $no_tlp = NoHandphone::first()->no_tlp;
                }
                $role = $role->user->role;
            } else {
                $role = 'user';
                $no_tlp = NoHandphone::first()->no_tlp;
            }
        } else {
            $no_tlp = NoHandphone::first()->no_tlp;

            $role = 'admin';
        }

        $data->image = asset('storage/images/product/'. $data->image);

        $data->productGallery = $data->productGallery->map(function ($item) {
            $item->image = asset('storage/images/product/gallery/'. $item->image);
            return $item;
        });
        
        $data->productHighlight = $data->productHighlight->map(function ($item) {
            $item->image = asset('storage/images/product/highlight/'. $item->image);
            return $item;
        });

        if (!$data) {
            return redirect()->route('home');
        }

        $no_tlp = preg_replace('/^0/', '+62', $no_tlp);

        // Url Youtube
        $url = $data->youtube;
        $parsedUrl = parse_url($url);
        $videoId = null;

        if (isset($parsedUrl['host'])) {
            if ($parsedUrl['host'] === 'youtu.be') {
                // Jika URL menggunakan youtu.be, ambil ID dari path
                $videoId = ltrim($parsedUrl['path'], '/');
            } elseif (strpos($parsedUrl['host'], 'youtube.com') !== false) {
                // Jika URL menggunakan youtube.com, periksa path dan query
                if (strpos($parsedUrl['path'], '/shorts/') === 0) {
                    // Jika URL adalah Shorts, ambil ID dari path
                    $videoId = ltrim(str_replace('/shorts/', '', $parsedUrl['path']), '/');
                } elseif (isset($parsedUrl['query'])) {
                    // Jika URL menggunakan query, ambil ID dari parameter 'v'
                    parse_str($parsedUrl['query'], $query);
                    $videoId = $query['v'] ?? null;
                }
            }
        }

        // Buat embed URL jika ID ditemukan
        $data->embed = $videoId ? "https://www.youtube.com/embed/" . $videoId : $data->youtube;

        return view('detail', compact('data', 'no_tlp', 'role', 'template'));

    }

    public function createproduct() {
        $tag = ProductTag::all();
        $product = Product::all();
        return view('create-product', compact('tag', 'product'));
    }

    public function storeproduct(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:'.Product::class,
            'subtitle' => 'required|string|max:255',
            'desc' => 'required|string',
            'no_tlp' => 'required|string|max:20',
            'thumbnail' => 'required|image',

            'inputs' => 'array|max:3',
            'inputs.*.image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'inputs.*.title' => 'required|string|max:27',
            'inputs.*.description' => 'required|string|max:64',
        ], [
            'inputs.max' => 'Maksimal hanya boleh 3 produk/layanan.',
            'inputs.*.image.required' => 'Gambar produk/layanan wajib diunggah.',
            'inputs.*.image.image' => 'File harus berupa gambar.',
            'inputs.*.image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'inputs.*.title.required' => 'Nama produk/layanan wajib diisi.',
            'inputs.*.title.max' => 'Nama produk/layanan maksimal 27 karakter.',
            'inputs.*.description.required' => 'Deskripsi produk/layanan wajib diisi.',
            'inputs.*.description.max' => 'Deskripsi maksimal 64 karakter.',
        ]);
    
        // Jika validasi gagal, kirim alert dan kembali
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $newdata= new Product();

        $newdata->name = $request->name;
        $newdata->slug = Str::slug($newdata->name);
        $newdata->subtitle = $request->subtitle;
        $newdata->template_id = 1;
        $newdata->description = $request->desc;
        $newdata->no_tlp = $request->no_tlp;

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

        if ($request->inputs) {
            foreach ($request->inputs as $index => $item) {
                $newhighlight = new Highlight;

                $newhighlight->product_id = $newdata->id;
                $newhighlight->title = $item['title'];
                $newhighlight->price = $item['price'];
                $newhighlight->description = $item['description'];

                if ($request->hasFile('inputs.'.$index.'.image')) {
                    $image = $request->file('inputs.'.$index.'.image');
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

                    $newhighlight->image = $imageName . '.webp';
                }
                $newhighlight->save();
            }
        }

        if ($request->file('image_gallery')) {
            foreach ($request->file('image_gallery') as $item) {
                $newgallery = new ProductGallery;
                $newgallery->product_id = $newdata->id;
                if ($item) {
                    $imageFile = $item;
                    $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
                    $imagePath = public_path('storage/images/product/gallery/');
        
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($imageFile->getPathname());
                    $imageFullPath = $imagePath . $imageName . '.webp';
                    $image->save($imageFullPath);
        
                    $newgallery->image = $imageName . '.webp';
                }
                $newgallery->save();
            }
        }

        $no_tlp = NoHandphone::first()->no_tlp;
        $no_tlp = preg_replace('/^0/', '+62', $no_tlp);

        $text = urlencode("Halo, saya sudah mendaftarkan usaha Saya dengan nama usaha ".$newdata->name.". Saya tertarik dengan fitur-fitur yang ada dan ingin mengetahui lebih lanjut. Apakah bisa mendapatkan informasi lebih lengkap?");

        return redirect()->away('https://wa.me/'.$no_tlp.'?text=' . $text);
    }

    public function join() {
        $no_tlp = NoHandphone::first()->no_tlp;
        $no_tlp = preg_replace('/^0/', '+62', $no_tlp);

        $text = urlencode("Halo, Saya tertarik dengan fitur-fitur yang ada di byoo.link dan ingin mengetahui lebih lanjut.\n Apakah saya bisa mendapatkan informasi lebih lengkap?");

        return redirect()->away('https://wa.me/'.$no_tlp.'?text=' . $text);
    }

    public function order(Request $request, $no_tlp) {
        $invoice = new Invoice;

        $invoice->business_id = $request->product_id;
        $invoice->invoice_code = strtoupper(Str::random(10));
        $invoice->invoice_text = '';
        // $data = Highlight::whereIn('id', $request->order)->get();

        // $no_tlp = NoHandphone::first()->no_tlp;
        // $no_tlp = preg_replace('/^0/', '+62', $no_tlp);

        $message = "Halo, saya ingin memesan produk/layanan Anda.\n";
        $tanggal = Carbon::now('Asia/Jakarta')->locale('id')->format('d-m-Y');
        $total = 0;
        $invoiceText = '';

        $invoiceText .= '<p style="font-size: 0.875rem; color: #525252; font-weight: 600;">Tanggal</p>';
        $invoiceText .= "<p>" . $tanggal . "</p>";

        $invoiceText .= '<p style="margin-top:8px;"><b>Detail Rekapan</b></p>';
        foreach ($request->order as $item) {
            // dd($item['id']);
            if (isset($item['id'])) {
                $data = Highlight::find($item['id']);
                if ($data) {
                    $subtotal = $data->price * $item['quantity'];
                    $total += $subtotal;
                    
                    $message .= "\n- " . $data->title . ", Jumlah: " . $item['quantity'];
                    
                    $invoiceText .= '<div style="font-size: 0.875rem;display: flex; justify-content: space-between;"><b>- '.$data->title.'</b><p>'. $item['quantity'] .' x '.number_format($data->price, 0, ',', '.').' = '. number_format($subtotal, 0, ',', '.') .'</p></div>';
                }
            }
        }
        $invoiceText .= '<p style="font-size: 0.875rem; color: #525252; font-weight: 600; margin-top:8px;">Total</p>';
        $invoiceText .= "<b>Rp" . number_format($total, 0, ',', '.') . "</b>";
        $invoice->invoice_text = $invoiceText;
        $invoice->save();

        $invoiceUrl = url("/invoice/{$invoice->invoice_code}");
        $message .= "\n\nDetail Rekapan: {$invoiceUrl}";
        $message .= "\nUntuk produk/layanan diatas apakah masih tersedia?";
        $whatsappUrl = "https://wa.me/{$no_tlp}?text=" . urlencode($message);

        return redirect()->away($whatsappUrl);
    }
    public function test() {
        $data = Product::where('status', 'active')->inRandomOrder()->get();
        return view('test', compact('data'));
    }
}
