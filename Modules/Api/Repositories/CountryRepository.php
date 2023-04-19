<?php

namespace Modules\Api\Repositories;

use Modules\Api\Entities\Country;

class CountryRepository implements CountryRepositoryInterface
{
    public function storeCountry($data)
    {
        $res = '';
        foreach ($data as $datum) {
            $res = Country::query()->firstOrCreate(['title' => $datum], ['title' => $datum])
                ->pluck('id')->toArray();
        }

        return $res;
    }
}
