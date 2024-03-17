<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_bonuses', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id')->default(0);
            $table->tinyInteger('type')->default(0);
            $table->integer('level')->default(0);
            $table->decimal('percent',8,4)->default(0);
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
        Schema::dropIfExists('package_bonuses');
    }
}
