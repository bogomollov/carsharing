<?php

namespace Tests\Unit\Services;

use App\Enums\ArendatorsStatus;
use App\Enums\BillsStatus;
use App\Http\Resources\Arendator\ArendatorResource;
use App\Models\Arendator;
use App\Models\Bill;
use App\Services\ArendatorService;
use App\Services\BillService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class ArendatorServiceTest extends TestCase
{
    use RefreshDatabase;

    private ArendatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ArendatorService(new BillService());
    }

    public function test_get_status_returns_arendator_status(): void
    {
        $arendator = Arendator::factory()->create(['status' => ArendatorsStatus::Active]);

        $this->assertSame(ArendatorsStatus::Active, $this->service->getStatus($arendator));
    }

    public function test_set_status_to_same_status_returns_422(): void
    {
        $arendator = Arendator::factory()->create(['status' => ArendatorsStatus::Active]);

        $response = $this->service->setStatus($arendator, ArendatorsStatus::Active);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(422, $response->getStatusCode());
    }

    public function test_set_status_to_deleted_soft_deletes_the_arendator(): void
    {
        $arendator = Arendator::factory()->create(['status' => ArendatorsStatus::Active]);

        $result = $this->service->setStatus($arendator, ArendatorsStatus::Deleted);

        $this->assertInstanceOf(ArendatorResource::class, $result);
        $this->assertSoftDeleted('arendators', ['id' => $arendator->id]);
    }

    public function test_set_status_updates_status(): void
    {
        $arendator = Arendator::factory()->create(['status' => ArendatorsStatus::Active]);

        $this->service->setStatus($arendator, ArendatorsStatus::Frozen);

        $this->assertDatabaseHas('arendators', ['id' => $arendator->id, 'status' => ArendatorsStatus::Frozen]);
    }

    public function test_set_default_bill_to_current_default_returns_422(): void
    {
        $bill = Bill::factory()->create(['status' => BillsStatus::Open]);
        $arendator = Arendator::factory()->create(['default_bill_id' => $bill->id]);

        $response = $this->service->setDefaultBill($arendator, $bill->id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(422, $response->getStatusCode());
    }

    public function test_set_default_bill_to_non_open_bill_returns_400(): void
    {
        $currentBill = Bill::factory()->create();
        $arendator = Arendator::factory()->create(['default_bill_id' => $currentBill->id]);
        $closedBill = Bill::factory()->create(['status' => BillsStatus::Closed]);

        $response = $this->service->setDefaultBill($arendator, $closedBill->id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(400, $response->getStatusCode());
    }

    public function test_set_default_bill_updates_arendator_and_bill_counters(): void
    {
        $currentBill = Bill::factory()->create();
        $arendator = Arendator::factory()->create(['default_bill_id' => $currentBill->id]);
        $newBill = Bill::factory()->create(['status' => BillsStatus::Open]);

        $result = $this->service->setDefaultBill($arendator, $newBill->id);

        $this->assertInstanceOf(ArendatorResource::class, $result);
        $this->assertDatabaseHas('arendators', ['id' => $arendator->id, 'default_bill_id' => $newBill->id]);
        $this->assertDatabaseHas('bills', ['id' => $newBill->id, 'arendators_count' => 1]);
    }

    public function test_check_default_bill(): void
    {
        $arendator = Arendator::factory()->create();
        $this->assertTrue($this->service->checkDefaultBill($arendator));

        $arendator->default_bill_id = null;
        $this->assertFalse($this->service->checkDefaultBill($arendator));
    }

    public function test_check_balance_on_default_bill(): void
    {
        $bill = Bill::factory()->create(['balance' => 250.75]);
        $arendator = Arendator::factory()->create(['default_bill_id' => $bill->id]);

        $this->assertEquals(250.75, $this->service->checkBalanceOnDefaultBill($arendator));

        $arendator->default_bill_id = null;
        $this->assertNull($this->service->checkBalanceOnDefaultBill($arendator));
    }
}
