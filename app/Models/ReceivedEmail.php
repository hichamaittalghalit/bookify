<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceivedEmail extends Model
{
    protected $fillable = [
        'smtp_id',
        'message_id',
        'from_email',
        'from_name',
        'to_email',
        'to_name',
        'subject',
        'body',
        'body_html',
        'received_at',
        'attachments',
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'attachments' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function smtp()
    {
        return $this->belongsTo(Smtp::class);
    }
}
