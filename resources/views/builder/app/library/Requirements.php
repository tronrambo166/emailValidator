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

class Requirements extends HTTPRequest
{
    /**
     * Allowing or not the processing of $_GET variables.
     *
     * @param $action The controller action name
     * @param $requirements Regular expressions (REGEX)
     *
     * @return bool true|false
     */
    public function httpGetAutorization($action, $requirements)
    {
        if (!empty($requirements)) {
            $requirements = explode("||", $requirements);
            if (count($requirements) >= 1) {
                foreach ($requirements as $value) {
                    $vars[] = $value;
                }
            }

            $requirements = array_filter($vars);
            foreach ($requirements as $key => $value) {
                $key % 2 == 0 ? $array[] = $value."::" : $array[] = $value."||";
            }

            $build = $array;
            $separated = implode("", $build);
            $varsAndRequirements = array_filter(explode("||", $separated));
            $validated = [];
            foreach ($varsAndRequirements as $varsID) {
                $data = explode("::", $varsID);
                $uri = explode("/", $this->requestURI());
                $uri = end($uri);
                if ($uri != $action) {
                    preg_match("/".$data[1]."/", $uri) ? $validated[] = 1 : $validated[] = 0;
                }
            }

            return array_sum($validated) >= 1 ? true : false;
        }

        return false;
    }
}
