<?php

namespace App\Http\Controllers;

use App\Insumo;
use App\Repositories\CentroCostos\CentroCostosRepository;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use DB;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use Mail;


use App\Repositories\Insumos\InsumoRepository;
use DateTime;

class InsumoController extends Controller
{

    public $insumo;
    public $cc;
    public $queryrun = array();


    //constructor
    function __construct(InsumoRepository $insumo,CentroCostosRepository $cc)
    {
        $this->insumo = $insumo;
        $this->cc = $cc;
    }


    public function index()
    {
        //
    }


    //vista para mantenimiento index
    public function mantenimiento_index()
    {
        $insumos = $this->insumo->getInsumosAll();
        $categorias = DB::table('insumos_categorias')->get();
        $proveedores = DB::table('proveedores')->get();
        $unidades = DB::table('ins_unidades_medida')->get();

        return view('insumos.admin.mantenimiento.index')
            ->with('insumos',$insumos)->with('categorias',$categorias)
            ->with('unidades',$unidades)
            ->with('proveedores',$proveedores);
    }


    public function create()
    {
        $insumos = $this->insumo->getInsumosAll();
        $categorias = DB::table('insumos_categorias')->get();
        return view('insumos.admin.insumos.show')->with('insumos',$insumos)->with('categorias',$categorias);
        //return response()->json($insumos);
    }


