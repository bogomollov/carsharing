<?php

namespace Tests\Unit\Services;

use App\Enums\BillsStatus;
use App\Enums\BillsType;
use App\Http\Resources\Bill\BillResource;
use App\Models\Arendator;
use App\Models\Bill;
use App\Services\BillService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Tests\TestCase;

class BillServiceTest extends TestCase
{
    use RefreshDatabase;

    private BillService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BillService();
    }

    public function test_get_status_returns_bill_status(): void
    {
        $bill = Bill::factory()->create(['status' => BillsStatus::Open]);

        $this->assertSame(BillsStatus::Open, $this->service->getStatus($bill));
    }

    public function test_set_status_to_same_status_returns_422(): void
    {
        $bill = Bill::factory()->create(['status' => BillsStatus::Open]);

        $response = $this->service->setStatus($bill, BillsStatus::Open);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(422, $response->getStatusCode());
    }

    public function test_set_status_to_closed_soft_deletes_the_bill(): void
    {
        $bill = Bill::factory()->create(['status' => BillsStatus::Open]);

        $result = $this->service->setStatus($bill, BillsStatus::Closed);

        $this->assertInstanceOf(BillResource::class, $result);
        $this->assertSoftDeleted('bills', ['id' => $bill->id]);
    }

    public function test_set_status_updates_status(): void
    {
        $bill = Bill::factory()->create(['status' => BillsStatus::Open]);

        $this->service->setStatus($bill, BillsStatus::Frozen);

        $this->assertDatabaseHas('bills', ['id' => $bill->id, 'status' => BillsStatus::Frozen]);
    }

    public function test_update_arendators_count_counts_related_arendators(): void
    {
        $bill = Bill::factory()->create();
        Arendator::factory()->count(2)->create(['default_bill_id' => $bill->id]);

        $this->service->updateArendatorsCount($bill->id);

        $this->assertDatabaseHas('bills', ['id' => $bill->id, 'arendators_count' => 2]);
    }

    public function test_update_arendators_count_with_unknown_bill_is_a_noop(): void
    {
        $this->assertNull($this->service->updateArendatorsCount((string) Str::uuid()));
    }

    public function test_update_bill_type_sets_corporated_when_multiple_arendators(): void
    {
        $bill = Bill::factory()->create(['arendators_count' => 2]);

        $this->service->updateBillType($bill->id);

        $this->assertDatabaseHas('bills', ['id' => $bill->id, 'type' => BillsType::Corporated]);
    }

    public function test_update_bill_type_sets_personal_when_single_arendator(): void
    {
        $bill = Bill::factory()->create(['arendators_count' => 1, 'type' => BillsType::Corporated]);

        $this->service->updateBillType($bill->id);

        $this->assertDatabaseHas('bills', ['id' => $bill->id, 'type' => BillsType::Personal]);
    }

    public function test_update_bill_type_blocks_bill_when_no_arendators(): void
    {
        $bill = Bill::factory()->create(['arendators_count' => 0, 'status' => BillsStatus::Open]);

        $this->service->updateBillType($bill->id);

        $this->assertDatabaseHas('bills', ['id' => $bill->id, 'status' => BillsStatus::Blocked]);
    }

    public function test_modificate_balance_adjusts_balance(): void
    {
        $bill = Bill::factory()->create(['balance' => 100]);

        $this->service->modificateBalance($bill, 50.25);

        $this->assertEquals(150.25, $bill->fresh()->balance);
    }
}
