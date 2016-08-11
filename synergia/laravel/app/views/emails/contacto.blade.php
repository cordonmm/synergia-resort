<!DOCTYPE html>

<html lang="en-US">


<head>
    <meta charset="utf-8">
</head>

<body>
    <p>
        Has recibido un mensaje a través de la web de Synergia Resort.
    </p>

    <hr>
        <p>Datos del contacto:</p>
    <hr>

    <p>Autor: {{ $data['contact-name'] }}</p>
    <p>Email: {{ $data['contact-email'] }}</p>
    <p>Comentario:</p>
    <p>
        {{ $data['contact-message'] }}
    </p>

    

</body>


</html>