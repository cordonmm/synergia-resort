<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnfitrionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('anfitrion', function($table) {
            //
            $table->engine = 'InnoDB';
            $table->integer('id')->unsigned();
            $table->primary('id');
            $table->string('nombre');
            $table->string('apellidos')->nullable();
            $table->string('email')->nullable();
            $table->integer('telefono')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('anfitrion');
	}

}
