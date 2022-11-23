<?php

namespace App\Http\Controllers;  
//use App\Validation\Controller;
use Illuminate\Http\Request;
use App\Validation\Standardize;
use App\Validation\MailCleaner;
use App\Validation\BounceMailHandler;


class fileController extends Controller
{


    public static function convert($filename, $delimiter)
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        // Deduplication by email
        self::fileProcess($filename, 'email', ';'); 

        $header = null;
        $data = array();

        // Converting file data to a table
        $file = file_get_contents($filename);
        $content = 'Emails'.PHP_EOL. $file;
        file_put_contents($filename,$content);

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                   $header = $row;
                } else {
                      $min = min(count($header), count($row));
                    $data[] = array_combine(array_slice($header, 0, $min), array_slice($row, 0, $min));
                }
            }  //echo print_r($header); exit;

            fclose($handle);
        }

         $finalData = array(); $i=0;
          foreach($data as $d)
          {
            //echo $d.PHP_EOL;
            if($d['Emails'] != ''){
             $finalData[$i] = $d['Emails']; $i++;
            }
          }
         return $finalData;

       //echo '<pre>'; print_r( $finalData); echo '<pre>';exit;
    }




        /**
     * Deduce a CSV/TXT file with a single column.
     *
     * @param string $fileName
     * @param string $uniqueColumnName
     * @param string $delimiter
     */
    public static function fileProcess($fileName, $uniqueColumnName = 'email', $delimiter = ';')
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
                        //echo $column; exit;

                        // Column 'email' not found
                        if ($emailIndex == -1) {
                           // return "Please include a colum 'Emails' at line 1 in your cse file";
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
       

}

$fileController = new fileController();



