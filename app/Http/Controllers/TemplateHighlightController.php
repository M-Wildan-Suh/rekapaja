<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\TemplateHighlight;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TemplateHighlightController extends Controller
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
        $newdata = new TemplateHighlight;

        $newdata->template_id = $request->template_id;
        $newdata->title = $request->title;
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
            $imagePath = public_path('storage/images/template/highlight/');
            
            $manager = new ImageManager(new Driver());
            $imageOptimized = $manager->read($image->getPathname());
            $imageFullPath = $imagePath . $imageName . '.webp';
            $imageOptimized->save($imageFullPath);

            $newdata->image = $imageName . '.webp';
        }
        $newdata->save();
        
        return redirect()->back()->with('highlight', 'highlight');
    }

    /**
     * Display the specified resource.
     */
    public function show(TemplateHighlight $templateHighlight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TemplateHighlight $templateHighlight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TemplateHighlight $templateHighlight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TemplateHighlight $templateHighlight)
    {
        //
    }
}
