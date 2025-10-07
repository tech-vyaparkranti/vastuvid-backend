<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\DomainPurchase;
use Illuminate\Support\Facades\Log;

class DomainController extends Controller
{
    protected $resellerId;
    protected $apiKey;
    protected $apiBase;
    protected $tldsToCheck;
    protected $tldPrices;

    public function __construct()
    {
        // Hardcoded credentials (use with caution in production)
        $this->resellerId = '1257116';
        $this->apiKey = 'IKe6WPxUtPR0U08HVHxitOdtk1aA0Heo';
        $this->apiBase = 'https://httpapi.com/api/';
        $this->tldsToCheck = ['com', 'in', 'org', 'net', 'biz', 'info', 'co', 'io', 'xyz'];

        $this->tldPrices = [
            'com' => 1150,
            'in' => 725,
            'org' => 1350,
            'net' => 1338,
            'biz' => 849,
            'info' => 1299,
            'co' => 2999,
            'io' => 2799,
            'xyz' => 1229,
        ];

        $this->middleware('auth:sanctum')->only(['registerDomain']);
    }

    // Check domain availability
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'sld' => 'required|string',
        ]);

        $sld = strtolower($request->input('sld'));
        $results = [];

        foreach ($this->tldsToCheck as $tld) {
            $domain = "{$sld}.{$tld}";

            $queryParams = [
                'auth-userid' => $this->resellerId,
                'api-key' => $this->apiKey,
                'domain-name' => $sld,
                'tlds' => $tld,
            ];

            $url = "{$this->apiBase}domains/available.json";
            $response = Http::get($url, $queryParams);
            $data = $response->json();

            Log::debug("ResellerClub domain check", [
                'domain' => $domain,
                'url' => $url,
                'queryParams' => $queryParams,
                'http_status' => $response->status(),
                'response_body' => $response->body(),
            ]);

            $isAvailable = false;
            $status = 'error';
            $reason = null;

            if ($response->successful()) {
                if (isset($data[$domain])) {
                    $isAvailable = $data[$domain]['status'] === 'available';
                    $status = 'success';
                } elseif (isset($data['status']) && $data['status'] === 'ERROR') {
                    $reason = $data['message'] ?? 'Unknown API error';
                } else {
                    $reason = 'Domain not found in API response';
                }
            } else {
                $reason = 'API request failed';
            }

            $results[] = [
                'domain' => $domain,
                'sld' => $sld,
                'tld' => $tld,
                'available' => $isAvailable,
                'status' => $status,
                'price' => $this->tldPrices[$tld] ?? null,
                'reason' => $reason,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Domain availability checked successfully.',
            'results' => $results,
        ]);
    }

    // Register domain after user fills full contact details (after sign in/up)
    public function registerDomain(Request $request)
    {
        $request->validate([
            'domain' => 'required|string',
            'years' => 'required|integer|min:1',
            'contact' => 'required|array',
        ]);

        $user = Auth::user();

        if (!$user || !$user->reseller_customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated or missing reseller_customer_id',
            ], 403);
        }

        $contact = $request->input('contact');
        $contactParams = [
            'auth-userid' => $this->resellerId,
            'api-key' => $this->apiKey,
            'name' => $contact['name'],
            'company' => $contact['company'] ?? '',
            'email' => $contact['email'],
            'address-line-1' => $contact['address'],
            'city' => $contact['city'],
            'state' => $contact['state'],
            'country' => $contact['country'],
            'zipcode' => $contact['zipcode'],
            'phone-cc' => $contact['phone_cc'],
            'phone' => $contact['phone'],
            'type' => 'Contact'
        ];

        $contactResponse = Http::asForm()->post("{$this->apiBase}contacts/add.json", $contactParams);

        if (!$contactResponse->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Contact creation failed',
                'data' => $contactResponse->json()
            ], 400);
        }

        $contactId = $contactResponse->json();

        $params = [
            'auth-userid' => $this->resellerId,
            'api-key' => $this->apiKey,
            'domain-name' => $request->input('domain'),
            'years' => $request->input('years'),
            'customer-id' => $user->reseller_customer_id,
            'reg-contact-id' => $contactId,
            'admin-contact-id' => $contactId,
            'tech-contact-id' => $contactId,
            'billing-contact-id' => $contactId,
            'invoice-option' => 'NoInvoice',
        ];

        if ($request->has('ns')) {
            foreach ($request->input('ns') as $index => $ns) {
                $params["ns" . ($index + 1)] = $ns;
            }
        }

        $response = Http::asForm()->post("{$this->apiBase}domains/register.json", $params);
        $domain = $request->input('domain');
        $tld = substr(strrchr($domain, '.'), 1);

        DomainPurchase::create([
            'user_id' => $user->id,
            'domain' => $domain,
            'tld' => $tld,
            'years' => $request->input('years'),
            'status' => $response->successful() ? 'registered' : 'failed',
            'reseller_data' => $response->json(),
        ]);

        return response()->json([
            'success' => $response->successful(),
            'message' => $response->successful() ? 'Domain registered successfully' : 'Domain registration failed',
            'data' => $response->json(),
        ]);
    }
}
