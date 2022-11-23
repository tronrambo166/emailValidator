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

interface BounceMailHandlerInterface
{
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
    public function initialize($hostname, $flag, $username, $password, $delete = 3, $imapSearch = "ALL", $count = 1);

    /**
     * @return string
     */
    public function hostname();

    /**
     * @return string
     */
    public function flag();

    /**
     * @return string
     */
    public function username();

    /**
     * @return string
     */
    public function password();

    /**
     * @param int $default
     *
     * @return int
     */
    public function delete($default = 2);

    /**
     * @param string $default
     *
     * @return mixed
     */
    public function imapSearch($default = "ALL");

    /**
     * @param int $default
     *
     * @return int
     */
    public function count($default = 1);

    /**
     * Return the full hostname for imap connection.
     *
     * @return string
     */
    public function imapHostname();

    /**
     * Check if imap_open function exists.
     *
     * @return bool
     */
    public function isImapOpenExists();

    /**
     * Check if the variable $ip is a valid IPV4 address.
     *
     * @param string $ip The IP address
     *
     * @return bool
     */
    public function validateIPv4($ip);

    /**
     * Check if the variable $ip is a valid IPV6 address.
     *
     * @param string $ip The IP address
     *
     * @return bool
     */
    public function validateIPv6($ip);

    /**
     * Check if the variable $ip is a valid IPV4 or IPV6 address.
     *
     * @param string $ip The IP address
     *
     * @return bool
     */
    public function validateIPv4AndIPv6($ip);

    /**
     * Extract ip address from eml text and check if valid.
     *
     * @param string $text The EML text
     *
     * @return bool
     */
    public function extractAndValidateIP($text);

    /**
     * Extract mail system message from eml text.
     *
     * @param string $text The EML text
     *
     * @return string
     */
    public function extractMailSystemMessage($text);

    /**
     * Extract header information from EML message.
     *
     * @param string $eml The EML header
     * @param string $searchFor The text to search for
     *
     * @return string|bool(false)
     */
    public function getReport($eml, $searchFor);

    /**
     * Extract header recipient from EML message.
     *
     * @param string $eml The EML header
     * @param string $searchFor The recipient to search for
     *
     * @return string|bool(false)
     */
    public function getRecipient($eml, $searchFor = "Original-Recipient:");

    /**
     * Connect to mailbox and process the bounced emails.
     */
    public function processBouncedEmails($outputDir);

    public function createDirectory($dir, $chmod = 0777, $recursive = true);
}
