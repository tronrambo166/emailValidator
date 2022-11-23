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

class Routing extends HTTPRequest implements RoutingInterface
{
    public function loadRouting()
    {
        if ($this->routingExists()) {
            $packages = [];
            $appPath = $this->getAppPath();
            foreach ($this->routingExists() as $routing) {
                $file = explode("src\\", $routing);
                $pack = explode("\\Resources\\config", $file[1]);
                $routing = substr($pack[1], 1);
                $file = $this->documentRoot().$this->getAppPath()."/../src/".$pack[0]."/Resources/config/".$routing.".php";
                if (file_exists($file)) {
                    require $file;
                }

                if (empty($packs)) {
                    $packs = [];
                }

                $packages[] = $packs;
            }

            return call_user_func_array('array_merge', $packages);
        }
    }

    public function routingExists()
    {
        $i = 0;
        foreach (glob(__DIR__.'/../../src/*', GLOB_ONLYDIR) as $dir) {
            $dirname[] = basename($dir);
            $directory = __DIR__.'/../../src/'.$dirname[$i]."/Resources/config/";
            if (is_dir($directory)) {
                $filesInDirectory = scandir($directory);
                $itemsCount = count($filesInDirectory);
                // More than one routing file
                if ($itemsCount > 3) {
                    if ($handle = opendir($directory)) {
                        $oo = [];
                        while (false !== ($entry = readdir($handle))) {
                            if ($entry != "." && $entry != "..") {
                                $package = substr("src\\".$dirname[$i]."\\Resources\\config\\".$entry, 0, -4);
                                $oo[] = $package;
                            }
                        }

                        closedir($handle);
                    }

                    $results1[] = $oo;
                }
                // One routing file only
                elseif ($itemsCount == 3) {
                    if ($handle = opendir($directory)) {
                        $oo = [];
                        while (false !== ($entry = readdir($handle))) {
                            if ($entry != "." && $entry != "..") {
                                $package = substr("src\\".$dirname[$i]."\\Resources\\config\\".$entry, 0, -4);
                                $oo[] = $package;
                            }
                        }

                        closedir($handle);
                    }

                    $results2[] = $oo;
                }
            }

            $i++;
        }

        !empty($results1) ? $flat1 = call_user_func_array('array_merge', $results1) : $flat1 = [];
        !empty($results2) ? $flat2 = call_user_func_array('array_merge', $results2) : $flat2 = [];

        $results = array_merge($flat1, $flat2);

        return $results;
    }
}
