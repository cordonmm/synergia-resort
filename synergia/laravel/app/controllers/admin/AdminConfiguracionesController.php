<?php

class AdminConfiguracionesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.configuraciones.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $text_button_submit =   'Crear';
        $title              =   'Crear Nueva Tarifa';
        return View::make('admin.configuraciones.create_edit', compact('text_button_submit', 'title'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
        $validator  =   Configuracion::validate(Input::all());

        if($validator->fails())
            return Redirect::to('admin/configuraciones/create')->withInput()->withErrors($validator);

        //Comprobar que el intervalo dado no pisa uno existente.

          $intervalos_pisados   = DB::table('configuraciones')
                                ->select('alias', 'fecha_ini', 'fecha_fin')
                                ->whereNotNull('fecha_ini')->whereNotNull('fecha_fin')
                                ->where(function($query){
                                    $query  ->where('fecha_ini', '<=', Input::get('fecha_ini'))
                                            ->where('fecha_fin', '>=', Input::get('fecha_ini'))

                                            ->orWhere(function($query){
                                                $query  ->where('fecha_ini', '<=', Input::get('fecha_fin'))
                                                        ->where('fecha_fin', '>=', Input::get('fecha_fin'));
                                            })
                                            ->orWhere(function($query){
                                                $query  ->where('fecha_ini', '>=', Input::get('fecha_ini'))
                                                        ->where('fecha_fin', '<=', Input::get('fecha_fin'));
                                            });
                                })
                                ->orderBy('fecha_ini', 'DESC')
                                ->get();

        if(count($intervalos_pisados) > 0)
            return Redirect::to('admin/configuraciones/create')->withInput()->with('intervalos_pisados', $intervalos_pisados);

        $configuracion  =   new Configuracion;

        $configuracion->fecha_ini                   =   Input::get('fecha_ini');
        $configuracion->fecha_fin                   =   Input::get('fecha_fin');
        $configuracion->alias                       =   Input::get('alias');
        $configuracion->tarifa_minima               =   Input::get('tarifa_minima');
        $configuracion->precio_noche_adicional      =   Input::get('precio_noche_adicional');
        $configuracion->precio_semana               =   Input::get('precio_semana');
        $configuracion->noches_minimas              =   Input::get('noches_minimas');

        $configuracion->save();

        return Redirect::to('admin/configuraciones/create')->with('success', 'La configuración fue creada con éxito');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Configuracion $configuracion)
	{
        $text_button_submit =   'Actualizar';
        $title              =   'Actualizar una Tarifa';
        return View::make('admin.configuraciones.create_edit', compact('configuracion', 'text_button_submit', 'title'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Configuracion $configuracion)
	{
        $validator  =   Configuracion::validate(Input::all());

        if($validator->fails())
            return Redirect::to('admin/configuraciones/'.$configuracion->id.'/edit')->withErrors($validator);

        //Comprobar que el intervalo dado no pisa uno existente.

        if($configuracion->id != 1){
            $intervalos_pisados   = DB::table('configuraciones')
                ->select('alias', 'fecha_ini', 'fecha_fin')
                ->whereNotNull('fecha_ini')->whereNotNull('fecha_fin')
                ->where(function($query){
                    $query  ->where('fecha_ini', '<=', Input::get('fecha_ini'))
                        ->where('fecha_fin', '>=', Input::get('fecha_ini'))

                        ->orWhere(function($query){
                            $query  ->where('fecha_ini', '<=', Input::get('fecha_fin'))
                                ->where('fecha_fin', '>=', Input::get('fecha_fin'));
                        })
                        ->orWhere(function($query){
                            $query  ->where('fecha_ini', '>=', Input::get('fecha_ini'))
                                ->where('fecha_fin', '<=', Input::get('fecha_fin'));
                        });
                })
                ->where('id', '<>', $configuracion->id)
                ->orderBy('fecha_ini', 'DESC')
                ->get();

            if(count($intervalos_pisados) > 0)
                return Redirect::to('admin/configuraciones/'.$configuracion->id.'/edit')->with('intervalos_pisados', $intervalos_pisados);
        }

        $configuracion->fecha_ini                   =   Input::get('fecha_ini');
        $configuracion->fecha_fin                   =   Input::get('fecha_fin');
        $configuracion->alias                       =   Input::has('alias') ? Input::get('alias') : 'Estándar';
        $configuracion->tarifa_minima               =   Input::get('tarifa_minima');
        $configuracion->precio_noche_adicional      =   Input::get('precio_noche_adicional');
        $configuracion->precio_semana               =   Input::get('precio_semana');
        $configuracion->noches_minimas              =   Input::get('noches_minimas');

        $configuracion->save();

        return Redirect::to('admin/configuraciones/'.$configuracion->id.'/edit')->with('success', 'La configuración fue actualizada con éxito');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Configuracion $configuracion)
	{
		//
        if($configuracion->id != 1)
            $configuracion->delete();

        return Redirect::to('admin/configuraciones');
	}

    public function getData(){

        $configuraciones = Configuracion::select(array('configuraciones.id', 'configuraciones.alias', 'configuraciones.fecha_ini', 'configuraciones.fecha_fin', 'configuraciones.tarifa_minima', 'configuraciones.precio_noche_adicional', 'configuraciones.precio_semana', 'configuraciones.noches_minimas'))
            ->orderBy('id')
            ->orderBy('fecha_fin', 'DESC');

        return Datatables::of($configuraciones)

            ->edit_column('fecha_ini',
                '@if($fecha_ini === NULL)
                    -
                @else
                    {{ date_format(new DateTime($fecha_ini), "d/m/Y") }}
                @endif')

            ->edit_column('fecha_fin',
                '@if($fecha_fin === NULL)
                    -
                @else
                    {{ date_format(new DateTime($fecha_fin), "d/m/Y") }}
                @endif')

            ->edit_column('tarifa_minima',
                '{{ number_format($tarifa_minima, 2) }}&euro;')

            ->edit_column('precio_noche_adicional',
                '{{ number_format($precio_noche_adicional, 2) }}&euro;')

            ->edit_column('precio_semana',
                '{{ number_format($precio_semana, 2) }}&euro;')

            ->add_column('actions',

                '@if($fecha_fin == NULL || $fecha_ini == NULL)
                       <a style="width: 100%;" href="{{{ URL::to(\'admin/configuraciones/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                @else
                    @if(new DateTime($fecha_fin) < new DateTime)
                        <span class="out-of-date"><strong>CADUCADO</strong></span>
                    @else
                        <a href="{{{ URL::to(\'admin/configuraciones/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                        <a href="{{{ URL::to(\'admin/configuraciones/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
                    @endif
                @endif
            	')

            ->remove_column('id')

            ->make();
    }

    public function getDelete($configuracion){
        // titulo

        $title = 'Borrar una tarifa';

        // Show the page

        return View::make('admin/configuraciones/delete', compact('configuracion', 'title'));
    }

    public function __call($method, $parameters){
        App::abort(404);
    }


}
