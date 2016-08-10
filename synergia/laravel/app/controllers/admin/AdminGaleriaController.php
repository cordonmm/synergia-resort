<?php

class AdminGaleriaController extends \BaseController {


	public function index()
	{

        $files = array();

        foreach (Galeria::all() as $item){

                $array = array(

                    "name" => $item->nombre_asignado ,

                    "size" => filesize(public_path().'/'.$item->ruta),

                    "url"  => asset($item->ruta),

                );

                array_push($files, $array);
        }

        JavaScript::put([

            'files' => $files

        ]);

        return View::make('admin.galeria.index');
	}

    public function delete_image(){
        if(Request::ajax()){

            $files = array(public_path().'/galeria/'.Input::get('file'), public_path().'/galeria/thumbnails/150x150_'.Input::get('file'));

            // Borrar imagen de galeria
            // Borrar imagen de galeria/thumbnails

            File::delete($files);

            // Borrar imagen de BBDD

            DB::table('galeria')->where('nombre_asignado', Input::get('file'))->delete();

            return 'good';

        }
        else{
            return Redirect::to('admin/galeria');
        }
    }

	public function upload(){
        if(Request::ajax()){

            if(Input::hasFile('file') && Input::file('file')->isValid()){

                // Subir una imagen

                $patron     =   Input::has('patron') ? Input::get('patron') : null;
                $imagen     =   Input::file('file');

                $nombre_original    =   $imagen->getClientOriginalName();
                $extension          =   strtolower($imagen->getClientOriginalExtension());

                if(!in_array($extension, array('jpg', 'jpeg', 'png')))
                    return 'error';

                $tamanyo            =   $imagen->getSize()/1024/1024;
                $tamanyo            =   $tamanyo.' MB';

                if($patron != null){
                    $nuevoID = Galeria::all()->last() ? intval(Galeria::all()->last()->id) + 1 : 1;
                    $nombre_asignado = $patron.$nuevoID.'.'.$extension;
                }
                else{
                    $nombre_asignado = md5(date_format(date_create(), 'U = Y-m-d H:i:s')).'.'.$extension;
                }

                $ruta = 'galeria/'.$nombre_asignado;

                if($imagen->move(public_path().'/galeria', $nombre_asignado)){
                    $item = new Galeria;

                    $item->ruta                 =   $ruta;
                    $item->nombre_original      =   $nombre_original;
                    $item->nombre_asignado      =   $nombre_asignado;
                    $item->extension            =   $extension;
                    $item->tamanyo              =   $tamanyo;

                    $item->save();

                    Image::make(public_path().'/galeria/'.$nombre_asignado)->fit(150, 150)->save(public_path().'/galeria/thumbnails/150x150_'.$nombre_asignado)->destroy();

                    return 'good';
                }
                else{
                    return 'error';
                }
            }
            else{
                return 'error';
            }

        }
        else{
            return Redirect::to('admin/galeria');
        }
    }

    public function __call($method, $parameters){
        App::abort(404);
    }


}
