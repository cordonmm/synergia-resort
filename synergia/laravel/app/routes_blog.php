<?php

/*
 * ¡¡¡SI HACES SEED HABRÁ QUE ACTUALIZAR LOS PARÁMETROS DE FECHA DE LAS URL DE EJEMPLOS PARA QUE TE ENCUENTRE ENTRADAS!!!
 * Testeo rutas amigables para blog.
 * */


/*
 * LISTA UNA SOLA ENTRADA.
 * Ejemplo: http://localhost/synergia/Blog/2016/08/16/noticias/Lorem-ipsum-dolor-sit-amet
 * */

Route::get('Blog/{anyo}/{mes}/{dia}/{categoria}/{titulo}', 'EntradaController@getEntradaConcreta')
    ->where(array('anyo' => '[0-9]{4}', 'mes' => '[0-9]{2}', 'dia' => '[0-9]{2}', 'categoria' => '[a-zA-Z]+', 'titulo' => '[\-a-zA-Z]+'));




/*
 * LISTA VARIAS ENTRADAS DE UNA CATEGORÍA PARA UN DÍA CONCRETO.
 * Ejemplo: http://localhost/synergia/Blog/2016/08/16/noticias
 * */

Route::get('Blog/{anyo}/{mes}/{dia}/{categoria}', 'EntradaController@getEntradasPorDiaCategoria')
    ->where(array('anyo' => '[0-9]{4}', 'mes' => '[0-9]{2}', 'dia' => '[0-9]{2}', 'categoria' => '[a-zA-Z]+'));



/*
 * LISTA VARIAS ENTRADAS PARA UN DÍA CONCRETO.
 * Ejemplo: http://localhost/synergia/Blog/2016/08/16
 * */

Route::get('Blog/{anyo}/{mes}/{dia}', 'EntradaController@getEntradasPorDia')
    ->where(array('anyo' => '[0-9]{4}', 'mes' => '[0-9]{2}', 'dia' => '[0-9]{2}'));



/*
 * LISTA VARIAS ENTRADAS DE UNA CATEGORIA PARA UN MES CONCRETO.
 * Ejemplo: http://localhost/synergia/Blog/2016/08/noticias
 * */

Route::get('Blog/{anyo}/{mes}/{categoria}', 'EntradaController@getEntradasPorMesCategoria')
    ->where(array('anyo' => '[0-9]{4}', 'mes' => '[0-9]{2}', 'categoria' => '[a-zA-Z]+'));



/*
 * LISTA VARIAS ENTRADAS PARA UN MES CONCRETO.
 * Ejemplo: http://localhost/synergia/Blog/2016/08
 * */

Route::get('Blog/{anyo}/{mes}', 'EntradaController@getEntradasPorMes')
    ->where(array('anyo' => '[0-9]{4}', 'mes' => '[0-9]{2}'));



/*
 * LISTA VARIAS ENTRADAS DE UNA CATEGORIA PARA UN AÑO CONCRETO.
 * Ejemplo: http://localhost/synergia/Blog/2016/noticias
 * */

Route::get('Blog/{anyo}/{categoria}', 'EntradaController@getEntradasPorAnyoCategoria')
    ->where(array('anyo' => '[0-9]{4}', 'categoria' => '[a-zA-Z]+'));



/*
 * LISTA VARIAS ENTRADAS PARA UN AÑO CONCRETO.
 * Ejemplo: http://localhost/synergia/Blog/2016
 * */

Route::get('Blog/{anyo}', 'EntradaController@getEntradasPorAnyo')
    ->where(array('anyo' => '[0-9]{4}'));