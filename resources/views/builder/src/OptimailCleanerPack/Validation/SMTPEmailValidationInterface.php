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

interface SMTPEmailValidationInterface
{
    const FSOCKOPEN_PORT = 25;
    const FSOCKOPEN_TIMEOUT = 2;
    const TIMEOUT_SECONDS = 5;
    const TIMEOUT_MICROSECONDS = 0;

    /**
     * @param string $default
     *
     * @return mixed
     */
    public function functionExists($default = "function_exists");

    /**
     * @param string $default
     *
     * @return mixed
     */
    public function checkDNS($default = "checkdnsrr");

    /**
     * Checks whether the given functions are defined.
     *
     * @param array $functions Table containing the function names
     *
     * @return bool
     */
    public function functionsExist(array $functions = array());

    /**
     * Checks the general format of an email address and if valid split
     * the address into two parts: The local-part and the domain name part.
     *
     * @param string $email The email address to check
     *
     * @return object|bool(false)
     */
    public function isValidEmail($email);

    /**
     * Perform a check and if necessary provide
     * a substitute for the email address.
     *
     * @param string $email The email address
     *
     * @return array|null
     */
    public function checkMailFrom($email);

    /**
     * Get the amount of MX records corresponding to a given Internet host name.
     *
     * @param string $hostname Internet host name
     * @param array $mxhosts A list of the MX records found
     * @param array $weight The weight information gathered (optional)
     *
     * @return int
     */
    public function getmxrr($hostname, &$mxhosts = array(), array &$weight = null);

    /**
     * Check DNS records corresponding to a given email address.
     *
     * @param string $email The email address to check
     * @param int $level The level of verification
     *
     * @return bool|string
     */
    public function checkMailExchanger($email, $level = 1);

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
    public function checkDomain($host, $type = "MX");

    /**
     * Fetch DNS Resource Records associated with a hostname.
     *
     * @param string $domain The host name to check
     * @param string $type The records type (default is DNS_AAAA)
     *
     * @return string
     */
    public function getIPV6($domain, $type = DNS_AAAA);

    /**
     * Try to find all available mail severs of the domain name.
     *
     * @param string $domain The domain name
     *
     * @return array
     */
    public function mailServers($domain);

    /**
     * Example given by PHP.net doc.
     * Return the current Unix timestamp with microseconds.
     *
     * @return string
     */
    public function microtimeFloat();

    /**
     * Return the time between two laps in microseconds.
     *
     * @return float
     */
    public function afterTime($timeStart);

    /**
     * Output a formatted string.
     *
     * @param string $message The format string
     * @param array $args Arguments (if empty output string)
     * @param bool $newline Add line break
     */
    public function writeln($message, array $args = array(), $newline = false);

    /**
     * Provides the command lines for the socket connection.
     * The order must be respected: Domain, mail from, rcpt to.
     *
     * @param array $lines Domain, mail from, rcpt to.
     *
     * @return array|string
     */
    public function inputCommands(array $lines = array());

    /**
     * Do not allow the use of this class in certain cases.
     *
     * @param bool $output If true output bool(true) instead of void exit (if not permitted)
     *
     * @return mixed bool(true)|void exit
     */
    public function isPermitted($output = false);

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
    public function filePutContents($pathname, $filename, $data, $structure = "valid", $mode = 0777, $recursive = false, $flags = 0, $active = false);

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
    public function performCheck($email, $from, array $data = array(), $verbose = false, $write = false);
}
