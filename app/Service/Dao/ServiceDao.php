<?php

namespace App\Service\Dao;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\Service;

class ServiceDao
{
    /**
     * @param $id
     * @param bool $throw
     * @return
     */
    public function first($id, $throw = true)
    {
        $model = Service::query()->find($id);
        if ($throw && empty($model)) {
            throw new BusinessException(ErrorCode::SERVER_ERROR);
        }
        return $model;
    }
}
