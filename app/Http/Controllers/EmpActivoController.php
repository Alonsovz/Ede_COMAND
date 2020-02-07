<?php

namespace App\Http\Controllers;

use App\ACT_Bajas;
use App\ACT_Traslados;
use App\EmpActivo;
use App\HojaActivos;
use App\User;
use App\Validacion_Activos;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;
use Session;
use DB;
use Mail;
use Barryvdh\DomPDF\PDF;
use Maatwebsite\Excel\Facades\Excel;


use App\Repositories\Activos\ActivoRepository;
use App\Repositories\User\UserRepository;

class EmpActivoController extends Controller
{
    public $activo;
    public $user;


    //constructor
    function __construct(ActivoRepository $activo,UserRepository $user)
    {
        $this->activo = $activo;
        $this->user = $user;
    }


    public function indexSuperv()
    {
        $activos = $this->activo->getActivosAll();
        $bodegas = DB::table('bodegas')->get();



        return view('activos.supervisor.index')
            ->with('activos',$activos)
            ->with('bodegas',$bodegas);

        //return response()->json($activos);
    }


    //Validacion de activos positiva por parte del empleado
    public function validacionPositiva()
    {
        //creamos el objeto
        $validacion = new Validacion_Activos();

        $validacion->user_id = Session::get('idusuario');
        $validacion->estado  = 1;
        $validacion->fecha_validacion = date('Ymd H:i');


        //persistimos el objeto
        $query = $validacion->save();

        return response()->json($query);

    }

    public function validacionNegativa(Request $request)
    {
        //creamos el objeto
        $validacion = new Validacion_Activos();

        $validacion->user_id = Session::get('idusuario');
        $validacion->estado  = 0;
        $validacion->fecha_validacion = date('Ymd H:i');
        $validacion->comentario = $request['comentario'];



        //persistimos el objeto
        $query = $validacion->save();

        return response()->json($query);

    }



    //vista de las validaciones realizadas por los usuarios
    public function showSuperv()
    {
        $validaciones = DB::table('validacion_activos as v')
                        ->join('users as u','u.id','=','v.user_id')
                        ->select('v.*','u.nombre','u.apellido')->get();


        return view('activos.supervisor.show')->with('validaciones',$validaciones);

    }

    //FUNCION PARA MOSTRAR LA VISTA DE JEFATURA PARA VER LOS ACT DE LOS EMPLEADOS
    public function showJefaturaAct()
    {
        $activos = $this->activo->getActivosAllByJefatura();

        return view('activos.jefatura.index')->with('activos',$activos);

        //return response()->json($activos);
    }


    //imprimir mis activos
    public function imprimirMisActivos()
    {
        $activos = $this->activo->getActivosByIdEmpleado(Session::get('idusuario'));

        $usuario = DB::table('users')->where('users.id',Session::get('idusuario'))->first();

        $pdf = \App::make('dompdf.wrapper');

        $view =  \View::make('activos.empleado.misactivos_pdf', compact('pdf','activos','usuario'))->render();

        $pdf->loadHTML($view);

        return $pdf->stream('misactivos.pdf');
    }


