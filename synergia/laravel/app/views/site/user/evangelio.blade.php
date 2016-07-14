@extends('site.layouts.content')

{{-- Web site Title --}}

@section('title')
Visitas Culturales

@parent
@stop

{{-- Content --}}

@section('content-left')

<!-- =========== Section 2 =========== -->                                        

<div class="col-sm-12">                            
<!-- Main Blog Items -->                            
    <div class="section-container main-page-content clearfix">                                
        <div class="section-content">                                    
            <h1 class="page_title">Visitas Culturales</h1>                                    
            <!-- Blog List -->                                    
            <div class="blog-articles-container clearfix">                                        
            {{--*/ $entradas = Entrada::where('categoria','=','actividades')->orderby('created_at','desc')->paginate(6) /*--}}                                        
            
                @foreach($entradas as $entrada)                                       
                <!-- Blog Single Article -->                                        
                    <article class="blog-article clearfix">                                            
                        <div class="blog-article-content clearfix">                                                
                            <h3 class="title"><a href="{{URL::to('entradas/'.$entrada->id.'/details/')}}">{{$entrada->titulo}}</a></h3>                                                
                            <!--<div class="meta clearfix">                                                    
                                <div class="meta-item date"><span class="glyphicon glyphicon-time"></span> {{$entrada->created_at}}</div>                                                
                            </div><!-- .meta -->                                                
                            <div class="text-content excerpt clearfix">                                                    
                                <p>{{ Str::limit($entrada->contenido, 200) }} </p>                                                
                            </div>                                                 
                            {{--*/ $enlace = $entrada->urls->first() /*--}}                                                                                                        
                            
                            @if($enlace != null)                                                                                                                                                                                                                          
                                @if(Str::lower($enlace->tipo) == "pdf")                                                            
                                    <iframe frameborder='0'  class='feature-image img-mask-effect zoom photo_link' width='100%' height='100%'  title='ReglasMuseo 2011' src='{{$enlace->url}}' type='text/html' allowfullscreen='true' scrolling='no' marginwidth='0' marginheight='0'></iframe>                                                        
                                @elseif(Str::lower($enlace->tipo) == "jpg")                                                            
                                    <a href="{{asset('entradas/'.$enlace->url)}}" class="feature-image img-mask-effect zoom photo_link">                                                                
                                        <img src="{{asset('entradas/'.$enlace->url)}}" alt="Foto">                                                                
                                        <i class="mask"><span class="glyphicon glyphicon-plus-sign large"></span></i>                                                            
                                    </a>                                                        
                                @else                                                            
                                    {{HTML::decode($enlace->url)}}                                                        
                                @endif                                                    
                            @endif                                                                                            
                        </div><!-- .blog-article-content -->                                        
                    </article><!-- .blog-article -->                                        
                @endforeach                                    
            </div><!-- .blog-articles-container -->                                    
            <!-- End: Blog List -->                                    
            <!-- Pagination -->                                    
            <div class="pagination-container center clearfix">                                        
                <ul class="pagination-list">                                            
                    {{$entradas->links()}}                                        
                </ul>                                    
            </div><!-- .pagination-container -->                                
        </div><!-- .section-content -->                            
    </div><!-- .section-container -->                            
    <!-- End: Main Blog Items -->                                        
</div><!-- .container-fluid -->                
<!-- End: Section 2 -->
@stop