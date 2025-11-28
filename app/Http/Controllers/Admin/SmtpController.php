<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Smtp;
use App\Models\ReceivedEmail;
use App\Services\ImapService;
use App\Mail\EmailReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SmtpController extends Controller
{
    protected $imapService;

    public function __construct(ImapService $imapService)
    {
        $this->imapService = $imapService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $smtps = Smtp::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.smtps.index', compact('smtps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.smtps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            'port' => 'required|integer|min:1|max:65535',
            'username' => 'required|string|max:255',
            'password' => 'required|string',
            'encryption' => 'required|in:ssl,tls,none',
            'mailbox' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['mailbox'] = $validated['mailbox'] ?? 'INBOX';
        $validated['is_active'] = $request->has('is_active');

        Smtp::create($validated);

        return redirect()->route('admin.smtps.index')->with('success', __('admin.smtp_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $smtp = Smtp::with('receivedEmails')->findOrFail($id);
        $emails = $smtp->receivedEmails()->orderBy('received_at', 'desc')->paginate(20);
        return view('admin.smtps.show', compact('smtp', 'emails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $smtp = Smtp::findOrFail($id);
        return view('admin.smtps.edit', compact('smtp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $smtp = Smtp::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            'port' => 'required|integer|min:1|max:65535',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string',
            'encryption' => 'required|in:ssl,tls,none',
            'mailbox' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['mailbox'] = $validated['mailbox'] ?? 'INBOX';
        $validated['is_active'] = $request->has('is_active');

        // Only update password if provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $smtp->update($validated);

        return redirect()->route('admin.smtps.index')->with('success', __('admin.smtp_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $smtp = Smtp::findOrFail($id);
        $smtp->delete();

        return redirect()->route('admin.smtps.index')->with('success', __('admin.smtp_deleted'));
    }

    /**
     * Fetch emails from SMTP
     */
    public function fetchEmails(string $id)
    {
        $smtp = Smtp::findOrFail($id);

        if (!$smtp->is_active) {
            return back()->withErrors(['error' => __('admin.smtp_not_active')]);
        }

        $result = $this->imapService->fetchEmails($smtp);

        if (!empty($result['errors'])) {
            return back()->withErrors(['error' => implode(', ', $result['errors'])])
                ->with('info', __('admin.emails_fetched', ['count' => $result['fetched']]));
        }

        return back()->with('success', __('admin.emails_fetched', ['count' => $result['fetched']]));
    }

    /**
     * Show reply form for received email
     */
    public function replyEmail($smtpId, $emailId)
    {
        $smtp = Smtp::findOrFail($smtpId);
        $email = ReceivedEmail::where('smtp_id', $smtpId)->findOrFail($emailId);
        return view('admin.smtps.reply-email', compact('smtp', 'email'));
    }

    /**
     * Send reply to received email
     */
    public function sendEmailReply(Request $request, $smtpId, $emailId)
    {
        $validated = $request->validate([
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $smtp = Smtp::findOrFail($smtpId);
        $email = ReceivedEmail::where('smtp_id', $smtpId)->findOrFail($emailId);

        try {
            Mail::to($email->from_email)->send(
                new EmailReplyMail($email, $validated['message'], $validated['subject'] ?? null)
            );

            return redirect()->route('admin.smtps.show', $smtp->id)
                ->with('success', __('admin.reply_sent'));
        } catch (\Exception $e) {
            Log::error('Failed to send email reply: ' . $e->getMessage());
            return back()->withErrors(['error' => __('admin.reply_failed')])->withInput();
        }
    }

    /**
     * List all received emails from all SMTPs
     */
    public function allEmails()
    {
        $emails = ReceivedEmail::with('smtp')
            ->orderBy('received_at', 'desc')
            ->paginate(20);
        return view('admin.smtps.all-emails', compact('emails'));
    }
}
