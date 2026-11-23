<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RazorpayService
{
    protected string $keyId;
    protected string $keySecret;
    protected string $baseUrl = 'https://api.razorpay.com/v1';

    public function __construct()
    {
        $this->keyId = (string) (config('services.razorpay.key') ?: env('RAZORPAY_KEY', ''));
        $this->keySecret = (string) (config('services.razorpay.secret') ?: env('RAZORPAY_SECRET', ''));
    }

    public function getKeyId(): string
    {
        return $this->keyId;
    }

    /**
     * Create Razorpay order
     * @param float $amount in Rupees
     * @param string $receipt unique receipt string
     * @param array $notes metadata
     */
    public function createOrder(float $amount, string $receipt, array $notes = []): array
    {
        $amountInPaise = (int) round($amount * 100);

        if ($amountInPaise < 100) {
            // Minimum 1 INR
            $amountInPaise = 100;
        }

        try {
            $response = Http::withBasicAuth($this->keyId, $this->keySecret)
                ->timeout(15)
                ->post("{$this->baseUrl}/orders", [
                    'amount' => $amountInPaise,
                    'currency' => 'INR',
                    'receipt' => substr($receipt, 0, 40),
                    'notes' => $notes,
                    'payment_capture' => 1,
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'order' => $response->json(),
                ];
            }

            Log::error('Razorpay Order Creation Failed: ' . $response->body());
            return [
                'success' => false,
                'message' => $response->json('error.description') ?? 'Failed to create payment order.',
            ];
        } catch (\Throwable $e) {
            Log::error('Razorpay Order Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Payment gateway connection error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Verify payment signature
     */
    public function verifySignature(string $orderId, string $paymentId, string $signature): bool
    {
        $expectedSignature = hash_hmac('sha256', "{$orderId}|{$paymentId}", $this->keySecret);
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Fetch payment details from Razorpay API
     */
    public function fetchPayment(string $paymentId): ?array
    {
        try {
            $response = Http::withBasicAuth($this->keyId, $this->keySecret)
                ->timeout(10)
                ->get("{$this->baseUrl}/payments/{$paymentId}");

            return $response->successful() ? $response->json() : null;
        } catch (\Throwable $e) {
            Log::error('Razorpay Fetch Payment Exception: ' . $e->getMessage());
            return null;
        }
    }
}
