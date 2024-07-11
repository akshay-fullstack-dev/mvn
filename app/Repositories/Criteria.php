<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IGenericRepository;

abstract class Criteria
{

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public abstract function apply($model, IGenericRepository $repository);
}
