<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutoria extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        Schema::create('tutorias', function($table) {
            //
            $table->engine = 'InnoDB';


            $table->increments('id')->unsigned();


            $table->integer('user_id')->unsigned()->index();


            $table->string('clase');


            $table->string('email');


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('tutorias');
	}

}
