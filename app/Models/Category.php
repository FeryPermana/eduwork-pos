<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'image', 'name', 'description'
    ];

    public function scopeFilter($query, $params)
    {
        if ($params->search) {
            $query->where(function ($query) use ($params) {
                $query->where('name', 'like', '%' . $params->search . '%');
            });
        }
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/categories/' . $value),
        );
    }
}
