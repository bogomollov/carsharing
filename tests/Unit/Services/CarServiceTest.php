<?php

namespace Tests\Unit\Services;

use App\Enums\CarsStatus;
use App\Http\Resources\Car\CarResource;
use App\Models\Car;
use App\Services\CarService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class CarServiceTest extends TestCase
{
    use RefreshDatabase;

    private CarService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CarService();
    }

    public function test_get_status_returns_car_status(): void
    {
        $car = Car::factory()->create(['status' => CarsStatus::Maintenance]);

        $this->assertSame(CarsStatus::Maintenance, $this->service->getStatus($car));
    }

    public function test_set_status_to_same_status_returns_422(): void
    {
        $car = Car::factory()->create(['status' => CarsStatus::Maintenance]);

        $response = $this->service->setStatus($car, CarsStatus::Maintenance);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(422, $response->getStatusCode());
    }

    public function test_set_status_to_expectation_soft_deletes_the_car(): void
    {
        $car = Car::factory()->create(['status' => CarsStatus::Rented]);

        $result = $this->service->setStatus($car, CarsStatus::Expectation);

        $this->assertInstanceOf(CarResource::class, $result);
        $this->assertSoftDeleted('cars', ['id' => $car->id]);
    }

    public function test_set_status_updates_status_and_returns_resource(): void
    {
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);

        $result = $this->service->setStatus($car, CarsStatus::Maintenance);

        $this->assertInstanceOf(CarResource::class, $result);
        $this->assertDatabaseHas('cars', ['id' => $car->id, 'status' => CarsStatus::Maintenance]);
    }

    public function test_check_is_status(): void
    {
        $car = Car::factory()->create(['status' => CarsStatus::Rented]);

        $this->assertTrue($this->service->checkIsStatus($car, [CarsStatus::Rented, CarsStatus::Maintenance]));
        $this->assertFalse($this->service->checkIsStatus($car, [CarsStatus::Expectation]));
    }
}
