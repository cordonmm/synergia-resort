@extends('site.layouts.default')



{{-- Web site Title --}}

@section('title')

{{{ Lang::get('user/user.login') }}} ::

@parent

@section('styles')
    <link rel="stylesheet" href="{{ asset('template/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/bootstrap/bootstrap-theme.min.css') }}">
    <style rel="stylesheet">
        .container:first-child{
            width: 100% !important;
            padding: 0 !important;
            height: auto;
        }
        
        footer{
            opacity: 1 !important;
        }
        
        div[class^="col"]{
            float: none !important;
        }
    </style>
@stop

@stop



{{-- Content --}}

@section('content')
<div class="container" style="margin: 150px auto; padding: 20px; border: 1px solid rgb(242, 242, 242); border-radius: 5px;">
    <div class="page-header">
    
    	<h1>Introduzca sus datos de acceso</h1>
    
    </div>
    
    <form class="form-horizontal" method="POST" action="{{ URL::to('user/login') }}" accept-charset="UTF-8">
    
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
        <fieldset>
    
            <div class="form-group">
    
                <div class="col-md-3">
                    <label class="control-label" for="email">{{ Lang::get('confide::confide.username_e_mail') }}</label>
                </div>
               
    
                <div class="col-md-9">
    
                    <input class="form-control" tabindex="1" placeholder="{{ Lang::get('confide::confide.username_e_mail') }}" type="text" name="email" id="email" value="{{ Input::old('email') }}">
    
                </div>
    
            </div>
    
            <div class="form-group">
    
                <div class="col-md-3">
                    <label class="control-label" for="password">
        
                        {{ Lang::get('confide::confide.password') }}
        
                    </label>
                </div>

                <div class="col-md-9">
    
                    <input class="form-control" tabindex="2" placeholder="{{ Lang::get('confide::confide.password') }}" type="password" name="password" id="password">
    
                </div>
    
            </div>
    
    
    
            <div class="form-group">
            
            <div class="col-xs-12">
                <div class="checkbox">
                    <label for="remember">
                        <input type="hidden" name="remember" value="0">
                        <input tabindex="4" type="checkbox" name="remember" id="remember" value="1">
                        {{ Lang::get('confide::confide.login.remember') }}
                    </label>
                </div>
            </div>
                <!--<div class="col-md-offset-2 col-md-10">
    
                    <div class="checkbox">
    
                        <label for="remember">{{ Lang::get('confide::confide.login.remember') }}
    
                            <input type="hidden" name="remember" value="0">
    
                            <input tabindex="4" type="checkbox" name="remember" id="remember" value="1">
    
                        </label>
    
                    </div>
    
                </div>-->
    
            </div>
            
            <br />
    
    
    
            @if ( Session::get('error') )
    
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
    
            @endif
    
    
    
            @if ( Session::get('notice') )
    
            <div class="alert">{{ Session::get('notice') }}</div>
    
            @endif
    
    
    
            <div class="form-group">
    
                <!--<div class="col-md-offset-2 col-md-10">
    
                    <button tabindex="3" type="submit" class="btn btn-primary">{{ Lang::get('confide::confide.login.submit') }}</button>
    
                    <a class="btn btn-default" href="forgot">{{ Lang::get('confide::confide.login.forgot_password') }}</a>
    
                </div>-->

                <div class="col-md-10">

                    <button tabindex="3" type="submit" class="btn btn-primary">{{ Lang::get('confide::confide.login.submit') }}</button>

                    <a class="btn btn-default" href="forgot">{{ Lang::get('confide::confide.login.forgot_password') }}</a>

                </div>
    
            </div>
    
        </fieldset>
    
    </form>
</div>



@stop

@section('scripts')
    <script type="text/javascript" src="{{ asset('template/bootstrap/bootstrap.min.js') }}"></script>
@stop

