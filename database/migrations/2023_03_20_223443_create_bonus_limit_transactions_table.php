<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusLimitTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_limit_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bonus_limit_id')->constrained('bonus_limits')->onUpdate('restrict')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onUpdate('restrict')->onDelete('cascade');
            $table->decimal('amount',20,6);
            $table->decimal('opening_balance',20,6);
            $table->decimal('closing_balance',20,6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bonus_limit_transactions');
    }
}
