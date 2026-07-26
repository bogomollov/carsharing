<?php

namespace Tests\Feature\Api;

use App\Enums\BillsStatus;
use App\Models\Bill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsApiUser;
use Tests\TestCase;

class BillControllerTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsApiUser;

    private function payload(array $overrides = []): array
    {
        return array_merge(
            Bill::factory()->make()->getAttributes(),
            ['arendators_count' => 0],
            $overrides,
        );
    }

    public function test_guest_cannot_list_bills(): void
    {
        $this->getJson('/api/v1/bills')->assertUnauthorized();
    }

    public function test_can_list_bills(): void
    {
        $this->actingAsApiUser();
        Bill::factory()->count(3)->create();

        $this->getJson('/api/v1/bills')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_can_show_bill(): void
    {
        $this->actingAsApiUser();
        $bill = Bill::factory()->create();

        $this->getJson("/api/v1/bills/{$bill->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $bill->id);
    }

    public function test_can_create_bill(): void
    {
        $this->actingAsApiUser();

        $this->postJson('/api/v1/bills', $this->payload(['arendators_count' => 2]))
            ->assertCreated()
            ->assertJsonPath('data.arendators_count', 2);

        $this->assertDatabaseCount('bills', 1);
    }

    public function test_creating_bill_requires_fields(): void
    {
        $this->actingAsApiUser();

        $this->postJson('/api/v1/bills', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['arendators_count', 'balance', 'type', 'status']);
    }

    public function test_can_update_bill(): void
    {
        $this->actingAsApiUser();
        $bill = Bill::factory()->create();

        $this->putJson("/api/v1/bills/{$bill->id}", $this->payload(['arendators_count' => 5]))
            ->assertOk()
            ->assertJsonPath('data.arendators_count', 5);

        $this->assertDatabaseHas('bills', ['id' => $bill->id, 'arendators_count' => 5]);
    }

    public function test_can_delete_bill(): void
    {
        $this->actingAsApiUser();
        $bill = Bill::factory()->create(['status' => BillsStatus::Open]);

        $this->deleteJson("/api/v1/bills/{$bill->id}")
            ->assertOk()
            ->assertJsonPath('data.status', BillsStatus::Closed);

        $this->assertSoftDeleted('bills', ['id' => $bill->id]);
    }

    public function test_can_change_status(): void
    {
        $this->actingAsApiUser();
        $bill = Bill::factory()->create(['status' => BillsStatus::Open]);

        $this->patchJson("/api/v1/bills/{$bill->id}/status", ['status' => BillsStatus::Frozen])
            ->assertOk()
            ->assertJsonPath('data.status', BillsStatus::Frozen);

        $this->assertDatabaseHas('bills', ['id' => $bill->id, 'status' => BillsStatus::Frozen]);
    }

    public function test_changing_to_same_status_returns_422(): void
    {
        $this->actingAsApiUser();
        $bill = Bill::factory()->create(['status' => BillsStatus::Open]);

        $this->patchJson("/api/v1/bills/{$bill->id}/status", ['status' => BillsStatus::Open])
            ->assertStatus(422);
    }
}
