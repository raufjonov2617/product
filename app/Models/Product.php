<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'article', 'name', 'status', 'data'
    ];

    const AVAILABLE = 'available';
    const UNAVAILABLE = 'unavailable';

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i'
    ];

    public function scopeFilter($query)
    {
        return $query->where('status', self::AVAILABLE);
    }
}
