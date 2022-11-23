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

class Managers
{
    protected $api = null;
    protected $dao = null;
    protected $request;
    protected $managers = [];

    public function __construct($api, $dao)
    {
        $this->api = $api;
        $this->dao = $dao;
        $this->request = new HTTPRequest;
    }

    public function getManagerOf($repository)
    {
        if (!is_string($repository) || empty($repository)) {
            throw new \InvalidArgumentException('The specified repository is invalid');
        }

        if (!isset($this->managers[$repository])) {
            $appConfig = new \app\config\AppConfig('routes');
            foreach ($appConfig->appRoutes() as $controller) {
                $lastVar = explode("/", $this->request->requestURI());
                if ($controller["path"] == $this->request->requestURI()) {
                    $caught["controller"] = $controller["controller"];
                }
            }

            $module = explode(":", $caught["controller"]);
            $manager = '\\src\\'.$module[0].'\\Repository\\'.$repository.$this->api;
            if (!file_exists(__DIR__.'/../../'.$manager.".php")) {
                throw new \InvalidArgumentException("The specified repository does not exist");
            }

            $this->managers[$repository] = new $manager($this->dao);
        }

        return $this->managers[$repository];
    }
}
