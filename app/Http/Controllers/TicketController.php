<?php

namespace App\Http\Controllers;

use App\CRM_eventos;
use App\Modulo;
use DateTime;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use App\Repositories\Sistemas\SistemaRepository;
use App\Repositories\Modulos\ModuloRepository;
use App\Repositories\Tickets\TicketRepository;
use App\Repositories\Bitacoras\BitacoraRepository;
use App\Repositories\Estados\EstadoRepository;
use App\Repositories\Categorias\CategoriaRepository;
use App\Repositories\Tickets\TicketMessengerRepository;
use App\Ticket;
use Session;
use App\Bitacora;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
use DB;

date_default_timezone_set("America/El_Salvador");

class TicketController extends Controller
{


    //variables globales
    public $ticket;
    public $sistema;
    public $user;
    public $modulo;
    public $bitacora;
    public $estado;
    public $categoria;
    public $ticketmessenger;




    //constructor
    function __construct(UserRepository $user,SistemaRepository $sistema,TicketRepository
    $ticket,BitacoraRepository $bitacora, EstadoRepository $estado,CategoriaRepository $categoria,ModuloRepository $modulo,TicketMessengerRepository $ticketmessenger)
    {
        $this->sistema          = $sistema;
        $this->user             = $user;
        $this->ticket           = $ticket;
        $this->bitacora         = $bitacora;
        $this->categoria        = $categoria;
        $this->estado           = $estado;
        $this->modulo           = $modulo;
        $this->ticketmessenger  = $ticketmessenger;
    }



    //index de creacion de tickets para nostaff
    public function indexNoStaff()
    {
        $usuarios = $this->user->getUsuariosStaff();
        $sistemas = $this->sistema->getSistemas();

        //return json_encode($usuarios);
        return view('tickets.nostaff.index')->with('usuarios',$usuarios)->with('sistemas',$sistemas);
    }




    //index de creacion de tickets para staff
    public function indexStaff()
    {
        $usuarios = $this->user->getUsuariosStaff();
        $sistemas = $this->sistema->getSistemas();
        $conteo   = $this->ticket->conteoTicketsStaff(Session::get('idusuario'));

        return view('tickets.staff.create')->with('conteo',$conteo)->with('usuarios',$usuarios)->with('sistemas',$sistemas);
    }





    public function create()
    {
        //
    }





