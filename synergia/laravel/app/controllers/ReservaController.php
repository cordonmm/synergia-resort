<?php
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
class ReservaController extends \BaseController {

	/**
	 * Parametros para api paypal
	 */
    private $_api_context;
    private $_ClientId='ARfbWm2_1lMBeW1wQgqZvCT7g4TuxpsR1kO0uKi6NaPcNIr5h5F-zWmg5k9UQlhH46ETD1YVars99pyK';
    private $_ClientSecret='EDpmeTpZDpsUdwCjFXUqOarephJJNZFAB7UkvNL4dBYFkfraibowkB2XhgQUCRpvJ91R9gNObFR_plAJ';

    /*
     * Inicializamos api paypal
     */
    public function __construct()
    {
        $this->_api_context = new ApiContext(new OAuthTokenCredential($this->_ClientId, $this->_ClientSecret));
        $this->_api_context->setConfig(array(
            'mode' => 'sandbox',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__.'/../PayPal.log',
            'log.LogLevel' => 'FINE'
        ));
    }

    /**
     * Carga la vista de inicio de reserva
     * @return unavailable, array de string [yyyy-mm-dd] días no disponibles en airbnb, se inyectan en javascript en la vista de reserva
     */
    public function index()
	{
        $unavailable = $this->unavailable();

        JavaScript::put([
            'unavailable' => $unavailable,
        ]);

        if($unavailable == null){
            return View::make('site/notservice');
        }
        return View::make('site/reservar');
	}



