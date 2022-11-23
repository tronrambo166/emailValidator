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

use app\KernelComponent;

class Controller extends KernelComponent
{
    protected $call;
    protected $view;
    protected $request;
    protected $response;
    protected $managers = null;
    protected $dataEngine;
    protected $services;
    protected $security;

    public function __construct($call)
    {
        $this->setCall($call);
        $this->view = new View;
        $this->request = new HTTPRequest;
        $this->response = new HTTPResponse;
        $this->managers = new Managers('Repository', PDOFactory::getMysqlConnexion());
        $this->dataEngine = new DataEngine;
        $this->services = new Services;
        $this->security = new Security;
    }

    public function setCall($call)
    {
        if (is_string($call)) {
            $this->call = $call;
        }
    }

    public function call()
    {
        return $this->call;
    }
}
