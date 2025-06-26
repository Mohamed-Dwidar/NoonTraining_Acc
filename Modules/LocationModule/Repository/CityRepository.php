<?php

namespace Modules\LocationModule\Repository;

use Modules\LocationModule\app\Http\Models\City;
use Prettus\Repository\Eloquent\BaseRepository;

class CityRepository extends BaseRepository
{

    public function model()
    {
        return City::class;
    }
 
}
