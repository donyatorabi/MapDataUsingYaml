<?php

namespace Modules\Api\Services;

use Modules\Api\Utils\Utility\DataConvert;
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

    public function __construct(CurlServiceInterface         $curlService,
                                XMLConverterServiceInterface $decoderService)
    {
        $this->curlService      = $curlService;
        $this->decoderService   = $decoderService;
    }

    public function getCurl($url)
    {
        $response = $this->curlService->getOpenApiCurl($url);
        if (DataConvert::isJson($response)) {
            return json_decode($response);
        }

        return $this->decoderService->convert($response);
    }
}
