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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('file_no', 200,)->nullable();
            $table->string('share_holder', 200,)->nullable();
            $table->string('surivor_name', 200,)->nullable();
            $table->string('address', 200,)->nullable();
            $table->string('city', 200,)->nullable();
            $table->string('state', 200,)->nullable();
            $table->string('pin', 200,)->nullable();
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
