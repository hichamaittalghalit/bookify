<?php

namespace App\Services;

use App\Models\PayPal as PayPalModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayPalService
{
    protected $paypal;
    protected $baseUrl;
    protected $clientId;
    protected $secretKey;

    public function __construct(PayPalModel $paypal = null)
    {
        $this->paypal = $paypal ?: PayPalModel::getActive();
        
        if (!$this->paypal) {
            throw new \Exception('PayPal account not configured');
        }

        // Determine PayPal API base URL based on environment
        if (app()->environment('production')) {
            $this->baseUrl = 'https://api-m.paypal.com';
        } else {
            $this->baseUrl = 'https://api-m.sandbox.paypal.com';
        }

        $this->clientId = $this->paypal->getClientId();
        $this->secretKey = $this->paypal->getSecretKey();
    }

    /**
     * Get PayPal access token
     */
    protected function getAccessToken()
    {
        $response = Http::asForm()->withBasicAuth($this->clientId, $this->secretKey)
            ->post($this->baseUrl . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new \Exception('Failed to get PayPal access token: ' . $response->body());
    }

    /**
     * Create PayPal payment and return approval URL
     */
    public function createPayment($amount, $currency, $description, $returnUrl, $cancelUrl)
    {
        $accessToken = $this->getAccessToken();

        $paymentData = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => number_format($amount, 2, '.', '')
                    ],
                    'description' => $description
                ]
            ],
            'application_context' => [
                'return_url' => $returnUrl,
                'cancel_url' => $cancelUrl,
                'brand_name' => config('app.name', 'Bookify'),
                'user_action' => 'PAY_NOW'
            ]
        ];

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation'
            ])
            ->post($this->baseUrl . '/v2/checkout/orders', $paymentData);

        if ($response->successful()) {
            $payment = $response->json();
            
            // Find approval URL
            $approvalUrl = null;
            foreach ($payment['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    $approvalUrl = $link['href'];
                    break;
                }
            }

            return [
                'payment_id' => $payment['id'],
                'approval_url' => $approvalUrl
            ];
        }

        throw new \Exception('Failed to create PayPal payment: ' . $response->body());
    }

    /**
     * Capture PayPal payment
     */
    public function capturePayment($paymentId)
    {
        $accessToken = $this->getAccessToken();

        // PayPal expects a JSON object body ({}), not an empty array, otherwise
        // it may respond with MALFORMED_REQUEST_JSON.
        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation'
            ])
            ->withBody('{}', 'application/json')
            ->post($this->baseUrl . '/v2/checkout/orders/' . $paymentId . '/capture');

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to capture PayPal payment: ' . $response->body());
    }
}

