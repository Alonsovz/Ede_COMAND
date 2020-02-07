<?php


namespace App\Http\Controllers;

use App\Departamento;
use Mail;
use App\User;
use App\VH_Vehiculos;
use DateTime;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use App\Repositories\VH_Vehiculos\VH_VehiculoRepository;
use App\Repositories\VH_Reservas\VH_ReservaRepository;
use App\Repositories\Departamentos\DepartamentoRepository;
use App\Repositories\VH_Estados;
use Illuminate\Http\Response;
use App\VH_Reserva;
use Session;
use DB;
use View;



class VH_ReservaController extends Controller
{

    protected $vhreservas;
    protected $departamento;
    protected $vh_vehiculo;
    protected $user;

    //constructor
    function __construct(VH_ReservaRepository $vhreservas,DepartamentoRepository $departamento,
                         VH_VehiculoRepository $vh_vehiculo,UserRepository $user)
    {
        $this->vhreservas   = $vhreservas;
        $this->departamento = $departamento;
        $this->vh_vehiculo  = $vh_vehiculo;
        $this->user         = $user;
    }


  
    public function index()
    {
        $departamentos  = $this->departamento->getDepartamentos();
        $vehiculos      = $this->vh_vehiculo->getVehiculos();
        $usuarios       = $this->user->getAll();
        $tiposreservas  = DB::table('vh_tipos')->get();

        return view('vh_reservas.index')
                                            ->with('departamentos',$departamentos)
                                            ->with('vehiculos',$vehiculos)
                                            ->with('usuarios',$usuarios)
                                            ->with('tiposreservas',$tiposreservas);

       //return response()->json($usuarios);
    }

    


    
    public function store(Request $request)
    {
        //iniciamos la transaccion
        DB::beginTransaction();

        //objeto de tipo Reserva
        $vhreserva      = new VH_Reserva;

        //formateamos las fechas para ingresarlas en la db
        $h1 = date_create_from_format('d/m/Y H:i',$request['inicio']);
        $h2 = date_create_from_format('d/m/Y H:i',$request['fin']);


        $inicio = date_format($h1,'Ymd H:i');
        $fin = date_format($h2,'Ymd H:i');



        $jefe = $request['jefe'];




        //obtenemos el jefe inmediato del empleado
        $arreglo = explode(" ",$jefe);




        $nombre   = $arreglo[0];
        $apellido = $arreglo[1];

        $jefeinmediato     = $this->user->findUserByName($nombre,$apellido);


        $vehiculo = DB::table('vh_vehiculos')->where('numeracion',$request['vehiculo'])->first();


        //rellenamos el objeto con los datos del formulario
        $vhreserva->empleado            = $request['nombrecompleto'];

        //si el vehiculo pertenece al grupo del area comercial se establecera el jefe inmediato correcto si no es asi
        //se establecera la excepcion del formulario introducido por el usuario

        $usuario = $this->user->getUserById(Session::get('idusuario'));

        if($vehiculo->grupo=="COMERCIAL")
        {
            $vhreserva->jefe_inmediato = $usuario->jefe_inmediato;
        }
        else
        {
            $vhreserva->jefe_inmediato = $jefeinmediato->id;
        }

        $vhreserva->departamento_id     = $request['departamento'];
        $vhreserva->vh_vehiculo_id      = $vehiculo->id;
        $vhreserva->fechasolicitud      = date('Ymd H:i');
        $vhreserva->motivo              = $request['motivo'];
        $vhreserva->vh_estado_id        = 1;
        $vhreserva->user_id             = Session::get('idusuario');
        $vhreserva->fechainicio         = $inicio;
        $vhreserva->fechafin            = $fin;
        $vhreserva->vh_tipo_id          = $request['tipo'];
        $vhreserva->destino             = $request['destino'];
        $vhreserva->conductor           = $request['conductor'];

        $vehiculo = VH_Vehiculos::find($vehiculo->id);

        //el estado del carro es importante ya que si esta en mto debe pasar a un estado FALSE para que el query no lo tome en cuenta en la disponibilidad
        if($request['tipo']==2)
        {
            $vehiculo->estado = 'Mantenimiento';
        }

        //persistimos
        $vehiculo->save();


        $queryrun = $this->vhreservas->saveReserva($vhreserva);

        if($queryrun==true)
        {
            //hacemos el commit
            DB::commit();
            //obtenemos la informacion completa de la ultima reserva
            $ultimareserva = $this->vhreservas->getReservaLast();

            $vehiculo_id = DB::table('vh_vehiculos')->where('numeracion',$request['vehiculo'])->first();

            $duenovehiculo = $this->user->getDueñoVH($vehiculo_id->id);

            $inicio = date_format($h1,'d/m/Y H:i');
            $fin = date_format($h2,'d/m/Y H:i');

            Session::put('vehiculo',$ultimareserva->vehiculo);
            Session::put('vh_id',$ultimareserva->id);
            Session::put('vh_empleado',$ultimareserva->empleado);
            Session::put('vh_fechas',$inicio.' - '.$fin);
            Session::put('vh_motivo',$ultimareserva->motivo);
            Session::put('destino',$ultimareserva->destino);

            Mail::send('email.vh_nuevareserva', ['duenovehiculo' => $duenovehiculo], function ($m) use ($duenovehiculo) {
                $m->from('comanda@edesal.com', 'COMANDA');
                $m->to('dhernandez@edesal.com', '')->subject('Nueva solicitud para reserva de vehiculo!');
            });

            Mail::send('email.vh_nuevareserva', ['ultimareserva' => $ultimareserva], function ($m) use ($ultimareserva) {
                $m->from('comanda@edesal.com', 'COMANDA');
                $m->to($ultimareserva->correojefe, '')->subject('Nueva solicitud para reserva de vehiculo!');
            });

            Mail::send('email.vh_nuevareserva', ['duenovehiculo' => $duenovehiculo], function ($m) use ($duenovehiculo) {
                $m->from('comanda@edesal.com', 'COMANDA');
                $m->to($duenovehiculo->correo, '')->subject('Nueva solicitud para reserva de vehiculo!');
            });

            Mail::send('email.vh_nuevareserva', ['duenovehiculo' => $duenovehiculo], function ($m) use ($duenovehiculo) {
                $m->from('comanda@edesal.com', 'COMANDA');
                $m->to('cperez@edesal.com', '')->subject('Nueva solicitud para reserva de vehiculo!');
            });

            return response()->json($queryrun);

        }
        else
        {
            //realizamos el rollback
            DB::rollBack();

            return response()->json($queryrun);
        }



    }



