<?php
/**


 * Date: 02/03/2018
 * Time: 03:27 PM
 */



namespace App\Repositories\Tickets;
use DB;

class TicketMessengerRepository
{
    //metodo para poder guardar un mensaje
    public function save($mensaje)
    {
        try{

            $queryrun = $mensaje->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para encontrar los mensajes de un ticket
    public function getMensajesForTicket($id)
    {
        $mensajes = DB::table('tickets_messenger as tm')
                    ->join('users as u1','u1.id','=','tm.emisor')
                    ->select('tm.*','u1.nombre as nombreemisor','u1.apellido as apellidoemisor','u1.avatar as avatar')
                    ->where('tm.ticket_id',$id)
                    ->get();

        return $mensajes;
    }
}