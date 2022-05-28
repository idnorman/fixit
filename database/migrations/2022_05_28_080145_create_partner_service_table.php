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
        Schema::create('partner_service', function (Blueprint $table) {
            $table->id();
            $table->string('price');
            $table->bigInteger('partner_id')->unsigned();
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->bigInteger('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');
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
        Schema::dropIfExists('partner_service');
    }
};
