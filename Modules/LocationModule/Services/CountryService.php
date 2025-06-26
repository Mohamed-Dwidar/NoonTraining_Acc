<?php


namespace Modules\LocationModule\Services;


use Modules\LocationModule\Repository\CountryRepository;

class CountryService
{
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }    

    function getAll()
    {
        return $this->countryRepository->get();
    }
}
