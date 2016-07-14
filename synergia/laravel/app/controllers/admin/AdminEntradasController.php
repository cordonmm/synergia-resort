<?phpuse Illuminate\Filesystem\Filesystem;//use Facebook\Facebook;class AdminEntradasController extends AdminController{	/**	 * Post Model	 * @var Post	 */	protected $entrada;		/**	 * Inject the models.	 * @param Post $post	 */	public function __construct(Entrada $entrada)	{		parent::__construct();		$this->entrada = $entrada;	}		/**	 * Show a list of all the entrada posts.	 *	 * @return View	 */	public function getIndex()	{		// titulo		$title = Lang::get('admin/entradas/title.entry_management');			// Grab all the entrada posts		$entradas = $this->entrada;			// Show the page		return View::make('admin/entradas/index', compact('entradas', 'title'));	}		/**	 * Show the form for creating a new resource.	 *	 * @return Response	 */	public function getCreate()	{		// titulo		$title = Lang::get('admin/entradas/titulo.create_a_new_entry');		$categoria = Entrada::distinct('categoria')->lists('categoria');		JavaScript::put([			'categorias' => $categoria,		]);		// Show the page		return View::make('admin/entradas/create_edit', compact('title'));	}		/**	 * Store a newly created resource in storage.	 *	 * @return Response	 */	public function postCreate()	{		// Declare the rules for the form validation		$rules = array(				'titulo'   => 'required|min:3',				'categoria' => 'required|min:3',		);			// Validate the inputs		$validator = Validator::make(Input::all(), $rules);			// Check if the form validates with success		if ($validator->passes())		{			// Create a new entrada post			$user = Auth::user();				// Update the entrada post data			$this->entrada->titulo            = Input::get('titulo');			$this->entrada->subtitulo         = Input::get('subtitulo');			$this->entrada->contenido         = Input::get('contenido');			$this->entrada->categoria         = Input::get('categoria');			$this->entrada->user_id			  = $user->id;				// Was the entrada post created?			if($this->entrada->save())			{				// Redirect to the new entrada post page				return Redirect::to('admin/entradas/' . $this->entrada->id . '/edit')->with('success', Lang::get('admin/entradas/messages.create.success'));			}				// Redirect to the entrada post create page			return Redirect::to('admin/entradas/create')->with('error', Lang::get('admin/entradas/messages.create.error'));		}			// Form validation failed		return Redirect::to('admin/entradas/create')->withInput()->withErrors($validator);	}		/**	 * Display the specified resource.	 *	 * @param $post	 * @return Response	 */	public function getShow($entrada)	{		// redirect to the frontend	}	public function getDetails($entrada)	{		return View::make('admin/entradas/details', compact('entrada'));	}        public function getDetailsGaleria($entrada)	{		return View::make('admin/galerias/details', compact('entrada'));	}		/**	 * Show the form for editing the specified resource.	 *	 * @param $post	 * @return Response	 */	public function getEdit($entrada)	{		// titulo		$title = Lang::get('admin/entradas/title.entry_update');		$urls = $entrada->urls;		$files = array();		$destinationPath = public_path() . '/entradas/';		foreach ($urls as $url){			if(Str::lower($url->tipo) == 'jpg' or Str::lower($url->tipo) == 'jpeg'){			$array = array(					"name" => $url->nombre ,					"size" => Image::make($destinationPath.$url->url)->filesize(),                    "url"  => $url->url,			);			array_push($files,$array);			}            else if(Str::lower($url->tipo) <> 'jpg' and Str::lower($url->tipo) <> 'jpeg' and Str::lower($url->tipo) <> 'video'){                $array = array(                    "name" => $url->nombre ,                    "size" =>File::size($destinationPath.$url->url),                    "url"  => 'document-default.jpg',                );                array_push($files,$array);            }					}		$categoria = Entrada::distinct('categoria')->lists('categoria');		JavaScript::put([		'files' => $files,		'categorias' => $categoria,				]);		// Show the page		return View::make('admin/entradas/create_edit', compact('entrada', 'title'));	}		/**	 * Update the specified resource in storage.	 *	 * @param $post	 * @return Response	 */	public function postEdit($entrada)	{			// Declare the rules for the form validation		$rules = array(				'titulo'   => 'required|min:3',		);			// Validate the inputs		$validator = Validator::make(Input::all(), $rules);		$categoria = Entrada::lists('categoria');		JavaScript::put([			'categorias' => $categoria,		]);		// Check if the form validates with success		if ($validator->passes())		{			// Update the entrada post data			$entrada->titulo            = Input::get('titulo');			$entrada->subtitulo         = Input::get('subtitulo');			$entrada->contenido         = Input::get('contenido');				// Was the entrada post updated?			if($entrada->save())			{				// Redirect to the new entrada post page				return Redirect::to('admin/entradas/' . $entrada->id . '/edit')->with('success', Lang::get('admin/entradas/messages.update.success'));			}				// Redirect to the entradas post management page			return Redirect::to('admin/entradas/' . $entrada->id . '/edit')->with('error', Lang::get('admin/entradas/messages.update.error'));		}			// Form validation failed		return Redirect::to('admin/entradas/' . $entrada->id . '/edit')->withInput()->withErrors($validator);	}			/**	 * Remove the specified resource from storage.	 *	 * @param $post	 * @return Response	 */	public function getDelete($entrada)	{		// titulo		$title = Lang::get('admin/entradas/title.entry_delete');			// Show the page		return View::make('admin/entradas/delete', compact('entrada', 'title'));	}	public function getEnlacesIndex($entrada){		$title = "Enlaces";		$cadenaData = 'admin/enlace/'.$entrada->id.'/data';		return View::make('admin/enlaces/index', compact('entrada','title','cadenaData'));	}	public function getAddLink($entrada){		$title = "Añadir enlace";        $tipos = array();        $tipos['video'] = 'Video';		return View::make('admin/enlaces/create_edit', compact('entrada','title','tipos'));	}	public function postCreateEnlace(){		$rules = array(			'nombre'   => 'required|min:3',			'url' => 'required|min:3'		);		// Validate the inputs		$validator = Validator::make(Input::all(), $rules);		$entrada = Entrada::find(Input::get('entrada'));		// Check if the form validates with success        $patron = '%^ (?:https?://)? (?:www\.)? (?: youtu\.be/ | youtube\.com (?: /embed/ | /v/ | /watch\?v= ) ) ([\w-]{10,12}) $%x';        $array = preg_match($patron, Input::get('url'), $parte);        if (false !== $array) {            $idyoutube =  $parte[1];        }        else{            $idyoutube =  false;        }        		// Check if the form validates with success        if($idyoutube == false){            	return Redirect::to('admin/enlace/' . $enlace->id . '/edit')->withInput()->with('error','Enlace de video incorrecto, debe ser un video de youtube')->with('title', 'Añadir enlace');        }		if ($validator->passes()) {			$enlace = new Enlace;			$enlace->nombre = Input::get('nombre');			$enlace->url = $idyoutube;			$enlace->carpeta_id = 1;			$enlace->tipo = Input::get('tipo');			$enlace->local = 0;			$enlace->save();			$entrada->urls()->attach($enlace->id);			return Redirect::to('admin/enlace/' . $enlace->id . '/edit')->with('success', Lang::get('admin/entradas/messages.update.success'))->with('entrada', $entrada)->with('title', 'Añadir enlace');		}		else{			return Redirect::to('admin/entradas/' . $entrada->id . '/addLink')->withInput()->withErrors($validator)->with('title', 'Añadir enlace');		}	}	public function getEditEnlace($enlace)	{		// titulo		$title = "Añadir enlace";        $array = Enlace::select('tipo')->distinct()->get();        $tipos = array();        foreach($array as $tipo){            $tipos[$tipo["tipo"]]= strtoupper($tipo["tipo"]);        }        		return View::make('admin/enlaces/create_edit', compact('enlace','title','tipos'));	}	public function postEditEnlace($enlace){		$rules = array(			'nombre'   => 'required|min:3',			'url' => 'required|min:3'		);		// Validate the inputs		$validator = Validator::make(Input::all(), $rules);		$entrada = Entrada::find(Input::get('entrada'));                $patron = '%^ (?:https?://)? (?:www\.)? (?: youtu\.be/ | youtube\.com (?: /embed/ | /v/ | /watch\?v= ) ) ([\w-]{10,12}) $%x';        $array = preg_match($patron, Input::get('url'), $parte);        if (false !== $array) {            $idyoutube =  $parte[1];        }else{            $idyoutube =  false;        }             		// Check if the form validates with success        if($idyoutube == false){            	return Redirect::to('admin/enlace/' . $enlace->id . '/edit')->withInput()->with('error','Enlace de video incorrecto, debe ser un video de youtube')->with('title', 'Añadir enlace');        }		if ($validator->passes()) {			$enlace->nombre = Input::get('nombre');			$enlace->url = $idyoutube;			$enlace->carpeta_id = 1;			$enlace->save();			return Redirect::to('admin/enlace/' . $enlace->id . '/edit')->with('success', Lang::get('admin/entradas/messages.update.success'))->with('title', 'Añadir enlace');		}		else{			return Redirect::to('admin/enlace/' . $enlace->id . '/edit')->withInput()->withErrors($validator)->with('title', 'Añadir enlace');		}	}    /**    * Extraer url de video de youtube    *    *    *    */	/**	 * Remove the specified resource from storage.	 *	 * @param $post	 * @return Response	 */	public function postDelete($entrada)	{		// Declare the rules for the form validation		$rules = array(				'id' => 'required|integer'		);			// Validate the inputs		$validator = Validator::make(Input::all(), $rules);			// Check if the form validates with success		if ($validator->passes())		{			$id = $entrada->id;			$entrada->delete();				// Was the entrada post deleted?			$entrada = Entrada::find($id);			if(empty($entrada))			{				// Redirect to the entrada posts management page				return Redirect::to('admin/entradas')->with('success', Lang::get('admin/entradas/messages.delete.success'));			}		}		// There was a problem deleting the entrada post		return Redirect::to('admin/entradas')->with('error', Lang::get('admin/entradas/messages.delete.error'));	}	public function getDeleteEnlace($enlace)	{		// titulo		$title = 'Borrar enlace';		// Show the page		return View::make('admin/enlaces/delete', compact('enlace', 'title'));	}	public function postDeleteEnlace($enlace)	{		$rules = array(			'id' => 'required|integer'		);		// Validate the inputs		$validator = Validator::make(Input::all(), $rules);		// Check if the form validates with success		if ($validator->passes()) {			$id = $enlace->id;			$enlace->delete();			// Was the entrada post deleted?			$enlace = Enlace::find($id);			if (empty($enlace)) {				// Redirect to the entrada posts management page				return Redirect::to('admin/enlaces')->with('success', Lang::get('admin/enlaces/messages.delete.success'));			}		}	}	public function getDataEnlace($entrada)	{		$urls = $entrada->urls;		$arrayUrl = array();		foreach($urls as $url){			$arrayUrl[] = $url->id;		}		$enlaces = Enlace::select(array('enlaces.id','enlaces.nombre', 'enlaces.url', 'enlaces.tipo'))->whereIn('id',$arrayUrl);		return Datatables::of($enlaces)			->add_column('actions', '<a href="{{{ URL::to(\'admin/enlace/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>                <a href="{{{ URL::to(\'admin/enlace/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>				')			->remove_column('id')			->make();	}		/**	 * Show a list of all the entrada posts formatted for Datatables.	 *	 * @return Datatables JSON	 */         public function getShare($entrada){		$urls = $entrada->urls;		$count = 0;		$array = array();        $title = Lang::get('admin/entradas/title.entry_management');        $entradas = $this->entrada;        foreach($urls as $url){			if($count<3){				if(Str::lower($url->tipo)=='jpg'){					$uploaded_media = Twitter::uploadMedia(['media' => File::get( public_path() . '/entradas/'.$url->url)]);                    //$picture =  URL::to('/entradas/'.$url->url);                    $picture =  File::get( public_path() . '/entradas/'.$url->url);					$array[] = $uploaded_media->media_id_string;				}			}		}		$tweet = ' '.$entrada->titulo.'  '.URL::to('entradas/'.$entrada->id.'/details/').' ';		if(empty($array))		{			Twitter::postTweet(['status' => $tweet]);		}		else		{			Twitter::postTweet(['status' => $tweet, 'media_ids' => $array]);		}        try {        $message = html_entity_decode(strip_tags($entrada->titulo)).':' ;        $message = $message.' '.URL::to('entradas/'.$entrada->id.'/details/');        Facebook::fqb()->setAccessToken('CAAZACWZCfQ2RsBAK3OcZBhG2ZC4ZA81FPHoa4aaiz3jf12RwvHMAZC5kMC56ZBZCcJx8Yloq6Gm7qh6PUeGt09b4SamoY0o8C7eRRjQX8laVlwO46USZCKmh94mytJStHv9mJ9UkCxW7qYnQGVkHgzmHLJ33lXOJgcid3d4OFMZC4VOCCbxw91uYKzln0EAxYKD4gZD');        $status_update = ['message' => $message];                $response = Facebook::fqb()->object('555097121201395/feed')->with($status_update)->post();        }catch (Exception $e){            $error = "No se ha podido compartir";            //die($e);            return View::make('admin/entradas/index', compact('entradas', 'title'))->with('error',$e);        }        // Show the page        return View::make('admin/entradas/index', compact('entradas', 'title'))->with('success','Compartido correctamente');;	} 	public function getData()	{		$entradas = Entrada::select(array('entradas.id', 'entradas.titulo', 'entradas.categoria', 'entradas.created_at'));			return Datatables::of($entradas)			->add_column('actions', '<a href="{{{ URL::to(\'admin/entradas/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>                <a href="{{{ URL::to(\'admin/enlace/\' . $id . \'/index\' ) }}}" class="btn btn-default btn-xs">{{{ Lang::get(\'button.video\') }}}</a>            	<a href="{{{ URL::to(\'admin/entradas/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>                <a href="{{{ URL::to(\'admin/entradas/\' . $id . \'/share\' ) }}}" class="btn btn-xs btn-primary">{{{ Lang::get(\'button.share\') }}}</a>				')		     ->remove_column('id')		     ->make();	}}