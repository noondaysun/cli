<?php
namespace Hash;

/**
 * From: https://www.sitepoint.com/re-introducing-symfony-console-cli-php-uninitiated/
 *
 * @author Cláudio Ribeiro
 *
 */
class Hash
{

    /**
     * Receives a string password and hashes it.
     *
     * @param string $password
     * @return string $hash
     */
    public static function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verifies if an hash corresponds to the given password
     *
     * @param string $password
     * @param string $hash
     * @return boolean If the hash was generated from the password
     */
    public static function checkHash($string, $hash)
    {
        if (password_verify($string, $hash)) {
            return true;
        }
        return false;
    }
}
