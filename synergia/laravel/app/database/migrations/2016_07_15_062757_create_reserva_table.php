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
            $table->string('hora_llegada');
            $table->date('fecha_fin');
            $table->date('fecha_nacimiento');
            $table->date('fecha_expedicion');
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->string('dni');
            $table->string('pais_nacionalidad');
            $table->integer('adultos');
            $table->integer('ninos');
            $table->float('precio');
            $table->boolean('pagado')->default(false);
            $table->boolean('pendiente')->default(true);
            $table->string('clave_pago');
            $table->text('observaciones')->nullable();
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
