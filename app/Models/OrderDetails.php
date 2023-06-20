<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $table = 'orders_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'price',
        'qty',
    ];
}
