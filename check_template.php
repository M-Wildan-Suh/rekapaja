<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$templates = \App\Models\Template::all();
foreach ($templates as $t) {
    echo "ID: {$t->id}, Name: {$t->name}, Head: {$t->head_type}\n";
}
