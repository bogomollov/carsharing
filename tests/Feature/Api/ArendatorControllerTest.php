<?php

namespace Tests\Feature\Api;

use App\Enums\ArendatorsStatus;
use App\Enums\BillsStatus;
use App\Models\Arendator;
use App\Models\Bill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsApiUser;
use Tests\TestCase;

class ArendatorControllerTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsApiUser;

    private function payload(array $overrides = []): array
    {
        $bill = Bill::factory()->create(['status' => BillsStatus::Open]);

        return array_merge(
            Arendator::factory()->make(['default_bill_id' => $bill->id])->getAttributes(),
            $overrides,
        );
    }

    public function test_guest_cannot_list_arendators(): void
    {
        $this->getJson('/api/v1/arendators')->assertUnauthorized();
    }

    public function test_can_list_arendators(): void
    {
        $this->actingAsApiUser();
        Arendator::factory()->count(3)->create();

        $this->getJson('/api/v1/arendators')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_can_show_arendator(): void
    {
        $this->actingAsApiUser();
        $arendator = Arendator::factory()->create();

        $this->getJson("/api/v1/arendators/{$arendator->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $arendator->id);
    }

    public function test_show_unknown_arendator_returns_404(): void
    {
        $this->actingAsApiUser();

        $this->getJson('/api/v1/arendators/'.fake()->uuid())->assertNotFound();
    }

    public function test_can_create_arendator(): void
    {
        $this->actingAsApiUser();

        $response = $this->postJson('/api/v1/arendators', $this->payload(['first_name' => 'Ivan']));

        $response->assertCreated()->assertJsonPath('data.first_name', 'Ivan');
        $this->assertDatabaseHas('arendators', ['first_name' => 'Ivan']);
    }

    public function test_creating_arendator_requires_fields(): void
    {
        $this->actingAsApiUser();

        $this->postJson('/api/v1/arendators', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'password', 'last_name', 'first_name']);
    }

    public function test_can_update_arendator(): void
    {
        $this->actingAsApiUser();
        $arendator = Arendator::factory()->create();

        $this->putJson("/api/v1/arendators/{$arendator->id}", $this->payload(['first_name' => 'Updated']))
            ->assertOk()
            ->assertJsonPath('data.first_name', 'Updated');

        $this->assertDatabaseHas('arendators', ['id' => $arendator->id, 'first_name' => 'Updated']);
    }

    public function test_can_delete_arendator(): void
    {
        $this->actingAsApiUser();
        $arendator = Arendator::factory()->create(['status' => ArendatorsStatus::Active]);

        $this->deleteJson("/api/v1/arendators/{$arendator->id}")
            ->assertOk()
            ->assertJsonPath('data.status', ArendatorsStatus::Deleted);

        $this->assertSoftDeleted('arendators', ['id' => $arendator->id]);
    }

    public function test_can_change_status(): void
    {
        $this->actingAsApiUser();
        $arendator = Arendator::factory()->create(['status' => ArendatorsStatus::Active]);

        $this->patchJson("/api/v1/arendators/{$arendator->id}/status", ['status' => ArendatorsStatus::Frozen])
            ->assertOk()
            ->assertJsonPath('data.status', ArendatorsStatus::Frozen);

        $this->assertDatabaseHas('arendators', ['id' => $arendator->id, 'status' => ArendatorsStatus::Frozen]);
    }

    public function test_changing_to_same_status_returns_422(): void
    {
        $this->actingAsApiUser();
        $arendator = Arendator::factory()->create(['status' => ArendatorsStatus::Active]);

        $this->patchJson("/api/v1/arendators/{$arendator->id}/status", ['status' => ArendatorsStatus::Active])
            ->assertStatus(422);
    }

    public function test_can_set_default_bill(): void
    {
        $this->actingAsApiUser();
        $oldBill = Bill::factory()->create(['status' => BillsStatus::Open]);
        $newBill = Bill::factory()->create(['status' => BillsStatus::Open]);
        $arendator = Arendator::factory()->create(['default_bill_id' => $oldBill->id]);

        $this->patchJson("/api/v1/arendators/{$arendator->id}/bill", ['default_bill_id' => $newBill->id])
            ->assertOk()
            ->assertJsonPath('data.default_bill_id', $newBill->id);

        $this->assertDatabaseHas('arendators', ['id' => $arendator->id, 'default_bill_id' => $newBill->id]);
    }

    public function test_setting_same_default_bill_returns_422(): void
    {
        $this->actingAsApiUser();
        $bill = Bill::factory()->create(['status' => BillsStatus::Open]);
        $arendator = Arendator::factory()->create(['default_bill_id' => $bill->id]);

        $this->patchJson("/api/v1/arendators/{$arendator->id}/bill", ['default_bill_id' => $bill->id])
            ->assertStatus(422);
    }

    public function test_setting_non_open_bill_as_default_returns_400(): void
    {
        $this->actingAsApiUser();
        $oldBill = Bill::factory()->create(['status' => BillsStatus::Open]);
        $blockedBill = Bill::factory()->create(['status' => BillsStatus::Blocked]);
        $arendator = Arendator::factory()->create(['default_bill_id' => $oldBill->id]);

        $this->patchJson("/api/v1/arendators/{$arendator->id}/bill", ['default_bill_id' => $blockedBill->id])
            ->assertStatus(400);
    }
}
