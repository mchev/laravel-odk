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

        } catch (RequestException $exception) {

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

        } catch (RequestException $exception) {

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

        try {

            $this->response = Http::withToken($this->token)
                ->post($this->api_url . $endpoint, $params)
                ->object();

        } catch (RequestException $exception) {

            return $exception;

        }

        return $this->response();

    }


    /** PATCH METHOD
     *
     * @param string $endpoint
     * @param array $params
     */
    public function patch(string $endpoint, array $params = [])
    {

        try {

            $this->response = Http::withToken($this->token)
                ->patch($this->api_url . $endpoint, $params)
                ->object();

        } catch (RequestException $exception) {

            return $exception;

        }

        return $this->response();

    }

    /** PUT METHOD
     *
     * @param string $endpoint
     * @param array $params
     */
    public function put(string $endpoint, array $params = [])
    {

        try {

            $this->response = Http::withToken($this->token)
                ->put($this->api_url . $endpoint, $params)
                ->object();

        } catch (RequestException $exception) {

            return $exception;

        }

        return $this->response();

    }

    /** DELETE METHOD
     *
     * @param string $endpoint
     * @param array $params
     */
    public function delete(string $endpoint, array $params = [])
    {

        try {

            $this->response = Http::withToken($this->token)
                ->delete($this->api_url . $endpoint, $params)
                ->object();

        } catch (RequestException $exception) {

            return $exception;

        }

        return $this->response();

    }

    /** DOWNLOAD METHOD
     *
     * @param string $endpoint
     * @param array $params
     */
    public function download(string $endpoint, array $params = [])
    {

        try {

            $this->response = Http::withToken($this->token)
                ->get($this->api_url . $endpoint, $params);

        } catch (RequestException $exception) {

            return $exception;

        }

        return \Response::make($this->response->body(), $this->response->status(), $this->response->headers());

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