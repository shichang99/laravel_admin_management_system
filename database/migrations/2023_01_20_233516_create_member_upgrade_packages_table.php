<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberUpgradePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_upgrade_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('admins')->onUpdate('restrict')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onUpdate('restrict')->onDelete('cascade');
            $table->integer('old_package')->default(0);
            $table->integer('new_package')->default(0);
            $table->decimal('amount',20,2)->default(0);
            $table->tinyInteger('is_auto')->default(0)->comment('0->Admin Manual Up,1->System Auto Up');
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
        Schema::dropIfExists('member_upgrade_packages');
    }
}
