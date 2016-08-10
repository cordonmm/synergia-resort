@extends('site.layouts.default')

@section('title')
    Apartamento en Sevilla | Synergia Resort
    @parent

@stop

@section('content')



    <!-- Carousel | START -->
    <div class="section carousel horizontal fade">
        <div class="slider">

            <img src="{{asset('template/system/images/apartamento/apartamento-sevilla-25.jpg')}}" alt="">
            <img src="{{asset('template/system/images/apartamento/apartamento-sevilla-26.jpg')}}" alt="">
            <img src="{{asset('template/system/images/apartamento/apartamento-sevilla-28.jpg')}}" alt="">
            <img src="{{asset('template/system/images/apartamento/apartamento-sevilla-29.jpg')}}" alt="">

        </div>

        <div class="slider-nav" style="padding: 1px 1.5px 1.5px 1px; background-color: #869791; opacity: 1">
            <a class="prev"><i class="icon ion-ios-arrow-left"></i></a>
            <a class="next"><i class="icon ion-ios-arrow-right"></i></a>
        </div>
    </div>
    <!-- Carousel | END -->





    <!-- Booking Bar | END -->

    <!-- ******************** Header | END ******************** -->

    <!-- ******************** Main | START ******************** -->

    <main>

        <!-- Text Block | START -->
        <div class="section text feature fade">
            <div class="center">

                <div class="col-1">
                    <h2>Aparcamientos cercanos</h2>
                </div>

            </div>
        </div>
        <!-- Text Block | END -->

        <!-- Text Block | START -->
        <div class="section text feature fade">
            <div class="center">

                <div class="col-1">
                    <ul>
                        <li><b>Aparcamientos Magdalena</b>: C/ San Pablo, 1</li>
                        <li><b>Plaza Nueva</b>: C/ Albareda, 18 (24h)</li>
                        <li><b>Arenal</b>: C/ Genil (24h)</li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- Text Block | END -->


        <!-- Map | START -->
        <div class="section map fade" style="max-height: 350px;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1585.0465324631402!2d-5.994128241766475!3d37.38763132609658!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd126c1a6930ad2b%3A0x266e0e156da8dee6!2sCalle+Conteros%2C+2%2C+41004+Sevilla!5e0!3m2!1ses!2ses!4v1467709762934" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
        <!-- Map | END -->

    </main>

@stop

@section('scripts')

@stop






