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

/**
 * Checking email through the SMTP protocol (HELO/RCPT).
 *
 * This class can be used to check whether an email is valid
 * using the SMTP protocol. It can connect to an SMTP server
 * defined by the MX records of the email address domain to
 * be validated. The class simulates delivery of a message
 * to see if the given recipient address is accepted as valid.
 * Use as follows:
 *
 * $validation = new SMTPEmailValidation;
 * $validation->performCheck("emailtocheck@domain.com", "myemail@domain.com", true, false);
 *
 * @author Alan Da Silva <info@berevi.com>
 */
class SMTPEmailValidation implements SMTPEmailValidationInterface
{
    /**
     * @var string
     */
    public $functionExists;

    /**
     * @var string
     */
    public $checkDNS;

    /**
     * @param string $default
     *
     * @return mixed
     */
    public function functionExists($default = "function_exists")
    {
        return isset($this->functionExists) ? $this->functionExists : $default;
    }

    /**
     * @param string $default
     *
     * @return mixed
     */
    public function checkDNS($default = "checkdnsrr")
    {
        return isset($this->checkDNS) ? $this->checkDNS : $default;
    }

    /**
     * Checks whether the given functions are defined.
     *
     * @param array $functions Table containing the function names
     *
     * @return bool
     */
    public function functionsExist(array $functions = array())
    {
        $os = get_defined_functions();
        if (empty($functions)) {
            $functions = array(
                $this->functionExists(),
                $this->checkDNS()
            );
        }

        foreach ($functions as $key => $function) {
            if (!in_array($function, $os["internal"])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks the general format of an email address and if valid split
     * the address into two parts: The local-part and the domain name part.
     *
     * @param string $email The email address to check
     *
     * @return object|bool(false)
     */
    public function isValidEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            list($localPart, $domain) = explode('@', $email);
            $format = array(
                "localPart" => $localPart,
                "domain" => $domain
            );

            return (object) $format;
        }

        return false;
    }

    /**
     * Perform a check and if necessary provide
     * a substitute for the email address.
     *
     * @param string $email The email address
     *
     * @return array|null
     */
    public function checkMailFrom($email)
    {
        $result = $this->isValidEmail($email);
        if (empty($result)) {
            $email = isset($_SERVER["SERVER_ADMIN"]) ? $this->isValidEmail($_SERVER["SERVER_ADMIN"]) : null;

            return $email;
        }

        return $result;
    }

    /**
     * Get the amount of MX records corresponding to a given Internet host name.
     *
     * @param string $hostname Internet host name
     * @param array $mxhosts A list of the MX records found
     * @param array $weight The weight information gathered (optional)
     *
     * @return int
     */
    public function getmxrr($hostname, &$mxhosts = array(), array &$weight = null)
    {
        exec('nslookup -type=mx '.$hostname, $results);
        foreach ($results as $result) {
            if (preg_match("/.*mail exchanger = (.*)/", $result, $matches)) {
                $mailServer = explode(' ', $matches[1]);
                if (empty($mailServer[1])) {
                    return false;
                }

                $mxhosts[] = $mailServer[1];
                $weight[] = $mailServer[0];
            }
        }

        return (count($mxhosts) > 0);
    }

    /**
     * Check DNS records corresponding to a given email address.
     *
     * @param string $email The email address to check
     * @param int $level The level of verification
     *
     * @return bool|string
     */
    public function checkMailExchanger($email, $level = 1)
    {
        $result = $this->isValidEmail($email);
        if (!empty($result)) {
            if ($level > 1) {
                if ($this->functionsExist(['checkdnsrr'])) {
                    return (checkdnsrr($result->domain, "MX")) ? true : false;
                }

                return "The checkdnsrr function is not enabled. Can not verify DNS records.";
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * Check DNS records corresponding to a given Internet host name or IP address.
     *
     * @param string $host The Internet host name or IP address
     * @param string $type The records type (default is MX)
     *
     * A, MX, NS, SOA, PTR, CNAME, AAAA, A6, SRV, NAPTR, TXT or ANY.
     *
     * @return bool
     */
    public function checkDomain($host, $type = "MX")
    {
        if ($this->functionsExist(['intl'])) {
            return checkdnsrr(idn_to_ascii($host, IDNA_NONTRANSITIONAL_TO_ASCII, INTL_IDNA_VARIANT_UTS46), $type);
        }

        return false;
    }

    /**
     * Fetch DNS Resource Records associated with a hostname.
     *
     * @param string $domain The host name to check
     * @param string $type The records type (default is DNS_AAAA)
     *
     * @return string
     */
    public function getIPV6($domain, $type = DNS_AAAA)
    {
        $ipv6 = dns_get_record($domain, $type);
        if (empty($ipv6[0]["ipv6"])) {
            return false;
        }

        return $ipv6[0]["ipv6"];
    }

    /**
     * Try to find all available mail severs of the domain name.
     *
     * @param string $domain The domain name
     *
     * @return array
     */
    public function mailServers($domain)
    {
        if ($this->getmxrr($domain, $mxhosts, $weight)) {
            for ($i = 0; $i < count($mxhosts); $i++) {
                $mailExchanger[$mxhosts[$i]] = $weight[$i];
            }

            asort($mailExchanger);

            return array_keys($mailExchanger);
        }

        if ($this->checkDomain($domain, "A")) {
            $mailServers[] = $this->getIPV6($domain) ? $this->getIPV6($domain) : gethostbyname($domain);

            return $mailServers;
        }

        return array();
    }

    /**
     * Example given by PHP.net doc.
     * Return the current Unix timestamp with microseconds.
     *
     * @return string
     */
    public function microtimeFloat()
    {
        list($usec, $sec) = explode(" ", microtime());

        return ((float)$usec + (float)$sec);
    }

    /**
     * Return the time between two laps in microseconds.
     *
     * @return float
     */
    public function afterTime($timeStart)
    {
        return (1000 * ($this->microtimeFloat() - $timeStart));
    }

    /**
     * Output a formatted string.
     *
     * @param string $message The format string
     * @param array $args Arguments (if empty output string)
     * @param bool $newline Add line break
     */
    public function writeln($message, array $args = array(), $newline = false)
    {
        $break = $newline ? "<br>" : $break = "";

        print (is_array($args) && !empty($args)) ? vsprintf($message.$break, $args) : $message.$break;
    }

    /**
     * Provide the command lines for the socket connection.
     * The order must be respected: Domain, mail from, rcpt to.
     *
     * @param array $lines Domain, mail from, rcpt to.
     *
     * @return array|string
     */
    public function inputCommands(array $lines = array())
    {
        if (is_array($lines) && !empty($lines)) {
            $outputCommands = (count($lines) == 3) ?
                array("HELO ".$lines[0], "MAIL FROM: <".$lines[1].">", "RCPT TO: <".$lines[2].">", "QUIT") :
                $this->writeln("[ERROR] The command lines provided are incomplete, 3 arguments are required. Connection closed.")
            ;

            return $outputCommands;
        }

        return $this->writeln("[ERROR] The command lines provided are invalid. Connection closed.");
    }

    /**
     * Do not allow the use of this class in certain cases.
     *
     * @param bool $output If true output bool(true) instead of void exit (if not permitted)
     *
     * @return mixed bool(true)|void exit
     */
    public function isPermitted($output = false)
    {
        $args = array(
            "[INFO]",
            "SMTP Email Validation",
            "can not be used from shared internet, behind a proxy server, from CLI command or in localhost mode."
        );
        if (isset($_SERVER['HTTP_CLIENT_IP']) ||
            isset($_SERVER['HTTP_X_FORWARDED_FOR']) ||
            php_sapi_name() === 'cli-server' ||
            (in_array(@$_SERVER['REMOTE_ADDR'], [
                '127.0.0.1',
                'fe80::1',
                '::1'
            ]))) {
            if ($output) {
                return true;
            }

            exit($this->writeln("%s %s %s", $args));
        }

        return false;
    }

    /**
     * Output all information to a file.
     *
     * @param string $pathname The path to the output directory
     * @param string $filename The name of the file
     * @param mixed $data The information to save (can be array too)
     * @param string $structure The name of the sub-directory
     * @param int $mode The CHMOD of the saved file
     * @param bool $recursive Create recursive folders
     * @param int $flags File save options (FILE_USE_INCLUDE_PATH, FILE_APPEND, LOCK_EX)
     * @param bool $active Enable the method
     *
     * @return int|bool(false)
     */
    public function filePutContents($pathname, $filename, $data, $structure = "valid", $mode = 0777, $recursive = false, $flags = 0, $active = false)
    {
        if (!$active) {
            return;
        }

        if ($pathname[0] == "/") {
            $pathname = substr($pathname, 1);
        }

        if ($pathname[strlen($pathname) - 1] != "/") {
            $pathname = $pathname."/";
        }

        $pathname = __DIR__."/../".$pathname;
        $structure = $structure."/";
        $fullPath = $pathname.$structure;
        $filename = basename($filename);
        if (!is_dir($fullPath)) {
            mkdir($fullPath, $mode, $recursive);
        }

        file_put_contents($fullPath.$filename, $data, $flags);
    }

    /**
     * Callback verification by SMTP in order to validate e-mail addresses.
     * If the address is not forged, the sender and the MX server may coincide.
     *
     * FROM/RCPT TO is used.
     * @see https://tools.ietf.org/html/rfc5321
     *
     * The VRFY command is not used. This is to prevent directory harvest attack.
     * @see https://tools.ietf.org/html/rfc2505
     *
     * @param string $email The email address to check
     * @param string $from The sender email address
     * @param array $data Various data such as the name of the file
     * @param bool $verbose Output informations (default is false)
     * @param bool $write Write informations in file (default is false)
     *
     * @return mixed
     */
    public function performCheck($email, $from, array $data = array(), $verbose = false, $write = false)
    {
        if ($this->isPermitted(true)) {
            file_put_contents(
                __DIR__."/../Resources/config/data/import/".$data[0].".brv",
                "<div class='alert alert-danger' role='alert'>[INFO] SMTP Email Validation, Message: Can not be used from shared internet, behind a proxy server, from CLI command or in localhost mode.</div>".'"'.',"results": "<h5><span class=\'badge badge-success\'>Good emails: 0</span> <span class=\'badge badge-danger\'>Invalid emails: 0</span></h5>'.'"'.',"extra": "'.date("Y-m-d H:i:s").'"'."\r\n}\r\n]\r\n}\r\n",
                FILE_APPEND | LOCK_EX
            );

            return;
        }

        $isValidEmail = $this->isValidEmail($email);
        if ($isValidEmail) {
            if ($this->functionsExist(array("checkdnsrr"))) {
                $mailServers = $this->mailServers($isValidEmail->domain);
                $amount = count($mailServers);
                if ($amount > 0) {
                    $mailFrom = $this->checkMailFrom($from);
                    if (empty($mailFrom)) {
                        return $this->writeln("[ERROR] The second argument (email address from) is invalid.");
                    }

                    for ($x = 0; $x < $amount; $x++) {
                        if ($verbose) {
                            $this->writeln("Connecting to the MAIL SERVER %s...", [$mailServers[$x]], true);
                        }

                        $fsockopen = @fsockopen($mailServers[$x], self::FSOCKOPEN_PORT, $errno, $errstr, self::FSOCKOPEN_TIMEOUT);
                        if (!$fsockopen) {
                            return $this->writeln("[ERROR %s] %s.", [$errno, $errstr]);
                        }

                        if ($verbose) {
                            $this->writeln("[OK] Connection established.<br>", [], true);
                            $this->writeln("Open Socket for %s", [$mailServers[$x]], true);
                        }

                        $response = fgets($fsockopen);
                        if ($verbose) {
                            $this->writeln("[OK] Socket open. Ready for stream.<br>", [], true);
                        }

                        stream_set_timeout($fsockopen, self::TIMEOUT_SECONDS, self::TIMEOUT_MICROSECONDS);

                        $info = stream_get_meta_data($fsockopen);
                        if ($verbose) {
                            $this->writeln("%s [REPLIED] %s<br>", [$mailServers[$x], $response], true);
                        }

                        if (!$info['timed_out'] && !preg_match('/^2\d\d/', $response, $matches)) {
                            fclose($fsockopen);
                            if ($write) {
                                if ($matches[0] == "421") {
                                    file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0].".brv", "<div class='alert alert-danger' role='alert'>[CODE: ".$matches[0]."], Message: Too many connections to this host, Email: ".$email."</div>", FILE_APPEND | LOCK_EX);
                                    file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0]."-bad", $email."\r\n", FILE_APPEND | LOCK_EX);

                                    $this->filePutContents("Resources/config/data/import/", "CLEAN.brv", "[CODE ".$matches[0]."];".$email.";Too many connections to this host.", "error", 0777, true, FILE_APPEND | LOCK_EX);

                                    return;
                                } else {
                                    if (empty($response) || empty($matches[0])) {
                                        file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0].".brv", "<div class='alert alert-danger' role='alert'>[CODE: 0], Message: ".$mailServers[$x]." did not give more precision, Email: ".$email."</div>", FILE_APPEND | LOCK_EX);
                                        file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0]."-bad", $email."\r\n", FILE_APPEND | LOCK_EX);

                                        $this->filePutContents("Resources/config/data/import/", "CLEAN.brv", "[CODE 0];".$email.";".$mailServers[$x]." did not give more precision.", "invalid", 0777, true, FILE_APPEND | LOCK_EX);

                                        return;
                                    } else {
                                        file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0].".brv", "<div class='alert alert-danger' role='alert'>[CODE: ".$matches[0]."], Message: ".$mailServers[$x]." respond ".trim(trim($response), '"').", Email: ".$email."</div>", FILE_APPEND | LOCK_EX);
                                        file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0]."-bad", $email."\r\n", FILE_APPEND | LOCK_EX);

                                        $this->filePutContents("Resources/config/data/import/", "CLEAN.brv", "[CODE ".$matches[0]."];".$email.";".$mailServers[$x]." respond ".$response.".", "invalid", 0777, true, FILE_APPEND | LOCK_EX);

                                        return;
                                    }
                                }

                                file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0].".brv", "<div class='alert alert-danger' role='alert'>[CODE: ".$matches[0]."], Message: ".$mailServers[$x]." respond ".trim(trim($response), '"').", Email: ".$email."</div>", FILE_APPEND | LOCK_EX);
                                file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0]."-bad", $email."\r\n", FILE_APPEND | LOCK_EX);

                                $this->filePutContents("Resources/config/data/import/", "CLEAN.brv", "[CODE ".$matches[0]."];".$email.";".$mailServers[$x]." respond ".$response, "invalid", 0777, true, FILE_APPEND | LOCK_EX);

                                return;
                            }

                            return ($matches[0] == "421") ? $this->writeln("[CODE %s] Too many connections to this host.", [$matches[0]]) :
                                (empty($response) || empty($matches[0])) ?
                                    $this->writeln("[CODE 0] %s did not give more precision.", [$mailServers[$x]]) :
                                    $this->writeln("[CODE %s] %s respond %s.", [$matches[0], $mailServers[$x], $response]);
                        }

                        $output = "";
                        $basicSMTPCommands = $this->inputCommands(
                            array(
                                $mailFrom->domain,
                                $mailFrom->localPart."@".$mailFrom->domain,
                                $email
                            )
                        );

                        if (!is_array($basicSMTPCommands) || empty($basicSMTPCommands)) {
                            fclose($fsockopen);

                            return $basicSMTPCommands;
                        }

                        foreach ($basicSMTPCommands as $basicSMTPCommand) {
                            $timeStart = $this->microtimeFloat();

                            fputs($fsockopen, "$basicSMTPCommand\r\n");

                            $response = fgets($fsockopen, 4096);
                            $time = $this->afterTime($timeStart);
                            if ($verbose) {
                                $output .= vsprintf("%s\r\n%s (%.2f ms)\r\n\r\n", [$basicSMTPCommand, $response, $time]);
                            }

                            if (!$info['timed_out'] && preg_match('/^5\d\d/', $response, $matches)) {
                                if ($write) {
                                    if ($matches[0] <> "552") {
                                        file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0].".brv", "<div class='alert alert-danger' role='alert'>[CODE: ".$matches[0]."], Message: ".$mailServers[$x]." respond ".trim(trim($response), '"').", Email: ".$email."</div>", FILE_APPEND | LOCK_EX);
                                        file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0]."-bad", $email."\r\n", FILE_APPEND | LOCK_EX);

                                        $this->filePutContents("Resources/config/data/import/", "CLEAN.brv", "[CODE ".$matches[0]."];".$email.";".$mailServers[$x]." respond ".$response, "invalid", 0777, true, FILE_APPEND | LOCK_EX);
                                    } else {
                                        file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0].".brv", "<div class='alert alert-danger' role='alert'>[CODE: ".$matches[0]."], Message: Try to send a lighter message => ".$mailServers[$x]." respond ".trim(trim($response), '"').", Email: ".$email."</div>", FILE_APPEND | LOCK_EX);

                                        file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0]."-bad", $email."\r\n", FILE_APPEND | LOCK_EX);

                                        $this->filePutContents("Resources/config/data/import/", "CLEAN.brv", "[CODE ".$matches[0]."];".$email.";Try to send a lighter message => ".$mailServers[$x]." respond ".$response.PHP_EOL, "invalid", 0777, true, FILE_APPEND | LOCK_EX);
                                    }

                                    return;
                                }

                                return ($matches[0] <> "552") ?
                                    $this->writeln("[CODE %s] &laquo;%s&raquo; => %s respond %s", [$matches[0], $email, $mailServers[$x], $response]) :
                                    $this->writeln("[CODE %s] Try to send a lighter message => %s respond %s.", [$matches[0], $mailServers[$x], $response]);
                            }
                        }

                        fclose($fsockopen);

                        if ($verbose) {
                            $this->writeln("%s", [nl2br(htmlentities($output))]);
                        }

                        if ($write) {
                            file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0].".brv", "<div class='alert alert-success' role='alert'>Status: VALID, Message: The email address is valid, Email: ".$email."</div>", FILE_APPEND | LOCK_EX);
                            file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0]."-good", $email."\r\n", FILE_APPEND | LOCK_EX);

                            $this->filePutContents("Resources/config/data/import/", "CLEAN.brv", "[VALID];".$email.";The email address is valid.".PHP_EOL, "valid", 0777, true, FILE_APPEND | LOCK_EX);

                            return;
                        }

                        $this->writeln("[VALID] The email address &laquo;%s&raquo; can be considered as valid. Connection closed.", [$email]);

                        return;
                    }
                }

                if ($write) {
                    file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0].".brv", "<div class='alert alert-danger' role='alert'>[CODE: INVALID], Message: No valid DNS records found for domain ".$isValidEmail->domain.", Email: ".$email."</div>", FILE_APPEND | LOCK_EX);
                    file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0]."-bad", $email."\r\n", FILE_APPEND | LOCK_EX);

                    $this->filePutContents("Resources/config/data/import/", "CLEAN.brv", "[INVALID];".$email.";No valid DNS records found for domain ".$isValidEmail->domain.".".PHP_EOL, "invalid", 0777, true, FILE_APPEND | LOCK_EX);

                    return;
                }

                return $this->writeln("[INVALID] No valid DNS records found for domain %s.", [$isValidEmail->domain]);
            }

            return $this->writeln("[PHP] Native function does not exist. Please enable or install checkdnsrr.");
        }

        if ($write) {
            file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0].".brv", "<div class='alert alert-danger' role='alert'>[CODE: INVALID], Message: Email address is incorrect, Email: ".$email."</div>", FILE_APPEND | LOCK_EX);
            file_put_contents(__DIR__."/../Resources/config/data/import/".$data[0]."-bad", $email."\r\n", FILE_APPEND | LOCK_EX);

            $this->filePutContents("Resources/config/data/import/", "CLEAN.brv", "[INVALID];".$email.";Email address is incorrect.".PHP_EOL, "invalid", 0777, true, FILE_APPEND | LOCK_EX);

            return;
        }

        return $this->writeln("[INVALID] Email address is not correct.");
    }
}
