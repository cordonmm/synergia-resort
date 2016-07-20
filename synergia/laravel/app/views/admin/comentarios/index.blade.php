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
            @foreach($comentarios as $comentario)
                <tr>
                    <td class="col-md-2">{{ $comentario->nombre }}</td>
                    <td class="col-md-2">{{ $comentario->email }}</td>
                    <td class="col-md-4">{{ substr($comentario->texto, 0, 20) }}...</td>
                    <td class="col-md-2">{{ $comentario->publicado }}</td>
                    <td class="col-md-2">
                        <a href="{{{ URL::to('admin/comentarios/' . $comentario->id   ) }}}" class="btn btn-default btn-xs iframe" >Ver</a>
                        <a href="{{{ URL::to('admin/comentarios/' . $comentario->id . '/delete' ) }}}" class="btn btn-xs btn-danger iframe">Borrar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $(".iframe").colorbox({
                iframe:true,
                width:"80%",
                height:"80%",
                onLoad: function(){
                    $('#cboxClose').remove();
                }
            });
        });
    </script>
@stop