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
 * Allows to connect to a mailbox and to extract in each e-mail address
 * the information necessary for the treatment of the bounced emails.
 *
 * According to the PHP documentation
 * @see http://php.net/manual/en/function.imap-open.php
 *
 * To connect to an IMAP server running on port 143 on the local machine,
 * do the following: {localhost:143}INBOX
 *
 * To connect to a POP3 server on port 110 on the local server,
 * do the following: {localhost:110/pop3}INBOX
 *
 * To connect to an SSL IMAP or POP3 server, add /ssl after the protocol
 * specification: {localhost:993/imap/ssl}INBOX
 *
 * To connect to an SSL IMAP or POP3 server with a self-signed certificate,
 * add /ssl/novalidate-cert after the protocol specification:
 * {localhost:995/pop3/ssl/novalidate-cert}
 *
 * To connect to an NNTP server on port 119 on the local server, use:
 * {localhost:119/nntp}comp.test
 *
 * To connect to a remote server replace "localhost" with the name or the
 * IP address of the server you want to connect to.
 *
 * Use as follows:
 *
 * $inbox = new BounceMailHandler('localhost', '995/pop3/ssl/novalidate-cert', 'noreply@domain.com', 'password');
 * $inbox->processBouncedEmails();
 *
 * @author Alan Da Silva <admin@berevi.com>
 */
class BounceMailHandler implements BounceMailHandlerInterface
{
    public $hostname;
    public $flag;
    public $username;
    public $password;
    public $delete;
    public $imapSearch;
    public $count;