    //funcion para almacenar un ticket
    public function store(Request $request)
    {
        $opcion = $request['opcion'];

        switch($opcion)
        {


            //opcion para un ticket express
            case '1':

                $fsol = date_create_from_format('Ymd H:i',$request['fechasolucionaprox']);

                $arreglo = explode(' ',$request['usuarioasignado']);

                $usuarioasignado = $this->user->getUserByNames($arreglo[0],$arreglo[1]);

                $fechasolucionaproximada = date_format($fsol,'Ymd H:i');


                $ticket = new Ticket();

                $ticket->titulo              = $request['titulo'];
                $ticket->descripcion         = $request['descripcion'];
                $ticket->fechasolicitud      = date('Ymd H:i');
                $ticket->fechasolaprox       = $fechasolucionaproximada;
                $ticket->us_asignado         = $usuarioasignado->id;
                $ticket->us_solicitante      = Session::get('idusuario');
                $ticket->estado_id           = 2;
                $ticket->creador_ticket      = Session::get('idusuario');


                //persistimos el objeto ticket (save)
                $queryrun = $this->ticket->saveTicket($ticket);

                if($queryrun==true)
                {
                    //buscamos el usuario asignado
                    $usuario = $this->user->getUserById($request['usuarioasignado']);

                    $ticketlast = $this->ticket->getLastTicket();

                    Session::put('id',$ticketlast->id);
                    Session::put('titulo',$ticketlast->titulo);
                    Session::put('descripcion',$ticketlast->descripcion);


                    $asignado       = $ticketlast->nombreasignado.' '.$ticketlast->apellidoasignado;
                    $solicitante    = $ticketlast->nombresolicitante.' '.$ticketlast->apellidosolicitante;


                    Session::put('solicitante',$solicitante);
                    Session::put('asignado',$asignado);

                    //enviar correo a usuario asignado
                    Mail::send('email.nuevoticket', ['ticketlast' => $ticketlast], function ($m) use ($ticketlast) {
                        $m->from('comanda@edesal.com', $ticketlast->nombresolicitante.' '.$ticketlast->apellidosolicitante);

                        $m->to($ticketlast->correoasignado, '')->subject('Nuevo Ticket!');
                    });


                    //enviar correo a usuario solicitante
                    Mail::send('email.solicitante', ['ticketlast' => $ticketlast], function ($m) use ($ticketlast) {
                        $m->from('comanda@edesal.com', 'Ticket Registrado');

                        $m->to($ticketlast->correosolicitante, '')->subject('Nuevo Ticket!');
                    });
                }


                return $queryrun;

                break;

            //opcion para un ticket personalizado
            case "2":

                $fsol = date_create_from_format('Ymd H:i',$request['fechasolucionaprox']);

                $fechasolucionaproximada = date_format($fsol,'Ymd H:i');



                $ticket = new Ticket();

                $ticket->titulo              = $request['titulo'];
                $ticket->descripcion         = $request['descripcion'];
                $ticket->fechasolicitud      = date('Ymd H:i');
                $ticket->us_asignado         = $request['usuarioasignado'];
                $ticket->fechasolaprox       = $fechasolucionaproximada;
                $ticket->us_solicitante      = Session::get('idusuario');
                $ticket->sistema_id          = $request['sistema'];
                $ticket->modulo_id           = $request['modulo'];
                $ticket->estado_id           = 2;
                $ticket->creador_ticket      = Session::get('idusuario');

                //persistimos el objeto ticket (save)
                $queryrun = $this->ticket->saveTicket($ticket);


                $ticketlast = $this->ticket->getLastTicket();


                Session::put('id',$ticketlast->id);
                Session::put('titulo',$ticketlast->titulo);
                Session::put('descripcion',$ticketlast->descripcion);


                $asignado       = $ticketlast->nombreasignado.' '.$ticketlast->apellidoasignado;
                $solicitante    = $ticketlast->nombresolicitante.' '.$ticketlast->apellidosolicitante;


                Session::put('solicitante',$solicitante);
                Session::put('asignado',$asignado);


                //enviar correo a usuario asignado
                Mail::send('email.nuevoticket', ['ticketlast' => $ticketlast], function ($m) use ($ticketlast) {
                    $m->from('comanda@edesal.com', $ticketlast->nombresolicitante.' '.$ticketlast->apellidosolicitante);

                    $m->to($ticketlast->correoasignado, '')->subject('Nuevo Ticket');
                });


                //enviar correo a usuario solicitante
                Mail::send('email.solicitante', ['ticketlast' => $ticketlast], function ($m) use ($ticketlast) {
                    $m->from('comanda@edesal.com', 'Ticket Registrado');

                    $m->to($ticketlast->correosolicitante, '')->subject('Nuevo Ticket');
                });

                return $queryrun;

                break;


            case "3":

                //usuario
                $usuario = $request['usuariosolicitante'];

                $array   = explode(' ',$usuario);

                $nombre   = $array[0];
                $apellido = $array[1];

                $usuariosolicitante = $this->user->getUserByNames($nombre,$apellido);

                $ticket = new Ticket();

                $ticket->titulo              = $request['titulo'];
                $ticket->descripcion         = $request['descripcion'];
                $ticket->fechasolicitud      = date('Ymd');
                $ticket->us_asignado         = Session::get('idusuario');
                $ticket->us_solicitante      = $usuariosolicitante->id;
                $ticket->sistema_id          = $request['sistema'];
                $ticket->modulo_id           = $request['modulo'];
                $ticket->estado_id           = 2;
                $ticket->creador_ticket      = Session::get('idusuario');


                //persistimos el objeto ticket (save)
                $queryrun = $this->ticket->saveTicket($ticket);






                return $queryrun;

                break;

            //opcion para un ticket quick
            case "4":
                $fsol = date_create_from_format('Ymd H:i',$request['fechasol']);

                $fechasolucionaproximada = date_format($fsol,'Ymd H:i');

                //usuario
                $usuario = $request['usuariosolicitante'];

                $array   = explode(' ',$usuario);

                $nombre   = $array[0];
                $apellido = $array[1];

                $usuariosolicitante = $this->user->getUserByNames($nombre,$apellido);

                $ticket = new Ticket();

                $f = date_create($request['fechasolucion']);
                $fechasolucion = date_format($f,'Ymd');

                $ticket->titulo              = $request['titulo'];
                $ticket->descripcion         = $request['descripcion'];
                $ticket->fechasolicitud      = date('Ymd');
                $ticket->us_asignado         = Session::get('idusuario');
                $ticket->us_solicitante      = $usuariosolicitante->id;
                $ticket->fechasolaprox       = $fechasolucionaproximada;
                $ticket->sistema_id          = $request['sistema'];
                $ticket->modulo_id           = $request['modulo'];
                $ticket->solucion            = $request['solucion'];
                $ticket->estado_id           = 8;
                $ticket->tiempodedicado      = $request['tiempodedicado'];
                $ticket->fechasolucion       = $fechasolucion;
                $ticket->categoria_id        = $request['categoria'];
                $ticket->creador_ticket      = Session::get('idusuario');

                //persistimos el ticket
                $queryticket = $this->ticket->saveTicket($ticket);

                if($queryticket=="success")
                {
                    //como es ticket quick llenamos la linea de bitacora de una sola vez y el ticket nace cerrado
                    $bitacora = new Bitacora();

                    //consultamos el ultimo ticket ingresado
                    $lastticket = $this->ticket->getLastTicket();

                    $bitacora->fechacreacion     = date('Ymd');
                    $bitacora->fechabitacora     = date('Ymd');
                    $bitacora->tiempodedicado    = $request['tiempodedicado'];
                    $bitacora->descripcion       = $request['solucion'];
                    $bitacora->ticket_id         = $lastticket->id;
                    $bitacora->user_id           = Session::get('idusuario');



                    //persistimos la bitacora
                    $querybitacora = $this->bitacora->saveBitacora($bitacora);

                    return response()->json($querybitacora);
                }
                else
                {
                    return "error";
                }



                break;

            case 911:


                $array1   = explode(' ',$request['solicitante']);
                $array    = explode(' ',$request['usuarioasignado']);

                $solicitante = $this->user->getUserByNames($array1[0],$array1[1]);
                $asignado    = $this->user->getUserByNames($array[0],$array[1]);





                $ticket = new Ticket();

                $ticket->titulo              = $request['titulo'];
                $ticket->descripcion         = $request['descripcion'];
                $ticket->fechasolicitud      = date('Ymd');
                $ticket->us_asignado         = $asignado->id;
                $ticket->us_solicitante      = $solicitante->id;
                $ticket->sistema_id          = $request['sistema'];
                $ticket->modulo_id           = $request['modulo'];
                $ticket->estado_id           = 2;
                $ticket->creador_ticket      = Session::get('idusuario');


                //persistimos el objeto ticket (save)
                $queryrun = $this->ticket->saveTicket($ticket);


                return $queryrun;


                break;


        }
    }





