<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('admins')->onUpdate('restrict')->onDelete('cascade');
            $table->foreignId('rejected_by')->nullable()->constrained('admins')->onUpdate('restrict')->onDelete('cascade');
            $table->string('reference')->nullable();
            $table->string('txid')->nullable();
            $table->tinyInteger('wallet_type')->default(1);
            $table->tinyInteger('withdraw_method')->default(1);
            $table->text('member_bank_detail')->nullable();
            $table->decimal('original_amount',20,4)->default(0);
            $table->decimal('original_process_fee',20,4)->default(0);
            $table->decimal('currency_rate',20,4)->default(0);
            $table->decimal('convert_amount',20,4)->default(0);
            $table->decimal('convert_process_fee',20,4)->default(0);
            $table->text('remark')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_requests');
    }
}
