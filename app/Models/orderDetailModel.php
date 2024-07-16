<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderDetailModel extends Model
{
    use HasFactory;
    protected $table = "order_detail";
    protected $fillable = [
        'orders_id',
        'products_id',
        'quantity',
        'price'
    ];
}