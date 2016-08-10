<!DOCTYPE html>

<html lang="en-US">


<head>
    <meta charset="utf-8">
</head>

<body>

<p>
    Su reserva a sido aceptada y está a la espera de pago. <br>
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
    <p>Precio: {{  $data->precio }}&euro;</p>


    <p>
        Vaya al siguiente link para realizar el pago.
        {{URL::to('Reservar/').'/Pago/'.$data->clave_pago}}
        Gracias por reservar en nuestro apartamento. <br>

    </p>
    

</body>


</html>