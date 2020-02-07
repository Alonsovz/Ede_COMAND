<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Permisos\PermisoRepository;
use App\Repositories\TipoPermisos\TipoPermisoRepository;
use App\Repositories\Departamentos\DepartamentoRepository;
use App\Repositories\User\UserRepository;
use App\Permiso;
use DateTime;
use Session;
use PDF;
use App\Jobs\ImprimirPermiso;
use JasperPHP\JasperPHP as JasperPHP;
use Input;
use DB;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use Mail;


class PermisoController extends Controller
{
    //variables globales
    protected $tipopermiso;
    protected $permiso;
    protected $departamento;
    protected $user;

    function __construct(UserRepository $user,TipoPermisoRepository $tipopermiso,PermisoRepository 
                        $permiso, DepartamentoRepository $departamento)
    {
        $this->permiso      = $permiso;
        $this->tipopermiso  = $tipopermiso;
        $this->departamento = $departamento;
        $this->user         = $user;
    }


    //funcion index de permisos
    public function index()
    {
        //obtenemos los tipos de permisos y los departamentos
        $tipopermiso        = $this->tipopermiso->getTiposPermisos();
        $departamentos      = $this->departamento->getDepartamentos();

        


        return view('permisos.index')
                                    ->with('departamentos',$departamentos)
                                    ->with('tipopermisos',$tipopermiso);
        //return view('mantenimiento.mantenimiento');
    }





   
    public function create()
    {
        
    }



    //vista para nuevos graficos
    public function estadisticas()
    {
        return view('permisos.rrhh.reportes.index');
    }






    //funcion para guardar el permiso ingresado por el usuario    
    public function store(Request $request)
    {
       DB::beginTransaction();




        //convertimos las fechas
        $fechain            = date_create_from_format('Ymd H:i',$request['fechainicio']);
        $fechafin           = date_create_from_format('Ymd H:i',$request['fechafin']);


        //damos formato a las fechas para guardarlas en la base de datos
        $fechainicial       = date_format($fechain,'Ymd H:i');
        $fechafinal         = date_format($fechafin,'Ymd H:i');



            //obtenemos el jefe inmediato del empleado
            $arreglo = explode(' ', $request['jefeinmediato']);

            $nombre   = $arreglo[0];
            $apellido = $arreglo[1];

            $jefe     = $this->user->findUserByName($nombre,$apellido);

            $jefe_id = $jefe->id;




        $permiso  = new Permiso;

        $fechaformateada = date('Ymd');

        $permiso->empleado                      = $request['empleado'];

        $permiso->departamento_id               = $request['departamento'];
        $permiso->jefeinmediato                 = $jefe_id;
        $permiso->tipo_permiso_id               = $request['tipopermiso'];
        $permiso->fechainicio                   = $fechainicial;
        $permiso->fechafin                      = $fechafinal;
        $permiso->motivopermiso                 = $request['motivopermiso'];
        $permiso->user_id                       = Session::get('idusuario');
        $permiso->fechasolicitud                = $fechaformateada;
        $permiso->rh_estados_id                 = 1;


        $queryrun = $this->permiso->savePermiso($permiso);



        //persistimos el objeto permiso
        if ($queryrun==true)
        {
            DB::commit();

            //damos formato a las fechas para guardarlas en la base de datos
            $fechainicial       = date_format($fechain,'d/m/Y H:i');
            $fechafinal         = date_format($fechafin,'d/m/Y H:i');

            //ultimo permiso ingresado con los datos completos
            $p = $this->permiso->getLastPermiso();

            //Session::put('id',$p->id);
            Session::put('empleado',$p->nombreempleado.' '.$p->apellidoempleado);
            Session::put('fechassolicitadas',$fechainicial.' - '.$fechafinal);
            Session::put('motivopermiso',$p->motivopermiso);

            //enviar correo con notificacion de acualizacion de datos de cliente
           Mail::send('email.nuevasolicitud', ['p' => $p], function ($m) use ($p) {
                $m->from('comanda@edesal.com', $p->nombreempleado.' '.$p->apellidoempleado);
                $m->to($p->correojefatura, '')->subject('Nueva solicitud de ausencia laboral!');
            });


            Mail::send('email.nuevasolicitud', ['permiso' => $p], function ($m) use ($p) {
                $m->from('comanda@edesal.com', $p->nombreempleado.' '.$p->apellidoempleado);
                $m->to('dhernandez@edesal.com', '')->subject('Nueva solicitud de ausencia laboral!');
            });

            //enviar correo con notificacion de acualizacion de datos de cliente
            Mail::send('email.nuevasolicitud', ['permiso' => $p], function ($m) use ($p) {
                $m->from('comanda@edesal.com', 'COMANDA');

                $m->to('jmorales@edesal.com', '')->subject('Nueva solicitud!');
            });


            return json_encode($queryrun);

        }
        else
        {
            DB::rollBack();
            return json_encode($queryrun);
        }
            

    }







