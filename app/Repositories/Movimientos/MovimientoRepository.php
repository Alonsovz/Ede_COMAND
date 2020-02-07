<?php
/**

 * User: Daniel Hernandez
 * Date: 21/12/2017
 * Time: 01:17 PM
 */

namespace App\Repositories\Movimientos;


class MovimientoRepository
{
    //funcion para registrar un movimiento
    public function saveMovimiento($movimiento)
    {
        try{

            $queryrun = $movimiento->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



}