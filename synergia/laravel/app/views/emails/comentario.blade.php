<!DOCTYPE html>

<html lang="en-US">


<head>
    <meta charset="utf-8">
</head>

<body>
    <p>
        Un nuevo comentario ha sido enviado por un usuario de la web, revise el panel para validarlo(Por defecto todos los nuevos comentarios no están publicados).
    </p>

    <hr>
        <p>Datos del comentario en cuestión:</p>
    <hr>

    <p>Autor: {{ $data['contact-name'] }}</p>
    <p>Email: {{ $data['contact-email'] }}</p>
    <p>Comentario:</p>
    <p>
        {{ $data['contact-message'] }}
    </p>
    
    <p>
        Para hacer la gestión del comentario haz click en el siguiente enlace:<br>
        <a href="{{ URL::to('admin/comentarios') }}">{{ URL::to('admin/comentarios') }}</a>
    </p>
    

</body>


</html>