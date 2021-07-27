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
     * @param string $endpoint
     * @param array $params
     */
    public function get(string $endpoint, array $params = [], array $headers = [])
    {

        try {

            $this->response = Http::withToken($this->token)
                ->withHeaders($headers)
                ->get($this->api_url . $endpoint, $params)
                ->object();

        } catch (Exception $exception) {

            return $exception;

        }

        return $this->response();

    }

    /**
     * GET RAW METHOD
     *
     * @param string $endpoint
     * @param array $params
     */
    public function getBody(string $endpoint, array $params = [], array $headers = [])
    {

        try {

            $this->response = Http::withToken($this->token)
                ->withHeaders($headers)
                ->get($this->api_url . $endpoint, $params)
                ->body();

        } catch (Exception $exception) {

            return $exception;

        }

        return (string) $this->response();

    }

    /** POST METHOD
     *
     * @param string $endpoint
     * @param array $params
     */
    public function post(string $endpoint, array $params = [])
    {

        $this->response = Http::withToken($this->token)
            ->post($this->api_url . $endpoint, $params)
            ->throw()
            ->object();

        return $this->response();

    }


    /** PATCH METHOD
     *
     * @param string $endpoint
     * @param array $params
     */
    public function patch(string $endpoint, array $params = [])
    {

        $this->response = Http::withToken($this->token)
            ->patch($this->api_url . $endpoint, $params)
            ->throw()
            ->object();

        return $this->response();

    }

    /** PUT METHOD
     *
     * @param string $endpoint
     * @param array $params
     */
    public function put(string $endpoint, array $params = [])
    {

        $this->response = Http::withToken($this->token)
            ->put($this->api_url . $endpoint, $params)
            ->throw()
            ->object();

        return $this->response();

    }

    /** DELETE METHOD
     *
     * @param string $endpoint
     * @param array $params
     */
    public function delete(string $endpoint, array $params = [])
    {

        $this->response = Http::withToken($this->token)
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
