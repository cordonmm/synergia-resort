@extends('site.layouts.default')@section('title')    Apartamento en Sevilla | Synergia Resort    @parent@stop@section('styles')    <style rel="stylesheet">        main{            width:      1000px;            margin:     auto;        }        .wrapper-comentario p{            margin-bottom:  3px !important;        }        .texto-comentario{            margin-bottom:  50px !important;            text-align:     justify;        }        .datos-comentario p{            text-align:     right;            font-style:     italic;        }        i.icon{            font-size:  1.5em;            display:    inline-block;            width:      32px;            text-align: center;        }        main{            margin-top: 50px;        }        footer{            margin-top: 50px;        }        .linea{            border:         1px solid #FFF;            border-bottom:  1px solid #EEE;            margin:         20px 70px 40px 70px;        }        .pagination{            display: table;            margin: auto;        }        h4{            margin-top: 60px;        }        a.comentar{            padding: 15px 50px;            font: 300 22px/30px 'Work Sans';            color: #555;            background: rgba(255,255,255,.85);            box-shadow: 0 0 1px rgba(0,0,0,.2),0 0 10px rgba(0,0,0,.1);            z-index: 1;            position: relative;            transition: .3s ease;            font-style: italic;            display: table;            float: right;        }        .f-left{            float:  left !important;        }        .width-60{            width: 60% !important;        }        .width-40{            width: 40% !important;        }        @media all and (max-width: 1000px){            main{                width:  90%;            }        }        @media all and (max-width: 767px){            .f-left{                float: none !important;            }            .width-60, .width-40{                width: 100% !important;            }            h2{                margin-bottom:  25px !important;            }            a.comentar{                display: block !important;            }        }    </style>@stop@section('content')    {{--*/                       $comentarios = Comentario::where('publicado','=','1')                           ->orderby('created_at','desc')                           ->paginate(7)                       /*--}}    <main>        <div class="section">            <div class="f-left width-60">                <h2 style="margin: 0;">Libro de Visitas. <strong>Synergia Resort</strong></h2>            </div>            <div class="f-left width-40">                <a class="comentar" href="{{ URL::to('Comentar') }}"><span style="vertical-align: middle;">Comenta</span>&nbsp;<i style="vertical-align: middle; margin-left: 10px;" class="icon ion-ios-bookmarks"></i></a>            </div>        </div>        <div class="ec-stars-wrapper" style="margin-top: 40px;">            {{--*/                $valoracion_media   =  DB::table('comentarios')                    ->where('publicado', '=', '1')                    ->whereNotNull('valoracion')                    ->avg('valoracion')            /*--}}            @for($i=1; $i<=round($valoracion_media); $i++)                <a style="font-size: 50px;" href="#" class="estrella-puntuada">&#9733;</a>            @endfor        </div>        <h4><strong>{{ Comentario::where('publicado', '1')->count() }}</strong> comentarios publicados.</h4>           @foreach($comentarios as $comentario)                <div class="wrapper-comentario">                    <div class="texto-comentario">                        {{ $comentario->texto }}                    </div>                    <div class="datos-comentario">                        <p>{{ $comentario->nombre }}&nbsp;<i class="icon ion-android-person"></i></p>                        <p>{{ date_format($comentario->created_at, 'd-m-Y H:i:s') }}&nbsp;<i class="icon ion-calendar"></i></p>                        <p class="ec-stars-wrapper" style="display: block; margin-top: 10px;">                        @if($comentario->valoracion !== null)                            @for($i=1; $i<=$comentario->valoracion; $i++)                                    <a href="#" class="estrella-puntuada">&#9733;</a>                            @endfor                        @endif                        </p>                    </div>                </div>               <div class="linea"></div>           @endforeach            <div>                {{$comentarios->links()}}            </div>    </main>@stop@section('scripts')    <script type="text/javascript">        window.addEventListener('load', function(){            $('.ec-stars-wrapper a').click(function(evento){                evento.preventDefault();            });        }, false);    </script>@stop