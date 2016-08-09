<?php

class AdminUbicacionController extends \BaseController {


	public function index()
	{
        return View::make('admin.ubicacion.index');
	}

	public function store()
	{
        //validaciones

        $validator = Ubicacion::validate(Input::all());

        if($validator->fails())
            return Redirect::to('admin/ubicacion')->withErrors($validator);


        DB::table('ubicacion')->truncate();

        $ubicacion                  =   new Ubicacion;

        $ubicacion->id              =   1;
        $ubicacion->titulo          =   (!Input::has('titulo')       || Input::get('titulo') == '')          ? NULL  : Input::get('titulo');
        $ubicacion->descripcion     =   (!Input::has('descripcion')  || Input::get('descripcion') == '')     ? NULL  : Input::get('descripcion');
        $ubicacion->iframe          =   Input::get('iframe');

        $ubicacion->save();

        return Redirect::to('admin/anfitrion')->with('success', 'La <b>Ubicación</b> ha sido creada con éxito.');
	}

    public function __call($method, $parameters){
        App::abort(404);
    }

}
