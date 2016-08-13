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
    //private $_ClientId='AZw-zNOxegZjFxOjTjC1ulkjpki3WlSL6wAW0EwtRURWN_sjzR7OQV54U2OwEKJbZXAAu21wKILKBTHq';
    //private $_ClientSecret='ECqBhqmJp6iO7cm9PXxHBhDmz-QhiRKELHAEtvfwnzjp0fYw45a_L6Pj0S7Pj7FShOjvJ_DjLPD7hkew';
    /**
      *SandBoxKeys**/
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

        $fecha_ini = Input::get("fecha_ini");
        $fecha_fin = Input::get("fecha_fin");
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
            'hora_llegada'  =>  'in:8:00,8:30,9:00,9:30,10:00,10:30,11:00,11:30,12:00,12:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00,17:30,18:00,18:30,19:00,19:30,20:00',
        );



        // Validate the inputs

        $validator = Validator::make(Input::all(), $rules, array(
            'condiciones_uso.required'   =>  'Por favor, lea atentamente las condiciones de uso y acéptelas para tramitar la reserva.',
            'pais_nacionalidad.required'    =>  'El campo país es requerido',
            'hora_llegada.in'        =>  'Por favor, introduzca una hora válida.',
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

            $reserva->dni               = Input::get('dni');

            $reserva->fecha_ini         = $fecha_ini;

            $reserva->fecha_fin         = $fecha_fin;

            $reserva->hora_llegada      = Input::get('hora_llegada');

            $reserva->observaciones     = Input::get('observaciones');

            $reserva->precio            = Reserva::precio_dates($reserva->fecha_ini,$reserva->fecha_fin);

            $reserva->clave_pago       = uniqid();


            if ($reserva->save()) {

                Mail::send('emails.solicitud_reserva', array('data' => $reserva), function ($message) use($reserva) {
                    //$message->to('cristina@synergia.es')->subject('Synergia-resort. Nuevo Comentario.');
                    $message->to( $reserva->email)->subject('Synergia-Resort. Solicitud de reserva.');
                });
                Mail::send('emails.solicitud_reserva_admin', array('data' => $reserva), function ($message) {
                    //$message->to('cristina@synergia.es')->subject('Synergia-resort. Nuevo Comentario.');
                    $message->to('cristina@synergia.es')->subject('Synergia-Resort. Solicitud de reserva.');
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
        $cuota = Reserva::precio_dates($reserva->fecha_ini,$reserva->fecha_fin);
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
                    $reserva->precio =  Reserva::precio_dates($reserva->fecha_ini,$reserva->fecha_fin);
                    $reserva->pagado = true;
                    $reserva->save();
                    $fecha_fin_periodo = strtotime ( '-1 day' , strtotime ( $reserva->fecha_fin ) ) ;
                    $fecha_fin_periodo = date ( 'y-m-d' , $fecha_fin_periodo  );

                        $url = "https://api.airbnb.com/v2/calendars/12878755/". $reserva->fecha_ini."/".$fecha_fin_periodo;
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
                            $message->to( $reserva->email)->subject('Synergia-Resort. Gracias por su reserva.');
                        });
                        Mail::send('emails.fin_reserva_admin', array('data' => $reserva), function ($message) {
                            //$message->to('cristina@synergia.es')->subject('Synergia-resort. Nuevo Comentario.');
                            $message->to('cristina@synergia.es')->subject('Synergia-Resort. Pago de reserva.');
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

    public function getUnavailables(){
        $unavailables = Reserva::unavailables();
        return Response::json(array('success'=>true,'unavailables'=>$unavailables),200);
    }

    public function getPrecio($fecha_ini,$fecha_fin){
        $precio = Reserva::precio_dates($fecha_ini,$fecha_fin);
        return Response::json(array('success'=>true,'precio'=>$precio),200);
    }



}
