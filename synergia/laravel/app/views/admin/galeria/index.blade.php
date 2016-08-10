@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
    Galería :: @parent
@stop

@section('keywords')Entrys administration @stop
@section('author')Laravel 4 Bootstrap Starter SIte @stop
@section('description')Entrys administration index @stop

@section('styles')
    <link href="{{asset('assets/css/dropzone.css')}}" rel="stylesheet" />
@stop

{{-- Content --}}
@section('content')
    <div class="page-header" style="margin-bottom: 20px;">
        <h3>
            Galería
        </h3>
    </div>

    <div class="row">
        {{ Form::open(array('action' => 'AdminGaleriaController@upload', 'class'=>'dropzone', 'id'=>'my-dropzone')) }}
        <div class="col-xs-12">
            <div class="form-group">
                <label class="control-label" for="patron">Patrón para la imagen</label>
                <input type="text" name="patron" id="patron" class="form-control">
            </div>
            <p style="color: red;">
                Se recomienda escribir un patrón para renombrar las imágenes subidas. Con el nombre adecuado puede beneficiar al SEO de tu web.*
            </p>
        </div>
        <div class="col-xs-12">
            <div class="form-group" style="margin-top: 30px;">
                <div id="dropzone">

                    <!-- Multiple file upload-->

                    <div class="fallback">
                        <input name="file" type="file" multiple = "false"/>
                    </div>

                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@stop

{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript" src="{{asset('assets/js/dropzone.js')}}"></script>
    <script type="text/javascript">
        Dropzone.options.myDropzone = {

            acceptedFiles: ".jpeg,.jpg,.png",
            uploadMultiple: false,

            init: function() {

                var myDropzone = this;

                this.on("addedfile", function(file) {

                    var option = document.createElement("option");

                    var removeButton = Dropzone.createElement('<a class="dz-remove">Remove file</a>');

                    var _this = this;

                    removeButton.addEventListener("click", function(e) {

                        e.preventDefault();

                        e.stopPropagation();

                        var fileInfo = new Array();

                        fileInfo['name']=file.name;

                        $.ajax({

                            type: "POST",

                            url: "{{ URL::to('admin/galeria/delete-image') }}", // URL que que va al controlador que elimina la imagen

                            data: {_token : "{{ csrf_token() }}", file : file.name},

                            beforeSend: function () {


                                // before send


                            },

                            success: function (response) {

                                if (response == 'success')

                                    alert('deleted');

                            },


                            error: function () {

                                alert("error");

                            }

                        });

                        _this.removeFile(file);

                        // If you want to the delete the file on the server as well,


                        // you can do the AJAX request here.

                    });

                    // Add the button to the file preview element.

                    file.previewElement.appendChild(removeButton);

                });

                this.on('complete', function(file){
                    $("img:not(.img-responsive)").addClass('img-responsive');
                });

                $.each( Laracasts.files, function( key, value ) {

                    // Call the default addedfile event handler

                    myDropzone.emit("addedfile", value);

                    // And optionally show the thumbnail of the file:

                    myDropzone.emit("thumbnail", value, "{{url('/galeria/thumbnails/')}}/150x150_"+value.name);

                    myDropzone.emit("complete", value);

                });

            }
        };
    </script>
@stop