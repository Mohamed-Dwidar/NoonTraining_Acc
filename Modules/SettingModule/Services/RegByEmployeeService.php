<?php

namespace Modules\SettingModule\Services;

use Modules\SettingModule\Repository\RegByEmployeeRepository;

class RegByEmployeeService
{
    private $regByEmployeeRepository;

    public function __construct(RegByEmployeeRepository $regByEmployeeRepository)
    {
        $this->regByEmployeeRepository = $regByEmployeeRepository;
    }

    public function create($data)
    {
        return $this->regByEmployeeRepository->create([
            'name' => trim($data->name),
            'is_active' => 1,
        ]);
    }

    public function update($data)
    {
        return $this->regByEmployeeRepository->update([
            'name' => trim($data->name),
            'is_active' => $data->is_active ? 1 : 0,
        ], $data->id);
    }

    public function findAll()
    {
        return $this->regByEmployeeRepository->findAllWithRegsCount();
    }

    public function findAllActive($columns = ['*'])
    {
        return $this->regByEmployeeRepository->findAllActive($columns);
    }

    public function findActiveOne($id)
    {
        return $this->regByEmployeeRepository->findActiveOne($id);
    }

    public function findOne($id)
    {
        return $this->regByEmployeeRepository->findOneOrNull($id);
    }

    /** Soft delete — registrations keep the name */
    public function deleteOne($id)
    {
        return $this->regByEmployeeRepository->delete($id);
    }
}
