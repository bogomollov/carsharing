<?php

namespace Tests\Feature\Api;

use App\Models\CarMark;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsApiUser;
use Tests\TestCase;

class CarMarkControllerTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsApiUser;

    public function test_guest_cannot_list_car_marks(): void
    {
        $this->getJson('/api/v1/car-marks')->assertUnauthorized();
    }

    public function test_can_list_car_marks(): void
    {
        $this->actingAsApiUser();
        CarMark::factory()->count(3)->create();

        $this->getJson('/api/v1/car-marks')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_can_show_car_mark(): void
    {
        $this->actingAsApiUser();
        $mark = CarMark::factory()->create();

        $this->getJson("/api/v1/car-marks/{$mark->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $mark->id);
    }

    public function test_can_create_car_mark(): void
    {
        $this->actingAsApiUser();

        $this->postJson('/api/v1/car-marks', ['name' => 'Toyota'])
            ->assertCreated()
            ->assertJsonPath('data.name', 'Toyota');

        $this->assertDatabaseHas('carsmarks', ['name' => 'Toyota']);
    }

    public function test_creating_car_mark_requires_name(): void
    {
        $this->actingAsApiUser();

        $this->postJson('/api/v1/car-marks', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_can_update_car_mark(): void
    {
        $this->actingAsApiUser();
        $mark = CarMark::factory()->create();

        $this->putJson("/api/v1/car-marks/{$mark->id}", ['name' => 'Renamed'])
            ->assertOk()
            ->assertJsonPath('data.name', 'Renamed');

        $this->assertDatabaseHas('carsmarks', ['id' => $mark->id, 'name' => 'Renamed']);
    }

    public function test_can_delete_car_mark(): void
    {
        $this->actingAsApiUser();
        $mark = CarMark::factory()->create();

        $this->deleteJson("/api/v1/car-marks/{$mark->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $mark->id);

        $this->assertSoftDeleted('carsmarks', ['id' => $mark->id]);
    }
}
