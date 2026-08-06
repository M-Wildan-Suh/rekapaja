<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\TemplateGallery;
use App\Models\TemplateHighlight;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TemplateController extends Controller
{
    public function editimage($id, Request $request) {
        $request->validate([
            'thumbnail' => ['required', 'image', 'max:5120'],
        ]);

        $template = Template::findOrFail($id);
        if ($request->hasFile('thumbnail')) {
            if ($template->image) {
                $path = public_path('storage/images/template/' . $template->image);

                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $imageFile = $request->file('thumbnail');
            $imageName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $imagePath = public_path('storage/images/template/');

            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageFile->getPathname());
            $imageFullPath = $imagePath . $imageName . '.webp';
            $image->save($imageFullPath);

            $template->image = $imageName . '.webp';
        }
        $template->save();

        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Template::all();
        $data->transform(function ($data) {
            $data->image = asset('storage/images/template/'.$data->image);
            return $data;
        });
        return view('admin.template.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.template.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->templateValidationRules(true));

        $newdata = new Template;

        $newdata->name = $validated['name'];
        $newdata->bg_type = $validated['bg_type'];
        $newdata->head_type = $validated['header'];
        $newdata->gallery_type = $validated['gallery'];
        $newdata->accent_color = $validated['accent_color'];
        $newdata->desc_type = $validated['desc_type'];
        $newdata->desc_main_color = $validated['desc_main_color'];
        $newdata->desc_text_color = $validated['desc_text_color'];
        
        $newdata->product_type = $validated['product_type'];
        $newdata->product_main_color = $validated['product_main_color'];
        $newdata->product_second_color = $validated['product_second_color'];
        $newdata->product_text_color = $validated['product_text_color'];
        
        $newdata->contact_main_color = $validated['contact_main_color'];
        $newdata->contact_second_color = $validated['contact_second_color'];
        if ($newdata->bg_type === "normal") {
            $newdata->bg_main_color = $validated['bg_normal_color'];
        } elseif ($newdata->bg_type === "gradient") {
            $newdata->bg_main_color = $validated['bg_main_color'];
            $newdata->bg_second_color = $validated['bg_second_color'];
        } elseif ($newdata->bg_type === "image") {
            if ($request->hasFile('bg_image')) {
                $imageFile = $request->file('bg_image');
                $imageName = time();
                $imagePath = public_path('storage/images/template/background/');
    
                $manager = new ImageManager(new Driver());
                $image = $manager->read($imageFile->getPathname());
                $imageFullPath = $imagePath . $imageName . '.webp';
                $image->save($imageFullPath);
    
                $newdata->bg_image = $imageName . '.webp';
            }
        }

        $newdata->save();
          
        return redirect()->route('template.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        return view('admin.template.edit', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        $validated = $request->validate($this->templateValidationRules(false));

        $template->name = $validated['name'];
        $template->bg_type = $validated['bg_type'];
        $template->head_type = $validated['header'];
        $template->gallery_type = $validated['gallery'];
        $template->accent_color = $validated['accent_color'];
        $template->desc_type = $validated['desc_type'];
        $template->desc_main_color = $validated['desc_main_color'];
        $template->desc_text_color = $validated['desc_text_color'];
        
        $template->product_type = $validated['product_type'];
        $template->product_main_color = $validated['product_main_color'];
        $template->product_second_color = $validated['product_second_color'];
        $template->product_text_color = $validated['product_text_color'];
        
        $template->contact_main_color = $validated['contact_main_color'];
        $template->contact_second_color = $validated['contact_second_color'];
        if ($template->bg_type === "normal") {
            $template->bg_main_color = $validated['bg_normal_color'];
        } elseif ($template->bg_type === "gradient") {
            $template->bg_main_color = $validated['bg_main_color'];
            $template->bg_second_color = $validated['bg_second_color'];
        } elseif ($template->bg_type === "image") {
            if ($request->hasFile('bg_image')) {
                $imageFile = $request->file('bg_image');
                $imageName = time();
                $imagePath = public_path('storage/images/template/background/');
    
                $manager = new ImageManager(new Driver());
                $image = $manager->read($imageFile->getPathname());
                $imageFullPath = $imagePath . $imageName . '.webp';
                $image->save($imageFullPath);
    
                $template->bg_image = $imageName . '.webp';
            }
        }

        $template->save();
          
        return redirect()
            ->route('template.show', $template)
            ->with('success', 'Template berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        // Delete the main template image if it exists
        $path = public_path('storage/images/template/' . $template->image);
        if (file_exists($path)) {
            unlink($path);
        }

        // Fetch associated template gallery images
        $templateGalleries = TemplateGallery::where('template_id', $template->id)->get();

        // Loop through each gallery image and delete it
        foreach ($templateGalleries as $gallery) {
            $galleryPath = public_path('storage/images/template/gallery/' . $gallery->image); // Adjust the path as needed
            if (file_exists($galleryPath)) {
                unlink($galleryPath);
            }
            // Delete the gallery record from the database
            $gallery->delete();
        }

        $highlight = TemplateHighlight::where('template_id', $template->id)->get();

        foreach ($highlight as $item) {
            $galleryPath = public_path('storage/images/template/highlight/' . $item->image); // Adjust the path as needed
            if (file_exists($galleryPath)) {
                unlink($galleryPath);
            }
            $item->delete();
        }

        // Finally, delete the template
        $template->delete();

        return redirect()->back()->with('success', 'template and its gallery images deleted successfully.');
    }

    private function templateValidationRules(bool $isStore): array
    {
        $colorRule = ['required', 'regex:/^#[A-Fa-f0-9]{6}$/'];

        return [
            'name' => ['required', 'string', 'max:255'],
            'bg_type' => ['required', 'in:normal,gradient,image'],
            'header' => ['required', 'in:one,two,three,four,ramen,network,florist,donut'],
            'gallery' => ['required', 'in:square,potrait,network,florist'],
            'accent_color' => $colorRule,
            'desc_type' => ['required', 'in:default,ramen,network,florist'],
            'desc_main_color' => $colorRule,
            'desc_text_color' => $colorRule,
            'product_type' => ['required', 'in:grid2,list,grid3'],
            'product_main_color' => $colorRule,
            'product_second_color' => $colorRule,
            'product_text_color' => $colorRule,
            'contact_main_color' => $colorRule,
            'contact_second_color' => $colorRule,
            'bg_normal_color' => ['nullable', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'bg_main_color' => ['nullable', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'bg_second_color' => ['nullable', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'bg_image' => [$isStore ? 'required_if:bg_type,image' : 'nullable', 'image', 'max:5120'],
        ];
    }
}
