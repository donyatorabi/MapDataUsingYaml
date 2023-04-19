<?php

namespace Modules\Api\Utils\Utility;

class DataConvert
{
    public static function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
