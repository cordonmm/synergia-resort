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


        $ch = curl_init("https://api.airbnb.com/v1/authorize");
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=3092nxybyb0otqw18e8nh5nty&locale=es-ES&currency=EUR&grant_type=password&password=alojamiento16&username=cristina@synergia.es");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($ch);
        curl_close($ch);
        $access = json_decode($response,true);
        if(array_key_exists("access_token",$access)) {
            $url = "https://api.airbnb.com/v2/batch/?client_id=3092nxybyb0otqw18e8nh5nty&locale=es-ES&currency=EUR";
            $data_json = '{"operations":[{"method":"GET","path":"/calendar_days","query":{"start_date":"2016-01-30","listing_id":"12878755","_format":"host_calendar","end_date":"2017-03-30"}},{"method":"GET","path":"/dynamic_pricing_controls/12878755","query":{}}],"_transaction":false}';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Airbnb-OAuth-Token: '.$access["access_token"],'Content-Type: application/json; charset=UTF-8','Content-Length: ' . strlen($data_json)));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);
            $calendar_days = json_decode($response,true)["operations"][0]["response"]["calendar_days"];
            $unavailable = array();
            foreach($calendar_days as $dia){
                if(!$dia["available"]){
                    array_push($unavailable,$dia["date"]);
                }
            }
            //var_dump($unavailable);
            //exit;
        }else{
            //var_dump(json_decode($response,true));
            //exit;
        }

        $reserva_disponible     =   Reserva::validate_dates_reserva(Input::get('fecha_ini'), Input::get('fecha_fin'), $unavailable);

        if($reserva_disponible['success'] == 0){

            Input::flash();
            return Redirect::to('admin/reservas/create')->with('error', 'No puede haber una reserva existente entre el intervalo de las dos fechas seleccionadas.');

        }

        //Almacenar en la BBDD

        if(!Input::has('observaciones')){
            $observaciones = '';
        }
        else{
            $observaciones = Input::get('observaciones');
        }

        $nombre             =   Input::get('nombre');
        $email              =   Input::get('email');
        $telefono           =   Input::get('telefono');
        $dni                =   Input::get('dni');
        $adultos            =   Input::get('adultos');
        $ninos              =   Input::get('ninos');
        $precio             =   Input::get('precio');
        $fecha_ini          =   Input::get('fecha_ini');
        $fecha_fin          =   Input::get('fecha_fin');

        DB::table('reservas')->insert(array(
            array(
                'nombre'            => $nombre,
                'email'             => $email,
                'telefono'          => $telefono,
                'dni'               => $dni,
                'adultos'           => $adultos,
                'ninos'             => $ninos,
                'precio'            => $precio,
                'observaciones'     => $observaciones,
                'fecha_ini'         => $fecha_ini,
                'fecha_fin'         => $fecha_fin
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
        return Redirect::action('AdminReservasController@index');
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


        $ch = curl_init("https://api.airbnb.com/v1/authorize");
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=3092nxybyb0otqw18e8nh5nty&locale=es-ES&currency=EUR&grant_type=password&password=alojamiento16&username=cristina@synergia.es");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($ch);
        curl_close($ch);
        $access = json_decode($response,true);
        if(array_key_exists("access_token",$access)) {
            $url = "https://api.airbnb.com/v2/batch/?client_id=3092nxybyb0otqw18e8nh5nty&locale=es-ES&currency=EUR";
            $data_json = '{"operations":[{"method":"GET","path":"/calendar_days","query":{"start_date":"2016-01-30","listing_id":"12878755","_format":"host_calendar","end_date":"2017-03-30"}},{"method":"GET","path":"/dynamic_pricing_controls/12878755","query":{}}],"_transaction":false}';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Airbnb-OAuth-Token: '.$access["access_token"],'Content-Type: application/json; charset=UTF-8','Content-Length: ' . strlen($data_json)));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = curl_exec($ch);
            curl_close($ch);
            $calendar_days = json_decode($response,true)["operations"][0]["response"]["calendar_days"];
            $unavailable = array();
            foreach($calendar_days as $dia){
                if(!$dia["available"]){
                    array_push($unavailable,$dia["date"]);
                }
            }
            //var_dump($unavailable);
            //exit;
        }else{
            //var_dump(json_decode($response,true));
            //exit;
        }

        $reserva_disponible     =   Reserva::validate_dates_reserva(Input::get('fecha_ini'), Input::get('fecha_fin'), $unavailable);

        $reserva = Reserva::find($id);
        $title = 'Editar Reserva';
        $text_button_submit = 'Actualizar';

        if($reserva_disponible['success'] == 0)
            return Redirect::to('admin/reservas/'.$id.'/edit')->with('error', 'No puede haber una reserva existente entre el intervalo de las dos fechas seleccionadas.');



        //Almacenar en la BBDD

        if(!Input::has('observaciones')){
            $observaciones = '';
        }
        else{
            $observaciones = Input::get('observaciones');
        }

        $nombre             =   Input::get('nombre');
        $email              =   Input::get('email');
        $telefono           =   Input::get('telefono');
        $dni                =   Input::get('dni');
        $adultos            =   Input::get('adultos');
        $ninos              =   Input::get('ninos');
        $precio             =   Input::get('precio');
        $fecha_ini          =   Input::get('fecha_ini');
        $fecha_fin          =   Input::get('fecha_fin');


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
                    'observaciones'     => $observaciones,
                    'fecha_ini'         => $fecha_ini,
                    'fecha_fin'         => $fecha_fin
                )
            );


        return Redirect::to('admin/reservas/'.$id.'/edit')->with('success', 'Reserva actualizada correctamente.');
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