    //funcion para mostrar los tickets enviados por parte del usuario nostaff
    public function showNostaff()
    {
        $tickets    = $this->ticket->getTicketsNoStaff(Session::get('idusuario'));
        $conteo     = $this->ticket->conteoTicketsNoStaff(Session::get('idusuario'));

        return view('tickets.nostaff.show')->with('tickets',$tickets)->with('conteo',$conteo);
    }


    //funcion para lanzar la vista de edicion de un ticket de parte de no staff
    public function edit(Request $request)
    {
        $ticket     = $this->ticket->getTicketById($request['ticket']);

        $usuarios = $this->user->getUsuariosStaff();

        $sistemas = $this->sistema->getSistemas();

        $bitacora   = $this->bitacora->getBitacorasById($request['ticket']);

        return view('tickets.nostaff.edit')
            ->with('ticket',$ticket)
            ->with('bitacora',$bitacora)
            ->with('sistemas',$sistemas)
            ->with('usuarios',$usuarios);
    }





    //funcion para lanzar la vista de los tickets recibidos para staff
    public function ticketsRecibidosStaff()
    {
        $id         = Session::get('idusuario');
        $tickets    =  $this->ticket->getTicketsStaff($id);


        return view('tickets.staff.index')->with('tickets',$tickets);
        //return json_encode($tickets);
    }




