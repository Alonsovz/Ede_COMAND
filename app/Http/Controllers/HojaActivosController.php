<?php

namespace App\Http\Controllers;

use App\DetalleHojaActivo;
use App\DetalleOrden;
use App\HojaActivos;
use App\Insumo;
use App\MovimientoInsumo;
use App\InsumoCentroCostos;
use DateTime;
use Illuminate\Http\Request;
use DB;
use App\OrdenCompra;
use App\Requisicion;
use App\Repositories\Requisiciones\RequisicionRepository;
use App\Repositories\Ordenes\OrdenRepository;
use App\Repositories\Ordenes\DetalleOrdenesRepository;
use App\Repositories\CentroCostos\InsumoCentroCostosRepository;
use Session;
use App\Repositories\User\UserRepository;
use App\Repositories\Proveedores\ProveedorRepository;
use App\Repositories\HojasActivos\ActivoHojaRepository;
use App\Repositories\Movimientos\MovimientoRepository;
use App\Repositories\Insumos\InsumoRepository;
use App\Repositories\CentroCostos\BodegaRepository;


class HojaActivosController extends Controller
{

    //variables globales
    public $requisicion;
    public $ordencompra;
    public $detalles;
    public $ccinsumos;
    public $user;
    public $proveedor;
    public $activo;
    public $movimiento;
    public $insumo;
    public $bodega;


    //constructor
    function __construct(ProveedorRepository $proveedor,UserRepository $user,OrdenRepository $ordencompra,
                         RequisicionRepository $requisicion,DetalleOrdenesRepository $detalles, InsumoCentroCostosRepository $ccinsumo,
                         ActivoHojaRepository $activo,MovimientoRepository $movimiento,InsumoRepository $insumo,BodegaRepository $bodega)
    {
        $this->ordencompra = $ordencompra;
        $this->requisicion = $requisicion;
        $this->detalles    = $detalles;
        $this->ccinsumos   = $ccinsumo;
        $this->user        = $user;
        $this->proveedor   = $proveedor;
        $this->activo      = $activo;
        $this->movimiento  = $movimiento;
        $this->insumo      = $insumo;
        $this->bodega      = $bodega;
    }





    //funcion para iniciar el proceso de baja de activo
    public function iniciarProcesoBA(Request $request)
    {

        //buscamos la linea del detalle de la herramienta
        $lineaherramientaHA = DB::table('detalles_hoja_activo')->where('cod_aux',$request['aux'])->first();

        //por medio de eloquent vamos a persistir dicho estado sobre la linea donde se encuentra la herramienta
        $ELOQUENTHerram = DetalleHojaActivo::find($lineaherramientaHA->id);

        //actualizamos estado de la herram
        $ELOQUENTHerram->estado_HA = 1;
        $ELOQUENTHerram->motivo_baja_id = $request['motivoba'];

        //persistimos
        $ELOQUENTHerram->save();


       //imprimimos la hoja de baja para que el usuario la entregue a contabilidad y que sea contabilidad quien finalice la baja
        $us = $this->user->getUserById(Session::get('idusuario'));


        $solicitante = $us->nombre.' '.$us->apellido;

        $motivoba = $request['justificacion'];

        $insumos = $this->bodega->getDetallesByHojaActivo($lineaherramientaHA->hoja_activo_id,$request['aux']);

        $total = $this->bodega->getTotalInsumosByHojaActivo($lineaherramientaHA->hoja_activo_id,$request['aux']);

        $hojaactivo = $this->activo->getELOQUENTHojaActivo($lineaherramientaHA->hoja_activo_id);

        $view =  \View::make('insumos.supervisor.baja_activo', compact('solicitante','total','insumos','hojaactivo','motivoba'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);

        return $pdf->stream('bajaactivo.pdf',array("Attachment" => true));


        exit(0);

    }


    //funcion para finalizar el proceso de baja
    public function finalizarProcesoBA(Request $request)
    {
        $lineaherramientaHA = DB::table('detalles_hoja_activo')->where('cod_aux',$request['aux'])->first();

        //por medio de eloquent vamos a persistir dicho estado sobre la linea donde se encuentra la herramienta
        $ELOQUENTHerram = DetalleHojaActivo::find($lineaherramientaHA->id);

        //actualizamos estado de la herram
        $ELOQUENTHerram->estado_HA = 3;

        //persistimos
        $ELOQUENTHerram->save();


        //tenemos que eliminar el insumo del inventario solo quedara la pista de la baja para un historico
        $lineainventario = DB::table('insumos-centro_costos')->where('cod_aux',$request['aux'])->first();


        //persistimos por medio de ELOQUENT
        $ELOQUENT_lineainventario = InsumoCentroCostos::find($lineainventario->id);


        //eliminamos la linea de inventario
        $query = $ELOQUENT_lineainventario->delete();

        return response()->json($query);


    }
}
