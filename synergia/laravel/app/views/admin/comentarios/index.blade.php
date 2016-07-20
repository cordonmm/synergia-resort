@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
    Comentarios :: @parent
@stop

@section('keywords')Entrys administration @stop
@section('author')Laravel 4 Bootstrap Starter SIte @stop
@section('description')Entrys administration index @stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h3>
            Comentarios

            <div class="pull-right">
                <a href="{{{ URL::to('admin/comentarios/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Comentario</a>
            </div>
        </h3>
    </div>

    <table id="comentarios" class="table table-striped table-hover">
        <thead>
        <tr>
            <th class="col-md-2">Nombre</th>
            <th class="col-md-2">Email</th>
            <th class="col-md-2">Comentario</th>
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
            oTable = $('#comentarios').dataTable( {
                "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ registros por página"
                },
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "{{ URL::to('admin/comentarios/data') }}",
                "fnDrawCallback": function ( oSettings ) {
                    $(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
                }
            });
        });
    </script>
@stop