<?php

namespace Tests\Feature\Api;

use App\Models\Arendator;
use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsApiUser;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsApiUser;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'arendator_id' => Arendator::factory()->create()->id,
            'bill_id' => Bill::factory()->create()->id,
            'modification' => '50.00',
        ], $overrides);
    }

    public function test_guest_cannot_list_transactions(): void
    {
        $this->getJson('/api/v1/transactions')->assertUnauthorized();
    }

    public function test_can_list_transactions(): void
    {
        $this->actingAsApiUser();
        Transaction::factory()->count(3)->create();

        $this->getJson('/api/v1/transactions')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_can_show_transaction(): void
    {
        $this->actingAsApiUser();
        $transaction = Transaction::factory()->create();

        $this->getJson("/api/v1/transactions/{$transaction->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $transaction->id);
    }

    public function test_can_create_transaction(): void
    {
        $this->actingAsApiUser();

        $this->postJson('/api/v1/transactions', $this->payload())
            ->assertCreated()
            ->assertJsonPath('data.modification', '50.00');

        $this->assertDatabaseCount('transactions', 1);
    }

    public function test_creating_transaction_adjusts_bill_balance(): void
    {
        $this->actingAsApiUser();
        $bill = Bill::factory()->create(['balance' => 100]);

        $this->postJson('/api/v1/transactions', $this->payload(['bill_id' => $bill->id, 'modification' => '50.00']))
            ->assertCreated();

        $this->assertEquals(150.00, (float) Bill::find($bill->id)->balance);
    }

    public function test_creating_transaction_requires_fields(): void
    {
        $this->actingAsApiUser();

        $this->postJson('/api/v1/transactions', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['arendator_id', 'bill_id', 'modification']);
    }

    public function test_can_update_transaction(): void
    {
        $this->actingAsApiUser();
        $transaction = Transaction::factory()->create();

        $this->putJson("/api/v1/transactions/{$transaction->id}", $this->payload(['modification' => '75.00']))
            ->assertOk()
            ->assertJsonPath('data.modification', '75.00');

        $this->assertDatabaseHas('transactions', ['id' => $transaction->id, 'modification' => '75.00']);
    }

    public function test_can_delete_transaction(): void
    {
        $this->actingAsApiUser();
        $transaction = Transaction::factory()->create();

        $this->deleteJson("/api/v1/transactions/{$transaction->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $transaction->id);

        $this->assertSoftDeleted('transactions', ['id' => $transaction->id]);
    }
}
