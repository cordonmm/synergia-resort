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
        //$comentarios = DB::table('comentarios')->get();

        return View::make('admin/comentarios/index');
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
        /*$comentarios = Reserva::select(array('comentarios.id', 'comentarios.nombre', 'comentarios.email', 'comentarios.texto'));

        return Datatables::of($reservas)

            ->add_column('actions',
                '<a href="{{{ URL::to(\'admin/reservas/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
            	<a href="{{{ URL::to(\'admin/reservas/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>'
            )

            ->remove_column('id')

            ->make();
        */
    }


}
