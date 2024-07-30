<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carsmodels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('mark_id')->nullable()->references('id')->on('carsmarks')->nullOnDelete()->comment("Идентификатор бренда");
            $table->string('name')->comment("Название модели ТС");
            $table->string('car_type')->comment('Тип кузова');
            $table->string('fuel_type')->comment('Тип топлива');
            $table->integer('door_count')->comment('Количество автомобильных дверей');
            $table->integer('seat_count')->comment('Количество пассажирских мест');
            $table->string('gear_box')->comment('Тип коробки передач');
            $table->string('drive_type')->comment('Вид привода');
            $table->integer('engine_power')->comment('Мощность двигателя');
            $table->year('year')->comment('Год выпуска');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carsmodels');
    }
};
