<?php

namespace Tests\Unit\Services;

use App\Enums\ArendatorsStatus;
use App\Enums\CarsStatus;
use App\Enums\RentsStatus;
use App\Http\Resources\Rent\RentResource;
use App\Models\Arendator;
use App\Models\Bill;
use App\Models\Car;
use App\Models\Rent;
use App\Services\ArendatorService;
use App\Services\BillService;
use App\Services\CarService;
use App\Services\RentService;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class RentServiceTest extends TestCase
{
    use RefreshDatabase;

    private RentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new RentService(
            new ArendatorService(new BillService()),
            new CarService(),
            new BillService(),
            new TransactionService(),
        );
    }

    private function activeArendatorWithFunds(float $balance = 500): Arendator
    {
        $bill = Bill::factory()->create(['balance' => $balance]);

        return Arendator::factory()->create([
            'status' => ArendatorsStatus::Active,
            'default_bill_id' => $bill->id,
        ]);
    }

    public function test_open_rejects_inactive_arendator(): void
    {
        $arendator = Arendator::factory()->create(['status' => ArendatorsStatus::Blocked]);
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);

        $response = $this->service->open($arendator->id, $car->id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(403, $response->getStatusCode());
        $this->assertDatabaseCount('rents', 0);
    }

    public function test_open_rejects_car_that_is_not_available(): void
    {
        $arendator = $this->activeArendatorWithFunds();
        $car = Car::factory()->create(['status' => CarsStatus::Rented]);

        $response = $this->service->open($arendator->id, $car->id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(403, $response->getStatusCode());
    }

    public function test_open_rejects_arendator_without_default_bill(): void
    {
        $arendator = Arendator::factory()->create([
            'status' => ArendatorsStatus::Active,
            'default_bill_id' => null,
        ]);
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);

        $response = $this->service->open($arendator->id, $car->id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(403, $response->getStatusCode());
    }

    public function test_open_rejects_arendator_with_insufficient_balance(): void
    {
        $arendator = $this->activeArendatorWithFunds(0);
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);

        $response = $this->service->open($arendator->id, $car->id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(403, $response->getStatusCode());
    }

    public function test_open_creates_rent_and_marks_car_as_rented(): void
    {
        $arendator = $this->activeArendatorWithFunds();
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);

        $result = $this->service->open($arendator->id, $car->id);

        $this->assertInstanceOf(RentResource::class, $result);
        $this->assertDatabaseHas('rents', [
            'car_id' => $car->id,
            'arendator_id' => $arendator->id,
            'status' => RentsStatus::Open,
        ]);
        $this->assertDatabaseHas('cars', ['id' => $car->id, 'status' => CarsStatus::Rented]);
    }

    public function test_close_rejects_rent_that_is_not_open(): void
    {
        $arendator = $this->activeArendatorWithFunds();
        $car = Car::factory()->create(['status' => CarsStatus::Rented]);
        $rent = Rent::factory()->create([
            'car_id' => $car->id,
            'arendator_id' => $arendator->id,
            'status' => RentsStatus::Closed,
        ]);

        $response = $this->service->close($rent);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(403, $response->getStatusCode());
    }

    public function test_close_rejects_when_car_is_not_marked_rented(): void
    {
        $arendator = $this->activeArendatorWithFunds();
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);
        $rent = Rent::factory()->create([
            'car_id' => $car->id,
            'arendator_id' => $arendator->id,
            'status' => RentsStatus::Open,
        ]);

        $response = $this->service->close($rent);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(403, $response->getStatusCode());
    }

    public function test_close_settles_rent_updates_car_and_charges_bill(): void
    {
        $bill = Bill::factory()->create(['balance' => 500]);
        $arendator = Arendator::factory()->create([
            'status' => ArendatorsStatus::Active,
            'default_bill_id' => $bill->id,
        ]);
        $car = Car::factory()->create(['status' => CarsStatus::Rented, 'price_minute' => 10]);
        $rent = Rent::factory()->create([
            'car_id' => $car->id,
            'arendator_id' => $arendator->id,
            'status' => RentsStatus::Open,
            'start_datetime' => Carbon::now()->subMinutes(30),
        ]);

        $result = $this->service->close($rent);

        $this->assertInstanceOf(RentResource::class, $result);

        $rent->refresh();
        $this->assertEquals(RentsStatus::Closed, (string) $rent->status);
        $this->assertSame(30, $rent->rented_time);
        $this->assertEquals(300.0, $rent->total_price);

        $this->assertDatabaseHas('cars', ['id' => $car->id, 'status' => CarsStatus::Expectation]);
        $this->assertDatabaseHas('transactions', [
            'arendator_id' => $arendator->id,
            'bill_id' => $bill->id,
            'modification' => 300,
        ]);
        $this->assertEquals(200.0, $bill->fresh()->balance);
    }

    public function test_calculate_rented_time_computes_minutes_between_start_and_end(): void
    {
        $rent = Rent::factory()->create([
            'start_datetime' => Carbon::parse('2026-01-01 10:00:00'),
            'end_datetime' => Carbon::parse('2026-01-01 10:45:00'),
        ]);

        $this->service->calculateRentedTime($rent);

        $this->assertSame(45, $rent->fresh()->rented_time);
    }

    public function test_calculate_total_price_multiplies_price_by_rented_time(): void
    {
        $car = Car::factory()->create(['price_minute' => 12.5]);
        $rent = Rent::factory()->create(['rented_time' => 10]);

        $this->service->calculateTotalPrice($rent, $car);

        $this->assertEquals(125.0, $rent->fresh()->total_price);
    }
}
