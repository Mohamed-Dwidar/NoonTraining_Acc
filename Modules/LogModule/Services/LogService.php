<?php

namespace Modules\LogModule\Services;

use Modules\LogModule\Repository\LogRepository;

class  LogService
{
    private $logRepository;

    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    /**
     * Add Log
     * 
     * @param Model $model
     * @param String $guard
     * @param Int $userID
     * @param String $message default null
     * 
     * @return Log
     */
    public function recordLog($model)
    {
        return $this->logRepository->createLog($model);
    }

    public function findAll()
    {
        return $this->logRepository->orderBy('created_at', 'DESC');
    }
}
