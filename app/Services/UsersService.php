<?php

namespace App\Services;

use App\Repositories\UsersRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use PDOException;

class UsersService{

    private $usersRepository;
    private $num_elements;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->num_elements = env('PAGINATE_ELEMENTS', 5);
    }

    /**
     * Service to get all information of users and paginate them
     * @param int number of page
     * @return array with the data of users and information of the pagination
     */
    public function findAllUsers($page = 1){
        $result = null;
        try{
            $total = $this->usersRepository->countAllUsers();
            $total_pages = ceil( $total / $this->num_elements);
            $user_result = $this->usersRepository->getAllUsersPaginated($page);

            $result = [
                'data' => $user_result,
                'status' => 200,
                'page' => $page,
                'total' => $total,
                'total_pages' => $total_pages,
                'per_page' => $this->num_elements
            ];

        }catch(PDOException $e){
            Log::error("There was an error on fetching data in user service");
            Log::error("Error message: ".$e->getMessage());
            $result = [
                'data' => [],
                'status' => 500,
                'page' => $page,
                'total' => 0,
                'total_pages' => 0,
                'per_page' => $this->num_elements
            ];

        }catch(Exception $e){
            Log::error("There was an error in user service");
            Log::error("Error message: ".$e->getMessage());
            $result = [
                'data' => [],
                'status' => 500,
                'page' => $page,
                'total' => 0,
                'total_pages' => 0,
                'per_page' => $this->num_elements
            ];
        }

        return $result;

    }

    /**
     * Service to get information of a user by its id
     * @param int id of the user
     * @return array with the data of user and a status
     */
    public function findById($id){
        $result = null;

        try{
            $user = $this->usersRepository->getUserById($id);
            if(!$user){
                return [
                    'data' => null,
                    'status' => 204
                ];
            }
            $result = [
                'data' => $user,
                'status' => 200
            ];
        }catch(PDOException $e){
            Log::error("There was an error on fetching data in user service on id ".$id);
            Log::error("Error message: ".$e->getMessage());
            $result = [
                'data' => null,
                'status' => 500
            ];
        }catch(Exception $e){
            Log::error("There was an error in user service consulting by id ".$id);
            Log::error("Error message: ".$e->getMessage());
            $result = [
                'data' => null,
                'status' => 500
            ];

        }
        return $result;

    }

    /**
     * Service method that stores a new user in db
     * @param array user information
     */
    public function createUser(array $userData){
        try{
            $this->usersRepository->createUser($userData);
            return ['created' => true, 'status' => 201];

        }catch(PDOException $e){
            Log::error("There was an error when creating a user in user service due db problem");
            Log::error("Error message: ".$e->getMessage());
            return ['created' => false, 'status' => 500];
        }
        catch(Exception $e){
            Log::error("There was an error when user service creating user");
            Log::error("Error message: ".$e->getMessage());
            return ['created' => false, 'status' => 500];
        }
    }

    /**
     * Method to update a user on db
     * @param int id of user to update
     * @param array details of user to update
     */
    public function updateUser(int $id, array $userDetails){
        try{
            $updated = $this->usersRepository->updateUser( $id, $userDetails );
            if($updated){
                return ['status' => 204, 'updated' => true];
            }
            return ['status' => 204, 'updated' => false];

        }catch(PDOException $e){
            Log::error("There was an error when updating a user in user service due db problem");
            Log::error("Error message: ".$e->getMessage());
            return ['updated' => false, 'status' => 500];
        }catch(Exception $e){
            Log::error("There was an error when user service creating user");
            Log::error("Error message: ".$e->getMessage());
            return ['updated' => false, 'status' => 500];
        }
    }



}
