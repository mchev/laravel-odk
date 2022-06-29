<?php

namespace Mchev\LaravelOdk;

class OdkCentral
{
    public $api;

    public $projectId;

    public $xmlFormId;

    public $submissionId;

    public $endpoint;

    private $params;

    private $headers;

    private $file;

    public function __construct()
    {
        $this->api = new OdkCentralRequest;

        $this->projectId = null;

        $this->xmlFormId = null;

        $this->submissionId = null;

        $this->endpoint = '';

        $this->params = [];

        $this->headers = [];

        $this->file = null;
    }

    /**
     * Get the list of users.
     *
     * @param  string|int  $q
     * @return $this
     */
    public function users($q = null)
    {
        $this->endpoint .= (is_int($q)) ? '/users/'.$q : '/users';

        $this->params = [
            'q' => $q,
        ];

        return $this;
    }

    /**
     * Get the list of App Users.
     *
     * @param  string|int  $q
     * @return $this
     */
    public function appUsers($q = null)
    {
        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->endpoint .= (is_int($q)) ? '/app-users/'.$q : '/app-users';

        $this->params = [
            'q' => $q,
        ];

        return $this;
    }

    /**
     * Get the list of roles.
     *
     * @param  string|int  $q
     * @return $this
     */
    public function roles($q = null)
    {
        $this->endpoint .= (is_int($q)) ? '/roles/'.$q : '/roles';

        $this->params = [
            'q' => $q,
        ];

        return $this;
    }

    /**
     * Set the assignements endpoint.
     *
     * @param  int  $id
     * @return $this
     */
    public function assignements($id = null)
    {
        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->endpoint .= (is_int($id)) ? '/assignements/'.$id : '/assignements';

        $this->params = [
            'id' => $id,
        ];

        return $this;
    }

