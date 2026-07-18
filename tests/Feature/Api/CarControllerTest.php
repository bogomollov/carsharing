<?php

namespace Tests\Feature\Api;

use App\Enums\CarsStatus;
use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsApiUser;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsApiUser;

    private function payload(array $overrides = []): array
    {
        $model = CarModel::factory()->create();

        return array_merge(
            Car::factory()->make(['model_id' => $model->id])->getAttributes(),
            $overrides,
        );
    }

    public function test_guest_cannot_list_cars(): void
    {
        $this->getJson('/api/v1/cars')->assertUnauthorized();
    }

    public function test_can_list_cars(): void
    {
        $this->actingAsApiUser();
        Car::factory()->count(3)->create();

        $this->getJson('/api/v1/cars')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_can_show_car(): void
    {
        $this->actingAsApiUser();
        $car = Car::factory()->create();

        $this->getJson("/api/v1/cars/{$car->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $car->id);
    }

    public function test_can_create_car(): void
    {
        $this->actingAsApiUser();

        $this->postJson('/api/v1/cars', $this->payload(['mileage' => 12345]))
            ->assertCreated()
            ->assertJsonPath('data.mileage', 12345);

        $this->assertDatabaseCount('cars', 1);
    }

    public function test_creating_car_requires_fields(): void
    {
        $this->actingAsApiUser();

        $this->postJson('/api/v1/cars', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['model_id', 'status', 'mileage', 'license_plate', 'vin', 'location']);
    }

    public function test_can_update_car(): void
    {
        $this->actingAsApiUser();
        $car = Car::factory()->create();

        $this->putJson("/api/v1/cars/{$car->id}", $this->payload(['mileage' => 999]))
            ->assertOk()
            ->assertJsonPath('data.mileage', 999);

        $this->assertDatabaseHas('cars', ['id' => $car->id, 'mileage' => 999]);
    }

    public function test_can_delete_car(): void
    {
        $this->actingAsApiUser();
        $car = Car::factory()->create(['status' => CarsStatus::Rented]);

        $this->deleteJson("/api/v1/cars/{$car->id}")
            ->assertOk()
            ->assertJsonPath('data.status', CarsStatus::Expectation);

        $this->assertSoftDeleted('cars', ['id' => $car->id]);
    }

    public function test_can_change_status(): void
    {
        $this->actingAsApiUser();
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);

        $this->patchJson("/api/v1/cars/{$car->id}/status", ['status' => CarsStatus::Maintenance])
            ->assertOk()
            ->assertJsonPath('data.status', CarsStatus::Maintenance);

        $this->assertDatabaseHas('cars', ['id' => $car->id, 'status' => CarsStatus::Maintenance]);
    }

    public function test_changing_to_same_status_returns_422(): void
    {
        $this->actingAsApiUser();
        $car = Car::factory()->create(['status' => CarsStatus::Expectation]);

        $this->patchJson("/api/v1/cars/{$car->id}/status", ['status' => CarsStatus::Expectation])
            ->assertStatus(422);
    }

    public function test_positions_endpoint_is_public_and_returns_only_rented_cars(): void
    {
        $rented = Car::factory()->create([
            'status' => CarsStatus::Rented,
            'location' => '55.751244 37.618423',
        ]);
        Car::factory()->create(['status' => CarsStatus::Expectation]);

        $response = $this->getJson('/api/v1/cars/positions')->assertOk();

        $response->assertJsonCount(1);
        $response->assertJson([
            [
                'id' => $rented->id,
                'latitude' => 55.751244,
                'longitude' => 37.618423,
            ],
        ]);
    }
}
