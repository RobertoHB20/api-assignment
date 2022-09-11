<?php

namespace App\Repositories\Impl;

use App\Models\ConsumersModel;
use App\Repositories\ConsumersRepository;

class ConsumersRepositoryImpl implements ConsumersRepository{

    private $consumersModel;

    public function __construct(ConsumersModel $consumersModel)
    {
        $this->consumersModel = $consumersModel;
    }


    public function findConsumer(string $id){

        return $this->consumersModel->where('id',$id)->where('status',1)->first();

    }

}
