<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\Impl\UsersRepositoryImpl;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class UsersRepositoryTest extends TestCase
{
    private $userModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userModel = Mockery::mock('App\Models\User');
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }


    /**
     * Method to test counter users works
     * @return void
     */
    public function test_count_method(){
        $this->userModel->shouldReceive('count')->once()->andReturn(10);

        $repository = new UsersRepositoryImpl($this->userModel);
        $result = $repository->countAllUsers();

        $this->assertTrue( $result == 10 );
    }

    /**
     * Method to test method to get all users and paginate them
     * @return void
     */
    public function test_get_all_users_paginated(){
        $this->userModel->shouldReceive('skip')->once()->andReturn($this->userModel);
        $this->userModel->shouldReceive('take')->once()->andReturn($this->userModel);
        $this->userModel->shouldReceive('get')->once()->andReturn($this->userModel);
        $this->userModel->shouldReceive('toArray')->once()->andReturn([]);

        $repository = new UsersRepositoryImpl($this->userModel);
        $result = $repository->getAllUsersPaginated(1);

        $this->assertTrue( $result == [] );
    }

    /**
     * Method to test get user by id fetch data
     * @return void
     */
    public function test_method_to_get_by_id(){
        $this->userModel->shouldReceive('where')->withArgs(['id',1])->once()->andReturn($this->userModel);
        $this->userModel->shouldReceive('get')->once()->andReturn($this->userModel);
        $this->userModel->shouldReceive('first')->once()->andReturn($this->userModel);
        $this->userModel->shouldReceive('toArray')->once()->andReturn(['some' => 'data']);

        $repository = new UsersRepositoryImpl($this->userModel);
        $result = $repository->getUserById(1);

        $this->assertTrue( $result != null );
    }

    /**
     * Method to test update of a user
     * @return void
     */
    public function test_method_to_update_user(){
        $id = 1;
        $args = ['first_name' => 'John', 'email' => 'other@test.com'];
        $this->userModel->shouldReceive('whereId')->with($id)->once()->andReturn($this->userModel);
        $this->userModel->shouldReceive('update')->with($args)->once()->andReturn(1);

        $repository = new UsersRepositoryImpl($this->userModel);
        $result = $repository->updateUser($id,$args);

        $this->assertEquals( 1 ,$result );
    }

    /**
     * Method to test creation of a user
     * @return void
     */
    public function test_method_create_user(){
        $args = ['first_name' => 'John', 'email' => 'other@test.com'];
        $this->userModel->shouldReceive('create')->with($args)->once()->andReturn($this->userModel);

        $repository = new UsersRepositoryImpl($this->userModel);
        $result = $repository->createUser($args);

        $this->assertTrue( $result != null );

    }




}
