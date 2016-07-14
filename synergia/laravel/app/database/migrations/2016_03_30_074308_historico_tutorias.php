<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HistoricoTutorias extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historico_tutorias', function($table) {
			//
			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->date('fecha_solicitud');
			$table->string('nombre');
			$table->string('telefono');
			$table->string('email_emisor');
			$table->string('email_receptor');
			$table->string('clase');
			$table->text('mensaje');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('historico_tutorias');
	}

}