    public function view_reservasEmpleados()
    {
        //obtenemos las reservas del usuario logueado
        $idempleado = Session::get('idusuario');

        $reservas   = $this->vhreservas->getReservasByEmpleado($idempleado);


        return view('vh_reservas.empleado.reservas')->with('reservas',$reservas);
        //return response()->json($reservas);
    }

   
    public function edit(Request $request)
    {
        $departamentos  = $this->departamento->getDepartamentos();
        $vehiculos      = $this->vh_vehiculo->getVehiculos();

        $reserva = $this->vhreservas->getReservaById($request['id']);
        return view('vh_reservas.empleado.edit')->with('reserva',$reserva)->with('departamentos',$departamentos)->with('vehiculos',$vehiculos);
        //return response()->json($reserva);
    }




   
    public function update(Request $request)
    {

        //objeto de tipo Reserva
        $vhreserva      = $this->vhreservas->findById($request['id']);



        $jefe = $request['jefe'];

        //obtenemos el jefe inmediato del empleado
        $arreglo = explode(" ",$jefe);



        $nombre   = $arreglo[0];
        $apellido = $arreglo[1];

        $jefeinmediato     = $this->user->findUserByName($nombre,$apellido);





        //rellenamos el objeto con los datos del formulario
        $vhreserva->empleado            = $request['nombrecompleto'];
        $vhreserva->jefe_inmediato      = $jefeinmediato->id;
        $vhreserva->departamento_id     = $request['departamento'];
        $vhreserva->vh_vehiculo_id      = $request['vehiculo'];
        $vhreserva->fechasolicitud      = date('Ymd H:i');
        $vhreserva->motivo              = $request['motivo'];
        $vhreserva->vh_estado_id        = 1;
        $vhreserva->user_id             = Session::get('idusuario');
        $vhreserva->fechainicio         = $request['inicio'];
        $vhreserva->fechafin            = $request['fin'];


        $queryrun = $this->vhreservas->updateReserva($vhreserva);

        return response()->json($queryrun);
    }

   
    public function destroy($id)
    {
        //
    }





