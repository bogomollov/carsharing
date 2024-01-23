<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\CarsStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('model_id')->comment("Идентификатор модели машины");
            $table->enum('status', CarsStatus::getValues())->default(CarsStatus::Maintenance)->comment("Статус ТС");
            $table->unsignedInteger('mileage')->comment("Пробег ТС");
            $table->string('location')->comment("Координаты текущего местоположения ТС");
            $table->unsignedInteger('price_minute')->nullable()->comment("Минутная цена аренды");
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('cars', function (Blueprint $table) {
            $table->foreignUuid('car_id')->nullable()->references('id')->on('rents');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
