<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Mail\ContactReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Display a listing of contacts
     */
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show contact details
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show reply form
     */
    public function reply($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.reply', compact('contact'));
    }

    /**
     * Send reply email
     */
    public function sendReply(Request $request, $id)
    {
        $validated = $request->validate([
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $contact = Contact::findOrFail($id);

        try {
            Mail::to($contact->email)->send(
                new ContactReplyMail($contact, $validated['message'], $validated['subject'] ?? null)
            );

            return redirect()->route('admin.contacts.show', $contact->id)
                ->with('success', __('admin.reply_sent'));
        } catch (\Exception $e) {
            Log::error('Failed to send contact reply: ' . $e->getMessage());
            return back()->withErrors(['error' => __('admin.reply_failed')])->withInput();
        }
    }

    /**
     * Remove the specified contact
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', __('admin.contact_deleted'));
    }
}
