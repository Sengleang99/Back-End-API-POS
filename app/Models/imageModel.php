<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imageModel extends Model
{
    use HasFactory;
    protected $table = "product_images";
    protected $fillable = [
        'product_id',
        'image_url'
    ];
}