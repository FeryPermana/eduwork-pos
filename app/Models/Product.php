<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image', 'title', 'description', 'buy_price', 'sell_price', 'category_id', 'stock'
    ];

    public function scopeFilter($query, $params)
    {
        if ($params->search) {
            $query->where(function ($query) use ($params) {
                $query->where('title', 'like', '%' . $params->search . '%');
            });
        }

        if ($params->category_id) {
            $query->where(function ($query) use ($params) {
                $query->where('category_id', $params->category_id);
            });
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/products/' . $value),
        );
    }
}
