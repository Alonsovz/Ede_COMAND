<?php
/**

 * User: Daniel Hernandez
 * Date: 20/11/2017
 * Time: 08:43 AM
 */

namespace App\Repositories\Estados;

use DB;

class EstadoRepository
{


    //funcion para obtener todos los estados del sistema almacenados en la db
    public function getEstadosAll()
    {
        try{

            $estados = DB::table('estados')->get();

            return $estados;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
}