    /**
     * Enhanced Mail System Status Codes.
     *
     * @see https://tools.ietf.org/html/rfc3463
     */
    public static $SMTPEnumeratedStatusCodes = array(
        '4.0.0'  => 'Other undefined Status',
        '5.0.0'  => 'Other undefined Status',
        '4.1.0'  => 'Other address status',
        '5.1.0'  => 'Other address status',
        '4.1.1'  => 'Bad destination mailbox address',
        '5.1.1'  => 'Bad destination mailbox address',
        '5.1.2'  => 'Bad destination system address',
        '5.1.3'  => 'Bad destination mailbox address syntax',
        '4.1.4'  => 'Destination mailbox address ambiguous',
        '5.1.4'  => 'Destination mailbox address ambiguous',
        '5.1.6'  => 'Destination mailbox has moved, No forwarding address',
        '5.1.7'  => 'Bad sender\'s mailbox address syntax',
        '4.1.8'  => 'Bad sender\'s system address',
        '5.1.8'  => 'Bad sender\'s system address',
        '5.1.9'  => 'Message relayed to non-compliant mailer',
        '5.1.10' => 'Recipient address has null MX',
        '4.2.0'  => 'Other or undefined mailbox status',
        '5.2.0'  => 'Other or undefined mailbox status',
        '4.2.1'  => 'Mailbox disabled, not accepting messages',
        '5.2.1'  => 'Mailbox disabled, not accepting messages',
        '4.2.2'  => 'Mailbox full',
        '5.2.2'  => 'Mailbox full',
        '5.2.3'  => 'Message length exceeds administrative limit',
        '4.2.4'  => 'Mailing list expansion problem',
        '4.3.0'  => 'Other or undefined mail system status',
        '5.3.0'  => 'Other or undefined mail system status',
        '4.3.1'  => 'Mail system full',
        '4.3.2'  => 'System not accepting network messages',
        '5.3.2'  => 'System not accepting network messages',
        '5.3.3'  => 'System not capable of selected features',
        '5.3.4'  => 'Message too big for system',
        '5.3.5'  => 'System incorrectly configured',
        '5.4.0'  => 'Other or undefined network or routing status',
        '4.4.1'  => 'No answer from host',
        '4.4.2'  => 'Bad connection',
        '4.4.3'  => 'Directory server failure',
        '5.4.3'  => 'Directory server failure',
        '4.4.4'  => 'Unable to route',
        '5.4.4'  => 'Unable to route',
        '4.4.5'  => 'Mail system congestion',
        '4.4.6'  => 'Routing loop detected',
        '4.4.7'  => 'Delivery time expired',
        '5.4.7'  => 'Delivery time expired',
        '4.5.0'  => 'Other or undefined protocol status',
        '5.5.0'  => 'Other or undefined protocol status',
        '4.5.1'  => 'Invalid command',
        '5.5.1'  => 'Invalid command',
        '5.5.2'  => 'Syntax error',
        '4.5.3'  => 'Too many recipients',
        '4.5.4'  => 'Invalid command arguments',
        '5.5.4'  => 'Invalid command arguments',
        '4.5.5'  => 'Wrong protocol version',
        '5.5.5'  => 'Wrong protocol version',
        '4.5.6'  => 'Authentication Exchange line is too long',
        '5.5.6'  => 'Authentication Exchange line is too long',
        '4.6.0'  => 'Other or undefined media error',
        '5.6.0'  => 'Other or undefined media error',
        '5.6.1'  => 'Media not supported',
        '4.6.2'  => 'Conversion required and prohibited',
        '5.6.2'  => 'Conversion required and prohibited',
        '5.6.3'  => 'Conversion required but not supported',
        '5.6.4'  => 'Conversion with loss performed',
        '4.6.5'  => 'Conversion Failed',
        '5.6.5'  => 'Conversion Failed',
        '5.6.6'  => 'Message content not available',
        '5.6.7'  => 'Non-ASCII addresses not permitted for that sender/recipient',
        '5.6.8'  => 'UTF-8 string reply is required, but not permitted by the SMTP client',
        '5.6.9'  => 'UTF-8 header message cannot be transferred to one or more recipients, so the message must be rejected',
        '4.7.0'  => 'Other or undefined security status',
        '5.7.0'  => 'Other or undefined security status',
        '4.7.1'  => 'Delivery not authorized, message refused',
        '5.7.1'  => 'Delivery not authorized, message refused',
        '5.7.2'  => 'Mailing list expansion prohibited',
        '5.7.3'  => 'Security conversion required but not possible',
        '5.7.4'  => 'Security features not supported',
        '4.7.5'  => 'Cryptographic failure',
        '5.7.5'  => 'Cryptographic failure',
        '4.7.6'  => 'Cryptographic algorithm not supported',
        '5.7.6'  => 'Cryptographic algorithm not supported',
        '4.7.7'  => 'Message integrity failure',
        '5.7.7'  => 'Message integrity failure',
        '5.7.8'  => 'Authentication credentials invalid',
        '5.7.9'  => 'Authentication mechanism is too weak',
        '5.7.10' => 'Encryption Needed',
        '5.7.11' => 'Encryption required for requested authentication mechanism',
        '4.7.12' => 'A password transition is needed',
        '5.7.13' => 'User Account Disabled',
        '5.7.14' => 'Trust relationship required',
        '4.7.15' => 'Priority Level is too low',
        '5.7.15' => 'Priority Level is too low',
        '4.7.16' => 'Message is too big for the specified priority',
        '5.7.16' => 'Message is too big for the specified priority',
        '5.7.17' => 'Mailbox owner has changed',
        '5.7.18' => 'Domain owner has changed',
        '5.7.19' => 'RRVS test cannot be completed',
        '5.7.20' => 'No passing DKIM signature found',
        '5.7.21' => 'No acceptable DKIM signature found',
        '5.7.22' => 'No valid author-matched DKIM signature found',
        '5.7.23' => 'SPF validation failed',
        '4.7.24' => 'SPF validation error',
        '5.7.24' => 'SPF validation error',
        '5.7.25' => 'Reverse DNS validation failed',
        '5.7.26' => 'Multiple authentication checks failed',
        '5.7.27' => 'Sender address has null MX',
        '5.7.28' => 'Mail flood detected'
    );

    /**
     * Constructor.
     *
     * @param string  $hostname   - The hostname parameter
     * @param string  $flag       - The flag parameter
     * @param string  $username   - The username parameter
     * @param string  $password   - The password parameter
     * @param integer $delete     - The number of failures allowed before bounced
     * @param string  $imapSearch - The imap_search METHOD parameter
     * @param integer $count      - The count parameter
     */
    public function __construct($hostname, $flag, $username, $password, $delete = 3, $imapSearch = "ALL", $count = 1)
    {
        $this->initialize($hostname, $flag, $username, $password, $delete, $imapSearch, $count);
    }

