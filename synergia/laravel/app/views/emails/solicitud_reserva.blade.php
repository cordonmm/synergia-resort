<!DOCTYPE html>

<html lang="en-US">


<head>
    <meta charset="utf-8">
</head>

<body>


    <hr>
        <p>Datos de la solicitud de reserva:</p>
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
        Gracias por realizar la solicitud de reserva para nuestro apartamento. <br>
        Nos pondremos en contacto con usted en el menor tiempo posible.
    </p>
    

</body>


</html>