<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//nombre, apellido, telefono. observaciones, nºadultos, nºniños, dni, fecha llegada, fecha salida, precio, email
        Schema::create('reservas', function($table) {
            //
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->date('fecha_ini');
            $table->date('fecha_fin');
            $table->string('nombre');
            $table->string('email');
            $table->string('apellido');
            $table->string('telefono');
            $table->string('observaciones');
            $table->string('dni');
            $table->integer('adultos');
            $table->integer('ninos');
            $table->float('precio');
            $table->text('observaciones');
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
		//
        Schema::drop('reservas');
	}

}
