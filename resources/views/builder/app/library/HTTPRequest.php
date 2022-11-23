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

class HTTPRequest
{
    /**
     * The name of the host server that runs the script.
     * Eg: domain.com
     */
    public function serverName()
    {
        return $_SERVER['SERVER_NAME'];
    }

    /**
     * The root document of the site.
     * Eg: /var/www/domain/
     */
    public function documentRoot()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * Host URL.
     * Eg: domain.com
     */
    public function httpHost()
    {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * Retrieve the IP address of the client requesting the page.
     * Eg: 255.255.255.255
     */
    public function remoteAddr()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Returns the name of the script file that is running.
     * Eg: /index.php
     */
    public function phpSelf()
    {
        return $_SERVER['PHP_SELF'];
    }

    /**
     * The port that the client device uses.
     * Eg: 43902
     */
    public function remotePort()
    {
        return $_SERVER['REMOTE_PORT'];
    }

    /**
     * Returns the IP address of the server under which the current script is executed.
     * Eg: 212.212.212.212
     */
    public function serverAddr()
    {
        return $_SERVER['SERVER_ADDR'];
    }

    /**
     * The port that the server uses (by default 80).
     * Different if the secure protocol SSL (HTTPS) is used.
     * Eg: 80
     */
    public function serverPort()
    {
        return $_SERVER['SERVER_PORT'];
    }

    /**
     * To find out which languages the browser accepts (Accept-Language header).
     * Eg: fr-FR,fr;q=0.8,en-US;q=0.6,en;q=0.4
     */
    public function httpAcceptLanguage()
    {
        return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }

    /**
     * To know the first two letters of the chain.
     * Codes ISO 639-1 on two letters.
     * Eg: fr
     */
    public function acceptLanguage()
    {
        return $this->httpAcceptLanguage() ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
    }

    /**
     * Retrieves the entire string of variables contained in
     * a URL after the question mark (?).
     * Eg: http://domain.com?page=1&city=chicago
     */
    public function queryString()
    {
        return urldecode($_SERVER['QUERY_STRING']);
    }

    /**
     * Parses the string to retrieve keys and parameters passed through the URL.
     */
    public function parseQueryString($result = [])
    {
        parse_str($this->queryString(), $result);

        return $result;
    }

    /**
     * Retrieves virtual directories that follow a real file.
     * Eg: /article
     */
    public function virtualDir()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $pathInfo = $_SERVER['PATH_INFO'];
        } elseif (!empty($_SERVER['ORIG_PATH_INFO'])) {
            $pathInfo = $_SERVER['ORIG_PATH_INFO'];
        } else {
            $pathInfo = null;
        }

        return $pathInfo;
    }

    /**
     * Query method used to access the page.
     * Eg: 'GET', 'HEAD', 'POST', 'PUT'
     */
    public function requestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * URI provided to access the page.
     * Eg: /index.html
     */
    public function requestURI()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * The absolute path to the file containing the running script.
     * Eg: /var/www/domain/web/index.php
     */
    public function scriptFilename()
    {
        return $_SERVER['SCRIPT_FILENAME'];
    }

    /**
     * Get a cookie.
     */
    public function getCOOKIE($key)
    {
        return isset($_COOKIE[$key]) ? htmlspecialchars($_COOKIE[$key]) : null;
    }

    /**
     * Check for cookie existence.
     */
    public function checkCOOKIE($key)
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * Get the value of $_GET.
     * Eg: http://domain.com/?name=John
     */
    public function getGET($key)
    {
        return isset($_GET[$key]) ? htmlspecialchars($_GET[$key]) : null;
    }

    /**
     * Check the existence of $_GET.
     */
    public function checkGET($key)
    {
        return isset($_GET[$key]);
    }

    /**
     * Get the value sent (posted) of $_POST.
     * Eg: name=John
     */
    public function getPOST($key)
    {
        return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : null;
    }

    /**
     * Check the existence of $_POST.
     */
    public function checkPOST($key)
    {
        return isset($_POST[$key]);
    }

    /**
     * Protocol http or https?
     */
    public function requestSheme()
    {
        isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ?
            $protocol = 'https://' :
            $protocol = 'http://'
        ;

        return $protocol;
    }

    /**
     * Real URL.
     */
    public function realURL()
    {
        return $this->requestSheme().$this->serverName();
    }

    /**
     * Returns the app path contained in the session var "_appPath".
     *
     * @return string The app path
     */
    public function getAppPath()
    {
        return isset($_SESSION["_appPath"]) ? $_SESSION["_appPath"] : null;
    }
}
