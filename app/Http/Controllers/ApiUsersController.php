<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateUserRequest;
use App\Http\Requests\GetByIdRequest;
use App\Http\Requests\GetUsersRequest;
use App\Services\UsersService;

/**
* @OA\Info(title="API Users", version="1.0")
* @OA\SecurityScheme(
*     securityScheme="basicAuth",
*      in="header",
*      name="Basic Auth",
*     type="http",
*     scheme="basic"
* )
*@OA\Schema(
*     schema="UserResponse",
*     title="Users response",
*     type="object",
*     @OA\Property(
*         property="id",
*         type="integer"
*     ),
*     @OA\Property(
*         property="email",
*         type="string"
*     ),
*     @OA\Property(
*         property="first_name",
*         type="string"
*     ),
*     @OA\Property(
*         property="last_name",
*         type="string"
*     ),
*     @OA\Property(
*         property="avatar",
*         type="string"
*     ),
*)
*@OA\Schema(
*     schema="UserRequest",
*     title="Users request",
*     required={"email","first_name"},
*     type="object",
*     @OA\Property(
*         property="email",
*         type="string"
*     ),
*     @OA\Property(
*         property="first_name",
*         type="string"
*     ),
*     @OA\Property(
*         property="last_name",
*         type="string"
*     ),
*     @OA\Property(
*         property="avatar",
*         type="string"
*     ),
*)
*@OA\Schema(
*     schema="UserResponsePag",
*     title="Users response paginated",
*     type="object",
*     @OA\Property(
*         property="page",
*         type="integer"
*     ),
*     @OA\Property(
*         property="total",
*         type="integer"
*     ),
*     @OA\Property(
*         property="total_pages",
*         type="integer"
*     ),
*     @OA\Property(
*         property="per_page",
*         type="integer"
*     ),
*     @OA\Property(
*         property="data",
*         type="array",
*         @OA\Items(ref="#/components/schemas/UserResponse"),
*     ),
*),
*@OA\Schema(
*     schema="ErrorValidation",
*     title="ErroValidation",
*     type="object",
*     @OA\Property(
*         property="errors",
*         type="object",
*          @OA\Property(
*              property="attribute",
*              type="array",
*              @OA\Items(
*                 type="string"
*              ),
*          ),
*     ),
*)
*/
class ApiUsersController extends Controller
{
    //

    private $usersService;

    public function __construct(UsersService $service)
    {
        $this->usersService = $service;
    }


    /**
    * @OA\Get(
    *     path="/api/users",
    *     tags={"Users"},
    *     summary="Show all users",
    *     description = "Return a json with users and information about pagination",
    *     @OA\Parameter(
    *           name="page",
    *           in="query",
    *           description="Number of page",
    *           required=false
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Ok",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *              @OA\Schema(ref="#/components/schemas/UserResponsePag"),
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Internal server error"
    *     )
    * )
    */
    public function index(GetUsersRequest $request){
        $response = null;
        if($request->has('page')){
            $response = $this->usersService->findAllUsers($request->page);
        }else{
            $response = $this->usersService->findAllUsers();
        }
        $status = $response['status'];
        unset($response['status']);

        return response()->json($response, $status);
    }

    /**
    * @OA\Get(
    *     path="/api/users/{id}",
    *     tags={"Users"},
    *     summary="Show user by id",
    *     description = "Return a json with users information",
    *     security={
    *           {"basicAuth":{}}
    *     },
    *     @OA\Parameter(
    *           name="id",
    *           in="path",
    *           description="Id of the user",
    *           required=true
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Ok",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/UserResponse"),
    *         )
    *     ),
    *     @OA\Response(
    *         response=204,
    *         description="No user was found"
    *     ),
    *     @OA\Response(
    *         response=403,
    *         description="Forbidden"
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Internal server error"
    *     )
    * )
    */
    public function getById($id, GetByIdRequest $request){
        $response = $this->usersService->findById($id);

        if($response['status'] == 500){
            return response()->json(['message' => 'There was an error on fetching data, please try again'], $response['status']);
        }
        return response()->json($response['data'], $response['status']);
    }


    /**
    * @OA\Post(
    *     path="/api/users",
    *     tags={"Users"},
    *     summary="Create a new user",
    *     description = "Only returns a message when ther was an error",
    *     @OA\RequestBody(
    *         description="User to add",
    *         required=true,
    *         @OA\MediaType(
    *               mediaType="application/json",
    *               @OA\Schema(ref="#/components/schemas/UserRequest"),
    *         ),
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="User was saved",
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Error on request data",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/ErrorValidation"),
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Internal server error"
    *     )
    * )
    */
    public function saveUser(CreateUpdateUserRequest $request){
        $response = $this->usersService->createUser($request->all());

        if($response['status']== 500){
            return response()->json(['message' => 'There was an error on saving data, please try again'], $response['status']);
        }
        return response()->json(null, $response['status']);

    }

    /**
    * @OA\Put(
    *     path="/api/users/{id}",
    *     tags={"Users"},
    *     summary="Update a user in db",
    *     description = "Only returns a message when ther was an error",
    *     @OA\Parameter(
    *           name="id",
    *           in="path",
    *           description="Id of the user",
    *           required=true
    *     ),
    *     @OA\RequestBody(
    *         description="User to add",
    *         required=true,
    *         @OA\MediaType(
    *               mediaType="application/json",
    *               @OA\Schema(ref="#/components/schemas/UserRequest"),
    *         ),
    *     ),
    *     @OA\Response(
    *         response=204,
    *         description="User was updated or user not exist",
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Error on request data",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(ref="#/components/schemas/ErrorValidation"),
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Internal server error"
    *     )
    * )
    */
    public function updateUser($id, CreateUpdateUserRequest $request){
        $response = $this->usersService->updateUser($id,$request->all());
        if($response['status']== 500){
            return response()->json(['message' => 'There was an error on changing data, please try again'], $response['status']);
        }
        if($response['updated']== false){
            return response()->json(['message' => "The user doens't exist"], $response['status']);
        }
        return response()->json(null, $response['status']);

    }




}
