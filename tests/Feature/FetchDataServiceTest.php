<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\FetchDataService;
use Mockery;

class FetchDataServiceTest extends TestCase
{

    private $pagesRepository;

    protected function setUp() : void
    {
        parent::setUp();
        $this->pagesRepository = Mockery::mock('App\Repositories\RequestApiLogRepository');
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * Method to test fetch users feature
     *
     * @return void
     */
    public function test_fetch_users(){
        $this->pagesRepository->shouldReceive('getLastPage')->once()->andReturn(['page' => 1]);
        $this->pagesRepository->shouldReceive('savePage')->with(2)->once();

        $instance = new FetchDataService($this->pagesRepository);
        $result = $instance->fetchData();
        $this->assertTrue( count($result['data']) > 0 );
    }

    /**
     *  Method to test response on exception
     *
     * @return void
     */
    public function test_response_on_exception(){
        $this->pagesRepository->shouldReceive('getLastPage')->andThrow('exception', 'there was an exception', 0);
        $instance = new FetchDataService($this->pagesRepository);
        $result = $instance->fetchData();
        $this->assertTrue( count($result['data']) == 0 );
    }




}