     /**
	 * Carga la vista de reserva con las fechas selecionadas en la página de inicio
	 *
	 * @return unavailable, array de string [yyyy-mm-dd] días no disponibles en airbnb, se inyectan en javascript en la vista de reserva
      * @return fecha_ini, fecha de inicio del intervalo de reserva
      * @return fecha_fin, fecha de fin del intervalo de reserva
	 * */
    public function postCreateWithInput(){
        $unavailable = $this->unavailable();
        if($unavailable == null){
            return View::make('site/notservice');
        }
        $fecha_ini = Input::get("fecha_ini");
        $fecha_fin = Input::get("fecha_fin");
        JavaScript::put([
            'unavailable' => $unavailable,
        ]);
        return View::make('site/reservar',compact('fecha_ini','fecha_fin'));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{


        $meses = array(
            'enero',
            'debrero',
            'marzo',
            'abril',
            'mayo',
            'junio',
            'julio',
            'agosto',
            'septiembre',
            'octubre',
            'noviembre',
            'diciembre');
        $months = array(
            'january',
            'february',
            'march',
            'april',
            'may',
            'june',
            'july ',
            'august',
            'september',
            'october',
            'november',
            'december',
        );
        Input::merge(array('fecha_ini'=> str_replace($meses,$months,Input::get('fecha_ini'))));
        Input::merge(array('fecha_fin'=> str_replace($meses,$months,Input::get('fecha_fin'))));
        Input::merge(array('fecha_nacimiento'=> str_replace($meses,$months,Input::get('fecha_nacimiento'))));
        Input::merge(array('fecha_expedicion'=> str_replace($meses,$months,Input::get('fecha_expedicion'))));


        /*
         * NUEVOS CAMPOS:
         *
         * Fecha Nacimiento
         * Fecha Expedicion
         * Pais
         * Pasaporte
         * Condiciones de uso
         *
         * */

        //Reglas de validación

        $rule_date =    'required|date|date_format:d M Y|before:fecha_fin';

        if(Input::get('fecha_ini') == Input::get('fecha_fin'))
            $rule_date = 'required|date|date_format:d M Y';

        $rules = array(
            'nombre'   => 'required|min:3',
            'dni' => 'required',
            'email' => 'required|email',
            'fecha_ini' => $rule_date,
            'fecha_fin' => 'required|date|date_format:d M Y',
            'fecha_nacimiento'  =>  'required|date|date_format:d M Y',
            'fecha_expedicion'  =>  'required|date|date_format:d M Y',
            'pais_nacionalidad' =>  'required',
            'adultos' => 'required|integer|min:1|max:8',
            'ninos' => 'required|integer|min:0|max:4',
            'condiciones_uso' => 'required',
        );



        // Validate the inputs

        $validator = Validator::make(Input::all(), $rules, array(
            'condiciones_uso.required'   =>  'Por favor, lea atentamente las condiciones de uso y aceptelas para tramitar la reserva.',
            'pais_nacionalidad.required'    =>  'El campo país es requerido',
        ));


        // Check if the form validates with success

        if ($validator->passes())

        {

            $fecha_ini         = date('y-m-d',strtotime(Input::get('fecha_ini')));

            $fecha_fin         = date('y-m-d',strtotime(Input::get('fecha_fin')));

            $fecha_nacimiento  = date('y-m-d', strtotime(Input::get('fecha_nacimiento')));

            $fecha_expedicion  = date('y-m-d', strtotime(Input::get('fecha_expedicion')));

            $reserva_disponible     =   Reserva::validate_dates_reserva(Input::get('fecha_ini'), Input::get('fecha_fin'));



            if($reserva_disponible['success'] == 0) {
                return Redirect::to('/Reservar')->withInput()->with('error', 'Error al reservar, fechas no validas');
            }



            $reserva = new Reserva();

            $reserva->nombre            = Input::get('nombre');

            $reserva->fecha_expedicion  = $fecha_expedicion;

            $reserva->fecha_nacimiento  = $fecha_nacimiento;

            $reserva->pais_nacionalidad = Input::get('pais_nacionalidad');

            $reserva->email             = Input::get('email');

            $reserva->telefono          = Input::get('telefono');

            $reserva->adultos           = Input::get('adultos');

            $reserva->ninos             = Input::get('ninos');

            $reserva->fecha_ini         = $fecha_ini;

            $reserva->fecha_fin         = $fecha_fin;

            $reserva->observaciones     = Input::get('observaciones');

            $reserva->precio            = floatval($this->getPrecioPrivate($reserva->fecha_ini,$reserva->fecha_fin));

            $reserva->clave_pago       = uniqid();


            if ($reserva->save()) {

                Mail::send('emails.solicitud_reserva', array('data' => $reserva), function ($message) use($reserva) {
                    //$message->to('cristina@synergia.es')->subject('Synergia-resort. Nuevo Comentario.');
                    $message->to( $reserva->email)->subject('Synergia-resort. Solicitud de reserva.');
                });
                Mail::send('emails.solicitud_reserva_admin', array('data' => $reserva), function ($message) {
                    //$message->to('cristina@synergia.es')->subject('Synergia-resort. Nuevo Comentario.');
                    $message->to('jose1561991@gmail.com')->subject('Synergia-resort. Solicitud de reserva.');
                });
                return Redirect::to('/Reservar')->with('success', 'La reserva se ha solicitado correctamente, compruebe su correo');
            }




        }

        Input::merge(array('fecha_ini'=> str_replace($months,$meses,Input::get('fecha_ini'))));
        Input::merge(array('fecha_fin'=> str_replace($months,$meses,Input::get('fecha_fin'))));

        // Form validation failed

       return Redirect::to('/Reservar')->withInput()->withErrors($validator);
	}


    public function getRealizarPago($uniq){

        $reserva = Reserva::where('clave_pago','like',$uniq)->first();

        if ($reserva == null){
            return Redirect::to('/Reservar')->with('error', 'Ha ocurrido algún error, por favor intentelo más tarde.');
        }

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        $concepto = "Reserva realizadal por ". $reserva->nombre;
        $cuota = floatval($this->getPrecioPrivate($reserva->fecha_ini,$reserva->fecha_fin));

        $item1 = new Item();
        $item1->setName('Apartamento Sevilla')
            ->setDescription($concepto)
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($cuota);
        $itemList = new ItemList();
        $itemList->setItems(array($item1));
        $details = new Details();
        $details->setShipping("0")
            //total of items prices
            ->setSubtotal(''.$cuota);
        //Payment Amount
        $amount = new Amount();
        $amount->setCurrency("EUR")
            // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
            ->setTotal($cuota)
            ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Reserva apartamento")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(URL::to('Reservar/Finalizar'))
            ->setCancelUrl(URL::to('Reservar/create'));

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'

        $payment = new Payment();

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                exit;
            } else {
                die('Some error occur, sorry for inconvenient');
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());
        Session::put('reserva',$reserva);

        if(isset($redirect_url)) {
            // redirect to paypal
            return Redirect::away($redirect_url);
        }
        Redirect::to('/Reservar')
            ->with('error', 'Ha ocurrido un problema al pagar, intentelo más tarde.');

    }

