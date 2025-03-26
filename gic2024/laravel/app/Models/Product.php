<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'pricing',
        'category_id',
        'description',
        'images'
    ];

    protected $casts = [
        'images' => 'json',
        'pricing' => 'double'
    ];

    // Remove or modify the hidden property to show necessary category info
    protected $hidden = ['category:id,name'];  // This will only show id and name from category

    public function category() {
        return $this->belongsTo(Category::class)->select(['id', 'name']);
    }
}
