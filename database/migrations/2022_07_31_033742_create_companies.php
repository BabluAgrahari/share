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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 200,)->nullable();
            $table->string('phone', 200,)->nullable();
            $table->string('email', 200,)->nullable();
            $table->string('address', 200,)->nullable();
            $table->string('city', 200,)->nullable();
            $table->string('state', 250,)->nullable();
            $table->string('pin', 200,)->nullable();
            $table->string('contact_person', 200,)->nullable();
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
        Schema::dropIfExists('companies');
    }
};
