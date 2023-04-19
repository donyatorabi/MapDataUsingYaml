<?php

namespace Modules\Api\Repositories;

interface CountryRepositoryInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function storeCountry($data);
}
