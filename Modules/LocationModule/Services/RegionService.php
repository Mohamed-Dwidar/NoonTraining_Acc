<?php


namespace Modules\LocationModule\Services;


use Modules\LocationModule\Repository\RegionRepository;

class RegionService
{
    private $regionRepository;

    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }    

    function getAll()
    {
        return $this->regionRepository->get();
    }   

    function getByCity($city_id)
    {
        return $this->regionRepository->findByField('city_id',$city_id);
    }
}
