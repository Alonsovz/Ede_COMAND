<?php
/**
 * Created by PhpStorm.
 * User: DHernandez
 * Date: 5/7/2018
 * Time: 09:22
 */

namespace App\Repositories\Postes;

use DB;
use Session;

class PosteRepository
{
    //metodo para guardar una solicitud de poste
    public function save($solicitud)
    {
        try{

            $query = $solicitud->save();

            return $query;

        }catch(\Exception $e)
        {
            $query = $e->getMessage();

            return $query;
        }
    }
}