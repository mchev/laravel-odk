<?php


return [

    /*
    |--------------------------------------------------------------------------
    | ODK Central API url
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default url for the API calls
    |
    */
    'api_url' => env('ODK_API_URL', 'https://private-anon-cecdde38ec-odkcentral.apiary-mock.com/v1'),


    /*
    |--------------------------------------------------------------------------
    | ODK Central User Email
    |--------------------------------------------------------------------------
    |
    | The user email should be in the .env file
    |
    */
    'user_email' => env('ODK_USER_EMAIL', 'test@test.fr'),


    /*
    |--------------------------------------------------------------------------
    | ODK Central User Password
    |--------------------------------------------------------------------------
    |
    | The user password should be in the .env file
    |
    */
    'user_password' => env('ODK_USER_PASSWORD', '123456'),


];