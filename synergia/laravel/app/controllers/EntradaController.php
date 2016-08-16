<?php

class EntradaController extends \BaseController {

    /*

    |--------------------------------------------------------------------------

    | FUNCIONES PÚBLICAS DEL CONTROLADOR DE ENTRADAS.

    |--------------------------------------------------------------------------

    */

    // <-- Función que muestra una entrada CONCRETA -->

    public function getEntradaConcreta($anyo, $mes, $dia, $categoria, $titulo){

        $entrada    =  Entrada::whereRaw('\''.$this->formarDate($anyo, $mes, $dia).'\''.' = '.'DATE_FORMAT(created_at, \'%Y-%m-%d\')')
            ->where('categoria', $categoria)
            ->where('titulo', $this->formatearTitulo($titulo))
            ->first();

        $this->existenEntradas($entrada);

        $cadena     =   '<ul>';
        $cadena     .=  '<li>'.$entrada->titulo.'</li>';
        $cadena     .=  '<li>'.$entrada->subtitulo.'</li>';
        $cadena     .=  '<li>'.$entrada->categoria.'</li>';
        $cadena     .=  '<li>'.$entrada->created_at.'</li>';
        $cadena     .=  '<li>'.$entrada->updated_at.'</li>';
        $cadena     .=  '</ul>';

        return $cadena;
    }

    // </-- FIN -->

    // <-- Funciones que muestran entradas por DIA o DIA Y CATEGORIA -->

    public function getEntradasPorDia($anyo, $mes, $dia){

        $entradas   =   Entrada::whereRaw('\''.$this->formarDate($anyo, $mes, $dia).'\''.' = '.'DATE_FORMAT(created_at, \'%Y-%m-%d\')')
            ->get();

        $this->existenEntradas($entradas);

        return $this->listarEntradasParaTesteo($entradas);
    }

    public function getEntradasPorDiaCategoria($anyo, $mes, $dia, $categoria){

        $entradas   =   Entrada::whereRaw('\''.$this->formarDate($anyo, $mes, $dia).'\''.' = '.'DATE_FORMAT(created_at, \'%Y-%m-%d\')')
            ->where('categoria', $categoria)
            ->get();

        $this->existenEntradas($entradas);

        return $this->listarEntradasParaTesteo($entradas);
    }

    // </-- FIN -->

    // <-- Funciones que muestran entradas por MES o MES Y CATEGORIA -->

    public function getEntradasPorMes($anyo, $mes){
        $entradas   =   Entrada::whereRaw('\''.$this->formarDate($anyo, $mes).'\''.' = '.'DATE_FORMAT(created_at, \'%Y-%m\')')
            ->get();

        $this->existenEntradas($entradas);

        return $this->listarEntradasParaTesteo($entradas);
    }

    public function getEntradasPorMesCategoria($anyo, $mes, $categoria){
        $entradas   =   Entrada::whereRaw('\''.$this->formarDate($anyo, $mes).'\''.' = '.'DATE_FORMAT(created_at, \'%Y-%m\')')
            ->where('categoria', $categoria)
            ->get();

        $this->existenEntradas($entradas);

        return $this->listarEntradasParaTesteo($entradas);
    }

    // </-- FIN -->

    // <-- Funciones que muestran entradas por AÑO o AÑO Y CATEGORIA -->

    public function getEntradasPorAnyo($anyo){
        $entradas   =   Entrada::whereRaw('\''.$this->formarDate($anyo).'\''.' = '.'DATE_FORMAT(created_at, \'%Y\')')
            ->get();

        $this->existenEntradas($entradas);

        return $this->listarEntradasParaTesteo($entradas);
    }

    public function getEntradasPorAnyoCategoria($anyo, $categoria){
        $entradas   =   Entrada::whereRaw('\''.$this->formarDate($anyo).'\''.' = '.'DATE_FORMAT(created_at, \'%Y\')')
            ->where('categoria', $categoria)
            ->get();

        $this->existenEntradas($entradas);

        return $this->listarEntradasParaTesteo($entradas);
    }

    // </-- FIN -->


    /*

    |--------------------------------------------------------------------------

    | FUNCIONES PRIVADAS DEL CONTROLADOR DE ENTRADAS.

    |--------------------------------------------------------------------------

    */

    // Forma una fecha a través de los parámetros día, mes y año de una URL.

    private function formarDate($anyo, $mes = null, $dia = null){

        $fecha  =   $anyo;

        if($mes != null){
            $fecha.=    '-'.$mes;

            if($dia != null){
                $fecha.=    '-'.$dia;
            }
        }

        return $fecha;
    }

    // Remplaza los guiones por espacios para buscar la entrada en la Base de Datos.

    private function formatearTitulo($titulo){

        return str_replace('-', ' ', $titulo);
    }

    // Devuelve una cadena formateada de las entradas consultadas. ESTA FUNCIÓN ES SOLO PARA TESTEO. SUSTITUIR EN CADA PUBLIC FUNCTION POR UNA VIEW O VARIAS VIEWS.

    private function listarEntradasParaTesteo($entradas){

        $cadena = '<ul>';

        foreach($entradas as $entrada){
            $cadena     .=  '<li>====================================</li>';
            $cadena     .=  '<li>'.$entrada->titulo.'</li>';
            $cadena     .=  '<li>'.$entrada->subtitulo.'</li>';
            $cadena     .=  '<li>'.$entrada->categoria.'</li>';
            $cadena     .=  '<li>'.$entrada->created_at.'</li>';
            $cadena     .=  '<li>'.$entrada->updated_at.'</li>';
            $cadena     .=  '<li>====================================</li>';
        }

        $cadena .= '</ul>';

        return $cadena;
    }

    private function existenEntradas($entradas){
        if($entradas == null || $entradas->count() == 0)
            return App::abort(404);
    }

}
