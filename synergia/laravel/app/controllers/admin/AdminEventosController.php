<?php

use Illuminate\Filesystem\Filesystem;

class AdminEventosController extends AdminController{

    /**

     * Post Model

     * @var Post

     */

    protected $evento;



    /**

     * Inject the models.

     * @param Post $post

     */

    public function __construct(Evento $evento)

    {

        parent::__construct();

        $this->evento = $evento;

    }



    /**

     * Show a list of all the entrada posts.

     *

     * @return View

     */

    public function getIndex()

    {

        // titulo

        $title = 'Eventos';



        // Grab all the entrada posts

        $eventos = $this->evento;



        // Show the page

        return View::make('admin/eventos/index', compact('eventos', 'title'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return Response

     */

    public function getCreate()

    {

        // titulo

        $title = Lang::get('admin/eventos/titulo.create_a_new_entry');





        // Show the page

        return View::make('admin/eventos/create_edit', compact('title'));

    }



    /**

     * Store a newly created resource in storage.

     *

     * @return Response

     */

    public function postCreate()

    {

        // Declare the rules for the form validation

        $rules = array(

            'titulo'   => 'required|min:3',
            'fechaInicio' => 'required|min:3',
            'fechaFin' => 'required|min:3'

        );



        // Validate the inputs

        $validator = Validator::make(Input::all(), $rules);



        // Check if the form validates with success

        if ($validator->passes())

        {

            // Create a new entrada post

            $user = Auth::user();



            // Update the entrada post data

            $this->evento->titulo            = Input::get('titulo');



            $this->evento->contenido         	= Input::get('contenido');

            $this->evento->fecha_inicio	       = Input::get('fechaInicio');

            $this->evento->fecha_fin	   	   = Input::get('fechaFin');

            $this->evento->user_id			   = $user->id;



            // Was the entrada post created?

            if($this->evento->save())

            {

                // Redirect to the new entrada post page

                return Redirect::to('admin/eventos/' . $this->evento->id . '/edit')->with('success', Lang::get('admin/entradas/messages.create.success'));

            }



            // Redirect to the entrada post create page

            return Redirect::to('admin/eventos/create')->with('error', Lang::get('admin/entradas/messages.create.error'));

        }



        // Form validation failed

        return Redirect::to('admin/eventos/create')->withInput()->withErrors($validator);

    }



    /**

     * Display the specified resource.

     *

     * @param $post

     * @return Response

     */

    public function getShow($evento)

    {

        // redirect to the frontend

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param $post

     * @return Response

     */

    public function getEdit($evento)

    {

        // titulo

        $title = 'Eventos';


        // Show the page

        return View::make('admin/eventos/create_edit', compact('evento', 'title'));

    }



    public function getDetails($date)

    {

        // titulo
        $dateTitle = new DateTime($date);
        $title = 'Eventos en '.$dateTitle->format('d-m-Y');
        $eventos = Evento::where('fecha_inicio','>=',$date)->where('fecha_fin','<=',$date)->get();

        // Show the page

        return View::make('admin/eventos/details', compact('eventos','title'));

    }



    /**

     * Update the specified resource in storage.

     *

     * @param $post

     * @return Response

     */

    public function postEdit($evento)

    {



        // Declare the rules for the form validation

        $rules = array(

            'titulo'   => 'required|min:3',
            'fechaInicio' => 'required|min:3',
            'fechaFin' => 'required|min:3'

        );



        // Validate the inputs

        $validator = Validator::make(Input::all(), $rules);



        // Check if the form validates with success

        if ($validator->passes())

        {

            // Update the entrada post data

            $evento->titulo            = Input::get('titulo');


            $evento->contenido         = Input::get('contenido');

            $evento->fecha_inicio	   = Input::get('fechaInicio');
            $evento->fecha_fin	   	   = Input::get('fechaFin');


            // Was the entrada post updated?

            if($evento->save())

            {

                // Redirect to the new entrada post page

                return Redirect::to('admin/eventos/' . $evento->id . '/edit')->with('success', Lang::get('admin/entradas/messages.update.success'));

            }



            // Redirect to the entradas post management page

            return Redirect::to('admin/eventos/' . $evento->id . '/edit')->with('error', Lang::get('admin/entradas/messages.update.error'));

        }



        // Form validation failed

        return Redirect::to('admin/eventos/' . $evento->id . '/edit')->withInput()->withErrors($validator);

    }





    /**

     * Remove the specified resource from storage.

     *

     * @param $post

     * @return Response

     */

    public function getDelete($evento)

    {

        // titulo

        $title = 'Borrar evento';



        // Show the page

        return View::make('admin/eventos/delete', compact('evento', 'title'));

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param $post

     * @return Response

     */

    public function postDelete($evento)

    {

        // Declare the rules for the form validation

        $rules = array(

            'id' => 'required|integer'

        );



        // Validate the inputs

        $validator = Validator::make(Input::all(), $rules);



        // Check if the form validates with success

        if ($validator->passes())

        {

            $id = $evento->id;

            $evento->delete();



            // Was the entrada post deleted?

            $evento = Evento::find($id);

            if(empty($evento))

            {

                // Redirect to the entrada posts management page

                return Redirect::to('admin/eventos')->with('success', Lang::get('admin/entradas/messages.delete.success'));

            }

        }

        // There was a problem deleting the entrada post

        return Redirect::to('admin/eventos')->with('error', Lang::get('admin/entradas/messages.delete.error'));

    }



    /**

     * Show a list of all the entrada posts formatted for Datatables.

     *

     * @return Datatables JSON

     */

    public function getData()

    {

        $entradas = Evento::select(array('eventos.id', 'eventos.titulo', 'eventos.fecha_inicio', 'eventos.fecha_fin'));



        return Datatables::of($entradas)



            ->add_column('actions', '<a href="{{{ URL::to(\'admin/eventos/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>

                          	<a href="{{{ URL::to(\'admin/eventos/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>

				')



            ->remove_column('id')



            ->make();

    }

}// Show the page		return View::make('admin/eventos/index', compact('eventos', 'title'));	}		/**	 * Show the form for creating a new resource.	 *	 * @return Response	 */	public function getCreate()	{		// titulo		$title = Lang::get('admin/eventos/titulo.create_a_new_entry');					// Show the page		return View::make('admin/eventos/create_edit', compact('title'));	}		/**	 * Store a newly created resource in storage.	 *	 * @return Response	 */	public function postCreate()	{		// Declare the rules for the form validation		$rules = array(			'titulo'   => 'required|min:3',			'fechaInicio' => 'required|min:3',			'fechaFin' => 'required|min:3'		);			// Validate the inputs		$validator = Validator::make(Input::all(), $rules);			// Check if the form validates with success		if ($validator->passes())		{			// Create a new entrada post			$user = Auth::user();				// Update the entrada post data			$this->evento->titulo            = Input::get('titulo');			$this->evento->contenido         	= Input::get('contenido');			$this->evento->fecha_inicio	       = Input::get('fechaInicio');			$this->evento->fecha_fin	   	   = Input::get('fechaFin');			$this->evento->user_id			   = $user->id;				// Was the entrada post created?			if($this->evento->save())			{				// Redirect to the new entrada post page				return Redirect::to('admin/eventos/' . $this->evento->id . '/edit')->with('success', Lang::get('admin/entradas/messages.create.success'));			}				// Redirect to the entrada post create page			return Redirect::to('admin/eventos/create')->with('error', Lang::get('admin/entradas/messages.create.error'));		}			// Form validation failed		return Redirect::to('admin/eventos/create')->withInput()->withErrors($validator);	}		/**	 * Display the specified resource.	 *	 * @param $post	 * @return Response	 */	public function getShow($evento)	{		// redirect to the frontend	}		/**	 * Show the form for editing the specified resource.	 *	 * @param $post	 * @return Response	 */	public function getEdit($evento)	{		// titulo		$title = 'Eventos';		// Show the page		return View::make('admin/eventos/create_edit', compact('evento', 'title'));	}	public function getDetails($evento)	{		// titulo		$title = 'Evento';		// Show the page		return View::make('admin/eventos/details', compact('evento','title'));	}		/**	 * Update the specified resource in storage.	 *	 * @param $post	 * @return Response	 */	public function postEdit($evento)	{			// Declare the rules for the form validation		$rules = array(				'titulo'   => 'required|min:3',				'fechaInicio' => 'required|min:3',				'fechaFin' => 'required|min:3'		);			// Validate the inputs		$validator = Validator::make(Input::all(), $rules);			// Check if the form validates with success		if ($validator->passes())		{			// Update the entrada post data			$evento->titulo            = Input::get('titulo');			$evento->contenido         = Input::get('contenido');			$evento->fecha_inicio	   = Input::get('fechaInicio');			$evento->fecha_fin	   	   = Input::get('fechaFin');				// Was the entrada post updated?			if($evento->save())			{				// Redirect to the new entrada post page				return Redirect::to('admin/eventos/' . $evento->id . '/edit')->with('success', Lang::get('admin/entradas/messages.update.success'));			}				// Redirect to the entradas post management page			return Redirect::to('admin/eventos/' . $evento->id . '/edit')->with('error', Lang::get('admin/entradas/messages.update.error'));		}			// Form validation failed		return Redirect::to('admin/eventos/' . $evento->id . '/edit')->withInput()->withErrors($validator);	}			/**	 * Remove the specified resource from storage.	 *	 * @param $post	 * @return Response	 */	public function getDelete($evento)	{		// titulo		$title = 'Borrar evento';			// Show the page		return View::make('admin/eventos/delete', compact('evento', 'title'));	}		/**	 * Remove the specified resource from storage.	 *	 * @param $post	 * @return Response	 */	public function postDelete($evento)	{		// Declare the rules for the form validation		$rules = array(				'id' => 'required|integer'		);			// Validate the inputs		$validator = Validator::make(Input::all(), $rules);			// Check if the form validates with success		if ($validator->passes())		{			$id = $evento->id;			$evento->delete();				// Was the entrada post deleted?			$evento = Evento::find($id);			if(empty($evento))			{				// Redirect to the entrada posts management page				return Redirect::to('admin/eventos')->with('success', Lang::get('admin/entradas/messages.delete.success'));			}		}		// There was a problem deleting the entrada post		return Redirect::to('admin/eventos')->with('error', Lang::get('admin/entradas/messages.delete.error'));	}		/**	 * Show a list of all the entrada posts formatted for Datatables.	 *	 * @return Datatables JSON	 */	public function getData()	{		$entradas = Evento::select(array('eventos.id', 'eventos.titulo', 'eventos.fecha_inicio', 'eventos.fecha_fin'));			return Datatables::of($entradas)			->add_column('actions', '<a href="{{{ URL::to(\'admin/eventos/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>                          	<a href="{{{ URL::to(\'admin/eventos/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>				')		     ->remove_column('id')		     ->make();	}}