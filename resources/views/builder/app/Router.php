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

namespace app;

class Router
{
    const NO_ROUTE = 1;

    protected $routes = [];

    public function addRoute(library\Route $route)
    {
        if (!in_array($route, $this->routes)) {
            $this->routes[] = $route;
        }
    }

    public function getRoute($path)
    {
        foreach ($this->routes as $route) {
            if (($varsValues = $route->match($path)) !== false) {
                if ($route->hasRequirements()) {
                    $varsNames = $route->packNames();
                    $listVars = [];
                    foreach ($varsValues as $key => $match) {
                        if ($key !== 0) {
                            $listVars[$varsNames[$key - 1]] = $match;
                        }
                    }

                    $route->setRequirements($listVars);
                }

                return $route;
            }
        }

        throw new \RuntimeException('No route matches the URL', self::NO_ROUTE);
    }
}
