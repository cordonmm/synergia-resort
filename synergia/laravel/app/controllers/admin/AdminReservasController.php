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
        $unavailable = $this->unavailable();
        $unavailable_on = '';

        JavaScript::put([
            'unavailable' => $unavailable,
        ]);

        if($unavailable == null){
            return Redirect::to('admin/reservas');
        }

        $title = 'Crear Reserva';
        $text_button_submit = 'Crear';

        $horas = array();

        for($i=8; $i<=20; $i++){
            $horas[$i.':00'] = $i.':00';
            $horas[$i.':30'] = $i.':30';
        }

        array_pop($horas);

        return View::make('admin/reservas/create_edit', compact('title', 'text_button_submit', 'horas', 'unavailable_on'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Cambiar fechas de formato

        Input::merge(array('fecha_ini' => date('Y-m-d', strtotime(Input::get('fecha_ini')))));
        Input::merge(array('fecha_fin' => date('Y-m-d', strtotime(Input::get('fecha_fin')))));

        $validator = Reserva::validate(Input::except('_token'));

        if($validator->fails()){

            Input::merge(array('fecha_ini' => date('d-m-Y', strtotime(Input::get('fecha_ini')))));
            Input::merge(array('fecha_fin' => date('d-m-Y', strtotime(Input::get('fecha_fin')))));

            return Redirect::action('AdminReservasController@create')->withInput()->withErrors($validator);
        }


        $reserva_disponible     =   Reserva::validate_dates_reserva(Input::get('fecha_ini'), Input::get('fecha_fin'));

        if($reserva_disponible['success'] == 0){

            Input::merge(array('fecha_ini' => date('d-m-Y', strtotime(Input::get('fecha_ini')))));
            Input::merge(array('fecha_fin' => date('d-m-Y', strtotime(Input::get('fecha_fin')))));

            Input::flash();
            return Redirect::to('admin/reservas/create')->with('error', 'No puede haber una reserva existente entre el intervalo de las dos fechas seleccionadas.');

        }

        //Almacenar en la BBDD

        $nombre             =   Input::get('nombre');
        $email              =   Input::get('email');
        $dni                =   Input::get('dni');
        $adultos            =   Input::get('adultos');
        $ninos              =   Input::get('ninos');
        $precio             =   Input::get('precio');
        $fecha_ini          =   Input::get('fecha_ini');
        $fecha_fin          =   Input::get('fecha_fin');
        $pais               =   Input::get('pais_nacionalidad');
        $fecha_nacimiento   =   Input::get('fecha_nacimiento');
        $fecha_expedicion   =   Input::get('fecha_expedicion');
        $hora_llegada       =   Input::get('hora_llegada');

        DB::table('reservas')->insert(array(
            array(
                'nombre'            => $nombre,
                'email'             => $email,
                'telefono'          => Input::get('telefono'),
                'dni'               => $dni,
                'adultos'           => $adultos,
                'ninos'             => $ninos,
                'precio'            => $precio,
                'observaciones'     => Input::get('observaciones'),
                'fecha_ini'         => $fecha_ini,
                'fecha_fin'         => $fecha_fin,
                'fecha_nacimiento'  => $fecha_nacimiento,
                'fecha_expedicion'  => $fecha_expedicion,
                'pais_nacionalidad' => $pais,
                'hora_llegada'      => $hora_llegada
            )
        ));

        Input::merge(array('fecha_ini' => date('d-m-Y', strtotime(Input::get('fecha_ini')))));
        Input::merge(array('fecha_fin' => date('d-m-Y', strtotime(Input::get('fecha_fin')))));

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
        /*$unavailable = $this->unavailable();

        JavaScript::put([
            'unavailable' => $unavailable,
        ]);

        if($unavailable == null){
            return Redirect::to('admin/reservas');
        }*/

        $reserva = Reserva::find($id);
        $title = 'Editar Reserva';
        $text_button_submit = 'Actualizar';

        $horas = array();

        for($i=8; $i<=20; $i++){
            $horas[$i.':00'] = $i.':00';
            $horas[$i.':30'] = $i.':30';
        }

        array_pop($horas);

        return View::make('admin/reservas/create_edit', compact('reserva', 'title', 'text_button_submit', 'horas'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $validator = Reserva::validate(Input::except('_token', 'fecha_ini', 'fecha_fin'));

        if($validator->fails())
            return Redirect::action('AdminReservasController@edit', array($id))->withErrors($validator);

        //$reserva_disponible     =   Reserva::validate_dates_reserva(Input::get('fecha_ini'), Input::get('fecha_fin'));

        //if($reserva_disponible['success'] == 0)
        //    return Redirect::to('admin/reservas/'.$id.'/edit')->with('error', 'No puede haber una reserva existente entre el intervalo de las dos fechas seleccionadas.');



        //Almacenar en la BBDD

        $nombre             =   Input::get('nombre');
        $email              =   Input::get('email');
        $dni                =   Input::get('dni');
        $adultos            =   Input::get('adultos');
        $ninos              =   Input::get('ninos');
        $precio             =   Input::get('precio');
        $pais               =   Input::get('pais_nacionalidad');
        $fecha_nacimiento   =   Input::get('fecha_nacimiento');
        $fecha_expedicion   =   Input::get('fecha_expedicion');
        $hora_llegada       =   Input::get('hora_llegada');


        DB::table('reservas')
            ->where('id', $id)
            ->update(array(
                    'nombre'            => $nombre,
                    'email'             => $email,
                    'telefono'          => Input::get('telefono'),
                    'dni'               => $dni,
                    'adultos'           => $adultos,
                    'ninos'             => $ninos,
                    'precio'            => $precio,
                    'observaciones'     => Input::get('observaciones'),
                    'fecha_nacimiento'  => $fecha_nacimiento,
                    'fecha_expedicion'  => $fecha_expedicion,
                    'pais_nacionalidad' => $pais,
                    'hora_llegada'      => $hora_llegada
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
        $reservas = Reserva::select(array('reservas.id', 'reservas.fecha_ini', 'reservas.fecha_fin', 'reservas.telefono', 'reservas.email', 'reservas.nombre','reservas.pagado','reservas.pendiente'))->orderBy('created_at', 'ASC');

        return Datatables::of($reservas)

            ->add_column('actions',
                '@if($pendiente)<a href="{{{ URL::to(\'admin/reservas/\' . $id . \'/pago\' ) }}}" class="btn btn-xs btn-success iframe"><span title="Solicitar pago" class="glyphicon glyphicon-credit-card"></a>@endif
                <a href="{{{ URL::to(\'admin/reservas/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" ><span title="Editar reserva" class="glyphicon glyphicon-edit"></a>
            	@if($pendiente)<a href="{{{ URL::to(\'admin/reservas/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe"><span title="Eliminar reserva" class="glyphicon glyphicon-trash"></span></a>@endif'

            )
            ->edit_column('pagado', '{{ $pagado ? "Pagado" : "Pendiente" }}')
            ->remove_column('pendiente')
            ->remove_column('id')

            ->make();
    }

    public function getDelete($reserva){
        // titulo

        $title = 'Borrar una reserva';

        // Show the page

        return View::make('admin/reservas/delete', compact('reserva', 'title'));
    }

    public function getPago($id)
    {
        $reserva = Reserva::find($id);
        $title = 'Solicitar pago reserva';
        $text_button_submit = 'Solicitar';

        return View::make('admin/reservas/solicitar_pago', compact('reserva', 'title', 'text_button_submit'));
    }

    public function postPago($reserva){


        Mail::send('emails.solicitud_pago', array('data' => $reserva), function ($message) use($reserva) {
            //$message->to('cristina@synergia.es')->subject('Synergia-resort. Nuevo Comentario.');
            $message->to( $reserva->email)->subject('Synergia-resort. Reserva confirmada.');
        });

        $reserva->pendiente = false;
        $reserva->save();

        return Redirect::to('admin/reservas/'.$reserva->id.'/edit')->with('success', 'Ha solicitado el pago correctamente.');
    }

    private function unavailable(){
        $hoy = date('y-m-d');
        $fechafin = strtotime ( '+2 year' , strtotime ( $hoy ) ) ;
        $fechafin = date ( 'y-m-d' , $fechafin );
        $ch = curl_init("https://api.airbnb.com/v1/authorize");
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=3092nxybyb0otqw18e8nh5nty&locale=es-ES&currency=EUR&grant_type=password&password=alojamiento16&username=cristina@synergia.es");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($ch);
        curl_close($ch);
        $access = json_decode($response,true);
        $unavailable = null;
        if($access != null and array_key_exists("access_token",$access)) {
            $url = "https://api.airbnb.com/v2/batch/?client_id=3092nxybyb0otqw18e8nh5nty&locale=es-ES&currency=EUR";
            $data_json = '{"operations":[{"method":"GET","path":"/calendar_days","query":{"start_date":"'.$hoy.'","listing_id":"12878755","_format":"host_calendar","end_date":"'.$fechafin.'"}},{"method":"GET","path":"/dynamic_pricing_controls/12878755","query":{}}],"_transaction":false}';
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

        }
        return $unavailable;
    }

}
