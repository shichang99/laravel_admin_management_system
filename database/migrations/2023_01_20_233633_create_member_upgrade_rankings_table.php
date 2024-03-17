<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberUpgradeRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_upgrade_rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('admins')->onUpdate('restrict')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('restrict')->onDelete('cascade');
            $table->integer('old_ranking')->default(0);
            $table->integer('new_ranking')->default(0);
            $table->tinyInteger('is_auto')->default(0)->comments('0->Admin Manual Up,1->System Auto Up');
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
        Schema::dropIfExists('member_upgrade_rankings');
    }
}
