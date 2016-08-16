@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
    Configuraciones :: @parent
@stop

@section('keywords')Entrys administration @stop
@section('author')Laravel 4 Bootstrap Starter SIte @stop
@section('description')Entrys administration index @stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h3>
            Tarifas

            <div class="pull-right">
                <a href="{{{ URL::to('admin/tarifas/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Nueva tarifa</a>
            </div>
        </h3>
    </div>

    <table id="configuraciones" class="table table-striped table-hover">
        <thead>
        <tr>
            <th class="col-md-2">Alias</th>
            <th class="col-md-2">F.&nbsp;inicio</th>
            <th class="col-md-2">F.&nbsp;fin</th>
            <th class="col-md-1">Tarifa&nbsp;mín.</th>
            <th class="col-md-1">Noche</th>
            <th class="col-md-1">Semana</th>
            <th class="col-md-1">Noches&nbsp;mín.</th>
            <th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript">
        var oTable;
        $(document).ready(function() {
            oTable = $('#configuraciones').dataTable( {
                "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ registros por página"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "{{ URL::to('admin/tarifas/data') }}",
                "fnDrawCallback": function ( oSettings ) {
                    $(".iframe").colorbox({iframe:true, width:"80%", height:"80%",
                        onLoad: function(){
                            $('#cboxClose').remove();
                        }});
                },
                "fnInitComplete": function () {
                    $('.out-of-date').parent().parent().css({color : 'red'});
                }
            });
        });
    </script>
@stop