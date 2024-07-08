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
            $table->foreignUuid('default_bill_id')->nullable()->references('id')->on('bills')->nullOnDelete()->comment("Выбранный пользователем счет по умолчанию");
            $table->string('last_name')->comment("Фамилия арендатора");
            $table->string('first_name')->comment("Имя арендатора");
            $table->string('middle_name')->comment("Отчество арендатора");
            $table->string('passport_series')->unique()->comment("Серия паспорта");
            $table->string('passport_number')->comment("Номер паспорта");
            $table->unsignedBigInteger('phone')->comment("Номер телефона");
            $table->enum('status', ArendatorsStatus::getValues())->default(ArendatorsStatus::Active)->comment("Статус аккаунта");
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
