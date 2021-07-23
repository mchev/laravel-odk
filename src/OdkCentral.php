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

        $this->params = [];
    }


    /**
     * Get the list of users.
     *
     * @return $this
     */
    public function users($q = null)
    {

        $this->endpoint = '/users';

        $this->params = [
            'q' => $q,
        ];

        return $this->get();

    }


    /**
     * Get the list of users.
     *
     * @return $this
     */
    public function user()
    {

        $this->endpoint = '/users';

        return $this;

    }


    /**
     * Get the list of roles.
     *
     * @param string $q
     * @return Response
     */
    public function roles()
    {
        $this->endpoint = '/roles';

        return $this->get();

    }


    /**
     * Get the list of projects.
     *
     * @return PendingRequest
     */
    public function projects()
    {
        $this->endpoint = '/projects';

        return $this->get();

    }

    /**
     * Adding query in parameters.
     *
     * @param string $q
     * @return $this
     */
    public function search()
    {

        return $this;

    }

    /**
     * Adding query in parameters.
     *
     * @param integer $actorId
     * @return $this
     */
    public function find(int $actorId)
    {

        $this->endpoint .= "/" . $actorId;

        $this->params = [
            'actorId' => $actorId,
        ];

        return $this->get();

    }

    /**
     * Create method is passing params to the request and then post it.
     *
     * @param array $params
     * @return collection
     */
    public function create(array $params)
    {

        $this->params = $params;

        return $this->post();

    }

    /**
     * Create method is passing params to the request and then post it.
     *
     * @param array $params
     * @return collection
     */
    public function update(array $params)
    {

        $this->endpoint .= "/" . $params['userId'];

        $this->params = [
            'actorId' => $params['userId'],
            'displayName' => $params['displayName'],
            'email' => $params['email'],
        ];

        return $this->patch();

    }

    /**
     * Adding query in parameters.
     *
     * @param integer $actorId
     * @return $this
     */
    public function current()
    {

        $this->endpoint  .= '/current';

        return $this->get();

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

        $response = $this->api->get($this->endpoint, $this->params);

        return $response;

    }

    /**
     * Create a new post request.
     *
     * @param string $this->endpoint
     * @param array $this->params
     * @return collection
     */
    public function post()
    {

        $response = $this->api->post($this->endpoint, $this->params);

        return $response;

    }


    /**
     * Create a new patch request.
     *
     * @param string $this->endpoint
     * @param array $this->params
     * @return collection
     */
    public function patch()
    {

        $response = $this->api->patch($this->endpoint, $this->params);

        return $response;

    }


}
