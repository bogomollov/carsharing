<?php

namespace Tests\Feature\Api;

use App\Enums\CarsClasses;
use App\Enums\CarsTypes;
use App\Enums\DrivesType;
use App\Enums\FuelsType;
use App\Enums\GearBoxesType;
use App\Models\CarMark;
use App\Models\CarModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsApiUser;
use Tests\TestCase;

class CarModelControllerTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsApiUser;

    private function payload(array $overrides = []): array
    {
        $mark = CarMark::factory()->create();

        return array_merge(
            CarModel::factory()->make(['mark_id' => $mark->id])->getAttributes(),
            $overrides,
        );
    }

    public function test_guest_cannot_list_car_models(): void
    {
        $this->getJson('/api/v1/car-models')->assertUnauthorized();
    }

    public function test_can_list_car_models(): void
    {
        $this->actingAsApiUser();
        CarModel::factory()->count(3)->create();

        $this->getJson('/api/v1/car-models')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_can_show_car_model(): void
    {
        $this->actingAsApiUser();
        $model = CarModel::factory()->create();

        $this->getJson("/api/v1/car-models/{$model->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $model->id);
    }

    public function test_can_create_car_model(): void
    {
        $this->actingAsApiUser();

        $this->postJson('/api/v1/car-models', $this->payload(['engine_power' => 250]))
            ->assertCreated()
            ->assertJsonPath('data.engine_power', 250);

        $this->assertDatabaseCount('carsmodels', 1);
    }

    public function test_creating_car_model_requires_fields(): void
    {
        $this->actingAsApiUser();

        $this->postJson('/api/v1/car-models', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['mark_id', 'name', 'car_class', 'car_type', 'fuel_type', 'gear_box', 'drive_type', 'year']);
    }

    public function test_can_update_car_model(): void
    {
        $this->actingAsApiUser();
        $model = CarModel::factory()->create();

        $this->putJson("/api/v1/car-models/{$model->id}", $this->payload(['engine_power' => 180]))
            ->assertOk()
            ->assertJsonPath('data.engine_power', 180);

        $this->assertDatabaseHas('carsmodels', ['id' => $model->id, 'engine_power' => 180]);
    }

    public function test_can_delete_car_model(): void
    {
        $this->actingAsApiUser();
        $model = CarModel::factory()->create();

        $this->deleteJson("/api/v1/car-models/{$model->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $model->id);

        $this->assertSoftDeleted('carsmodels', ['id' => $model->id]);
    }

    public function test_can_set_mark(): void
    {
        $this->actingAsApiUser();
        $model = CarModel::factory()->create();
        $newMark = CarMark::factory()->create();

        $this->patchJson("/api/v1/car-models/{$model->id}/mark", ['mark_id' => $newMark->id])
            ->assertOk()
            ->assertJsonPath('data.mark_id', $newMark->id);

        $this->assertDatabaseHas('carsmodels', ['id' => $model->id, 'mark_id' => $newMark->id]);
    }

    public function test_can_set_class(): void
    {
        $this->actingAsApiUser();
        $model = CarModel::factory()->create();

        $this->patchJson("/api/v1/car-models/{$model->id}/class", ['car_class' => CarsClasses::Business])
            ->assertOk()
            ->assertJsonPath('data.car_class', CarsClasses::Business);

        $this->assertDatabaseHas('carsmodels', ['id' => $model->id, 'car_class' => CarsClasses::Business]);
    }

    public function test_can_set_type(): void
    {
        $this->actingAsApiUser();
        $model = CarModel::factory()->create();

        $this->patchJson("/api/v1/car-models/{$model->id}/type", ['car_type' => CarsTypes::Suv])
            ->assertOk()
            ->assertJsonPath('data.car_type', CarsTypes::Suv);

        $this->assertDatabaseHas('carsmodels', ['id' => $model->id, 'car_type' => CarsTypes::Suv]);
    }

    public function test_can_set_fuel_type(): void
    {
        $this->actingAsApiUser();
        $model = CarModel::factory()->create();

        $this->patchJson("/api/v1/car-models/{$model->id}/fuel", ['fuel_type' => FuelsType::Electric])
            ->assertOk()
            ->assertJsonPath('data.fuel_type', FuelsType::Electric);

        $this->assertDatabaseHas('carsmodels', ['id' => $model->id, 'fuel_type' => FuelsType::Electric]);
    }

    public function test_can_set_gear_box(): void
    {
        $this->actingAsApiUser();
        $model = CarModel::factory()->create();

        $this->patchJson("/api/v1/car-models/{$model->id}/gearbox", ['gear_box' => GearBoxesType::Automatic])
            ->assertOk()
            ->assertJsonPath('data.gear_box', GearBoxesType::Automatic);

        $this->assertDatabaseHas('carsmodels', ['id' => $model->id, 'gear_box' => GearBoxesType::Automatic]);
    }

    public function test_can_set_drive_type(): void
    {
        $this->actingAsApiUser();
        $model = CarModel::factory()->create();

        $this->patchJson("/api/v1/car-models/{$model->id}/drive", ['drive_type' => DrivesType::RearDrive])
            ->assertOk()
            ->assertJsonPath('data.drive_type', DrivesType::RearDrive);

        $this->assertDatabaseHas('carsmodels', ['id' => $model->id, 'drive_type' => DrivesType::RearDrive]);
    }
}
