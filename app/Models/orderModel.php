<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderModel extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $fillable = [
        'products_id',
        'customers_id',
        'payment_methods_id',
        'orders_status_id',
        'order_date',
        'total',
    ];
}