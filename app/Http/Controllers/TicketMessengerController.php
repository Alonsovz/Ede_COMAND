<?php

namespace App\Http\Controllers;

use App\TicketMessenger;
use Illuminate\Http\Request;
use App\Repositories\Tickets\TicketMessengerRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Tickets\TicketRepository;
use Session;
use Mail;


class TicketMessengerController extends Controller
{
    public $user;
    public $ticketmessenger;
    public $ticket;

    function __construct(TicketMessengerRepository $ticketmessenger,UserRepository $user,TicketRepository $ticket)
    {
        $this->user = $user;
        $this->ticketmessenger = $ticketmessenger;
        $this->ticket = $ticket;
    }


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $mensaje = new TicketMessenger();

        //buscamos el ticket relacionado con el mensaje
        $ticket = $this->ticket->getTicketById($request['idticket']);

        $emisor = $this->user->getUserById($ticket->us_solicitante);
        $receptor = $this->user->getUserById($ticket->us_asignado);

        $destinatarios = [$emisor->correo,$receptor->correo];

        //rellenamos el objeto
        $mensaje->mensaje           = $request['mensaje'];
        $mensaje->emisor            = Session::get('idusuario');
        $mensaje->ticket_id         = $ticket->id;
        $mensaje->fecha_creacion    = date('Ymd H:i');

        $queryrun = $this->ticketmessenger->save($mensaje);

        Session::put('ticket',$ticket->id);
        Session::put('mensaje',$mensaje->mensaje);
        Session::put('titulo',$ticket->titulo);

        Mail::send('email.tickets.mensajesticket', ['destinatarios' => $destinatarios], function ($m) use ($destinatarios) {
            $m->from('comanda@edesal.com');
            $m->to($destinatarios)->subject('Nuevo mensaje sobre ticket');
        });



        return response()->json($queryrun);
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
}
