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
        Schema::create('contact_person', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200,)->nullable();
            $table->string('email', 200,)->nullable();
            $table->string('mobile', 200,)->nullable();
            $table->integer('status', 1,)->default(0);
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
        Schema::dropIfExists('clients');
    }
};
