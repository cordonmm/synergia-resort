@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
    Reservas :: @parent
@stop

@section('keywords')Entrys administration @stop
@section('author')Laravel 4 Bootstrap Starter SIte @stop
@section('description')Entrys administration index @stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h3>
            Reservas

            <div class="pull-right">
                <a href="{{{ URL::to('admin/reservas/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Nueva reserva</a>
            </div>
        </h3>
    </div>

    <table id="reservas" class="table table-striped table-hover">
        <thead>
        <tr>

            <th class="fit">Llegada</th>
            <th class="fit">Salida</th>
            <th class="fit">Teléfono</th>
            <th class="fit">Email</th>
            <th class="fit">Nombre</th>
            <th class="fit">Pagado</th>
            <th class="fit">{{{ Lang::get('table.actions') }}}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@stop

@section('styles')
    <style>
    .table td.fit,
    .table th.fit {
    white-space: nowrap;
    width: 1%;
    }
    </style>
@stop
{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript">
        var oTable;
        $(document).ready(function() {
            oTable = $('#reservas').dataTable( {
                "autoWidth": true,
                "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ registros por página"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "{{ URL::to('admin/reservas/data') }}",
                "fnDrawCallback": function ( oSettings ) {
                    $(".iframe").colorbox({iframe:true, width:"80%", height:"80%",
                        onLoad: function(){
                            $('#cboxClose').remove();
                        }});
                }
            });
        });

    </script>
    <script>
        window.addEventListener('load', function(){
            $('tr').addClass('fit');
            $('td').addClass('fit');
            $('table').addClass('fit');
        }, false);

    </script>
@stop