<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$p = \App\Models\Product::find(44);
if ($p) {
    $p->image = 'hero_donut.png';
    $p->save();
}

$h1 = \App\Models\Highlight::find(169);
if ($h1) {
    $h1->image = 'donut_warnawarni.png';
    $h1->save();
}

$h2 = \App\Models\Highlight::find(170);
if ($h2) {
    $h2->image = 'donut_edan.png';
    $h2->save();
}
echo "Done\n";
