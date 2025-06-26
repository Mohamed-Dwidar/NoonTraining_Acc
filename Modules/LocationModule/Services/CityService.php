<?php


namespace Modules\LocationModule\Services;


use Modules\LocationModule\Repository\CityRepository;

class CityService
{
    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }    

    function getAll()
    {
        return $this->cityRepository->get();
    }
}
