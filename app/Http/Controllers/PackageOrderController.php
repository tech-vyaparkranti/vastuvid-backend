<?php

namespace App\Http\Controllers;

use App\Models\PackageOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PackageOrderController extends Controller
{
    private $appId;
    private $secretKey;
    private $baseUrl;

    public function __construct()
    {
        // Move these to .env file for better security
        $this->appId = env('CASHFREE_APP_ID', '745248e2ddc0b6cfc8332d5189842547');
        $this->secretKey = env('CASHFREE_SECRET_KEY', 'cfsk_ma_prod_dba4ebf1d1899e4a1f71ad3902a5c4a7_fdf77365');

        // Determine environment
        $environment = env('CASHFREE_ENVIRONMENT', 'production');
        $this->baseUrl = $environment === 'production'
            ? 'https://api.cashfree.com/pg/orders'
            : 'https://sandbox.cashfree.com/pg/orders';
    }

    public function createAndPay(Request $request)
    {
        try {
            $request->validate([
                'client_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:15',
                'amount' => 'required|numeric|min:1', // This is the base amount from frontend
                'package_type' => 'required|string|max:255',
                'package_class' => 'required|string|max:100',
                'remarks'       => 'nullable|string|max:1500',
            ]);

            $baseAmount = (float)$request->amount;
            $gstRate = 0.18; // 18% GST
            $gstAmount = round($baseAmount * $gstRate, 2); // Calculate GST, round to 2 decimal places
            $totalAmountWithGst = $baseAmount + $gstAmount; // Calculate total amount including GST

            // Create order in database
            // Ensure your PackageOrder model/migration has a column for the total amount if it's different from the base amount
            $order = PackageOrder::create([
                'client_name' => $request->client_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'amount' => $totalAmountWithGst, // Store the total amount with GST
                'package_type' => $request->package_type,
                'package_class' => $request->package_class,
                'payment_status' => 'pending',
                // You might want to store base_amount and gst_amount separately if needed for reporting
                'base_amount' => $baseAmount,
                'gst_amount' => $gstAmount,
                'remarks'       => $request->remarks,
            ]);

            $cashfreeOrderId = 'ORDER_' . $order->id . '_' . time(); // Make it more unique

            // Prepare Cashfree order payload
            $postData = [
                "order_id" => $cashfreeOrderId,
                "order_amount" => $totalAmountWithGst, // Pass the total amount including GST to Cashfree
                "order_currency" => "INR",
                "customer_details" => [
                    "customer_id" => 'user_' . $order->id,
                    "customer_name" => $order->client_name,
                    "customer_email" => $order->email,
                    "customer_phone" => $order->phone,
                ],
                "order_meta" => [
                    "return_url" => url('/api/cashfree/callback') . "?order_id=" . $cashfreeOrderId,
                    "notify_url" => url('/api/cashfree/webhook'),
                ],
            ];

            Log::info('Cashfree Order Request:', [
                'order_id' => $cashfreeOrderId,
                'base_amount' => $baseAmount,
                'gst_amount' => $gstAmount,
                'total_amount_with_gst' => $totalAmountWithGst,
                'customer' => $order->email
            ]);

            // Make API call to Cashfree
            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey,
                'Content-Type' => 'application/json',
                'x-api-version' => '2022-09-01',
            ])->post($this->baseUrl, $postData);

            Log::info('Cashfree API Response:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                // Update order with Cashfree order ID
                $order->update([
                    'cashfree_order_id' => $responseData['cf_order_id'] ?? null,
                    'payment_session_id' => $responseData['payment_session_id'] ?? null,
                ]);

                return response()->json([
                    'success' => true,
                    'cashfree' => $responseData,
                    'order_id' => $cashfreeOrderId,
                    'payment_session_id' => $responseData['payment_session_id'] ?? null,
                ]);
            }

            Log::error('Cashfree API Error:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Payment gateway error: ' . $response->body(),
                'message' => 'Failed to create payment order'
            ], 500);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Payment Creation Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Internal server error',
                'message' => 'Something went wrong while creating the payment order'
            ], 500);
        }
    }

    public function webhook(Request $request)
    {
        try {
            Log::info('Cashfree Webhook Received:', $request->all());

            // Get the signature from headers
            $signature = $request->header('x-webhook-signature');
            
            // Verify webhook signature (implement this for security)
            // It's crucial for production. Cashfree provides SDKs or you can implement
            // it manually by hashing the payload with your secret key.
            // For example:
            // $webhookTimestamp = $request->header('x-webhook-timestamp');
            // $computedSignature = hash_hmac('sha256', $webhookTimestamp . $request->getContent(), $this->secretKey);
            // if ($computedSignature !== $signature) {
            //     Log::warning('Webhook signature mismatch!', ['signature' => $signature, 'computed' => $computedSignature]);
            //     return response('Unauthorized', 401);
            // }

            $data = $request->all();
            
            // Handle different webhook types
            $eventType = $data['type'] ?? '';
            
            if ($eventType === 'PAYMENT_SUCCESS_WEBHOOK') {
                $this->handlePaymentSuccess($data);
            } elseif ($eventType === 'PAYMENT_FAILED_WEBHOOK') {
                $this->handlePaymentFailed($data);
            } elseif ($eventType === 'ORDER_EXPIRED_WEBHOOK') {
                // Handle order expiration if needed
                 Log::info('Order Expired Webhook Received:', $data);
                 $this->handleOrderExpired($data);
            }

            return response('OK', 200);

        } catch (\Exception $e) {
            Log::error('Webhook Error:', [
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);
            return response('Error', 500);
        }
    }

    private function handlePaymentSuccess($data)
    {
        $orderId = $data['data']['order']['order_id'] ?? '';
        $paymentId = $data['data']['payment']['payment_id'] ?? '';
        
        if ($orderId) {
            // Assuming orderId format is 'ORDER_{db_order_id}_{timestamp}'
            $parts = explode('_', $orderId);
            $orderIdNum = (int) ($parts[1] ?? 0); // Get the numeric ID from your database

            if ($orderIdNum > 0) {
                $order = PackageOrder::find($orderIdNum);
                if ($order) {
                    $order->update([
                        'payment_status' => 'completed',
                        'transaction_id' => $paymentId,
                        'payment_completed_at' => now(),
                    ]);
                    
                    Log::info('Payment Success Updated:', ['order_id' => $orderIdNum, 'cashfree_order_id' => $orderId]);
                } else {
                    Log::warning('Payment Success Webhook: Local order not found', ['order_id_cashfree' => $orderId, 'derived_local_id' => $orderIdNum]);
                }
            } else {
                 Log::error('Payment Success Webhook: Invalid local order ID derived from Cashfree order ID', ['order_id_cashfree' => $orderId]);
            }
        }
    }

    private function handlePaymentFailed($data)
    {
        $orderId = $data['data']['order']['order_id'] ?? '';
        
        if ($orderId) {
            // Assuming orderId format is 'ORDER_{db_order_id}_{timestamp}'
            $parts = explode('_', $orderId);
            $orderIdNum = (int) ($parts[1] ?? 0); // Get the numeric ID from your database

            if ($orderIdNum > 0) {
                $order = PackageOrder::find($orderIdNum);
                if ($order) {
                    $order->update([
                        'payment_status' => 'failed',
                        // You might also log failure reasons from $data['data']['payment']
                    ]);
                    
                    Log::info('Payment Failed Updated:', ['order_id' => $orderIdNum, 'cashfree_order_id' => $orderId]);
                } else {
                    Log::warning('Payment Failed Webhook: Local order not found', ['order_id_cashfree' => $orderId, 'derived_local_id' => $orderIdNum]);
                }
            } else {
                Log::error('Payment Failed Webhook: Invalid local order ID derived from Cashfree order ID', ['order_id_cashfree' => $orderId]);
            }
        }
    }

    private function handleOrderExpired($data)
    {
        $orderId = $data['data']['order']['order_id'] ?? '';
        
        if ($orderId) {
            $parts = explode('_', $orderId);
            $orderIdNum = (int) ($parts[1] ?? 0);

            if ($orderIdNum > 0) {
                $order = PackageOrder::find($orderIdNum);
                if ($order && $order->payment_status === 'pending') { // Only update if still pending
                    $order->update([
                        'payment_status' => 'expired',
                    ]);
                    Log::info('Order Expired Updated:', ['order_id' => $orderIdNum, 'cashfree_order_id' => $orderId]);
                } else {
                    Log::warning('Order Expired Webhook: Local order not found or already processed', ['order_id_cashfree' => $orderId, 'derived_local_id' => $orderIdNum]);
                }
            } else {
                Log::error('Order Expired Webhook: Invalid local order ID derived from Cashfree order ID', ['order_id_cashfree' => $orderId]);
            }
        }
    }

    public function callback(Request $request)
    {
        try {
            $orderId = $request->query('order_id');
            
            if (!$orderId) {
                return redirect()->to('/payment/error')->with('error', 'Invalid order ID');
            }

            // Fetch order status from Cashfree to verify
            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey, // <--- Added x-client-secret here
                'x-api-version' => '2022-09-01',
            ])->get($this->baseUrl . '/' . $orderId);

            if ($response->successful()) {
                $orderData = $response->json();
                $orderStatus = $orderData['order_status'] ?? 'UNKNOWN';
                
                // Update local order status
                // Assuming orderId format is 'ORDER_{db_order_id}_{timestamp}'
                $parts = explode('_', $orderId);
                $orderIdNum = (int) ($parts[1] ?? 0);

                $order = PackageOrder::find($orderIdNum);
                
                if ($order) {
                    $paymentStatus = match($orderStatus) {
                        'PAID' => 'completed',
                        'PENDING' => 'pending', // Explicitly handle pending
                        'FAILED' => 'failed',   // Handle failed cases here too
                        'EXPIRED' => 'expired', // Handle expired cases
                        default => 'pending',   // Default to pending for unknown statuses
                    };
                    $order->update(['payment_status' => $paymentStatus]);

                    // You might also want to update transaction_id if available from this query
                    if (isset($orderData['cf_order_id'])) {
                        $order->update(['cashfree_order_id' => $orderData['cf_order_id']]);
                    }
                     if (isset($orderData['payments']) && count($orderData['payments']) > 0 && isset($orderData['payments'][0]['cf_payment_id'])) {
                        $order->update(['transaction_id' => $orderData['payments'][0]['cf_payment_id']]);
                    }
                }

                // Redirect based on status
                if ($orderStatus === 'PAID') {
                    return redirect()->to('https://vyaparkranti.com/success')->with('success', 'Payment completed successfully');
                } elseif ($orderStatus === 'PENDING') {
                    return redirect()->to('/payment/pending')->with('info', 'Payment is being processed');
                } else { // FAILED, EXPIRED, or any other non-successful status
                    return redirect()->to('https://vyaparkranti.com/error')->with('error', 'Payment ' . strtolower($orderStatus) . ' or failed');
                }
            }

            Log::error('Cashfree API Error during callback verification:', [
                'status' => $response->status(),
                'body' => $response->body(),
                'order_id' => $orderId
            ]);

            return redirect()->to('https://vyaparkranti.com/error')->with('error', 'Unable to verify payment status from Cashfree');

        } catch (\Exception $e) {
            Log::error('Callback Error:', [
                'message' => $e->getMessage(),
                'order_id' => $request->query('order_id'),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->to('https://vyaparkranti.com/error')->with('error', 'Payment verification failed due to an internal error');
        }
    }

    // Add method to verify webhook signature (implement based on Cashfree docs)
    private function verifyWebhookSignature($payload, $signature)
    {
        // Implement signature verification logic here
        // This is crucial for production security
        // Refer to Cashfree's documentation for the exact algorithm (e.g., HMAC SHA256)
        // You'll need the x-webhook-timestamp header as well for the full verification.
        // Example (conceptual, verify with Cashfree docs):
        // $webhookTimestamp = request()->header('x-webhook-timestamp');
        // $data = $webhookTimestamp . $payload;
        // $computedSignature = hash_hmac('sha256', $data, $this->secretKey, true); // true for raw output
        // $computedSignatureBase64 = base64_encode($computedSignature);
        // return $computedSignatureBase64 === $signature;
        return true; // Placeholder - **MUST IMPLEMENT FOR PRODUCTION**
    }
    
}