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

interface XMLEngine
{
    public function getDatabase($filename = "");
    public function createDatabase($filename, $tablename, $columns = [], $mode = "prod");
    public function readData($filename, $id);
    public function addData($filename, $columns = []);
    public function updateData($filename, $id, $columns = []);
    public function deleteData($filename, $id);
}
