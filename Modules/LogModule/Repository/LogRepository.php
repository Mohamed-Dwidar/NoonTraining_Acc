<?php

namespace Modules\LogModule\Repository;

use Modules\LogModule\app\Http\Models\Log;
use Prettus\Repository\Eloquent\BaseRepository;

class  LogRepository extends BaseRepository
{

    public function model()
    {
        return Log::class;
    }

    public function createLog($model)
    {
        return $model->logs()->create([
            'login_time' => now()
        ]);
    }
}
