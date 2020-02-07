<?php
/**

 * User: Daniel Hernandez
 * Date: 20/11/2017
 * Time: 08:35 AM
 */

namespace App\Repositories\Categorias;

use DB;


class CategoriaRepository
{

    //funcion para poder listar las categorias
    public function getCategoriasAll()
    {
        try{

            $categorias = DB::table('categorias')->get();

            return $categorias;

        }catch(\Exception $e)
        {
           return $e->getMessage();
        }
    }
}