    public function index()
    {

        $bodegas = DB::table('bodegas')->get();
        $centrocostos = DB::table('centro_costos')->get();
        $departamentos = DB::table('DEPSV')->get();
        $agencias = DB::table('agencias')->get();

        $activos = $this->activo->getActivosByIdEmpleado(Session::get('idusuario'));

        $tipostraslados = DB::table('act_tipos_traslados')->get();

        $categoriasinsumos = DB::table('insumos_categorias')->get();

        $validacion = DB::table('validacion_activos')->where('user_id',Session::get('idusuario'))->first();

        $areas = DB::table('departamentos_edesal')->orderBy('departamentos_edesal.nombre','asc')->get();

        return view('activos.empleado.index')->with('activos',$activos)->with('validacion',$validacion)
                    ->with('centros',$centrocostos)
                    ->with('bodegas',$bodegas)
                    ->with('agencias',$agencias)
                    ->with('tipostraslados',$tipostraslados)
                    ->with('departamentos',$departamentos)
                    ->with('areas',$areas);
        
        
        
        
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
        $activo = new EmpActivo();

        $array = explode(' ',$request['n_empleado']);

        if($request['n_fecha']!='')
        {
            $f = date_create_from_format('d/m/Y',$request['n_fecha']);
            $fecha = date_format($f,'Ymd');
        }
        else
        {
            $fecha = '';
        }

        $empleado = $this->user->findUserByName($array[0],$array[1]);

        $activo->empleado                   = $empleado->id;
        $activo->tipo_activo                = $request['n_activo'];
        $activo->marca                      = $request['n_marca'];
        $activo->modelo                     = $request['n_modelo'];
        if($fecha){$activo->fecha           = $fecha;}
        $activo->ccf                        = $request['n_ccf'];
        $activo->proveedor                  = $request['n_proveedor'];
        $activo->valor                      = (double)$request['n_valor'];
        $activo->area_inversion             = $request['n_areainversion'];
        $activo->ubicacion                  = $request['n_ubicacion'];
        $activo->color                      = $request['n_color'];
        $activo->cantidad                   = 1;
        $activo->estado_activo              = 2;
        $activo->categoria_activo           = $request['categoria'];
        $activo->finalidad                  = $request['finalidad'];



        //persisitmos
        $query = $activo->save();

        return response()->json($query);


    }


