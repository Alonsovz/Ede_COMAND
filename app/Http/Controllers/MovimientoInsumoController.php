<?php

namespace App\Http\Controllers;

use App\Insumo;
use App\InsumoCentroCostos;
use DateTime;
use Illuminate\Http\Request;
use DB;
use Session;
use App\MovimientoInsumo;
use App\Repositories\Movimientos\MovimientoRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Insumos\InsumoRepository;
use App\Repositories\CentroCostos\InsumoCentroCostosRepository;
use App\Repositories\CentroCostos\CentroCostosRepository;

class MovimientoInsumoController extends Controller
{


    public $usuario;
    public $movimiento;
    public $insumo;
    public $insumocc;
    public $cc;



    //constructor
    function __construct(CentroCostosRepository $cc,InsumoCentroCostosRepository $insumocc,UserRepository $usuario, MovimientoRepository $movimiento,InsumoRepository $insumo)
    {
        $this->movimiento = $movimiento;
        $this->usuario = $usuario;
        $this->insumo = $insumo;
        $this->insumocc = $insumocc;
        $this->cc = $cc;
    }

    public function create()
    {
        //
    }


    public function salida(Request $request)
    {
        $movimiento = new MovimientoInsumo();

        $usuario = $this->usuario->getUserById(Session::get('idusuario'));
        $insumo = $this->insumo->findIdByname($request['insumo']);
        $u_id = null;

        if($request['usuarioasignado']!='')
        {
            //usuario asignado buscamos su id
            $asignado = $request['usuarioasignado'];

            $array = explode(" ",$asignado);

            $u = $this->usuario->getUserByNames($array[0],$array[1]);

            $u_id = $u->id;
        }


        $movimiento->insumo_id              = $insumo->id;
        $movimiento->fecha_movimiento       = date('Ymd');
        $movimiento->cantidad_movimiento    = $request['cantidad']*(-1);
        $movimiento->user_id                = Session::get('idusuario');
        $movimiento->centro_costos_id       = $usuario->centro_costos_id;
        $movimiento->usuario_asignado       = $u_id;
        $movimiento->descripcion            = $request['descripcion'];





        //verificamos la existencia del insumo
        $existencia = $this->insumocc->getExistencia($movimiento->insumo_id,$movimiento->centro_costos_id);

        //validamos si la existencia es mayor que la cantidad el movimiento que se quiere realizar
        if($existencia->existencia>=$request['cantidad'])
        {
            //persistimos el objeto movimientos media vez la cantidad de salida del insumo sea menor o igual que la existencia
            $queryrun = $this->movimiento->saveMovimiento($movimiento);

            if($queryrun==true)
            {

                //buscamos el objeto de tipo querybuilder para subtraer el id de la linea que contiene el insumo
                $icc_queryb = $this->insumocc->findLineaCCByInsumo($movimiento->insumo_id,$movimiento->centro_costos_id);

                //luego con eloquent utilizaremos el metodo save para persistir el objeto actualizando la existencia
                $icc_eloquent = $this->insumocc->findLineaCC($icc_queryb->id);

                //actualizamos la existencia
                $icc_eloquent->existencia = $existencia->existencia - (int)$request['cantidad'];

                //persistimos la linea del centro de costos con el id del insumo respectivo donde actual. su exist.
                $qq = $this->insumocc->updateExistencia($icc_eloquent);


                return response()->json($qq);
            }
            else
            {
                return response()->json($queryrun);

            }
        }
        else
        {
            return response()->json('movimiento erroneo');
        }

    }


