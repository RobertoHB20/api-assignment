<?php

namespace Tests\Unit;

use App\Models\ConsumersModel;
use App\Repositories\ConsumersRepository;
use App\Services\ConsumersService;
use Mockery;
use Tests\TestCase;

class ConsumersServiceTest extends TestCase
{
    private $consumersRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->consumersRepository = Mockery::mock(ConsumersRepository::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }



    public function test_service_with_valid_credentials(){
        $id = 'e9a39381-9bb0-37c1-aba5-117a13fd5d68';
        $result = new ConsumersModel(['id' => $id, 'secret' => '$2y$10$2UKuLFgPLt/UwY7zrSTZH.gibOxE.j4sznkgPFHiix0XmOFrc391y']);
        $this->consumersRepository->shouldReceive('findConsumer')->once()->andReturn( $result );
        $service = new ConsumersService($this->consumersRepository);

        $result = $service->validateConsumer($id, 'password');

        $this->assertTrue($result);
    }

    public function test_service_with_bad_credentials(){
        $id = 'e9a39381-9bb0-37c1-aba5-117a13fd5d68';
        $result = new ConsumersModel(['id' => $id, 'secret' => '$2y$10$2UKuLFgPLt/UwY7zrSTZH.gibOxE.j4sznkgPFHiix0XmOFrc391y']);
        $this->consumersRepository->shouldReceive('findConsumer')->once()->andReturn( $result );
        $service = new ConsumersService($this->consumersRepository);

        $result = $service->validateConsumer($id, 'password2');

        $this->assertFalse( $result );

    }

    public function test_service_with_no_user_registered(){
        $id = 'e9a39381-9bb0-37c1-aba5-117a13fd5d68';
        $this->consumersRepository->shouldReceive('findConsumer')->once()->andReturn( null );
        $service = new ConsumersService($this->consumersRepository);

        $result = $service->validateConsumer($id, 'password');

        $this->assertFalse( $result );

    }

}
