<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId( 'user_id' )->constrained( 'users' )->onUpdate( 'restrict' )->onDelete( 'cascade' );
            $table->foreignId( 'sponsor_id' )->nullable()->constrained( 'users' )->onUpdate( 'restrict' )->onDelete( 'cascade' );
            $table->integer( 'level' );
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
        Schema::dropIfExists('member_structures');
    }
}
