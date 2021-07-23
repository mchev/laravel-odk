<?php

namespace Mchev\LaravelOdk;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class OdkCentralRequest
{

    private $api_url;

    private string $token;

    public function __construct() {

        $this->api_url = config('odkcentral.api_url');

        $auth = new OdkCentralAuth();

        $this->token = $auth->getAccessToken();

    }

    /**
     * GET METHOD
     *
     */
    public function get(string $endpoint, array $params = [])
    {

        $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
            ])
            ->get($this->api_url . $endpoint, $params)
            ->throw(function ($response, $e) {
                return $e;
            })
            ->object();

        if (is_array($response)) {
            $response = collect($response);
        }

        return $response;
    }


    /** POST METHOD
     *
     */
    public function post(string $endpoint, array $params = [])
    {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post($this->api_url . $endpoint, $params);

        return collect($response->json())->map(function ($item) {
                    return (object) $item;
                });
    }

}
