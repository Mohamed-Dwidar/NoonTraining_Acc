<?php

namespace Modules\LocationModule\Repository;

use Modules\LocationModule\app\Http\Models\Region;
use Prettus\Repository\Eloquent\BaseRepository;

class RegionRepository extends BaseRepository
{

    public function model()
    {
        return Region::class;
    }
 
}