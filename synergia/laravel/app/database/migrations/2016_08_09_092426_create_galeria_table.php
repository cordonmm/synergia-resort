<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGaleriaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('galeria', function($table) {
            //
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('ruta');
            $table->string('nombre_original');
            $table->string('nombre_asignado');
            $table->string('extension');
            $table->string('tamanyo');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('galeria');
	}

}
