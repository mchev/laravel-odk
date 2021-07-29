<?php

namespace Mchev\LaravelOdk;

class OdkCentral
{


    private $api;

    private $endpoint;

    private $params;

    private $headers;

    private $file;


    public function __construct()
    {
        $this->api = new OdkCentralRequest;

        $this->endpoint = '';

        $this->params = [];

        $this->headers = [];

        $this->file = null;

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

        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

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
     * Set the assignements endpoint.
     *
     * @param int $id
     * @return $this
     */
    public function assignements($id = null)
    {

        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->endpoint .= (is_int($id)) ? '/assignements/' . $id : '/assignements';

        $this->params = [
            'id' => $id,
        ];

        return $this;

    }

    /**
     * Set the submissions endpoint.
     *
     * @param string|int $id
     * @return $this
     */
    public function submissions($id = null)
    {

        $this->endpoint .= (!is_null($id)) ? '/submissions/' . $id : '/submissions';

        $this->params = [
            'id' => $id,
        ];

        return $this;

    }

    /**
     * Set the comments endpoint.
     *
     * @return $this
     */
    public function comments()
    {

        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->endpoint .= '/comments';

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

        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->endpoint .= (is_int($q)) ? '/projects/' . $q : '/projects';

        $this->params = [
            'q' => $q,
        ];

        return $this;

    }

    /**
     * Forms endpoint.
     *
     * @param string|int $id
     * @return $this
     */
    public function forms($id = null)
    {

        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->endpoint .= (!is_null($id)) ? '/forms/' . $id : '/forms';

        $this->params = [
            'xmlFormId' => $id,
        ];

        return $this;

    }

    /**
     * Versions endpoint.
     * TODO : documentation
     *
     * @param string|int $id
     * @return $this
     */
    public function versions($id = null)
    {

        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->endpoint .= (!is_null($id)) ? '/versions/' . $id : '/versions';

        return $this;

    }

    /**
     * Assignments endpoint.
     * TODO : documentation
     *
     * @param string|int $id
     * @return $this
     */
    public function assignments($id = null)
    {

        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->endpoint .= (!is_null($id)) ? '/assignments/' . $id : '/assignments';

        return $this;

    }

    /**
     * Fields endpoint.
     *
     * @param boolean $odata
     * @return $this
     */
    public function fields($odata = false)
    {

        $this->endpoint .= '/fields';

        $this->params = [
            'odata' => $odata,
        ];

        return $this;

    }

    /**
     * Attachments endpoint.
     *
     * @return $this
     */
    public function attachments()
    {

        $this->endpoint .= '/attachments';

        return $this;

    }

    /**
     * Attachments endpoint.
     *
     * @param string $filename
     * @return $this
     */
    public function downloadAttachment(string $filename)
    {

        $this->endpoint .= '/attachments/' . $filename;

        return $this->download();

    }

    /**
     * Create method is passing params to the request and then post it.
     *
     * @param array $params
     * @return collection
     */
    public function create(array $params, $file = null)
    {

        $this->params = $params;

        if(!is_null($file)) {

            $this->endpoint .= '?ignoreWarnings=true&formId=testtest';

            $this->headers = [
                'Content-Type' => $file->getMimeType(),
                'X-XlsForm-FormId-Fallback' => $file->getClientOriginalName(),
            ];

            $this->file = $file;

        }

        return $this->post();

    }

    /**
     * Create method is passing params to the request and then post it.
     *
     * @param $params
     * @return collection
     */
    public function import($form, $ignoreWarnings = false, $publish = false)
    {

        $this->headers = [
            'Content-Type' => 'application/xml',
        ];

        $this->params = $form;

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
     * Set the submissions xml endpoint.
     *
     * @return $this
     */
    public function xml()
    {

        $this->endpoint .= '.xml';

        return $this->download();

    }

    /**
     * Set the submissions xls endpoint.
     *
     * @return $this
     */
    public function xls()
    {

        $this->endpoint .= '.xls';

        return $this->download();

    }

    /**
     * Set the submissions xlsx endpoint.
     *
     * @return $this
     */
    public function xlsx()
    {

        $this->endpoint .= '.xlsx';

        return $this->download();

    }

    /**
     * Set the submissions xml endpoint.
     *
     * @return $this
     */
    public function svc()
    {

        $this->headers = [
            'Content-Type' => 'application/json',
        ];

        $this->endpoint .= '.svc';

        $this->params = [];

        return $this->get();

    }

    /**
     * Set the odata Data document endpoint.
     * TODO : documentation
     *
     * @return $this
     */
    public function data($table)
    {

        $this->headers = [
            'Content-Type' => 'application/json',
        ];

        $this->endpoint .= '.svc/' . $table;

        return $this;

    }


    /**
     * Create a new get request.
     *
     * @param string $this->endpoint
     * @param array $this->params
     * @param array $this->headers
     * @return collection
     */
    public function get($endpoint = '')
    {

        $this->endpoint .= $endpoint;

        return $this->api->get($this->endpoint, $this->params, $this->headers);

    }

    /**
     * Create a new get raw request.
     *
     * @param string $this->endpoint
     * @param array $this->params
     * @param array $this->headers
     * @return collection
     */
    public function getBody()
    {

        return $this->api->getBody($this->endpoint, $this->params, $this->headers);

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

        return $this->api->post($this->endpoint, $this->params, $this->file);

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

    /**
     * Create a new download request.
     *
     * @param string $this->endpoint
     * @param array $this->params
     * @return collection
     */
    public function download()
    {

        return $this->api->download($this->endpoint, $this->params);

    }


}
