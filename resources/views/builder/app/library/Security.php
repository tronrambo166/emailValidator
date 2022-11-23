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

use \app\error\Error;

class Security extends Error
{
    public function isAuthorized($authorization = null)
    {
        if (!isset($authorization)) {
            return $this->addHeader('HTTP/1.0 401 Unauthorized');
        }
    }

    public function checkAuthorization()
    {
        $token = isset($_COOKIE["_token"]) ? $_COOKIE["_token"] : null;
        $authorization = isset($_SESSION["authorization"]) ? $_SESSION["authorization"] : null;
        if (empty($token) || empty($authorization)) {
            return false;
        }

        return true;
    }

    public function returnAuthorization()
    {
        $authorization = isset($_SESSION["authorization"]) ? $_SESSION["authorization"] : null;
        if (!$this->checkAuthorization()) {
            $this->isAuthorized($authorization);
            $this->indexAction();
        }
    }

    public function revokeAuthorization()
    {
        if (isset($_SESSION["authorization"])) {
            unset($_SESSION["authorization"]);
        }

        if (isset($_COOKIE["_token"])) {
            $this->setCookie("_token", "", time() - 3600, "/");
        }
    }
}
