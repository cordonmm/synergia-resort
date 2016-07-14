@extends('site.layouts.default')
{{-- Web site Title --}}
@section('title')

@parent
@stop

{{-- Content --}}
{{-- Content --}}
@section('content')
<!-- =========== Page Body Inside Content =========== -->
            <div class="inside-body-content-container clearfix">

                <!-- End: Section: Breadcrumbs -->

                <!-- =========== Section 2 =========== -->
                <div class="container-fluid horizontal-section-container clearfix">
                    <div class="row">

                        <div class="col-sm-8">
                            <!-- Main Page Content -->
                            <div id="main-page-content" class="section-container main-page-content clearfix">

                                <!-- Content -->
								@yield('content-left')
								<!-- ./ content -->

                            </div><!-- .section-container -->
                            <!-- End: Main Page Content -->
                        </div><!-- .col-sm-8 -->

                        <div class="col-sm-4">

                            <!-- Gallery -->
                            @yield('gallery')
                            
                            
                            
                            <!-- Latest News -->
                            <div id="sidebar-news" class="section-container clearfix">

                                <a href="news-date.html" class="section-header with-icon">
                                    <div class="icon"><span class="glyphicon glyphicon-bullhorn"></span></div>
                                    <h5 class="text">&Uacute;ltimas Noticias</h5>
                                </a><!-- .section-header -->

                                <div class="section-content clearfix">
                                    {{--*/ $entradas = Entrada::where('categoria','=','noticias')->orderby('updated_at', 'desc')->take(6)->get() /*--}}

                                    <ul class="vertical-simple-list w-dates">
                                        @foreach($entradas as $entrada)
                                            {{--*/ $update = DateTime::createFromFormat("Y-!m-d", $entrada->updated_at) /*--}}
                                        <!-- list item -->
                                        <li class="item clearfix"><div class="item-content">
                                            <div class="date">
                                                <div class="day">{{ date("d", strtotime($entrada->updated_at)) }}</div>
                                                <div class="month">{{ date("M", strtotime($entrada->updated_at)) }}</div>
                                            </div>
                                            <h6 class="title"><a href="{{URL::to('entradas/'.$entrada->id.'/details/')}}">{{$entrada->titulo}}</a></h6>
                                        </div></li>
                                        @endforeach
                                        <!-- list item -->


                                    </ul><!-- .vertical-simple-list -->
                                </div><!-- .section-content -->

                            </div><!-- .section-container -->
                            <!-- End: Latest News -->
							
							<div id="sidebar-news" class="section-container clearfix">
							<a class="twitter-timeline" href="https://twitter.com/Hdad_Museo" data-widget-id="556766552398528512">Tweets por el @Hdad_Museo.</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

							<img src="{{asset('template/images/design/donante-caridad.png')}}" alt="Hermandad del museo" class="full-width-image">

							</div>
							
                        </div><!-- .col-sm-4 -->

                    </div><!-- .row -->
                </div><!-- .container-fluid -->
                <!-- End: Section 2 -->

@stop