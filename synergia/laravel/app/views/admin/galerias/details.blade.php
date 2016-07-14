@extends('site.layouts.content')

{{-- Web site Title --}}

@section('title')

{{$entrada->titulo}}

@parent

@stop



{{-- Content --}}

@section('content')


    <!--=== Breadcrumbs ===-->
    <div class="breadcrumbs">
        <div class="container">
            <h1 class="pull-left">{{$entrada->titulo}}</h1>

        </div><!--/container-->
    </div><!--/breadcrumbs-->
    <!--=== End Breadcrumbs ===-->

    <!--=== Content Part ===-->
    <div class="blog_masonry_3col">
        <div class="container content grid-boxes">
            
                
                @foreach($entrada->urls as $enlace)
                    <div class="grid-boxes-in">
                        @if(Str::lower($enlace->tipo) == "jpg")
                            <a href="{{asset('entradas/'.$enlace->url)}}" rel="gallery1" class="fancybox img-hover-v1" title="{{$entrada->titulo}}">
                                <img class="img-responsive" src="{{asset('entradas/'.$enlace->url)}}" alt="{{$entrada->titulo}}">
                            </a>
                        @else
                            {{HTML::decode($enlace->url)}}
                        @endif
                    </div>
                @endforeach

                    
                
        </div><!--/container-->

    </div>
    <!--=== End Content Part ===-->
    
@stop

@section('scripts')
    <script type="text/javascript" src="{{{ asset('assets/js/pages/blog-masonry.js')}}}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            App.init();
        });
    </script>
    
    
    
    <script type="text/javascript" src="{{{ asset('assets/plugins/fancybox/source/jquery.fancybox.pack.js')}}}"></script>
    <script type="text/javascript" src="{{{ asset('assets/js/plugins/fancy-box.js')}}}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            App.init();
            FancyBox.initFancybox();
        });
    </script>
@stop