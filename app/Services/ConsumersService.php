<?php

namespace App\Services;

use App\Repositories\ConsumersRepository;
use Illuminate\Support\Facades\Hash;

class ConsumersService {

    private $consumerRepository;

    public function __construct(ConsumersRepository $consumerRepository)
    {
        $this->consumerRepository = $consumerRepository;
    }


    public function validateConsumer(string $id, string $secret){
        $consumer = $this->consumerRepository->findConsumer($id);

        if(!$consumer){
            return false;
        }
        if(Hash::check($secret, $consumer->secret)){
            return true;
        }
        return false;
    }


}
