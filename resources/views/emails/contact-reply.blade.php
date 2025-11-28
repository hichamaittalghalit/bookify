<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('mail.contact_reply_subject') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0;">📧 {{ __('mail.contact_reply_subject') }}</h1>
    </div>
    
    <div style="background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 10px 10px;">
        <p style="font-size: 16px; margin-bottom: 20px;">{{ __('mail.hello', ['name' => $contact->name]) }}</p>
        
        <p style="font-size: 16px; margin-bottom: 20px;">
            {{ __('mail.thank_you_for_contacting') }}
        </p>
        
        <div style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #6366f1;">
            <h3 style="color: #6366f1; margin-top: 0;">{{ __('mail.your_message') }}</h3>
            <p style="margin: 0; color: #6b7280; font-size: 14px;">
                <strong>{{ __('mail.object') }}:</strong> {{ $contact->object }}<br>
                <strong>{{ __('mail.message') }}:</strong> {{ $contact->subject }}
            </p>
        </div>
        
        <div style="background: #e0e7ff; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #6366f1;">
            <h3 style="color: #6366f1; margin-top: 0;">{{ __('mail.our_response') }}</h3>
            <p style="margin: 0; color: #4b5563; white-space: pre-wrap;">{{ $replyMessage }}</p>
        </div>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="color: #6b7280; font-size: 14px; margin: 0;">
                {{ __('mail.if_you_have_questions') }}
            </p>
        </div>
        
        <div style="margin-top: 30px; text-align: center; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                {{ __('mail.best_regards') }}<br>
                {{ config('mail.from.name', 'Bookify Team') }}
            </p>
        </div>
    </div>
</body>
</html>

