<?php

namespace Tests\Unit\Services;

use App\Models\Arendator;
use App\Models\Bill;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_transaction_persists_transaction_with_given_data(): void
    {
        $bill = Bill::factory()->create();
        $arendator = Arendator::factory()->create(['default_bill_id' => $bill->id]);

        (new TransactionService())->createTransaction($arendator, $bill, 150.50);

        $this->assertDatabaseHas('transactions', [
            'arendator_id' => $arendator->id,
            'bill_id' => $bill->id,
            'modification' => 150.50,
        ]);
    }
}
