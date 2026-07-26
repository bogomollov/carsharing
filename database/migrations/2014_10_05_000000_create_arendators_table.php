<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ArendatorsStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arendators', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique()->comment("РџРѕС‡С‚Р° Р°СЂРµРЅРґР°С‚РѕСЂР°");
            $table->string('password')->comment("РџР°СЂРѕР»СЊ Р°СЂРµРЅРґР°С‚РѕСЂР°");
            $table->foreignUuid('default_bill_id')->nullable()->constrained('bills')->cascadeOnUpdate()->nullOnDelete()->comment("Р’С‹Р±СЂР°РЅРЅС‹Р№ РїРѕР»СЊР·РѕРІР°С‚РµР»РµРј СЃС‡РµС‚ РїРѕ СѓРјРѕР»С‡Р°РЅРёСЋ");
            $table->string('last_name')->comment("Р¤Р°РјРёР»РёСЏ Р°СЂРµРЅРґР°С‚РѕСЂР°");
            $table->string('first_name')->comment("РРјСЏ Р°СЂРµРЅРґР°С‚РѕСЂР°");
            $table->string('middle_name')->comment("РћС‚С‡РµСЃС‚РІРѕ Р°СЂРµРЅРґР°С‚РѕСЂР°");
            $table->string('passport_series')->comment("РЎРµСЂРёСЏ РїР°СЃРїРѕСЂС‚Р°");
            $table->string('passport_number')->unique()->comment("РќРѕРјРµСЂ РїР°СЃРїРѕСЂС‚Р°");
            $table->string('driverlicense_series')->comment("РЎРµСЂРёСЏ РІРѕРґРёС‚РµР»СЊСЃРєРѕРіРѕ СѓРґРѕСЃС‚РѕРІРµСЂРµРЅРёСЏ");
            $table->string('driverlicense_number')->comment("РќРѕРјРµСЂ РІРѕРґРёС‚РµР»СЊСЃРєРѕРіРѕ СѓРґРѕСЃС‚РѕРІРµСЂРµРЅРёСЏ");
            $table->string('driverlicense_date')->comment("Р”Р°С‚Р° РІС‹РґР°С‡Рё СѓРґРѕСЃС‚РѕРІРµСЂРµРЅРёСЏ");
            $table->unsignedBigInteger('phone')->comment("РќРѕРјРµСЂ С‚РµР»РµС„РѕРЅР°")->unique('phone');
            $table->enum('status', ArendatorsStatus::getValues())->default(ArendatorsStatus::Active)->comment("РЎС‚Р°С‚СѓСЃ Р°РєРєР°СѓРЅС‚Р°");
            $table->rememberToken();
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
        Schema::dropIfExists('arendators');
    }
};