    /**
     * Sets the parameters for this process.
     *
     * This method also pre-set all properties except for hostname, username and password.
     *
     * @param string  $hostname   - The hostname parameter
     * @param string  $flag       - The flag parameter
     * @param string  $username   - The username parameter
     * @param string  $password   - The password parameter
     * @param integer $delete     - The number of failures allowed before bounced
     * @param string  $imapSearch - The imap_search METHOD parameter
     * @param integer $count      - The count parameter
     */
    public function initialize($hostname, $flag, $username, $password, $delete = 3, $imapSearch = "ALL", $count = 1)
    {
        $this->hostname = $hostname;
        $this->flag = $flag;
        $this->username = $username;
        $this->password = $password;
        $this->delete = $delete;
        $this->imapSearch = $imapSearch;
        $this->count = $count;
    }

    /**
     * @return string
     */
    public function hostname()
    {
        return $this->hostname;
    }

    /**
     * @return string
     */
    public function flag()
    {
        return $this->flag;
    }

    /**
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * @param int $default
     *
     * @return int
     */
    public function delete($default = 2)
    {
        return (isset($this->delete) && (is_numeric($this->delete))) ? $this->delete : $default;
    }

    /**
     * @param string $default
     *
     * @return mixed
     */
    public function imapSearch($default = "ALL")
    {
        return isset($this->imapSearch) ? $this->imapSearch : $default;
    }

    /**
     * @param int $default
     *
     * @return int
     */
    public function count($default = 1)
    {
        return (isset($this->count) && (is_numeric($this->delete))) ? $this->count : $default;
    }

    /**
     * Return the full hostname for imap connection.
     *
     * @return string
     */
    public function imapHostname()
    {
        if ($this->flag == "143" || $this->flag == "110/pop3" || $this->flag == "993/imap/ssl") {
            return '{'.$this->hostname.':'.$this->flag.'}INBOX';
        }

        if ($this->flag == "119/nntp") {
            return '{'.$this->hostname.':'.$this->flag.'}comp.test';
        }

        return '{'.$this->hostname.':'.$this->flag.'}';
    }

    /**
     * Check if imap_open function exists.
     *
     * @return bool
     */
    public function isImapOpenExists()
    {
        return (!function_exists('imap_open')) ? true : false;
    }

    /**
     * Check if the variable $ip is a valid IPV4 address.
     *
     * @param string $ip The IP address
     *
     * @return bool
     */
    public function validateIPv4($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return true;
        }