    //obtener reservas para el calendario
    public function getReservasForCalendario()
    {
        $reservas = $this->vhreservas->getReservasForCalendario();

        return response()->json($reservas);

    }



    //funcion para obtener reserva por medio de su id
    public function getReservaByID(Request $request)
    {
        $reserva = $this->vhreservas->getReservaByIDGet($request['id']);

        if ($reserva!=null)
        {
            return response()->json($reserva);
        }
        else
        {
            return "error";
        }
    }


    //eliminar una reserva
    public function deleteReserva()
    {

    }





    //funcion para retornar la vista de administracion de las reservas de los empleados
    public function viewSolicitudesEmpleadosByAdmin()
    {
        $conteo = "";
        $reservas = $this->vhreservas->getReservasByAdmin();

        return view('vh_reservas.admin.reservas')->with('reservas',$reservas);

        //return response()->json($reservas);
    }


    //funcion para poder generar la hoja de control
    public function generarHojaControl()
    {
        $view =  \View::make('vh_reservas.empleado.hojacontrol', compact(''))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);

        //return response()->json($iva);

        return $pdf->stream('hojacontrol.pdf');
    }


    //funcion para comprobar la disponibilidad de la reserva para la edicion
    public function comprobarDisponibilidadEdicion(Request $request)
    {
        //obtenemos el vehiculo seleccionado para la edicion
        $vehiculo = DB::table('vh_vehiculos')->where('numeracion',$request['vehiculo'])->first();

        //comprobar disponibilidad
        $disponibilidad = DB::table('vh_reservas')
            ->where('fechainicio','<',$request['fin'])
            ->where('fechafin','>',$request['inicio'])
            ->where('id','!=',$request['reserva'])
            ->where('vh_vehiculo_id',$vehiculo->id)
            ->where('vh_estado_id','!=',6)
            ->where('vh_estado_id','!=',5)
            ->where('vh_estado_id','!=',7)
            ->get();

        if(count($disponibilidad)>0 || $vehiculo->estado=='Mantenimiento')
        {
            return response()->json('reservado');

        }
        else
        {
            return response()->json('disponible');
        }


    }


    //comprobar disponibilidad de horarios
    public function comprobarDisponibilidad(Request $request)
    {
        $h1 = DateTime::createFromFormat('d/m/Y H:i',$request['inicio']);
        $h2 = DateTime::createFromFormat('d/m/Y H:i',$request['fin']);

        $inicio = date_format($h1,'Ymd H:i');
        $fin = date_format($h2,'Ymd H:i');

        $vehiculo = DB::table('vh_vehiculos')->where('numeracion',$request['vehiculo'])->first();

        $disponibilidad = DB::table('vh_reservas')
            ->where('fechainicio','<',$fin)
            ->where('fechafin','>',$inicio)
            ->where('vh_vehiculo_id',$vehiculo->id)
            ->where('vh_estado_id','!=',6)
            ->where('vh_estado_id','!=',5)
            ->where('vh_estado_id','!=',7)
            ->get();






        if(count($disponibilidad)>0 || $vehiculo->estado=='Mantenimiento')
        {
            return response()->json('reservado');

        }
        else
        {
            return response()->json('disponible');
        }



    }



    //retorna vista para las reservas de los empleados segun la jefatura logueada
    public function viewReservasByJefatura()
    {
        $reservas = $this->vhreservas->getReservasByJefatura(Session::get('idusuario'));

        return view('vh_reservas.jefatura.reservas')->with('reservas',$reservas);
    }


    //retorna la vista para la resolucion de la reserva por parte de jefatura
    public function viewResolucion(Request $request)
    {
        $departamentos  = $this->departamento->getDepartamentos();
        $vehiculos      = $this->vh_vehiculo->getVehiculos();

        $reserva = $this->vhreservas->getReservaById($request['id']);
        return view('vh_reservas.jefatura.edit')->with('reserva',$reserva)->with('departamentos',$departamentos)->with('vehiculos',$vehiculos);
        //return response()->json($reserva);
    }



    //aprobar una reserva por parte de jefatura
    public function aprobarReserva(Request $request)
    {
        //buscamos el objeto equivalente a la reserva para actualizar
        $reserva = $this->vhreservas->findById($request['id']);

       //actualizamos el objeto
        $reserva->vh_estado_id = 3;

        //persistimos el objeto
        $queryrun = $this->vhreservas->updateReserva($reserva);

        return response()->json($queryrun);

    }


    //denegar reserva
    public function denegarReserva(Request $request)
    {
        //buscamos el objeto equivalente a la reserva para actualizar
        $reserva = $this->vhreservas->findById($request['id']);

        //actualizamos el objeto
        $reserva->vh_estado_id = 2;
        $reserva->resolucion = $request['resolucion'];

        //persistimos el objeto
        $queryrun = $this->vhreservas->updateReserva($reserva);

        return response()->json($queryrun);
    }


    //funcion para imprimir hoja de uso de vehiculo
    public function imprimirHoja(Request $request)
    {
        $reserva = $this->vhreservas->getReservaByIdFirst($request['id']);
        $dueño = DB::select('select top 1 nombre,apellido from vehiculos_dueños
                inner join users  on users.id = vehiculos_dueños.user_id
                inner join vh_reservas on vh_reservas.vh_vehiculo_id = vehiculos_dueños.vh_vehiculo_id
                where vh_reservas.id = ?
                ',[$request['id']]);


        $view =  \View::make('vh_reservas.empleado.hojacontrol', compact('reserva','dueño'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);
        //return response()->json($dueño);
        return $pdf->stream('reserva.pdf');
    }



    //vista para autorizacion de vehiculo
    public function viewAutorizacionVH()
    {
        $reservas = $this->vhreservas->getReservasFromDueños(Session::get('idusuario'));


        //hacemos la busqueda si el usuario
        return view('vh_reservas.jefatura.reservas_vehiculos')->with('reservas',$reservas);
        //return response()->json($reservas);
    }


    //funcion para mostrar la edicion de la autorizacion del vehiculo solicitado
    public function viewEditAutorizacion(Request $request)
    {
        $departamentos  = $this->departamento->getDepartamentos();

        $vehiculos      = $this->vh_vehiculo->getVehiculos();

        $reserva = $this->vhreservas->getReservaById($request['id']);

        //verificamos si el usuario es jefe y dueño de vehiculo para facilitar su aprobacion de la reserva
        $duenojefe = $this->vhreservas->getDueñoJefeByReserva($request['id']);

        return view('vh_reservas.jefatura.autorizacion_vehiculo')->with('duenojefe',$duenojefe)
            ->with('reserva',$reserva)->with('departamentos',$departamentos)->with('vehiculos',$vehiculos);

        //return response()->json($dueñojefe);
    }


    //funcion para autorizar el vehiculo solicitado
    public function autorizarVehiculo(Request $request)
    {

        //buscamos el objeto equivalente a la reserva para actualizar
        $reserva = $this->vhreservas->findById($request['id']);

        //actualizamos el objeto
        $reserva->vh_estado_id = 4;

        //persistimos el objeto
        $queryrun = $this->vhreservas->updateReserva($reserva);


        //mandamos correo al jefe inmediato y al solicitante
        $ultimareserva = $this->vhreservas->getReservaByIdFirst($request['id']);


        $h1 = date_create($ultimareserva->fechainicio);
        $h2 = date_create($ultimareserva->fechafin);

        $inicio = date_format($h1,'d/m/Y H:i');
        $fin = date_format($h2,'d/m/Y H:i');

        Session::put('vehiculo',$ultimareserva->vehiculo);
        Session::put('vh_id',$ultimareserva->id);
        Session::put('vh_empleado',$ultimareserva->empleado);
        Session::put('vh_fechas',$inicio.' - '.$fin);
        Session::put('vh_motivo',$ultimareserva->motivo);




        Mail::send('email.reservas_vh.notif_autorizacion_vh', ['ultimareserva' => $ultimareserva], function ($m) use ($ultimareserva) {
            $m->from('comanda@edesal.com',  'COMANDA');
            $m->to($ultimareserva->correojefe, '')->subject('Vehiculo autorizado!');
        });

        Mail::send('email.reservas_vh.notif_autorizacion_vh', ['ultimareserva' => $ultimareserva], function ($m) use ($ultimareserva) {
            $m->from('comanda@edesal.com', 'COMANDA');
            $m->to($ultimareserva->correoempleado, '')->subject('Vehiculo autorizado!');
        });

        Mail::send('email.reservas_vh.notif_autorizacion_vh', ['ultimareserva' => $ultimareserva], function ($m) use ($ultimareserva) {
            $m->from('comanda@edesal.com', 'COMANDA');
            $m->to('dhernandez@edesal.com', '')->subject('Vehiculo autorizado!');
        });



        return response()->json($queryrun);
    }

    //funcion para autorizar el vehiculo solicitado
    public function denegarVehiculo(Request $request)
    {
        //buscamos el objeto equivalente a la reserva para actualizar
        $reserva = $this->vhreservas->findById($request['id']);

        //actualizamos el objeto
        $reserva->vh_estado_id = 5;

        //persistimos el objeto
        $queryrun = $this->vhreservas->updateReserva($reserva);

        return response()->json($queryrun);
    }



    //lanzar vista de edicion para supervisor de reservas
    public function editAdminView(Request $request)
    {
        $departamentos  = $this->departamento->getDepartamentos();
        $vehiculos      = $this->vh_vehiculo->getVehiculos();

        $reserva = $this->vhreservas->getReservaById($request['id']);
        return view('vh_reservas.admin.edit')->with('reserva',$reserva)->with('departamentos',$departamentos)->with('vehiculos',$vehiculos);
        //return response()->json($reserva);
    }



    //cancelar reserva
    public function cancelarReserva(Request $request)
    {
        $vhreserva               = $this->vhreservas->findById($request['id']);

        $vhreserva->vh_estado_id = 6;

        $queryrun = $this->vhreservas->updateReserva($vhreserva);

        //cambiamos el estado del vehiculo a disponible
        $vehiculo = VH_Vehiculos::find($vhreserva->vh_vehiculo_id);

        $vehiculo->estado = 'Disponible';

        //persistimos el objeto
        $vehiculo->save();

        return response()->json($queryrun);
    }


    //funcion para finalizar una reserva
    public function finalizarReserva(Request $request)
    {
        $reserva = $this->vhreservas->findById($request['id']);

        $reserva->vh_estado_id = 7;
        $reserva->fecha_cierre_reserva= date('Ymd H:i');

        //persistimos
        $this->vhreservas->saveReserva($reserva);

        $objeto = '';

        Session::put('reservafinalizada',$request['id']);


        Mail::send('email.reservafinalizada', [], function ($m) use ($objeto) {
            $m->from('comanda@edesal.com',  'COMANDA');
            $m->to('dhernandez@edesal.com', '')->subject('Reserva finalizada!');
        });

        $vehiculo = VH_Vehiculos::find($reserva->vh_vehiculo_id);
        $vehiculo->estado='Disponible';

        //persistimos el vehiculo
        $vehiculo->save();

        return redirect('vhadminreservas');
    }


    //funcion para que los empleados puedan finalizar la reserva
    public function finalizarReservaByEmpleado(Request $request)
    {
        $reserva = $this->vhreservas->findById($request['reserva']);

        $reserva->vh_estado_id = 7;
        $reserva->fecha_cierre_reserva= date('Ymd H:i');

        //persistimos
        $this->vhreservas->saveReserva($reserva);


        $vehiculo = VH_Vehiculos::find($reserva->vh_vehiculo_id);
        $vehiculo->estado='Disponible';

        //persistimos el vehiculo
        $query =  $vehiculo->save();

        return response()->json($query);
    }


    public function autorizarVehiculoByDuenoJefe(Request $request)
    {
        //buscamos el objeto equivalente a la reserva para actualizar
        $reserva = $this->vhreservas->findById($request['id']);

        //actualizamos el objeto
        $reserva->vh_estado_id = 3;

        //persistimos el objeto
        $queryrun = $this->vhreservas->updateReserva($reserva);

        return response()->json($queryrun);
    }


    //listar las reservas para un registro de km asi el supervisor puede adjuntar una reserva para ese registro
    public function reservasForKilometraje(Request $request)
    {


        $res = $this->vhreservas->getReservaByDateAndVehiculo($request['vehiculo'],$request['horarioinicio'].' 00:00',$request['horarioinicio'].' 23:59');

        return view('vh_reservas.admin.kilometraje.partials.reservas')->with('res',$res);

        //return response()->json($reservas);
    }

}
