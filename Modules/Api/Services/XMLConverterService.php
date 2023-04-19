<?php

namespace Modules\Api\Services;

use stdClass;

class XMLConverterService implements XMLConverterServiceInterface
{
    /**
     * @see XMLConverterServiceInterface::convert()
     */
    public function convert($data)
    {
        return $this->convertToJson($data);
    }

    // Cleans up ugly JSON data by removing @attributes tag
    function cleanupJson ($uglyJson) {
        if (is_object($uglyJson)) {
            $niceJson = new stdClass();
            foreach ($uglyJson as $attr => $value) {
                if ($attr == '@attributes') {
                    foreach ($value as $xattr => $xvalue) {
                        $niceJson->$xattr = $xvalue;
                    }
                } else {
                    $niceJson->$attr = $this->cleanupJson($value);
                }
            }
            return $niceJson;
        } else if (is_array($uglyJson)) {
            $niceJson = array();
            foreach ($uglyJson as $n => $e) {
                $niceJson[$n] = $this->cleanupJson($e);
            }
            return $niceJson;
        } else {
            return $uglyJson;
        }
    }

    // Convert XML to JSON
    function convertToJson ($xmlString) {
        $xml = simplexml_load_string($xmlString);
        $uglyJson = json_decode(json_encode($xml));
        $niceJson = $this->cleanupJson($uglyJson);
        return json_encode($niceJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
