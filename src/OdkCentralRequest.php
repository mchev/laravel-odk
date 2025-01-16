<?php

namespace Mchev\LaravelOdk;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class OdkCentralRequest
{
    public $api_url;

    private $response;

    private string $token;

    /**
     * Init
     */
    public function __construct()
    {
        $this->api_url = config('odkcentral.api_url');

        $auth = new OdkCentralAuth;

        $this->token = $auth->getAccessToken();
    }

    /**
     * GET METHOD
     */
    public function get(string $endpoint, array $params = [], array $headers = [])
    {
        try {
            $this->response = Http::withToken($this->token)
                ->withHeaders($headers)
                ->get($this->api_url.$endpoint, $params)
                ->object();
        } catch (RequestException $exception) {
            return $exception;
        }

        return $this->response();
    }

    /**
     * GET RAW METHOD
     */
    public function getBody(string $endpoint, array $params = [], array $headers = [])
    {
        try {
            $this->response = Http::withToken($this->token)
                ->withHeaders($headers)
                ->get($this->api_url.$endpoint, $params)
                ->body();
        } catch (RequestException $exception) {
            return $exception;
        }

        return (string) $this->response();
    }

    /** POST METHOD
     *
     * @param  object  $file
     */
    public function post(string $endpoint, array $params = [], array $headers = [], $file = null)
    {
        if (! is_null($file)) {
            try {
                $this->response = Http::withToken($this->token)
                    ->withHeaders($headers)
                    ->withBody($file->get(), $file->getMimeType())
                    ->post($this->api_url.$endpoint)
                    ->object();
            } catch (RequestException $exception) {
                return $exception;
            }
        } else {
            try {
                $this->response = Http::withToken($this->token)
                    ->withHeaders($headers)
                    ->post($this->api_url.$endpoint, $params)
                    ->object();
            } catch (RequestException $exception) {
                return $exception;
            }
        }

        return $this->response();
    }

    /** PATCH METHOD
     *
     */
    public function patch(string $endpoint, array $params = [], array $headers = [])
    {
        try {
            $this->response = Http::withToken($this->token)
                ->withHeaders($headers)
                ->patch($this->api_url.$endpoint, $params)
                ->object();
        } catch (RequestException $exception) {
            return $exception;
        }

        return $this->response();
    }

    /** PUT METHOD
     *
     */
    public function put(string $endpoint, array $params = [], array $headers = [])
    {
        try {
            $this->response = Http::withToken($this->token)
                ->withHeaders($headers)
                ->put($this->api_url.$endpoint, $params)
                ->object();
        } catch (RequestException $exception) {
            return $exception;
        }

        return $this->response();
    }

    /** DELETE METHOD
     *
     */
    public function delete(string $endpoint, array $params = [], array $headers = [])
    {
        try {
            $this->response = Http::withToken($this->token)
                ->withHeaders($headers)
                ->delete($this->api_url.$endpoint, $params)
                ->object();
        } catch (RequestException $exception) {
            return $exception;
        }

        return $this->response();
    }

    /** DOWNLOAD METHOD
     *
     */
    public function download(string $endpoint, array $params = [], array $headers = [])
    {
        try {
            $this->response = Http::withToken($this->token)
                ->withHeaders($headers)
                ->get($this->api_url.$endpoint, $params);
        } catch (RequestException $exception) {
            return $exception;
        }

        return \Response::make($this->response->body(), $this->response->status(), $this->response->headers());
    }

    /** Return the formated response
     *
     */
    public function response()
    {
        if (is_array($this->response)) {
            return collect($this->response);
        }

        return $this->response;
    }
}
