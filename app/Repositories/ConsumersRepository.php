<?php

namespace App\Repositories;

interface ConsumersRepository{

    /**
     * Method to get consumer by its id (uuid)
     */
    public function findConsumer(string $id);

}
