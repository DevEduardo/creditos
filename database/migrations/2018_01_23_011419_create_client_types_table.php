<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('slug');
            $table->decimal('credit', 10,2);
            //Interes para el tipo de cliente
            $table->text('interest')->nullable();
            //Interes por dia al vencer las cuaotas
            $table->decimal('daily_interest', 10,2)->default(0.1);
            //sobrecargo
            $table->decimal('surcharge', 10, 2)->default(0);
            $table->integer('max_fees');
            $table->integer('company_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')
              ->references('id')->on('companies')
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
        Schema::dropIfExists('client_types');
    }
}
