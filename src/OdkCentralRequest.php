<?php

namespace Mchev\LaravelOdk;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class OdkCentralRequest
{

    private $api_url;

    private $response;

    private string $token;


    /**
     * Init
     *
     */
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

        $this->response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
            ])
            ->get($this->api_url . $endpoint, $params)
            ->throw(function ($response, $e) {
                return $e;
            })
            ->object();

        return $this->response();

    }


    /** POST METHOD
     *
     */
    public function post(string $endpoint, array $params = [])
    {

        $this->response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
            ])
            ->post($this->api_url . $endpoint, $params)
            ->throw()
            ->object();

        return $this->response();

    }


    /** PATCH METHOD
     *
     */
    public function patch(string $endpoint, array $params = [])
    {

        $this->response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
            ])
            ->patch($this->api_url . $endpoint, $params)
            ->throw()
            ->object();

        return $this->response();

    }

    /** PUT METHOD
     *
     */
    public function put(string $endpoint, array $params = [])
    {

        $this->response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
            ])
            ->put($this->api_url . $endpoint, $params)
            ->throw()
            ->object();

        return $this->response();

    }

    /** DELETE METHOD
     *
     */
    public function delete(string $endpoint, array $params = [])
    {

        $this->response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
            ])
            ->delete($this->api_url . $endpoint, $params)
            ->throw()
            ->object();

        return $this->response();

    }

    /** Return the formated response
     *
     */
    public function response() {

        if (is_array($this->response)) {
            return collect($this->response);
        }

        return $this->response;
    }

}
