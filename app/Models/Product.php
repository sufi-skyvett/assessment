<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = ['name', 'price', 'details', 'is_published'];
    protected $guarded = ['id'];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // public function getPriceAttribute($value)
    // {
    //     return '$' . number_format($value, 2);
    // }

    // public function setPriceAttribute($value)
    // {
    //     $this->attributes['price'] = (float) $value;
    // }
}
