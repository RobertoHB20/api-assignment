<?php

namespace App\Repositories\Impl;

use App\Models\UsersRequestLogModel;
use App\Repositories\RequestApiLogRepository;

class RequestApiLogRepositoryImpl implements RequestApiLogRepository{

    private $model;


    public function __construct(UsersRequestLogModel $model)
    {
        $this->model = $model;
    }



    public function savePage(int $page){
        return $this->model->create(['page' => $page]);
    }


    public function getLastPage(){
        return $this->model->select('page')->where('status', 1)->orderBy('id', 'desc')->first();
    }

}
