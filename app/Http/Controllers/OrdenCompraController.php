<?php

namespace App\Http\Controllers;

use App\DetalleHojaActivo;
use App\DetalleOrden;
use App\EmpActivo;
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





class OrdenCompraController extends Controller
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
    public $totalorden = 0;
    public $ivaorden = 0;
    public $subtotalorden = 0;


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

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }




    public function store(Request $request)
    {

        $f1             = DateTime::createFromFormat('d/m/Y',$request['fechaentrega']);

        $fecha_entrega  = date_format($f1,'Ymd');

        //creamos el objeto de orden de compra
        $ordencompra = new OrdenCompra();

        //rellenamos el objeto
        $ordencompra->requisicion_id    = $request['requisicion'];
        $ordencompra->proveedor_id      = $request['proveedor'];
        $ordencompra->fecha_creacion    = date('Ymd');
        $ordencompra->fecha_entrega     = $fecha_entrega;
        $ordencompra->user_id           = Session::get('idusuario');
        $ordencompra->ordenes_estado_id = 1;
        $ordencompra->termino_pago_id   = $request['terminopago'];

        //persistimos el objeto de ordenes de compra
        $queryrun = $this->ordencompra->saveOrden($ordencompra);


        $ord_insumos = $request['codinsumos'];
        $ord_cantidades = $request['cantidades'];
        $ord_precios = $request['precios'];
        $ins_desc = $request['ins_desc'];


        if($queryrun==true)
        {


            $lastorden = $this->ordencompra->getLastOrden();


            //almacenamos los detalles de la orden
            for($i=0;$i<=count($ord_insumos)-1;$i++)
            {
                $detalles = new DetalleOrden();

                //persistimos el objeto
                $detalles->orden_compra_id  = $lastorden->id;
                $detalles->insumo_id        = (int)$ord_insumos[$i];
                $detalles->cantidad         = (int)$ord_cantidades[$i];
                $detalles->preciouni        = (double)$ord_precios[$i];
                $detalles->ins_descripcion   = $ins_desc[$i];

                $queryrun = $this->detalles->saveDetalles($detalles);



            }


            //actualizamos estado de la requisicion
            $rq = $this->requisicion->EloquentFindRequisicionById($ordencompra->requisicion_id);

            $rq->estado_requisicion_id = 3;

            //persistimos el objeto requisicion para actualizar su estado
            $qr = $this->requisicion->updateRequisicion($rq);


            if($queryrun==true)
            {
                return response()->json($queryrun);
            }
            else
            {
                return response()->json($queryrun);
            }


        }
        else
        {
            return response()->json($queryrun);
        }


    }




    public function show()
    {
        $ordenes = $this->ordencompra->getAllOrdenes();

        return view('insumos.admin.ordenes.index')->with('ordenes',$ordenes);
        //return json_encode($ordenes);
    }




    public function edit(Request $request)
    {
        $orden = $this->ordencompra->getOrdenById($request['idorden']);
        $detalles = $this->detalles->getDetallesOrden($request['idorden']);
        $bodegas = DB::table('bodegas')->get();
        $electricistas = DB::table('electricistas')->get();
        $agencias = DB::table('agencias')->get();
        $centrocostos = DB::table('centro_costos')->get();
        $departamentos = DB::table('DEPSV')->get();
        $municipios = DB::table('MUNSV')->get();
        $proveedores = DB::table('proveedores')->get();

        return view('insumos.admin.ordenes.show')
            ->with('municipios',$municipios)
            ->with('departamentos',$departamentos)
            ->with('agencias',$agencias)
            ->with('centrocostos',$centrocostos)
            ->with('electricistas',$electricistas)
            ->with('bodegas',$bodegas)
            ->with('orden',$orden)
            ->with('detalles',$detalles)
            ->with('proveedores',$proveedores);
        //return json_encode($detalles);
    }





    public function update(Request $request, $id)
    {
        //
    }






    public function destroy($id)
    {
        //
    }






    //mover insumos de orden de compra a centro de costos
    public function moverInsumosToCC(Request $request)
    {

        $cantidades = $request['cantidades'];
        $insumos = $request['insumos'];
        $precios = $request['precios'];
        $queryrun = "";
        $precioscomp = $request['precioscompra'];
        $modelos = $request['modelos'];
        $series = $request['series'];
        $marcas= $request['marcas'];

        $oc = $this->ordencompra->getOrdenById($request['ordencompra']);

        //obtenemos la requisicion
        $requisicion = $this->requisicion->getRequisicionById($oc->requisicion_id);



        $usuario = $this->user->getUserById(Session::get('idusuario'));




        if($requisicion->tipo_requisicion_id==4)
        {
            for($i=0; $i<count($cantidades); $i++)
            {
                $activo = new EmpActivo();

                $insumo = $this->insumo->getInsumoPorID($insumos[$i]);


                //PROVEEDOR
                $proveedor = $this->proveedor->getProveedorById($request['proveedorfinal']);


                $activo = new EmpActivo();



                $activo->tipo_activo        = $insumo->nombre;
                $activo->marca              = $marcas[$i];
                $activo->modelo             = $modelos[$i];
                $activo->fecha              = date('Ymd');
                $activo->ccf                = $request['ccf'];
                $activo->proveedor          = $proveedor->razonsocial;
                $activo->valor              = (double)$precioscomp[$i];
                $activo->area_inversion     = "";
                $activo->ubicacion          = "";
                $activo->cantidad           = 1;
                $activo->vida_util          = 1;
                $activo->centro_costo       = $request['centrocostos'];
                $activo->estado_activo      = 3;
                $activo->fecha_compra       = $request['fechacompra'];
                $activo->categoria_activo   = $requisicion->tipo_requisicion_id;



                //persistimos el objeto activo
                $queryrun = $activo->save();


            }


        }








        //recorremos por medio de un for todos los insumos que se cargaran al cc
        for($i=0; $i<count($cantidades); $i++)
        {

            //verificamos si existe el insumo
            $existenciainsumo = $this->ccinsumos->getExistencia($insumos[$i],$request['centrocostos']);

            //linea del insumo dentro del centro de costo por medio de QUERYBUILDER
            $lineabyinsumo = $this->ccinsumos->findLineaCCByInsumo($insumos[$i],$request['centrocostos']);

            if($existenciainsumo!="")
            {
                if($existenciainsumo->existencia>=0)
                {
                    //obtenemos la linea de insumos del centro de costos para solo actualizar su existencia
                    //por medio de ELOQUENT
                    $lineacc = $this->ccinsumos->findLineaCC($lineabyinsumo->id);

                    $lineacc->existencia = $existenciainsumo->existencia + $cantidades[$i];

                    //persistimos el objeto
                    $queryrun = $this->ccinsumos->saveInsumosCentroCostos($lineacc);
                }

            }
            else
            {
                //objeto para ingresar a centro de costos insumos
                $insumoCC = new InsumoCentroCostos();

                $insumoCC->id_centro_costos     = $request['centrocostos'];
                $insumoCC->id_insumos           = $insumos[$i];
                $insumoCC->existencia           = $cantidades[$i];
                $insumoCC->marca                = $marcas[$i];
                $insumoCC->modelo               = $modelos[$i];
                $insumoCC->serie                = $series[$i];




                //persistimos el objeto
                $queryrun = $this->ccinsumos->saveInsumosCentroCostos($insumoCC);
            }

        }



        //-----------------------------------------------------------------------------
        //creamos los movimientos necesarios para cada insumo cargado al CC

        //recorremos por medio de un for todos los insumos que se cargaron al cc y los convertimos en movimientos
        for($i=0; $i<=count($cantidades)-1; $i++)
        {
            //objeto para registrar el movimiento del insumo como entrada
            $movimientoinsumo = new MovimientoInsumo();

            //rellenamos el objeto movimiento para almacenarlo en la db
            $movimientoinsumo->insumo_id            = $insumos[$i];
            $movimientoinsumo->fecha_movimiento     = date('Ymd');
            $movimientoinsumo->cantidad_movimiento  = $cantidades[$i];
            $movimientoinsumo->user_id              = Session::get('idusuario');
            $movimientoinsumo->centro_costos_id     = $request['centrocostos'];
            $movimientoinsumo->orden_compra_id      = $request['ordencompra'];

            //persistimos el movimiento para quede registrado como una entrada de insumo
            $this->movimiento->saveMovimiento($movimientoinsumo);

        }



        //---------------------------------------------------------------------------






        if ($queryrun==true)
        {

            //recibimos la fecha
            $fechacompra = date_create($request['fechacompra']);

            //actualizaremos el estado de la orden de compra a cerrado ya que se descargaron los insumos al CC
            $ordendecompra = $this->ordencompra->eloquentGetOrdenById($request['ordencompra']);

            $ordendecompra->ordenes_estado_id   = 3;
            $ordendecompra->num_ccf = $request['ccf'];
            $ordendecompra->proveedor_final = $request['proveedorfinal'];
            $ordendecompra->fecha_compra = date_format($fechacompra,'Ymd H:i');

            //persistimos la actualizacion del objeto de tipo orden
            $this->ordencompra->saveOrden($ordendecompra);


            //recorrer los detalles de la orden para actualizar los precios de compra
            for($i=0; $i<count($cantidades); $i++)
            {
                DB::table('detalles_orden_compra')->where('insumo_id',$insumos[$i])->where('orden_compra_id',$ordendecompra->id)->update(['preciocompra'=> $precioscomp[$i]]);

            }


            return response()->json($queryrun);

        }
        else
        {
            return response()->json($queryrun);
        }
    }


    //funcion para poder mover insumos a una bodega
    public function moverInsumosToBodega(Request $request)
    {

        $cantidades = $request['cantidades'];
        $insumos    = $request['insumos'];
        $precios    = $request['precios'];
        $modelos    = $request['modelos'];
        $series      = $request['series'];
        $marcas     = $request['marcas'];
        $queryrun   = "";
        $precioscomp = $request['precioscompra'];

         $f =  date_create_from_format('Y-m-d',$request['fechacompra']);
         $fecha = date_format($f,'Ymd H:i');


        $orden = $this->ordencompra->getOrdenById($request['ordencompra']);

        $usuario = $this->user->getUserById(Session::get('idusuario'));
        $bodega = DB::table('bodegas')->where('supervisor',$orden->user_solicitante)->first();

        //obtenemos la requisicion
        $requisicion = $this->requisicion->getRequisicionById($orden->requisicion_id);

        //recorremos por medio de un for todos los insumos que se cargaran al cc
        for($i=0; $i<=count($cantidades)-1; $i++)
        {
            $insumo = $this->insumo->getInsumoPorID($insumos[$i]);

            //dentro del mismo for vamos a guardar los movimientos en la tabla movimientos_insumos para el kardex
            $movimientoinsumo = new MovimientoInsumo();
            //rellenamos el objeto movimiento para almacenarlo en la db
            $movimientoinsumo->insumo_id            = $insumos[$i];
            $movimientoinsumo->fecha_movimiento     = date('Ymd');
            $movimientoinsumo->cantidad_movimiento  = $cantidades[$i];
            $movimientoinsumo->user_id              = $usuario->id;
            $movimientoinsumo->bodegas_id           = $bodega->id;
            $movimientoinsumo->orden_compra_id      = $request['ordencompra'];


            //persistimos el movimiento para quede registrado como una entrada de insumo
            $this->movimiento->saveMovimiento($movimientoinsumo);


            //Recorrer con un for para guardar las herramientas con sus codigos auxiliares
            for($j=0; $j<=$cantidades[$i]-1; $j++)
            {
                //query para poder encontrar el total de insumos que se encuentran ya de un id para poder generar uno nuevo
                $conteoins = DB::table('insumos-centro_costos')
                    ->where('id_insumos',$insumos[$i])
                    ->where('bodega_id',$bodega->id)
                    ->count();

                //PROVEEDOR
                $proveedor = $this->proveedor->getProveedorById($request['proveedorfinal']);


                $activo = new EmpActivo();



                $activo->tipo_activo        = $insumo->nombre;
                $activo->marca              = $marcas[$i];
                $activo->modelo             = $modelos[$i];
                $activo->fecha              = date('Ymd H:i');
                $activo->ccf                = $request['ccf'];
                $activo->proveedor          = $proveedor->razonsocial;
                $activo->valor              = (double)$precioscomp[$i];
                $activo->area_inversion     = "";
                $activo->ubicacion          = "";
                $activo->cantidad           = 1;
                $activo->centro_costo       = $request['centrocostos'];
                $activo->bodega_id          = $bodega->id;
                $activo->estado_activo      = 3;
                $activo->vida_util          = 1;
                $activo->fecha_compra       = $fecha;
                $activo->categoria_activo   = $requisicion->tipo_requisicion_id;



                //persistimos el objeto activo
                $queryrun = $activo->save();
            }



        }



        //actualizamos la orden de comrpa su estado a cerrado
        if ($queryrun==true)
        {
            //recibimos la fecha
            $fechacompra = date_create($request['fechacompra']);

            //actualizaremos el estado de la orden de compra a cerrado ya que se descargaron los insumos al CC
            $ordendecompra = $this->ordencompra->eloquentGetOrdenById($request['ordencompra']);

            $ordendecompra->ordenes_estado_id   = 3;
            $ordendecompra->num_ccf = $request['ccf'];
            $ordendecompra->proveedor_final = $request['proveedorfinal'];
            $ordendecompra->fecha_compra = $fecha;

            //persistimos la actualizacion del objeto de tipo orden
            $this->ordencompra->saveOrden($ordendecompra);


            //recorrer los detalles de la orden para actualizar los precios de compra
            for($i=0; $i<count($cantidades); $i++)
            {
                DB::table('detalles_orden_compra')->where('insumo_id',$insumos[$i])->where('orden_compra_id',$ordendecompra->id)->update(['preciocompra'=> $precioscomp[$i]]);

            }


            return response()->json($queryrun);

        }
        else
        {
            return response()->json($queryrun);
        }


    }







    //generar el pdf de la orden de compra guardada
    public function generarPDF()
    {
        $lastorden = $this->ordencompra->getLastOrden();
        $tiporequisicion = $this->detalles->getTipoRequisicion($lastorden->id);

        if ($tiporequisicion->nombre =='Herramientas')
        {
            //$total = $this->detalles->getTotal($lastorden->id);

            $us = $this->detalles->getSolicitanteOCC($lastorden->id);
                
            $solicitante = $us->nombreempleado.' '.$us->apellidoempleado;
            
            $terminopago = DB::table('ordenes_term_pagos as otp')->join('ordenes_compras as oc','otp.id','=','oc.termino_pago_id')->select('otp.nombre as termino')->first();

            $iva = $this->detalles->getIva($lastorden->id);

            $subtotal = $this->detalles->getSubTotal($lastorden->id);

            $proveedor = $this->proveedor->getProveedorById($lastorden->proveedor_id);

            $user = $this->user->getUserById(Session::get('idusuario'));

            $detalles = $this->detalles->getDetallesOrden($lastorden->id);

            $view =  \View::make('insumos.admin.ordenes.pdf_orden', compact('solicitante','terminopago','subtotal','iva','lastorden','detalles','user','proveedor'))->render();

            $pdf = \App::make('dompdf.wrapper');

            $pdf->loadHTML($view);

            //return response()->json($iva);

            return $pdf->stream('ordencompra.pdf');
        }
        else
        {
            //$total = $this->detalles->getTotal($lastorden->id);

            $us = $this->detalles->getSolicitanteOCC($lastorden->id);

            $solicitante = $us->nombreempleado.' '.$us->apellidoempleado;

            $terminopago = DB::table('ordenes_term_pagos as otp')->join('ordenes_compras as oc','otp.id','=','oc.termino_pago_id')->select('otp.nombre as termino')->first();

            $iva = $this->detalles->getIva($lastorden->id);

            $subtotal = $this->detalles->getSubTotal($lastorden->id);

            $proveedor = $this->proveedor->getProveedorById($lastorden->proveedor_id);

            $user = $this->user->getUserById(Session::get('idusuario'));

            $detalles = $this->detalles->getDetallesOrden($lastorden->id);

            $view =  \View::make('insumos.admin.ordenes.pdf_orden', compact('solicitante','terminopago','subtotal','iva','lastorden','detalles','user','proveedor'))->render();

            $pdf = \App::make('dompdf.wrapper');

            $pdf->loadHTML($view);

            //return response()->json($iva);

            return $pdf->stream('ordencompra.pdf');
        }


    }


    //guardar hoja de activo
    public function saveHojaActivo(Request $request)
    {
        //guardamos la hoja de activo
        $hojaactivo = new HojaActivos();

        $hojaactivo->fechacreacion          = date('Ymd');
        //$hojaactivo->orden_compra_id    = $request['oc'];
        $hojaactivo->agencia_id             = $request['ag'];
        $hojaactivo->usuario_asignado       = $request['electricista'];
        $hojaactivo->centro_costo_id        = $request['centrocostos'];
        $hojaactivo->justificacion          = $request['justificacion'];
        if($request['bodega'])
        {
            $hojaactivo->bodega_id          = $request['bodega'];
        }
        $hojaactivo->sv_departamento_id     = $request['departamento'];
        $hojaactivo->sv_municipio_id        = $request['municipio'];
        $hojaactivo->estado                 = 2;



        //persistimos el objeto de la hoja de activo
        $queryrun = $this->activo->saveHojaActivo($hojaactivo);

        //obtener la ultima hoja de activo generada
        $hojalast = $this->activo->getLast();

        //guardar detalles de la hoja de activo generada
        $detalles = new DetalleHojaActivo();

        //partimos el array de insumo y la linea donde pertenece en el centro de costos
        $array = explode('-',$request['insumo']);


        $lineainventario = DB::table('insumos-centro_costos')->where('cod_aux',$request['insumo'])->first();

        $detalles->insumo_id            = $array[0];
        $detalles->cantidad             = $request['cantidad'];
        $detalles->hoja_activo_id       = $hojalast->id;
        $detalles->estado_insumo_id     = $request['estado'];
        $detalles->serie                = $lineainventario->serie;
        $detalles->modelo               = $lineainventario->modelo;
        $detalles->marca                = $lineainventario->marca;
        $detalles->cod_aux              = $request['insumo'];


        //persistimos los detalles
        $queryrun = $this->activo->saveDetalles($detalles);

        //linea del centro de costos para adjuntar la hoja de activo
        $icc = $this->ccinsumos->findLineaCC($lineainventario->id);

        $icc->hoja_activo_id = $hojalast->id;

        //persistimos
        $icc->save();



        return response()->json($queryrun);

    }





    public function imprimirHojaActivo(Request $request)
    {

        $us = $this->user->getUserById(Session::get('idusuario'));


        $solicitante = $us->nombre.' '.$us->apellido;

        $insumos = $this->bodega->getDetallesByHojaActivo($request['id'],$request['aux']);

        $total = $this->bodega->getTotalInsumosByHojaActivo($request['id'],$request['aux']);

        $hojaactivo = $this->activo->getELOQUENTHojaActivo($request['id']);

        $view =  \View::make('insumos.supervisor.hojaactivoPDF', compact('solicitante','total','insumos','hojaactivo'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);



        //return response()->json($hojaactivo);

        return $pdf->stream('hojaactivo.pdf');

        //return response()->json($total);
    }









}
