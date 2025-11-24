<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('admin.password_reset_email_subject') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0;">🔐 {{ __('admin.password_reset_email_subject') }}</h1>
    </div>
    
    <div style="background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 10px 10px;">
        <p style="font-size: 16px; margin-bottom: 20px;">{{ __('admin.password_reset_email_greeting', ['name' => $user->name ?? __('admin.admin')]) }}</p>
        
        <p style="font-size: 16px; margin-bottom: 20px;">
            {{ __('admin.password_reset_email_body') }}
        </p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetUrl }}" 
               style="display: inline-block; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px;">
                {{ __('admin.password_reset_email_button') }}
            </a>
        </div>
        
        <div style="background: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #ffc107;">
            <p style="margin: 0; color: #856404; font-size: 14px;">
                <strong>⚠️ {{ __('admin.password_reset_email_security_notice') }}</strong><br>
                {{ __('admin.password_reset_email_expiry_notice') }}
            </p>
        </div>
        
        <p style="font-size: 14px; color: #6b7280; margin-top: 30px;">
            {{ __('admin.password_reset_email_alternative') }}
        </p>
        
        <div style="background: #f3f4f6; padding: 15px; border-radius: 8px; margin: 20px 0; word-break: break-all;">
            <p style="margin: 0; font-size: 12px; color: #6b7280; font-family: monospace;">
                {{ $resetUrl }}
            </p>
        </div>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="color: #6b7280; font-size: 14px; margin: 0;">
                {{ __('admin.password_reset_email_footer') }}
            </p>
        </div>
        
        <div style="margin-top: 30px; text-align: center; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                {{ __('admin.password_reset_email_best_regards') }}<br>
                {{ __('admin.password_reset_email_team') }}
            </p>
        </div>
    </div>
</body>
</html>

