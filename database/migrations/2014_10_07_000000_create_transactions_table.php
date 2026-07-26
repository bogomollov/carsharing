<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('arendator_id')->nullable()->constrained('arendators')->cascadeOnUpdate()->nullOnDelete()->comment("РРґРµРЅС‚РёС„РёРєР°С‚РѕСЂ Р°СЂРµРЅРґР°С‚РѕСЂР°");
            $table->foreignUuid('bill_id')->nullable()->constrained('bills')->cascadeOnUpdate()->nullOnDelete()->comment("РРґРµРЅС‚РёС„РёРєР°С‚РѕСЂ СЃС‡С‘С‚Р°");
            $table->decimal('modification',100,2)->comment("РР·РјРµРЅРµРЅРёРµ Р±Р°Р»Р°РЅСЃР°");
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
        Schema::dropIfExists('transactions');
    }
};