    public function show($id)
    {
        //
    }



    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }



    public function destroy($id)
    {
        //
    }



    //inventario inicial
    public function inventarioInicial()
    {
        $bodegas = DB::table('bodegas')->get();
        $estados = DB::table('estados_insumos')->get();
        $cc= $this->cc->getCentrosCostos();


        return view('insumos.admin.inventario.levantamiento')
            ->with('estados',$estados)
            ->with('bodegas',$bodegas)
            ->with('centrocostos',$cc);
    }



    //entrada inicial de inventario
    public function invInicialPapeleria(Request $request)
    {
        $cantidades = $request['cantidades'];
        $insumos    = $request['insumos'];
        $queryrun   = "";

        $usuario = $this->usuario->getUserById(Session::get('idusuario'));

        //recorremos por medio de un for todos los insumos que se cargaran al cc
        for($i=0; $i<=count($cantidades)-1; $i++)
        {

                //objeto para ingresar a centro de costos insumos
                $insumoCC = new InsumoCentroCostos();

                //objeto para registrar el movimiento del insumo como entrada
                $movimientoinsumo = new MovimientoInsumo();

                //rellenamos el objeto movimiento para almacenarlo en la db
                $movimientoinsumo->insumo_id            = $insumos[$i];
                $movimientoinsumo->fecha_movimiento     = date('Ymd');
                $movimientoinsumo->cantidad_movimiento  = $cantidades[$i];
                $movimientoinsumo->user_id              = $usuario->id;
                $movimientoinsumo->centro_costos_id     = $usuario->centro_costos_id;
                $movimientoinsumo->tipomovimiento      = "INV_IN";

                //persistimos el movimiento para quede registrado como una entrada de insumo
                $queryrun = $movimientoinsumo->save();


                $insumoCC->id_insumos       = $insumos[$i];
                $insumoCC->id_centro_costos = $usuario->centro_costos_id;
                $insumoCC->existencia       = $cantidades[$i];

                 $insumoCC->save();

        }

        return response()->json($queryrun);
    }


    //funcion para inventario inicial herramientas
    public function invInicialHerramienta(Request $request)
    {


        $cantidades = $request['cantidades'];
        $insumos    = $request['insumos'];
        $queryrun   = "";
        $bodegas    = $request['bodegas'];
        $estados    = $request['estados'];

        $usuario = $this->usuario->getUserById(Session::get('idusuario'));
        $bodega  = DB::table('bodegas')->select('id')->where('supervisor',Session::get('idusuario'))->first();


        //recorremos por medio de un for todos los insumos que se cargaran al cc
        for($i=0; $i<=count($cantidades)-1; $i++)
        {

            //recorremos el for para poder crear los codigos auxiliares
            for($j=0; $j<=$cantidades[$i]-1; $j++)
            {
                //query para poder encontrar el total de insumos que se encuentran ya de un id para poder generar uno nuevo
                $conteoins = DB::table('insumos-centro_costos')
                    ->where('id_insumos',$insumos[$i])
                    ->where('bodega_id',$bodega->id)
                    ->count();

                //objeto para ingresar a centro de costos insumos
                $insumoCC = new InsumoCentroCostos();
                $insumoCC->bodega_id            = $bodega->id;
                $insumoCC->id_insumos           = $insumos[$i];
                $insumoCC->existencia           = 1;
                $insumoCC->cod_aux              = $insumos[$i].'-'.$bodega->id.'-'.($conteoins+1);
                $insumoCC->estado_insumo        = $estados[$i];


                //persistimos el objeto
                $queryrun = $this->insumocc->saveInsumosCentroCostos($insumoCC);
            }


        }

        //recorremos por medio de un for todos los insumos que se cargaran al cc
        for($k=0; $k<=count($cantidades)-1; $k++)
        {
            //objeto para registrar el movimiento del insumo como entrada
            $movimientoinsumo = new MovimientoInsumo();

            //rellenamos el objeto movimiento para almacenarlo en la db
            $movimientoinsumo->insumo_id            = $insumos[$k];
            $movimientoinsumo->fecha_movimiento     = date('Ymd');
            $movimientoinsumo->cantidad_movimiento  = $cantidades[$k];
            $movimientoinsumo->user_id              = $usuario->id;
            $movimientoinsumo->bodegas_id            = $bodega->id;
            $movimientoinsumo->tipomovimiento      = "INV_IN";

            //persistimos el movimiento para quede registrado como una entrada de insumo
            $this->movimiento->saveMovimiento($movimientoinsumo);
        }

        return response()->json($queryrun);
    }



    //funcion para levantar el inventario inicial de oficina
    public function invInicialOficina(Request $request)
    {
        $usuario = $this->usuario->getUserById(Session::get('idusuario'));

        $cantidades = $request['cantidades'];
        $insumos    = $request['insumos'];
        $queryrun   = "";
        $cc         = $request['cc'];
        $estados    = $request['estados'];

        //recorremos por medio de un for todos los insumos que se cargaran al cc
        for($i=0; $i<=count($cantidades)-1; $i++)
        {
            $centrocosto = DB::table('centro_costos')->select('id')->where('nombre',$cc[$i])->first();


            for($j=0; $j<=$cantidades[$i]-1; $j++)
            {
                //query para poder encontrar el total de insumos que se encuentran ya de un id para poder generar uno nuevo
                $conteoins = DB::table('insumos-centro_costos')
                    ->where('id_insumos',$insumos[$i])
                    ->where('bodega_id',$centrocosto->id)
                    ->count();

                //objeto para ingresar a centro de costos insumos
                $insumoCC = new InsumoCentroCostos();
                $insumoCC->id_centro_costos     = $centrocosto->id;
                $insumoCC->id_insumos           = $insumos[$i];
                $insumoCC->existencia           = 1;
                $insumoCC->cod_aux              = $insumos[$i].'-'.$centrocosto->id.'-'.($conteoins+1);
                $insumoCC->estado_insumo        = $estados[$i];


                //persistimos el objeto
                $queryrun = $this->insumocc->saveInsumosCentroCostos($insumoCC);
            }

        }

        for($k=0; $k<=count($cantidades)-1; $k++)
        {

            //objeto para ingresar a centro de costos insumos
            $insumoCC = new InsumoCentroCostos();

            //objeto para registrar el movimiento del insumo como entrada
            $movimientoinsumo = new MovimientoInsumo();

            //rellenamos el objeto movimiento para almacenarlo en la db
            $movimientoinsumo->insumo_id            = $insumos[$k];
            $movimientoinsumo->fecha_movimiento     = date('Ymd');
            $movimientoinsumo->cantidad_movimiento  = $cantidades[$k];
            $movimientoinsumo->user_id              = $usuario->id;
            $movimientoinsumo->centro_costos_id     = $usuario->centro_costos_id;
            $movimientoinsumo->tipo_movimiento      = "INV_IN";

            //persistimos el movimiento para quede registrado como una entrada de insumo
            $this->movimiento->saveMovimiento($movimientoinsumo);



        }

        return response()->json($queryrun);
    }


}
