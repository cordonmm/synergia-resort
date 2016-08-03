@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')

    <!-- Tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
        </ul>
    <!-- ./ tabs -->
    {{-- Delete Post Form --}}

    {{ Form::open(array('action' => array('AdminConfiguracionesController@destroy', $configuracion->id), 'method' => 'delete', 'id' => 'deleteForm')) }}
        <div class="form-group">
            <div class="controls">
                Va a proceder a borrar definitivamente la tarifa, ¿está seguro?
                <button type="submit" class="btn btn-danger">Borrar</button>
            </div>
        </div>
    {{ Form::close() }}




@stop