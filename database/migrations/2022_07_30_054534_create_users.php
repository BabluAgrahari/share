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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 200,)->nullable();
            $table->string('lastname', 200)->nullable();
            $table->string('father_name', 200)->nullable();
            $table->string('add', 200)->nullable();
            $table->string('mobile', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('password', 200)->nullable();
            $table->text('image')->nullable();
           
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
};
