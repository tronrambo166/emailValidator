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

class Route
{
    protected $path;
    protected $controller;
    protected $requirements;
    protected $packNames;

    public function __construct($path, $controller, $requirements, array $packNames)
    {
        $this->setPath($path);
        $this->setController($controller);
        $this->setRequirements($requirements);
        $this->setPackNames($packNames);
    }

    public function hasRequirements()
    {
        return !empty($this->requirements);
    }

    public function match($path)
    {
        return preg_match('`^'.$this->path.'$`', $path, $matches) ? $matches : false;
    }

    public function setController($controller)
    {
        if (is_string($controller)) {
            $this->controller = $controller;
        }
    }

    public function setPath($path)
    {
        if (is_string($path)) {
            $this->path = $path;
        }
    }

    public function setRequirements($requirements)
    {
        if (is_string($requirements)) {
            $this->requirements = $requirements;
        }
    }

    public function setPackNames(array $packNames)
    {
        $this->packNames = $packNames;
    }

    public function controller()
    {
        return $this->controller;
    }

    public function requirements()
    {
        return $this->requirements;
    }

    public function packNames()
    {
        return $this->packNames;
    }
}
