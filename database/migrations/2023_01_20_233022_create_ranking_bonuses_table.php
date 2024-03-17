<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRankingBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ranking_bonuses', function (Blueprint $table) {
            $table->id();
            $table->integer('ranking_id')->default(0);
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
        Schema::dropIfExists('ranking_bonuses');
    }
}
