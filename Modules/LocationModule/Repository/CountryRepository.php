<?php

namespace Modules\LocationModule\Repository;

use Modules\LocationModule\app\Http\Models\Country;
use Prettus\Repository\Eloquent\BaseRepository;

class CountryRepository extends BaseRepository
{

    public function model()
    {
        return Country::class;
    }
 
}
