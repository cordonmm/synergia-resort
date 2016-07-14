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
                <a href="Inicio"><img src="{{asset('template/images/logo-gota.png')}}" alt="logo"></a>
                <p class="white">Agencia de publicidad Sevilla | GOTA &amp; CLAIM</p>
            </div>
            <!-- /LOGO -->

            <a id="hamburger" class="white" href="#menu"></a>
        </div>
        <!-- /HEADER -->

        <!-- HEAD SECTION -->
        <section class="js-height-home" style="height: 484px;">
            <div class="home border">
                <div class="home-parallax-image bg mask-dark op7 parallax" data-background="{{asset('template/images/agencia-publicidad-sevilla-4.jpg')}}" style="background-image: url(&quot;images/agencia-publicidad-sevilla-4.jpg&quot;); background-attachment: fixed; background-position: 50% -24px;">

                    <div class="head">
                        <div class="col-sm-6 col-xs-10 col-xs-offset-1">
                            <h1 class="hs-title os-animation animated fadeInDown" data-os-animation="fadeInDown" data-os-animation-delay="1s" style="animation-delay: 1s;">Nuestras tarifas</h1>
                            <div class="hs-subtitle os-animation animated fadeInUp" data-os-animation="fadeInUp" data-os-animation-delay="1s" style="animation-delay: 1s;">
                                Un líquido es un estado de la materia sin una forma particular. Cambia fácilmente y sólo queda definido por el recipiente que lo contiene. Somos un 70% agua, nos adaptamos a TI.
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /home-parallax-image -->

            </div>
            <!-- /home-->

        </section>
        <!-- /HEAD SECTION -->


        <div id="wrapper" class="mm-page mm-slideout">


            <!-- Page Loader -->

            <!-- /Page Loader -->


            <!-- HEADER -->

            <!-- /HEADER -->




        </div>

        <!-- PRICING TABLES 4 COLUMNS SECTION -->
        <section class="section">
            <div class="container">
                <div class="row os-animation" data-os-animation="fadeIn" data-os-animation-delay="0s">

                    <div class="col-sm-6 col-md-3">
                        <div class="pricing mb-md-60">
                            <div class="plan">
                                <h3>Gota</h3>
                                <h4><span class="currency">€</span>200<span class="period"> /mes</span></h4>
                                <p class="mb0"><em>Precio espcial<br>por 3 meses.</em></p>
                            </div>
                            <div class="features">
                                <ul>
                                    <li>Alta y gestión 2 RRSS</li>
                                    <li>2 publicaciones semanales por red</li>
                                    <li>Publicaciones diarias en Twitter</li>
                                    <li>Informe mensual de resultados</li>
                                    <li>Respuesta y seguimiento comentarios de seguidores</li>
                                    <li><span style="color: #e5e5e3;">Agencia <br>publicidad sevilla</span></li>
                                    <li><span style="color: white;">Agencia <br>publicidad sevilla</span></li>
                                    <li><a href="#" class="btn btn-main btn-round" role="button">+ info</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="pricing mb-md-60">
                            <div class="plan distinction">
                                <h3 class="darkgray">Lluvia</h3>
                                <h4><span class="currency">€</span>300<span class="period"> /mes</span></h4>
                                <p class="mb0"><em>Precio espcial<br>por 3 meses.</em></p>
                            </div>
                            <div class="features">
                                <ul>
                                    <li>Alta y gestión 3 RRSS</li>
                                    <li>3 publicaciones semanales por red</li>
                                    <li>Publicaciones diarias en Twitter</li>
                                    <li>2 diseños mensuales promocionales</li>
                                    <li>Informe mensual de resultados</li>
                                    <li>Respuesta y seguimiento comentarios de seguidores</li>
                                    <li><span style="color: white;">Agencia <br>publicidad sevilla</span></li>
                                    <li><a href="#" class="btn btn-main btn-round" role="button">+ info</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="pricing mb-sm-60">
                            <div class="plan">
                                <h3>Tormenta</h3>
                                <h4><span class="currency">€</span>500<span class="period"> /mes</span></h4>
                                <p class="mb0"><em>Precio espcial<br>por 3 meses.</em></p>
                            </div>
                            <div class="features">
                                <ul>
                                    <li>Alta y gestión 3 RRSS</li>
                                    <li>4 publicaciones semanales por red</li>
                                    <li>Publicaciones diarias en Twitter, de 3 a 4</li>
                                    <li>3 diseños mensuales promocionales</li>
                                    <li>Informe mensual de resultados</li>
                                    <li>Respuesta y seguimiento comentarios de seguidores</li>
                                    <li>Adaptaciones de imágenes de marca</li>
                                    <li><a href="#" class="btn btn-main btn-round" role="button">+ info</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="pricing">
                            <div class="plan">
                                <h3>Monzón</h3>
                                <h4><span class="currency">€</span>700<span class="period"> /mes</span></h4>
                                <p class="mb0"><em>Precio espcial<br>por 3 meses.</em></p>
                            </div>
                            <div class="features">
                                <ul>
                                    <li>Alta y gestión 4 RRSS</li>
                                    <li>5 publicaciones semanales por red</li>
                                    <li>Publicaciones diarias en Twitter, de 3 a 4</li>
                                    <li>4 diseños mensuales promocionales</li>
                                    <li>Informe mensual de resultados</li>
                                    <li>Respuesta y seguimiento comentarios de seguidores</li>
                                    <li>Adaptaciones de imágenes de marca</li>
                                    <li><a href="#" class="btn btn-main btn-round" role="button">+ info</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- /PRICING TABLES 4 COLUMNS SECTION -->


        <!-- CALL ACTION SECTION -->
        <section class="section section-dark">

            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 pt60 pb60">

                    </div>
                </div>
            </div>

        </section>
        <!-- /CALL ACTION SECTION -->

@stop