<?php
/**

 * User: Daniel Hernandez
 * Date: 08/11/2017
 * Time: 02:31 PM
 */

namespace App\Repositories\Modulos;

use DB;


class ModuloRepository
{
    //funcion para obtener todos los modulos  de la base de datos
    public function getModulos()
    {
        try{

            $modulos = DB::table('modulos')
                ->join('sistemas','sistemas.id','=','modulos.sistema_id')
                ->select('modulos.*','sistemas.nombre as sistema')
                ->orderBy('modulos.nombre','asc')
                ->get();

            return $modulos;

        }catch(\Exception $e )
        {
            return $e->getMessage();
        }
    }





    //funcion para obtener los modulos a partir de un id
    public function getModulosById($id)
    {
        try{

            $modulos = DB::table('modulos')->where('sistema_id',$id)->orderBy('nombre','asc')->get();

            return $modulos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para guardar un modulo
    public function save($modulo)
    {
        try{

            $queryrun = $modulo->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
}