<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->nullable();  
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('location')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('webpage')->nullable();
            $table->longtext('add_info')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('profiles');
    }
}
