<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'price',
        'desc',
        'content',
        'image',
        'qty',
        'status',
    ];
}