        return false;
    }

    /**
     * Check if the variable $ip is a valid IPV6 address.
     *
     * @param string $ip The IP address
     *
     * @return bool
     */
    public function validateIPv6($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return true;
        }

        return false;
    }

    /**
     * Check if the variable $ip is a valid IPV4 or IPV6 address.
     *
     * @param string $ip The IP address
     *
     * @return bool
     */
    public function validateIPv4AndIPv6($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return true;
        }

        return false;
    }

    /**
     * Extract ip address from eml text and check if valid.
     *
     * @param string $text The EML text
     *
     * @return bool
     */
    public function extractAndValidateIP($text)
    {
        $isIPAddress = explode("[", $text);
        $ipAddress = explode("]", $isIPAddress[1]);
        if ($ipAddress[0]) {
            return $this->validateIPv4AndIPv6($ipAddress[0]);
        }

        return false;
    }

    /**
     * Extract mail system message from eml text.
     *
     * @param string $text The EML text
     *
     * @return string
     */
    public function extractMailSystemMessage($text)
    {
        $MailSystemMessage = explode("[", $text);
        $message = explode("]", $MailSystemMessage[1]);

        return $message[1];
    }

    /**
     * Extract header information from EML message.
     *
     * @param string $eml The EML header
     * @param string $searchFor The text to search for
     *
     * @return string|bool(false)
     */
    public function getReport($eml, $searchFor)
    {
        $pattern = preg_quote($searchFor, '/');
        $pattern = "/^.*$pattern.*\$/m";
        if (preg_match_all($pattern, $eml, $matches)) {
            $report = trim($matches[0][0]);
            $report = explode($searchFor." ", $report);

            return $report[1];
        }

        return false;
    }

    /**
     * Extract header recipient from EML message.
     *
     * @param string $eml The EML header
     * @param string $searchFor The recipient to search for
     *
     * @return string|bool(false)
     */
    public function getRecipient($eml, $searchFor = "Original-Recipient:")
    {
        if ($this->getReport($eml, $searchFor)) {
            $recipient = explode(";", $this->getReport($eml, $searchFor));

            return $recipient[1];
        }

        return false;
    }

    /**
     * Connect to mailbox and process the bounced emails.
     */
    public function processBouncedEmails($outputDir)
    {
        if ($this->isImapOpenExists()) {
            $response = json_encode("Imap function not available.");

            return print vsprintf("%s", [$response]);
        }

        $inbox = @imap_open($this->imapHostname(), $this->username, $this->password);
        $imapMessage = imap_errors();
        if (!empty($imapMessage)) {
            $response = json_encode($imapMessage);

            return print vsprintf("%s", [$response]);
        }

        $this->createDirectory($outputDir);

        $emails = imap_search($inbox, $this->imapSearch);
        if ($emails) {
            rsort($emails);

            $date = new \DateTime();
            $filename = $date->getTimestamp();
            $e = $this->count;
            $emailAddresses = array();
            $deleteAddresses = array();
            $numMsgs = imap_num_msg($inbox);
            $failed = fopen($outputDir.'/'.$filename.'.brv', 'w');

            $preJson = '{"data": [{'.
                '"id": "'.$filename.'",'.
                '"name": "'.$filename.'",'.
                '"date": "'.date("Y/m/d").'",'.
                '"nb_returned": "'.$numMsgs.'",'.
                '"download": "<button id=\''.$filename.'-B\' onclick=\'downloadBad(this)\' class=\'btn btn-danger btn-sm\'>Bad</button>",'.
                '"delete": "<button id=\''.$filename.'-D\' onclick=\'deleteMe(this)\' class=\'btn btn-secondary btn-sm\' type=\'button\'>Delete</button>",'.
                '"info": "'
            ;

            fwrite($failed, $preJson);

            for ($n = 1; $n <= $numMsgs; $n++) {
                $bounce = imap_fetchheader($inbox, $n).imap_body($inbox, $n);
                $action = $this->getReport($bounce, "Action:");
                $status = $this->getReport($bounce, "Status:");
                $original = $this->getRecipient($bounce);
                if (!empty($action) && !empty($status) && !empty($original)) {
                    if ($action == 'failed') {
                        if (!isset($emailAddresses[$original])) {
                            $emailAddresses[$original] = 0;
                        }

                        $emailAddresses[$original]++;
                        $deleteAddresses[$original][] = $n;
                        (!empty(self::$SMTPEnumeratedStatusCodes[$status])) ?
                            fwrite($failed, "<div class='alert alert-danger' role='alert'>Status: ".$action.", Code: [".$status."], Message: ".self::$SMTPEnumeratedStatusCodes[$status].", Email: ".$original."</div>") :
                            fwrite($failed, "<div class='alert alert-danger' role='alert'>Status: ".$action.", Code: [".$status."], Message: Other undefined Status, Email: ".$original."</div>")
                        ;
                    }
                }

                $e++;
            }

            fwrite($failed, '"}]}');
            fclose($failed);

            $file = fopen($outputDir.'/'.$filename.'-bad', 'w');
            foreach ($emailAddresses as $key => $value) {
                if ($value >= $this->delete) {
                    fwrite($file, trim($key)."\r\n");

                    foreach ($deleteAddresses[$key] as $delNum) {
                        imap_delete($inbox, $delNum);
                    }
                }
            }

            fclose($file);
            imap_expunge($inbox);
            imap_close($inbox);

            $response = json_encode("Cleaning the mailbox successfully completed.");

            return print vsprintf("%s", [$response]);
        }
    }

    public function createDirectory($dir, $chmod = 0777, $recursive = true)
    {
        if (is_string($dir) && !empty($dir)) {
            if (!is_dir($dir)) {
                mkdir($dir, $chmod, $recursive);
            }
        }
    }
}
