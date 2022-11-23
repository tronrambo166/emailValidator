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

class Variables extends HTTPRequest
{
    public function getVariables($httpGetAutorization)
    {
        $isGet = (int) filter_var($httpGetAutorization, FILTER_VALIDATE_BOOLEAN);
        if ($isGet) {
            $getVar = explode("/", $this->requestURI());

            return htmlspecialchars(end($getVar));
        }

        return "";
    }
}
