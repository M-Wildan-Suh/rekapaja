<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$g1 = \App\Models\ProductGallery::find(229);
if ($g1) {
    $g1->image = 'gallery_donut_1.png';
    $g1->save();
}

$g2 = \App\Models\ProductGallery::find(230);
if ($g2) {
    $g2->image = 'gallery_donut_2.png';
    $g2->save();
}
echo "Gallery Done\n";
