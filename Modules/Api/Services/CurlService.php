<?php

namespace Modules\Api\Services;

use Modules\Api\Utils\Cfg\CfgCurlOptions;

class CurlService implements CurlServiceInterface
{
    function getOpenApiCurl($url) {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_MAXREDIRS      => CfgCurlOptions::CURLOPT_MAXREDIRS,     // stop after 10 redirects
            CURLOPT_CONNECTTIMEOUT => CfgCurlOptions::CURLOPT_CONNECTTIMEOUT,    // time-out on connect
            CURLOPT_TIMEOUT        => CfgCurlOptions::CURLOPT_TIMEOUT,    // time-out on response
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $content  = curl_exec($ch);

        curl_close($ch);

        return $content;
    }
}
