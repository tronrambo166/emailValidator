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

namespace src\OptimailCleanerPack\Validation;

class MailCleaner extends SMTPEmailValidation
{
    public $dataEngine;
    protected $_standardize;
    protected $_convertCsvToArray;
    protected $_bounceMailHandler;

    public function __construct($_standardize, $_convertCsvToArray)
    {
        $this->initialize($_standardize, $_convertCsvToArray);
    }

    public function initialize($_standardize, $_convertCsvToArray)
    {
        $this->_standardize = $_standardize;
        $this->_convertCsvToArray = $_convertCsvToArray;
    }

    public function standardize()
    {
        return $this->_standardize;
    }

    public function convertCsvToArray()
    {
        return $this->_convertCsvToArray;
    }

    public function bounceMailHandler($hostname, $flag, $username, $password, $delete = 3)
    {
        $this->_bounceMailHandler = new \BounceMailHandler($hostname, $flag, $username, $password, $delete);
    }

    /**
     * Clean a string with preg_replace.
     *
     * @param string $string The string to clean
     *
     * @return string The string cleaned
     */
    public function clean($string)
    {
        $string = str_replace(' ', '', $string);

        return preg_replace('/[^A-Za-z0-9-@.\-]/', '', $string);
    }

    /**
     * Advanced sorting options by domain level (TLD, ccTLD, SLD).
     *
     * @param string $domainLevel The domain level
     * @param string $order The sorting order (ASC, DESC)
     * @param array $emails The emails to sort
     *
     * @return array
     */
    public function tldAndSld($domainLevel, $order, array $emails = array())
    {
        if ($domainLevel == "tld") {
            $newlines = [];
            foreach ($emails as $email) {
                $newlines[] = strrev($email);
            }

            if ($order == "asc") {
                sort($newlines, SORT_NATURAL | SORT_FLAG_CASE);
            } elseif ($order == "desc") {
                rsort($newlines, SORT_NATURAL | SORT_FLAG_CASE);
            } else {
                sort($newlines, SORT_NATURAL | SORT_FLAG_CASE);
            }

            foreach ($newlines as $email) {
                $reallines[] = strrev($email);
            }

            return $reallines;
        } elseif ($domainLevel == "ccTld") {
            $a = $b = $ax = $bx = [];
            foreach ($emails as $email) {
                $x = substr(strrev(trim($email)), 0, 3);
                (strpos($x, '.') !== false) ? $a[] = strrev($email) : $b[] = strrev($email);
            }

            if ($order == "asc") {
                sort($a, SORT_NATURAL | SORT_FLAG_CASE);
                sort($b, SORT_NATURAL | SORT_FLAG_CASE);
            } elseif ($order == "desc") {
                rsort($a, SORT_NATURAL | SORT_FLAG_CASE);
                rsort($b, SORT_NATURAL | SORT_FLAG_CASE);
            } else {
                sort($a, SORT_NATURAL | SORT_FLAG_CASE);
                sort($b, SORT_NATURAL | SORT_FLAG_CASE);
            }

            foreach ($a as $lineA) {
                $ax[] = strrev($lineA);
            }

            foreach ($b as $lineB) {
                $bx[] = strrev($lineB);
            }

            return array_merge($ax, $bx);
        } elseif ($domainLevel == "sld") {
            $a = $b = $c = $ax = $bx = [];
            foreach ($emails as $email) {
                $x = trim($email);
                if (strpos($x, '@') !== false) {
                    $y = explode("@", $x);
                    $a[] = $y[1];
                    $b[] = $y[0];
                } else {
                    $c[] = $x;
                }
            }

            foreach ($a as $key => $value) {
                $ax[] = $value."@".$b[$key];
            }

            if ($order == "asc") {
                sort($ax, SORT_NATURAL | SORT_FLAG_CASE);
            } elseif ($order == "desc") {
                rsort($ax, SORT_NATURAL | SORT_FLAG_CASE);
            } else {
                sort($ax, SORT_NATURAL | SORT_FLAG_CASE);
            }

            foreach ($ax as $key => $value) {
                list($sld, $local) = explode('@', $value);
                $bx[] = $local.'@'.$sld;
            }

            if ($order == "asc") {
                sort($c, SORT_NATURAL | SORT_FLAG_CASE);
            } elseif ($order == "desc") {
                rsort($c, SORT_NATURAL | SORT_FLAG_CASE);
            } else {
                sort($c, SORT_NATURAL | SORT_FLAG_CASE);
            }
        
            return array_merge($bx, $c);
        } elseif ($domainLevel == "none" && $order == "asc") {
            sort($emails, SORT_NATURAL | SORT_FLAG_CASE);

            return $emails;
        } elseif ($domainLevel == "none" && $order == "desc") {
            rsort($emails, SORT_NATURAL | SORT_FLAG_CASE);

            return $emails;
        }

        return $emails;
    }

