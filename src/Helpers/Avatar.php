<?php

namespace FoundationApp\Discussions\Helpers;

class Avatar {
    /**
     * Convert any string to a color code.
     *
     * @param string $string
     *
     * @return string
     */
    public static function stringToColorCode($string)
    {
        $code = dechex(crc32($string));

        return substr($code, 0, 6);
    }

    /**
     * Get the initials from a name.
     *
     * @param $name
     *
     * @return string
     */
    public static function getInitials($name){
        $initials = '';
        $words = explode(' ', $name);
        foreach ($words as $w) {
            $initials .= $w[0];
        }

        return strtoupper($initials);
    }

}