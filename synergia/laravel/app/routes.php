<?php/*|--------------------------------------------------------------------------| Application Routes|--------------------------------------------------------------------------|| Here is where you can register all of the routes for an application.| It's a breeze. Simply tell Laravel the URIs it should respond to| and give it the Closure to execute when that URI is requested.|*//** ------------------------------------------ *  Route model binding *  ------------------------------------------ */Route::model('user', 'User');Route::model('entrada', 'Entrada');Route::model('enlace', 'Enlace');Route::model('role', 'Role');Route::model('evento', 'Evento');Route::model('tutoria', 'Tutoria');Route::model('historico_tutoria', 'Historico_tutoria');Route::model('carpeta', 'Carpeta');/** ------------------------------------------ *  Route constraint patterns *  ------------------------------------------ */Route::pattern('entrada', '[0-9]+');Route::pattern('enlace', '[0-9]+');Route::pattern('evento', '[0-9]+');Route::pattern('carpeta', '[0-9]+');Route::pattern('user', '[0-9]+');Route::pattern('role', '[0-9]+');Route::pattern('tutoria', '[0-9]+');Route::pattern('historico_tutoria', '[0-9]+');Route::pattern('token', '[0-9a-z]+');/** ------------------------------------------ *  Admin Routes *  ------------------------------------------ */Route::group(array('prefix' => 'admin', 'after' => 'auth'), function(){      # User Management    Route::get('users/{user}/show', 'AdminUsersController@getShow');    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');    Route::controller('users', 'AdminUsersController');	    # Entrada Management    Route::get('entradas/{entrada}/show', 'AdminEntradasController@getShow');	Route::get('entradas/{entrada}/addLink', 'AdminEntradasController@getAddLink');    Route::get('entradas/{entrada}/edit', 'AdminEntradasController@getEdit');    Route::post('entradas/{entrada}/edit', 'AdminEntradasController@postEdit');    Route::get('entradas/{entrada}/delete', 'AdminEntradasController@getDelete');    Route::post('entradas/{entrada}/delete', 'AdminEntradasController@postDelete');    Route::get('entradas/{entrada}/share', 'AdminEntradasController@getShare');    Route::controller('entradas', 'AdminEntradasController');	# Eventos Management	Route::get('eventos/{evento}/show', 'AdminEventosController@getShow');	Route::get('eventos/{evento}/edit', 'AdminEventosController@getEdit');	Route::post('eventos/{evento}/edit', 'AdminEventosController@postEdit');	Route::get('eventos/{evento}/delete', 'AdminEventosController@getDelete');	Route::post('eventos/{evento}/delete', 'AdminEventosController@postDelete');	Route::controller('eventos', 'AdminEventosController');    # Tutorias Management    Route::get('tutorias/{tutoria}/show', 'AdminTutoriasController@getShow');    Route::get('tutorias/{tutoria}/edit', 'AdminTutoriasController@getEdit');    Route::post('tutorias/{tutoria}/edit', 'AdminTutoriasController@postEdit');    Route::get('tutorias/{tutoria}/delete', 'AdminTutoriasController@getDelete');    Route::post('tutorias/{tutoria}/delete', 'AdminTutoriasController@postDelete');    Route::get('tutorias/{tutoria}/data','AdminTutoriasController@getDataEnlace');    Route::controller('tutorias', 'AdminTutoriasController');        # User Role Management    Route::get('roles/{role}/show', 'AdminRolesController@getShow');    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');    Route::controller('roles', 'AdminRolesController');	#Enlaces	Route::get('enlace/{entrada}/index','AdminEntradasController@getEnlacesIndex');	Route::get('enlace/{enlace}/edit', 'AdminEntradasController@getEditEnlace');	Route::post('enlace/{enlace}/edit', 'AdminEntradasController@postEditEnlace');	Route::get('enlace/{enlace}/delete', 'AdminEntradasController@getDeleteEnlace');	Route::post('enlace/{enlace}/delete', 'AdminEntradasController@postDeleteEnlace');	Route::post('enlace/create','AdminEntradasController@postCreateEnlace');	Route::get('enlace/{entrada}/data','AdminEntradasController@getDataEnlace');        Route::get('historico/{historico_tutoria}/details', 'AdminHistoricoTutoriasController@getDetails');	Route::controller('historico', 'AdminHistoricoTutoriasController');    # Admin Dashboard    Route::controller('/', 'AdminDashboardController');});/** ----------------------------------------- * Dropzone Route *///Funcion optimizar imagenfunction resizeImagen($ruta, $nombre, $alto, $ancho, $nombreN, $extension){    $rutaImagenOriginal = $ruta.$nombre;    if($extension == 'jpg' || $extension == 'jpeg'){        $img_original = imagecreatefromjpeg($rutaImagenOriginal);    }    if($extension == 'png'){        $img_original = imagecreatefrompng($rutaImagenOriginal);    }        $max_ancho = $ancho;    $max_alto = $alto;    list($ancho,$alto)=getimagesize($rutaImagenOriginal);    $x_ratio = $max_ancho / $ancho;    $y_ratio = $max_alto / $alto;    if(($ancho <= $max_ancho) && ($alto <= $max_alto)){        $ancho_final = $ancho;        $alto_final = $alto;    }elseif(($x_ratio * $alto) < $max_alto){        $alto_final = ceil($x_ratio * $alto);        $ancho_final = $max_ancho;    }else{        $ancho_final = ceil($y_ratio * $ancho);        $alto_final = $max_alto;    }		    $tmp=imagecreatetruecolor($ancho_final,$alto_final);    imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final, $ancho, $alto);    $tamanyo = filesize($rutaImagenOriginal);    imagedestroy($img_original);        if($tamanyo >= 1572864){        $calidad = 70;        imagejpeg($tmp,$ruta.$nombreN,$calidad);    }    else{        imagejpeg($tmp,$ruta.$nombreN,100);    }}// upload fileRoute::post('upload', function (){    //Input::file('photo')->getSize();	$file = Input::file('file');    $entrada = Entrada::find(Input::get('entrada'));    	if($file){        $size = $file->getSize();        //Controlar que no exceda la m�xima subida de fichero definido en php.ini        $maximoTamanyoSubida = ini_get('upload_max_filesize');        $maximoTamanyoSubida = substr($maximoTamanyoSubida, 0, -1);        $maximoTamanyoSubida = $maximoTamanyoSubida*1024*1024;                if($size < $maximoTamanyoSubida){                		$destinationPath = public_path() . '/entradas/';        		$filename = $file->getClientOriginalName();        		$marca = round(microtime(true)).'-'.rand(0, 10000);        		$extension = preg_split("/\./",$filename);        		$extension = strtolower($extension[sizeof($extension)-1]);                        $esImagen = false;                        if($extension=="jpg" || $extension=="jpeg" || $extension=="png"){                                $esImagen = true;                                $imagen = $marca.'.'.$extension;                                Image::make(Input::file('file'))->save($destinationPath.$imagen);                //move_uploaded_file($file, $destinationPath.$imagen);                                $resImagen = $imagen;               	                list($anchura, $altura) = getimagesize($destinationPath.$imagen);                                if($anchura > 1100 && $altura > 700){                    if($anchura >= $altura){                        $anchura = 1100;                        $altura = 1100;                    }                    else{                        $anchura = 700;                        $altura = 700;                    }                }                else if($anchura > 1100){                        $anchura = 1100;                        $altura = 1100;                }                else if($altura > 700){                        $anchura = 700;                        $altura = 700;                }                //1459756760-5676.jpeg                resizeImagen($destinationPath, $imagen, $anchura, $altura, $resImagen, $extension);	                                            //unlink($destinationPath.$imagen);            }                        if(!$esImagen)    		  $upload_success = Input::file('file')->move($destinationPath, $marca.'.'.$extension);        		                		if ($esImagen || $upload_success){    			$enlace = new Enlace;        			$enlace->nombre = $filename;        			$enlace->url =  $marca.'.'.$extension;        			$enlace->carpeta_id = 1;        			$enlace->tipo = $extension;        			$enlace->save();        			$entrada->urls()->attach($enlace->id);    			// resizing an uploaded file    			if($extension == "jpg" or $extension == "jpeg"){    			     Image::make($destinationPath.$resImagen)->resize(150, 150)->save($destinationPath. "150x150_" . $marca.'.'.$extension);    			}    			return Response::json('success', 200);        		} else {        			return Response::json('error', 400);        		}        }        else{            return Response::json('Error: El archivo excede el l�mite de tama�o m�ximo permitido.', 500);        }	}});	// delete image	Route::post('delete-image', function () {		$destinationPath = public_path() . '/entradas/';		if(File::exists($destinationPath . Input::get('file'))){			File::delete($destinationPath . Input::get('file'));			File::delete($destinationPath . "150x150_" . Input::get('file'));			$enlace = Enlace::where("url","=",Input::get('file'))->first();		}else{			$enlace = Enlace::where("nombre","=",Input::get('file'))->first();			File::delete($destinationPath . $enlace->url());			File::delete($destinationPath . "150x150_" . $enlace->url());					}					$entrada = Entrada::find(Input::get('entrada'));		$entrada->urls()->detach($enlace->id);		$enlace->delete();		return Response::json('success', 200);	});/** ------------------------------------------ *  Frontend Routes *  ------------------------------------------ */// User reset routesRoute::get('user/reset/{token}', 'UserController@getReset');// User password resetRoute::post('user/reset/{token}', 'UserController@postReset');//:: User Account Routes ::Route::post('user/{user}/edit', 'UserController@postEdit');//:: User Account Routes ::Route::post('user/login', 'UserController@postLogin');# User RESTful Routes (Login, Logout, Register, etc)Route::controller('user', 'UserController');//:: Application Routes ::Route::get('entradas/{entrada}/details', 'AdminEntradasController@getDetails');Route::get('galerias/{entrada}/details', 'AdminEntradasController@getDetailsGaleria');# Filter for detect languageRoute::when('contact-us','detectLang');Route::get('eventos/{date}/details', 'AdminEventosController@getDetails');Route::get('Inicio', function(){	$eventos = Evento::all();	$calendarEvent = array();	foreach ($eventos as $evento){		$fecha = new DateTime($evento->fecha_inicio);		$fechaFin = new DateTime($evento->fecha_fin);		do {			$calendarEvent[$fecha->format('Y-m-d')] = array(								"url" => URL::to('eventos/' . $fecha->format('Y-m-d') . '/details'),			);			$fecha->add(new DateInterval('P1D'));		}while($fecha <= $fechaFin);	}	JavaScript::put([		'calendariodeeventos' => $calendarEvent,	]);	$entradas = Entrada::all();	return View::make('site/welcome',compact('entradas'));		});Route::post('sendMail', 'AdminContactoController@sendMail');//Views of siteRoute::get('Aviso-legal', function(){return View::make('site/aviso-legal');});Route::get('Equipamiento', function(){return View::make('site/equipamiento');});Route::get('Ubicacion', function(){return View::make('site/ubicacion');});Route::get('Galeria', function(){return View::make('site/galeria');});Route::get('Contacto', function(){return View::make('site/contacto');});Route::get('Reservar', function(){return View::make('site/reservar');});Route::get('Blog', function(){return View::make('site/blog');});App::missing(function($exception){	return Redirect::action('WelcomeController@getIndex');});# Index Page - Last route, no matchesRoute::get('/', array('after' => 'detectLang','uses' => 'WelcomeController@getIndex'));