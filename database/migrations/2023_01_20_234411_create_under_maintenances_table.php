<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnderMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('under_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('admins')->onUpdate('restrict')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->onUpdate('restrict')->onDelete('cascade');
            $table->tinyInteger('type')->default(0)->comment('1->Daily Maintenance,2->Temporary Maintenance,3->Emergency Maintenance');
            $table->date('start_date')->nullable(); 
            $table->date('end_date')->nullable(); 
            $table->string('start_time')->nullable(); 
            $table->string('end_time')->nullable(); 
            $table->string('day')->nullable(); 
            $table->text('content')->nullable();
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
        Schema::dropIfExists('under_maintenances');
    }
}