    public function store(Request $request)
    {
        $insumo = new Insumo();

        $insumo->nombre                 = $request['insumo'];
        $insumo->precio                 = $request['precio'];
        $insumo->descripcion            = $request['descripcion'];
        $insumo->categoria_insumo_id    = $request['categoria'];
        $insumo->activo                 = $request['activo'];
        $insumo->unidad_medida_id       = $request['unidad'];

        //persistimos el objeto
        $queryrun = $this->insumo->saveInsumo($insumo);

        if($queryrun==true)
        {
            Session::put('insumo',$insumo->nombre);

            Mail::send('email.insumos.noti_nuevo', ['insumo' => $insumo], function ($m) use ($insumo) {
                $m->from('comanda@edesal.com', 'COMANDA');
                $m->to('iavalos@edesal.com', '')->subject('Nuevo Insumo creado');
            });
        }

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


    public function update(Request $request)
    {
        //buscamos objeto para actualizar su informacion
        $insumo = Insumo::find($request['id']);

        $insumo->nombre = $request['insumo'];
        $insumo->descripcion = $request['descripcion'];
        $insumo->precio = $request['precio'];
        $insumo->categoria_insumo_id = $request['categoria'];
        $insumo->activo = $request['activo'];

        //persistimos el objeto
        $queryrun = $this->insumo->saveInsumo($insumo);

        //retornamos respuesta json
        return response()->json($queryrun);
    }


    public function destroy(Request $request)
    {
        $in = $this->insumo->findIdByname($request['id']);

        $insumo = Insumo::find($in->id);

        //persistimos
        $queryrun = $insumo->delete();

        return response()->json($queryrun);

    }



    //obtener todos los insumos
    public function obtenerInsumos(Request $request)
    {
        if($request['tiporeq']==1)
        {
            $insumos = $this->insumo->getInsumosForPapeleria();
            return response()->json($insumos);
        }
        else if($request['tiporeq']==2)
        {
            $insumos = $this->insumo->getInsumosByHerramienta();

            return response()->json($insumos);
        }
        else if($request['tiporeq']==3)
        {
            $insumos = $this->insumo->getInsumosByLimpieza();

            return response()->json($insumos);
        }
        else if($request['tiporeq']==4)
        {
            $insumos = $this->insumo->getInsumosByOficina();

            return response()->json($insumos);
        }
    }



    //obtener un insumo por su nombre
    public function obtenerInsumoXNombre(Request $request)
    {
        $insumo = $this->insumo->findIdByname($request['insumo']);
        return response()->json($insumo->id);
    }



    //funcion para reporte de disponibilidad de papeleria
    public function rpt_movimientoPapeleria(Request $request)
    {
        $d      = $request['desde'];
        $h      = $request['hasta'];
        $cc     = $request['cc'];

        $fd = date_create_from_format('Ymd',$d);
        $fh = date_create_from_format('Ymd',$h);



        $desde = date_format($fd,'d/m/Y');
        $hasta = date_format($fh,'d/m/Y');

        $ccnombre = $this->cc->getNombreCC($cc);
        $queryrun = $this->insumo->movimientoPapeleria($cc,$d,$h);
        //cantidad inicial en el periodo seleccionado
        $cant_inicial = $this->insumo->cantInicialPape($cc,$d);

        $pdf = \App::make('dompdf.wrapper');

        $view =  \View::make('insumos.admin.reportes.papeleria.rpt_mov_papeleria', compact('pdf','queryrun','cant_inicial','ccnombre','hasta','desde'))->render();

        $pdf->loadHTML($view);

        return $pdf->stream('rpt_mov_papeleria.pdf');


    }


    //metodo para obtener el query de la disponibilidad de papeleria para poder mostrar una tabla
    //dentro del modulo
    public function getQueryRptMovPape(Request $request)
    {
        $d      = $request['desde'];
        $h      = $request['hasta'];
        $cc     = $request['cc'];
        $centrocostos = $this->cc->getCentrosCostos();

        //cantidades adquiridas y consumidas
        $queryrun = $this->insumo->movimientoPapeleria($cc,$d,$h);

        //cantidad inicial en el periodo seleccionado


        return view('insumos.admin.reportes.papeleria.movimientopapeleria')
            ->with('queryrun',$queryrun)
            ->with('centrocostos',$centrocostos);

//        return response()->json($queryrun);
    }




    //funcion para reporte de disponibilidad de limpieza
    public function rpt_movimientoLimpieza(Request $request)
    {
        $d      = $request['desde'];
        $h      = $request['hasta'];
        $cc     = $request['cc'];

        $fd = date_create_from_format('Ymd',$d);
        $fh = date_create_from_format('Ymd',$h);



        $desde = date_format($fd,'d/m/Y');
        $hasta = date_format($fh,'d/m/Y');

        $ccnombre = $this->cc->getNombreCC($cc);
        $queryrun = $this->insumo->movimientoLimpieza($cc,$d,$h);
        //cantidad inicial en el periodo seleccionado
        $cant_inicial = $this->insumo->cant_InicialLimpieza($cc,$d);

        $pdf = \App::make('dompdf.wrapper');

        $view =  \View::make('insumos.admin.reportes.limpieza.rpt_mov_limpieza', compact('pdf','queryrun','cant_inicial','ccnombre','hasta','desde'))->render();

        $pdf->loadHTML($view);

        return $pdf->stream('rpt_mov_papeleria.pdf');


    }



    //Reporte de disponibilidad de herramientas
    public function rpt_DispoHerramientas(Request $request)
    {
        $insumos = $this->insumo->dispoHerramientas($request['bodega']);

        $bodega = DB::table('bodegas')->where('id',$request['bodega'])->first();

        $pdf = \App::make('dompdf.wrapper');

        $view =  \View::make('insumos.admin.reportes.herramientas.rpt_dispoherramientas', compact('pdf','insumos','bodega'))->render();

        $pdf->loadHTML($view);

        return $pdf->stream('rpt_dispoherram.pdf');
    }


    //metodo para obtener el query de la disponibilidad de limpieza para poder mostrar una tabla
    //dentro del modulo
    public function getQueryRptMovLimpieza(Request $request)
    {
        $d      = $request['desde'];
        $h      = $request['hasta'];
        $cc     = $request['cc'];
        $centrocostos = $this->cc->getCentrosCostos();

        //cantidades adquiridas y consumidas
        $queryrun = $this->insumo->movimientoLimpieza($cc,$d,$h);

        //cantidad inicial en el periodo seleccionado
        $cant_inicial = $this->insumo->cant_InicialLimpieza($cc,$d);

        if(count($queryrun)>0)
        {
            return view('insumos.admin.reportes.limpieza.movimientolimpieza')
                ->with('queryrun',$queryrun)
                ->with('centrocostos',$centrocostos);
        }
        else
        {
            return response()->json('no insumos');
        }
    }

    //Metodo para generar el query del reporte de los costos de movimientos de insumos de limpieza por centro de costos en un rango de fechas para mostrarlos en la vista del
    //usuario
    public function getQueryRptCostosLimpieza(Request $request)
    {
        $d                  = $request['desde'];
        $h                  = $request['hasta'];
        $cc                 = $request['cc'];
        $centrocostos       = $this->cc->getCentrosCostos();
        $movimientos        = $this->insumo->movimientoLimpieza($cc,$d,$h);
        $cant_ini           = $this->insumo->cant_InicialLimpieza($cc,$d);
        $precios_cant_ini   = $this->insumo->precios_cant_ini($cc,$d);
        $precios_cant_adq   = $this->insumo->precios_cant_adquirida($cc,$d,$h);

        return view('insumos.admin.reportes.limpieza.movimientolimpiezacostos')
            ->with('movimientos',$movimientos)
            ->with('cant_ini',$cant_ini)
            ->with('precios_cant_adq',$precios_cant_adq)
            ->with('precios_cant_ini',$precios_cant_ini);

        //return response()->json($precios_cant_ini);

    }


    //generar pdf de costos de de insumos de limpieza
    public function rpt_CostosLimpieza(Request $request)
    {
        $d      = $request['desde'];
        $h      = $request['hasta'];
        $cc     = $request['cc'];

        $fd = date_create_from_format('Ymd',$d);
        $fh = date_create_from_format('Ymd',$h);



        $desde = date_format($fd,'d/m/Y');
        $hasta = date_format($fh,'d/m/Y');

        $ccnombre = $this->cc->getNombreCC($cc);
        $movimientos        = $this->insumo->movimientoLimpieza($cc,$d,$h);
        $cant_ini           = $this->insumo->cant_InicialLimpieza($cc,$d);
        $precios_cant_ini   = $this->insumo->precios_cant_ini($cc,$d);
        $precios_cant_adq   = $this->insumo->precios_cant_adquirida($cc,$d,$h);

        $pdf = \App::make('dompdf.wrapper');

        $pdf->setPaper('letter', 'landscape');

        $view =  \View::make('insumos.admin.reportes.limpieza.rpt_costos_limpieza', compact('pdf','movimientos',
            'cant_ini','ccnombre','hasta','desde','precios_cant_adq','precios_cant_ini'))->render();

        $pdf->loadHTML($view);

        return $pdf->stream('rpt_costoslimpieza.pdf');
    }



    //funcion para reporte de dispo de herram
    public function getQueryRptDispoHerram(Request $request)
    {
        $insumos = $this->insumo->dispoHerramientas($request['bodega']);

        return view('insumos.admin.reportes.herramientas.dispoherramientas')->with('insumos',$insumos);
    }







    public function generarExcelDispoPape(Request $request)
    {
        $d      = $request['desde'];
        $h      = $request['hasta'];
        $cc     = $request['cc'];

    }



    //buscar un insumo por id
    public function findInsumo(Request $request)
    {
        $id = $request['id'];

        $insumo = $this->insumo->findInsumoQUERYBUILDER($id);

        return response()->json($insumo);

    }



    //buscar insumo por nombre
    public function findInsumoByNAME(Request $request)
    {
        $nombre = $request['insumo'];

        $insumo = $this->insumo->getInsumoByNombre($nombre);

        return response()->json($insumo);

    }


    //historico de movimientos de un insumo sobre el centro de costo
    public function getHistoricoInsumoMov(Request $request)
    {

    }


    //obtener las bajas de activo segun bodega
    public function getBajasActivoByBodega(Request $request)
    {
        $bajas = $this->insumo->getBajasPorBodega($request['bodega']);

        return view('insumos.admin.reportes.activos.bajas')->with('bajas',$bajas);
        //return response()->json($bajas);
    }


    //funcion para ver el consumo historico de un insumo en un rango de fechas
    public function getConsumosInsumo(Request $request)
    {
        $usuario = User::find(Session::get('idusuario'));

        $consumos = $this->insumo->listarConsumosInsumo_supervCC($request['desde'],$request['hasta'],$request['insumo'],$usuario->centro_costos_id);

        //return response()->json($consumos);

        return view('insumos.supervisor.subviews.detalleconsumos')->with('consumos',$consumos);
    }


    //funcion para mostrar el PDF de los consumos de insumos
    public function rptConsumos(Request $request)
    {

        $usuario = User::find(Session::get('idusuario'));

        $consumos = $this->insumo->listarConsumosInsumo_supervCC($request['desde'],$request['hasta'],$request['insumo'],$usuario->centro_costos_id);

        $fechas = $request['desde'].'-'.$request['hasta'];

        $cc = $usuario->centro_costos_id;

        $centrocosto = DB::table('centro_costos')->where('id',$cc)->first();

        $c = $centrocosto->nombre;

        $pdf = \App::make('dompdf.wrapper');

        $view =  \View::make('insumos.supervisor.reportes.rpt_consumos', compact('pdf','consumos','c','fechas'))->render();

        $pdf->loadHTML($view);

        return $pdf->stream('rpt_consumos.pdf');

        //return response()->json($request['desde']);
    }

    //ver consumos de los centros de costo por parte del administrador
    public function getConsumosByAdmin(Request $request)
    {

        $insumo = $this->insumo->findIdByname($request['insumo']);

        $consumos = $this->insumo->listarConsumosInsumo_supervCC($request['desde'],$request['hasta'],$insumo->id,$request['cc']);

        //return response()->json($consumos);

        return view('insumos.supervisor.subviews.detalleconsumos')->with('consumos',$consumos);
    }


    //listar el consumo de papeleria con la condicion de listar los centro de costos y todos los insumos
    public function getHistoricoConsumosPapeleria(Request $request)
    {
        $consumos = $this->insumo->listarConsumosHistoricosXcc($request['desde'],$request['hasta']);
        return view('insumos.admin.reportes.papeleria.consumoshistoricos_all')->with('consumos',$consumos);
        //return response()->json($consumos);
    }


    //obtener todos los insumos
    public function obtenerInsumosAll()
    {
        $insumos = DB::table('insumos')->get();

        return response()->json($insumos);
    }




    //generar excel de movimientos de papeleria
    public function generarExcelMovPape(Request $request)
    {

        $d = $request['desde'];
        $h = $request['hasta'];
        $cc = $request['cc'];

        $centrocostos = DB::table('centro_costos')->where('id',$cc)->first();


        //cantidades adquiridas y consumidas
        $queryrun = $this->insumo->movimientoPapeleria($cc,$d,$h);


        Excel::create('mov_pape'.$centrocostos->nombre, function($excel) use($queryrun,$centrocostos) {
            $excel->sheet('Movimientos', function($sheet) use($queryrun,$centrocostos) {



                $sheet->loadView('insumos.admin.reportes.papeleria.view_excel')
                    ->with('queryrun',$queryrun)
                    ->with('centrocostos',$centrocostos);

            });
        })->export('xls');

        //return response()->json($this->queryrun);

    }


    //funcion para generar el excel de los consumos historicos listados por cc
    public function generarExcelConsumosHistoricosPapeleria(Request $request)
    {
        $d = $request['desde'];
        $h = $request['hasta'];




        //cantidades adquiridas y consumidas
        $consumos = $this->insumo->listarConsumosHistoricosXcc($d,$h);


        Excel::create('mov_pape', function($excel) use($consumos) {
            $excel->sheet('Movimientos', function($sheet) use($consumos) {



                $sheet->loadView('insumos.admin.reportes.papeleria.consumoshistoricos_excel')
                    ->with('consumos',$consumos);


            });
        })->export('xls');
    }




}
