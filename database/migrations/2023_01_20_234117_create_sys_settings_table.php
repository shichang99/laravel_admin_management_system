<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('admins')->onUpdate('restrict')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->onUpdate('restrict')->onDelete('cascade');
            $table->string('name');
            $table->string('key')->nullable();
            $table->string('value')->nullable();
            $table->tinyInteger('type')->nullable(0);
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
        Schema::dropIfExists('sys_settings');
    }
}
