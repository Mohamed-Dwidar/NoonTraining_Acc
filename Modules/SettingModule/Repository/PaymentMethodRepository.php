<?php

namespace Modules\SettingModule\Repository;

use Modules\SettingModule\app\Http\Models\PaymentMethod;
use Prettus\Repository\Eloquent\BaseRepository;

class PaymentMethodRepository extends BaseRepository
{
    function model()
    {
        return PaymentMethod::class;
    }

    /** All methods (admin list) with the number of payments for each */
    public function findAllWithPaymentsCount()
    {
        return PaymentMethod::withCount('payments')->orderBy('id')->get();
    }

    /** Active methods only (for the dropdown) */
    public function findAllActive($columns = ['*'])
    {
        return PaymentMethod::where('is_active', 1)->orderBy('id')->get($columns);
    }

    public function findActiveOne($id)
    {
        return PaymentMethod::where('is_active', 1)->where('id', $id)->first();
    }

    public function findOneOrNull($id)
    {
        return PaymentMethod::where('id', $id)->first();
    }

    /** Non-deleted method by exact name (used to map old text values) */
    public function findOneByName($name)
    {
        return PaymentMethod::where('name', trim((string) $name))->first();
    }
}
