<!DOCTYPE html>

<html lang="en-US">


<head>
    <meta charset="utf-8">
</head>

<body>

<p>
   Reserva confirmada. ¡Enhorabuena, {{ $data->nombre }}! ¡Has reservado nuestro apartamento!. <br>
</p>
    <hr>
        <p>Datos de la Reserva:</p>
    <hr>


    <p>Nombre: {{ $data->nombre }}</p>
    <p>Fecha Nacimiento: {{ $data->fecha_nacimiento }}</p>
    <p>País: {{ $data->pais_nacionalidad }}</p>
    <p>Teléfono: {{ $data->telefono }}</p>
    <p>Adultos: {{ $data->adultos }}</p>
    <p>Niños: {{ $data->ninos }}</p>
    <p>Llegada: {{ date('d/m/Y',strtotime($data->fecha_ini)) }}</p>
    <p>Salida: {{ date('d/m/Y',strtotime($data->fecha_fin)) }}</p>
    <p>Precio: {{  $data->precio }}&euro; IVA incluido.</p>


    <h4>CONDICIONES DE USO</h4>
    <p style="text-align: justify; font-size: 10px">
        Una vez acordada la hora de entrada al apartamento se debe respetar, así que por favor sea puntual.
        En caso de retraso superior a 1 hora se le cobrará un suplemento de 20 € por hora.
        Se contemplarán ciertas excepciones, como retraso en el vuelo o accidente grave, siempre y cuenta se proporcione el justificante adecuado.
    </p>

    <h4>TERMS OF USE</h4>
    <p style="text-align: justify; font-size: 10px">
        Once the time of entry to the apartment has been agreed you must respect this, so please to be punctual.
        In case of delay exceeding 1 hour you will be charged with an extra cost of 20€ per hour.
        Some exception such an flight delays or major accidents will be accepted as long as any proof can be provided.
    </p>
    <p>
        Para realizar algún cambio en la reserva pongase en contacto a traves del siguiente email cristina@synergia.es.

        Gracias por reservar en nuestro apartamento. ¡Nos vemos pronto!<br>

    </p>
    

</body>


</html>