<?php
/**
 * Created by PhpStorm.
 * User: DHernandez
 * Date: 4/5/2018
 * Time: 08:35
 */

namespace App\Repositories\ControlOfertas;


class ControlOfertasRepository
{
    //metodo para poder guardar una oferta presentada
    public function saveOferta($oferta)
    {
        try{

            $queryrun = $oferta->save();
            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
}