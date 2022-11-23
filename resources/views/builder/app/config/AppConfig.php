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

namespace app\config;

use \app\Controller\RouteController;
use \app\library\Routing;

final class AppConfig extends Routing
{
    /**
     * Build object AppConfig.
     *
     * @param string $filename The name of the main file containing the routes
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Retrieves the paths only from the routes.
     *
     * @param void
     * @return void
     */
    public function appRoutesPath()
    {
        $file = __DIR__."/data/".$this->filename.".php";
        if (!file_exists($file)) {
            throw new \RuntimeException('The routes file does not exist');
        }

        ob_start();

        require $file;

        foreach ($packs as $appRoute) {
            $routes[] = $appRoute["path"];
        }

        return ob_get_clean();
    }

    /**
     * Displays routes entirely from all packs if they exist.
     *
     * @return array The routes and their configurations
     */
    public function appRoutes()
    {
        $file = __DIR__."/data/".$this->filename.".php";
        if (!file_exists($file)) {
            throw new \RuntimeException('The routes file does not exist');
        }

        $appPath = $this->getAppPath();

        require $file;
        if (!empty($this->routingExists())) {
            $packs = array_merge($packs, $this->loadRouting());
        }

        return $packs;
    }
}
