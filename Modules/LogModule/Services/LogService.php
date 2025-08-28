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

    public function recordLog($action, $desription, $url, $userable_id = null, $userable_type = null)
    {
        $this->logRepository->create([
            'action' => $action,
            'description' => $desription,
            'url' => $url,
            'userable_id' => $userable_id ?? auth()->id(),
            'userable_type' => $userable_type ?? get_class(auth()->user()),
        ]);
        return true;
    }

    public function findAll()
    {
        return $this->logRepository->orderBy('created_at', 'DESC');
    }

    public function findAllWithFilter(array $request)
    {
        return $this->logRepository->filter($request);
    }
}
