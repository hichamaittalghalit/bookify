<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Smtp extends Model
{
    protected $fillable = [
        'name',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'mailbox',
        'is_active',
        'last_fetched_at',
    ];

    protected $casts = [
        'port' => 'integer',
        'is_active' => 'boolean',
        'last_fetched_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];

    public function receivedEmails()
    {
        return $this->hasMany(ReceivedEmail::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encryptString($value);
    }

    public function getPasswordAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }
}
