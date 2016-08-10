<?php



class UbicacionTableSeeder extends Seeder {



    public function run()

    {

        DB::table('ubicacion')->truncate();



        DB::table('ubicacion')->insert(array(
            array(
                'id'            => 1,
                'titulo'        => NULL,
                'descripcion'   => NULL,
                'iframe'        => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d50729.739919354535!2d-5.990077680453935!3d37.37543369580759!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd126c1114be6291%3A0x34f018621cfe5648!2sSevilla!5e0!3m2!1ses!2ses!4v1470723931244" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>'
            )
        ));

    }



}

