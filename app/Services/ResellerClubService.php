<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ResellerClubService
{
    protected $userId, $apiKey;

    public function __construct()
    {
        $this->userId = config('services.reseller.user_id');
        $this->apiKey = config('services.reseller.api_key');
    }

    public function checkDomain(string $domain, string $tld)
    {
        $response = Http::get('https://httpapi.com/api/domains/available.json', [
            'auth-userid'   => $this->userId,
            'api-key'       => $this->apiKey,
            'domain-name'   => $domain,
            'tlds'          => $tld,
        ]);

        return $response->json();
    }

    public function registerDomain(array $params)
    {
        $response = Http::asForm()->post('https://httpapi.com/api/domains/register.json', array_merge([
            'auth-userid' => $this->userId,
            'api-key'     => $this->apiKey,
        ], $params));

        return $response->json();
    }
}
