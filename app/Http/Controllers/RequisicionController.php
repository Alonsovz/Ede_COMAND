<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Departamentos\DepartamentoRepository;
use App\Repositories\Requisiciones\RequisicionRepository;
use App\Repositories\Insumos\InsumoRepository;
use App\Requisicion;
use App\Repositories\User\UserRepository;
use App\Detalle_Requisicion;
use App\Repositories\Requisiciones\DetalleRequisicionRepository;
use App\Repositories\Proveedores\ProveedorRepository;
use Session;
use DB;
use App\Repositories\CentroCostos\CentroCostosRepository;
use App\HojaActivos;
use App\Repositories\HojasActivos\ActivoHojaRepository;
use Mail;


class RequisicionController extends Controller
{
    public $departamento;
    public $requisicion;
    public $insumo;
    public $user;
    public $detalles;
    public $proveedor;
    public $cc;
    public $bodegas;
    public $activo;

    //constructor
    function __construct(DepartamentoRepository $departamento,
                         RequisicionRepository $requisicion, InsumoRepository $insumo, UserRepository $user,
                         DetalleRequisicionRepository $detalles, ProveedorRepository $proveedor,
                         CentroCostosRepository $cc, ActivoHojaRepository $activo)
    {
        $this->departamento = $departamento;
        $this->requisicion = $requisicion;
        $this->insumo = $insumo;
        $this->user = $user;
        $this->detalles = $detalles;
        $this->proveedor = $proveedor;
        $this->cc = $cc;
        $this->activo = $activo;
    }


    //bandeja para administrador de las insumos enviadas por los centros de costos
    public function bandejaAdmin()
    {
        $requisiciones = $this->requisicion->getRequisicionesByAdmin();
        $conteo = $this->requisicion->conteoRequisicionesNuevas();

        return view('insumos.admin.requisiciones.index')->with('requisiciones', $requisiciones)->with('conteo', $conteo);
        //return response()->json($requisiciones);
    }


    public function create()
    {
        $nuevarequisicion = $this->requisicion->generarIdRequisicion();
        $departamentos = $this->departamento->getDepartamentos();
        $electricistas = DB::table('electricistas')->get();
        $centroscostos = $this->cc->getCentrosCostos();
        $bodegas = DB::table('bodegas')->get();
        $agencias = DB::table('agencias')->get();


        return view('insumos.supervisor.create')
            ->with('departamentos', $departamentos)
            ->with('requisicion', $nuevarequisicion)
            ->with('electricistas', $electricistas)
            ->with('centrocostos', $centroscostos)
            ->with('bodegas', $bodegas)
            ->with('agencias', $agencias);

        //return view('mantenimiento.mantenimiento');

        //return json_encode($nuevarequisicion);
    }


    public function store(Request $request)
    {
        //arreglo de los codigos de insumos para los detalles de la requisicion
        $insumos = $request['insumos'];


        //arreglo de las cantidades de los insumos ingresados
        $cantidades = $request['cantidades'];

        //arreglo de precios
        $precios = $request['precios'];

        $requisicion = new Requisicion();

        $array = explode(' ', $request['solicitante']);

        $solicitante = $this->user->getUserByNames($array[0], $array[1]);

        $descripciones = $request['descripciones'];


        //rellenamos el objeto de requisicion
        $requisicion->user_solicitante = $solicitante->id;
        $requisicion->fechasolicitud = date('Ymd');
        $requisicion->estado_requisicion_id = 2;
        $requisicion->tipo_requisicion_id = $request['requisicion'];
        $requisicion->justificacion = $request['justificacion'];


        //persistimos el objeto
        $queryrun = $this->requisicion->saveRequisicion($requisicion);





        $empleado = $request['solicitante'];

        $last = $this->requisicion->generarIdRequisicion();

        Session::put('requisicionid', $last - 1);
        Session::put('solicitanterequisicion', $empleado);

        if ($queryrun == true) {
            //enviar correo a usuario asignado

           /*Mail::send('email.nuevarequisicion', ['requisicion' => $requisicion], function ($m) use ($requisicion) {
                $m->from('comanda@edesal.com', 'COMANDA');

                $m->to('aortiz@edesal.com', '')->subject('Nueva Requisicion!');
            });

            //enviar correo a usuario asignado
            Mail::send('email.nuevarequisicion', ['requisicion' => $requisicion], function ($m) use ($requisicion) {
                $m->from('comanda@edesal.com', 'COMANDA');

                $m->to('dhernandez@edesal.com', '')->subject('Nueva Requisicion!');
            });*/
            

            //ultima requisicion ingresada
            $requisicion = $this->requisicion->generarIdRequisicion();
                

            //si la requisicion es generada procedemos a guardar sus detalles ya que es una relacion maestro-detalle
            for ($i = 0; $i <= count($insumos) - 1; $i++) {
                //objeto detallesrequisicion
                $detallerequisicion = new Detalle_Requisicion();


                //rellenamos el objeto de los detalles
                $detallerequisicion->requisicion_id = $requisicion - 1;
                $detallerequisicion->insumo_id = (int)$insumos[$i];
                $detallerequisicion->cantidad = (int)$cantidades[$i];
                $detallerequisicion->ins_descripcion = $descripciones[$i];
                $detallerequisicion->precio = $precios[$i];


                //persistimos el objeto
                $queryrun = $this->detalles->saveDetalle($detallerequisicion);

            }

            if ($queryrun == true) {
                return response()->json($queryrun);
            } else {
                return response()->json($queryrun);
            }


        } else {
            return response()->json($queryrun);
        }
    }


