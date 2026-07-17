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
            $table->foreignUuid('model_id')->nullable()->references('id')->on('carsmodels')->nullOnDelete()->comment("Идентификатор модели ТС");
            $table->string('status')->comment("Статус ТС");
            $table->unsignedInteger('mileage')->comment("Пробег ТС");
            $table->string("license_plate")->unique()->comment("Регистрационный знак ТС")->unique('license_plate');
            $table->string("vin")->unique()->comment("Идентификационный номер ТС");
            $table->string('location')->comment("Координаты текущего местоположения ТС");
            $table->decimal('price_minute',100,2)->nullable()->comment("Минутная цена аренды");
            $table->timestamps();
            $table->softDeletes();
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
