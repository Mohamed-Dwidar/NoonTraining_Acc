<?php

namespace Modules\SettingModule\Services;

use Modules\SettingModule\Repository\PaymentMethodRepository;

class PaymentMethodService
{
    private $paymentMethodRepository;

    public function __construct(PaymentMethodRepository $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function create($data)
    {
        return $this->paymentMethodRepository->create([
            'name' => trim($data->name),
            'is_active' => 1,
        ]);
    }

    public function update($data)
    {
        return $this->paymentMethodRepository->update([
            'name' => trim($data->name),
            'is_active' => $data->is_active ? 1 : 0,
        ], $data->id);
    }

    public function findAll()
    {
        return $this->paymentMethodRepository->findAllWithPaymentsCount();
    }

    public function findAllActive($columns = ['*'])
    {
        return $this->paymentMethodRepository->findAllActive($columns);
    }

    public function findActiveOne($id)
    {
        return $this->paymentMethodRepository->findActiveOne($id);
    }

    public function findOne($id)
    {
        return $this->paymentMethodRepository->findOneOrNull($id);
    }

    public function findOneByName($name)
    {
        return $this->paymentMethodRepository->findOneByName($name);
    }

    /** Soft delete — payments keep the name */
    public function deleteOne($id)
    {
        return $this->paymentMethodRepository->delete($id);
    }
}
