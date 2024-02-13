<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\BillsStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('arendator_id')->comment("Идентификатор арендатора");
            $table->foreignUuid('bill_id')->nullable()->references('id')->on('transactions');
            $table->decimal('balance', 10,2)->comment("Баланс счёта");
            $table->enum('status', BillsStatus::getValues())->default(BillsStatus::Open)->comment("Статус счёта");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
};
