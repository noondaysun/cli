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
     * @param mixed $password
     *
     * @return string|null $hash
     */
    public static function hash($password): ?string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verifies if an hash corresponds to the given password
     *
     * @param mixed $password
     * @param mixed $hash
     *
     * @return boolean If the hash was generated from the password
     */
    public static function checkHash($password, $hash): bool
    {
        if (password_verify($password, $hash)) {
            return true;
        }

        return false;
    }
}
