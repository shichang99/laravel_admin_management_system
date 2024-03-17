<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_wallet_id')->constrained('member_wallets')->onUpdate('restrict')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('admins')->onUpdate('restrict')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->onUpdate('restrict')->onDelete('cascade');
            $table->decimal('amount',20,6);
            $table->decimal('opening_balance',20,6);
            $table->decimal('closing_balance',20,6);
            $table->text( 'remark' )->nullable();
            $table->tinyInteger('type');
            $table->tinyInteger('trx_type');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('member_wallet_transactions');
    }
}
