<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\BillsStatus;
use App\Enums\BillsType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger("arendators_count")->default(1)->comment("РљРѕР»РёС‡РµСЃС‚РІРѕ РїРѕР»СЊР·РѕРІР°С‚РµР»РµР№ СЃРІСЏР·Р°РЅРЅС‹С… СЃРѕ СЃС‡С‘С‚РѕРј");
            $table->decimal('balance', 10,2)->comment("Р‘Р°Р»Р°РЅСЃ СЃС‡С‘С‚Р°");
            $table->string("type")->comment("РўРёРї СЃС‡С‘С‚Р°");
            $table->string('status')->comment("РЎС‚Р°С‚СѓСЃ СЃС‡С‘С‚Р°");
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
        Schema::dropIfExists('bills');
    }
};
