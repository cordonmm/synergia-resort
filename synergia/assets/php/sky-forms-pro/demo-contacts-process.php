<?php

session_start();

if( isset($_POST['name']) && strtoupper($_POST['captcha']) == $_SESSION['captcha_id'] )

{

	$to = 'hermandaddevalme@hotmail.com'; // Replace with your email	

	$subject = 'Message from website'; // Replace with your $subject

	$headers = 'From: ' . $_POST['email'] . "\r\n" . 'Reply-To: ' . $_POST['email'];	

	

	$message = 'Name: ' . $_POST['name'] . "\n" .

	           'E-mail: ' . $_POST['email'] . "\n" .

	           'Subject: ' . $_POST['subject'] . "\n" .

	           'Message: ' . $_POST['message'];

	

	mail($to, $subject, $message, $headers);

    header('Location: http://www.10code.es/valeme/Contacto');	

	if( $_POST['copy'] == 'on' )

	{

		mail($_POST['email'], $subject, $message, $headers);

        header('Location: http://www.hermandaddevalme.es/Contacto');

	}

}

?>