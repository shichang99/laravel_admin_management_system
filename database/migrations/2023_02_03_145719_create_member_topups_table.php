<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberTopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_topups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->onUpdate('restrict')->onDelete('cascade');
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('wallet_type')->default(1);
            $table->tinyInteger('payment_method')->default(1);
            $table->decimal('amount',20,4)->default(0);
            $table->decimal('currency_rate',20,4)->default(0);
            $table->decimal('convert_amount',20,4)->default(0);
            $table->text('attachment')->nullable();
            $table->text('remark')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('member_topups');
    }
}
