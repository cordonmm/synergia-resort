<?php

class AdminComentariosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        $comentarios = DB::table('comentarios')->get();
        return View::make('admin/comentarios/index', compact('comentarios'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */

	/*
	 * public function create()
	{
		//
	}
	*/


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	/*
	 *
	 *public function store()
	{
		//
	}
	*/


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
        $comentario     =   Comentario::find($id);
        $title          =   'Comentario';
        return View::make('admin/comentarios/show', compact('comentario', 'title'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	/*
	 *
	 public function edit($id)
	{
		//
	}
	*/


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function getData(){

        /*$primer_consulta = Ur::select(DB::raw('substr(cod_ur, 1, 4)'))
            ->where('id', '=', $id)
            ->get();*/

        //$comentarios = Comentario::select(array('comentarios.id', 'comentarios.nombre', 'comentarios.email', 'comentarios.texto', 'comentarios.email', 'comentarios.publicado'));


        /*return Datatables::of($comentarios)

            ->add_column('actions',
                '<a href="{{{ URL::to(\'admin/comentarios/\' . $id ) }}}" class="btn btn-default btn-xs iframe" >Ver</a>
            	<a href="{{{ URL::to(\'admin/comentarios/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>'
            )

            ->remove_column('id')

            ->make();*/
    }



}
