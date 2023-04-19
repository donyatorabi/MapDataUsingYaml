<?php

namespace Modules\Api\Services;

use Modules\Api\Utils\Utility\DataConvert;
use Symfony\Component\Yaml\Yaml;
use function PHPUnit\Framework\isJson;

class ApiService implements ApiServiceInterface
{
    /**
     * @var CurlService
     */
    protected $curlService;

    /**
     * @var XMLConverterServiceInterface
     */
    protected $decoderService;

    /**
     * @var HolidayService
     */
    protected $holidayService;

    public function __construct(CurlServiceInterface         $curlService,
                                XMLConverterServiceInterface $decoderService,
                                HolidayServiceInterface      $holidayService)
    {
        $this->curlService      = $curlService;
        $this->decoderService   = $decoderService;
        $this->holidayService   = $holidayService;
    }

    public function getCurl($url)
    {
        $response = $this->curlService->getOpenApiCurl($url);
        if (DataConvert::isJson($response)) {
            $result = array_values(json_decode($response, true));
        } else {
            $result = $this->decoderService->convert($response);
        }

        //Parse YAML file and get json mapper from it
        $mapper = Yaml::parseFile(config_path('mapper.yaml'))['json'];

        return $this->holidayService->saveHoliday($mapper, $result);
    }
}
