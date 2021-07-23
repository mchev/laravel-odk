<?php

namespace Mchev\LaravelOdk;

class OdkCentral
{


    private $api;


    public function __construct()
    {
        $this->api = new OdkCentralRequest;
    }


    /**
     * Get the list of users.
     *
     * @param string $q
     * @return PendingRequest
     */
    public function users($q = null)
    {
        $endpoint = '/users';

        $params = [
            'q' => $q
        ];

        return $this->api->get($endpoint, $params);

    }


    /**
     * Create a new user.
     *
     * @param string $q
     * @return PendingRequest
     */
    public function createUser(string $email, string $password = null)
    {
        $endpoint = '/users';

        $params = [
            'email' => $email,
            'password' => $password,
        ];

        return $this->api->post($endpoint, $params);

    }


    /**
     * Get the list of roles.
     *
     * @param string $q
     * @return Response
     */
    public function roles($q = null)
    {
        $endpoint = '/roles';

        return $this->api->get($endpoint);

    }


    /**
     * Get the list of projects.
     *
     * @return PendingRequest
     */
    public function projects($q = null)
    {
        $endpoint = '/projects';
        $request = new OdkCentralRequest;
        return $request->get($endpoint);

    }

    /**
     * Get Spotify catalog information for multiple albums identified by their Spotify IDs.
     *
     * @param string $q
     * @return PendingRequest
     */
    public function forms($projectId)
    {
        $endpoint = '/projects/' . $projectId . '/forms';

        $method = 'get';

        $params = [
            'projectId' => $projectId,
        ];

        return new OdkCentralRequest($method, $endpoint, $params);
    }


}