    public function finalizar(){

        $payment_id = Session::get('paypal_payment_id');
        $reserva = Session::get('reserva');
        // clear the session payment ID
        Session::forget('paypal_payment_id');
        Session::forget('reserva');

        $payerId=Input::get('PayerID');
        $token=Input::get('token');
        if (empty($payerId) || empty($token)) {
            Redirect::to('/Reservar')
                ->with('error', 'Ha ocurrido un problema al pagar, intentelo más tarde.');
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);


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
                if ($result->getState() == 'approved') { // payment made
                    $reserva->precio =  $this->getPrecioPrivate($reserva->fecha_ini,$reserva->fecha_fin);
                    $reserva->pagado = true;
                    $reserva->save();
                        $url = "https://api.airbnb.com/v2/calendars/12878755/2018-06-15/2018-06-20";
                        $data_json = '{"availability":"unavailable"}';
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Airbnb-OAuth-Token: '.$access["access_token"],'Content-Type: application/json; charset=UTF-8','Content-Length: ' . strlen($data_json)));
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response  = curl_exec($ch);
                        curl_close($ch);
                        // Redirect to the new entrada post page
                        Mail::send('emails.fin_reserva', array('data' => $reserva), function ($message) use($reserva) {
                            //$message->to('cristina@synergia.es')->subject('Synergia-resort. Nuevo Comentario.');
                            $message->to( $reserva->email)->subject('Synergia-resort. Gracias por su reserva.');
                        });
                        Mail::send('emails.fin_reserva_admin', array('data' => $reserva), function ($message) {
                            //$message->to('cristina@synergia.es')->subject('Synergia-resort. Nuevo Comentario.');
                            $message->to('jose1561991@gmail.com')->subject('Synergia-resort. Pago de reserva.');
                        });
                        return Redirect::to('/Reservar')->with('success', 'La reserva se ha realizado correctamente, compruebe su correo');




                }

        }




        // Redirect to the entrada post create page

