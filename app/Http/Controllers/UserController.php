<?php

namespace App\Http\Controllers;

use App\Bodega;
use App\ErogacionGasto;
use App\Usuario_Rol;
use App\Vehiculo_Dueno;
use Illuminate\Http\Request;
use User;
use App\Repositories\User\UserRepository;
use App\Repositories\Tickets\TicketRepository;
use DB;
use Collection;
use Session;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Illuminate\Http\Response;
use Mail;



class UserController extends Controller
{

    //variable de usario
    protected $user;
    public $ticket;

    //metodo constructor para el controlador usuario
    public function __construct(UserRepository $user,TicketRepository $ticket)
    {
        $this->user     = $user;
        $this->ticket   = $ticket;
    }

    //erogaciones proceso
    public function verErogaciones()
    {
        $tipostarifarios = DB::table('tipos_tarifarios')->get();
        $centroscostos  = DB::table('centro_costos')->get();
        $tipoGastosGG = DB::connection('saf')->table('estructura31 ')->
         where('empresa_id',1)->where('estructura31_id', '>', 0)-> get();
        return view('home.erogaciones')->with('centrocostos',$centroscostos)->with('tipostarifarios',$tipostarifarios)
        ->with('tipoGastosGG',$tipoGastosGG);
    }


    //get extensiones
    public function getExtensiones()
    {
        $extensiones    = DB::table('extensiones')->get();
        return view('home.telefonos')->with('extensiones',$extensiones);
    }

