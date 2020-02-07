<?php

namespace App\Repositories\VH_Estados;
use Illuminate\Support\Facades\DB;

/**
 * .
 * User: Daniel Hernandez
 * Date: 02/10/2017
 * Time: 10:13 AM
 */
class VH_EstadoRepository
{



 /*---------------------------------------------------------------------------------------------
  //funcion para obtener todos los estados ingresados en el sistema
  ▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀*/

    public function getEstados()
    {
        try{

            $estados = DB::table('vh_estados')->get();

            return $estados;

        }catch(\Exception $e){

            return $e;
        }
    }

 /*-------------------------------------------------------------------------------------------------*/

























}