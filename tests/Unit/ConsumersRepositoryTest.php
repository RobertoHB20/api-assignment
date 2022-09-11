<?php

namespace Tests\Unit;

use App\Repositories\Impl\ConsumersRepositoryImpl;
use Mockery;
use PHPUnit\Framework\TestCase;

class ConsumersRepositoryTest extends TestCase
{
    private $consumersModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->consumersModel = Mockery::mock('App\Models\ConsumersModel');
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_get_by_id(){
        $id = 'e9a39381-9bb0-37c1-aba5-117a13fd5d68';
        $this->consumersModel->shouldReceive('where')->once()->andReturn($this->consumersModel);
        $this->consumersModel->shouldReceive('where')->once()->andReturn($this->consumersModel);
        $this->consumersModel->shouldReceive('first')->once()->andReturn($this->consumersModel);

        $repository = new ConsumersRepositoryImpl($this->consumersModel);

        $result = $repository->findConsumer($id);

        $this->assertNotNull($result);
    }


}
