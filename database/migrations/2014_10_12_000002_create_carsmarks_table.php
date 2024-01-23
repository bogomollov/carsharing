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
        Schema::create('carsmarks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('manufacturer_id')->comment("Идентификатор производителя машины");
            $table->string('name')->unique()->comment("Марка ТС");
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('carsmarks', function (Blueprint $table) {
            $table->foreignUuid('mark_id')->nullable()->references('id')->on('carsmodels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carsmarks');
    }
};
