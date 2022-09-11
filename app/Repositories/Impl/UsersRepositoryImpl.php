<?php

namespace App\Repositories\Impl;

use App\Models\User;
use App\Repositories\UsersRepository;

class UsersRepositoryImpl implements UsersRepository{

    private $userModel;
    private $num_elements;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
        $this->num_elements = env('PAGINATE_ELEMENTS', 5);
    }

    public function countAllUsers(){
        return $this->userModel->count();
    }

    public function getAllUsersPaginated(int $page = 1){
        $offset = ($page - 1) * $this->num_elements;
        return $this->userModel
            ->skip($offset)
            ->take($this->num_elements)
            ->get(['id', 'email', 'first_name', 'last_name', 'avatar'])
            ->toArray();

    }

    public function getUserById(int $id){
        $result = $this->userModel->where('id',$id)->get(['id', 'email', 'first_name', 'last_name', 'avatar'])->first();
        if(!$result){
            return null;
        }
        return $result->toArray();

    }

    public function createUser(array $user){

        return $this->userModel->create($user);


    }

    public function updateUser(int $id, array $userDetails){

        return $this->userModel->whereId($id)->update($userDetails);

    }

}
