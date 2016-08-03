<?php
class ComentarioController extends \BaseController {

    public function enviar(){

        // tu clave secreta
        $secret = "6LfP6SUTAAAAACLEx31UvN9uYPjtEOo7lUJYeyer";

        // respuesta vacía
        $response = null;

        // comprueba la clave secreta
        $reCaptcha = new ReCaptcha($secret);

        // si se detecta la respuesta como enviada
        if ($_POST["g-recaptcha-response"]) {
            $response = $reCaptcha->verifyResponse(
                $_SERVER["REMOTE_ADDR"],
                $_POST["g-recaptcha-response"]
            );
        }

        if (!($response != null && $response->success)){
            Input::flashExcept('valoracion');
            return Redirect::to('Comentar');
        }


        if(!isset($_REQUEST['valoracion']) || $_REQUEST['valoracion']==''){
            $rules  =   array(
                'contact-name' => 'required',
                'contact-email' => 'required|email',
                'contact-message' => 'required'
            );
            $valoracion = NULL;
        }
        else{
            $rules  =   array(
                'contact-name' => 'required',
                'contact-email' => 'required|email',
                'contact-message' => 'required',
                'valoracion'        =>  'integer|min:1|max:5'
            );
            $valoracion = Input::get('valoracion');
        }


        $validator = Validator::make(
            Input::all(),
            $rules,
            array(
                'required'  =>  'Debe rellenar este campo.',
                'email'     =>  'El formato es inválido.',
                'integer'   =>  'La puntuación debe ser un número entero.',
                'min'       =>  'La puntuación no puede ser inferior a 1.',
                'max'       =>  'La puntuación no puede ser superior a 5.'
            )
        );

        if($validator->fails()){
            Input::flashExcept('valoracion');
            return Redirect::to('Comentar')->withErrors($validator);
        }


        $comentario = new Comentario;
        $comentario->nombre     =       strip_tags(Input::get('contact-name'));
        $comentario->email      =       strip_tags(Input::get('contact-email'));
        $comentario->texto      =       strip_tags(Input::get('contact-message'));
        $comentario->publicado  =       0;
        $comentario->valoracion =       $valoracion;

        $comentario->save();

        //Enviar correo a Admin

        Mail::send('emails.contacto', array('data' => Input::all()), function($message)
        {
            //$message->to('cristina@synergia.es')->subject('Synergia-resort. Nuevo Comentario.');
            $message->to('jotelo969.informatico@gmail.com')->subject('Synergia-resort. Nuevo Comentario.');
        });

        return Redirect::to('Comentar')->with('success', '<b>Su email está pendiente de confirmación para ser publicado, Muchas gracias por su aportación.</b>');

    }

}
