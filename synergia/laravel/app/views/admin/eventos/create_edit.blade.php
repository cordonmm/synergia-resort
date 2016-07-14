@extends('admin.layouts.modal')

{{-- content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	{{-- Edit entrada Form --}}
	<form class="form-horizontal" method="post" action="@if (isset($evento)){{ URL::to('admin/eventos/' . $evento->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs contenido -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- entrada titulo -->
				<div class="form-group {{{ $errors->has('titulo') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="titulo">Titulo</label>
						<input class="form-control" type="text" name="titulo" id="titulo" value="{{{ Input::old('titulo', isset($evento) ? $evento->titulo : null) }}}" />
						{{ $errors->first('titulo', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ entrada titulo -->



				<!-- contenido -->
				<div class="form-group {{{ $errors->has('contenido') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="contenido">Contenido</label>
						<textarea class="form-control full-width ckeditor" name="contenido" value="contenido" rows="10">{{{ Input::old('contenido', isset($evento) ? $evento->contenido : null) }}}</textarea>
						{{ $errors->first('contenido', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ contenido -->
				<div class="form-group {{{ $errors->has('fechaInicio') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="fechaInicio">Fecha Inicio</label>
						<input class="form-control-static" type="text" id="fechaInicio" name="fechaInicio" value="{{{ Input::old('fechaFin', isset($evento) ? $evento->fecha_inicio : null) }}}">
						{{ $errors->first('fechaInicio', '<span class="help-block">:message</span>') }}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('fechaFin') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="fechaFin">Fecha Fin</label>
						<input class="form-control-static" type="text" id="fechaFin"  name="fechaFin" value="{{{ Input::old('fechaFin', isset($evento) ? $evento->fecha_fin : null) }}}">
						{{ $errors->first('fechaFin', '<span class="help-block">:message</span>') }}
					</div>
				</div>

			</div>
			<!-- ./ general tab -->
		
			
		</div>
		<!-- ./ tabs contenido -->

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<button class="btn btn-danger"><element class="btn-cancel close_popup">Cancelar</element></button>
				<button type="reset" class="btn btn-default">Limpiar</button>
				<button type="submit" class="btn btn-success">Actualizar</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>

	</div>
@stop
@section('styles')
<!-- 1 -->
<link href="{{asset('assets/css/dropzone.css')}}" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

@stop
{{-- Scripts --}}
@section('scripts')
	<script src="{{ asset('/template/plugins/ckeditor/ckeditor.js') }}"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type="text/javascript">
 	$('#fechaInicio').datepicker({
		dateFormat: 'yy-mm-dd',

	});
	$('#fechaFin').datepicker({
		dateFormat: 'yy-mm-dd',

	});

	
	</script>
@stop
