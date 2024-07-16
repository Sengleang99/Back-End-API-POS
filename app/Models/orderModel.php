<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderModel extends Model
{
    use HasFactory;
    protected $table = "order";
    protected $fillable = [
        'products_id',
        'customers_id',
        'payment_methods_id',
        'order_statuses_id',
        'order_date',
        'total',
    ];
}