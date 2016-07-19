<?php

class AdminReservasController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        return View::make('admin/reservas/index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
        $title = 'Crear Reserva';
        $text_button_submit = 'Crear';

        return View::make('admin/reservas/create_edit', compact('title', 'text_button_submit'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
        $validator = Reserva::validate(Input::except('_token'));

        if($validator->fails())
            return Redirect::action('AdminReservasController@create')->withInput()->withErrors($validator);

        //Almacenar en la BBDD

        if(!Input::has('observaciones')){
            $observaciones = '';
        }
        else{
            $observaciones = e(Input::get('observaciones'));
        }

        $nombre             =   e(Input::get('nombre'));
        $email              =   e(Input::get('email'));
        $telefono           =   e(Input::get('telefono'));
        $dni                =   e(Input::get('dni'));
        $adultos            =   e(Input::get('adultos'));
        $ninos              =   e(Input::get('ninos'));
        $precio             =   e(Input::get('precio'));

        DB::table('reservas')->insert(array(
            array(
                'nombre'            => $nombre,
                'email'             => $email,
                'telefono'          => $telefono,
                'dni'               => $dni,
                'adultos'           => $adultos,
                'ninos'             => $ninos,
                'precio'            => $precio,
                'observaciones'     => $observaciones
            )
        ));

        return Redirect::action('AdminReservasController@create')->with('success', 'Reserva dada de alta correctamente.');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
        $reserva = Reserva::find($id);
        $title = 'Editar Reserva';
        $text_button_submit = 'Actualizar';

        return View::make('admin/reservas/create_edit', compact('reserva', 'title', 'text_button_submit'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
        $validator = Reserva::validate(Input::except('_token'));

        if($validator->fails())
            return Redirect::action('AdminReservasController@edit', array($id))->withErrors($validator);

        //Almacenar en la BBDD

        if(!Input::has('observaciones')){
            $observaciones = '';
        }
        else{
            $observaciones = e(Input::get('observaciones'));
        }

        $nombre             =   e(Input::get('nombre'));
        $email              =   e(Input::get('email'));
        $telefono           =   e(Input::get('telefono'));
        $dni                =   e(Input::get('dni'));
        $adultos            =   e(Input::get('adultos'));
        $ninos              =   e(Input::get('ninos'));
        $precio             =   e(Input::get('precio'));

        DB::table('reservas')
            ->where('id', $id)
            ->update(array(
                    'nombre'            => $nombre,
                    'email'             => $email,
                    'telefono'          => $telefono,
                    'dni'               => $dni,
                    'adultos'           => $adultos,
                    'ninos'             => $ninos,
                    'precio'            => $precio,
                    'observaciones'     => $observaciones
                )
            );

        return Redirect::action('AdminReservasController@edit', array($id))->with('success', 'Reserva actualizada correctamente.');

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
        DB::table('reservas')
            ->where('id', $id)
            ->delete();

        return Redirect::action('AdminReservasController@index');
	}

    public function getData(){
        $reservas = Reserva::select(array('reservas.id', 'reservas.fecha_ini', 'reservas.fecha_fin', 'reservas.telefono', 'reservas.email', 'reservas.nombre'));

        return Datatables::of($reservas)

            ->add_column('actions',
                '<a href="{{{ URL::to(\'admin/reservas/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
            	<a href="{{{ URL::to(\'admin/reservas/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>'
            )

            ->remove_column('id')

            ->make();
    }

    public function getDelete($reserva){
        // titulo

        $title = 'Borrar una reserva';

        // Show the page

        return View::make('admin/reservas/delete', compact('reserva', 'title'));
    }


}
