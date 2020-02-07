<?php

namespace App\Http\Controllers;

use App\BitacoraActualizacionIns;
use App\DetalleHojaActivo;
use App\InsumoCentroCostos;
use Illuminate\Http\Request;
use App\Repositories\CentroCostos\BodegaRepository;
use App\Repositories\Insumos\InsumoRepository;
use App\Repositories\CentroCostos\InsumoCentroCostosRepository;
use App\Repositories\CentroCostos\CentroCostosRepository;
use App\Repositories\HojasActivos\ActivoHojaRepository;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class BodegaController extends Controller
{
    public $bodega;
    public $insumo;
    public $icc;
    public $hoja;
    public $cc;

    public function __construct(BodegaRepository $bodega,InsumoRepository $insumo,InsumoCentroCostosRepository $icc,ActivoHojaRepository $hoja,
                                    CentroCostosRepository $cc)
    {
        $this->bodega = $bodega;
        $this->insumo = $insumo;
        $this->icc    = $icc;
        $this->hoja   = $hoja;
        $this->cc     = $cc;
    }

    //funcion para lanzar la vista de los insumos contenidos en las bodegas segun el supervisor logueado
    public function viewInsumosByBodega()
    {
        $bodegas = DB::table('bodegas')->get();
        $electricistas = DB::table('electricistas')->get();
        $departamentos = DB::table('DEPSV')->get();
        $agencias = DB::table('agencias')->get();
        $centrocostos = DB::table('centro_costos')->get();
        $bodega = DB::table('bodegas')->select('codigo','id')->where('supervisor',Session::get('idusuario'))->first();
        $detalles = $this->bodega->getDetallesBodega(Session::get('idusuario'));
        $estados = DB::table('estados_insumos')->get();
        $usuario = DB::table('users')->where('id',Session::get('idusuario'))->first();
        $insumos = $this->bodega->getInsumosByBodegaUser(Session::get('idusuario'));
        $suma = $this->cc->getTotalInsumosByBodega($bodega->id);
        $tipostraslados = DB::table('act_tipos_traslados')->get();



        return view('insumos.supervisor.bodegas')
            ->with('electricistas',$electricistas)
            ->with('departamentos',$departamentos)
            ->with('centrocostos',$centrocostos)
            ->with('centros',$centrocostos)
            ->with('cc',$usuario->centro_costos_id)
            ->with('bodega',$bodega)
            ->with('insumos',$insumos)
            ->with('agencias',$agencias)
            ->with('detalles',$detalles)
            ->with('estados',$estados)
            ->with('suma',$suma)
            ->with('tipostraslados',$tipostraslados)
            ->with('bodegas',$bodegas);

         //return response()->json($insumos);
    }



    //obtener los activos de una bodega x
    public function getActivosBodega(Request $request)
    {
        $activos = $this->bodega->getActivosByBodega($request['bodega']);
        $bodega  = DB::table('bodegas')->where('bodegas.id',$request['bodega'])->first();

        return view('insumos.admin.subviews.tablasbodegas')
        ->with('bodega',$bodega)
        ->with('insumos',$activos);
    }






    //funcion para editar activo
    public function editarActivo(Request $request)
    {

        //buscamos la linea del detalle de la hoja de activo donde se encuentra el insumo a editar
        $QB_LineaDA= DB::table('detalles_hoja_activo')->where('cod_aux',$request['insumo'])->first();

        $ELOQUENT_LineaDA = DetalleHojaActivo::find($QB_LineaDA->id);

        //editamos la linea del detalle de la hoja de activo
        $ELOQUENT_LineaDA->estado_insumo_id = $request['estado'];

        //persistimos el objeto
        $ELOQUENT_LineaDA->save();

        //buscamos la linea donde se encuenta nuestro insumo dentro del inventario ya que anteriormente solo actualizamos la del detalle de la hoja de activo
        $lineainventario = DB::table('insumos-centro_costos')->where('cod_aux',$request['insumo'])->first();

        //Por medio de eloquent buscamos persistir dicha linea con la actualizacion
        $ELOQUENT_lineainventario = InsumoCentroCostos::find($lineainventario->id);

        //editamos la linea
        $ELOQUENT_lineainventario->estado_insumo = $request['estado'];

        //persistimos la linea
        $query = $ELOQUENT_lineainventario->save();


        //vamos a crear un objeto para guardar dicha actualizacion en la tabla de bitacoras
        $bitacorains = new BitacoraActualizacionIns();

        //rellenamos el objeto
        $bitacorains->user_id               = Session::get('idusuario');
        $bitacorains->insumo                = $QB_LineaDA->insumo_id;
        $bitacorains->cod_aux               = $request['insumo'];
        $bitacorains->fecha_actualizacion   = date('Ymd H:i');
        $bitacorains->estado                = $request['estado'];
        $bitacorains->hoja_activo_id        = $QB_LineaDA->hoja_activo_id;
        $bitacorains->bodega_id             = $lineainventario->bodega_id;


        //persistimos el objeto para guardar la informacion
        $query = $bitacorains->save();




        return response()->json($query);




    }


    //funcion para obtener los estados de lo insumos de las bodegas
    public function getEstadosInsumos(Request $request)
    {
        $insumo = $this->insumo->findIdByname($request['insumo']);
        $detalles = $this->bodega->estados(Session::get('idusuario'),$insumo->id);

        if(count($detalles)>0)
        {
            return view('insumos.supervisor.subviews.sv_detallebodega')->with('detalles',$detalles);

        }
        else
        {
            return response()->json(false);
        }
    }


    //funcion para lanzar vista para que contabilidad realice las bajas
    public function indexContabilidadBajas()
    {
        $detalles = $this->bodega->contabilidadInsumosByBajas();

        //return response()->json($detalles);
        return view('insumos.contabilidad.index')->with('detalles',$detalles);
    }


    //funcion para mostrar la vista de los cambios de estado de las herramientas
    public function rpt_cambiosEstadosHerram(Request $request)
    {
        $query = $this->bodega->query_cambiosEstadosHerram($request['desde'], $request['hasta'], $request['bodega']);

        return view('insumos.admin.reportes.activos.estadosherramientas')->with('cambios',$query);
    }



    //generar excel para los cambios de las herram
    public function excel_CambiosEstadosHerram(Request $request)
    {
        $queryrun = $this->bodega->query_cambiosEstadosHerram($request['desde'], $request['hasta'], $request['bodega']);

        Excel::create('cambiosestadosherram', function($excel) use($queryrun) {
            $excel->sheet('detalles', function($sheet) use($queryrun) {



                $sheet->loadView('insumos.admin.reportes.activos.excel_estadosherramientas')
                    ->with('cambios',$queryrun);


            });
        })->export('xls');
    }





}
