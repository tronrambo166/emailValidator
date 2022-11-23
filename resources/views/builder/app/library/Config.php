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

use app\KernelComponent;

class Config extends KernelComponent
{
    protected $vars = [];

    public function get($var)
    {
        $elements = [
            $app = [
                "name" => "Application",
                "version" => "1.0.0",
            ],
            $module = [
                "name" => "Module",
                "version" => "2.0.0",
            ],
        ];

        foreach ($elements as $element) {
            if (!empty($element[$var])) {
                $this->vars[$var] = $element[$var];
            }
        }

        if (isset($this->vars[$var])) {
            return $this->vars[$var];
        }

        return null;
    }
}
