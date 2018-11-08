<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('type'); //pay simple, sing or fee
            $table->text('info'); //Aqui se guarda un json con la estructura [id: , model:]
            $table->unsignedInteger('payment_id')->nullable();
            $table->unsignedInteger('credit_detail_id')->nullable();
            $table->unsignedInteger('sale_id')->nullable();
            $table->timestamps();

            $table->foreign('payment_id')
                ->references('id')->on('payments')
                ->onDelete('cascade');

            $table->foreign('credit_detail_id')
                ->references('id')->on('credit_details')
                ->onDelete('cascade');

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
        Schema::dropIfExists('coupons');
    }
}
