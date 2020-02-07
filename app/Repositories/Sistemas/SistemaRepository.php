<?php
/**

 * User: Daniel Hernandez
 * Date: 08/11/2017
 * Time: 02:11 PM
 */

namespace App\Repositories\Sistemas;

use App\Sistema;
use DB;
use Dompdf\Exception;

class SistemaRepository
{



    //funcion para obtener todos los sitemas del sistema de la base de datos
    public function getSistemas()
    {
        try{

            $sistemas = DB::table('sistemas')->orderBy('sistemas.nombre','asc')->get();

            return $sistemas;

        }catch(\Exception $e )
        {
            return $e->getMessage();
        }
    }



    //metodo para guardar un sistema
    public function save($sistema)
    {
        try{

            $queryrun = $sistema->save();

            return $queryrun;

        }catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }




    //busqueda de un sistema por su id
    public function getSistemaByID($id)
    {
        try{

            $sistema = DB::table('sistemas')->where('id',$id)->orderBy('sistemas.nombre','asc')->get();

            return $sistema;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para poder actualizar un sistema
    public function update($sistema)
    {
        try{

            $queryrun = $sistema->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para poder encontrar un sistema por eloquent y su id
    public function getSistemaByIDELOQUENT($id)
    {
        try{

            $sistema = Sistema::find($id);

            return $sistema;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

}