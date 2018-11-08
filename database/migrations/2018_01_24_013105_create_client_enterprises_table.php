<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientEnterprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_enterprises', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('enterprise_id')->unsigned();
            $table->timestamps();

            $table->foreign('client_id')
              ->references('id')->on('clients')
              ->onDelete('cascade');

            $table->foreign('enterprise_id')
              ->references('id')->on('enterprises')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_enterprises');
    }
}
