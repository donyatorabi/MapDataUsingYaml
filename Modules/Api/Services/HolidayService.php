<?php

namespace Modules\Api\Services;

use Illuminate\Support\Facades\DB;
use Modules\Api\Entities\Country;
use Modules\Api\Entities\HolidayCountry;
use Modules\Api\Repositories\CountryRepository;
use Modules\Api\Repositories\CountryRepositoryInterface;
use Modules\Api\Repositories\HolidayRepository;
use Modules\Api\Repositories\HolidayRepositoryInterface;
use Modules\Api\Utils\Cfg\CfgMapper;

class HolidayService implements HolidayServiceInterface
{
    /**
     * @var HolidayRepository
     */
    private $holidayRepository;

    /**
     * @var CountryRepository
     */
    private $countryRepository;

    public function __construct(HolidayRepositoryInterface $holidayRepository,
                                CountryRepositoryInterface $countryRepository)
    {
        $this->holidayRepository = $holidayRepository;
        $this->countryRepository = $countryRepository;
    }

    public function saveHoliday($mapper, $data)
    {
        $holidays   = [];
        DB::beginTransaction();
        try {
            foreach ($data as $datum) {
                $countryIds = [];
                foreach ($mapper as $mapIndex => $map) {
                    if (array_key_exists($mapIndex, $datum)) {

                        if ($mapIndex == CfgMapper::COUNTRY_MAPPER_NAME) {

                            if (!empty($datum[$mapIndex])) {
                                $countryIds[] = $this->countryRepository->storeCountry($datum[$mapIndex]);
                            }

                        } else {
                            $holidays[$map['key']] = $datum[$mapIndex];
                        }
                    }
                }
                $this->holidayRepository->storeHoliday($holidays, $countryIds);
                $holidays = [];
            }
            DB::commit();
            return [
                'success' => true,
                'message' => 'Action Was Done Successfully!'
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception('sth went wrong!', 400);
        }

    }
}
