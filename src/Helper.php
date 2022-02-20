<?php

namespace RobsonSanches\Stays\Client;

/**
 * Class Helper
 */
class Helper {

    /**
     * Remove the leading slashes from a string.
     *
     * @param string $string
     *
     * @return string
     */
    public static function removeLeadingSlash(string $string):string
    {

        if(substr($string, 0, 1) == '/') {
            $string = substr($string, 1);
        }

        return $string;
    }

    /**
     * Remove the trailing slashes from a string.
     *
     * @param string $string
     *
     * @return string
     */
    public static function removeTrailingSlash(string $string):string
    {
        if(substr($string, -1) == '/') {
            $string = substr($string, 0, -1);
        }

        return $string;
    }

    /**
     * Remove the leading and trailing slashes from a string.
     *
     * @param string $string
     *
     * @return string
     */
    public static function removeSlashes(string $string):string
    {
        $string = self::removeLeadingSlash($string);
        $string = self::removeTrailingSlash($string);

        return $string;
    }

}