    /**
     * Set the submissions endpoint.
     *
     * @param  string|int  $id
     * @return $this
     */
    public function submissions($id = null)
    {
        $this->submissionId = (! is_null($id)) ? $id : null;

        $formEndpoint = '/projects/'.$this->projectId.'/forms/'.$this->xmlFormId;

        $submissionsEndpoint = ($this->submissionId) ? '/submissions/'.$this->submissionId : '/submissions';

        $this->endpoint = $formEndpoint.$submissionsEndpoint;

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
     * @param  string|int  $q
     * @return $this
     */
    public function projects($q = null)
    {
        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->projectId = (is_int($q)) ? $q : null;

        $this->endpoint .= ($this->projectId) ? '/projects/'.$this->projectId : '/projects';

        $this->params = [
            'q' => $q,
        ];

        return $this;
    }

    /**
     * Forms endpoint.
     *
     * @param  string|int  $id
     * @return $this
     */
    public function forms($id = null)
    {
        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->xmlFormId = (! is_null($id)) ? $id : null;

        $this->endpoint .= ($this->xmlFormId) ? '/forms/'.$this->xmlFormId : '/forms';

        $this->params = [
            'xmlFormId' => $id,
            'formId' => $id,
        ];

        return $this;
    }

    /**
     * Draft endpoint.
     *
     * @param  string|int  $id
     * @return $this
     */
    public function draft($id = null)
    {
        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->endpoint .= (! is_null($id)) ? '/draft/'.$id : '/draft';

        return $this;
    }

    /**
     * Versions endpoint.
     * TODO : documentation
     *
     * @param  string|int  $id
     * @return $this
     */
    public function versions($id = null)
    {
        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->endpoint .= (! is_null($id)) ? '/versions/'.$id : '/versions';

        return $this;
    }

    /**
     * Assignments endpoint.
     * TODO : documentation
     *
     * @param  string|int  $id
     * @return $this
     */
    public function assignments($id = null)
    {
        $this->headers = [
            'X-Extended-Metadata' => 'true',
        ];

        $this->endpoint .= (! is_null($id)) ? '/assignments/'.$id : '/assignments';

        return $this;
    }

    /**
     * Fields endpoint.
     *
     * @param  bool  $odata
     * @return $this
     */
    public function fields($odata = false)
    {
        $this->endpoint .= '/fields?odata='.$odata;

        return $this->get();
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
     * @param  string  $filename
     * @return $this
     */
    public function downloadAttachment(string $filename)
    {
        $this->endpoint .= '/attachments/'.$filename;

        return $this->download();
    }

    /**
     * Create method is passing params to the request and then post it.
     *
     * @param  file  $file
     * @param  bool  $publish
     * @param  bool  $ignoreWarnings
     * @return collection
     */
    public function create($file = null, $publish = false, $ignoreWarnings = false)
    {
        if (! is_null($file)) {
            $this->endpoint .= '?ignoreWarnings='.$ignoreWarnings.'&publish='.$publish;

            $this->headers = [
                'Content-Type' => $file->getMimeType(),
                'X-XlsForm-FormId-Fallback' => urlencode($file->getClientOriginalName()),
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
     * @param  array  $params
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
     * @param  array  $params
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
     * @param  array  $params
     * @return object $user
     */
    public function updatePassword(array $params)
    {
        $this->endpoint .= '/password';

        $this->params = $params;

        return $this->put();
    }

    /**
     * Initiating a password reset.
     *
     * @param  string  $email
     * @return object $user
     */
    public function passwordReset($email)
    {
        $this->endpoint .= '/reset/initiate?invalidate=true';

        $this->params = [
            'email' => $email,
        ];

        return $this->post();
    }

    /**
     * Getting authentificated User details.
     *
     * @param  int  $actorId
     * @return $this
     */
    public function current()
    {
        $this->endpoint .= '/current';

        return $this->get();
    }

    /**
     * Getting authentificated User details.
     *
     * @param  string  $version
     * @return $this
     */
    public function publish(string $version = '')
    {
        $this->endpoint .= '/publish?version='.$version;

        return $this->post();
    }

    /**
     * Assign a user role.
     *
     * @param  int  $roleId
     * @return $this
     */
    public function assignRole($roleId)
    {
        $this->endpoint .= '/'.$roleId;

        return $this->post();
    }

    /**
     * Remove a user role.
     *
     * @param  int  $roleId
     * @return $this
     */
    public function removeRole($roleId)
    {
        $this->endpoint .= '/'.$roleId;

        return $this->delete();
    }

    /**
     * Enabling Project Managed Encryption
     *
     * @param  array  $params
     * @return $this
     */
    public function encrypt($params)
    {
        $this->endpoint .= '/key';

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

        return $this;
    }

    /**
     * Set the submissions xls endpoint.
     *
     * @return $this
     */
    public function xls()
    {
        $this->endpoint .= '.xls';

        return $this;
    }

    /**
     * Set the submissions xlsx endpoint.
     *
     * @return $this
     */
    public function xlsx()
    {
        $this->endpoint .= '.xlsx';

        return $this;
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
     * Getting forms answers.
     *
     * @return $odata
     */
    public function answers()
    {
        $url = ($this->submissionId) ? "Submissions('".$this->submissionId."')" : 'Submissions';

        $odata = $this->odata($url)->get();

        return $odata;
    }

    /*
    * Getting submissions data (answers)
    * OdkCentral::project($projectId)->form($xmlFormId)->submissions($uuid)->data();
    *
    * @param boolean $format
    * @return array $values
    */
    public function answersWithRepeats($format = false)
    {
        $answers = $this->answers();

        if (isset($answers->value)) {
            $values = $answers->value[0];

            $values = $this->fetchRepeatTable($values);

            return ($format) ? $this->format($values) : $values;
        }

        return null;
    }

    /**
     * OData request.
     *
     * @param  string  $url
     * @param  bool  $top
     * @param  bool  $skip
     * @param  bool  $count
     * @param  bool  $wkt
     * @param  string  $filter
     * @param  bool  $expand
     * @return $this
     */
    public function odata($url = '', $top = false, $skip = false, $count = false, $wkt = false, $filter = '', $expand = false)
    {
        $top = ($top === 0 || is_null($top)) ? '' : $top;
        $skip = ($skip === 0 || is_null($skip)) ? '' : $skip;
        $expand = ($expand) ? '&#42;' : '';

        $base = '/projects/'.$this->projectId.'/forms/'.$this->xmlFormId;

        $this->headers = [
            'Content-Type' => 'application/json',
        ];

        $this->endpoint = $base.'.svc/'.$url.'?%24top='.$top.'&%24skip='.$skip.'&%24count='.$count.'&%24wkt='.$wkt.'&%24filter='.$filter.'&%24expand='.$expand;

        $this->params = [];

        return $this;
    }

    public function fetchRepeatTable($data)
    {
        foreach ($data as $key => $value) {
            if (is_object($value)) {
                $this->fetchRepeatTable($value);
            } else {
                if (str_contains($key, '@odata.navigationLink')) {
                    $newKey = str_replace('@odata.navigationLink', '', $key);

                    unset($data->$key);

                    $newValue = $this->odata($value)->get()->value;

                    if (is_array($newValue)) {
                        foreach ($newValue as $k => $v) {
                            $newK = $newKey.'_'.$k;
                            unset($newValue[$k]);
                            $newValue[$newK] = $this->fetchRepeatTable($v);
                        }

                        $data->$newKey = (object) $newValue;
                    } else {
                        $data->$newKey = $this->fetchRepeatTable($this->odata($value)->get()->value);
                    }
                }
            }
        }

        return $data;
    }

    public function format($data)
    {
        foreach ($data as $key => $value) {
            if (substr($key, 0, 2) === '__' || $key === 'meta') {
                unset($data->$key);
            } else {
                if (is_object($value) || is_array($value)) {
                    $this->format($value);
                } else {

                    //$data->$key->question_name = $key;
                    //$data->$key->value = $value;
                }
            }
        }

        return $data;
    }

    /**
     * Create a new get request.
     *
     * @param  string  $this->endpoint
     * @param  array  $this->params
     * @param  array  $this->headers
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
     * @param  string  $this->endpoint
     * @param  array  $this->params
     * @param  array  $this->headers
     * @return collection
     */
    public function getBody()
    {
        return $this->api->getBody($this->endpoint, $this->params, $this->headers);
    }

    /**
     * Create a new post request.
     *
     * @param  string  $this->endpoint
     * @param  array  $this->params
     * @param  array  $this->headers
     * @param  object  $this->file
     * @return collection
     */
    public function post()
    {
        return $this->api->post($this->endpoint, $this->params, $this->headers, $this->file);
    }

    /**
     * Create a new patch request.
     *
     * @param  string  $this->endpoint
     * @param  array  $this->params
     * @param  array  $this->headers
     * @return collection
     */
    public function patch()
    {
        return $this->api->patch($this->endpoint, $this->params, $this->headers);
    }

    /**
     * Create a new patch request.
     *
     * @param  string  $this->endpoint
     * @param  array  $this->params
     * @param  array  $this->headers
     * @return collection
     */
    public function put()
    {
        return $this->api->put($this->endpoint, $this->params, $this->headers);
    }

    /**
     * Create a new delete request.
     *
     * @param  string  $this->endpoint
     * @param  array  $this->params
     * @param  array  $this->headers
     * @return collection
     */
    public function delete()
    {
        return $this->api->delete($this->endpoint, $this->params, $this->headers);
    }

    /**
     * Create a new download request.
     *
     * @param  string  $this->endpoint
     * @param  array  $this->params
     * @param  array  $this->headers
     * @return collection
     */
    public function download()
    {
        return $this->api->download($this->endpoint, $this->params, $this->headers);
    }
}
