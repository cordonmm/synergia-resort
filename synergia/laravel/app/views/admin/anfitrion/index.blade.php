@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
    Reservas :: @parent
@stop

@section('keywords')Entrys administration @stop
@section('author')Laravel 4 Bootstrap Starter SIte @stop
@section('description')Entrys administration index @stop

@section('styles')
    <style rel="stylesheet">
        .file-imagen-anfitrion{
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .file-imagen-anfitrion + label{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color:  rgba(30, 149, 255, 0.5);
            cursor: pointer;
            border-radius: 5px;
            opacity: 0;
            transition: all 1s;
            display: flex;
            align-items: center;
        }

        .file-imagen-anfitrion + label:hover, .file-imagen-anfitrion:focus + label{
            opacity: 1;
            transition: all 1s;
        }

        .file-imagen-anfitrion + label span{
            text-align: center;
            font-size: 8em;
            color: #fff;
            margin: auto;
        }

        .bg-anfitrion{
            background-image:
            @if(file_exists(public_path().'/template/anfitrion/anfitrion.jpg'))
                url('{{ asset("template/anfitrion/anfitrion.jpg") }}');
            @elseif(file_exists(public_path().'/template/anfitrion/anfitrion.jpeg'))
                url('{{ asset("template/anfitrion/anfitrion.jpeg") }}');
            @elseif(file_exists(public_path().'/template/anfitrion/anfitrion.png'))
                url('{{ asset("template/anfitrion/anfitrion.png") }}');
            @else
                url('{{ asset("template/anfitrion/default.png") }}');
            @endif
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            height:296px;
            margin: 30px auto;
        }

        @media all and (max-width: 767px){
            .file-imagen-anfitrion + label{
                top: -5%;
                height: 110%;
            }

            .page-header{
                margin-bottom: 20px !important;
            }
        }

    </style>
@stop

{{-- Content --}}
@section('content')
    <div class="page-header" style="margin-bottom: 150px;">
        <h3>
            Anfitrión
        </h3>
    </div>

    {{ Form::model(Anfitrion::first(), array('action' => 'AdminAnfitrionController@store', 'method' => 'post', 'files' => true, 'id' => 'formAnfitrion')) }}
    <div class="row">
        <div class="col-sm-6" style="position: relative;">
            <div class="bg-anfitrion"></div>
            <input type="file" name="imagenAnfitrion" id="imagenAnfitrion" class="file-imagen-anfitrion"/>
            <label for="imagenAnfitrion">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </label>
        </div>
        <div class="col-sm-6">
            <div class="form-group {{{ $errors->has('nombre') ? 'has-error' : '' }}}">
                {{ Form::label('nombre', 'Nombre', array('class' => 'control-label')) }}
                {{ Form::text('nombre', null, array('class' => 'form-control')) }}
                {{ $errors->first('nombre', '<span class="help-block">:message</span>') }}
            </div>
            <div class="form-group {{{ $errors->has('apellidos') ? 'has-error' : '' }}}">
                {{ Form::label('apellidos', 'Apellidos', array('class' => 'control-label')) }}
                {{ Form::text('apellidos', null, array('class' => 'form-control')) }}
                {{ $errors->first('apellidos', '<span class="help-block">:message</span>') }}
            </div>
            <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
                {{ Form::label('email', 'Email', array('class' => 'control-label')) }}
                {{ Form::text('email', null, array('class' => 'form-control')) }}
                {{ $errors->first('email', '<span class="help-block">:message</span>') }}
            </div>
            <div class="form-group {{{ $errors->has('telefono') ? 'has-error' : '' }}}">
                {{ Form::label('telefono', 'Teléfono', array('class' => 'control-label')) }}
                {{ Form::text('telefono', null, array('class' => 'form-control')) }}
                {{ $errors->first('telefono', '<span class="help-block">:message</span>') }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <button type="button" name="btnEliminarImagen" id="btnEliminarImagen" class="btn btn-danger" style="width: 100%; margin-top: 20px;">Eliminar Imagen</button>
        </div>
        <div class="col-sm-3">
            <label id="btnSustituirImagen" for="imagenAnfitrion" class="btn btn-warning" style="width: 100%; margin-top: 20px;">
                Sustituir Imagen
            </label>
        </div>
        <div class="col-sm-6">
            {{ Form::submit('Crear / Remplazar', array('class' =>  'btn btn-info', 'style' => 'width:100%; margin-top: 20px;')) }}
        </div>
    </div>
    {{ Form::close() }}
@stop

{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript">
        function sustituirImagen(){
            //Subir fichero via ajax

            var formData = new FormData(document.getElementById("formAnfitrion"));

            $.ajax({
                url: "{{ URL::to('admin/anfitrion/sustituir-imagen') }}",
                type: "post",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }).always(function(res){
                if(res[0] == 'good'){
                    window.location.href = window.location.href;
                }
            });
        }

        function eliminarImagen(){
            $.ajax({
                url: "{{ URL::to('admin/anfitrion/eliminar-imagen') }}",
                type: "get",
                dataType: "json",
                data: null,
                cache: false,
                contentType: false,
                processData: false
            }).always(function(res){
                if(res[0] == 'good'){
                    window.location.href = window.location.href;
                }
            });
        }

        $(document).ready(function(){
            $('#imagenAnfitrion').change(sustituirImagen);
            $('#btnEliminarImagen').click(eliminarImagen);
        });
    </script>
@stop