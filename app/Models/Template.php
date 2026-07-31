<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;
    public function templateGallery()
    {
        return $this->hasMany(TemplateGallery::class);
    }
    public function templateHighlight()
    {
        return $this->hasMany(TemplateHighlight::class);
    }
}
