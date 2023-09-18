<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'no_telp', 'address'
    ];

    public function scopeFilter($query, $params)
    {
        if ($params->search) {
            $query->where(function ($query) use ($params) {
                $query->where('name', 'like', '%' . $params->search . '%');
            });
        }
    }
}
