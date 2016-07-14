<?php

use Illuminate\Filesystem\Filesystem;

class AdminHistoricoTutoriasController extends AdminController{

    protected $historico_tutoria;

    public function __construct(Historico_tutoria $historico_tutoria)
    {
        parent::__construct();
        $this->historico_tutoria = $historico_tutoria;
    }

    public function getIndex()
    {
        $title = 'Historico Tutorías';
        $tutorias = $this->historico_tutoria;
        return View::make('admin/historico/index', compact('tutorias', 'title'));
    }

    public function getData()
    {
        $historico = Historico_tutoria::select(array('id', 'nombre', 'email_emisor', 'email_receptor' , 'fecha_solicitud'));

        return Datatables::of($historico)
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/historico/\' . $id . \'/details\' ) }}}" class="btn btn-success btn-xs iframe" >Ver detalles</a>')
            ->remove_column('id')
            ->make();
    }

    public function getDetails($historico_tutorias)
    {
        return View::make('admin/historico/details', compact('historico_tutorias'));
    }


}