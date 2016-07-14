<?php
/**



 * Laravel - A PHP Framework For Web Artisans



 *



 * @package  Laravel



 * @author   Desarrollo 10Code Software en Sevilla



 */

    

    $user_agent = $_SERVER['HTTP_USER_AGENT'];



    //CAPAMOS ACCESO A INTERNET EXPLORER, VERSI�N WEB Y M�VIL.

    $posicion = strrpos($user_agent, "MSIE");

    $posicion2 = strrpos($user_agent, "IEMobile");



    //echo $user_agent;



    if ($posicion === false && $posicion2 === false)

        $ie = false;

    else

        $ie = true;



    if ($ie)

    {

        header('Location: http://www.hermandaddevalme.es/navegador');        

    }



    //FIN CAPAMOS ACCESO


    /*if(date('d-m-Y H:i') <= '11-09-2015 21:35')
    {
        if($_SERVER['REMOTE_ADDR'] != '217.217.240.130'){
            header('Location: http://www.hermandaddevalme.es/indexprox.php');
        }       
        
    }*/
/* PRUEBA DE COMMIT



|--------------------------------------------------------------------------



| Register The Auto Loader



|--------------------------------------------------------------------------



|



| Composer provides a convenient, automatically generated class loader



| for our application. We just need to utilize it! We'll require it



| into the script here so that we do not have to worry about the



| loading of any our classes "manually". Feels great to relax.



|



*/



ini_set('eaccelerator.enable', 0);







require __DIR__ . '/laravel/bootstrap/autoload.php';



error_reporting(E_ALL ^ E_NOTICE);

/*



|--------------------------------------------------------------------------



| Turn On The Lights



|--------------------------------------------------------------------------



|



| We need to illuminate PHP development, so let's turn on the lights.



| This bootstraps the framework and gets it ready for use, then it



| will load up this application so that we can run it and send



| the responses back to the browser and delight these users.



|



*/







$app = require_once __DIR__ . '/laravel/bootstrap/start.php';









/*



|--------------------------------------------------------------------------



| Run The Application



|--------------------------------------------------------------------------



|



| Once we have the application, we can simply call the run method,



| which will execute the request and send the response back to



| the client's browser allowing them to enjoy the creative



| and wonderful application we have whipped up for them.



|



*/







$app->run();