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

namespace src\OptimailCleanerPack\Services;

class ConvertCsvToArray
{
    /**
     * Converts a CSV/TXT file to a table.
     *
     * @param string $fileName
     * @param string $delimiter
     *
     * @return array
     */
    public function convert($filename, $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        // Deduplication by email
        $this->csvProcess($filename, 'email', ';');

        $header = null;
        $data = array();

        // Converting file data to a table
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $min = min(count($header), count($row));
                    $data[] = array_combine(array_slice($header, 0, $min), array_slice($row, 0, $min));
                }
            }

            fclose($handle);
        }

        return $data;
    }

    /**
     * Deduce a CSV/TXT file with a single column.
     *
     * @param string $fileName
     * @param string $uniqueColumnName
     * @param string $delimiter
     */
    public function csvProcess($fileName, $uniqueColumnName = 'email', $delimiter = ';')
    {
        // Unique lines
        $lines = array();
        // Unique Emails
        $emails = array();
        // Email column index
        $emailIndex = -1;

        // Translation mode 't' pour \n = \r\n
        if (($saveHandle = fopen($fileName.'.brv', "wt")) !== false) {
            // Opens the CSV file
            if (($readHandle = fopen($fileName, "r")) !== false) {
                // Reading each row in the table
                while (($data = fgetcsv($readHandle, 8192, $delimiter)) !== false) {
                    if ($emailIndex == -1) {
                        // Identify single column 'email'
                        foreach ($data as $index => $column) {
                            if ($column == $uniqueColumnName) {
                                $emailIndex = $index;
                                break;
                            }
                        }

                        // Column 'email' not found
                        if ($emailIndex == -1) {
                            return false;
                        }
                    }

                    // If duplicate, ignored email
                    if (isset($emails[$data[$emailIndex]])) {
                        continue;
                    }
                    $emails[$data[$emailIndex]] = true;

                    // Write the line in the file
                    fputcsv($saveHandle, $data, $delimiter);
                }

                fclose($readHandle);
            }

            fclose($saveHandle);
        }

        if (is_file($fileName)) {
            // Deleting temporary file
            unlink($fileName);
            // Rename the file by its original name
            rename($fileName.'.brv', $fileName);
        }
    }

    /**
     * Creating a TXT file containing a list of contacts.
     *
     * @param string $input Data coming from a form
     * @param string $path The absolute path to the file
     * @param string $filename The name of the file
     * @param string $rep The path to the entity
     * @param array $array The name of the columns coming from a form
     *
     * @return null|string
     */
    public function outputToTxt($input, $path, $filename, $array)
    {
        $columns = '';
        $arrlength = count($array);

        for ($i = 0; $i < $arrlength; $i++) {
            if (!empty($array[$i])) {
                $columns .= $array[$i].';';
            }
        }

        // Checks for columns
        $lookupHeader = explode(';', $columns);
        $lookupHeader = array_slice(array_filter($lookupHeader), 0);

        // If multiple columns (2 or more)
        if (count($lookupHeader) > 1) {
            // Applies the 'strtolower' function to the array elements
            $array = array_map('strtolower', $lookupHeader);

            // Determines the position and existence of the 'email' column
            foreach ($lookupHeader as $key => $value) {
                if ($value == 'email') {
                    $position = $lookupHeader[$key];
                    $newKey = $key;
                }
            }

            // If an 'email' column has been found
            if ($position == 'email') {
                // Places the contents of $input in a table
                $inputArray = explode(';', $input);

                // Return if the key does not exist
                if (empty($inputArray[$newKey])) {
                    return null;
                }

                // Checks if the email address in its position is valid
                if (filter_var($inputArray[$newKey], FILTER_VALIDATE_EMAIL)) {
                    // Saving the file with its headers
                    file_put_contents($path.$filename, $columns."\r\n".$input);

                    // Returns the name of the file to the controller
                    return $filename;
                }
                // Invalid email address for this position
                else {
                    return null;
                }
            }
            // Column 'email' not found
            else {
                return null;
            }
        }
        // If 0 or 1 column
        else {
            // New header
            $columns = 'email';
            // Returns the string in lowercase
            $email = filter_var($input, FILTER_CALLBACK, array("options" => "strtolower"));
            // Extract the emails from the variable
            $email = $this->extractEmailsFromString($email);

            // Determines whether the variable '$email' is an array
            if (!is_array($email)) {
                return null;
            }

            // Applies the 'strtolower' function to the array elements (a second time)
            $email = array_map('strtolower', $email);
            // Returns an indexed array of values
            $email = array_values($email);
            // Creating the file
            $fp = fopen($path.$filename, 'w+');

            // Add header first
            fwrite($fp, $columns.";\r\n");
            // Line by line inscription for the emails
            foreach ($email as $line) {
                fwrite($fp, $line.';'.PHP_EOL);
            }
            // Close the file
            fclose($fp);
            // Destroys the variable
            unset($line);

            // Returns the name of the file to the controller
            return $filename;
        }
    }

    /**
     * Extracts mail from a string.
     *
     * @param string $sChaine The chain containing emails
     * @return array $aEmails[0] Duplicate emails table
     */
    public function extractEmailsFromString($sChaine)
    {
        if (false !== preg_match_all('`\w(?:[-_.]?\w)*@\w(?:[-_.]?\w)*\.(?:[a-z]{2,4})`', $sChaine, $aEmails)) {
            if (is_array($aEmails[0]) && sizeof($aEmails[0]) > 0) {
                return array_unique($aEmails[0]);
            }
        }

        return null;
    }
}
