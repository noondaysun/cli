<?php
namespace BWT;

/**
 * @package BWT\Syspro
 * @author Feighen Oosterbroek <foosterbroek@bwtrans.co.za>
 * @license GNU GPL v2
 * @see cli/LICENSE
 */
class Syspro
{
    //: Variables

    //: Functions
    /**
     * Check to see if specific trips have been sent into syspro, or have errors
     */
    public function checkIfTripsHaveBeenSentToSyspro()
    {
        $file = (string) __DIR__ . DIRECTORY_SEPARATOR . "../config/config.json";
        if (is_file($file) && is_readable($file)) {
            $config = json_decode(file_get_contents($file), true);
        } else {
            throw new \FileNotFoundException("Could not successfully parse configuration file");
        }
        if (!isset($config) || !is_array($config) || !$config) {
            throw new \Exception('Could not find a valid configuration file.');
        }
    }
}
