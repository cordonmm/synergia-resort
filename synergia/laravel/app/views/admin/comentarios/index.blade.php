@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
    Comentarios :: @parent
@stop

@section('keywords')Entrys administration @stop
@section('author')Laravel 4 Bootstrap Starter SIte @stop
@section('description')Entrys administration index @stop
@section('styles')
    <style rel="stylesheet">
        /*#comentarios tbody tr td:nth-child(3){
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 100px;*/
        }
    </style>
@stop
{{-- Content --}}
@section('content')
    <form action="{{ URL::to('admin/comentarios/publicar') }}" method="post">
    {{ Form::token() }}
    <div class="page-header">
        <h3>
            Comentarios
            <button name="publicar" id="publicar" class="btn btn-small btn-info pull-right"><span class="glyphicon glyphicon-plus-sign"></span> Publicar / Despublicar</button>
        </h3>
    </div>


        <table id="comentarios" class="table table-striped table-hover">
            <thead>
            <tr>
                <th class="col-md-2">Nombre</th>
                <th class="col-md-2">Email</th>
                <th class="col-md-4">Comentario</th>
                <th class="col-md-2">Publicado</th>
                <th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </form>
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
                    $(".iframe").colorbox({iframe:true, width:"80%", height:"80%",
                        onLoad: function(){
                            $('#cboxClose').remove();
                        }});
                }
            });
        });
    </script>
@stop