    /**
     * Advanced TLD and ccTLD removal options.
     *
     * @param string $domainLevel The domains level to remove
     * @param array $emails The emails
     *
     * @return array
     */
    public function aeoTldOrSld($domainLevel, array $emails = array())
    {
        if ($domainLevel) {
            $a = $b = [];
            $tlds = explode(",", $domainLevel);
            foreach ($emails as $email) {
                foreach ($tlds as $tld) {
                    $length = strlen($tld);
                    $x = substr(trim($email), -$length);
                    (strpos($x, $tld) !== false) ? $a[] = $email : $b[] = $email;
                }
            }

            foreach ($a as $ax) {
                $pos = array_search($ax, $emails);
                unset($emails[$pos]);
            }

            return array_values($emails);
        }

        return $emails;
    }

    /**
     * Performs email cleanup.
     *
     * @param string $file The file name.
     * @param string $tmpFile The filename of the uploaded file.
     * @param string $sender The sender email address
     * @param int $cleaningLevel The cleaning level (1 = email validation, 2 = email domain validation, 3 = SMTP email validation)
     * @param array $options The form data
     * @param object dataEngine DataEngine Manager
     */
    public function run($file, $tmpFile, $sender, $cleaningLevel = 1, array $options = array(), $dataEngine = null)
    {
        session_write_close();

        if (ob_get_length()) {
            ob_end_clean();
        }

        header("Connection: close");
        ignore_user_abort(true);
        ob_start();
        header("Content-Length: 0");
        ob_end_flush();
        flush();
        // fastcgi_finish_request();

        if (empty($file) && empty($options['txtEmails'])) {
            return;
        }

        $date = new \DateTime();
        $fileName = $date->getTimestamp();
        $targetDir = __DIR__."/../Resources/config/data/import/";
        $targetFile = $targetDir.basename($fileName);
        $i = 0;
        if (!empty($file)) {
            move_uploaded_file($tmpFile, $targetFile);
            $lines = file($targetFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        } else {
            $lines = [];
        }

        $fopen = fopen($targetFile, 'w+');
        fwrite($fopen, "email"."\r\n");

        $txtEmails = (!empty($options['txtEmails'])) ? explode("\n", $options['txtEmails']) : [];
        $lines = array_merge($lines, $txtEmails);

        $lines = $this->tldAndSld($options['tldAndSld'], $options['ascOrDesc'], $lines);
        $lines = $this->aeoTldOrSld($options['aeoTld'], $lines);
        $lines = $this->aeoTldOrSld($options['aeoSld'], $lines);

        $arrlength = count($lines);
        foreach ($lines as $lineNum => $line) {
            $line = $this->_standardize->bulkStandardize($line);
            $line = trim($line);
            $email = filter_var($line, FILTER_SANITIZE_EMAIL);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                (++$i === $arrlength) ? fwrite($fopen, $this->clean($line)) : fwrite($fopen, $this->clean($line)."\r\n");
            }
        }

        fclose($fopen);

        $data = $this->_convertCsvToArray->convert($targetFile, ';');
        if ($cleaningLevel != 3) {
            $cleanFile = fopen($targetFile.".brv", 'w+');
            $goodFile = fopen($targetFile."-good", 'w+');
            $badFile = fopen($targetFile."-bad", 'w+');
        }

        if (!empty($dataEngine)) {
            $columns = [
                [
                    "file_name"   => (!empty($options['fileName'])) ? $options['fileName'] : $fileName,
                    "clean_level" => $options['level'],
                    "asc_or_desc" => $options['ascOrDesc'],
                    "tld_and_sld" => $options['tldAndSld'],
                    "aeo_tld" 	  => (!empty($options['aeoTld'])) ? $options['aeoTld'] : 'none',
                    "aeo_sld" 	  => (!empty($options['aeoSld'])) ? $options['aeoSld'] : 'none'
                ]
            ];

            $database = dirname(__FILE__)."/../Resources/config/data/optimail.xml";
            (!file_exists($database)) ?
                $dataEngine->createDatabase("optimail", "mail_cleaner", $columns, true, "OptimailCleanerPack", "prod") :
                $dataEngine->addData("optimail", $columns, true, "OptimailCleanerPack")
            ;
        }

        $size = count($data);
        $x = $y = 0;
        $e = $batchSize = 1;
        $lastTimer = $dataEngine->readLast("timer", true, "OptimailCleanerPack");
        $lastData = $dataEngine->readLast("optimail", true, "OptimailCleanerPack");
        if ($cleaningLevel != 3) {
            $fwriteData = '"id": "'.$fileName.'",'."\r\n".'"name": "'.$lastData->{"file_name"}.'",'.'"clean_level": "'.$lastData->{"clean_level"}.'",'.'"asc_or_desc": "'.$lastData->{"asc_or_desc"}.'",'.'"tld_and_sld": "'.$lastData->{"tld_and_sld"}.'",'.'"aeo_tld": "'.$lastData->{"aeo_tld"}.'",'.'"aeo_sld": "'.$lastData->{"aeo_sld"}.'",'.'"nb_emails": "'.$size.'",'.'"download": "<button id=\''.$fileName.'-G\' onclick=\'downloadGood(this)\' class=\'btn btn-success btn-sm\' role=\'button\'>Good</button> <button id=\''.$fileName.'-B\' onclick=\'downloadBad(this)\' class=\'btn btn-danger btn-sm\' role=\'button\'>Bad</button>",'.'"delete": "<button id=\''.$fileName.'-D\' onclick=\'deleteMe(this)\' class=\'btn btn-secondary btn-sm\' type=\'button\' role=\'button\'>Delete</button>",'."\r\n".'"info": "';

            fwrite($cleanFile, "{\r\n".'"data": ['."\r\n"."{\r\n");
            fwrite($cleanFile, $fwriteData);
        }

        foreach ($data as $row) {
            if (!empty($row['email'])) {
                $percent = 100 * $e / $size;
                if (($e % $batchSize) === 0) {
                    if ($e == $size) {
                        $columns = [["percent" => "100", "active" => "1", "reload" => "0"]];
                        $dataEngine->updateData("timer", $lastTimer["id"], $columns, true, "OptimailCleanerPack");
                    } else {
                        $columns = [["percent" => round($percent, 0, PHP_ROUND_HALF_DOWN), "active" => "1", "reload" => "1"]];
                        $dataEngine->updateData("timer", $lastTimer["id"], $columns, true, "OptimailCleanerPack");
                    }
                }

                $e++;

                if ($cleaningLevel == 1) {
                    if ($this->checkMailExchanger($row['email'])) {
                        fwrite($goodFile, $row['email']."\r\n");
                        fwrite($cleanFile, "<div class='alert alert-success' role='alert'>Status: OK, Email: ".$row['email']."</div>");
                        $x++;
                    } else {
                        fwrite($badFile, $row['email']."\r\n");
                        fwrite($cleanFile, "<div class='alert alert-danger' role='alert'>Status: INVALID, Email: ".$row['email']."</div>");
                        $y++;
                    }
                } elseif ($cleaningLevel == 2) {
                    $isDomainValid = $this->checkMailExchanger($row['email'], 2);
                    if ($isDomainValid && is_string($isDomainValid)) {
                        fwrite($cleanFile, $isDomainValid."\r\n");
                    } elseif ($isDomainValid && !is_string($isDomainValid)) {
                        fwrite($goodFile, $row['email']."\r\n");
                        fwrite($cleanFile, "<div class='alert alert-success' role='alert'>Status: OK, Message: Domain MX ok, Email: ".$row['email']."</div>");
                        $x++;
                    } else {
                        fwrite($badFile, $row['email']."\r\n");
                        fwrite($cleanFile, "<div class='alert alert-danger' role='alert'>Status: INVALID, Message: Domain MX invalid, Email: ".$row['email']."</div>");
                        $y++;
                    }
                } elseif ($cleaningLevel == 3) {
                    if ($e == 2) {
                        $fwriteData = '"id": "'.$fileName.'",'."\r\n".'"name": "'.$lastData->{"file_name"}.'",'.'"clean_level": "'.$lastData->{"clean_level"}.'",'.'"asc_or_desc": "'.$lastData->{"asc_or_desc"}.'",'.'"tld_and_sld": "'.$lastData->{"tld_and_sld"}.'",'.'"aeo_tld": "'.$lastData->{"aeo_tld"}.'",'.'"aeo_sld": "'.$lastData->{"aeo_sld"}.'",'.'"nb_emails": "'.$size.'",'.'"download": "<button id=\''.$fileName.'-G\' onclick=\'downloadGood(this)\' class=\'btn btn-success btn-sm\' role=\'button\'>Good</button> <button id=\''.$fileName.'-B\' onclick=\'downloadBad(this)\' class=\'btn btn-danger btn-sm\' role=\'button\'>Bad</button>",'.'"delete": "<button id=\''.$fileName.'-D\' onclick=\'deleteMe(this)\' class=\'btn btn-secondary btn-sm\' type=\'button\' role=\'button\'>Delete</button>",'."\r\n".'"info": "';

                        file_put_contents(
                            __DIR__."/../Resources/config/data/import/".$fileName.".brv",
                            "{\r\n".'"data": ['."\r\n"."{\r\n".$fwriteData,
                            FILE_APPEND | LOCK_EX
                        );
                    }

                    if ($this->isPermitted(true)) {
                        if ($e == $size + 1) {
                            $this->performCheck($row['email'], $sender, [$fileName, $lastData, $size], false, true);
                        }
                    } else {
                        $this->performCheck($row['email'], $sender, [$fileName, $lastData, $size], false, true);
                    }
                }
            }
        }

        if ($this->isPermitted(true)) {
            fwrite($cleanFile, '"'.',"results": "<h5><span class=\'badge badge-success\'>Good emails: '.$x.'</span> <span class=\'badge badge-danger\'>Invalid emails: '.$y.'</span></h5>');
            fwrite($cleanFile, '"'.',"extra": "'.date("Y-m-d H:i:s").'"'."\r\n}\r\n]\r\n}\r\n");
            fclose($cleanFile);

            return;
        }

        if ($cleaningLevel == 3) {
            $validEmailsCount = $this->lineCount(__DIR__."/../Resources/config/data/import/", $fileName."-good");
            $invalidEmailsCount = $this->lineCount(__DIR__."/../Resources/config/data/import/", $fileName."-bad");
            $validEmailsCount = ($validEmailsCount > 0) ? $validEmailsCount - 1 : "0";
            $invalidEmailsCount = ($invalidEmailsCount > 0) ? $invalidEmailsCount - 1 : "0";
            file_put_contents(
                __DIR__."/../Resources/config/data/import/".$fileName.".brv",
                '"'.',"results": "<h5><span class=\'badge badge-success\'>Good emails: '.$validEmailsCount.'</span> <span class=\'badge badge-danger\'>Invalid emails: '.$invalidEmailsCount.'</span></h5>'.'"'.',"extra": "'.date("Y-m-d H:i:s").'"'."\r\n}\r\n]\r\n}\r\n",
                FILE_APPEND | LOCK_EX
            );
        } else {
            fwrite($cleanFile, '"'.',"results": "<h5><span class=\'badge badge-success\'>Good emails: '.$x.'</span> <span class=\'badge badge-danger\'>Invalid emails: '.$y.'</span></h5>');
            fwrite($cleanFile, '"'.',"extra": "'.date("Y-m-d H:i:s").'"'."\r\n}\r\n]\r\n}\r\n");
            fclose($cleanFile);
        }
    }

    /**
     * Counts the amount of lines in a file.
     *
     * @param string $filename The file path
     * @param string $file The file name
     *
     * @return int
     */
    public function lineCount($filename, $file)
    {
        if (!file_exists($filename.$file)) {
            return "0";
        }

        $linecount = 0;
        $handle = fopen($filename.$file, "r");
        while (!feof($handle)) {
            $line = fgets($handle);
            $linecount++;
        }

        fclose($handle);

        return $linecount;
    }
}
