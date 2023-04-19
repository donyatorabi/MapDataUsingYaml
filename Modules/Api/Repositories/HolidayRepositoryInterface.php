<?php

namespace Modules\Api\Repositories;

interface HolidayRepositoryInterface
{
    /**
     * @param array $holidays
     * @param array $countryIds
     * @return mixed
     */
    public function storeHoliday(array $holidays, array $countryIds);
}
