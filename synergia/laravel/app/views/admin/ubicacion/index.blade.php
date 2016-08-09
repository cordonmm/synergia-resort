@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
    Ubicación :: @parent
@stop

@section('keywords')Entrys administration @stop
@section('author')Laravel 4 Bootstrap Starter SIte @stop
@section('description')Entrys administration index @stop

@section('styles')
<style rel="stylesheet">
    iframe{
        width: 100% !important;
    }
</style>
@stop

{{-- Content --}}
@section('content')
    <div class="page-header" style="margin-bottom: 20px;">
        <h3>
            Ubicación
        </h3>
    </div>

    {{ Form::model(Ubicacion::first(), array('action' => 'AdminUbicacionController@store', 'method' => 'post')) }}
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group {{{ $errors->has('titulo') ? 'has-error' : '' }}}">
                {{ Form::label('titulo', 'Título', array('class' => 'control-label')) }}
                {{ Form::text('titulo', null, array('class' => 'form-control')) }}
                {{ $errors->first('titulo', '<span class="help-block">:message</span>') }}
            </div>
            <div class="form-group {{{ $errors->has('descripcion') ? 'has-error' : '' }}}">
                {{ Form::label('descripcion', 'Descripción', array('class' => 'control-label')) }}
                {{ Form::text('descripcion', null, array('class' => 'form-control')) }}
                {{ $errors->first('descripcion', '<span class="help-block">:message</span>') }}
            </div>
            <div class="form-group">
                {{ Ubicacion::first()->iframe }}
            </div>
            <!--<div class="form-group {{{ $errors->has('iframe') ? 'has-error' : '' }}}">
                {{ Form::label('iframe', 'Iframe', array('class' => 'control-label')) }}
                {{ Form::text('iframe', null, array('class' => 'form-control')) }}
                {{ $errors->first('iframe', '<span class="help-block">:message</span>') }}
            </div>-->
            <div class="form-group {{{ $errors->has('iframe') ? 'has-error' : '' }}}">
                {{ Form::label('iframe', 'Iframe', array('class' => 'control-label')) }}
                {{ Form::textarea('iframe', null, array('class' => 'form-control')) }}
                {{ $errors->first('iframe', '<span class="help-block">:message</span>') }}
            </div>
            <div class="form-group">
                {{ Form::submit('Crear / Remplazar', array('class' =>  'btn btn-info', 'style' => 'width:20%; float: right;')) }}
            </div>
        </div>
    </div>
    {{ Form::close() }}
@stop

{{-- Scripts --}}
@section('scripts')

@stop