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
        return View::make('admin/comentarios/index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */


    public function create()
	{
		//
        return Redirect::action('AdminComentariosController@index');
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

	 public function store()
	{
		//
        return Redirect::action('AdminComentariosController@index');
	}



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

        if($comentario === null)
            return Redirect::action('AdminComentariosController@index');

        $title          =   'Comentario';
        return View::make('admin/comentarios/show', compact('comentario', 'title'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	 public function edit($id)
	{
		//
        return Redirect::action('AdminComentariosController@index');
	}



	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function update($id)
	{
		//
        return Redirect::action('AdminComentariosController@index');
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
        Comentario::destroy($id);
	}

    public function getData(){

        $comentarios = Comentario::select(DB::raw('comentarios.id, comentarios.nombre, comentarios.email, concat(substr(comentarios.texto, 1, 20), "...") as texto, comentarios.publicado'));

        return Datatables::of($comentarios)

            ->edit_column('publicado',
                '@if($publicado == 1)
                    <input type="checkbox" name="comentarios[]" value="{{ $id }}" checked="checked"/>
                @else
                    <input type="checkbox" name="comentarios[]" value="{{ $id }}"/>
                @endif')

            ->add_column('actions',
                '<a href="{{{ URL::to(\'admin/comentarios/\' . $id ) }}}" class="btn btn-default btn-xs iframe" >Ver</a>
            	<a href="{{{ URL::to(\'admin/comentarios/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>'
            )

            ->remove_column('id')

            ->make();
    }

    public function getDelete($comentario){
        // titulo

        $title = 'Borrar un comentario';

        // Show the page

        return View::make('admin/comentarios/delete', compact('comentario', 'title'));
    }

    public function publicar(){
        if(Request::ajax()){
            $comentario =  Comentario::find(Input::get('comentario'));

            if($comentario === null){
                return 'error';
            }

            $comentario->publicado = Input::get('publicado');
            $comentario->save();

            return 'success';
        }
        else{
            return Redirect::action('AdminComentariosController@index');
        }
    }
}
