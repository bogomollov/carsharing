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
            $table->unsignedBigInteger("arendators_count")->default(1)->comment("Количество пользователей связанных со счётом");
            $table->decimal('balance', 10,2)->comment("Баланс счёта");
            $table->string("type")->comment("Тип счёта");
            $table->string('status')->comment("Статус счёта");
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