    public function show($id)
    {

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


    public function update(Request $request)
    {
        $usuario = explode(' ',$request['empleado']);

        $empleado = $this->user->findUserByName($usuario[0],$usuario[1]);

        //creamos el objeto de tipo activo
        $activo  = EmpActivo::find($request['id']);

        if($request['fecha'])
        {
            $f = date_create_from_format('d/m/Y',$request['fecha']);
            $fecha = date_format($f,'Ymd');
        }
        else
        {
            $fecha = '';
        }

        //llenamos el objeto
        $activo->tipo_activo                = $request['activo'];
        $activo->empleado                   = $empleado->id;
        $activo->marca                      = $request['marca'];
        $activo->modelo                     = $request['modelo'];
        if($fecha){$activo->fecha           = $fecha;}
        $activo->ccf                        = $request['ccf'];
        $activo->proveedor                  = $request['proveedor'];
        $activo->valor                      = $request['valor'];
        $activo->area_inversion             = $request['areainversion'];
        $activo->ubicacion                  = $request['ubicacion'];
        $activo->color                      = $request['color'];
        $activo->finalidad                  = $request['finalidad'];
        $activo->bodega_id                  = $request['bodega'];




        //persistimos el objeto
        $query = $activo->save();

        return response()->json($query);


    }



    public function destroy(Request $request)
    {
        $activos = $request['activos'];
        $query = '';

        //proceso de eliminacion de activos asignados a los empleados
        for($i=0; $i<=count($activos)-1; $i++)
        {
            //buscamos objeto por medio del id seleccionado en el formulario
            $activo = EmpActivo::find($activos[$i]);

            //eliminamos
            $query = $activo->delete();
        }

        return response()->json($query);
    }



    //buscar un activo por id
    public function finActivoById(Request $request)
    {
        $activo = $this->activo->findLineaActivoById($request['id']);

        return response()->json($activo);

    }



    //generar reporte por empleado
    public function rpt_ActivosXEmpleado(Request $request)
    {
        $formato = $request['formato'];

        switch ($formato)
        {
            case 'pdf':
                $array = explode(' ',$request['empleado']);
                $usuario = $this->user->findUserByName($array[0],$array[1]);

                $activos = $this->activo->getActivosByIdEmpleado($usuario->id);


                $pdf = \App::make('dompdf.wrapper');

                $view =  \View::make('activos.empleado.misactivos_pdf', compact('activos','usuario'))->render();

                $pdf->loadHTML($view);

                return $pdf->stream('activos'.$usuario->nombre.''.$usuario->apellido.'pdf');
                break;
            case 'excel':
                $array = explode(' ',$request['empleado']);
                $usuario = $this->user->findUserByName($array[0],$array[1]);

                $queryrun = $this->activo->getActivosByIdEmpleado($usuario->id);
                Excel::create('activos', function($excel) use($queryrun,$usuario) {
                    $excel->sheet('detalles', function($sheet) use($queryrun,$usuario) {



                        $sheet->loadView('activos.empleado.misactivos_excel')
                            ->with('activos',$queryrun)->with('usuario',$usuario);


                    });
                })->export('xls');
                break;
        }


    }


    //generar sabana de activos
    public function rpt_SabanaGeneral(Request $request)
    {
        $formato = $request['formato'];

        switch($formato)
        {
            case 'excel':
                $queryrun = $this->activo->getActivosAll();
                Excel::create('activos', function($excel) use($queryrun) {
                    $excel->sheet('detalles', function($sheet) use($queryrun) {



                        $sheet->loadView('activos.reportes.sabanaactivos_excel')
                            ->with('activos',$queryrun);


                    });
                })->export('xls');
                break;
        }
    }



    //obtener lista de activos desde la base de datos
    public function getActivosAll()
    {
        $activos = $this->activo->getActivos();

        return response()->json($activos);

    }



    //funcion para guardar un activo de tipo mobiliario y equipo y generar automaticamente la hoja de activo respectiva
    public function saveWithHoja(Request $request)
    {

        //iniciamos la transaccion
        DB::beginTransaction();

        $activo = new EmpActivo();

        $f = date_create_from_format('Y-m-d',$request['fechacompra']);

        $fecha = date_format($f,'Ymd');

        $activo->tipo_activo        = $request['insumo'];
        $activo->marca              = $request['marca'];
        $activo->modelo             = $request['modelo'];
        $activo->fecha              = date('Ymd');
        $activo->ccf                = $request['ccf'];
        $activo->proveedor          = $request['proveedor'];
        $activo->valor              = (double)$request['precio'];
        $activo->area_inversion     = "";
        $activo->ubicacion          = "";
        $activo->empleado           = Session::get('idusuario');
        $activo->cantidad           = 1;
        $activo->color              = $request['color'];
        $activo->centro_costo       = $request['cc'];
        $activo->departamento_id    = $request['departamento'];
        $activo->municipio          = $request['municipio'];
        $activo->justificacion      = $request['justificacion'];
        $activo->agencia_id         = $request['agencia'];
        $activo->fecha_compra       = $fecha;
        $activo->estado_activo      = 2;
        $activo->finalidad          = $request['finalidad'];
        $activo->bodega_id          = $request['bodega'];
        $activo->area_edesal        = $request['deptoedesal'];
        $activo->entrega_bodega     = $request['estado'];

        $usuario = $this->user->getUserById(Session::get('idusuario'));
        //persistimos el objeto activo
        $queryrun = $activo->save();



        if($queryrun)
        {
            DB::commit();
            $ultimoactivo = DB::table('emp_activos')->orderBy('emp_activos.id','desc')->first();

            //enviar correo al supervisor que se creo un nuevo activo
            Mail::send('email.activos.superv_nuevo_activo', ['activo' => $activo,'empleado'=>$usuario->nombre.' '.$usuario->apellido], function ($m) use ($activo) {
                $m->from('comanda@edesal.com', '');

                $m->to('wmarquez@edesal.com', '')->subject('Nuevo Activo Creado!');
            });

           return response()->json($ultimoactivo->id);

        }
        else
        {
            DB::rollBack();
            return response()->json($queryrun);
        }



    }


    //funcion para guardar un activo desde bodega (area comercial)
    public function saveWithHojaBodega(Request $request)
    {

        //iniciamos la transaccion
        DB::beginTransaction();

        $activo = EmpActivo::find($request['id']);

        $f = date_create_from_format('d/m/Y',$request['fechacompra1']);

        $fecha = date_format($f,'Ymd');

        $array = explode(' ', $request['usuarioasignado']);

        $empleado = $this->user->getUserByNames($array[0],$array[1]);

        $activo->tipo_activo        = $request['activo1'];
        $activo->marca              = $request['marca1'];
        $activo->modelo             = $request['modelo1'];
        $activo->fecha              = date('Ymd');
        $activo->ccf                = $request['ccf1'];
        $activo->proveedor          = $request['proveedor1'];
        $activo->valor              = (double)$request['precio1'];
        $activo->area_inversion     = "";
        $activo->ubicacion          = "";
        $activo->empleado           = $empleado->id;
        $activo->cantidad           = 1;
        $activo->color              = $request['color1'];
        $activo->centro_costo       = $request['cc1'];
        $activo->departamento_id    = $request['departamento1'];
        $activo->municipio          = $request['municipio1'];
        $activo->justificacion      = $request['justificacion1'];
        $activo->agencia_id         = $request['agencia1'];
        $activo->fecha_compra       = $fecha;
        $activo->estado_activo      = 2;
        $activo->finalidad          = $request['finalidad1'];
        $activo->bodega_id          = $request['bodega1'];
        $activo->area_edesal        = $request['deptoedesal1'];
        $activo->entrega_bodega     = $request['estado1'];

        $usuario = $this->user->getUserById(Session::get('idusuario'));
        //persistimos el objeto activo
        $queryrun = $activo->save();



        if($queryrun)
        {
            DB::commit();
            $ultimoactivo = DB::table('emp_activos')->orderBy('emp_activos.id','desc')->first();

            //enviar correo al supervisor que se creo un nuevo activo
            Mail::send('email.activos.superv_nuevo_activo', ['activo' => $activo,'empleado'=>$usuario->nombre.' '.$usuario->apellido], function ($m) use ($activo) {
                $m->from('comanda@edesal.com', '');

                $m->to('wmarquez@edesal.com', '')->subject('Nuevo Activo Creado!');
            });

            return response()->json($ultimoactivo->id);

        }
        else
        {
            DB::rollBack();
            return response()->json($queryrun);
        }



    }


    //funcion para generar la hoja de activo
    public function generarHojaActivo(Request $request)
    {
        //listamos el ultimo activo ingresado
        $activo = DB::table('emp_activos as activo')
            ->leftjoin('DEPSV as dep', 'dep.ID', '=', 'activo.departamento_id')
            ->leftjoin('MUNSV as mun', 'mun.ID', '=', 'activo.municipio')
            ->leftjoin('agencias as ag', 'ag.id', '=', 'activo.agencia_id')
            ->leftjoin('users as u', 'u.id', '=', 'activo.empleado')
            ->leftjoin('departamentos_edesal as de', 'de.id', '=', 'activo.area_edesal')
            ->leftjoin('centro_costos as cc', 'cc.id', '=', 'activo.centro_costo')
            ->leftjoin('bodegas as b', 'b.id', '=', 'activo.bodega_id')
            ->select('b.codigo as bodega','de.nombre as area', 'activo.*', 'u.nombre', 'u.apellido', 'cc.nombre as centrocosto', 'ag.nombre as agencia', 'dep.DepName as departamento', 'mun.MunName as municipio')
            ->where('activo.id', $request['id'])
            ->orderBy('activo.id', 'desc')
            ->first();

        $usuario = User::find(Session::get('idusuario'));

        $view =  \View::make('activos.empleado.reportes.hoja_activo', compact('activo','usuario'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);


        //return response()->json($hojaactivo);

        return $pdf->stream('hojaactivo.pdf');
    }


    //generar una hoja de activo por parte del area tecnica
    public function saveHojaActivoAreaTecnica(Request $request)
    {

        //iniciamos la transaccion
        DB::beginTransaction();

        $activo  = new EmpActivo();

        $f = date_create_from_format('Y-m-d',$request['fechacompra2']);

        $fecha = date_format($f,'Ymd');

        $array = explode(' ',$request['usuarioasignado2']);



        $empleado = $this->user->getUserByNames($array[0],$array[1]);

        $activo->tipo_activo        = $request['activo2'];
        $activo->marca              = $request['marca2'];
        $activo->modelo             = $request['modelo2'];
        $activo->fecha              = date('Ymd');
        $activo->ccf                = $request['ccf2'];
        $activo->proveedor          = $request['proveedor2'];
        $activo->valor              = (double)$request['precio2'];
        $activo->area_inversion     = "";
        $activo->ubicacion          = "";
        $activo->empleado           = $empleado->id;
        $activo->cantidad           = 1;
        $activo->color              = $request['color2'];
        $activo->centro_costo       = $request['cc2'];
        $activo->departamento_id    = $request['departamento2'];
        $activo->municipio          = $request['municipio2'];
        $activo->justificacion      = $request['justificacion2'];
        $activo->agencia_id         = $request['agencia2'];
        $activo->fecha_compra       = $fecha;
        $activo->estado_activo      = 2;
        $activo->finalidad          = $request['finalidad2'];
        $activo->bodega_id          = $request['bodega2'];
        $activo->area_edesal        = $request['deptoedesal2'];
        $activo->entrega_bodega     = $request['estado2'];
        $activo->vida_util          = 1;
        $activo->codigo_vnr         = $empleado->vnr;



        //persistimos el objeto activo
        $queryrun = $activo->save();


        $usuario = $this->user->getUserById(Session::get('idusuario'));

        if($queryrun)
        {
            DB::commit();
            $ultimoactivo = DB::table('emp_activos')->orderBy('emp_activos.id','desc')->first();

            //enviar correo al supervisor que se creo un nuevo activo
            Mail::send('email.activos.superv_nuevo_activo', ['activo' => $activo,'empleado'=>$usuario->nombre.' '.$usuario->apellido], function ($m) use ($activo) {
                $m->from('comanda@edesal.com', '');

                $m->to('wmarquez@edesal.com', '')->subject('Nuevo Activo Creado!');
            });

            return response()->json($ultimoactivo->id);

        }
        else
        {
            DB::rollBack();
            return response()->json($queryrun);
        }
    }



    //buscar un activo por su id
    public function findActivo(Request $request)
    {
        $activo = $this->activo->findLineaActivoById($request['id']);

        return response()->json($activo);
    }

    //generar traslado
    public function generarTraslado(Request $request)
    {
        DB::beginTransaction();

        //objeto de tipo traslado
        $traslado = new ACT_Traslados();

        //partimos el activo para substraer el id del activo a trasladar
        $array = explode('-',$request['insumo_tr']);

        //partimos el empleado para realiza su busqueda
        $array1 = explode(' ',$request['empleado_tr']);

        $empleado = $this->user->findUserByName($array1[0],$array1[1]);

        //llenamos el objeto traslado
        $traslado->emp_activo_id            = $array[0];
        $traslado->centro_costo_destino     = $request['cc_tr'];
        $traslado->agencia_destino          = $request['agencia_tr'];
        $traslado->departamento_destino     = $request['departamento_tr'];
        $traslado->municipio_destino        = $request['municipio_tr'];
        $traslado->usuario_destino          = $empleado->id;
        $traslado->fecha_traslado           = date('Ymd H:i');
        $traslado->observaciones            = $request['observaciones_tr'];
        $traslado->tipo_traslado_id         = $request['tipotraslado'];
        $traslado->usuario_emisor           = Session::get('idusuario');
        $traslado->estado_traslado          = 1;


        $emisor = $this->user->getUserById(Session::get('idusuario'));

        //persistimos el traslado
        $queryrun = $traslado->save();

        $act = new Array_();

        if($queryrun)
        {
            DB::commit();

            //enviamos el correo para el supervisor que se esta generando un nuevo traslado
           /* Mail::send('email.activos.supervisor_traslado', ['act' => $array[1],'emisor'=>$emisor->nombre.' '.$emisor->apellido,'receptor'=>$empleado->nombre.' '.$empleado->apellido], function ($m) use ($act) {
                $m->from('comanda@edesal.com', '');

                $m->to('dhernandez@edesal.com', '')->subject('Nuevo Traslado en proceso!');
            });


            //enviamos correo al receptor del traslado
            Mail::send('email.activos.supervisor_traslado', ['act' => $array[1],'emisor'=>$emisor->nombre.' '.$emisor->apellido,'receptor'=>$empleado->nombre.' '.$empleado->apellido], function ($m) use ($empleado) {
                $m->from('comanda@edesal.com', '');

                $m->to($empleado->correo, '')->subject('Nuevo Traslado en proceso!');
            });*/



            return response()->json($queryrun);
        }
        else
        {
            DB::rollBack();
            return response()->json($queryrun);
        }

    }


    //generar PDF para el traslado
    public function generarPDFTraslado(Request $request)
    {
        $traslado = $this->activo->getTrasladoById($request['id']);



        //estado anterior del activo
        $act = $this->activo->getActivoById($traslado->emp_activo_id);





        //actualizamos la linea del traslado a finalizado
        $trasladoELOQUENT = ACT_Traslados::find($request['id']);

        //finalizado el proceso
        $trasladoELOQUENT->estado_traslado = 5;
        $trasladoELOQUENT->save();


        //GENERAMOS EL PDF DE LA HOJA DE TRASLADO
        $pdf = \App::make('dompdf.wrapper');

        $view =  \View::make('activos.empleado.reportes.hoja_traslado', compact('traslado','act'))->render();

        $pdf->loadHTML($view);



        return $pdf->stream('traslado.pdf');

        //ACTUALIZAMOS LA INFORMACION DEL ACTIVO
        //buscamos el activo para asignar el nuevo responsable
        $activo                     = EmpActivo::find($traslado->emp_activo_id);
        $activo->empleado           = $traslado->usuario_destino;
        $activo->centro_costo       = $traslado->centro_costo_destino;
        $activo->departamento_id    = $traslado->departamento_destino;
        $activo->municipio          = $traslado->municipio_destino;

        //persistimos
        $activo->save();



    }



    //vista de los traslados para los empleados
    public function getTraslados()
    {
        //listamos todos los traslados segun empleado logueado
        $trasladosemisor = $this->activo->getTrasladosEmisor(Session::get('idusuario'));

        //listamos los traslados para el receptor
        $trasladosreceptor = $this->activo->getTrasladosReceptor(Session::get('idusuario'));


        return view('activos.empleado.traslados')->with('traslados',$trasladosemisor)->with('trasladosreceptor',$trasladosreceptor);

        //return response()->json($traslados);

    }




    //aceptar traslado de activo
    public function aceptarTraslado(Request $request)
    {
        DB::beginTransaction();

        //buscamos el traslado por su id enviado
        $traslado   = ACT_Traslados::find($request['id']);

        //buscamos el activo que actualizaremos con la informacion del traslado
        $activo     = EmpActivo::find($traslado->emp_activo_id);

        //realizamos la busqueda del usuario destino para extraer su informacion y utilizarla en la edicion del activo
        $user = User::find($traslado->usuario_destino);


        //Actualizamos el activo con la informacion del traslado y usuario
        $activo->empleado   = $traslado->usuario_destino;
        $activo->codigo_vnr = $user->vnr;
        $activo->departamento_id = $traslado->departamento_destino;
        $activo->municipio = $traslado->municipio_destino;
        $activo->agencia_id = $traslado->agencia_destino;
        $activo->centro_costo = $traslado->centro_costo_destino;


        //persistimos el objeto activo
        $activo->save();



        //cambiamos el estado del traslado
        $traslado->estado_traslado = 2;



        //persistimos
        $queryrun1 = $traslado->save();

        if($queryrun1)
        {
            DB::commit();
            return response()->json($queryrun1);
        }
        else
        {
            DB::rollBack();
            return response()->json($queryrun1);
        }
    }



    //funcion para actualizar un activo desde el centro de costo correspondiente
    public function updateActivoFromCC(Request $request)
    {
        DB::beginTransaction();

        $act = explode('-',$request['insumo']);

        $usuario = explode(' ',$request['responsable']);

        $empleado = $this->user->findUserByName($usuario[0],$usuario[1]);

        $activo = EmpActivo::find($act[0]);

        $f = date_create_from_format('d/m/Y',$request['fechacompra']);

        $fecha = date_format($f,'Ymd');

        $activo->tipo_activo        = $act[1];
        $activo->marca              = $request['marca'];
        $activo->modelo             = $request['modelo'];
        $activo->fecha              = date('Ymd');
        $activo->ccf                = $request['ccf'];
        $activo->proveedor          = $request['proveedor'];
        $activo->valor              = (double)$request['precio'];
        $activo->area_inversion     = "";
        $activo->ubicacion          = "";
        $activo->empleado           = $empleado->id;
        $activo->cantidad           = 1;
        $activo->color              = $request['color'];
        $activo->centro_costo       = $request['cc'];
        $activo->departamento_id    = $request['departamento'];
        $activo->municipio          = $request['municipio'];
        $activo->justificacion      = $request['justificacion'];
        $activo->agencia_id         = $request['agencia'];
        $activo->fecha_compra       = $fecha;
        $activo->estado_activo      = 2;
        $activo->entrega_bodega     = $request['estado'];
        $activo->finalidad          = $request['finalidad'];
        $activo->area_edesal        = $request['deptoedesal'];


        //persistimos el objeto activo
        $queryrun = $activo->save();



        if($queryrun)
        {
            DB::commit();
            $ultimoactivo = DB::table('emp_activos')->orderBy('emp_activos.id','desc')->first();

            return response()->json($ultimoactivo->id);

        }
        else
        {
            DB::rollBack();
            return response()->json($queryrun);
        }
    }


    //iniciar proceso de baja
    public function iniciarProcesoBaja(Request $request)
    {
        //objeto de tipo baja
        $baja = new ACT_Bajas();

        $baja->tipo_baja        = $request['motivo'];
        $baja->justificacion    = $request['justificacion'];
        $baja->activo           = $request['activo'];
        $baja->fecha            = date('Ymd H:i');
        $baja->estado           = 1;
        $baja->usuario          = Session::get('idusuario');

        //persistimos el objeto
        $queryrun = $baja->save();

        if($queryrun)
        {
            //objeto de tipo activo para cambiar su estado ya que esta en proceso de baja
            $activo = EmpActivo::find($request['activo']);

            //cambiamos el estado a proceso de baja
            $activo->estado_activo = 1;

            //persistimos el objeto
            $activo->save();

            $usuario = $this->user->getUserById(Session::get('idusuario'));

            $activo = EmpActivo::find($request['activo']);

            //enviamos el email a contabilidad para avisar que se esta iniciando un nuevo proceso de baja
           Mail::send('email.activos.contabilidad_baja', ['activo' => $activo,'empleado'=>$usuario->nombre.' '.$usuario->apellido], function ($m) use ($activo) {
                $m->from('comanda@edesal.com', '');

                $m->to('iavalos@edesal.com', '')->subject('Nuevo proceso de baja!');
            });
        }

        return response()->json($request['activo']);


    }
    
    
    //Generar el pdf de la baja de activo
    public function generarPDFBaja(Request $request)
    {
        $a  = $this->activo->getBajaByActivo($request['activo']);
            
        $pdf = \App::make('dompdf.wrapper');
        
        $view =  \View::make('activos.empleado.reportes.hoja_bajaactivo', compact('pdf','a'))->render();

        $pdf->loadHTML($view);

        return $pdf->stream('baja.pdf');

        //return response()->json($a);


    }


    //vista para el perfil de contabilidad y poder ver las bajas iniciadas
    public function indexContabilidadBajas()
    {
        $detalles  = $this->activo->getActivosProcesoBaja();

        return view('insumos.contabilidad.index')->with('detalles',$detalles);
    }



    //finalizar baja por parte de contabilidad
    public function finalizarProcesoBaja(Request $request)
    {
        //objeto de la tabla baja para finalizar el proceso creado
        $baja = ACT_Bajas::find($request['id']);

        //establecemos el estado
        $baja->estado = 4;

        //persistimos
        $baja->save();



        //cambiamos el estado del activo que se encuentra en el repositorio del empleado
        $activo = EmpActivo::find($baja->activo);

        $activo->estado_activo = 4;

        //persistimos
        $queryrun = $activo->save();

        return response()->json($queryrun);

    }


    //obtener activos de tipo herramientas y mostrarlos en la vista correspondientes para los supervisores
    public function indexBodegaVirtual()
    {
        $activos = $this->activo->getActivosForBodegas(Session::get('idusuario'));

        return response()->json($activos);
    }




    //actualizar el estado de la herramienta
    public function actualizarVidaUtil(Request $request)
    {
        //partimos la herram que nos manda el formulario para obtener el id y asi actualizar su estado
        $arreglo = explode('-',$request['herramienta']);

        $activo = EmpActivo::find($arreglo[0]);

        $activo->vida_util = $request['estado'];

        //persistimos la actualizacion del activo
        $queryrun = $activo->save();

        return response()->json($queryrun);
    }

}
