@extends('admin.layouts.modal2')

{{-- Content --}}
@section('content')
	<div id="main-page-content" class="section-container main-page-content clearfix">

		<div class="section-content clearfix">
        <table id="eventos" class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="col-md-3">{{{ Lang::get('admin/eventos/table.title') }}}</th>
                <th class="col-md-5">Contenido</th>
				<th class="col-md-2">{{{ Lang::get('admin/eventos/table.start_date') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/eventos/table.finish_date') }}}</th>
				
			</tr>
		</thead>
		<tbody>
        <tr>
         @foreach($eventos as $evento)
         
                <td>{{$evento->titulo}}</td>
    						
    			<td>{{$evento->contenido}}</td>
    			
    			<td>{{date("d-m-Y",strtotime($evento->fecha_inicio))}}</td>
    			
    			<td>{{date("d-m-Y",strtotime($evento->fecha_fin))}}</td>
            @endforeach
       </tr>
		</tbody>
	   </table>
           
		</div>
	</div>




@stop

