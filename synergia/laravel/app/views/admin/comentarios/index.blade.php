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
    <div class="page-header">
        <h3>
            Comentarios
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

    <div id="message_comentarios">

    </div>
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
                "fnDrawCallback": function ( oSettings ){
                    $(".iframe").colorbox({iframe:true, width:"80%", height:"80%",
                        onLoad: function(){
                            $('#cboxClose').remove();
                        }});
                    $("input[type=checkbox]").change(publicar);
                }
            });

            //Publicaciones vía AJAX



        });

        function publicar(){

            var iPublicado = 0;
            var sCadena = 'despublicado';

            if($(this).prop('checked')){
                sCadena = 'publicado';
                iPublicado = 1;
            }

            var jqAjax = $.ajax({
                            url: '{{ URL::to('admin/comentarios/publicar') }}',
                            type: 'GET',
                            async: true,
                            data: 'comentario='+$(this).val()+'&publicado='+iPublicado,
                            dataType: 'json'
                        }).always(function(){
                            if(jqAjax.responseText == 'success'){
                                $('#message_comentarios').prepend(
                                        $('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button> <strong>¡Hecho!</strong> El comentario fue <strong>'+sCadena+'</strong> satisfactoriamente. </div>')
                                );
                            }
                            else if(jqAjax.responseText == 'error'){
                                $('#message_comentarios').prepend(
                                        $('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button> <strong>¡Error!</strong> El comentario no existe. </div>')
                                );
                            }
                            else{
                                $('#message_comentarios').prepend(
                                        $('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button> <strong>¡Error!</strong> Ha sucedido un error inesperado. </div>')
                                );
                            }
                        });
        }

    </script>
@stop