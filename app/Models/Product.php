<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    use HasUuids;

    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'in_stock',
    ];


public static function booted() {
    static::creating(function ($model) {
        $model->id = Str::uuid();
    });
}
}
