<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->increments('id');
            $table->longtext('add_info');
            $table->integer('sale_id')->unsigned();
            //monto -> Total de la venta
            $table->decimal('amount', 10,2);
            $table->decimal('final_amount', 10,2)->nullable();
            //monto -> Financiado
            //$table->decimal('payment', 10,2);
            //$table->decimal('debit', 10,2);
            //Primer avance en caso de seña o doble avance, credito simple
            $table->decimal('advance_I', 10,2)->nullable();
            $table->date('date_advance_I')->nullable();
            //Segundo avance en caso de seña o doble avance
            $table->decimal('advance_II', 10,2)->nullable();
            $table->date('date_advance_II')->nullable();
            $table->enum('type', ['credit', 'sing', 'two_advance', 'without_advance']);
            $table->integer('fees')->nullable();
            $table->text('interest');
            //Interes a aplicar en cuotas expiradas
            $table->decimal('interest_expired', 10,2)->default(0);
            $table->boolean('is_payed')->default(false);
            $table->boolean('is_expired')->default(false);
            //$table->decimal('interest_to_expire', 10,2)->nullable();
            $table->enum('way_to_pay', ['cash', 'card', 'mixed'])->nullable();
            $table->text('observation')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sale_id')
              ->references('id')->on('sales')
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
        Schema::dropIfExists('credits');
    }
}
