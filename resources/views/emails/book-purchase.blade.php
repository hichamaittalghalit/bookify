<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('email.thank_you_purchase') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0;">📚 {{ __('email.thank_you_purchase') }}</h1>
    </div>
    
    <div style="background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 10px 10px;">
        <p style="font-size: 16px; margin-bottom: 20px;">{{ __('email.hello', ['name' => $user->name]) }}</p>
        
        <p style="font-size: 16px; margin-bottom: 20px;">
            {{ __('email.thank_you_purchase') }} <strong>{{ $book->title }}</strong>!
        </p>
        <p style="font-size: 16px; margin-bottom: 20px;">
            {{ __('email.book_attached') }}
        </p>
        
        <div style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #6366f1;">
            <h2 style="color: #6366f1; margin-top: 0;">{{ __('email.order_details') }}</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; color: #6b7280;"><strong>{{ __('email.order_number') }}:</strong></td>
                    <td style="padding: 8px 0; text-align: right;"><strong>{{ $order->num }}</strong></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280;">{{ __('email.book_title') }}:</td>
                    <td style="padding: 8px 0; text-align: right;">{{ $book->title }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280;">{{ __('email.amount_paid') }}:</td>
                    <td style="padding: 8px 0; text-align: right;">{{ $order->currency }} {{ number_format($order->price, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280;">{{ __('email.date') }}:</td>
                    <td style="padding: 8px 0; text-align: right;">{{ $order->created_at->format('F j, Y g:i A') }}</td>
                </tr>
            </table>
        </div>
        
        <div style="background: #e0e7ff; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #6366f1;">
            <h3 style="color: #6366f1; margin-top: 0;">📎 {{ __('email.book_attached') }}</h3>
            <p style="margin: 0; color: #4b5563;">
                {{ __('email.download_book') }}
            </p>
        </div>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="color: #6b7280; font-size: 14px; margin: 0;">
                {{ __('email.enjoy_reading') }} 📖
            </p>
        </div>
        
        <div style="margin-top: 30px; text-align: center; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                {{ __('email.best_regards') }}<br>
                {{ __('email.bookify_team') }}
            </p>
        </div>
    </div>
</body>
</html>

