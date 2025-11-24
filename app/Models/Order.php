<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'num',
        'uuid',
        'paypal_payment_id',
        'paypal_payer_id',
        'paypal_id',
        'user_id',
        'book_id',
        'price',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->uuid)) {
                $order->uuid = \Illuminate\Support\Str::uuid()->toString();
            }
        });
    }

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function paypal()
    {
        return $this->belongsTo(PayPal::class, 'paypal_id');
    }
}

