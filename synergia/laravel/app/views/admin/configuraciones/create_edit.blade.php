@extends('admin.layouts.modal'){{-- content --}}@section('content')    @if(Session::has('intervalos_pisados'))        <div class="alert alert-danger alert-dismissable">            <button type="button" class="close" data-dismiss="alert">&times;</button>            <p><strong>Error.</strong> El intervalo de fechas se superpone a uno de los siguientes:</p><br>            <ol style="margin-top: 10px;">                @foreach(Session::get('intervalos_pisados') as $item)                    <li><span style="display: inline-block; width: 300px;">{{ $item->alias }}</span><strong>{{ date_format(date_create($item->fecha_ini), 'd/m/Y') }}</strong> ~ <strong>{{ date_format(date_create($item->fecha_fin), 'd/m/Y') }}</strong></li>                @endforeach            </ol>        </div>    @endif        <!-- Tabs -->		<ul class="nav nav-tabs">			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>		</ul>	<!-- ./ tabs -->    @if(isset($configuracion))        {{ Form::model($configuracion, array('action' => array('AdminConfiguracionesController@update', $configuracion->id), 'method' => 'put', 'class' => 'form-horizontal')) }}    @else        {{ Form::open(array('action' => 'AdminConfiguracionesController@store', 'method' => 'post', 'class' => 'form-horizontal')) }}    @endif    <div class="tab-content">        <!-- General tab -->        <div class="tab-pane active" id="tab-general">            <!-- configuraciones alias -->            @if(!isset($configuracion) || isset($configuracion) && $configuracion->id != 1)            <div class="form-group {{{ $errors->has('alias') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('alias', 'Alias', array('class' => 'control-label')) }}                    <div class="input-group">                        {{ Form::text('alias', null, array('class' => 'form-control')) }}                        <div class="input-group-btn">                            <!-- Botón y menú desplegable -->                            <button type="button" class="btn btn-default" tabindex="-1" style="padding: 6px 30px">Alias</button>                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" tabindex="-1">                                <span class="caret"></span>                                <span class="sr-only">Desplegar menú</span>                            </button>                            <ul class="dropdown-menu pull-right lista-alias" role="menu" style="font-size: 16px;">                                <li><a href="#">Navidad</a></li>                                <li><a href="#">Feria</a></li>                                <li><a href="#">Semana Santa</a></li>                            </ul>                        </div>                    </div>                    {{ $errors->first('alias', '<span class="help-block">:message</span>') }}                </div>            </div>            <!-- ./ configuraciones alias -->            <!-- configuraciones fecha inicio -->            <div class="form-group {{{ $errors->has('fecha_ini') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('fecha_ini', 'Fecha Inicio', array('class' => 'control-label')) }}                    {{ Form::text('fecha_ini', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}                    {{ $errors->first('fecha_ini', '<span class="help-block">:message</span>') }}                </div>            </div>            <!-- ./ configuraciones fecha inicio -->            <!-- configuraciones fecha final -->            <div class="form-group {{{ $errors->has('fecha_fin') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('fecha_fin', 'Fecha Final', array('class' => 'control-label')) }}                    {{ Form::text('fecha_fin', null, array('class' => 'form-control', 'readonly' => 'readonly')) }}                    {{ $errors->first('fecha_fin', '<span class="help-block">:message</span>') }}                </div>            </div>            @endif            <div class="form-group {{{ $errors->has('tarifa_minima') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('tarifa_minima', 'Tarifa mínima', array('class' => 'control-label')) }}                    <div class="input-group">                        {{ Form::text('tarifa_minima', null, array('class' => 'form-control')) }}                        <span class="input-group-addon">&euro;</span>                    </div>                    {{ $errors->first('tarifa_minima', '<span class="help-block">:message</span>') }}                </div>            </div>            <div class="form-group {{{ $errors->has('precio_noche_adicional') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('precio_noche_adicional', 'Precio noche', array('class' => 'control-label')) }}                    <div class="input-group">                        {{ Form::text('precio_noche_adicional', null, array('class' => 'form-control')) }}                        <span class="input-group-addon">&euro;</span>                    </div>                    {{ $errors->first('precio_noche_adicional', '<span class="help-block">:message</span>') }}                </div>            </div>            <div class="form-group {{{ $errors->has('precio_semana') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('precio_semana', 'Precio semana', array('class' => 'control-label')) }}                    <div class="input-group">                        {{ Form::text('precio_semana', null, array('class' => 'form-control')) }}                        <span class="input-group-addon">&euro;</span>                    </div>                    {{ $errors->first('precio_semana', '<span class="help-block">:message</span>') }}                </div>            </div>            <div class="form-group {{{ $errors->has('noches_minimas') ? 'has-error' : '' }}}">                <div class="col-md-12">                    {{ Form::label('noches_minimas', 'Noches mínimas', array('class' => 'control-label')) }}                    {{ Form::selectRange('noches_minimas', 1, 10, isset($configuracion) ? $configuracion->noches_minimas : 2, array('class' => 'form-control')) }}                    {{ $errors->first('noches_minimas', '<span class="help-block">:message</span>') }}                </div>            </div>            <!-- ./ configuraciones fecha final -->            </div>            <!-- ./ groups -->        </div>        <!-- ./ general tab -->    <!-- ./ tabs contenido -->    <!-- Form Actions -->    <div class="form-group">        <div class="col-md-12">            <button type="reset" class="btn btn-default">Limpiar</button>            <button type="submit" class="btn btn-success">{{ $text_button_submit }}</button>        </div>    </div>    {{ Form::close() }}    </div>@stop@section('styles')<!-- 1 --><link href="{{asset('assets/css/dropzone.css')}}" type="text/css" rel="stylesheet" /><link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"><style rel="stylesheet">    #ui-datepicker-div{        z-index: 2 !important;    }</style>@stop{{-- Scripts --}}@section('scripts')	<script src="{{ asset('/template/plugins/ckeditor/ckeditor.js') }}"></script>    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>    <script type="text/javascript">        function inicializarFechaInicio(){            $('#fecha_ini').datepicker({                numberOfMonths: 1,                regional: 'es',                dateFormat: 'dd-mm-yy',                changeMonth: true,                changeYear: true,                yearRange: '2000:2100',                monthNamesShort: ["Ene", "Feb", "Mar", "Abr",                    "May", "Jun", "Jul", "Ago", "Sep",                    "Oct", "Nov", "Dec"],                dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab']            });        }        function inicializarFechaFin(){            $('#fecha_fin').datepicker({                numberOfMonths: 1,                regional: 'es',                dateFormat: 'dd-mm-yy',                changeMonth: true,                changeYear: true,                yearRange: '2000:2100',                monthNamesShort: ["Ene", "Feb", "Mar", "Abr",                    "May", "Jun", "Jul", "Ago", "Sep",                    "Oct", "Nov", "Dec"],                dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab']            });        }        $(document).ready(function(){            $('.lista-alias a').click(function(){               $('#alias').val($(this).text());            });            //Inicializar datepickers            inicializarFechaInicio();            inicializarFechaFin();        });    </script>@stop