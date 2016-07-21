@extends('site.layouts.default')@section('title')    Apartamento en Sevilla | Synergia Resort    @parent@stop@section('content')    <!-- Photo Panel | START -->    <div class="section panel hero full fade">        <div class="slider">            <div class="item">                <div class="back" data-image="{{asset('template/system/images/apartamento-sevilla-3.jpg')}}"></div>                <div class="panel-button">                    <div class="button-container">                        <a href="location.html">Apartamento en pleno centro de <strong>Sevilla</strong></a>                        <span>Reserva ahora <i class="icon ion-ios-arrow-right"></i></span>                    </div>                </div>            </div>            <div class="item">                <div class="back" data-image="{{asset('template/system/images/apartamento-sevilla-2.jpg')}}"></div>                <div class="panel-button">                    <div class="button-container">                        <a href="packages.html">Terraza y vistas a <strong>Giralda y Catedral</strong></a>                        <span>Reserva ahora <i class="icon ion-ios-arrow-right"></i></span>                    </div>                </div>            </div>        </div>        <div class="slider-nav">            <a class="prev"><i class="icon ion-ios-arrow-left"></i></a>            <a class="next"><i class="icon ion-ios-arrow-right"></i></a>        </div>    </div>    <!-- Photo Panel | END -->    <!-- Booking Bar | START -->    <div id="book-bar"></div>    <div class="book-bar fade">        <div class="center">            <div class="date-field date-arrival">                <div class="date">                    <span class="tag">Llegada</span>                    <span class="arrival-day"></span>                    <span class="arrival-month"></span>                </div>            </div>            <div class="date-field date-departure">                <div class="date">                    <span class="tag">Salida</span>                    <span class="departure-day"></span>                    <span class="departure-month"></span>                </div>            </div>            <div class="date-field date-book">                <div class="date">                    <i class="icon ion-paper-airplane"></i>                </div>            </div>        </div>    </div>    <form action="contact.php" method="post" class="book-form">        <input name="arrival" type="hidden" class="arrival" />        <input name="departure" type="hidden" class="departure" />        <button></button>    </form>    <!-- Booking Bar | END -->    <!-- ******************** Header | END ******************** -->    <!-- ******************** Main | START ******************** -->    <!-- Notifications -->    @include('notifications')    <!-- ./ notifications -->    <main>        <!-- Text Block | START -->        <div class="section text feature fade">            <div class="center">                <div class="col-1">                    <h2>Apartamento en Sevilla. <strong>Synergia Resort</strong></h2>                </div>            </div>        </div>        <!-- Text Block | END -->        <!-- Text Block | START -->        <div class="section text fade">            <div class="center">                <div class="col-2">                    <p>                        Apartamento dúplex de 131 metros cuadrados situado en pleno corazón de Sevilla,ubicada en el antiguo Palacio Andaluz, a 50 metros de la Catedral.                        Totalmente amueblado con terraza privada de 18 metros cuadrados con una panorámica perfecta para disfrutar de unas impresionantes vistas de la                        Giralda y la Catedral. Este apartamento dispone de 3 dormitorios, uno de ellos es una buhardilla con dos sofás camas y con salida a la terraza.                        Amplio salón con sofá cama. Dos cuartos de baño y 2 cocinas totalmente equipadas, una de las cuales está ubicada en la buhardilla y la otra con                        todos los electrodomésticos necesarios y vinoteca.                    </p>                </div>                <div class="col-2">                    <p>                        Es un lugar tan céntrico como tranquilo. Equipado con tv de pantalla plana en todas las habitaciones y conexión WIFI, aire acondicionado y                        calefacción centralizados.                    </p>                    <p>                        Esta magnífica situación ofrece la ventaja de disfrutar de todos los servicios que requiere un turismo exigente como la proximidad a restaurantes                        de primer nivel donde degustar la gastronomía Sevillana, museos, monumentos, iglesias, palacios, zonas comerciales, etc. Al igual que disponer de                        un acceso rápido a medios de transporte como paradas de taxi a pie de calle, tranvía y líneas de autobuses.                    </p>                </div>            </div>        </div>        <!-- Text Block | END -->        <div class="section text feature fade visible">            <div class="center">                <div class="col-1">                    <ul class="tags">                        <li>8 Personas</li>                        <li>Internet</li>                        <li>Se suministran toallas</li>                        <li>Reservar Online</li>                        <li>4 Habitaciones</li>                        <li>Lavavajillas</li>                        <li>Ropa de cama</li>                        <li>2 Baños</li>                        <li>Lavadora</li>                        <li>Acepta Tarjetas de Crédito</li>                    </ul>                </div>            </div>        </div>        <!-- USP Strip | START -->        <div class="section usp fade">            <div class="center">                <div class="col-3">                    <div class="item">                        <i class="icon ion-ios-heart-outline"></i>                        <h4>En el corazón de Sevilla</h4>                        <p>                            Disfruta de nuestra terraza de 18 metros cuadrados con una panorámica perfecta con vistas a La Giralda y La Catedral.                        </p>                    </div>                </div>                <div class="col-3">                    <div class="item">                        <i class="icon ion-ios-location-outline"></i>                        <h4>Excelente localización</h4>                        <p>                            La Giralda, la Torre del Oro, los Reales Alcázares. Disfruta de todos los monumentos de la ciudad a tan solo un paso.                        </p>                    </div>                </div>                <div class="col-3">                    <div class="item">                        <i class="icon ion-ios-clock-outline"></i>                        <h4>Aparcamientos 24 hora</h4>                        <p>                            Despreocúpate del coche. Disfruta de hasta tres aparcamientos 24 horas cercanos al apartamento.                        </p>                    </div>                </div>            </div>        </div>        <!-- USP Strip | END -->        <!-- Photo Panel | START -->        <div class="section panel">            <div class="item side fade">                <div class="back" data-image="{{asset('template/system/images/apartamento/apartamento-sevilla-16.jpg')}}"></div>                <div class="panel-button">                    <div class="button-container">                        <a href="Galeria">Máximas comodidades</a>                        <span>Conoce el apartamento <i class="icon ion-ios-arrow-right"></i></span>                    </div>                </div>                <div class="details">                    <div class="float">                        <h3><strong>Confort</strong></h3>                        <p>Nuestro apartamento está equipado de forma que tu estancia en él sea una experiencia única e inolvidable.</p>                    </div>                </div>            </div>            <div class="item side fade">                <div class="back" data-image="{{asset('template/system/images/apartamento/apartamento-sevilla-18.jpg')}}"></div>                <div class="panel-button">                    <div class="button-container">                        <a href="Ubicacion">Ubicación</a>                        <span>En el corazón de Sevilla <i class="icon ion-ios-arrow-right"></i></span>                    </div>                </div>                <div class="details">                    <div class="float">                        <h3><strong>En el corazón de Sevilla</strong></h3>                        <p>Ubicado en pleno centro de Sevilla, en un enclave sin igual, con vistas a La Giralda y La Catedral desde nuestra terraza.</p>                    </div>                </div>            </div>        </div>        <!-- Photo Panel | END -->    </main>@stop@section('scripts')@stop