    //funcion para poder listar el permiso con sus detalles por medio de su id
    public function edit(Request $request)
    {
        //obtenemos los detalles del permiso seleccionado
        $permiso = $this->permiso->getPermisoById($request['idpermiso']);

        if ($permiso!=null) 
        {
            return json_encode($permiso);
        }
        else
        {
            return json_encode("Error");
        }
    }





  
    //funcion para actualizar un permiso


    public function update(Request $request)
    {
        //opcion para actualizar
        $opcion     = $request['opcion'];

        switch ($opcion) {

            case 'aprobar':
                


                $permisoELOQUENT = $this->permiso->eloquentFindPermiso($request['idpermiso']);

                //llenamos el objeto para actualizar su estado 
                $permisoELOQUENT->rh_estados_id     = 3;
                $permisoELOQUENT->gocesueldo        = $request['gocesueldo'];

                //persistimos el objeto
                $queryrun = $this->permiso->savePermiso($permisoELOQUENT);

                //realizamos la busqueda del permiso
                $permiso  = $this->permiso->getPermiso($request['idpermiso']);

                Session::put('id',$request['idpermiso']);
                Session::put('motivopermiso',$permiso->motivopermiso);
                Session::put('estado',$permiso->estado);

               Mail::send('email.permisos.aprobado', ['permiso' => $permiso], function ($m) use ($permiso) {
                    $m->from('comanda@edesal.com', $permiso->nombrejefe.' '.$permiso->apellidojefe);
                    $m->to($permiso->correoempleado, '')->subject('Resolución de permiso solicitado');
                });

                return response()->json($queryrun);

                break;

            case 'denegar':


                $permisoELOQUENT = $this->permiso->eloquentFindPermiso($request['idpermiso']);



                //llenamos el objeto para actualizar su estado 
                $permisoELOQUENT->rh_estados_id         = 6;
                $permisoELOQUENT->comentariodenegacion  = $request['comentariodenegacion'];
                
                $queryrun   = $this->permiso->updateEstado($permisoELOQUENT);

                //realizamos la busqueda del permiso
                $permiso  = $this->permiso->getPermiso($request['idpermiso']);

                //persistimos la actualizacion del objeto
                if ($queryrun=='success') 
                {
                    Session::put('id',$request['idpermiso']);
                    Session::put('motivopermiso',$permiso->motivopermiso);
                    Session::put('estado',$permiso->estado);
                    Session::put('comentario',$permiso->comentariodenegacion);

                    Mail::send('email.permisos.aprobado', ['permiso' => $permiso], function ($m) use ($permiso) {
                        $m->from('comanda@edesal.com', $permiso->nombrejefe.' '.$permiso->apellidojefe);
                        $m->to($permiso->correoempleado, '')->subject('Resolución de permiso solicitado');
                    });

                    return "success";

                }
                else
                {
                    return json_encode($queryrun);
                }

                break;

            case 'revision':
                
                //realizamos la busqueda del permiso 
                $permiso  = $this->permiso->getPermiso($request['idpermiso']);

                //llenamos el objeto para actualizar su estado 
                $permiso->rh_estados_id     = 4;
                $permiso->constancia        = $request['constancia'];
                $permiso->comentario        = $request{'comentario'};


                $queryrun   = $this->permiso->updateEstado($permiso);


                //persistimos la actualizacion del objeto
                if ($queryrun=='success')
                {
                    return "success";
                }
                else
                {
                    return json_encode($queryrun);
                }

                break;

            case 'actualizar_em':
                //convertimos las fechas
                $fechain            = date_create_from_format('d/m/Y H:i',$request['fechainicio']);
                $fechafin           = date_create_from_format('d/m/Y H:i',$request['fechafin']);


                //damos formato a las fechas para guardarlas en la base de datos
                $fechainicial       = date_format($fechain,'Ymd H:i');
                $fechafinal         = date_format($fechafin,'Ymd H:i');


                //obtenemos el jefe inmediato del empleado
                $arreglo = explode(' ', $request['jefeinmediato']);

                $nombre   = $arreglo[0];
                $apellido = $arreglo[1];

                $jefe     = $this->user->findUserByName($nombre,$apellido);

                $id = $request['id'];

                //buscamos permiso para actualizar sus campos
                $permiso = $this->permiso->eloquentFindPermiso($id);


                $fechasol = $permiso->fechasolicitud;

                $permiso->empleado                      = $request['empleado'];
                $permiso->departamento_id               = $request['departamento'];
                $permiso->jefeinmediato                 = $jefe->id;
                $permiso->tipo_permiso_id               = $request['tipopermiso'];
                $permiso->fechainicio                   = $fechainicial;
                $permiso->fechafin                      = $fechafinal;
                $permiso->motivopermiso                 = $request['motivopermiso'];
                $permiso->fechasolicitud                = $fechasol;

                $queryrun = $this->permiso->savePermiso($permiso);

                return response()->json($queryrun);

                break;
                
            default:
                
                break;
        }
    }


