<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\PayPal;
use App\Models\User;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookPurchaseMail;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Initiate PayPal payment - redirect to PayPal
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $book = Book::findOrFail($request->book_id);
        $paypal = PayPal::getActiveRotated();

        if (!$paypal) {
            return redirect()->route('books.show', $book->slug)
                ->with('error', __('payment.payment_disabled'));
        }

        try {
            // Create or get user by email
            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'password' => bcrypt(Str::random(16)), // Random password for guest users
                ]
            );

            // Store payment info in session
            session([
                'payment_book_id' => $book->id,
                'payment_name' => $request->name,
                'payment_email' => $request->email,
            ]);

            // Create PayPal payment
            $paypalService = new PayPalService($paypal);
            
            $returnUrl = route('payment.callback', ['status' => 'success']);
            $cancelUrl = route('payment.callback', ['status' => 'cancel']);

            $payment = $paypalService->createPayment(
                $book->price,
                $book->currency,
                $book->title,
                $returnUrl,
                $cancelUrl
            );

            // Store payment ID in session
            session(['paypal_payment_id' => $payment['payment_id']]);

            // Create pending order linked to this PayPal payment
            $order = Order::create([
                'num' => 'ORD-' . strtoupper(Str::random(10)),
                'paypal_payment_id' => $payment['payment_id'],
                'paypal_id' => $paypal->id,
                'user_id' => $user->id,
                'book_id' => $book->id,
                'price' => $book->price,
                'status' => 'pending',
            ]);

            // Store order id in session so we can easily update it on callback
            session(['order_id' => $order->id]);

            // Redirect to PayPal
            return redirect($payment['approval_url']);

        } catch (\Exception $e) {
            \Log::error('PayPal payment initiation failed: ' . $e->getMessage());
            
            return redirect()->route('books.show', $book->slug)
                ->with('error', __('payment.failed_initiate'));
        }
    }

    /**
     * Handle PayPal callback (success or cancel)
     */
    public function callback(Request $request)
    {
        $status = $request->get('status');
        $paymentId = session('paypal_payment_id');
        $orderId = session('order_id');
        $bookId = session('payment_book_id');
        $name = session('payment_name');
        $email = session('payment_email');

        // Clear session
        session()->forget(['paypal_payment_id', 'order_id', 'payment_book_id', 'payment_name', 'payment_email']);

        if ($status === 'cancel') {
            // Mark order as canceled if we have it
            if ($paymentId) {
                $order = Order::where('paypal_payment_id', $paymentId)->first();
                if ($order) {
                    $order->update(['status' => 'canceled']);
                }
            }

            if ($bookId) {
                $book = Book::find($bookId);
                if ($book) {
                    return redirect()->route('books.show', $book->slug)
                        ->with('error', __('payment.payment_cancelled'));
                }
            }
            return redirect()->route('books.index')
                ->with('error', __('payment.payment_cancelled'));
        }

        if (!$paymentId || !$bookId) {
            return redirect()->route('books.index')
                ->with('error', __('payment.session_expired'));
        }

        $book = Book::findOrFail($bookId);
        
        // Get PayPal from the order if it exists, otherwise use rotation
        $order = Order::where('paypal_payment_id', $paymentId)->first();
        if ($order && $order->paypal_id) {
            $paypal = PayPal::find($order->paypal_id);
        } else {
            $paypal = PayPal::getActiveRotated();
        }

        if (!$paypal) {
            return redirect()->route('books.show', $book->slug)
                ->with('error', __('payment.processing_failed'));
        }

        try {
            // Capture PayPal payment
            $paypalService = new PayPalService($paypal);
            $captureResult = $paypalService->capturePayment($paymentId);

            if ($captureResult['status'] !== 'COMPLETED') {
                return redirect()->route('books.show', $book->slug)
                    ->with('error', __('payment.not_completed'));
            }

            // Create or get user by email (in case they weren't already created)
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => bcrypt(Str::random(16)), // Random password for guest users
                ]
            );

            // Get payer ID from capture result
            $payerId = $captureResult['payer']['payer_id'] ?? null;

            // Find existing pending order by PayPal payment id, or create if not found
            $order = Order::where('paypal_payment_id', $paymentId)->first();

            if ($order) {
                $order->update([
                    'paypal_payer_id' => $payerId,
                    'paypal_id' => $paypal->id,
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'price' => $book->price,
                    'status' => 'completed',
                ]);
            } else {
                $order = Order::create([
                    'num' => 'ORD-' . strtoupper(Str::random(10)),
                    'paypal_payment_id' => $paymentId,
                    'paypal_payer_id' => $payerId,
                    'paypal_id' => $paypal->id,
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'price' => $book->price,
                    'status' => 'completed',
                ]);
            }

            // Increment PayPal transaction count
            $paypal->increment('transactions_count');

            // Send email with book attachment
            try {
                Mail::to($user->email)->send(new BookPurchaseMail($order, $book));
            } catch (\Exception $e) {
                // Log error but don't fail the order
                \Log::error('Failed to send email: ' . $e->getMessage());
            }

            return redirect()->route('payment.thankyou', $order->num)
                ->with('success', __('payment.success'));

        } catch (\Exception $e) {
            \Log::error('PayPal payment capture failed: ' . $e->getMessage());
            
            return redirect()->route('books.show', $book->slug)
                ->with('error', __('payment.processing_failed_contact'));
        }
    }

    /**
     * Show thank you page
     */
    public function thankyou($num)
    {
        $order = Order::with(['book', 'user'])->where('num', $num)->firstOrFail();
        
        return view('public.payment.thankyou', compact('order'));
    }
}

