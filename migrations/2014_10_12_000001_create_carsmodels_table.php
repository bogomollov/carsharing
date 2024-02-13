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
            $table->foreignUuid('mark_id')->comment("Идентификатор марки машины");
            $table->foreignUuid('model_id')->nullable()->references('id')->on('cars');
            $table->string('name')->comment("Название модели машины");
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
