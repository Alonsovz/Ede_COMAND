<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Bitacora;
use App\Ticket;
use App\Repositories\Tickets\TicketRepository;
use App\Repositories\Bitacoras\BitacoraRepository;
use Illuminate\Support\Facades\Session;
use Datetime;

class BitacoraController extends Controller
{
    public $bitacora;
    public $ticket;


    //constructor
    function __construct(BitacoraRepository $bitacora, TicketRepository $ticket)
    {
        $this->ticket    = $ticket;
        $this->bitacora  = $bitacora;
    }

    public function index()
    {
        $bitacoras = $this->bitacora->getBitacorasByStaff(Session::get('idusuario'));

        return view('bitacoras.index')->with('bitacoras',$bitacoras);
    }


    public function create()
    {
        $tickets = $this->ticket->getTicketsStaff(Session::get('idusuario'));
        return view('bitacoras.subviews.sv_nuevabitacora')->with('tickets',$tickets);
    }


    public function store(Request $request)
    {
        $opcion = $request['opcion'];

        switch ($opcion)
        {
            case 1:
                $bitacora = new Bitacora;

                $fecha = DateTime::createFromFormat('Ymd H:i',$request['fechabitacora']);

                $fechabitacora = date_format($fecha,'Ymd');

                $bitacora->descripcion      = $request['descripcion'];
                $bitacora->fechabitacora    = $fechabitacora;
                $bitacora->fechacreacion    = date('Ymd');
                $bitacora->tiempodedicado   = $request['tiempodedicado'];
                $bitacora->ticket_id        = $request['ticket'];
                $bitacora->user_id          = Session::get('idusuario');


                //persistimos el objeto
                $queryrun = $this->bitacora->saveBitacora($bitacora);

                return response()->json($queryrun);
                break;

            case 2:
                $bitacora = new Bitacora;

                $fecha = DateTime::createFromFormat('Ymd H:i',$request['fechabitacora']);

                $fechabitacora = date_format($fecha,'Ymd');

                $bitacora->descripcion      = $request['descripcion'];
                $bitacora->fechabitacora    = $fechabitacora;
                $bitacora->fechacreacion    = date('Ymd');
                $bitacora->tiempodedicado   = $request['tiempodedicado'];
                $bitacora->ticket_id        = $request['ticket'];
                $bitacora->user_id          = Session::get('idusuario');


                //persistimos el objeto
                $queryrun = $this->bitacora->saveBitacora($bitacora);

                //creamos nuevo objeto de ticket
                $ticket = $this->ticket->findTicketByEloquent($bitacora->ticket_id);

                //llenamos el objeto
                $ticket->solucion = $bitacora->descripcion;
                $ticket->fechasolucion = date('Ymd H:i');
                $ticket->estado_id = 6;

                //persistimos el objeto
                $query = $ticket->save();

                return response()->json($query);

                break;
        }
    }




    //funcion para lanzar la subvista de administracion de bitacoras para la vista de tickets
    public function adminBitacoraByTickets(Request $request)
    {
        $ticket     = $this->ticket->getTicketById($request['id']);
        $tickets    = $this->ticket->getTicketsStaff(Session::get('idusuario'));
        $bitacoras  = $this->bitacora->getBitacorasById($request['id']);

        return view('tickets.staff.sub-views.sv_nuevabitacora')
            ->with('bitacoras',$bitacoras)
            ->with('ticket',$ticket)
            ->with('tickets',$tickets);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    //obtener lineas de un ticket
    public function getLineasDeTicket(Request $request)
    {
        $lineas = $this->bitacora->getLineasByTicket($request['ticket']);

        return response()->json($lineas);
    }


    //detalles de bitacora por usuario
    public function detallesByUser(Request $request)
    {
        $tickets = DB::select('SELECT t.id,t.titulo FROM tickets t WHERE t.us_asignado=?  ORDER BY t.id DESC',[$request['usuario']]);

        $detalle = DB::select('SELECT b.descripcion as bitacora, b.tiempodedicado as tiempo,b.fechacreacion,t.id,t.titulo
                    FROM bitacoras b
                    LEFT JOIN tickets t ON b.ticket_id = t.id
                    LEFT JOIN users u ON t.us_asignado = u.id
                    WHERE u.id = ? 
                    GROUP BY t.id,b.descripcion,b.tiempodedicado,b.fechacreacion,t.titulo ORDER BY t.id DESC',[$request['usuario']]);

        return view('tickets.edesal.partials.bitacorasusuariostaff')->with('bitacoras',$detalle)->with('tickets',$tickets);
    }




}
