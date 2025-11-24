<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayPal extends Model
{
    use HasFactory;

    protected $table = 'paypals';

    protected $fillable = [
        'title',
        'email',
        'test_client_id',
        'test_secret_key',
        'live_client_id',
        'live_secret_key',
        'is_active',
        'transactions_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'transactions_count' => 'integer',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'paypal_id');
    }

    /**
     * Get the active PayPal account
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Get an active PayPal account using rotation (round-robin)
     */
    public static function getActiveRotated()
    {
        $activePaypals = static::where('is_active', true)->orderBy('id')->get();
        
        if ($activePaypals->isEmpty()) {
            return null;
        }

        // Get the last used PayPal ID from session
        $lastPaypalId = session('last_used_paypal_id', 0);
        
        // Find the next PayPal in rotation
        $nextPaypal = $activePaypals->filter(function($paypal) use ($lastPaypalId) {
            return $paypal->id > $lastPaypalId;
        })->first();
        
        if (!$nextPaypal) {
            // If no PayPal found with ID greater than last used, start from the beginning
            $nextPaypal = $activePaypals->first();
        }
        
        // Store the selected PayPal ID for next rotation
        session(['last_used_paypal_id' => $nextPaypal->id]);
        
        return $nextPaypal;
    }

    /**
     * Get client ID based on environment
     */
    public function getClientId()
    {
        if (app()->environment('production')) {
            return $this->live_client_id;
        }
        return $this->test_client_id;
    }

    /**
     * Get secret key based on environment
     */
    public function getSecretKey()
    {
        if (app()->environment('production')) {
            return $this->live_secret_key;
        }
        return $this->test_secret_key;
    }
}

