<!DOCTYPE html>

<html lang="en-US">


<head>
    <meta charset="utf-8">
</head>

<body>

<p>
   Pago de Reserva confirmado.<br>
</p>
    <hr>
        <p>Datos de la Reserva:</p>
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
    <p>Precio: {{  $data->precio }}&euro; IVA incluido.</p>

<p>
    Puede acceder al historico de reservas a traves del siguiente enlace: {{URL::to('admin/reservas')}}
</p>
    

</body>


</html>