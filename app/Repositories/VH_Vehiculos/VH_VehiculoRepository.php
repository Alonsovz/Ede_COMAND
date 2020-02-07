<?php
/**
 * Created by PhpStorm.
 * User: Daniel Hernandez
 * Date: 02/10/2017
 * Time: 10:25 AM
 */

namespace App\Repositories\VH_Vehiculos;

use Illuminate\Support\Facades\DB;


class VH_VehiculoRepository
{

    /*---------------------------------------------------------------------------------------------
  //funcion para obtener todos los vehiculos ingresados en el sistema
  ▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀*/

    public function getVehiculos()
    {
        try{

            $vehiculos = DB::table('vh_vehiculos')->get();

            return $vehiculos;

        }catch(\Exception $e){

            return $e;
        }
    }

    /*▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀*/
}