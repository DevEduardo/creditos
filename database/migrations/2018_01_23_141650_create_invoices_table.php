<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('code');
            $table->integer('company_id')->unsigned();
            $table->integer('provider_id')->unsigned();
            $table->integer('user_id')->unsigned();
            
            $table->decimal('total', 8,2)->nullable();
            $table->text('observations')->nullable();

            $table->boolean('finished')->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')
              ->references('id')->on('companies')
              ->onDelete('cascade');

            $table->foreign('provider_id')
              ->references('id')->on('providers')
              ->onDelete('cascade');

              $table->foreign('user_id')
              ->references('id')->on('users')
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
        Schema::dropIfExists('invoices');
    }
}
