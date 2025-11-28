<?php

namespace App\Services;

use App\Models\Smtp;
use App\Models\ReceivedEmail;
use Illuminate\Support\Facades\Log;

class ImapService
{
    /**
     * Fetch emails from SMTP server
     */
    public function fetchEmails(Smtp $smtp): array
    {
        $fetched = 0;
        $errors = [];

        try {
            // Build connection string
            $host = '{' . $smtp->host . ':' . $smtp->port . '/' . $smtp->encryption . '}';
            $mailbox = $host . $smtp->mailbox;

            // Connect to IMAP server
            $connection = @imap_open($mailbox, $smtp->username, $smtp->password, OP_READONLY);
            
            if (!$connection) {
                $error = imap_last_error();
                throw new \Exception('IMAP connection failed: ' . $error);
            }

            // Get all emails
            $emails = imap_search($connection, 'ALL');
            
            if (!$emails) {
                imap_close($connection);
                return ['fetched' => 0, 'errors' => []];
            }

            // Get existing message IDs to avoid duplicates
            $existingMessageIds = ReceivedEmail::where('smtp_id', $smtp->id)
                ->pluck('message_id')
                ->toArray();

            // Process each email
            foreach ($emails as $emailNumber) {
                try {
                    $header = imap_headerinfo($connection, $emailNumber);
                    $messageId = $header->message_id ?? null;

                    // Skip if already exists
                    if (!$messageId || in_array($messageId, $existingMessageIds)) {
                        continue;
                    }

                    // Get email body
                    $body = imap_body($connection, $emailNumber);
                    $bodyHtml = null;

                    // Try to get HTML body
                    $structure = imap_fetchstructure($connection, $emailNumber);
                    if ($structure) {
                        $bodyHtml = $this->getHtmlBody($connection, $emailNumber, $structure);
                    }

                    // Extract from/to
                    $fromEmail = $header->from[0]->mailbox . '@' . $header->from[0]->host;
                    $fromName = isset($header->from[0]->personal) ? imap_mime_header_decode($header->from[0]->personal)[0]->text : null;
                    
                    $toEmail = isset($header->to[0]) ? ($header->to[0]->mailbox . '@' . $header->to[0]->host) : '';
                    $toName = isset($header->to[0]->personal) ? imap_mime_header_decode($header->to[0]->personal)[0]->text : null;

                    // Get attachments
                    $attachments = $this->getAttachments($connection, $emailNumber, $structure);

                    // Save email
                    ReceivedEmail::create([
                        'smtp_id' => $smtp->id,
                        'message_id' => $messageId,
                        'from_email' => $fromEmail,
                        'from_name' => $fromName,
                        'to_email' => $toEmail,
                        'to_name' => $toName,
                        'subject' => isset($header->subject) ? imap_mime_header_decode($header->subject)[0]->text : '',
                        'body' => $body ?: '',
                        'body_html' => $bodyHtml,
                        'received_at' => date('Y-m-d H:i:s', $header->udate),
                        'attachments' => $attachments,
                    ]);

                    $fetched++;
                } catch (\Exception $e) {
                    $errors[] = 'Email #' . $emailNumber . ': ' . $e->getMessage();
                    Log::error('Error processing email: ' . $e->getMessage());
                }
            }

            // Update last fetched timestamp
            $smtp->update(['last_fetched_at' => now()]);

            imap_close($connection);

            return ['fetched' => $fetched, 'errors' => $errors];
        } catch (\Exception $e) {
            Log::error('IMAP fetch error: ' . $e->getMessage());
            return ['fetched' => $fetched, 'errors' => [$e->getMessage()]];
        }
    }

    /**
     * Get HTML body from email structure
     */
    private function getHtmlBody($connection, $emailNumber, $structure): ?string
    {
        if (!isset($structure->parts)) {
            return null;
        }

        foreach ($structure->parts as $partNum => $part) {
            if ($part->subtype === 'HTML') {
                $body = imap_fetchbody($connection, $emailNumber, $partNum + 1);
                return imap_base64($body) ?: quoted_printable_decode($body);
            }
        }

        return null;
    }

    /**
     * Get attachments from email
     */
    private function getAttachments($connection, $emailNumber, $structure): array
    {
        $attachments = [];

        if (!isset($structure->parts)) {
            return $attachments;
        }

        foreach ($structure->parts as $partNum => $part) {
            if (isset($part->disposition) && strtolower($part->disposition) === 'attachment') {
                $filename = '';
                if (isset($part->dparameters)) {
                    foreach ($part->dparameters as $param) {
                        if (strtolower($param->attribute) === 'filename') {
                            $filename = $param->value;
                            break;
                        }
                    }
                }

                if ($filename) {
                    $attachments[] = [
                        'filename' => $filename,
                        'size' => $part->bytes ?? 0,
                        'type' => $part->type ?? 'application/octet-stream',
                    ];
                }
            }
        }

        return $attachments;
    }
}