    //funcion para actualizar un permiso por parte del empleado
    public function actualizarPermisoByEmpleado(Request $request)
    {

    }


    //funcion para eliminar un permiso
    public function destroy($id)
    {
        
    }






    //funcion para devolver la vista de la bandeja de permisos para recursos humanos
    public function indexRRHH()
    {
        //obtenemos los permisos sin restriccion
        $permisos   = $this->permiso->getPermisos();

        //obtenemos el conteo de los permisos con estado enviado
        $conteo     = $this->permiso->getConteo();

        //return json_encode($permisos);

        return view('permisos.rrhh.bandejarrhh')->with('permisos',$permisos)->with('conteopermisos',$conteo);
    }






    //funcion para devolver la vista de la bandeja de permisos para recursos humanos
    public function indexJefatura()
    {
        //obtenemos los permisos sin restriccion
        $permisos   = $this->permiso->getPermisosJefatura();

        //obtenemos el conteo de los permisos con estado enviado
        $conteo     = $this->permiso->getConteoJefatura();

        //return json_encode($permisos);

        return view('permisos.jefatura.bandejajefatura')->with('permisos',$permisos)->with('conteopermisos',$conteo);
    }




    
    
    //mostrar index de empleado
    public function indexEmpleado()
    {
        //obtenemos los permisos sin restriccion
        $permisos   = $this->permiso->getPermisosEmpleado();
        
        //obtenemos el conteo de los permisos con estado enviado
        $conteo     = $this->permiso->getConteoEmpleado();

        //obtenemos los tipos de permisos y los departamentos
        $tipopermiso        = $this->tipopermiso->getTiposPermisos();
        $departamentos      = $this->departamento->getDepartamentos();
        
       
        return view('permisos.empleado.bandejaempleado')
                                            ->with('permisos',$permisos)
                                            ->with('conteopermisos',$conteo)
                                            ->with('tipopermisos',$tipopermiso)
                                            ->with('departamentos',$departamentos);

//                                            return json_encode($permisos);
    }






    //funcion para mostrar la vista de los permisos aprobados por jefatura
    public function viewAprobadosJefatura()
    {
        //permisos aprobados por jefatura
        $permisos   = $this->permiso->aprobadosjefatura();

        //obtenemos el conteo de los permisos con estado enviado
        $conteo     = $this->permiso->getConteoJefatura();

        return view('permisos.jefatura.aprobadosjefatura')->with('permisos',$permisos)->with('conteo',$conteo);
    }







    //funcion para mostrar la vista de los permisos aprobados por jefatura para RRHH
    public function viewAprobadosByRRHH()
    {
        
        //permisos aprobados por jefatura
        $permisos   = $this->permiso->aprobadosRRHH();

        //obtenemos el conteo de los permisos con estado enviado
        $conteo     = $this->permiso->getConteo();

        return view('permisos.rrhh.aprobadosrrhh')
                                ->with('permisos',$permisos)
                                ->with('conteo',$conteo);

                                //return json_encode($permisos);


    }






    //funcion para mostrar la vista de los permisos rechazados por jefatura
    public function viewRechazadosJefatura(){

        //permisos aprobados por jefatura
        $permisos   = $this->permiso->rechazadosJefatura();

        //obtenemos el conteo de los permisos con estado enviado
        $conteo     = $this->permiso->getConteoJefatura();

        return view('permisos.jefatura.rechazadosjefatura')->with('permisos',$permisos)->with('conteopermisos',$conteo);

        //return json_encode($permisos);
    }






    //funcion para imprimir el permiso 
    public function imprimirPermiso()
    {
        //obtenemos los detalles del permiso seleccionado
        $permiso    = $this->permiso->getPermisoById('20259');

        //return json_encode($permiso);

        $pdf        = PDF::loadview('permisos.permisosPDF',['permiso'=>$permiso]);

        return $pdf->download('permiso.pdf');


        //return view('permisos.permisosPDF')->with('permiso',$permiso);

        
    }






