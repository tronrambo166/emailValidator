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

interface CurlRequestInterface
{
    /**
     * @return string
     */
    public function init();
    /**
     * @return string
     */
    public function token();
    /**
     * @param string $default
     * @return mixed
     */
    public function authorization($default = "Bearer");
    /**
     * @param string $default
     * @return mixed
     */
    public function contentType($default = "application/json");
    /**
     * @param string $default
     * @return mixed
     */
    public function method($default = "GET");
    /**
     * @param boolean $default
     * @return bool true|false
     */
    public function return($default = true);
    /**
     * @param integer $default
     * @return int
     */
    public function follow($default = 1);
    /**
     * @return string|resource
     */
    public function getRequest();
}
