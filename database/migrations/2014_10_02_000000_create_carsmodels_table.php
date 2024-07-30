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
            $table->string('car_type');
            $table->string('fuel_type');
            $table->integer('door_count');
            $table->integer('seat_count');
            $table->string('gear_box');
            $table->integer('engine_power');
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
