<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('credit_id')->unsigned();
            $table->integer('fee_number');
            $table->decimal('base_amount', 10,2);
            $table->decimal('fee_amount', 10,2);
            //Monto pagado
            $table->decimal('payment', 10,2)->nullable();
            //fecha cuando se paga la cuota
            $table->date('fee_date')->nullable();
            //Fecha de expiracion de cuota
            $table->date('fee_date_expired');
            $table->integer('days_expired')->default('0');
            //$table->boolean('is_per_pay');
            $table->boolean('is_payed')->default(false);
            $table->boolean('is_expired')->default(false);
            //Suma de intereses diarios
            $table->decimal('interest_to_expire', 10,2)->nullable();
            //Json con datos que vayan saliendo
            $table->text('info')->nullable();
            
            $table->timestamps();

            $table->foreign('credit_id')
              ->references('id')->on('credits')
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
        Schema::dropIfExists('credit_details');
    }
}
