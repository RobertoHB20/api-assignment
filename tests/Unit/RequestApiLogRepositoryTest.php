<?php

namespace Tests\Unit;

use App\Repositories\Impl\RequestApiLogRepositoryImpl;
use Mockery;
use PHPUnit\Framework\TestCase;

class RequestApiLogRepositoryTest extends TestCase
{
    private $requestApiModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->requestApiModel = Mockery::mock('App\Models\UsersRequestLogModel');
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }


    /**
     * Method to test fetching last page in db
     */
    public function test_get_last_page(){
        $this->requestApiModel->shouldReceive('select')->with('page')->once()->andReturn($this->requestApiModel);
        $this->requestApiModel->shouldReceive('where')->withArgs(['status', 1])->once()->andReturn($this->requestApiModel);
        $this->requestApiModel->shouldReceive('orderBy')->withArgs(['id', 'desc'])->once()->andReturn($this->requestApiModel);
        $this->requestApiModel->shouldReceive('first')->once()->andReturn(['page' => 1]);

        $repository = new RequestApiLogRepositoryImpl($this->requestApiModel);

        $last_page = $repository->getLastPage();

        $this->assertEquals(['page' => 1], $last_page);
    }

    /**
     * Method to test creation of new record
     */
    public function test_save_new_record(){
        $page = 1;
        $this->requestApiModel->shouldReceive('create')->with(['page' => $page])->once()->andReturn($this->requestApiModel);
        $repository = new RequestApiLogRepositoryImpl($this->requestApiModel);

        $data = $repository->savePage($page);

        $this->assertTrue( $data != null );
    }
}