    //funcion para mostrar los rechazados para rrhh
    public function viewRechazadosByRRHH()
    {
        //permisos aprobados por jefatura
        $permisos   = $this->permiso->rechazadosRRHH();

        //obtenemos el conteo de los permisos con estado enviado
        $conteo     = $this->permiso->getConteo();

        return view('permisos.rrhh.rechazadosrrhh')->with('permisos',$permisos)->with('conteopermisos',$conteo);

        //return json_encode($permisos);
    }
    





   //funcion para mostrar vista de aprobados empleado
    public function viewAprobadosEmpleado()
    {
        //permisos aprobados por jefatura
        $permisos   = $this->permiso->aprobadosEmpleado();

       

        return view('permisos.empleado.aprobadosempleados')->with('permisos',$permisos);

        //return json_encode($permisos);
    }



    //funcion para mostrar la vista de la edicion de un permiso
    public function viewEdit(Request $request)
    {
        $id = Input::get('idpermiso');
        
        //obtenemos los tipos de permisos y los departamentos
        $tipopermiso        = $this->tipopermiso->getTiposPermisos();
        $departamentos      = $this->departamento->getDepartamentos();

        //obtenemos los detalles del permiso seleccionado
        $permiso = $this->permiso->getPermisoById($id);

        if ($permiso!=null) 
        {
            return view('permisos.edit')
                                    ->with('departamentos',$departamentos)
                                    ->with('tipopermisos',$tipopermiso)
                                    ->with('permisos',$permiso);

            //return json_encode($permiso);
        }
        else
        {
            return view('permisosempleados');
        }

    }


    //vista para los permisos rechazados de empleado
    public function rechazadosByEmpleados()
    {
        //permisos aprobados por jefatura
        $permisos           = $this->permiso->rechazadosEmpleados();
        $tipopermiso        = $this->tipopermiso->getTiposPermisos();
        $departamentos      = $this->departamento->getDepartamentos();


        return view('permisos.empleado.rechazadosempleados')->with('permisos',$permisos)
            ->with('departamentos',$departamentos)->with('tipopermisos',$tipopermiso);

        return json_encode($permisos);
    }






    //funcion para editar un permiso
    public function saveEdicion(Request $request)
    {
        //convertimos las fechas
        $fechain            = DateTime::createFromFormat('d/m/Y',$request['fechainicio']);
        $fechafin           = Datetime::createFromFormat('d/m/Y',$request['fechafin']);


        //damos formato a las fechas para guardarlas en la base de datos
        $fechainicial       = date_format($fechain,'Ymd');
        $fechafinal         = date_format($fechafin,'Ymd');


        //obtenemos el jefe inmediato del empleado
        $arreglo = explode(' ', $request['jefeinmediato']);

        $nombre   = $arreglo[0];
        $apellido = $arreglo[1];

        $jefe     = $this->user->findUserByName($nombre,$apellido);


        $permiso  = $this->permiso->getPermisoFirst($request['idpermiso']);

        $fechaformateada = date('Ymd');

        $permiso->empleado                      = $request['empleado'];
        
        $permiso->departamento_id               = $request['departamento'];
        $permiso->jefeinmediato                 = $jefe->id;
        $permiso->tipo_permiso_id               = $request['tipopermiso'];
        $permiso->fechainicio                   = $fechainicial;
        $permiso->fechafin                      = $fechafinal;
        $permiso->horainicio                    = $request['horainicio'];
        $permiso->horafin                       = $request['horafin'];
        $permiso->horasalida                    = $request['horasalida'];
        $permiso->horaentrada                   = $request['horaentrada'];
        $permiso->motivopermiso                 = $request['motivopermiso'];

        $runquery = $this->permiso->editPermiso($permiso);


        //persistimos el objeto permiso para guardar su edicion
        if ($runquery==1) 
        {
            return "success";
        }
        else
        {
            return "Error ".$runquery;
        }

     
    }



