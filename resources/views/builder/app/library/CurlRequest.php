<?php

/**
 * This file is part of Berevi Collection applications.
 *
 * (c) Alan Da Silva
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or on Codecanyon
 *
 * @see https://codecanyon.net/licenses/terms/regular
 */

namespace app\library;

class CurlRequest implements CurlRequestInterface
{
    public $init;
    public $token;
    public $authorization;
    public $contentType;
    public $method;
    public $return;
    public $follow;

    /**
     * Constructor.
     *
     * @param string  $init          - The POST parameter
     * @param string  $token         - The access token key
     * @param string  $authorization - The authorization type (header)
     * @param string  $contentType   - The CONTENT TYPE parameter (header)
     * @param string  $method        - The METHOD parameter
     * @param boolean $return        - The RETURN parameter (waiting for an answer)
     * @param integer $follow        - The FOLLOW parameter
     *
     * @api
     */
    public function __construct($init, $token, $authorization = "Bearer", $contentType = "application/json", $method = "GET", $return = true, $follow = 1)
    {
        $this->initialize($init, $token, $authorization, $contentType, $method, $return, $follow);
    }

    /**
     * Sets the parameters for this request.
     *
     * This method also pre-set all properties except for init and token.
     *
     * @param string  $init          - The POST parameter
     * @param string  $token         - The access token key
     * @param string  $authorization - The authorization type (header)
     * @param string  $contentType   - The CONTENT TYPE parameter (header)
     * @param string  $method        - The METHOD parameter
     * @param boolean $return        - The RETURN parameter (waiting for an answer)
     * @param integer $follow        - The FOLLOW parameter
     *
     * @api
     */
    public function initialize($init, $token, $authorization = "Bearer", $contentType = "application/json", $method = "GET", $return = true, $follow = 1)
    {
        $this->init = $init;
        $this->token = $token;
        $this->authorization = $authorization;
        $this->contentType = $contentType;
        $this->method = $method;
        $this->return = $return;
        $this->follow = $follow;
    }

    /**
     * @return string
     */
    public function init()
    {
        return $this->init;
    }

    /**
     * @return string
     */
    public function token()
    {
        return $this->token;
    }

    /**
     * @param string $default
     * @return mixed
     */
    public function authorization($default = "Bearer")
    {
        return isset($this->authorization) ? $this->authorization : $default;
    }

    /**
     * @param string $default
     * @return mixed
     */
    public function contentType($default = "application/json")
    {
        return isset($this->contentType) ? $this->contentType : $default;
    }

    /**
     * @param string $default
     * @return mixed
     */
    public function method($default = "GET")
    {
        return isset($this->method) ? $this->method : $default;
    }

    /**
     * @param boolean $default
     * @return bool true|false
     */
    public function return($default = true)
    {
        return isset($this->return) ? $this->return : $default;
    }

    /**
     * @param integer $default
     * @return int
     */
    public function follow($default = 1)
    {
        return isset($this->follow) ? $this->follow : $default;
    }

    /**
     * Returns the request body content.
     *
     * @return string|resource - The request body content or a resource to read the body stream.
     */
    public function getRequest()
    {
        $ch = curl_init($this->init);
        $authorization = "Authorization: ".$this->authorization." ".$this->token;
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER      => ['Content-Type: '.$this->contentType, $authorization],
            CURLOPT_CUSTOMREQUEST   => $this->method,
            CURLOPT_RETURNTRANSFER  => $this->return,
            CURLOPT_FOLLOWLOCATION  => $this->follow
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $results = json_decode($result);

        return $results;
    }
}
