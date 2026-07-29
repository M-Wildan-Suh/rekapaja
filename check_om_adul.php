<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$product = \App\Models\Product::where('name', 'like', '%adul%')->first();
if ($product) {
    echo "Om adul uses template id: " . $product->template_id . "\n";
    $template = \App\Models\Template::find($product->template_id);
    if ($template) {
        echo "Template name: " . $template->name . "\n";
        echo "Head type: " . $template->head_type . "\n";
    }
} else {
    echo "Om adul not found\n";
}

$donuts = \App\Models\Product::where('slug', 'donutsgo')->first();
if ($donuts) {
    echo "DonutsGO uses template id: " . $donuts->template_id . "\n";
    $template = \App\Models\Template::find($donuts->template_id);
    if ($template) {
        echo "Template name: " . $template->name . "\n";
        echo "Head type: " . $template->head_type . "\n";
    }
} else {
    echo "DonutsGO not found\n";
}
