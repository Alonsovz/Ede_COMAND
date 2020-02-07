<?php
/**

 * User: Daniel Hernandez
 * Date: 14/11/2017
 * Time: 01:43 PM
 */

namespace App\Repositories\Bitacoras;
use DB;
use App\Bitacora;



class BitacoraRepository
{


    //funcion para obtener las bitacoras de un determinado ticket
    public function getBitacorasById($id)
    {
        try{

            $bitacora = DB::table('bitacoras')->where('ticket_id',$id)->get();

            return $bitacora;

        }catch(\Exception $e)
        {
            return $e->getMessage();

        }
    }





    //funcion para guardar una nueva bitacora
    public function saveBitacora($bitacora)
    {
        try{

            $queryrun = $bitacora->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();

        }
    }




    //funcion para obtener bitacoras de un usuario
    public function getBitacorasByStaff($id)
    {
        try{

            $bitacora = DB::table('bitacoras')->where('user_id',$id)->get();

            return $bitacora;

        }catch(\Exception $e)
        {
            return $e->getMessage();

        }
    }


    //buscar las lineas de bitacora por id de ticket
    public function getLineasByTicket($ticket)
    {
        try{

            $bitacoras = DB::table('bitacoras')->where('bitacoras.ticket_id',$ticket)->orderBy('bitacoras.fechabitacora','ASC')->get();


            return $bitacoras;

        }catch(\Exception $e)
        {
            return $e->getMessage();

        }
    }
}