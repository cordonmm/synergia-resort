@extends('admin.layouts.modal'){{-- content --}}@section('content')	<!-- Tabs -->		<ul class="nav nav-tabs">			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>		</ul>	<!-- ./ tabs -->	{{-- Edit entrada Form --}}	<form class="form-horizontal" method="post" action="@if (isset($tutoria)){{ URL::to('admin/tutorias/' . $tutoria->id . '/edit') }}@endif" autocomplete="off">		<!-- CSRF Token -->		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />		<!-- ./ csrf token -->		<!-- Tabs contenido -->		<div class="tab-content">			<!-- General tab -->			<div class="tab-pane active" id="tab-general">				<!-- Tutoria clase -->				<div class="form-group {{{ $errors->has('clase') ? 'error' : '' }}}">                    <div class="col-md-12">                        <label class="control-label" for="clase">Clase</label>						<input class="form-control" type="text" name="clase" id="clase" value="{{{ Input::old('clase', isset($tutoria) ? $tutoria->clase : null) }}}" />						{{ $errors->first('clase', '<span class="help-block">:message</span>') }}					</div>				</div>				<!-- ./ Tutoria clase -->                <!-- Tutoria email -->                <div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">                    <div class="col-md-12">                        <label class="control-label" for="email">Email</label>                        <input class="form-control" type="text" name="email" id="email" value="{{{ Input::old('email', isset($tutoria) ? $tutoria->email : null) }}}" />                        {{ $errors->first('email', '<span class="help-block">:message</span>') }}                    </div>                </div>                <!-- ./ Tutoria clase -->			</div>			<!-- ./ general tab -->		</div>		<!-- ./ tabs content -->		<!-- Form Actions -->		<div class="form-group">			<div class="col-md-12">				<button class="btn btn-danger"><element class="btn-cancel close_popup">Cancelar</element></button>				<button type="reset" class="btn btn-default">Limpiar</button>				<button type="submit" class="btn btn-success">Actualizar</button>			</div>		</div>		<!-- ./ form actions -->	</form>	</div>@stop@section('styles')<!-- 1 --><link href="{{asset('assets/css/dropzone.css')}}" type="text/css" rel="stylesheet" /><link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">@stop{{-- Scripts --}}@section('scripts')	<script src="{{ asset('/template/plugins/ckeditor/ckeditor.js') }}"></script>	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>@stop