    //descargar PDF
    public function descargarPDF(Request $request)
    {
        $permiso = $this->permiso->getPermisoById($request['id']);

        $view =  \View::make('permisos.permisosPDF', compact('permiso'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);

        //return response()->json($iva);

        return $pdf->stream('permiso.pdf');

    }



    //index estadisticas
    public function viewEstadisticas()
    {
        return view('permisos.rrhh.estadisticas');
    }


    //funcion para lanzar el grafico de pastel por area segun un rango de fechas
    public function graficoPastelByAreas(Request $request)
    {
        //variables para el rango de fechas
        $desde      = $request['desde'];
        $hasta      = $request['hasta'];

        $grafico    = $this->permiso->permisosByArea($desde,$hasta);

        return json_encode($grafico);


    }


    //funcion para lanzar el grafico de barra por empleado mensual o historico
    public function graficoBarraEmpleado(Request $request)
    {
        //buscamos el id del empleado
        $nombres    = explode(' ',$request['empleado']);

        $nombre     = $nombres[0];
        $apellido   = $nombres[1];

        $usuario    = $this->user->findUserByName($nombre,$apellido);

        //devolvemos la query para el grafico
        $querygrafico = $this->permiso->permisosByEmpleadoHistorico($usuario->id);

        return response()->json($querygrafico);


    }



    //funcion para lanzar el grafico de barra por tipo de permiso de las areas
    public function graficoTipoPermisosByArea(Request $request)
    {
        //obtenenos el departamento por medio del nombre
        $departamento = $this->departamento->findDepartamentoByName($request['departamento']);


        //obtenemos el grafico
        $grafico = $this->permiso->graph_tipoPermisosByArea($departamento->id);

        //mostramos el grafico
        return response()->json($grafico);
    }

    //devolver vista para editar un permiso
    public function editPermisoEmpleado(Request $request)
    {
        $permisos = $this->permiso->getPermisoById($request['id']);
        $departamentos = $this->departamento->getDepartamentos();
        $tipopermisos = $this->tipopermiso->getTiposPermisos();


        return view('permisos.empleado.edit')
            ->with('tipopermisos',$tipopermisos)
            ->with('departamentos',$departamentos)
            ->with('permisos',$permisos);
    }



    //funcion para generar el reporte detalle de los permisos solicitados
    public function rpt_DetallePermisos(Request $request)
    {
        /*$u = explode(' ',$request['empleado']);

        $empleado= $this->user->getUserByNames($u[0],$u[1]);

        $detalles = $this->permiso->rpt_detalles($request['desde'],$request['hasta'],$empleado->id);

        return view('permisos.rrhh.reportes.rpt_cantidadpermisosemp')->with('detalles',$detalles);*/


        $detalles = $this->permiso->rpt_detalles($request['desde'],$request['hasta']);

        return view('permisos.rrhh.partial_detallepermisos')->with('detalles',$detalles);

        //return view('permisos.rrhh.partial_detallepermisos')->with('detalles',$detalles);
    }



    //funcion para generar los detalles de los permisos en formato excel
    public function excel_DetallePermisos(Request $request)
    {
        $query = $this->permiso->rpt_detalles($request['desde'],$request['hasta']);

        Excel::create('permisos_detalle', function($excel) use($query) {
            $excel->sheet('detalles', function($sheet) use($query) {

                $sheet->loadView('permisos.rrhh.excel_detallepermisos')
                    ->with('detalles',$query);

            });
        })->export('xls');
    }



    //funcion para el detalle de los permisos solicitados por empleado
    public function rpt_DetallePorEmpleado(Request $request)
    {
        $array = explode(' ',$request['empleado']);
        $empleado = $this->user->findUserByName($array[0],$array[1]);

        $tipospermisos = DB::table('tipos_permisos')->get();


        $detalle = $this->permiso->queryDetallePorEmpleado($request['desde'],$request['hasta'],$empleado->id);

        return view('permisos.rrhh.reportes.rpt_detalleXempleado')->with('detalles',$detalle)
            ->with('tipos',$tipospermisos)->with('empleado',$empleado->nombre." ".$empleado->apellido);
    }


    //funcion para lanzar el pdf del detalle de los permisos solicitados por empleado
    public function pdf_DetallePorEmpleado(Request $request)
    {
        $array = explode(' ',$request['empleado']);
        $emp = $this->user->findUserByName($array[0],$array[1]);

        $tipos = DB::table('tipos_permisos')->get();

        $empleado = $emp->nombre." ".$emp->apellido;


        $detalles = $this->permiso->queryDetallePorEmpleado($request['desde'],$request['hasta'],$emp->id);

        $view =  \View::make('permisos.rrhh.reportes.pdf_detalleXempleado', compact('tipos','detalles','empleado'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);

        //return response()->json($iva);

        return $pdf->stream('permisos_empleado.pdf');
    }


    //funcion para devolver el conteo de permisos por categoria de un empleado en un rango especificado
    public function getConteoXCategoria(Request $request)
    {
        $array = explode(' ',$request['empleado']);

        $empleado = $this->user->getUserByNames($array[0],$array[1]);

        $detalles = $this->permiso->rpt_detalles1($request['desde'],$request['hasta'],$empleado->id);

        return response()->json($detalles);
    }

}
