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
        Schema::create('system_error_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('namespace', ['Backend'])->default('Backend');;
            $table->string('controller')->nullable();
            $table->string('function')->nullable();
            $table->string('log',2000)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_error_logs');
    }
};