    //funcion para mostrar los detalles de una requisicion
    public function show(Request $request)
    {
        $insumos = $this->detalles->detallesByIdRequisicion($request['idrequisicion']);
        $requisicion = $this->requisicion->getRequisicionById($request['idrequisicion']);
        $proveedores = $this->proveedor->getProveedores();
        $terminos = DB::table('ordenes_term_pagos')->get();

        if ($insumos != "") {
            //return json_encode($requisicion);
            return view('insumos.admin.subviews.requisiciondetalles')
                ->with('insumos', $insumos)->with('requisicion', $requisicion)->with('proveedores', $proveedores)
                ->with('terminos', $terminos);
        } else {
            return "error";
        }
    }


    //funcion para los detalles de requisicion de supervisor
    public function showSuperv(Request $request)
    {
        $insumos = $this->detalles->detallesByIdRequisicion($request['idrequisicion']);
        $requisicion = $this->requisicion->getRequisicionById($request['idrequisicion']);
        $proveedores = $this->proveedor->getProveedores();

        if ($insumos != "") {
            //return json_encode($requisicion);
            return view('insumos.supervisor.show')
                ->with('insumos', $insumos)->with('requisicion', $requisicion)->with('proveedores', $proveedores);
        } else {
            return "error";
        }
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {
        //recibimos por request cantidades e insumos de igual manera el id de la req a editar
        $cantidades = $request['cantidades'];
        $insumos = $request['insumos'];
        $requisicion = $request['id'];
        $precios = $request['precios'];

        //primero eliminamos el detalle de la requisicion antigua para estar seguros que no habran insumos que no pertenecen ya a la requ
        $queryrun = Detalle_Requisicion::where('requisicion_id', $requisicion)->delete();

        //si eliminamos los detalles de la req antigua ahora ingresaremos los nuevos detalles de la req
        if ($queryrun > 0) {
            for ($i = 0; $i <= count($insumos) - 1; $i++) {
                //objeto detallesrequisicion
                $detallerequisicion = new Detalle_Requisicion();

                //rellenamos el objeto de los detalles
                $detallerequisicion->requisicion_id = $requisicion;
                $detallerequisicion->insumo_id = (int)$insumos[$i];
                $detallerequisicion->cantidad = (int)$cantidades[$i];
                $detallerequisicion->precio = $precios[$i];


                //persistimos el objeto
                $queryrun = $this->detalles->saveDetalle($detallerequisicion);

            }

            return response()->json($queryrun);
        }

    }


    public function destroy(Request $request)
    {
        $req = $this->requisicion->EloquentFindRequisicionById($request['id']);

        $req->estado_requisicion_id = 7;

        //persistimos el objeto
        $queryrun = $this->requisicion->saveRequisicion($req);

        return response()->json($queryrun);
    }


    //agregar nueva fila
    public function nuevaFila()
    {
        return view('insumos.supervisor.sub-views.fila');
    }


    //obtener ultimo numero de requisicion
    public function getCountRequisiciones()
    {
        $conteo = $this->requisicion->generarIdRequisicion();
        return response()->json($conteo);
    }



    //mostrar vista de las requisiciones aprobadas
    public function adminAprobadasReq()
    {
        $requisiciones = $this->requisicion->getRequisicionesByAdmin();
        $conteo = $this->requisicion->conteoRequisicionesNuevas();

        return view('insumos.admin.requisiciones.index')->with('requisiciones', $requisiciones)->with('conteo', $conteo);
        //return response()->json($requisiciones);
    }


    //funcion para vista de la bandeja de requisiciones de un supervisor
    public function bandejaRequisicionSuperv()
    {
        $requisiciones = $this->requisicion->getRequisicionesBySupervisor(Session::get('idusuario'));

        //return json_encode($requisiciones);

        return view('insumos.supervisor.index')->with('requisiciones', $requisiciones);

       //return view('mantenimiento.mantenimiento');
    }




    //funcion para imprimir hoja de activo
    public function imprimirHojaActivo()
    {
        //variables para PDF
        $ultimarequisicion = $this->requisicion->generarIdRequisicion() - 1;

        $insumos = $this->detalles->detallesByIdRequisicion($ultimarequisicion);

        $total = $this->detalles->getTotalInsumosForRequisicion($ultimarequisicion);

        $hojaactivo = $this->activo->getLastHoja($ultimarequisicion);

        $view = \View::make('insumos.supervisor.hojaactivoPDF', compact('total', 'insumos', 'hojaactivo'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);

        //return response()->json($iva);

        return $pdf->stream('hojaactivo.pdf');

        //return response()->json($hojaactivo);
    }

}
