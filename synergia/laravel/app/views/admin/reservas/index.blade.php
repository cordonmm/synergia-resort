@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ $data['title'] }}} :: @parent
@stop

@section('keywords')Entrys administration @stop
@section('author')Laravel 4 Bootstrap Starter SIte @stop
@section('description')Entrys administration index @stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h3>
            {{{ $data['title'] }}}

            <div class="pull-right">
                <a href="{{{ URL::to('') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Nueva reserva</a>
            </div>
        </h3>
    </div>

    <table id="entradas" class="table table-striped table-hover">
        <thead>
        <tr>
            <th class="col-md-2">fecha_ini</th>
            <th class="col-md-2">fecha_fin</th>
            <th class="col-md-2">teléfono</th>
            <th class="col-md-2">email</th>
            <th class="col-md-2">nombre</th>
            <th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
        </tr>
        </thead>
        <tbody>
            @if(count($data['reservas']) > 0)
                @foreach($data['reservas'] as $reserva)
                    <tr>
                        <td class="col-md-2">{{$reserva->fecha_ini}}</td>
                        <td class="col-md-2">{{$reserva->fecha_fin}}</td>
                        <td class="col-md-2">{{$reserva->telefono}}</td>
                        <td class="col-md-2">{{$reserva->email}}</td>
                        <td class="col-md-2">{{$reserva->nombre}}</td>
                        <td class="col-md-2"><a href="{{URL::to('admin/reservas/'.$reserva->id.'/edit')}}" class="btn btn-xs btn-default">Editar</a> <a href="#" class="btn btn-xs btn-danger">Borrar</a></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th class="col-md-12">
                        No se encontraron registros.
                    </th>
                </tr>
            @endif
        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')
    <!--<script type="text/javascript">
        var oTable;
        $(document).ready(function() {
            oTable = $('#entradas').dataTable( {
                "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ registros por página"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "{{ URL::to('admin/entradas/data') }}",
                "fnDrawCallback": function ( oSettings ) {
                    $(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
                }
            });
        });
    </script>-->
@stop