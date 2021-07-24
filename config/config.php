<?php


return [

    /*
    |--------------------------------------------------------------------------
    | ODK Central API url
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default url for the API calls.
    | Example : https://private-anon-cecdde38ec-odkcentral.apiary-mock.com/v1
    |
    */
    
    'api_url' => env('ODK_API_URL'),


    /*
    |--------------------------------------------------------------------------
    | ODK Central Authentification
    |--------------------------------------------------------------------------
    |
    | An administrator user of your ODK Central app.
    |
    */

    'user_email' => env('ODK_USER_EMAIL'),

    'user_password' => env('ODK_USER_PASSWORD'),


];