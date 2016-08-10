<?php



class AnfitrionTableSeeder extends Seeder {



    public function run()

    {

        DB::table('anfitrion')->truncate();



        DB::table('anfitrion')->insert(array(
            array(
                'id'            => 1,
                'nombre'        => 'anfitrion_name',
                'apellidos'     => 'anfitrion_surname',
                'email'        => 'anfitrion_email',
                'telefono'      =>  112345678
            )
        ));

    }



}

