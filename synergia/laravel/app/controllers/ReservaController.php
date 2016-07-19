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
		//
        $reserva = new Reserva();
        return View::make('site/reservar',compact('reserva'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $reserva = new Reserva();
        return View::make('site/reservar',compact('reserva'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

        //Reglas de validación
        $rules = array(
            'nombre'   => 'required|min:3',
            'dni' => array('required','regex:/^(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))$/i'),
            'email' => 'required|email',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'required|date',
            'adultos' => 'required|integer',
            'ninos' => 'required|integer',


        );



        // Validate the inputs

        $validator = Validator::make(Input::all(), $rules);



        // Check if the form validates with success

        if ($validator->passes())

        {

            $reserva = new Reserva();


            //nombre, apellido, telefono. observaciones, nºadultos, nºniños, dni, fecha llegada, fecha salida, precio, email
            $reserva->nombre            = Input::get('nombre');

            $reserva->email             = Input::get('email');

            $reserva->telefono          = Input::get('telefono');

            $reserva->adultos           = Input::get('adultos');

            $reserva->ninos             = Input::get('ninos');

            $reserva->fecha_ini         = date('y-m-d',strtotime(Input::get('fecha_ini')));

            $reserva->fecha_fin         = date('y-m-d',strtotime(Input::get('fecha_fin')));;

            $reserva->observaciones     = Input::get('observaciones');






            $payer = new Payer();
            $payer->setPaymentMethod("paypal");
            $concepto = "Reserva realizadal por ". $reserva->nombre;
            $cuota = floatval(501);
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
            $redirectUrls->setReturnUrl(URL::to('reserva/finalizar'))
                ->setCancelUrl(URL::to('reserva'));

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

            return View::make('site/misrecibos')->with('error', 'Unknown error occurred');

            // Was the entrada post created?



        }



        // Form validation failed

        return Redirect::to('Reservar/create')->withInput()->withErrors($validator);
	}


    public function finalizar(){

        if($reserva->save())

        {

            // Redirect to the new entrada post page

            return Redirect::to('Reservar/create')->with('success', 'La reserva se ha realizado correctamente, compruebe sus correo');

        }



        // Redirect to the entrada post create page

        return Redirect::to('Reservar/create')->with('error', 'Error al reservar, intentelo de nuevo');
    }


}
