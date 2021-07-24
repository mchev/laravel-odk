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

        $this->endpoint = '';

        $this->params = [];
    }


    /**
     * Get the list of users.
     *
     * @param string|int $q
     * @return $this
     */
    public function users($q = null)
    {

        $this->endpoint .= (is_int($q)) ? '/users/' . $q : '/users';

        $this->params = [
            'q' => $q,
        ];

        return $this;

    }

    /**
     * Get the list of App Users.
     *
     * @param string|int $q
     * @return $this
     */
    public function appUsers($q = null)
    {

        $this->endpoint .= (is_int($q)) ? '/app-users/' . $q : '/app-users';

        $this->params = [
            'q' => $q,
        ];

        return $this;

    }

    /**
     * Get the list of roles.
     *
     * @param string|int $q
     * @return $this
     */
    public function roles($q = null)
    {

        $this->endpoint .= (is_int($q)) ? '/roles/' . $q : '/roles';

        $this->params = [
            'q' => $q,
        ];

        return $this;

    }

    /**
     * Get the list of projects.
     *
     * @param string|int $q
     * @return $this
     */
    public function projects($q = null)
    {

        $this->endpoint .= (is_int($q)) ? '/projects/' . $q : '/projects';

        $this->params = [
            'q' => $q,
        ];

        return $this;

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
     * Updating the current item based on endpoint.
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
     * Deep Updating.
     *
     * @param array $params
     * @return collection
     */
    public function deepUpdate(array $params)
    {

        $this->params = $params;

        return $this->put();

    }

    /**
     * Updating the user password.
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
     * Initiating a password reset.
     *
     * @param string $email
     * @return Object $user
     */
    public function passwordReset($email)
    {

        $this->endpoint .= '/reset/initiate?invalidate=true';

        $this->params = [
            'email' => $email
        ];

        return $this->post();

    }

    /**
     * Getting authentificated User details.
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
     * Enabling Project Managed Encryption
     *
     * @param array $params
     * @return $this
     */
    public function encrypt($params)
    {

        $this->endpoint  .= '/key';

        $this->params = $params;

        return $this->post();

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
