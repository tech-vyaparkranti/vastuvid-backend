<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    public function getPlans()
    {
        $plans = DB::connection('mysql2')->table('plans')->get();
         $data = [
            'status' => true,
            'success' => true,
            'plans' => $plans,
        ];
        return response()->json($data, 200);
    }
    
    public function createPaymentOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'organisation_name' => 'required|string|max:255',
            'employee_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|min:10|max:15', // Added phone validation
            'password' => 'required|string|min:6',
            'plan_id' => 'nullable|integer',
            'billing_cycle' => 'required|in:monthly,yearly',
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::connection('mysql2')->beginTransaction();

            // Generate unique order ID
            $orderId = 'ORD_' . time() . '_' . rand(1000, 9999);
            
            // Create payment transaction record using DB query
            $paymentTransactionId = DB::connection('mysql2')->table('payment_transactions')->insertGetId([
                'order_id' => $orderId,
                'amount' => $request->amount,
                'currency' => 'INR',
                'status' => 'pending',
                'plan_id' => $request->plan_id,
                'billing_cycle' => $request->billing_cycle,
                'customer_email' => $request->email,
                'customer_name' => $request->employee_name,
                'customer_phone' => $request->phone, // Store phone number
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'metadata' => json_encode([
                    'organisation_name' => $request->organisation_name,
                    'password_hash' => Hash::make($request->password),
                    'currency_data' => $request->currency,
                    'base_amount' => $request->base_amount ?? $request->amount,
                    'gst_amount' => $request->gst_amount ?? 0,
                    'total_amount' => $request->total_amount ?? $request->amount,
                    'tax_details' => $request->tax_details ?? null,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create Cashfree order - now passing phone number
            $cashfreeOrder = $this->createCashfreeOrder(
                $orderId, 
                $request->amount, 
                $request->email, 
                $request->employee_name,
                $request->phone // Pass phone number
            );

            if (!$cashfreeOrder['success']) {
                throw new Exception('Failed to create Cashfree order: ' . $cashfreeOrder['message']);
            }

            // Update payment transaction with Cashfree details using DB query
            DB::connection('mysql2')->table('payment_transactions')
                ->where('id', $paymentTransactionId)
                ->update([
                    'cf_order_id' => $cashfreeOrder['cf_order_id'],
                    'payment_session_id' => $cashfreeOrder['payment_session_id'],
                    'status' => 'processing',
                    'updated_at' => now(),
                ]);

            DB::connection('mysql2')->commit();

            return response()->json([
                'success' => true,
                'order_id' => $orderId,
                'payment_session_id' => $cashfreeOrder['payment_session_id'],
                'cf_order_id' => $cashfreeOrder['cf_order_id'],
            ]);

        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            Log::error('Payment order creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment order: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function createCashfreeOrder($orderId, $amount, $customerEmail, $customerName, $customerPhone)
    {
        try {
            // ... existing configuration code ...
            
            $clientId = config('services.cashfree.app_id');
            $clientSecret = config('services.cashfree.secret_key');
            $environment = config('services.cashfree.environment', 'sandbox');
            
            if ($environment === 'production') {
                $baseUrl = 'https://api.cashfree.com';
            } else {
                $baseUrl = 'https://sandbox.cashfree.com';
            }

            if (!$clientId || !$clientSecret) {
                throw new Exception('Cashfree credentials not configured');
            }

            // Clean phone number
            $cleanPhone = preg_replace('/[^0-9]/', '', $customerPhone);
            if (strlen($cleanPhone) === 10) {
                $cleanPhone = '91' . $cleanPhone;
            }

            // Get frontend URL from config or environment
            $frontendUrl = config('app.frontend_url', 'localhost:3000');

            // Prepare order data
            $orderData = [
                'order_id' => $orderId,
                'order_amount' => floatval($amount),
                'order_currency' => 'INR',
                'customer_details' => [
                    'customer_id' => 'CUST_' . time(),
                    'customer_name' => $customerName,
                    'customer_email' => $customerEmail,
                    'customer_phone' => $cleanPhone,
                ],
                'order_meta' => [
                    'return_url' => config('app.frontend_url' , 'localhost:3000') . '/crm?order_id=' . $orderId,
                    'notify_url' => config('app.url') . '/api/payment/webhook',
                ]
            ];

            // ... rest of the method remains the same ...
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-client-id' => $clientId,
                'x-client-secret' => $clientSecret,
                'x-api-version' => '2023-08-01',
            ])
            ->timeout(30)
            ->post($baseUrl . '/pg/orders', $orderData);

            Log::info('Cashfree API Response', [
                'status' => $response->status(),
                'response' => $response->json(),
                'request_data' => $orderData
            ]);

            if ($response->successful() && $response->json('payment_session_id')) {
                $responseData = $response->json();
                return [
                    'success' => true,
                    'cf_order_id' => $responseData['cf_order_id'],
                    'payment_session_id' => $responseData['payment_session_id'],
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response->json('message', 'Unknown error from Cashfree'),
                    'details' => $response->json()
                ];
            }

        } catch (Exception $e) {
            Log::error('Cashfree order creation failed', [
                'error' => $e->getMessage(),
                'order_id' => $orderId
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function handleWebhook(Request $request)
    {
        try {
            Log::info('Payment webhook received', [
                'method' => $request->method(),
                'all_data' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            // Check if this is a GET request (redirect from payment page)
            if ($request->isMethod('get')) {
                return $this->handlePaymentRedirect($request);
            }

            // Handle POST webhook
            $paymentData = $request->all();
            
            // Validate webhook data
            if (!isset($paymentData['type'])) {
                Log::error('Webhook type not found in request');
                return response()->json(['error' => 'Invalid webhook data'], 400);
            }

            if ($paymentData['type'] === 'PAYMENT_SUCCESS_WEBHOOK') {
                return $this->handlePaymentSuccess($paymentData['data']);
            } elseif ($paymentData['type'] === 'PAYMENT_FAILED_WEBHOOK') {
                return $this->handlePaymentFailure($paymentData['data']);
            }

            return response()->json(['status' => 'ok']);

        } catch (Exception $e) {
            Log::error('Webhook processing failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            // If it's a GET request (redirect), redirect to frontend with error
            if ($request->isMethod('get')) {
                return $this->redirectToFrontend('error', 'Payment verification failed');
            }
            
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Handle payment redirect (GET request)
     */
    private function handlePaymentRedirect(Request $request)
    {
        try {
            $orderId = $request->query('order_id');
            
            if (!$orderId) {
                Log::error('Payment redirect without order_id');
                return $this->redirectToFrontend('error', 'Invalid payment reference');
            }

            // Wait a moment for webhook to process (if it hasn't already)
            sleep(2);

            // Check payment status
            $paymentTransaction = DB::connection('mysql2')->table('payment_transactions')
                ->where('order_id', $orderId)
                ->first();

            if (!$paymentTransaction) {
                Log::error('Payment transaction not found for order: ' . $orderId);
                return $this->redirectToFrontend('error', 'Payment not found');
            }

            // If still processing, try to verify with Cashfree
            if ($paymentTransaction->status === 'processing') {
                $this->verifyPaymentWithCashfree($paymentTransaction);
                
                // Refresh payment transaction
                $paymentTransaction = DB::connection('mysql2')->table('payment_transactions')
                    ->where('order_id', $orderId)
                    ->first();
            }

            // Redirect based on status
            switch ($paymentTransaction->status) {
                case 'success':
                    return $this->redirectToFrontend('success', 'Payment completed successfully', [
                        'order_id' => $orderId,
                        'user_id' => $paymentTransaction->user_id
                    ]);
                    
                case 'failed':
                    return $this->redirectToFrontend('failed', 'Payment failed', [
                        'order_id' => $orderId,
                        'reason' => $paymentTransaction->failure_reason
                    ]);
                    
                default:
                    return $this->redirectToFrontend('pending', 'Payment is being processed', [
                        'order_id' => $orderId
                    ]);
            }

        } catch (Exception $e) {
            Log::error('Payment redirect error: ' . $e->getMessage());
            return $this->redirectToFrontend('error', 'Something went wrong');
        }
    }

    /**
     * Verify payment status with Cashfree API
     */
    private function verifyPaymentWithCashfree($paymentTransaction)
    {
        try {
            $clientId = config('services.cashfree.app_id');
            $clientSecret = config('services.cashfree.secret_key');
            $environment = config('services.cashfree.environment', 'sandbox');
            
            $baseUrl = $environment === 'production' 
                ? 'https://api.cashfree.com' 
                : 'https://sandbox.cashfree.com';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-client-id' => $clientId,
                'x-client-secret' => $clientSecret,
                'x-api-version' => '2023-08-01',
            ])
            ->timeout(30)
            ->get($baseUrl . '/pg/orders/' . $paymentTransaction->cf_order_id);

            if ($response->successful()) {
                $orderData = $response->json();
                
                Log::info('Cashfree order verification', [
                    'order_id' => $paymentTransaction->order_id,
                    'cf_order_id' => $paymentTransaction->cf_order_id,
                    'status' => $orderData['order_status'] ?? 'unknown'
                ]);

                // Update based on Cashfree status
                if (isset($orderData['order_status'])) {
                    switch ($orderData['order_status']) {
                        case 'PAID':
                            // Simulate successful payment webhook
                            $this->processSuccessfulPayment($paymentTransaction, $orderData);
                            break;
                            
                        case 'FAILED':
                        case 'CANCELLED':
                            DB::connection('mysql2')->table('payment_transactions')
                                ->where('id', $paymentTransaction->id)
                                ->update([
                                    'status' => 'failed',
                                    'failure_reason' => 'Payment ' . strtolower($orderData['order_status']),
                                    'gateway_response' => json_encode($orderData),
                                    'updated_at' => now(),
                                ]);
                            break;
                    }
                }
            }

        } catch (Exception $e) {
            Log::error('Cashfree verification failed: ' . $e->getMessage());
        }
    }

    /**
     * Process successful payment (from webhook or verification)
     */
    private function processSuccessfulPayment($paymentTransaction, $paymentData)
    {
        try {
            DB::connection('mysql2')->beginTransaction();

            // Update payment transaction
            DB::connection('mysql2')->table('payment_transactions')
                ->where('id', $paymentTransaction->id)
                ->update([
                    'status' => 'success',
                    'gateway_status' => 'PAID',
                    'payment_method' => $paymentData['payment_method'] ?? 'card',
                    'gateway_response' => json_encode($paymentData),
                    'payment_date' => now(),
                    'updated_at' => now(),
                ]);

            // Create user and subscriber
            $result = $this->createUserAndSubscriber($paymentTransaction->id);
            
            if (!$result['success']) {
                throw new Exception($result['message']);
            }

            DB::connection('mysql2')->commit();
            
            Log::info('Payment processing completed successfully', [
                'order_id' => $paymentTransaction->order_id,
                'user_id' => $result['user_id']
            ]);

        } catch (Exception $e) {
            DB::connection('mysql2')->rollback();
            
            DB::connection('mysql2')->table('payment_transactions')
                ->where('id', $paymentTransaction->id)
                ->update([
                    'status' => 'failed',
                    'failure_reason' => 'Registration failed: ' . $e->getMessage(),
                    'updated_at' => now(),
                ]);
            
            Log::error('Failed to process successful payment: ' . $e->getMessage());
        }
    }

    /**
     * Create user and subscriber records
     */
    private function createUserAndSubscriber($paymentTransactionId)
    {
        try {
            $paymentTransaction = DB::connection('mysql2')->table('payment_transactions')
                ->where('id', $paymentTransactionId)
                ->first();
            
            if (!$paymentTransaction) {
                throw new Exception('Payment transaction not found');
            }

            $metadata = json_decode($paymentTransaction->metadata, true);

            // Create user
            $userId = DB::connection('mysql2')->table('users')->insertGetId([
                'name' => $paymentTransaction->customer_name,
                'organisation_name' => $metadata['organisation_name'],
                'designation' => 'Owner',
                'email' => $paymentTransaction->customer_email,
                'password' => $metadata['password_hash'],
                'is_admin' => false,
                'email_verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Calculate expiry date
            $expiredOn = null;
            if ($paymentTransaction->billing_cycle === 'monthly') {
                $expiredOn = Carbon::now()->addMonth();
            } elseif ($paymentTransaction->billing_cycle === 'yearly') {
                $expiredOn = Carbon::now()->addYear();
            }

            // Create subscriber
            $subscriberId = DB::connection('mysql2')->table('subscribers')->insertGetId([
                'user_id' => $userId,
                'plan_id' => $paymentTransaction->plan_id,
                'currency_id' => $metadata['currency_data']['id'] ?? 1,
                'billing_cycle' => $paymentTransaction->billing_cycle,
                'amount' => $paymentTransaction->amount,
                'payment_transaction_id' => $paymentTransaction->id,
                'payment_status' => 'paid',
                'payment_date' => now(),
                'created_by_type' => 'App\\Models\\User',
                'created_by_id' => $userId,
                'expired_on' => $expiredOn,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update payment transaction
            DB::connection('mysql2')->table('payment_transactions')
                ->where('id', $paymentTransaction->id)
                ->update([
                    'user_id' => $userId,
                    'subscriber_id' => $subscriberId,
                    'updated_at' => now(),
                ]);

            // Create default pipelines
            $this->createDefaultPipelines($userId);
            
            // Create currency
            $this->createDefaultCurrency($userId, $metadata);

            return [
                'success' => true,
                'user_id' => $userId,
                'subscriber_id' => $subscriberId
            ];

        } catch (Exception $e) {
            Log::error('Failed to create user and subscriber: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Create default pipelines
     */
    private function createDefaultPipelines($userId)
    {
        $pipelineData = [
            [
                'name' => 'Lead Pipeline Stages',
                'type' => 'lead',
                'created_by_id' => $userId,
                'created_by_type' => 'App\\Models\\User',
                'status' => 1,
                'description' => 'Manage stages from CRM settings.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Deal Pipeline Stages',
                'type' => 'deal',
                'created_by_id' => $userId,
                'created_by_type' => 'App\\Models\\User',
                'status' => 1,
                'description' => 'Manage stages from CRM settings.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($pipelineData as $pipeline) {
            DB::connection('mysql2')->table('pipelines')->insert($pipeline);
        }
    }

    /**
     * Create default currency
     */
    private function createDefaultCurrency($userId, $metadata)
    {
        if (isset($metadata['currency_data']) && is_array($metadata['currency_data'])) {
            $currencyData = $metadata['currency_data'];
            
            DB::connection('mysql2')->table('currencies')->insert([
                'name' => $currencyData['currency'] ?? 'Indian Rupee',
                'code' => $currencyData['code'] ?? 'INR',
                'symbol' => $currencyData['symbol'] ?? '₹',
                'exchange_rate' => 1,
                'status' => 1,
                'created_by_type' => 'App\\Models\\User',
                'created_by_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Redirect to React frontend with payment status
     */
    private function redirectToFrontend($status, $message, $data = [])
    {
        $frontendUrl = config('app.frontend_url', 'http://localhost:3000');
        
        $queryParams = [
            'payment_status' => $status,
            'message' => urlencode($message),
        ];
        
        if (!empty($data)) {
            $queryParams = array_merge($queryParams, $data);
        }
        
        $redirectUrl = $frontendUrl . '/crm?' . http_build_query($queryParams);
        
        Log::info('Redirecting to frontend', [
            'url' => $redirectUrl,
            'status' => $status,
            'message' => $message
        ]);
        
        return redirect($redirectUrl);
    }

    /**
     * Handle successful payment from webhook
     */
    private function handlePaymentSuccess($paymentData)
    {
        try {
            $orderId = $paymentData['order']['order_id'];
            
            $paymentTransaction = DB::connection('mysql2')->table('payment_transactions')
                ->where('order_id', $orderId)
                ->first();
            
            if (!$paymentTransaction) {
                Log::error('Payment transaction not found for order: ' . $orderId);
                return response()->json(['error' => 'Payment transaction not found'], 404);
            }

            $this->processSuccessfulPayment($paymentTransaction, $paymentData);

            return response()->json(['status' => 'success']);

        } catch (Exception $e) {
            Log::error('Webhook payment success handling failed: ' . $e->getMessage());
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }

    /**
     * Handle failed payment from webhook
     */
    private function handlePaymentFailure($paymentData)
    {
        try {
            $orderId = $paymentData['order']['order_id'];
            
            $paymentTransaction = DB::connection('mysql2')->table('payment_transactions')
                ->where('order_id', $orderId)
                ->first();
            
            if ($paymentTransaction) {
                DB::connection('mysql2')->table('payment_transactions')
                    ->where('id', $paymentTransaction->id)
                    ->update([
                        'status' => 'failed',
                        'failure_reason' => $paymentData['payment']['payment_message'] ?? 'Payment failed',
                        'gateway_response' => json_encode($paymentData),
                        'updated_at' => now(),
                    ]);
            }

            return response()->json(['status' => 'payment_failed']);

        } catch (Exception $e) {
            Log::error('Webhook payment failure handling failed: ' . $e->getMessage());
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }
}
