<?php

namespace Tests\Unit;

use App\Services\UsersService;
use Mockery;
use PDOException;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = Mockery::mock('App\Repositories\UsersRepository');
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }


    /**
     * Method to test UserServices works properly
     * @return void
     */
    public function test_get_all(){

        $this->userRepository->shouldReceive('countAllUsers')->andReturn(0);
        $this->userRepository->shouldReceive('getAllUsersPaginated')->andReturn([]);


        $service = new UsersService($this->userRepository);
        $result = $service->findAllUsers();

        $this->assertTrue( $result['data'] == [] );
        $this->assertTrue( $result['status'] == 200 );
        $this->assertTrue( $result['page'] == 1 );
        $this->assertTrue( $result['total_pages'] == 0 );

    }

    /**
     * Method to test when UserService throw an exception
     * @return void
    */
    public function test_when_get_all_throw_exception(){
        $this->userRepository->shouldReceive('countAllUsers')->andThrow(new PDOException("There was and error on db"));

        $service = new UsersService($this->userRepository);
        $result = $service->findAllUsers();

        $this->assertTrue( $result['data'] == [] );
        $this->assertTrue( $result['status'] == 500 );

    }


    /**
     * Method to test fetching user by id
     * @return void
     */
    public function test_search_by_id(){
        $id = 1;
        $this->userRepository->shouldReceive('getUserById')->with($id)->once()->andReturn($this->userRepository);

        $service = new UsersService($this->userRepository);
        $result = $service->findById($id);

        $this->assertTrue( isset($result['data']) );
        $this->assertTrue( $result['status'] == 200 );

    }

    /**
     * Method to test when there is an exception in search by id
     * @return void
     */
    public function test_search_by_id_throws_an_exception(){
        $this->userRepository->shouldReceive('getUserById')->andThrow(new PDOException("there was an error in db"));

        $service = new UsersService($this->userRepository);
        $result = $service->findById(1);

        $this->assertTrue( $result['data'] == null );
        $this->assertTrue( $result['status'] == 500 );
    }

    /**
     * Method to test seach by id and doesn't found an record
     * @return void
     */
    public function test_search_by_id_when_not_found(){
        $this->userRepository->shouldReceive('getUserById')->once()->andReturn(null);

        $service = new UsersService($this->userRepository);
        $result = $service->findById(1);

        $this->assertTrue( $result['data'] == null );
        $this->assertTrue( $result['status'] == 204 );
    }


    /**
     * Method to test creation of new user
     * @return void
     */
    public function test_save_new_user(){
        $user = ['fist_name' => 'John', 'email' => 'test@test.com'];
        $this->userRepository->shouldReceive('createUser')->with($user)->once()->andReturn(User::class);
        $service = new UsersService($this->userRepository);
        $result = $service->createUser($user);

        $this->assertTrue($result['created']);
    }

    /**
     * Method to test creating of a user when an exception appear
     * @return void
     */
    public function test_save_when_exception_appear(){
        $user = ['fist_name' => 'John', 'email' => 'test@test.com'];
        $this->userRepository->shouldReceive('createUser')->andThrow(new PDOException("There was an error on db"));
        $service = new UsersService($this->userRepository);
        $result = $service->createUser($user);

        $this->assertTrue(!$result['created']);
    }


    /**
     * Method to test user update
     * @return void
     */
    public function test_user_update(){
        $user = ['fist_name' => 'John', 'email' => 'test@test.com'];
        $id = 1;
        $this->userRepository->shouldReceive('updateUser')->withArgs([$id, $user])->once()->andReturn(1);
        $service = new UsersService($this->userRepository);
        $result = $service->updateUser($id, $user);

        $this->assertTrue($result['updated']);
        $this->assertTrue($result['status'] == 204);
    }

    /**
     * Method to test user update when there is an exception
     * @return void
     */
    public function test_user_update_when_exeption_appears(){
        $user = ['fist_name' => 'John', 'email' => 'test@test.com'];
        $id = 1;
        $this->userRepository->shouldReceive('updateUser')->andThrow(new PDOException("there is a problem in db"));
        $service = new UsersService($this->userRepository);
        $result = $service->updateUser($id, $user);

        $this->assertTrue(!$result['updated']);
        $this->assertTrue($result['status'] == 500);
    }







}
