<?php

namespace Mchev\LaravelOdk;

use Illuminate\Support\Facades\Http;

class LaravelOdkRequest
{

    private $api_url;

    private string $token;

    public function __construct() {

        $this->api_url = config('laravel-odk.api_url');

        $auth = new LaravelOdkAuth();

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
        ])->get($this->api_url . $endpoint, $params);

        return collect($response->json())->map(function ($item) {
                    return (object) $item;
                });
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