    //funcion para la busqueda de ticket por id
    public function getTicketById(Request $request)
    {
        $ticket     = $this->ticket->findTicketById($request['id']);
        $usuarios   = $this->user->getUsuariosStaff();

        return view('tickets.staff.sub-views.sv_ticketrecibido')->with('ticket',$ticket)->with('usuarios',$usuarios);
    }





    //funcion para actualizar los estados del ticket y administrar su contenido hasta la resolucion
    public function update(Request $request)
    {
        //variable que almacena la opcion para el switch case
        $opcion     = $request['opcion'];





        switch($opcion)
        {
            //opcion para actualizar el estado a "en proceso"
            case "1":

                //buscamos el ticket para actualizar sus campos
                $ticket     = $this->ticket->findTicketByEloquent($request['id']);

                //actualizamos el estado del ticket a "en proceso"
                $ticket->estado_id = 2;

                //persistimos el objeto ticket
                $queryrun = $this->ticket->updateTicket($ticket);

                if($queryrun==1)
                {
                    return response()->json('success');
                }
                else
                {
                    return response()->json($queryrun);
                }

                break;

            //reasignar un ticket
            case "2":
                //buscamos el ticket para actualizar sus campos
                $ticket     = $this->ticket->findTicketByEloquent($request['ticket']);

                //buscamos el usuario nuevo para enviar correo de reasignacion

                //reasignamos
                $ticket->us_asignado = $request['usuario'];
                $ticket->desc_reasignacion = $request['motivo'];
                $ticket->reasignado = 1;

                //persistimos el objeto ticket
                $queryrun = $this->ticket->updateTicket($ticket);



                if ($queryrun==1)
                {
                    $ticketlast = $this->ticket->getTicketReasignado($request['ticket']);

                    Session::put('id',$ticketlast->id);
                    Session::put('titulo',$ticketlast->titulo);
                    Session::put('descripcionticket',$ticketlast->descripcion);


                    $asignado       = $ticketlast->nombreasignado.' '.$ticketlast->apellidoasignado;
                    $solicitante    = $ticketlast->nombresolicitante.' '.$ticketlast->apellidosolicitante;


                    Session::put('solicitante',$solicitante);
                    Session::put('asignado',$asignado);

                    //enviar correo al usuario que reasignemos el ticket
                    Mail::send('email.tickets.reasignacion', ['ticketlast' => $ticketlast], function ($m) use ($ticketlast) {
                        $m->from('comanda@edesal.com', $ticketlast->nombresolicitante.' '.$ticketlast->apellidosolicitante);

                        $m->to($ticketlast->correoasignado, '')->subject('Ticket Reasignado');
                    });

                    return response()->json("success");

                }
                else
                {
                    return response()->json($queryrun);
                }
                break;


            //administrar un ticket
            case "3":
                //buscamos el ticket para actualizar sus campos
                $ticket     = $this->ticket->findTicketByEloquent($request['id']);

                //fecha formateada


                $h1 = date_create($request['fechasolucion']);
                $inicio = date_format($h1,'Ymd');



                $ticket->categoria_id       = $request['categoria'];
                $ticket->estado_id          = $request['estado'];
                $ticket->sistema_id         = $request['sistema'];
                $ticket->modulo_id          = $request['modulo'];
                $ticket->solucion           = $request['solucion'];
                $ticket->tiempodedicado     = $request['tiempodedicado'];
                $ticket->fechasolucion      = $inicio;
                $queryrun = $this->ticket->updateTicket($ticket);

                $usuario = $this->user->getUserById($ticket->us_solicitante);

                $asignado = $this->user->getUserById($ticket->us_asignado);

                $tickets = DB::table('tickets')->where('evento_id',$ticket->evento_id)->where('estado_id','!=',6)->where('estado_id','!=',8)->get();


                 if(count($tickets)>0)
                 {
                     return response()->json($queryrun);
                 }
                 else
                 {
                     $evento = CRM_eventos::find($ticket->evento_id);
                     $evento->estado = 3;

                     $queryrun = $evento->save();

                     return response()->json($queryrun);
                 }






                break;

            //aceptar o denegar solucion
            case '4':
                //buscamos el ticket para actualizar sus campos
                $ticket     = $this->ticket->findTicketByEloquent($request['id']);

                if($request['estado']=='denegado')
                {
                    $ticket->estado_id = 10;
                    $ticket->comentariodenegado = $request['comentario'];

                    //persistimos el objeto ticket
                    $queryrun = $this->ticket->updateTicket($ticket);

                    if ($queryrun>=1)
                    {
                        return response()->json("success");
                    }
                    else
                    {
                        return response()->json($queryrun);
                    }

                }
                elseif($request['estado']=='aceptado')
                {
                    $ticket->estado_id = 8;
                    //persistimos el objeto ticket
                    $queryrun = $this->ticket->updateTicket($ticket);

                    if ($queryrun>=1)
                    {
                        return response()->json("success");
                    }
                    else
                    {
                        return response()->json($queryrun);
                    }
                }

                break;
        }


    }







