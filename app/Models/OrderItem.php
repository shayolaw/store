<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;


class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemsFactory> */
    use HasFactory;
    use HasUuids;

    protected $cast = [
        'id' => 'string'
    ];
    // protected $table = 'OrderItems';
    public $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function order():BelongsTo{
        return $this->belongsTo(Order::class);
    }
}
