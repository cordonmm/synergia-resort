@extends('site.layouts.default')


@section('title')

    Agencia Publicidad Sevilla | Gota &amp; Claim

    @parent



@stop


@section('content')


    <div id="wrapper">


        <!-- Page Loader -->
        <div id="pageloader" class="Fixed">
            <div class="loader">
                <div class="bounce"></div>
            </div>
        </div>
        <!-- /Page Loader -->


        <!-- HEADER -->
        <div id="header" class="Fixed dark">

            <!-- LOGO -->
            <div id="logo">
                <a href="index.php"><img src="{{asset('template/images/logo-gota.png')}}" alt="logo"></a>
                <p class="white">Agencia de publicidad Sevilla | GOTA &amp; CLAIM</p>
            </div>
            <!-- /LOGO -->

            <a id="hamburger" class="white" href="#menu"></a>
        </div>
        <!-- /HEADER -->


        <!-- HEAD SECTION -->
        <section class="height-small">

            <div class="home bordertop">

                <div class="home-no-image">

                    <div class="head-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <h1 class="hs-title dark os-animation" data-os-animation="fadeInDown" data-os-animation-delay="1s">blog</h1>
                                    <!--<div class="hs-subtitle dark os-animation" data-os-animation="fadeInUp" data-os-animation-delay="1s">Noster ad voluptate an id iis dolore aute esse, occaecat sint fore doctrina duis do magna probant ad admodum, legam an vidisse, tamen fabulas ab sunt quorum, enim o occaecat.</div>-->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /home-no-image -->

            </div>
            <!-- /home-->

        </section>
        <!-- /HEAD SECTION -->


        {{--*/

               $entradas = Entrada::where('categoria','=','noticias')

               ->orderby('created_at','desc')

               ->paginate(9)

        /*--}}

        <!-- BLOG LIST SECTION -->
        <section class="section mt0">

            <div class="container">

                <div class="row">

                    <div class="blog-list clearfix">

                        @foreach($entradas as $entrada)
                            {{--*/ $enlace = $entrada->urls()->where('tipo','=','jpg')->orwhere('tipo','=','jpeg')->orwhere('tipo','=','png')->first() /*--}}
                            @if($enlace != null)
                                <figure class="item hover-effect-dark os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0s">
                                    <a href="{{URL::to('entradas/'.$entrada->id.'/details/')}}">
                                        <div class="item-img">
                                            <img src="{{asset('entradas/'.$enlace->url)}}" alt="">
                                        </div>
                                        <div class="mask">
                                            <h2>{{$entrada->titulo}}</h2>
                                            <div class="subtitle">{{date('d/m/Y',strtotime($entrada->created_at))}}</div>
                                        </div>
                                    </a>
                                </figure>
                            @endif
                        @endforeach


                    </div>

                </div>
            </div>

        </section>
        <!-- /BLOG LIST SECTION -->

        <!-- navigation -->
        <section class="section section-dark">
            <div class="blog-controls">
                <div class="blog-buttons">
                    <ul class="pagination no-margin">
                        {{$entradas->links()}}
                    </ul>
                </div>
            </div>
        </section>
        <!-- /navigation -->

@stop