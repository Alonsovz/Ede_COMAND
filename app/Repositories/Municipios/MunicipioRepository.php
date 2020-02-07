<?php
/**

 * User: Daniel Hernandez
 * Date: 11/01/2018
 * Time: 08:37 AM
 */

namespace App\Repositories\Municipios;
use DB;



class MunicipioRepository
{
    //funcion para listar municipios segun departamento
    public function getMunicipiosByDpto($departamento)
    {
        try{

            $municipios = DB::table('MUNSV')->where('DEPSV_ID',$departamento)->get();

            return $municipios;

        }catch(\Exception $e)
        {
            $e->getMessage();
        }
    }
}