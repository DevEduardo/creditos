<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_interests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('credit_detail_id')->unsigned();
            $table->integer('number_days');
            $table->decimal('interest_to_pay_base', 10,2);
            $table->decimal('interest_to_pay', 10,2);
            $table->decimal('base_interest', 10,2);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('credit_detail_id')
              ->references('id')->on('credit_details')
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
        Schema::dropIfExists('credit_interests');
    }
}
