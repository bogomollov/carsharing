<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\BillsStatus;
use App\Enums\BillsType;

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
            $table->string("arendators_count")->default(1)->comment("Количество пользователей связанных со счётом");
            $table->decimal('balance', 10,2)->comment("Баланс счёта");
            $table->enum("type", BillsType::getValues())->default(BillsType::Personal)->comment("Тип счёта");
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
