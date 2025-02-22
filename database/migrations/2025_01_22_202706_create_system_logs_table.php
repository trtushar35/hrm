<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_id')->nullable()->comment('no of id of table');
            $table->unsignedBigInteger('admin_id')->nullable()->comment('done by who');
            $table->enum('user_type',['admin'])->default('admin');
            $table->string('reference_table')->nullable()->comment('data table name');
            $table->string('note',1000)->nullable()->comment('data transaction details'); 
            $table->timestamps();
            $table->softDeletes(); 
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_logs');
    }
};
