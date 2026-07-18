<?php

namespace Tests\Feature\Api;

use App\Enums\ArendatorsStatus;
use App\Enums\BillsStatus;
use App\Enums\CarsStatus;
use App\Enums\RentsStatus;
use App\Models\Arendator;
use App\Models\Bill;
use App\Models\Car;
use App\Models\Rent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsApiUser;
use Tests\TestCase;

class RentControllerTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsApiUser;

    private function activeArendator(array $overrides = []): Arendator
    {
        $bill = Bill::factory()->create(['balance' => 500, 'status' => BillsStatus::Open]);

        return Arendator::factory()->create(array_merge([
            'status' => ArendatorsStatus::Active,
            'default_bill_id' => $bill->id,
        ], $overrides));
    }

    public function test_guest_cannot_list_rents(): void
    {
        $this->getJson('/api/v1/rents')->assertUnauthorized();
    }

    public function test_can_list_rents(): void
    {
        $this->actingAsApiUser();
        Rent::factory()->count(3)->create();

        $this->getJson('/api/v1/rents')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_can_show_rent(): void
    {
        $this->actingAsApiUser();
        $rent = Rent::factory()->create();

        $this->getJson("/api/v1/rents/{$rent->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $rent->id);
    }

    public function test_can_open_rent(): void
    {
        $this->actingAsApiUser();
        $arendator = $this->activeArendator();
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);

        $this->postJson('/api/v1/rents', ['arendator_id' => $arendator->id, 'car_id' => $car->id])
            ->assertCreated()
            ->assertJsonPath('data.arendator_id', $arendator->id)
            ->assertJsonPath('data.car_id', $car->id)
            ->assertJsonPath('data.status', RentsStatus::Open);

        $this->assertDatabaseHas('cars', ['id' => $car->id, 'status' => CarsStatus::Rented]);
        $this->assertDatabaseCount('rents', 1);
    }

    public function test_opening_rent_fails_when_arendator_not_active(): void
    {
        $this->actingAsApiUser();
        $arendator = $this->activeArendator(['status' => ArendatorsStatus::Blocked]);
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);

        $this->postJson('/api/v1/rents', ['arendator_id' => $arendator->id, 'car_id' => $car->id])
            ->assertStatus(403);
    }

    public function test_opening_rent_fails_when_car_not_available(): void
    {
        $this->actingAsApiUser();
        $arendator = $this->activeArendator();
        $car = Car::factory()->create(['status' => CarsStatus::Rented]);

        $this->postJson('/api/v1/rents', ['arendator_id' => $arendator->id, 'car_id' => $car->id])
            ->assertStatus(403);
    }

    public function test_opening_rent_fails_when_arendator_has_no_default_bill(): void
    {
        $this->actingAsApiUser();
        $arendator = Arendator::factory()->create([
            'status' => ArendatorsStatus::Active,
            'default_bill_id' => null,
        ]);
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);

        $this->postJson('/api/v1/rents', ['arendator_id' => $arendator->id, 'car_id' => $car->id])
            ->assertStatus(403);
    }

    public function test_opening_rent_fails_when_balance_too_low(): void
    {
        $this->actingAsApiUser();
        $arendator = $this->activeArendator();
        Bill::where('id', $arendator->default_bill_id)->update(['balance' => 0.5]);
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);

        $this->postJson('/api/v1/rents', ['arendator_id' => $arendator->id, 'car_id' => $car->id])
            ->assertStatus(403);
    }

    public function test_can_update_rent(): void
    {
        $this->actingAsApiUser();
        $rent = Rent::factory()->create();
        $arendator = Arendator::factory()->create();
        $car = Car::factory()->create();

        $this->putJson("/api/v1/rents/{$rent->id}", [
            'car_id' => $car->id,
            'arendator_id' => $arendator->id,
            'status' => RentsStatus::Closed,
            'start_datetime' => now()->subHour()->toDateTimeString(),
            'end_datetime' => now()->toDateTimeString(),
            'rented_time' => 60,
            'total_price' => 300,
        ])
            ->assertOk()
            ->assertJsonPath('data.status', RentsStatus::Closed);

        $this->assertDatabaseHas('rents', ['id' => $rent->id, 'car_id' => $car->id, 'rented_time' => 60]);
    }

    public function test_can_delete_rent(): void
    {
        $this->actingAsApiUser();
        $rent = Rent::factory()->create();

        $this->deleteJson("/api/v1/rents/{$rent->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $rent->id);

        $this->assertSoftDeleted('rents', ['id' => $rent->id]);
    }

    public function test_can_close_rent(): void
    {
        $this->actingAsApiUser();
        $now = now();
        $this->travelTo($now);

        $bill = Bill::factory()->create(['balance' => 1000, 'status' => BillsStatus::Open]);
        $arendator = Arendator::factory()->create([
            'status' => ArendatorsStatus::Active,
            'default_bill_id' => $bill->id,
        ]);
        $car = Car::factory()->create(['status' => CarsStatus::Rented, 'price_minute' => 10]);
        $rent = Rent::factory()->create([
            'car_id' => $car->id,
            'arendator_id' => $arendator->id,
            'status' => RentsStatus::Open,
            'start_datetime' => $now->copy()->subMinutes(20),
        ]);

        $this->patchJson("/api/v1/rents/{$rent->id}")
            ->assertOk()
            ->assertJsonPath('data.status', RentsStatus::Closed)
            ->assertJsonPath('data.rented_time', 20)
            ->assertJsonPath('data.total_price', 200);

        $this->assertDatabaseHas('cars', ['id' => $car->id, 'status' => CarsStatus::Expectation]);
        $this->assertDatabaseCount('transactions', 1);
        $this->assertEquals(800.0, (float) Bill::find($bill->id)->balance);
    }

    public function test_closing_rent_fails_when_not_open(): void
    {
        $this->actingAsApiUser();
        $rent = Rent::factory()->create(['status' => RentsStatus::Closed]);

        $this->patchJson("/api/v1/rents/{$rent->id}")->assertStatus(403);
    }

    public function test_closing_rent_fails_when_car_not_rented(): void
    {
        $this->actingAsApiUser();
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);
        $rent = Rent::factory()->create([
            'car_id' => $car->id,
            'status' => RentsStatus::Open,
        ]);

        $this->patchJson("/api/v1/rents/{$rent->id}")->assertStatus(403);
    }

    public function test_closing_rent_fails_when_arendator_has_no_default_bill(): void
    {
        $this->actingAsApiUser();
        $arendator = Arendator::factory()->create(['default_bill_id' => null]);
        $car = Car::factory()->create(['status' => CarsStatus::Rented]);
        $rent = Rent::factory()->create([
            'car_id' => $car->id,
            'arendator_id' => $arendator->id,
            'status' => RentsStatus::Open,
        ]);

        $this->patchJson("/api/v1/rents/{$rent->id}")->assertStatus(400);
    }
}