    //retornar vista de usuarios
    public function index()
    {
        if(Session::get('idusuario'))
        {
            $conteotickets  = DB::table('tickets')->where('us_asignado',Session::get('idusuario'))->count();
            $centroscostos  = DB::table('centro_costos')->get();
            $extensiones    = DB::table('extensiones')->get();
            $conteopermisos = DB::table('permisos')->where('user_id',Session::get('idusuario'))->count();
            $conteoreservas = DB::table('vh_reservas')->where('user_id',Session::get('idusuario'))->count();
            //$conteo = $this->ticket->conteoTicketsStaff(Session::get('idusuario'));
            //$tickets = $this->ticket->getTicketsStaff(Session::get('idusuario'));
            $tipostarifarios = DB::table('tipos_tarifarios')->get();
            $ticketsproceso = $this->user->getTicketsEnProceso();

            $ticketssolicitados = $this->ticket->getTicketsNoStaff(Session::get('idusuario'));

            $ticketscompartidos = $this->ticket->getTicketsCompartidos(Session::get('idusuario'));


            $tickets  = $this->ticket->getTicketsStaff(Session::get('idusuario'));
            $conteo   = $this->ticket->conteoTicketsStaff(Session::get('idusuario'));
            $categorias = DB::table('categorias')->get();
            $sistemas = DB::table('sistemas')->get();
            $usuarios = $this->user->getUsuariosStaff();
            $dedicado = 0;

            //variable para saber cuanto tiempo dedicado en el dia llevamos como staff de informatica
            $tiempo = DB::select('SELECT SUM(tiempodedicado) as tiempo FROM bitacoras b
                  WHERE b.fechabitacora = DATEADD(dd, 0, DATEDIFF(dd, 0, GETDATE())) and user_id = ?',[Session::get('idusuario')]);

            if($tiempo>0)
            {
                $dedicado = $tiempo;
            }


            //usuario
            $usuario = $this->user->getUserById(Session::get('idusuario'));

            if($usuario->departamento_id=='' || $usuario->jefe_inmediato=='')
            {
                $departamentos = DB::table('departamentos_edesal')->get();
                return view('usuarios.info')->with('departamentos',$departamentos)->with('idusuario',Session::get('idusuario'));
            }
            else
            {
                return view('dashboard')
                    ->with('roles',Session::get('roles'))
                    ->with('conteo',$conteo)
                    ->with('tickets',$tickets)
                    ->with('conteotickets',$conteotickets)
                    ->with('conteopermisos',$conteopermisos)
                    ->with('conteoreservas',$conteoreservas)
                    ->with('extensiones',$extensiones)
                    ->with('ticketscompartidos',$ticketscompartidos)
                    ->with('centrocostos',$centroscostos)
                    ->with('tipostarifarios',$tipostarifarios)
                    ->with('ticketsproceso',$ticketsproceso)
                    ->with('dedicado',$dedicado)->with('usuarios',$usuarios)
                    ->with('ticketssolicitados',$ticketssolicitados)
                    ->with('conteo',$conteo)->with('categorias',$categorias)->with('sistemas',$sistemas);
            }


        }
        else
        {
            return redirect('/');
        }



    }



    //formulario sub-view para ingresar datos del usuario
    public function create()
    {
        //
    }



    //Crear un usuario dentro del sistema comanda    
    public function store(Request $request)
    {
        $usuario = new \App\User();

        //rellenamos el objeto
        $usuario->nombre            = $request['nombre'];
        $usuario->apellido          = $request['apellido'];
        $usuario->password          = '12345';
        $usuario->alias             = $request['alias'];
        $usuario->correo            = $request['correo'];
        $usuario->departamento_id   = $request['departamento'];
        $usuario->jefe_inmediato    = $request['jefatura'];

        //persistimos el objeto
        $queryrun = $usuario->save();

        return response()->json($queryrun);

    }


    //editar informacion extra
    public function editarInformacionExtra(Request $request)
    {
        $arreglo = explode(' ',$request['jefeinmediato']);

        $jefe = $this->user->getUserByNames($arreglo[0],$arreglo[1]);

        $usuario = $this->user->getUserByEloquentID($request['usuario']);

        //editamos informacion
        $usuario->departamento_id = $request['departamento'];
        $usuario->jefe_inmediato = $jefe->id;

        //persistimos
        $queryrun = $this->user->update($usuario);

        return response()->json($queryrun);
    }






    //Formulario sub-view para editar la informacion de un usuario
    public function edit($id)
    {
        //
    }



    //Metodo para actualizar el usuario
    public function update(Request $request, $id)
    {
        //
    }



    //Metodo para eliminar un usuario
    public function destroy($id)
    {
        //
    }



    //Metodo para validar las credenciales del usuario
    public function validacionCredenciales(Request $request)
    {
        //validamos la informacion ingresada por el usuario
        $usuario = $this->user->validarCredenciales($request['correo'],$request['password']);



       if ($usuario!='error' && $usuario!='')
        {
            //obtenemos los roles del usuario
            $roles = $this->user->getRoles($usuario->id);

            //convertimos roles a tipo array
            $arregloroles = $roles->toArray();

            //establecemos la Session de los roles activos para el login del usuario
            Session::put('roles',$arregloroles);

            //establecemos la sesion para el alias del usuario
            Session::put('alias',$usuario->alias);

            //establecemos la variable de sesion para la empresa
            Session::put('empresa',$usuario->empresa);



            //sesion para jefe inmediato
            $jefe = DB::table('users as u')->select('u.nombre as nombrejefe','u.apellido as apellidojefe')->where('u.id',$usuario->jefe_inmediato)->first();

            Session::put('jefeinmediato',$jefe->nombrejefe.' '.$jefe->apellidojefe);




            //establecemos la sesion para el nombre completo del usuario
            Session::put('nombreusuario',$usuario->nombre.' '.$usuario->apellido);

            //ID de sesion
            Session::put('idusuario',$usuario->id);

            //correo de usuario logueado
            Session::put('correousuario',$usuario->correo);

            //avatar
            Session::put('avatar',$usuario->avatar);

            //conteo de tickets nuevos del empleado
            $conteo = $this->ticket->conteoTicketsStaff(Session::get('idusuario'));

            //Sesion de los conteos de los tickets del usuario staff logueado
            Session::put('conteostaff',$conteo);

            Session::put('idjefe',$usuario->jefe_inmediato);


            //retornamos la vista del dashboard principal si las credenciales son validas
            return "success";

        }
        else
        {
            return "error";
        }


       //return response()->json($usuario);

    }


    //funcion para eliminar sesiones
    public function cerrarSesion()
    {
        //cierre de sesiones activas
        Session::forget('roles');
        Session::forget('idusuario');
        Session::forget('alias');
        Session::forget('nombreusuario');
        Session::forget('id');
        Session::forget('asignado');
        Session::forget('solicitante');
        Session::forget('descripcion');
        Session::forget('titulo');

        return redirect('/');
    }


    //funcion para obtener los usuarios con rol de jefatura
    public function obtenerJefaturas()
    {
        //obtenemos los usuarios con jefatura invocando al repositorio
        $usuarios = $this->user->getUsuariosXJefatura();

        if ($usuarios!=null)
        {
            return json_encode($usuarios);
        }
        else
        {
            return json_encode("Error encontrado: ".$usuarios);
        }

    }



    //obtener todos los usuarios
    public function usuariosAll()
    {
        $usuarios = $this->user->getUsuariosAll();

        return response()->json($usuarios);
    }




    //funcion para vista de mi perfil
    public function miPerfil()
    {
        $avatars = 29;
        return view('usuarios.edit')->with('conteos',$avatars);
    }



    //funcion para editar perfil
    public function editPerfil(Request $request)
    {
        $user = $this->user->getUserByEloquentID(Session::get('idusuario'));

        $user->password = md5($request['contrasena']);
        $user->avatar   = $request['avatar'];


        //persistimos el objeto usuario
        $queryrun = $this->user->update($user);

        if($queryrun==1)
        {
            return response()->json("success");
        }
        else
        {
            return response()->json($queryrun);
        }

    }


    //funcion para nueva encriptacion
    public function contraseñaMD5(Request $request)
    {

    }


    //funcion para mostrar los usuarios con sus roles
    public function show()
    {
        $vehiculos = DB::table('vh_vehiculos')->get();
        $roles = DB::table('roles')->get();
        $usuarios = $this->user->getUsuariosAll();
        $centrocostos = DB::table('centro_costos')->get();
        
        $bodegas = DB::table('bodegas')->get();
        $departamentos = DB::table('departamentos_edesal')->get();
        $usuarios = DB::table('users')->get();


        return view('usuarios.show')->with('usuarios',$usuarios)->with('roles',$roles)->with('vehiculos',$vehiculos)
            ->with('bodegas',$bodegas)->with('centrocostos',$centrocostos)->with('usuarios',$usuarios)->with('departamentos',$departamentos);

    }


    //funcion para obtener la info - detalle del usuario por su id
    public function getInfoUsuarioById(Request $request)
    {
        $info = $this->user->getInfoDetalleUser($request['id']);

        return response()->json($info);
    }


    //funcion para poder obtener los roles de un usuario
    public function getRoles(Request $request)
    {
        $roles = $this->user->getRolesByIdUser($request['id']);

        return response()->json($roles);
    }


    //funcion para asignar un rol
    public function asignarRol(Request $request)
    {
        //variable usuario-rol de tabla de la base de datos
        $ur = new Usuario_Rol();

        $ur->user_id = $request['usuario'];
        $ur->rol_id  = $request['rol'];

        //persistimos el objeto
        $queryrun = $ur->save();

        return response()->json($queryrun);
    }


    //asignar un vehiculo a un usuario
    public function asignarVehiculo(Request $request)
    {
        //objeto de vehiculo_dueño
        $vd = new Vehiculo_Dueno();

        //rellenamos el objeto
        $vd->vh_vehiculo_id = $request['vehiculo'];
        $vd->user_id = $request['usuario'];

        //persistimos el objeto
        $queryrun = $vd->save();

        return response()->json($queryrun);
    }


    //asignar bodega y cc a usuario
    public function asignarBodegaCC(Request $request)
    {
        //objeto usuario
        $usuario = $this->user->getUserByEloquentID($request['usuario']);

        //rellenamos el objeto usuario
        $usuario->centro_costos_id = $request['cc'];

        //persistimos el objeto usuario
        $queryrun = $usuario->save();


        //objeto bodegas
        $bodega = Bodega::find($request['bodega']);

        //rellenamos objeto bodega
        $bodega->supervisor = $request['usuario'];

        //persistimos el objeto
        $queryrun = $bodega->save();

        return response()->json($queryrun);

    }


    //funcion para editar la informacion general de un usuario por parte de informatica
    public function editInfoUserByInformatica(Request $request)
    {
        $usuario = $this->user->getUserByEloquentID($request['usuario']);

        //rellenamos el objeto
        $usuario->nombre            = $request['nombre'];
        $usuario->apellido          = $request['apellido'];
        $usuario->alias             = $request['alias'];
        $usuario->correo            = $request['correo'];
        $usuario->departamento_id   = $request['departamento'];
        $usuario->jefe_inmediato    = $request['jefatura'];


        //persistimos el objeto
        $queryrun = $usuario->save();

        return response()->json($queryrun);
    }



    //eliminar rol para usuario
    public function elminarRolForUser(Request $request)
    {
        $queryrun = DB::table('usuario_rol')->where('user_id',$request['usuario'])->where('rol_id',$request['rol'])->delete();

        return response()->json($queryrun);

    }


    //confirmar correo de usuario
    public function confirmarCorreo(Request $request)
    {
        $usuario = $this->user->getUserByCorreo($request['correo']);

        if($usuario=='')
        {
            return response()->json('no valido');
        }
        else
        {
            return response()->json('valido');
        }



    }

    //nueva contraseña
    public function reestablecerContraseña(Request $request)
    {
        $u = $this->user->getUserByCorreo($request['correo']);

        $usuario = $this->user->getUserByEloquentID($u->id);

        $passwordencrypt = md5($request['password']);

        $usuario->password = $passwordencrypt;


        //persistimos el objeto
        $queryrun = $usuario->save();

        Mail::send('email.restablecerpassword', ['usuario' => $usuario], function ($m) use ($usuario) {
            $m->from('comanda@edesal.com', 'COMANDA');
            $m->to($usuario->correo, '')->subject('Restablecimiento de contraseña!');
        });


        return response()->json($queryrun);
    }


    //listar tipos de gastos
    public function listarTiposGastos(Request $request)
    {
        $tipoactividad = DB::table('tipos_tarifarios')->where('id',$request['tipoactividad'])->first();
        
        

        if($tipoactividad->categoria_gasto_id == '1'){
            $tiposgastos =  DB::connection('saf')->table('Estructura21')->where('estructura21_id', '>',0)
            ->where('estructura21_id', '<',100)->get();

            return response()->json($tiposgastos);
        }

        if($tipoactividad->categoria_gasto_id == '2'){
            $tiposgastos =  DB::connection('saf')->table('Estructura21')->where('estructura21_id', '>=',400)
            ->where('estructura21_id', '<',600)->get();

            return response()->json($tiposgastos);
        }

        if($tipoactividad->categoria_gasto_id == '3'){
            $tiposgastos =  DB::connection('saf')->table('Estructura21')->where('estructura21_id', '>=',200)
            ->where('estructura21_id', '<',400)->get();

            return response()->json($tiposgastos);
        }

        if($tipoactividad->categoria_gasto_id == '4'){
            $tiposgastos =  DB::connection('saf')->table('Estructura21')->where('estructura21_id', '>=',600)->get();

            return response()->json($tiposgastos);
        }

        
    }


    

}
