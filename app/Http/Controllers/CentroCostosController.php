<?php

namespace App\Http\Controllers;

use App\InsumoCentroCostos;
use Illuminate\Http\Request;
use Session;
use DB;
use App\Repositories\CentroCostos\CentroCostosRepository;
use App\Repositories\Insumos\InsumoRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Activos\ActivoRepository;

class CentroCostosController extends Controller
{

    //variables globales
    public $centrocostos;
    public $insumos;
    public $usuario;
    public $activo;

    //constructor
    function __construct(CentroCostosRepository $centrocostos,InsumoRepository $insumos,UserRepository $usuario,ActivoRepository $activo)
    {
        $this->centrocostos = $centrocostos;
        $this->insumos = $insumos;
        $this->usuario = $usuario;
        $this->activo  = $activo;
    }





    public function create()
    {

    }





    public function store(Request $request)
    {
        //
    }


    public function show()
    {
        $centrocostos = $this->centrocostos->getCentrosCostos();

        return view('insumos.admin.centrocostos.index')->with('centrocostos',$centrocostos);
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


    //obtener los insumos segun centro de costos
    public function getInsumosCC(Request $request)
    {

        $insumos = $this->centrocostos->getInsumosCentroCostos($request['centrocosto']);

        $centrocostos = $this->centrocostos->getNombreCC($request['centrocosto']);

        $suma = $this->centrocostos->getTotalInsumosByCC($request['centrocosto']);

        return view('insumos.admin.subviews.tablascc')
            ->with('suma',$suma)
            ->with('insumos',$insumos)->with('centrocosto',$centrocostos);

        //return response()->json($insumos);

    }


    //funcion para listar los insumos segun Bodega
    public function getInsumosBodegas(Request $request)
    {

        $insumos = $this->centrocostos->getInsumosCentroCostosByBodega($request['bodega']);

        $bodega = DB::table('bodegas')->select('codigo')->where('id',$request['bodega'])->first();

        $suma = $this->centrocostos->getTotalInsumosByBodega($request['bodega']);

        return view('insumos.admin.subviews.tablasbodegas')
            ->with('bodega',$bodega)
            ->with('suma',$suma)
            ->with('insumos',$insumos);

        //return response()->json($insumos);

    }




    //obtener la vista de los movimientos para supervisor
    public function indexSupervisor()
    {
        $cc = $this->centrocostos->getCCByUser(Session::get('idusuario'));
        $insumos = $this->centrocostos->getInsumosCentroCostos($cc->id);
        $agencias = DB::table('agencias')->get();
        $departamentos = DB::table('DEPSV')->get();
        $electricistas = DB::table('electricistas')->get();
        $centros = DB::table('centro_costos')->get();
        $bodegas = DB::table('bodegas')->get();
        $estados = DB::table('estados_insumos')->get();
        $usuario = $this->usuario->getUserById(Session::get('idusuario'));

        $areas = DB::table('departamentos')->get();

        $activos = $this->activo->getActivosByCC($usuario->centro_costos_id);

        $detallesCC = $this->centrocostos->getInsumosHAByCC($usuario->centro_costos_id);

        $tipostraslados = DB::table('act_tipos_traslados')->get();



        //return json_encode($activos);

        return view('insumos.supervisor.movimientos')
                        ->with('insumos',$insumos)
                        ->with('centrocostos',$cc)
                        ->with('agencias',$agencias)
                        ->with('departamentos',$departamentos)
                        ->with('electricistas',$electricistas)
                        ->with('activos',$activos)
                        ->with('estados',$estados)
                        ->with('centros',$centros)
                        ->with('detalles',$detallesCC)
                        ->with('areas',$areas)
                        ->with('tipostraslados',$tipostraslados);


        //return view('mantenimiento.mantenimiento');
    }


    //funcion para mostrar la vista de bodegas
    public function viewBodegas()
    {
        $bodegas = $this->centrocostos->getBodegas();
        $electricistas = DB::table('electricistas')->get();
        $departamentos = DB::table('DEPSV')->get();
        $agencias = DB::table('agencias')->get();
        $centrocostos = $this->centrocostos->getCentrosCostos();

        return view('insumos.admin.bodegas.index')
            ->with('electricistas',$electricistas)
            ->with('departamentos',$departamentos)
            ->with('agencias',$agencias)
            ->with('centrocostos',$centrocostos)
            ->with('bodegas',$bodegas);
    }



    //obtener precio de compra del insumo
    public function getPriceInsumo(Request $request)
    {
        $array = explode('-',$request['insumo']);

        $insumo = $this->insumos->findIdByname($array[0]);
        $precio = $this->centrocostos->getPriceForInsumo($insumo->id);

        return response()->json($precio);

    }



}
