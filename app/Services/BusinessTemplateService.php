<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Template;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BusinessTemplateService
{
    private function pastelProductPreset(string $buttonColor = '#F26CA7', string $textColor = '#4A2F3A'): array
    {
        return [
            'product_type' => 'grid3',
            'product_main_color' => '#FFFFFF',
            'product_second_color' => $buttonColor,
            'product_text_color' => $textColor,
        ];
    }

    private function applyHeaderPreset(Template $template): void
    {
        $preset = match ($template->head_type) {
            'skincare' => $this->pastelProductPreset('#F26CA7', '#4A2F3A'),
            'pudding_putih' => $this->pastelProductPreset('#F26CA7', '#5C3446'),
            default => null,
        };

        if ($preset === null) {
            return;
        }

        foreach ($preset as $field => $value) {
            $template->{$field} = $value;
        }
    }

    public function rules(): array
    {
        $colorRule = ['required', 'regex:/^#[A-Fa-f0-9]{6}$/'];

        return [
            'bg_type' => ['required', 'in:normal,gradient,image'],
            'header' => ['required', 'in:one,two,three,four,ramen,network,donut,skincare,pudding_putih,sembako'],
            'gallery' => ['required', 'in:square,potrait,network'],
            'accent_color' => $colorRule,
            'desc_type' => ['required', 'in:default'],
            'desc_main_color' => $colorRule,
            'desc_text_color' => $colorRule,
            'product_type' => ['required', 'in:grid2,list,grid3'],
            'product_main_color' => $colorRule,
            'product_second_color' => $colorRule,
            'product_text_color' => $colorRule,
            'contact_main_color' => $colorRule,
            'contact_second_color' => $colorRule,
            'bg_normal_color' => ['required_if:bg_type,normal', 'nullable', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'bg_main_color' => ['required_if:bg_type,gradient', 'nullable', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'bg_second_color' => ['required_if:bg_type,gradient', 'nullable', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'bg_image' => ['nullable', 'image', 'max:5120'],
        ];
    }

    /** Build a draft without persisting the product or writing uploaded files. */
    public function preview(array $validated, Product $product): Template
    {
        $template = $product->designTemplate();
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
        }

        $this->applyHeaderPreset($template);

        return $template;
    }

    public function update(Request $request, Product $product): void
    {
        $validated = $request->validate($this->rules());
        $template = $product->designTemplate();
        if ($validated['bg_type'] === 'image' && !$request->hasFile('bg_image') && !$template->bg_image) {
            throw \Illuminate\Validation\ValidationException::withMessages(['bg_image' => 'Pilih gambar background.']);
        }
        $template = $this->preview($validated, $product);
        if ($template->bg_type === "image") {
            if ($request->hasFile('bg_image')) {
                $imageFile = $request->file('bg_image');
                $imageName = (string) \Illuminate\Support\Str::uuid();
                $imagePath = public_path('storage/images/template/background/');
                \Illuminate\Support\Facades\File::ensureDirectoryExists($imagePath);
    
                $manager = new ImageManager(new Driver());
                $image = $manager->read($imageFile->getPathname());
                $imageFullPath = $imagePath . $imageName . '.webp';
                $image->save($imageFullPath);
    
                $template->bg_image = $imageName . '.webp';
            }
        }

        $this->applyHeaderPreset($template);


        $product->template_settings = $template->settings();
        $product->save();
    }
}
