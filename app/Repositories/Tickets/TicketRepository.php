<?php
/**

 * User: Daniel Hernandez
 * Date: 09/11/2017
 * Time: 09:52 AM
 */

namespace App\Repositories\Tickets;

use App\Ticket;
use DB;
use Dompdf\Exception;


class TicketRepository
{


    //funcion para ingresar un nuevo ticket
    public function saveTicket($ticket)
    {
        try {

            $runquery = $ticket->save();

            if($runquery==true)
            {
                return "success";
            }
            else
            {
                return "error";
            }


        }catch (\Exception $e)
        {
            return $e->getMessage();
        }

    }


    //obtener datos de ticket reasignado
    public function getTicketReasignado($ticket)
    {
        $ticket = DB::table('tickets')
            ->leftjoin('users as u1','u1.id','=','tickets.us_solicitante')
            ->leftjoin('users as u2','u2.id','=','tickets.us_asignado')
            ->leftjoin('estados','estados.id','=','tickets.estado_id')
            ->leftjoin('categorias','categorias.id','=','tickets.categoria_id')
            ->leftjoin('sistemas','sistemas.id','=','tickets.sistema_id')
            ->leftjoin('modulos','modulos.id','=','tickets.modulo_id')
            ->select('tickets.*',
                'u1.nombre as nombresolicitante',
                'u1.apellido as apellidosolicitante',
                'u1.correo as correosolicitante',
                'u2.nombre as nombreasignado',
                'u2.apellido as apellidoasignado',
                'u2.correo as correoasignado',
                'estados.nombre as estado',
                'categorias.nombre as categoria',
                'sistemas.nombre as sistema',
                'modulos.nombre as modulo'
            )
            ->where('tickets.id',$ticket)
            ->orderBy('id','desc')
            ->first();

        return $ticket;
    }


    //funcion para el conteo de los tickets ingresados por un usuario NOSTAFF
    public function conteoTicketsNoStaff($id)
    {
        try{

            $conteo = DB::table('tickets')->where('us_solicitante',$id)->count();

            return $conteo;

        }catch(\Exception $e)
        {

        }
    }




