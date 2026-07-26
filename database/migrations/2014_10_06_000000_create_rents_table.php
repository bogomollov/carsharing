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
            $table->foreignUuid('car_id')->nullable()->constrained('cars')->cascadeOnUpdate()->nullOnDelete()->comment("РРґРµРЅС‚РёС„РёРєР°С‚РѕСЂ РўРЎ");
            $table->foreignUuid('arendator_id')->nullable()->constrained('arendators')->cascadeOnUpdate()->nullOnDelete()->comment("РРґРµРЅС‚РёС„РёРєР°С‚РѕСЂ Р°СЂРµРЅРґР°С‚РѕСЂР°");
            $table->string('status')->comment("РЎС‚Р°С‚СѓСЃ Р°СЂРµРЅРґС‹");
            $table->dateTime('start_datetime')->nullable()->comment("Р”Р°С‚Р° Рё РІСЂРµРјСЏ РЅР°С‡Р°Р»Р° Р°СЂРµРЅРґС‹");
            $table->dateTime('end_datetime')->nullable()->comment("Р”Р°С‚Р° Рё РІСЂРµРјСЏ РѕРєРѕРЅС‡Р°РЅРёСЏ Р°СЂРµРЅРґС‹");
            $table->unsignedBigInteger('rented_time')->nullable()->comment("РћР±С‰РµРµ РІСЂРµРјСЏ Р°СЂРµРЅРґС‹");
            $table->decimal('total_price', 10,2)->nullable()->comment("РС‚РѕРіРѕРІР°СЏ С†РµРЅР° Р°СЂРµРЅРґС‹");
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
