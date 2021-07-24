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

        $this->endpoint = (is_int($q)) ? '/users/' . $q : '/users';

        $this->params = [
            'q' => $q,
        ];

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

        $this->params = $params;

        return $this->patch();

    }

    /**
     * Update the user password.
     *
     * @param array $params
     * @return Object $user
     */
    public function updatePassword(array $params)
    {

        $this->endpoint  .= '/password';

        $this->params = $params;

        return $this->put();

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
     * Assign a user role.
     *
     * @param integer $roleId
     * @return $this
     */
    public function assignRole($roleId)
    {

        $this->endpoint  .= '/' . $roleId;

        return $this->post();

    }

    /**
     * Remove a user role.
     *
     * @param integer $roleId
     * @return $this
     */
    public function removeRole($roleId)
    {

        $this->endpoint  .= '/' . $roleId;

        return $this->delete();

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

        return $this->api->get($this->endpoint, $this->params);

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

        return $this->api->post($this->endpoint, $this->params);

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

        return $this->api->patch($this->endpoint, $this->params);

    }

    /**
     * Create a new patch request.
     *
     * @param string $this->endpoint
     * @param array $this->params
     * @return collection
     */
    public function put()
    {

        return $this->api->put($this->endpoint, $this->params);

    }

    /**
     * Create a new delete request.
     *
     * @param string $this->endpoint
     * @param array $this->params
     * @return collection
     */
    public function delete()
    {

        return $this->api->delete($this->endpoint, $this->params);

    }


}
