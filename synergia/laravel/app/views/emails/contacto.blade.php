<!DOCTYPE html>

<html lang="en-US">


<head>
    <meta charset="utf-8">
</head>

<body>
    <h2>Nueva solicitud de tutoría</h2>
    
    <p>
        El padre/madre/tutor del alumno/a {{$nombre}} ha solicitado una tutoría con usted.
    </p>
    
    <p>Estos son sus datos de contacto:</p>
    
    <ul>
        <li><b>Teléfono:</b> {{$telefono}}</li>
        <li><b>Email:</b> {{$email}}</li>
    </ul>
    
    <p>El motivo de la cita es el siguiente:</p>
    
    <div style="padding: 1em; background-color: #99c2ff; border: 1px solid grey;"><p style="color: grey;"><b>{{$mensaje}}</b></p></div>
    
    <p>Pongase en contacto con el/ella a la mayor brevedad posible para gestionarla. Gracias.</p>
    
    <p><b>EL EQUIPO DIRECTIVO.</b></p>    
    

</body>


</html>