<?php
class CarpetasTableSeeder extends Seeder {
	public function run() {
		DB::table ( 'carpetas' )->delete ();
		
		$carpetas = array (
				array ( // 1
						'nombre'=> 'Default',
				)
				
		)
		;
		
		DB::table ( 'carpetas' )->insert ( $carpetas );
		
	}
}
