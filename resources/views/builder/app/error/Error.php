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

namespace app\error;

use \app\library\HTTPResponse;

class Error extends HTTPResponse
{
    public function indexAction($action = null)
    {
        $code = $this->getHTTPResponseCode();
        if (array_key_exists($code, HTTPResponse::$statusTexts)) {
            if ($code == "200") {
                header("Location: /login");
                exit();
            }

            $error = HTTPResponse::$statusTexts[$code];
            include(__DIR__.'/'.$code.'.php');
            die();
        }
    }
}
