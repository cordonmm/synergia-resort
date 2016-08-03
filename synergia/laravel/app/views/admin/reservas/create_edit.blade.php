@extends('admin.layouts.modal'){{-- content --}}@section('content')	<!-- Tabs -->		<ul class="nav nav-tabs">			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>		</ul>	<!-- ./ tabs -->    @if(isset($reserva))        {{ Form::model($reserva, array('action' => array('AdminReservasController@update', $reserva->id), 'method' => 'put', 'class' => 'form-horizontal')) }}    @else        {{ Form::open(array('action' => 'AdminReservasController@store', 'method' => 'post', 'class' => 'form-horizontal')) }}    @endif    <div class="tab-content">        <!-- General tab -->        <div class="tab-pane active" id="tab-general">            <!-- reserva fecha inicio -->            <div class="form-group {{{ $errors->has('fecha_ini') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('fecha_ini', 'Fecha Inicio', array('class' => 'control-label')) }}                    {{ Form::text('fecha_ini', null, array('class' => 'form-control')) }}                    {{ $errors->first('fecha_ini', '<span class="help-block">:message</span>') }}                </div>            </div>            <!-- ./ reserva fecha inicio -->            <!-- reserva fecha final -->            <div class="form-group {{{ $errors->has('fecha_fin') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('fecha_fin', 'Fecha Final', array('class' => 'control-label')) }}                    {{ Form::text('fecha_fin', null, array('class' => 'form-control')) }}                    {{ $errors->first('fecha_fin', '<span class="help-block">:message</span>') }}                </div>            </div>            <!-- ./ reserva fecha final -->            <!-- reserva nombre -->            <div class="form-group {{{ $errors->has('nombre') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('nombre', 'Nombre', array('class' => 'control-label')) }}                    {{ Form::text('nombre', null, array('class' => 'form-control')) }}                    {{ $errors->first('nombre', '<span class="help-block">:message</span>') }}                </div>            </div>            <!-- ./ reserva nombre -->            <!-- reserva email -->            <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('email', 'Email', array('class' => 'control-label')) }}                    {{ Form::text('email', null, array('class' => 'form-control')) }}                    {{ $errors->first('email', '<span class="help-block">:message</span>') }}                </div>            </div>            <!-- ./ reserva email -->            <!-- reserva telefono -->            <div class="form-group {{{ $errors->has('telefono') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('telefono', 'Teléfono', array('class' => 'control-label')) }}                    {{ Form::text('telefono', null, array('class' => 'form-control')) }}                    {{ $errors->first('telefono', '<span class="help-block">:message</span>') }}                </div>            </div>            <!-- reserva dni -->            <div class="form-group {{{ $errors->has('dni') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('dni', 'DNI o Pasaporte', array('class' => 'control-label')) }}                    {{ Form::text('dni', null, array('class' => 'form-control')) }}                    {{ $errors->first('dni', '<span class="help-block">:message</span>') }}                </div>            </div>            <!-- ./ reserva dni -->            <div class="form-group {{{ $errors->has('fecha_nacimiento') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('fecha_nacimiento', 'Fecha de nacimiento', array('class' => 'control-label')) }}                    {{ Form::text('fecha_nacimiento', null, array('class' => 'form-control')) }}                    {{ $errors->first('fecha_nacimiento', '<span class="help-block">:message</span>') }}                </div>            </div>            <div class="form-group {{{ $errors->has('pais_nacionalidad') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('pais_nacionalidad', 'País', array('class' => 'control-label')) }}                    {{ Form::text('pais_nacionalidad', null, array('class' => 'form-control')) }}                    {{ $errors->first('pais_nacionalidad', '<span class="help-block">:message</span>') }}                </div>            </div>            <div class="form-group {{{ $errors->has('fecha_expedicion') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('fecha_expedicion', 'Fecha de expedición', array('class' => 'control-label')) }}                    {{ Form::text('fecha_expedicion', null, array('class' => 'form-control')) }}                    {{ $errors->first('fecha_expedicion', '<span class="help-block">:message</span>') }}                </div>            </div>            <div class="form-group {{{ $errors->has('adultos') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('adultos', 'Adultos', array('class' => 'control-label')) }}                    {{ Form::select('adultos',                        array(  '1' =>      '1',                                '2' =>      '2',                                '3'  =>     '3',                                '4'  =>     '4',                                '5'  =>     '5',                                '6'  =>     '6',                                '7'  =>     '7',                                '8'  =>     '8'                        ), null, array('class' => 'form-control'));                    }}                    {{ $errors->first('adultos', '<span class="help-block">:message</span>') }}                </div>            </div>            <div class="form-group {{{ $errors->has('ninos') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('ninos', 'Niños', array('class' => 'control-label')) }}                    {{ Form::select('ninos',                        array(  '0' =>      '0',                                '1' =>      '1',                                '2'  =>     '2',                                '3'  =>     '3',                                '4'  =>     '4'                        ), null, array('class' => 'form-control'));                    }}                    {{ $errors->first('ninos', '<span class="help-block">:message</span>') }}                </div>            </div>            <!--<div class="form-group {{{ $errors->has('precio') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('precio', 'Precio', array('class' => 'control-label')) }}                    {{ Form::text('precio', null, array('class' => 'form-control')) }}                    {{ $errors->first('precio', '<span class="help-block">:message</span>') }}                </div>            </div>-->            <div class="form-group {{{ $errors->has('observaciones') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('observaciones', 'Observaciones', array('class' => 'control-label')) }}                    {{ Form::text('observaciones', null, array('class' => 'form-control')) }}                    {{ $errors->first('observaciones', '<span class="help-block">:message</span>') }}                </div>            </div>            <!-- ./ groups -->        </div>        <!-- ./ general tab -->    </div>    <!-- ./ tabs contenido -->    <!-- Form Actions -->    <div class="form-group">        <div class="col-md-12">            <button type="reset" class="btn btn-default">Limpiar</button>            <button type="submit" class="btn btn-success">{{ $text_button_submit }}</button>        </div>    </div>    {{ Form::close() }}@stop@section('styles')<!-- 1 --><link href="{{asset('assets/css/dropzone.css')}}" type="text/css" rel="stylesheet" /><link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">@stop{{-- Scripts --}}@section('scripts')	<script src="{{ asset('/template/plugins/ckeditor/ckeditor.js') }}"></script>    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>@stop