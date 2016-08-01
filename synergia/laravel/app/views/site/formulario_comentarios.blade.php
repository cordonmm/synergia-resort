@extends('site.layouts.default')

@section('title')
    Apartamento en Sevilla | Synergia Resort
    @parent

@stop

@section('content')
    <main>
        <!-- Form | START -->
        <div class="section form fade">
            <div class="center">
                <h2>¿Tienes algo que compartir?</h2>
                <h5>Este es el sitio.</h5>
                @if(Session::has('success'))
                    <h5>{{ Session::get('success') }}</h5>
                @endif
                <form action="{{ URL::action('ComentarioController@enviar') }}" method="post">
                    {{ Form::token() }}
                    <div class="col-1">
                        <div class="field"><input name="contact-name" id="contact-name" type="text" placeholder="Tu nombre" value="{{ Input::old('contact-name') }}" /></div>
                        @if($errors->has('contact-name'))
                            <div style="text-align: left; max-width: 600px; margin: 0 auto 12px auto;">
                                {{ $errors->first('contact-name') }}
                            </div>
                        @endif
                        <div class="field"><input name="contact-email" id="contact-email" type="text" placeholder="Email" value="{{ Input::old('contact-email') }}" /></div>
                        @if($errors->has('contact-email'))
                            <div style="text-align: left; max-width: 600px; margin: 0 auto 12px auto;">
                                {{ $errors->first('contact-email') }}
                            </div>
                        @endif
                        <div class="field"><textarea name="contact-message" id="contact-message" placeholder="Comentario" >{{ Input::old('contact-message') }}</textarea></div>
                        @if($errors->has('contact-message'))
                            <div style="text-align: left; max-width: 600px; margin: 0 auto 12px auto;">
                                {{ $errors->first('contact-message') }}
                            </div>
                        @endif

                        <!--
                            Nocaptcha Recaptcha de Google
                        -->

                        <div class="field" style="background-color: transparent">
                            <div class="g-recaptcha" data-sitekey="6LfP6SUTAAAAADh4a1QRy4orWyfM8kp90r4ucANS"></div>
                        </div>

                        <button class="button" name="send" value="sendform">Enviar <i class="icon ion-ios-arrow-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Form | END -->
    </main>
@stop

@section('scripts')
    <script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
@stop