    //funcion para obtener todos los ticket solicitados por un usuarios NS
    public function getTicketsNoStaff($id)
    {
        try{

            $tickets = $tickets = DB::table('tickets')
                ->leftjoin('users as u1','u1.id','=','tickets.us_asignado')
                ->leftjoin('users as u2','u2.id','=','tickets.us_solicitante')
                ->leftjoin('estados','estados.id','=','tickets.estado_id')
                ->leftjoin('categorias','categorias.id','=','tickets.categoria_id')
                ->leftjoin('sistemas','sistemas.id','=','tickets.sistema_id')
                ->leftjoin('modulos','modulos.id','=','tickets.modulo_id')
                ->select('tickets.*',
                    'u1.nombre as nombreasignado',
                    'u1.apellido as apellidoasignado',
                    'estados.nombre as estado',
                    'categorias.nombre as categoria',
                    'sistemas.nombre as sistema',
                    'modulos.nombre as modulo'
                )

                ->where('tickets.us_solicitante',$id)
                ->orderBy('tickets.id','desc')
                ->get();

            return $tickets;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }




    //obtener un ticket por medio de su id para la edicion
    public function getTicketById($id)
    {
        try{

            $tickets = DB::table('tickets')
                ->leftjoin('users','users.id','=','tickets.us_asignado')
                ->leftjoin('users as u','u.id','=','tickets.us_solicitante')
                ->leftjoin('estados','estados.id','=','tickets.estado_id')
                ->leftjoin('categorias','categorias.id','=','tickets.categoria_id')
                ->leftjoin('sistemas','sistemas.id','=','tickets.sistema_id')
                ->leftjoin('modulos','modulos.id','=','tickets.modulo_id')
                ->select('tickets.*',
                    'users.nombre',
                    'users.apellido',
                    'u.nombre as nombresolicitante',
                    'u.apellido as apellidosolicitante',
                    'estados.nombre as estado',
                    'categorias.nombre as categoria',
                    'sistemas.nombre as sistema',
                    'modulos.nombre as modulo'
                )
                ->where('tickets.id',$id)
                ->first();

            return $tickets;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }





    //funcion para consultar el ultimo ticket ingresado
    public function getLastTicket()
    {
        try{

            $ticket = DB::table('tickets')
                ->leftjoin('users as u1','u1.id','=','tickets.us_solicitante')
                ->leftjoin('users as u2','u2.id','=','tickets.us_asignado')
                ->leftjoin('estados','estados.id','=','tickets.estado_id')
                ->leftjoin('categorias','categorias.id','=','tickets.categoria_id')
                ->leftjoin('sistemas','sistemas.id','=','tickets.sistema_id')
                ->leftjoin('modulos','modulos.id','=','tickets.modulo_id')
                ->select('tickets.*',
                    'u1.nombre as nombresolicitante',
                    'u1.apellido as apellidosolicitante',
                    'u1.correo as correosolicitante',
                    'u2.nombre as nombreasignado',
                    'u2.apellido as apellidoasignado',
                    'u2.correo as correoasignado',
                    'estados.nombre as estado',
                    'categorias.nombre as categoria',
                    'sistemas.nombre as sistema',
                    'modulos.nombre as modulo'
                )
                ->orderBy('id','desc')
                ->first();

            if($ticket!='')
            {
                return $ticket;
            }
            else
            {
                return "error";
            }

            return $conteo;

        }catch(\Exception $e)
        {

        }
    }




    //funcion para listar todos los tickets de STAFF
    public function getTicketsStaff($id)
    {
        try{

            $tickets = $tickets = DB::table('tickets')
                ->leftjoin('users','users.id','=','tickets.us_solicitante')
                ->leftjoin('users as users1','users1.id','=','tickets.us_asignado')
                ->leftjoin('estados','estados.id','=','tickets.estado_id')
                ->leftjoin('categorias','categorias.id','=','tickets.categoria_id')
                ->leftjoin('sistemas','sistemas.id','=','tickets.sistema_id')
                ->leftjoin('CRM_eventos as eventos','eventos.id','=','tickets.evento_id')
                ->leftjoin('modulos','modulos.id','=','tickets.modulo_id')
                ->select('tickets.*',
                    'eventos.cliente as cliente',
                    'users.nombre as nombresolicitante',
                    'users.apellido as apellidosolicitante',
                    'users1.apellido as apellidoasignado',
                    'users1.nombre as nombreasignado',
                    'estados.nombre as estado',
                    'categorias.nombre as categoria',
                    'sistemas.nombre as sistema',
                    'modulos.nombre as modulo'
                )

                ->where('tickets.us_asignado',$id)
                ->where('tickets.categoria_id','!=',10)
                ->orderBy('tickets.id','desc')
                ->get();

            return $tickets;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //tickets compartidos
    public function getTicketsCompartidos($usuario)
    {
        try{

            $tickets = $tickets = DB::table('tickets')
                ->leftjoin('users','users.id','=','tickets.us_solicitante')
                ->leftjoin('users as users1','users1.id','=','tickets.us_asignado')
                ->leftjoin('estados','estados.id','=','tickets.estado_id')
                ->leftjoin('categorias','categorias.id','=','tickets.categoria_id')
                ->leftjoin('sistemas','sistemas.id','=','tickets.sistema_id')
                ->leftjoin('CRM_eventos as eventos','eventos.id','=','tickets.evento_id')
                ->leftjoin('modulos','modulos.id','=','tickets.modulo_id')
                ->select('tickets.*',
                    'eventos.cliente as cliente',
                    'users.nombre as nombresolicitante',
                    'users.apellido as apellidosolicitante',
                    'users1.apellido as apellidoasignado',
                    'users1.nombre as nombreasignado',
                    'estados.nombre as estado',
                    'categorias.nombre as categoria',
                    'sistemas.nombre as sistema',
                    'modulos.nombre as modulo'
                )

                ->where('tickets.usuario_compartido',$usuario)
                ->orderBy('tickets.id','desc')
                ->get();

            return $tickets;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para la busqueda de un ticket por ID
    public function findTicketById($id)
    {
        try{

            $tickets = $tickets = DB::table('tickets')
                ->leftjoin('users','users.id','=','tickets.us_solicitante')
                ->leftjoin('estados','estados.id','=','tickets.estado_id')
                ->leftjoin('categorias','categorias.id','=','tickets.categoria_id')
                ->leftjoin('sistemas','sistemas.id','=','tickets.sistema_id')
                ->leftjoin('modulos','modulos.id','=','tickets.modulo_id')
                ->select('tickets.*',
                    'users.nombre',
                    'users.apellido',
                    'estados.nombre as estado',
                    'categorias.nombre as categoria',
                    'sistemas.nombre as sistema',
                    'modulos.nombre as modulo'
                )

                ->where('tickets.id',$id)
                ->orderBy('tickets.id','desc')
                ->first();

            return $tickets;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para la busqueda de un ticket por ID
    public function findTicketByEloquent($id)
    {
        try{

            $ticket = Ticket::find($id);

            return $ticket;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }




    //funcion para actualizar los campos del ticket
    public function updateTicket($ticket)
    {
        try{

            $queryrun = $ticket->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //obtener tickets completos
    public function getTicketsCompletos($id)
    {
        try{

            $tickets = $tickets = DB::table('tickets')
                ->leftjoin('users','users.id','=','tickets.us_solicitante')
                ->leftjoin('estados','estados.id','=','tickets.estado_id')
                ->leftjoin('categorias','categorias.id','=','tickets.categoria_id')
                ->leftjoin('sistemas','sistemas.id','=','tickets.sistema_id')
                ->leftjoin('modulos','modulos.id','=','tickets.modulo_id')
                ->select('tickets.*',
                    'users.nombre',
                    'users.apellido',
                    'estados.nombre as estado',
                    'categorias.nombre as categoria',
                    'sistemas.nombre as sistema',
                    'modulos.nombre as modulo'
                )
                ->where('tickets.us_asignado',$id)
                ->get();

            return $tickets;


        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }




    //conteo de tickets recibidos por staff
    public function conteoTicketsStaff($id)
    {
        try{

            $conteo = DB::table('tickets')->where('us_asignado',$id)->where('tickets.estado_id',2)->count();

            return $conteo;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //listar tickets para supervisar tickets
    public function getTicketsForSupervision($jefe)
    {
        try{

           $tickets = DB::table('tickets')
               ->leftjoin('users','users.id','=','tickets.us_solicitante')
               ->leftjoin('users as u1','u1.id','=','tickets.us_asignado')
               ->leftjoin('estados','estados.id','=','tickets.estado_id')
               ->leftjoin('categorias','categorias.id','=','tickets.categoria_id')
               ->leftjoin('sistemas','sistemas.id','=','tickets.sistema_id')
               ->leftjoin('modulos','modulos.id','=','tickets.modulo_id')
               ->select('tickets.*',
                   'users.nombre as nombresolicitante',
                   'users.apellido as apellidosolicitante',
                   'estados.nombre as estado',
                   'categorias.nombre as categoria',
                   'sistemas.nombre as sistema',
                   'modulos.nombre as modulo','u1.nombre as nombreasignado','u1.apellido as apellidoasignado'
               )->where('u1.jefe_inmediato',$jefe)
               ->orderBy('tickets.id','desc')
               ->get();


            return $tickets;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para query de reporte de detalle de tickets de informatica
    public function rpt_querydetalleticketsinfo($desde, $hasta)
    {
        $desde1 = $desde;
        $desde2 = $desde;
        $desde3 = $desde;

        $hasta1 = $hasta;
        $hasta2 = $hasta;
        $hasta3 = $hasta;

        try{

            $detalle = DB::select("SELECT c.nombre as categoria, COUNT(t.id) as recibidos,
                        --subquery para los solucionados
                        solucionados = (SELECT   COUNT(t.id)  FROM tickets t
                                        LEFT JOIN categorias c1 on t.categoria_id = c1.id
                                        WHERE t.fechasolicitud  >= ? AND t.fechasolicitud <=? AND (t.estado_id = 6 OR t.estado_id = 8)
                                        AND c1.nombre = c.nombre AND (t.us_asignado = 1 OR t.us_asignado = 2
                                          OR t.us_asignado = 3 OR t.us_asignado = 4)
                                        ),
                       --sub query para el tiempo dedicado
                        tiempo_dedicado = (SELECT SUM(b.tiempodedicado) FROM bitacoras b
                                           INNER JOIN tickets t ON b.ticket_id = t.id
                                           LEFT JOIN categorias c2 ON t.categoria_id = c2.id
                                           WHERE t.fechasolicitud  >=? AND t.fechasolicitud <=? AND c.id = c2.id
                                           AND (t.us_asignado = 1 OR t.us_asignado = 2
                                          OR t.us_asignado = 3 OR t.us_asignado = 4)
                                          )
                    FROM tickets t
              
                    INNER JOIN users u ON u.id = t.us_asignado
                    LEFT JOIN categorias c ON t.categoria_id = c.id
                    
                    WHERE t.fechasolicitud  >=? AND t.fechasolicitud <=? AND (t.us_asignado = 1 OR t.us_asignado = 2
                                          OR t.us_asignado = 3 OR t.us_asignado = 4)
                    GROUP BY c.nombre,c.id",[$desde1,$hasta1,$desde2,$hasta2,$desde3,$hasta3]);

            return $detalle;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion query para listar el detalle de las horas trabajadas por empleado
    public function getHorasTrabajadas($desde,$hasta)
    {
        try{

            $detalles = DB::select("SELECT u.nombre as nombre, u.apellido as apellido, SUM(b.tiempodedicado) as horas FROM bitacoras b
                        INNER JOIN tickets t ON b.ticket_id = t.id
                        INNER JOIN users u ON t.us_asignado = u.id
                        WHERE b.fechabitacora>=? and b.fechabitacora<=?
                        GROUP BY u.nombre,u.apellido
                        ORDER BY u.nombre
                         ",[$desde,$hasta]);





            return $detalles;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //generar reporte de horas registradas por sistema
    public function getHorasRegistradasXSistema($desde,$hasta)
    {
        try{

            $detalles = DB::select("SELECT s.nombre as sistema,SUM(b.tiempodedicado) as horas FROM bitacoras b
                        INNER JOIN tickets t ON b.ticket_id = t.id
                        INNER JOIN users u ON t.us_asignado = u.id
                        INNER JOIN sistemas s ON t.sistema_id = s.id
                        WHERE b.fechabitacora>=? and b.fechacreacion<=?
                        GROUP BY s.nombre
                        ORDER BY s.nombre
                         ",[$desde,$hasta]);


            return $detalles;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //obtener los tickets recibidos filtrado por fecha y por empleado
    public function getTicketsPorEmpleado($desde,$hasta)
    {
        $desde1 = $desde;
        $desde2 = $desde;
        $desde3 = $desde;
        $desde4 = $desde;
        $desde5 = $desde;


        $hasta1 = $hasta;
        $hasta2 = $hasta;
        $hasta3 = $hasta;
        $hasta4 = $hasta;
        $hasta5 = $hasta;


        try{

            $detalles = DB::select("SELECT u1.nombre,u1.apellido, COUNT(t.id) as conteo,

                                        requerimientos = (SELECT COUNT(t.id) FROM tickets t
                                                          WHERE t.us_asignado = u1.id
                                                          AND (t.fechasolicitud>=? AND t.fechasolicitud<=?)
                                                          AND (t.us_asignado=1 OR t.us_asignado=2 OR t.us_asignado=3 OR t.us_asignado=4)
                                                          AND t.categoria_id = 3
                                        
                                                         ),
                                        
                                        incidencias = (SELECT COUNT(t.id) FROM tickets t
                                                          WHERE t.us_asignado = u1.id
                                                          AND (t.fechasolicitud>=? AND t.fechasolicitud<=?)
                                                          AND (t.us_asignado=1 OR t.us_asignado=2 OR t.us_asignado=3 OR t.us_asignado=4)
                                                          AND t.categoria_id = 2
                                        
                                                         ),
                                        
                                          actualizacion_db = (SELECT COUNT(t.id) FROM tickets t
                                                          WHERE t.us_asignado = u1.id
                                                          AND (t.fechasolicitud>=? AND t.fechasolicitud<=?)
                                                          AND (t.us_asignado=1 OR t.us_asignado=2 OR t.us_asignado=3 OR t.us_asignado=4)
                                                          AND t.categoria_id = 4
                                        
                                                         ),
                                                         
                                                         
                                        
                                          proyectos = (SELECT COUNT(t.id) FROM tickets t
                                                          WHERE t.us_asignado = u1.id
                                                          AND (t.fechasolicitud>=? AND t.fechasolicitud<=?)
                                                          AND (t.us_asignado=1 OR t.us_asignado=2 OR t.us_asignado=3 OR t.us_asignado=4)
                                                          AND t.categoria_id = 6
                                        
                                                         )
                                        
                                        
                                        FROM tickets t
                                        
                                                                            INNER JOIN users u1 ON t.us_asignado = u1.id
                                                                            WHERE (t.fechasolicitud>=? and t.fechasolicitud<=?)
                                                                            AND (t.us_asignado=1 OR t.us_asignado=2 OR t.us_asignado=3 OR t.us_asignado=4)
                                                                            GROUP BY u1.nombre,u1.apellido,u1.id
                                                                            ORDER BY u1.nombre
                         ",[$desde1,$hasta1,$desde2,$hasta2,$desde3,$hasta3,$desde4,$hasta4,$desde5,$hasta5]);




            return $detalles;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //listar los ticket recibidos por sistema
    public function getTicketPorSistema($desde,$hasta)
    {
        try{

            $detalles = DB::select("SELECT s.nombre as sistema, COUNT(t.id) as conteo FROM bitacoras b
                                    INNER JOIN tickets t ON b.ticket_id = t.id
                                    INNER JOIN users u ON t.us_asignado = u.id
                                    INNER JOIN sistemas s ON t.sistema_id = s.id
                                    WHERE (t.fechasolicitud>=? and t.fechasolicitud<=?)
                                    GROUP BY s.nombre
                                    ORDER BY s.nombre
                         ",[$desde,$hasta]);


            return $detalles;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //obtener los tickets autoasignados (reporte)
    public function getTicketsAutoasignados($desde,$hasta)
    {
        $desde1 = $desde;
        $desde2 = $desde;

        $hasta1 = $hasta;
        $hasta2 = $hasta;

        try{

            $detalles = DB::select("SELECT COUNT(t.id) as auto_asignados,

                recibidos = (SELECT COUNT(t.id) as Auto_asignados
                FROM tickets t
                INNER JOIN users u ON t.creador_ticket = u.id
                WHERE (t.fechasolicitud>=? and t.fechasolicitud<=?)
                AND (t.us_asignado=1 OR t.us_asignado=2 OR t.us_asignado=3 OR t.us_asignado=4))
                
                
                FROM tickets t
                INNER JOIN users u ON t.creador_ticket = u.id
                WHERE (t.fechasolicitud>=? and t.fechasolicitud<=?)
                AND t.creador_ticket = t.us_asignado
                AND (t.creador_ticket=1 OR t.creador_ticket=2 OR t.creador_ticket=3 OR t.creador_ticket=4)
                         ",[$desde1,$hasta1,$desde2,$hasta2]);


            return $detalles;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //top de usuarios que no registran tickets
    public function getUsuariosNoUsoComandaTickets($desde,$hasta)
    {
        try{

            $detalle = DB::select("SELECT TOP 10  u.nombre, u.apellido, count(t.id) as conteo FROM tickets t
                        INNER JOIN users u ON t.us_solicitante = u.id
                        WHERE t.us_solicitante != t.creador_ticket
                        AND t.fechasolicitud >= ? AND t.fechasolicitud <=?
                        AND NOT (t.us_solicitante = 1 OR t.us_solicitante = 2 OR t.us_solicitante = 3 OR t.us_solicitante = 4)
                        GROUP BY u.nombre,u.apellido
                        ORDER BY conteo DESC",[$desde,$hasta]);


            return $detalle;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para obtener los top 10 de los usuarios que mas piden tickets
    public function getSolicitantesMasFrecuencia($desde,$hasta)
    {
        try{

            $query = DB::select("SELECT TOP 10  u.nombre, u.apellido, count(t.id) as conteo FROM tickets t
                        INNER JOIN users u ON t.us_solicitante = u.id
                        WHERE t.us_solicitante = t.creador_ticket
                        AND t.fechasolicitud >=? AND t.fechasolicitud <=?
                        AND NOT (t.us_solicitante = 1 OR t.us_solicitante = 2 OR t.us_solicitante = 3 OR t.us_solicitante = 4)
                        GROUP BY u.nombre,u.apellido
                        ORDER BY conteo DESC",[$desde,$hasta]);

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


}