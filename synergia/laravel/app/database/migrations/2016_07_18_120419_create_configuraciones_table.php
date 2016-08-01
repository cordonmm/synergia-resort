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

        /* COLUMNAS:
         *
         * precio           :   float
         * alias            :   string
         * fecha_ini        :   datetime
         * fecha_fin        :   datetime
         * precio_semana    :   float
         * noches_minimas   :   integer
         *
         */

        Schema::create('configuraciones', function($table) {
            //
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->date('fecha_ini')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('alias');
            $table->double('tarifa_minima', 15, 2)->unsigned();
            $table->double('precio_noche_adicional', 15, 2)->unsigned();
            $table->double('precio_semana', 15, 2)->unsigned();
            $table->integer('noches_minimas')->unsigned();
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
