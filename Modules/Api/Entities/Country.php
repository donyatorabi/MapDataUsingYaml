<?php

namespace Modules\Api\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    protected static function newFactory()
    {
        return \Modules\Api\Database\factories\CountryFactory::new();
    }
}