        return Redirect::to('/Reservar')->with('error', 'Error al reservar, intentelo de nuevo');
    }

    public function cancelar(){
        return Redirect::to('/Reservar')->with('error', 'Has cancelado la reserva');
    }
    public function __call($a,$b){
        return Redirect::to('/');
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
    public function getPrecio($fecha_ini,$fecha_fin){
        $precio = 0.0;
        $intervalos_pisados   = DB::table('configuraciones')
            ->whereNotNull('fecha_ini')->whereNotNull('fecha_fin')
            ->where('fecha_ini', '>', $fecha_ini)
            ->where('fecha_fin', '<', $fecha_fin)
            ->orderBy('fecha_ini', 'DESC')
            ->get();

        $intervalo_entandar = Configuracion::where('alias','like','Estándar')->first();
        $intervalo1 = Configuracion::where('fecha_ini','<=',$fecha_ini)->where('fecha_fin','>=',$fecha_ini)->first();
        $intervalo2 = Configuracion::where('fecha_ini','<=',$fecha_fin)->where('fecha_fin','>=',$fecha_fin)->first();
        if($intervalo1 == null){
            $intervalo1 = new Configuracion;
            $intervalo1->id = -1;
        }
        if($intervalo2 == null){
            $intervalo2 = new Configuracion;
            $intervalo2->id = -2;
        }
        //die($this->difDias($fecha_ini,$intervalo1->fecha_fin == null ? null : date ( 'Y-m-d' ,strtotime ('+1 day' , strtotime($intervalo1->fecha_fin)))));
        $dias = $this->difDias($fecha_ini,$fecha_fin);
        $dias_totales = 0;
        if($dias < 7){
            if(($intervalo1->id != $intervalo2->id)) {
                $precio = ($intervalo1->precio_noche_adicional * $this->difDias($fecha_ini,$intervalo1->fecha_fin == null ? null : date ( 'Y-m-d' ,strtotime ('+1 day' , strtotime($intervalo1->fecha_fin))))) + ($intervalo2->precio_noche_adicional * $this->difDias($intervalo2->fecha_ini, $fecha_fin));
                $dias_totales += $this->difDias($fecha_ini,$intervalo1->fecha_fin == null ? null : date ( 'Y-m-d' ,strtotime ('+1 day' , strtotime($intervalo1->fecha_fin)))) + $this->difDias($intervalo2->fecha_ini, $fecha_fin);
            }else{
                $precio = ($intervalo1->precio_noche_adicional * $dias);
                $dias_totales += $dias;
            }

        }else{
            if($intervalo1->id != $intervalo2->id) {
                $precio = (($intervalo1->precio_semana/7) * $this->difDias($fecha_ini,$intervalo1->fecha_fin == null ? null : date ( 'Y-m-d' ,strtotime ('+1 day' , strtotime($intervalo1->fecha_fin))))) + (($intervalo2->precio_semana/7) * $this->difDias($intervalo2->fecha_ini, $fecha_fin));
                $dias_totales += $this->difDias($fecha_ini,$intervalo1->fecha_fin == null ? null : date ( 'Y-m-d' ,strtotime ('+1 day' , strtotime($intervalo1->fecha_fin)))) + $this->difDias($intervalo2->fecha_ini, $fecha_fin);
            }else{
                $precio = (($intervalo1->precio_semana/7) * $dias);
                $dias_totales += $dias;
            }
        }

        foreach($intervalos_pisados as $intervalo_pisado){
            $dias_int = $this->difDias($intervalo_pisado->fecha_ini,$intervalo_pisado->fecha_fin == null ? null : date ( 'Y-m-d' ,strtotime ('+1 day' , strtotime($intervalo_pisado->fecha_fin))));
            if($dias < 7){
                $precio += $intervalo_pisado->precio_noche_adicional * $dias_int;
            }else{
                $precio += ($intervalo_pisado->precio_semana/7) * $dias_int;
            }
            $dias_totales += $dias_int;
        }

        if($dias < 7){
            $precio += $intervalo_entandar->precio_noche_adicional * ($dias - $dias_totales);
        }else{
            $precio += ($intervalo_entandar->precio_semana/7) * ($dias - $dias_totales);
        }
        return Response::json(array('success'=>true,'precio'=>$precio),200);
    }

    private function getPrecioPrivate($fecha_ini,$fecha_fin){
        $precio = 0.0;
        $intervalos_pisados   = DB::table('configuraciones')
            ->whereNotNull('fecha_ini')->whereNotNull('fecha_fin')
            ->where('fecha_ini', '>', $fecha_ini)
            ->where('fecha_fin', '<', $fecha_fin)
            ->orderBy('fecha_ini', 'DESC')
            ->get();

        $intervalo_entandar = Configuracion::where('alias','like','Estándar')->first();
        $intervalo1 = Configuracion::where('fecha_ini','<=',$fecha_ini)->where('fecha_fin','>=',$fecha_ini)->first();
        $intervalo2 = Configuracion::where('fecha_ini','<=',$fecha_fin)->where('fecha_fin','>=',$fecha_fin)->first();
        if($intervalo1 == null){
            $intervalo1 = new Configuracion;
            $intervalo1->id = -1;
        }
        if($intervalo2 == null){
            $intervalo2 = new Configuracion;
            $intervalo2->id = -2;
        }
        //die($this->difDias($fecha_ini,$intervalo1->fecha_fin == null ? null : date ( 'Y-m-d' ,strtotime ('+1 day' , strtotime($intervalo1->fecha_fin)))));
        $dias = $this->difDias($fecha_ini,$fecha_fin);
        $dias_totales = 0;
        if($dias < 7){
            if(($intervalo1->id != $intervalo2->id)) {
                $precio = ($intervalo1->precio_noche_adicional * $this->difDias($fecha_ini,$intervalo1->fecha_fin == null ? null : date ( 'Y-m-d' ,strtotime ('+1 day' , strtotime($intervalo1->fecha_fin))))) + ($intervalo2->precio_noche_adicional * $this->difDias($intervalo2->fecha_ini, $fecha_fin));
                $dias_totales += $this->difDias($fecha_ini,$intervalo1->fecha_fin == null ? null : date ( 'Y-m-d' ,strtotime ('+1 day' , strtotime($intervalo1->fecha_fin)))) + $this->difDias($intervalo2->fecha_ini, $fecha_fin);
            }else{
                $precio = ($intervalo1->precio_noche_adicional * $dias);
                $dias_totales += $dias;
            }

        }else{
            if($intervalo1->id != $intervalo2->id) {
                $precio = (($intervalo1->precio_semana/7) * $this->difDias($fecha_ini,$intervalo1->fecha_fin == null ? null : date ( 'Y-m-d' ,strtotime ('+1 day' , strtotime($intervalo1->fecha_fin))))) + (($intervalo2->precio_semana/7) * $this->difDias($intervalo2->fecha_ini, $fecha_fin));
                $dias_totales += $this->difDias($fecha_ini,$intervalo1->fecha_fin == null ? null : date ( 'Y-m-d' ,strtotime ('+1 day' , strtotime($intervalo1->fecha_fin)))) + $this->difDias($intervalo2->fecha_ini, $fecha_fin);
            }else{
                $precio = (($intervalo1->precio_semana/7) * $dias);
                $dias_totales += $dias;
            }
        }

        foreach($intervalos_pisados as $intervalo_pisado){
            $dias_int = $this->difDias($intervalo_pisado->fecha_ini,$intervalo_pisado->fecha_fin == null ? null : date ( 'Y-m-d' ,strtotime ('+1 day' , strtotime($intervalo_pisado->fecha_fin))));
            if($dias < 7){
                $precio += $intervalo_pisado->precio_noche_adicional * $dias_int;
            }else{
                $precio += ($intervalo_pisado->precio_semana/7) * $dias_int;
            }
            $dias_totales += $dias_int;
        }

        if($dias < 7){
            $precio += $intervalo_entandar->precio_noche_adicional * ($dias - $dias_totales);
        }else{
            $precio += ($intervalo_entandar->precio_semana/7) * ($dias - $dias_totales);
        }
        return $precio;
    }
    private function difDias($fecha_ini,$fecha_fin){
        if($fecha_ini == null or $fecha_fin == null){
            return 0;
        }
        $dias	= (strtotime($fecha_ini)-strtotime($fecha_fin))/86400;
        $dias 	= abs($dias);
        $dias = floor($dias);
        return $dias;
    }
}