    //funcion para lanzar la sub vista de administracion del ticket
    public function administrarTicket(Request $request)
    {
        $ticket     = $this->ticket->findTicketById($request['id']);
        $categorias = $this->categoria->getCategoriasAll();
        $estados    = $this->estado->getEstadosAll();
        $sistemas   = $this->sistema->getSistemas();
        $modulos    = $this->modulo->getModulosById($ticket->sistema_id);
        $bitacora   = $this->bitacora->getBitacorasById($request['id']);
        $mensajes   = $this->ticketmessenger->getMensajesForTicket($request['id']);
        $usuarios   = $this->user->getUsuariosStaff();


        return view('tickets.edesal.partials.administrar_tck')
            ->with('ticket',$ticket)
            ->with('categorias',$categorias)
            ->with('estados',$estados)
            ->with('sistemas',$sistemas)
            ->with('modulos',$modulos)
            ->with('bitacoras',$bitacora)
            ->with('usuarios',$usuarios)
            ->with('mensajes',$mensajes);

//        return response()->json($ticket);
    }




    //obtener tickets completos
    public function obtenerTicketsCompletos()
    {
        $tickets = $this->ticket->getTicketsCompletos(Session::get('idusuario'));

        return view('tickets.staff.sub-views.sv_ticketscompletados')->with('tickets',$tickets);


    }


    //lanzar vista de tickets completados
    public function ticketsCompletados()
    {
        $tickets    = $this->ticket->getTicketsCompletos(Session::get('idusuario'));

        return view('tickets.edesal.ticketscompletados')->with('tickets',$tickets);

    }


    //resoluciones de tickets
    public function ticketsResoluciones(Request $request)
    {
        $ticket     = $this->ticket->getTicketById($request['ticket']);

        $usuarios = $this->user->getUsuariosStaff();

        $sistemas = $this->sistema->getSistemas();

        $bitacora   = $this->bitacora->getBitacorasById($request['ticket']);

        return view('tickets.staff.sub-views.sv_ticketscompletados')
            ->with('ticket',$ticket)
            ->with('bitacora',$bitacora)
            ->with('sistemas',$sistemas)
            ->with('usuarios',$usuarios);
    }

    public function destroy($id)
    {
        //
    }




    //vista para generar nuevos tickets de edesal
    public function indexEdesal()
    {
        $usuarios = $this->user->getUsuariosStaff();
        $sistemas = $this->sistema->getSistemas();
        $conteo   = $this->ticket->conteoTicketsStaff(Session::get('idusuario'));
        $categorias = DB::table('categorias')->get();

        return view('tickets.edesal.index')
            ->with('conteo',$conteo)->with('usuarios',$usuarios)
            ->with('sistemas',$sistemas)
            ->with('categorias',$categorias);
    }


