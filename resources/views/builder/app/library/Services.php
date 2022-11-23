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

class Services implements ServiceInterface
{
    public function logEncryption()
    {
        if (!is_object($this->loadServices()->logEncryption)) {
            throw new \Exception("The class does not exist.");
        }

        return $this->loadServices()->logEncryption;
    }

    public function loadServices()
    {
        $object = new \stdClass();
        if ($this->serviceExists()) {
            foreach ($this->serviceExists() as $className => $service) {
                $getClass = explode("\\", $service);
                $logEncryption = end($getClass);
                $className = lcfirst($logEncryption);
                $object->$className = new $service;
            }

            return $object;
        }
    }

    public function serviceExists()
    {
        $i = 0;
        foreach (glob(__DIR__.'/../../src/*', GLOB_ONLYDIR) as $dir) {
            $dirname[] = basename($dir);
            $directory = __DIR__.'/../../src/'.$dirname[$i]."/Services";
            if (is_dir($directory)) {
                $filesInDirectory = scandir($directory);
                $itemsCount = count($filesInDirectory);
                // More than one class
                if ($itemsCount > 3) {
                    if ($handle = opendir($directory)) {
                        $oo = [];
                        while (false !== ($entry = readdir($handle))) {
                            if ($entry != "." && $entry != "..") {
                                $service = substr("src\\".$dirname[$i]."\\Services\\".$entry, 0, -4);
                                $oo[] = $service;
                            }
                        }

                        closedir($handle);
                    }

                    $results1[] = $oo;
                }
                // One class only
                elseif ($itemsCount == 3) {
                    if ($handle = opendir($directory)) {
                        $oo = [];
                        while (false !== ($entry = readdir($handle))) {
                            if ($entry != "." && $entry != "..") {
                                $service = substr("src\\".$dirname[$i]."\\Services\\".$entry, 0, -4);
                                $oo[] = $service;
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
