<?php

namespace App\Repositories;

interface UsersRepository{

    /**
     * Method to count all the users in users table
     * @return int
     */
    public function countAllUsers();

    /**
     * Method to get all users in users table but using pagination and each page contains X register(5 by default),
     * number of register migth be changed in .env file
     * @param int number of page, by default it gets page 1
     * @return array with information of n users
     */
    public function getAllUsersPaginated(int $page = 1);

    /**
     * Method to get informacion of a user by its id
     * @param int id of the user
     * @return null|array null if user doesn't exit otherwise it returns user's data as array
     */
    public function getUserById(int $id);

    /**
     * Method to create a new user in users table
     * @param array with users information to create
     * @return App\Models\User the information of user created
     */
    public function createUser(array $user);


    /**
     * Method to update a user by its id
     * @param int id of the user
     * @param array information of the user
     * @return int 1 in case a user was updated, 0 otherwise
     */
    public function updateUser(int $id, array $userDetails);

}
