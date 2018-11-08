<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('dni')->unique();
            $table->integer('client_type_id')->unsigned();
            $table->integer('profile_id')->unsigned()->nullable();
            $table->string('image_dni')->nullable();
            $table->string('image_service')->nullable();
            $table->string('receipt_payment')->nullable();
            $table->boolean('is_working')->default(false);
            $table->string('profession')->nullable();
            $table->longtext('enterprise')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('profile_id')
              ->references('id')->on('profiles')
              ->onDelete('cascade');

              $table->foreign('client_type_id')
              ->references('id')->on('client_types')
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
        Schema::dropIfExists('clients');
    }
}
