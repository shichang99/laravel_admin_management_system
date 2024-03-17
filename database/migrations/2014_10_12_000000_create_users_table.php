<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId( 'country_id' )->nullable();
            $table->foreignId( 'ranking_id' )->nullable();
            $table->foreignId( 'package_id' )->nullable();
            $table->foreignId( 'sponsor_id' )->nullable();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('security_pin');
            $table->string('invitation_code',10);
            $table->text('sponsor_structure');
            $table->decimal('capital',20,4)->default(0);
            $table->tinyInteger('is_free_acc')->default(0)->comment('0->No,1->Yes');
            $table->rememberToken();
            $table->tinyInteger('status');
            $table->foreignId('created_by')->default(0);
            $table->foreignId('updated_by')->default(0);
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
        Schema::dropIfExists('users');
    }
}
