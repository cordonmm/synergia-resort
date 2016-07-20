<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//

        /*COLUMNAS:
         *
         * precio:float
         *
        */

        Schema::create('configuraciones', function($table) {
            //
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->float('precio');
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
        Schema::drop('configuraciones');
	}

}