    //vista para mostrar los tickets solicitados por parte de los usuarios edesal
    public function showEdesal()
    {
        $tickets  = $this->ticket->getTicketsStaff(Session::get('idusuario'));
        $conteo   = $this->ticket->conteoTicketsStaff(Session::get('idusuario'));
        $categorias = DB::table('categorias')->get();
        $sistemas = DB::table('sistemas')->get();

        $recibidos =  DB::table('tickets')->where('estado_id',2)->
        where('us_asignado',Session::get('idusuario'))->count();

        $process =  DB::table('tickets')->where('estado_id',5)->
        where('us_asignado',Session::get('idusuario'))->count();


        $pausa =  DB::table('tickets')->where('estado_id',13)->
        where('us_asignado',Session::get('idusuario'))->count();


        $cerrados =  DB::table('tickets')->where('estado_id',8)->
        where('us_asignado',Session::get('idusuario'))->count();


        $solu =  DB::table('tickets')->where('estado_id',6)->
        where('us_asignado',Session::get('idusuario'))->count();

        $recha =  DB::table('tickets')->where('estado_id',12)->
        where('us_asignado',Session::get('idusuario'))->count();

        $usuarios = $this->user->getUsuariosStaff();
        $dedicado = 0;

        //variable para saber cuanto tiempo dedicado en el dia llevamos como staff de informatica
        $tiempo = DB::select('SELECT SUM(tiempodedicado) as tiempo FROM bitacoras b
                  WHERE b.fechabitacora = DATEADD(dd, 0, DATEDIFF(dd, 0, GETDATE())) and user_id = ?',[Session::get('idusuario')]);

        if($tiempo>0)
        {
            $dedicado = $tiempo;
        }

        return view('tickets.edesal.show')->with('tickets',$tickets)->with('dedicado',$dedicado)->with('usuarios',$usuarios)
            ->with('conteo',$conteo)->with('categorias',$categorias)->with('sistemas',$sistemas)
            ->with('recibidos',$recibidos)->with('process',$process)->with('pausa',$pausa)
            ->with('cerrados',$cerrados)->with('solu',$solu)
            ->with('recha',$recha);

        //return response()->json(($dedicado));
    }



    //ver procesos de informatica
    public function verProcesosInformatica()
    {
        $conteo = $this->ticket->conteoTicketsStaff(Session::get('idusuario'));
        $tickets =  $this->user->getTicketsEnProceso();

        return view('home.informatica')->with('ticketsproceso',$tickets);

        //return response()->json($tickets);
    }


    //devolver vista con la informacion del ticket
    public function infoTicketEdesal(Request $request)
    {
        $usuarios = $this->user->getUsuariosAll();
        $ticket = $this->ticket->getTicketById($request['id']);

        return view('tickets.edesal.partials.infoticket')->with('ticket',$ticket)->with('usuarios',$usuarios);
    }



    //funcion para aceptar ticket
    public function aceptarTicket(Request $request)
    {
        $fsol = date_create_from_format('d/m/Y H:i',$request['fechasolaprox']);
        $fechasolucionaproximada = date_format($fsol,'Ymd H:i');

        $ticket = $this->ticket->findTicketByEloquent($request['id']);

        $ticket->estado_id = 5;
        $ticket->fechaaceptacion = date('Ymd H:i');

        if(isset($request['fechasolaprox']))
        {
            $ticket->fechaentregareal = $fechasolucionaproximada;
        }
        else
        {
            $ticket->fechaentregareal = $ticket->fechasolaprox;
        }

        //persistimos
        $queryrun = $this->ticket->saveTicket($ticket);

        return response()->json($queryrun);


    }



    
    //rechazar ticket
    public function rechazarTicketEdesal(Request $request)
    {
        $ticket = $this->ticket->findTicketByEloquent($request['id']);

        $ticket->estado_id                  = 12;
        $ticket->comentariorechazo          = $request['comentario'];
        $ticket->fecharechazoticket         = date('Ymd H:i');

        //persistimos
        $queryrun = $this->ticket->saveTicket($ticket);

        return response()->json($queryrun);

    }



    //funcion para vista de tickets solicitados
    public function Solicitados()
    {
        $tickets = $this->ticket->getTicketsNoStaff(Session::get('idusuario'));
        $conteo  = $this->ticket->conteoTicketsNoStaff(Session::get('idusuario'));

        $recibidos =  DB::table('tickets')->where('estado_id',2)->
        where('us_solicitante',Session::get('idusuario'))->count();

        $process =  DB::table('tickets')->where('estado_id',5)->
        where('us_solicitante',Session::get('idusuario'))->count();


        $solu =  DB::table('tickets')->where('estado_id',6)->
        where('us_solicitante',Session::get('idusuario'))->count();

        $recha =  DB::table('tickets')->where('estado_id',12)->
        where('us_solicitante',Session::get('idusuario'))->count();

        $cerrado =  DB::table('tickets')->where('estado_id',8)->
        where('us_solicitante',Session::get('idusuario'))->count();

        return view('tickets.edesal.solicitados')->
        with('tickets',$tickets)->with('conteo',$conteo)
        ->with('recibidos',$recibidos)->with('process',$process)->with('solu',$solu)
        ->with('recha',$recha)->with('cerrado',$cerrado);

//        return response()->json($tickets);
    }



    //funcion para poder ver solicitud
    public function verTicketSolicitado(Request $request)
    {
        $ticket = $this->ticket->getTicketById($request['id']);
        $bitacora   = $this->bitacora->getBitacorasById($request['id']);
        $mensajes   = $this->ticketmessenger->getMensajesForTicket($request['id']);

        return view('tickets.edesal.partials.infoticketsolicitado')
            ->with('bitacoras',$bitacora)
            ->with('mensajes',$mensajes)
            ->with('ticket',$ticket);

    }


    //funcion para denegar o acaptar una resolucion de ticket
    public function resolucionTicket(Request $request)
    {
        $ticket = $this->ticket->findTicketByEloquent($request['id']);

        $ticket->estado_id = $request['resolucion'];
        $ticket->comentariodenegado = $request['comentario'];

        //persistimos el objeto ticket
        $queryrun = $this->ticket->updateTicket($ticket);

        return response()->json($queryrun);
    }



    //funcion para generar los detalles del ticket en curso
    public function generarReporteDetalles(Request $request)
    {
        $ticket = $this->ticket->getTicketById($request['id']);

        $bitacoras = $this->bitacora->getBitacorasById($request['id']);

        $view =  \View::make('tickets.edesal.rpt_ticketdetalles', compact('ticket','bitacoras'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);

        //return response()->json($reserva);
        return $pdf->stream('ticketdetalles.pdf');
    }



    //vista para supervisar tickets de parte de la jefatura
    public function view_supervisionTickets()
    {
        $tickets = $this->ticket->getTicketsForSupervision(Session::get('idusuario'));

        return view('tickets.edesal.tck_supervision')->with('tickets',$tickets);
        //return response()->json($tickets);
    }

    //funcion para retornar la partial view del detalle del ticket supervisado
    public function view_DetalleSupervision(Request $request)
    {
        $ticket = $this->ticket->getTicketById($request['id']);
        $bitacora   = $this->bitacora->getBitacorasById($request['id']);
        $estados    = $this->estado->getEstadosAll();
        $sistemas   = $this->sistema->getSistemas();
        $categorias = $this->categoria->getCategoriasAll();
        $modulos    = $this->modulo->getModulos();
        $mensajes   = $this->ticketmessenger->getMensajesForTicket($request['id']);

        return view('tickets.edesal.partials.partial_supervisarticket')
            ->with('bitacoras',$bitacora)
            ->with('categorias',$categorias)
            ->with('estados',$estados)
            ->with('sistemas',$sistemas)
            ->with('modulos',$modulos)
            ->with('mensajes',$mensajes)
            ->with('ticket',$ticket);
    }


    //listar los ticket de un usuario de staff
    public function staffDetalleTickets(Request $request)
    {
        $tickets = $this->user->getDetalleTicketsEnProceso($request['usuario']);

        return view('tickets.edesal.partials.ticketusuariostaff')->with('tickets',$tickets);
    }


    //funcion para lanzar el reporte del detalle de los ticket de informatica
    public function rptDetalleTicketInformatica(Request $request)
    {
        $detalles = $this->ticket->rpt_querydetalleticketsinfo($request['desde'],$request['hasta']);

        return view('usuarios.jefatura.detalletckinformatica')->with('detalles',$detalles);
    }


    //generar excel del detalle de los ticket
    public function xls_GenerarDetalleTickets(Request $request)
    {
        $detalles = $this->ticket->rpt_querydetalleticketsinfo($request['desde'],$request['hasta']);

        //return response()->json($detalles);

        Excel::create('tickets', function($excel) use($detalles) {
            $excel->sheet('detalles', function($sheet) use($detalles) {

                $sheet->loadView('usuarios.jefatura.excel_detalleticketinformatica')
                    ->with('detalles',$detalles);

            });
        })->export('xls');
    }


    public function rpt_HorasTrabajadas(Request $request)
    {
        $detalle = $this->ticket->getHorasTrabajadas($request['desde'],$request['hasta']);

        return view('usuarios.jefatura.reportes.rpt_detallehrstrabajadas')->with('detalles',$detalle);

        //return response()->json($detalle);
    }


    //generar excel para el reporte de horas trabajadas por empleado
    public function excelHorasTrabajadas(Request $request)
    {
        $detalles = $this->ticket->getHorasTrabajadas($request['desde'],$request['hasta']);


        Excel::create('horastrabajadas', function($excel) use($detalles) {
            $excel->sheet('detalles', function($sheet) use($detalles) {

                $sheet->loadView('usuarios.jefatura.reportes.rpt_detallehrstrabajadas')
                    ->with('detalles',$detalles);

            });
        })->export('xls');
    }


    //generar reporte de horas registradas por sistema
    public function rpt_HorasXSistema(Request $request)
    {
        $detalle = $this->ticket->getHorasRegistradasXSistema($request['desde'],$request['hasta']);

        return view('usuarios.jefatura.reportes.rpt_detallehrstrabajadasxsistema')->with('detalles',$detalle);
    }

    //generar excel para las horas registradas por sistema
    public function excelHorasTrabajadasXSistema(Request $request)
    {
        $detalles = $this->ticket->getHorasRegistradasXSistema($request['desde'],$request['hasta']);


        Excel::create('horasXsistema', function($excel) use($detalles) {
            $excel->sheet('detalles', function($sheet) use($detalles) {

                $sheet->loadView('usuarios.jefatura.reportes.rpt_detallehrstrabajadasxsistema')
                    ->with('detalles',$detalles);

            });
        })->export('xls');
    }



    //reporte para los tickets recibidos por empleado
    public function rpt_ticketsrecibidos(Request $request)
    {
        $detalle = $this->ticket->getTicketsPorEmpleado($request['desde'],$request['hasta']);
        return view('usuarios.jefatura.reportes.rpt_ticketsrecibidos')->with('detalles',$detalle);
    }


    //generar un excel para los tickets recibidos por empleado
    public function excel_ticketsRecibidos(Request $request)
    {
        $detalles = $this->ticket->getTicketsPorEmpleado($request['desde'],$request['hasta']);


        Excel::create('ticketsXempleado', function($excel) use($detalles) {
            $excel->sheet('detalles', function($sheet) use($detalles) {

                $sheet->loadView('usuarios.jefatura.reportes.rpt_ticketsrecibidos')
                    ->with('detalles',$detalles);

            });
        })->export('xls');
    }


    //ticket recibidos por sistema
    public function rpt_TicketXSistemaRecibidos(Request $request)
    {
        $detalle = $this->ticket->getTicketPorSistema($request['desde'],$request['hasta']);
        return view('usuarios.jefatura.reportes.rpt_ticketsrecibidosxsistema')->with('detalles',$detalle);
    }


    //generar excel de los tickets recibidos por sistema
    public function excel_ticketsRecibidosXXSistema(Request $request)
    {
        $detalles = $this->ticket->getTicketPorSistema($request['desde'],$request['hasta']);


        Excel::create('ticketsXsistema', function($excel) use($detalles) {
            $excel->sheet('detalles', function($sheet) use($detalles) {

                $sheet->loadView('usuarios.jefatura.reportes.rpt_ticketsrecibidosxsistema')
                    ->with('detalles',$detalles);

            });
        })->export('xls');
    }


    //generar reporte de los tickets autoasignados para informatica
    public function rpt_ticketsAutoAsignados(Request $request)
    {
        $detalle = $this->ticket->getTicketsAutoasignados($request['desde'],$request['hasta']);
        $usuarios = $this->ticket->getUsuariosNoUsoComandaTickets($request['desde'],$request['hasta']);
        $solicitantes = $this->ticket->getSolicitantesMasFrecuencia($request['desde'],$request['hasta']);

        return view('usuarios.jefatura.reportes.rpt_ticketsautoasignados')->with('detalles',$detalle)->with('usuarios',$usuarios)->with('solicitantes',$solicitantes);
    }

    public function excel_ticketsAutoasignados(Request $request)
    {
        $detalles = $this->ticket->getTicketsAutoasignados($request['desde'],$request['hasta']);


        Excel::create('autoasignados', function($excel) use($detalles) {
            $excel->sheet('detalles', function($sheet) use($detalles) {

                $sheet->loadView('usuarios.jefatura.reportes.rpt_ticketsautoasignados')
                    ->with('detalles',$detalles);

            });
        })->export('xls');
    }




}//fin de clase
