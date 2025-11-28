<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show contact form
     */
    public function index()
    {
        return view('public.contact.index');
    }

    /**
     * Store contact message
     * Throttled to 3 requests per minute via middleware
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'object' => 'required|string|max:255',
            'subject' => 'required|string|max:5000',
        ]);

        Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'object' => $validated['object'],
            'subject' => $validated['subject'],
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', __('contact.message_sent'));
    }
}
