@extends('admin.layouts.modal2')

{{-- Content --}}
@section('content')
	<div id="main-page-content" class="section-container main-page-content clearfix">

		<div class="section-content clearfix">

			<h1 class="page_title">{{$evento->titulo}}</h1>			
			<h3>{{$evento->contenido}}</h3>
			<h3>{{{ Lang::get('admin/eventos/table.start_date') }}}</h3>
			<p>{{$evento->fecha_inicio}}</p>
			<h3>{{{ Lang::get('admin/eventos/table.finish_date') }}}</h3>
			<p>{{$evento->fecha_fin}}</p>
		</div>
	</div>




@stop

