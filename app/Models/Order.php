<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrdersFactory> */
    use HasFactory;
    use HasUuids;

    // protected $table = "Orders";
    protected $cast = [
        "id" => 'string'
    ];
    protected $fillable = [
        'status',
        'sub_total',
        'total_price',
        'total_tax',
        'user_id'
    ];

    public function user(): BelongsTo{
      return  $this->belongsTo(User::class);

    }
    public function order_items(): HasMany{
        return $this->hasMany(OrderItem::class);
    }
    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
