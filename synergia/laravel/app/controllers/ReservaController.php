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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    private $_api_context;
    private $_ClientId='AQe9z3SXB_oTk2KwMI204QyZ7FZtaZKGP-l4V6z5zwYemBH5CHjskoRcwkuQnnWjdjS1VG_PLNvOAMIj';
    private $_ClientSecret='EN2swwMeiaj2HUr2Z6Fx8K0RoKRE4Du95xqqXhsWb3m1Bo0Zqvsu7rx6sFJcIbWURcd-Fz0M5snT2hpb';


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
    public function index()
	{
        $unavailable = $this->unavailable();

        JavaScript::put([
            'unavailable' => $unavailable,
        ]);

        if($unavailable == null){
            $error = "El servicio de reserva no está disponible en este momento, intentelo de nuevo más tarde";
            return View::make('site/reservar',compact('error'));
        }
        return View::make('site/reservar');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

        $unavailable = $this->unavailable();

        JavaScript::put([
            'unavailable' => $unavailable,
        ]);

        if($unavailable == null){
            $error = "El servicio de reserva no está disponible en este momento, intentelo de nuevo más tarde";
            return View::make('site/reservar',compact('error'));
        }
        JavaScript::put([
            'unavailable' => $unavailable,
        ]);

        return View::make('site/reservar');
	}


    public function postCreateWithInput(){
        $unavailable = $this->unavailable();


        JavaScript::put([
            'unavailable' => $unavailable,
        ]);

        if($unavailable == null){
            $error = "El servicio de reserva no está disponible en este momento, intentelo de nuevo más tarde";
            return View::make('site/reservar',compact('error'));
        }
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
        //Reglas de validación
        $rules = array(
            'nombre'   => 'required|min:3',
            'dni' => array('required','regex:/^(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))$/i'),
            'email' => 'required|email',
            'fecha_ini' => 'required|date_format:d M Y',
            'fecha_fin' => 'required|date_format:d M Y',
            'adultos' => 'required|integer',
            'ninos' => 'required|integer',


        );



        // Validate the inputs

        $validator = Validator::make(Input::all(), $rules);



        // Check if the form validates with success

        if ($validator->passes())

        {
            $fecha_ini         = date('y-m-d',strtotime(Input::get('fecha_ini')));

            $fecha_fin         = date('y-m-d',strtotime(Input::get('fecha_fin')));

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
                $bandera = true;
                foreach($calendar_days as $dia){
                    if(!$dia["available"]){
                        array_push($unavailable,$dia["date"]);
                        if (($fecha_ini==date('y-m-d',strtotime($dia["date"]))) or  ($fecha_ini <= date('y-m-d',strtotime($dia["date"])) and date('y-m-d',strtotime($dia["date"]))< $fecha_fin)){
                            $bandera = false;
                            echo $fecha_ini;
                            die(date('y-m-d',strtotime($dia["date"])));
                        }
                    }
                }
                if(!$bandera) {
                    return Redirect::to('/Reservar')->withInput()->with('error', 'Error al reservar, fechas no validas');
                }

            }


            $reserva = new Reserva();


            //nombre, apellido, telefono. observaciones, nºadultos, nºniños, dni, fecha llegada, fecha salida, precio, email
            $reserva->nombre            = Input::get('nombre');

            $reserva->email             = Input::get('email');

            $reserva->telefono          = Input::get('telefono');

            $reserva->adultos           = Input::get('adultos');

            $reserva->ninos             = Input::get('ninos');

            $reserva->fecha_ini         = $fecha_ini;

            $reserva->fecha_fin         = $fecha_fin;

            $reserva->observaciones     = Input::get('observaciones');





            $interval = date_diff(new Datetime($fecha_ini) , new Datetime($fecha_fin));
            $payer = new Payer();
            $payer->setPaymentMethod("paypal");
            $concepto = "Reserva realizadal por ". $reserva->nombre;
            $cuota = floatval(Configuracion::first()->precio_noche_adicional)*$interval->format('%a');;
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

            return Redirect::to('/Reservar')->with('error', 'Unknown error occurred');

            // Was the entrada post created?



        }

        Input::merge(array('fecha_ini'=> str_replace($months,$meses,Input::get('fecha_ini'))));
        Input::merge(array('fecha_fin'=> str_replace($months,$meses,Input::get('fecha_fin'))));

        // Form validation failed

       return Redirect::to('/Reservar')->withInput()->withErrors($validator);
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
            $bandera = true;
            #
            $fecha_ini         = date('y-m-d',strtotime($reserva->fecha_ini));

            $fecha_fin         = date('y-m-d',strtotime($reserva->fecha_fin));

            foreach($calendar_days as $dia){
                if(!$dia["available"]){
                    array_push($unavailable,$dia["date"]);
                    if (($fecha_ini==date('y-m-d',strtotime($dia["date"]))) or  ($fecha_ini <= date('yy-mm-dd',strtotime($dia["date"])) and date('yy-mm-dd',strtotime($dia["date"]))< $fecha_fin)){
                        $bandera = false;
                    }
                }
            }
            if($bandera) {

                //Execute the payment
                $result = $payment->execute($execution, $this->_api_context);

                //echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT, remove it later

                if ($result->getState() == 'approved') { // payment made


                    if ($reserva->save()) {
                        $url = "https://api.airbnb.com/v2/calendars/12878755/2017-06-15/2017-06-15";
                        $data_json = '{"availability":"available"}';
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Airbnb-OAuth-Token: '.$access["access_token"],'Content-Type: application/json; charset=UTF-8','Content-Length: ' . strlen($data_json)));
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response  = curl_exec($ch);
                        curl_close($ch);
                        // Redirect to the new entrada post page

                        return Redirect::to('/Reservar')->with('success', 'La reserva se ha realizado correctamente, compruebe sus correo');

                    }


                }
            }
            else{
                return Redirect::to('/Reservar')->with('error', 'Error al reservar, fechas no validas');
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
        $ch = curl_init("https://api.airbnb.com/v1/authorize");
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=3092nxybyb0otqw18e8nh5nty&locale=es-ES&currency=EUR&grant_type=password&password=alojamiento16&username=cristina@synergia.es");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($ch);
        curl_close($ch);
        $access = json_decode($response,true);
        $unavailable = null;
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

        }
        return $unavailable;
    }
}
