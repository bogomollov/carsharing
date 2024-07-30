<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\RentsStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('car_id')->comment("Идентификатор ТС");
            $table->foreignUuid('arendator_id')->comment("Идентификатор арендатора");
            $table->string('status')->comment("Статус аренды");
            $table->dateTime('start_datetime')->nullable()->comment("Дата и время начала аренды");
            $table->dateTime('end_datetime')->nullable()->comment("Дата и время окончания аренды");
            $table->unsignedBigInteger('rented_time')->nullable()->comment("Общее время аренды");
            $table->decimal('total_price', 10,2)->nullable()->comment("Итоговая цена аренды");
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
        Schema::dropIfExists('rents');
    }
};
