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

class PDOFactory
{
    const NAMES = "SET NAMES utf8";
    const INIT = \PDO::MYSQL_ATTR_INIT_COMMAND;
    const ERRMODE = \PDO::ATTR_ERRMODE;
    const EXCEPTION = \PDO::ERRMODE_EXCEPTION;

    public static function getMysqlConnexion()
    {
        $config = (object) parse_ini_file(__DIR__.'/../config/data/config.ini', true);
        try {
            $options = [
                self::INIT => self::NAMES,
                self::ERRMODE => self::EXCEPTION
            ];
            $db = new \PDO(
                    'mysql:host='.$config->database['MYSQL_HOST'].';dbname='.$config->database['MYSQL_DB_NAME'],
                    $config->database['MYSQL_USERNAME'],
                    $config->database['MYSQL_PASSWORD'],
                    $options
                )
            ;

            return $db;
        } catch (\Exception $e) {
            //echo "Connection to MySQL impossible : ".$e->getMessage();
            //die();
        }
    }
}
