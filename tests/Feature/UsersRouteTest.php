<?php

namespace Tests\Feature;

use App\Http\Controllers\ApiUsersController;
use App\Http\Requests\GetUsersRequest;
use App\Services\UsersService;
use Mockery;
use Tests\TestCase;

class UsersRouteTest extends TestCase
{
    private $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = Mockery::mock('App\Services\UsersService');
        $this->app->instance(UsersService::class, $this->userService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * Method to test endpoint to get all users paginated
     * @return void
     */
    public function test_get_all_users(){
        $this->userService->shouldReceive('findAllUsers')->with(1)->once()->andReturn(['status' => 200,'data' => []]);

        $response = $this->get('/api/users?page=1');

        $response->assertStatus(200)->assertJsonFragment(['data' => []]);
    }

    /**
     * Method to test endpoint to get all users without a page
     */
    public function test_get_all_users_without_parameter(){
        $this->userService->shouldReceive('findAllUsers')->once()->andReturn(['status' => 200,'data' => []]);
        $response = $this->get('/api/users');

        $response->assertStatus(200)->assertJsonFragment(['data' => []]);

    }

    /**
     * Method to test endpoint to get all users when user sent a bad argument
     */
    public function test_get_all_users_on_bad_argument(){

        $this->app->instance(UsersService::class, $this->userService);
        $response = $this->get('/api/users?page=0', ['accept' => 'application/json']);

        $response->assertStatus(422);
    }

    /**
     * Method to test get user by id
     */
    public function test_get_user_by_id(){
        $data = ['id' => 1,
            'email' => "george.bluth@reqres.in",
            'first_name' => "George",
            'last_name' => "Bluth",
            'avatar' => "https://reqres.in/img/faces/1-image.jpg"
        ];
        $this->userService->shouldReceive('findById')->with(1)->once()->andReturn(['data' => $data, 'status' => 200]);
        $response = $this->get('/api/users/1', ['Authorization' => 'Base ' . base64_encode('e9a39381-9bb0-37c1-aba5-117a13fd5d68'.':'.'password')]);

        $response->assertStatus(200)->assertJson( $data );
    }

    /**
     * Method to test get user by id when no user is found
     */
    public function test_get_user_by_id_when_user_not_found(){
        $this->userService->shouldReceive('findById')->with(1)->once()->andReturn(['data' => [], 'status' => 204]);
        $response = $this->get('/api/users/1', ['Authorization' => 'Base ' . base64_encode('e9a39381-9bb0-37c1-aba5-117a13fd5d68'.':'.'password')]);

        $response->assertStatus(204);
    }

    /**
     * Method to test get user by id on bad request
     */
    public function test_get_user_by_id_on_bad_request(){
        $response = $this->get('/api/users/test');
        $response2 = $this->get('/api/users/-1');

        $response->assertStatus(404);
        $response2->assertStatus(404);
    }

    /**
     * Method to test get user by id on bad credentials
     */
    public function test_get_user_by_id_with_bad_credentials(){
        $response = $this->get('/api/users/1', ['Authorization' => 'Base ' . base64_encode('e9a39381-9bb0-37c1-aba5-117a13fd5d68'.':'.'password2')]);

        $response->assertStatus(403);
    }

    /**
     * Method to test creating of new user
     */
    public function test_create_user(){
        $user = ['first_name' => 'John', 'email' => 'test@test.com'];
        $this->userService->shouldReceive('createUser')->with($user)->once()->andReturn(['created' => true, 'status' => 201]);
        $response = $this->post('/api/users', $user, ['accept'=> 'application/json']);
        $response->assertStatus(201);
    }

    /**
     * Method to test creating of new user with bad data
     */
    public function test_create_user_with_bad_data(){
        $user = ['first_name' => '', 'email' => 'test@test.com'];

        $response = $this->post('/api/users', $user, ['accept'=> 'application/json']);
        $response->assertStatus(422);
    }

    /**
     * Method to test update of a user
     */
    public function test_update_user(){
        $user = ['first_name' => 'John', 'email' => 'test@test.com'];
        $id = 1;
        $this->userService->shouldReceive('updateUser')->withArgs([$id, $user])->once()->andReturn(['updated' => true, 'status' => 204]);
        $response = $this->put('/api/users/1', $user);
        $response->assertStatus(204);
    }

    /**
     * Method to test update of a user when user doenst exist
     */
    public function test_update_user_that_dont_exist(){
        $user = ['first_name' => 'John', 'email' => 'test@test.com'];
        $id = 1;
        $this->userService->shouldReceive('updateUser')->withArgs([$id, $user])->once()->andReturn(['updated' => false, 'status' => 204]);
        $response = $this->put('/api/users/1', $user);
        $response->assertStatus(204);
    }

    /**
     * Method to test update user when bad data was send
     */
    public function test_update_user_on_bad_request(){
        $user = ['first_name' => 'John', 'email' => 'test'];
        $response = $this->put('/api/users/1', $user, ['accept'=> 'application/json']);
        $response->assertStatus(422);
    }



}
