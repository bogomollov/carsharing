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
            $table->foreignUuid('arendator_id')->nullable()->constrained('arendators')->cascadeOnUpdate()->nullOnDelete()->comment("Идентификатор арендатора");
            $table->foreignUuid('bill_id')->nullable()->constrained('bills')->cascadeOnUpdate()->nullOnDelete()->comment("Идентификатор счёта");
            $table->decimal('modification',100,2)->comment("Изменение баланса");
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
