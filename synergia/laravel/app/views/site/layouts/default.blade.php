<!DOCTYPE html><html><head>    <meta charset="utf-8"/>    <meta name="viewport" content="width=device-width, initial-scale=1"/>    	@yield('metas')    @yield('styles')    <link rel="stylesheet" href="{{asset('template/system/style.css')}}"/>    <link rel="stylesheet" href="{{asset('template/system/custom.css')}}"/>    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>    <link rel="shortcut icon" href="{{ asset('template/favicon/favicon.ico') }}">    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('template/favicon/apple-touch-icon.png') }}">    <link rel="icon" type="image/png" href="{{ asset('template/favicon/apple-touch-icon.png/favicon-32x32.png') }}" sizes="32x32">    <link rel="icon" type="image/png" href="{{ asset('template/favicon/apple-touch-icon.png/favicon-16x16.png') }}" sizes="16x16">    <link rel="manifest" href="{{ asset('template/favicon/apple-touch-icon.png/manifest.json') }}">    <link rel="mask-icon" href="{{ asset('template/favicon/apple-touch-icon.png/safari-pinned-tab.svg') }}" color="#5bbad5">    <meta name="theme-color" content="#ffffff">    <title>        @yield('title')    </title>    <!--<meta name="description" content=""/>    <meta name="keywords" content=""/>--></head><body><div class="container">    <!-- ******************** Header | START ******************** -->    <!-- Navigation | START -->    <header>        <div class="center">            <!--<a class="logo" href="Inicio"><img src="{{asset('template/system/images/synergia.png')}}" alt=""></a>-->            <nav>                <ul>                    <li class="nav-book"><a href="Reservar">Reservar</a></li>                    <li><a href="{{ URL::to('/') }}">Inicio</a></li>                    <li><a href="{{ URL::to('Reservar') }}">Reservar</a></li>                    <li class="drop"><a href="{{ URL::to('Equipamiento') }}">Equipamiento</a></li>                    <li><a href="{{ URL::to('Ubicacion') }}">Ubicación</a></li>                    <li><a href="{{ URL::to('Galeria') }}">Galería</a></li>                    <li><a href="{{ URL::to('Libro-visitas') }}">Libro de visitas</a>                    <li><a href="{{ URL::to('Contacto') }}">Contacto</a>                        <!--<ul>                            <li><a href="contact.php">Booking Request</a></li>                            <li><a href="contact-no-booking.php">Make an Enquiry</a></li>                        </ul>-->                    </li>                </ul>            </nav>            <div id="mobilenav"><i class="icon ion-navicon"></i></div>            <a class="button book-button" href="Reservar">Reservar</a>        </div>    </header>    <!-- Navigation | END --><!-- Contenido Estático Template -->@yield('content')<!-- Javascript Files Template-->    <!-- ******************** Footer | START ******************** -->    <footer class="fade">        <div class="col-3">            <i class="icon ion-ios-location-outline"></i>            <h4>Synergia Resort</h4>            <div class="stars">                <i class="icon ion-android-star"></i>                <i class="icon ion-android-star"></i>                <i class="icon ion-android-star"></i>                <i class="icon ion-android-star"></i>                <i class="icon ion-android-star"></i>            </div>            <p>Calle Conteros, 2<br>                41004 Sevilla<br>                <strong>+34 616 13 84 91</strong></p>        </div>        <div class="footer-nav">            <ul class="footer-links">                <li class="hide">Copyright &copy; <script type="text/javascript">var d = new Date(); document.write(d.getFullYear());</script></li>                <li><a href="Aviso-legal">Aviso legal</a></li>                <li>                    <a target="_blank" href="http://www.10code.es">Developed by 10Code Desarrollo Software</a>                </li>            </ul>        </div>    </footer>    <!-- ******************** Footer | END ******************** --></div><script type="text/javascript" src="{{asset('template/system/plugins.js')}}"></script><!--<script type="text/javascript" src="{{asset('template/system/i18n/datepicker-es.js')}}"></script>--><script type="text/javascript">    var RESERVA_URL = '{{ URL::to('/Reservar')}}';</script><script type="text/javascript" src="{{asset('template/system/script.js')}}"></script>@yield('scripts')</body></html>