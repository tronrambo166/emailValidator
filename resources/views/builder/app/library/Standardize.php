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

/**
 * Use between two conversion methods as required.
 *
 * 1. The first method is more cumbersome and more
 * resources and therefore suitable for one-time use.
 *
 * 2. The second method is faster and lighter
 * and is therefore suitable for mass use.
 *
 * @author Alan Da Silva <admin@berevi.com>
 */
class Standardize
{
    /**
     * Méthode 1: Removes accents and converts the string to lowercase.
     *
     * @param string $str String with accented characters
     * @param string $encoding Text encoding (example: utf-8, ISO-8859-1...)
     *
     * @return string
     */
    public function punctualStandardize($str, $encoding='UTF-8')
    {
        // Transform accented characters into HTML entities
        $str = htmlentities($str, ENT_NOQUOTES, $encoding);
        // Replace HTML entities to have just the first unaccented characters
        // Example: "&ecute;" => "e", "&Ecute;" => "E", "Ã " => "a"...
        $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        // Replace ligatures such as: Œ, Æ...
        // Example "Å“" => "oe"
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        // Remove all the rest
        $str = preg_replace('#&[^;]+;#', '', $str);

        // Converts string to lowercase with modified encoding
        $str = mb_strtolower($str, mb_detect_encoding($str, $encoding, true));

        return $str;
    }

    /**
     * Méthode 2: Removes accents and converts the string to lowercase.
     *
     * Simple and light version for quick use.
     * This version can be completed with other accents
     * (example: Polish, Russian, Japanese...).
     *
     * @param string $str String of accented characters
     *
     * @return string
     */
    public function bulkStandardize($str)
    {
        $str = str_replace(
            array(
                'à', 'â', 'ä', 'á', 'ã', 'å',
                'î', 'ï', 'ì', 'í',
                'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
                'ù', 'û', 'ü', 'ú',
                'é', 'è', 'ê', 'ë',
                'ç', 'ÿ', 'ñ',
                'À', 'Â', 'Ä', 'Á', 'Ã', 'Å',
                'Î', 'Ï', 'Ì', 'Í',
                'Ô', 'Ö', 'Ò', 'Ó', 'Õ', 'Ø',
                'Ù', 'Û', 'Ü', 'Ú',
                'É', 'È', 'Ê', 'Ë',
                'Ç', 'Ÿ', 'Ñ'
            ),
            array(
                'a', 'a', 'a', 'a', 'a', 'a',
                'i', 'i', 'i', 'i',
                'o', 'o', 'o', 'o', 'o', 'o',
                'u', 'u', 'u', 'u',
                'e', 'e', 'e', 'e',
                'c', 'y', 'n',
                'A', 'A', 'A', 'A', 'A', 'A',
                'I', 'I', 'I', 'I',
                'O', 'O', 'O', 'O', 'O', 'O',
                'U', 'U', 'U', 'U',
                'E', 'E', 'E', 'E',
                'C', 'Y', 'N'
            ),
            $str
        );

        return strtolower($str);
    }
}
