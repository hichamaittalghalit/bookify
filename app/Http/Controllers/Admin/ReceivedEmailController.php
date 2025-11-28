<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReceivedEmail;
use Illuminate\Http\Request;

class ReceivedEmailController extends Controller
{
    /**
     * Get email details
     */
    public function show($id)
    {
        $email = ReceivedEmail::findOrFail($id);
        
        return response()->json([
            'id' => $email->id,
            'from_email' => $email->from_email,
            'from_name' => $email->from_name,
            'to_email' => $email->to_email,
            'to_name' => $email->to_name,
            'subject' => $email->subject,
            'body' => $email->body,
            'body_html' => $email->body_html,
            'received_at' => $email->received_at->format('Y-m-d H:i:s'),
            'attachments' => $email->attachments,
        ]);
    }
}
