<?php

namespace Mchev\LaravelOdk;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OdkCentralAuth
{
    private $api_url;

    private $email;

    private $password;

    private $expires = 3600;

    public function __construct()
    {
        $this->api_url = config('odkcentral.api_url');

        $this->email = config('odkcentral.user_email');

        $this->password = config('odkcentral.user_password');
    }

    /**
     * Generate the access token that will be used to make request to the ODK Central API.
     */
    public function generateAccessToken()
    {
        $endpoint = '/sessions';

        $response = Http::post($this->api_url.$endpoint, [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $response->throw();

        $body = $response->body();
        $token = $response->json()['token'];

        Cache::remember('ODKAccessToken', $this->expires, function () use ($token) {
            return $token;
        });
    }

    /**
     * Get the access token.
     *
     * @return string
     */
    public function getAccessToken()
    {
        if (! Cache::has('ODKAccessToken')) {
            $this->generateAccessToken();
        }

        return Cache::get('ODKAccessToken');
    }

    /**
     * Destroy the ODK Central session.
     *
     * TODO : check the call and return boolean
     *
     * @return bool
     */
    public function destroyAccessToken()
    {
        $endpoint = '/sessions';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->getAccessToken(),
        ])->delete($this->api_url.$endpoint, [
            'token' => $this->getAccessToken(),
        ]);

        return $response->json();
    }
}
