<?php

namespace Mchev\LaravelOdk;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class OdkCentralAuth
{

    private $api_url;

    private $email;

    private $password;

    private $expires = 3600;


    public function __construct() {

        $this->api_url = config('laravel-odk.api_url');

        $this->email = config('laravel-odk.user_email');

        $this->password = config('laravel-odk.user_password');

    }

    /**
     * Generate the access token that will be used to make request to the ODK Central API.
     *
     */
    public function generateAccessToken() {

        $endpoint = "/sessions";

        $response = Http::post($this->api_url . $endpoint, [
            'email' => $this->email,
            'password' => $this->password,
        ]);

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
    public function getAccessToken() {

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
     * @return boolean
     */
    public function destroyAccessToken() {

        $endpoint = "/sessions";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
        ])->delete($this->api_url . $endpoint, [
            'token' =>  $this->getAccessToken()
        ]);

        return $response->json();
    }

}
