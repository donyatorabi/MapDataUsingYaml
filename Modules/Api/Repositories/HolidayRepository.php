<?php

namespace Modules\Api\Repositories;

use Modules\Api\Entities\Holiday;
use Modules\Api\Entities\HolidayCountry;

class HolidayRepository implements HolidayRepositoryInterface
{
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * @see HolidayRepositoryInterface::storeHoliday()
     */
    public function storeHoliday(array $holidays, array $countryIds)
    {
        $holidayId = Holiday::query()->where($holidays)
            ->first('id')
        ;
        if (empty($holidayId)) {
            $holidayId = Holiday::query()->create($holidays)
                ->first('id')
            ;
        }


        if (!empty($countryIds) && !empty($holidayId)) {
            $holidayId = $holidayId->toArray()['id'];
            foreach ($countryIds[0] as $countryId) {
                HolidayCountry::query()->firstOrCreate(
                    [
                        'holiday_id' => $holidayId,
                        'country_id' => $countryId
                    ],
                    [
                        'holiday_id' => $holidayId,
                        'country_id' => $countryId
                    ]);
            }
        }

    }
}
