<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 28/06/2017
 * Time: 02:49
 */

namespace CyberWorks\Life\Helper;

class General
{
    public function guid($input)
    {
        $id = $input;
        $temp = '';
        for ($i = 0; $i < 8; $i++) {
            $temp .= chr($id & 0xFF);
            $id >>= 8;
        }

        return md5('BE' . $temp);
    }

    public function stripArray($input, $type)
    {
        switch ($type) {
            case 0:
                $array = explode("],[", $input);
                $array = str_replace('"[[', '', $array);
                $array = str_replace(']]"', '', $array);
                return str_replace('`', '', $array);
            case 1:
                $array = explode(",", $input);
                $array = str_replace('"[', '', $array);
                $array = str_replace(']"', '', $array);
                return str_replace('`', '', $array);
            case 2:
                $array = explode(",", $input);
                $array = str_replace('"[', '', $array);
                $array = str_replace(']"', '', $array);
                return str_replace('`', '', $array);
            case 3:
                $input = str_replace('"[`', '', $input);
                $input = str_replace('`]"', '', $input);
                return explode("`,`", $input);
                break;
            default:
                return [];
        }
    }

    public function before($needle, $haystack)
    {
        return substr($haystack, 0, strpos($haystack, $needle));
    }

    public function after($needle, $haystack)
    {
        if (!is_bool(strpos($haystack, $needle))) {
            return substr($haystack, strpos($haystack, $needle) + strlen($needle));
        }
    }

    public function arraySearch($needle, $id, $haystack)
    {
        foreach ($haystack as $value)
        {
            if ($value[$id] == $needle) return $value;
        }
        return null;
    }

    public function switchValue($current)
    {
        if ($current == 1) return 0;

        return 1;
    }

    public function processLicenses($input)
    {
        $stripped = General::stripArray($input, 0);

        $out = [];
        foreach ($stripped as $value){
            array_push($out, ["name" => General::before(",", $value), "value" => General::after(",", $value)]);
        }

        return $out;
    }
}

