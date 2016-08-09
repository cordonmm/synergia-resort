<!DOCTYPE html>

<html lang="en-US">


<head>
    <meta charset="utf-8">
</head>

<body>
<p>
    Se ha realizado la siguiente solicitud de reserva a traves de la plataforma web. <br>
</p>

    <hr>
        <p>Datos de la solicitud de reserva:</p>
    <hr>


    <p>Nombre: {{ $data->nombre }}</p>
    <p>Email: {{ $data->email }}</p>
    <p>Fecha Nacimiento: {{ $data->fecha_nacimiento }}</p>
    <p>País: {{ $data->pais_nacionalidad }}</p>
    <p>Teléfono: {{ $data->telefono }}</p>
    <p>Adultos: {{ $data->adultos }}</p>
    <p>Niños: {{ $data->ninos }}</p>
    <p>Llegada: {{ date('d/m/Y',strtotime($data->fecha_ini)) }}</p>
    <p>Salida: {{ date('d/m/Y',strtotime($data->fecha_fin)) }}</p>
    <p>Precio: {{  $data->precio }}&euro;</p>



<p>
 Puede acceder a traves del siguiente enlace: {{URL::to('admin/reservas')}}
</p>

</body>


</html>