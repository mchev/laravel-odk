<?php

namespace Mchev\LaravelOdk;

class OdkCentral
{


    private $api;

    private $endpoint;

    private $params;


    public function __construct()
    {
        $this->api = new OdkCentralRequest();

        $this->endpoint = null;

        $this->params = null;
    }


    /**
     * Get the list of users.
     *
     * @param string $q
     * @return PendingRequest
     */
    public function users($q = null)
    {

        $this->endpoint = '/users';

        $this->params = [
            'q' => $q
        ];

        return $this;

    }


    /**
     * Create a new user.
     *
     * @param string $q
     * @return PendingRequest
     */
    public function createUser(string $email, string $password = null)
    {

        $this->endpoint = '/users';

        $this->params = [
            'email' => $email,
            'password' => $password,
        ];

        $request = new OdkCentralRequest();
        $response = $request->post($this->endpoint, $this->params);

        return $response;

    }


    /**
     * Get the list of roles.
     *
     * @param string $q
     * @return Response
     */
    public function roles($q = null)
    {
        $this->endpoint = '/roles';

        return $this;

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
     * Create a new get request.
     *
     * @param string $this->endpoint
     * @param array $this->params
     * @return collection
     */
    public function get()
    {

        $request = new OdkCentralRequest();
        $response = $request->get($this->endpoint, $this->params);

        return $response;

    }


}
