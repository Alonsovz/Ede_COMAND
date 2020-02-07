<?php
/**

 * User: Daniel Hernandez
 * Date: 15/12/2017
 * Time: 09:52 AM
 */

namespace App\Repositories\CentroCostos;

use App\CentroCostos;
use DB;
use FontLib\Table\Type\head;


class CentroCostosRepository
{



    //listar centros de costos
    public function getCentrosCostos()
    {
        try{

            $centrocostos  = DB::table('centro_costos')->get();

            return $centrocostos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //obtener todos los insumos dentro del centro de costos
    public function getInsumosCentroCostos($idcentrocostos)
    {
        try{

            $insumos = DB::table('insumos as ins')
                ->leftjoin('insumos-centro_costos as icc','icc.id_insumos','=','ins.id')
                ->leftjoin('insumos_categorias as ci','ci.id','=','ins.categoria_insumo_id')
                ->leftjoin('ins_unidades_medida as um','um.id','=','ins.unidad_medida_id')
                ->select(DB::raw('icc.marca,icc.modelo,icc.serie,icc.hoja_activo_id,ins.id,ins.nombre as insumo,icc.cod_aux as cod_aux, um.nombre as unidad,  icc.existencia as existencia,ci.nombre as categoria,um.nombre as unidad,icc.id as linea'))
                ->where('icc.id_centro_costos',$idcentrocostos)
                ->get();

            return $insumos;

        }catch(\Exception $e)
        {   
            return $e->getMessage();
        }

    }


    //obtener insumos dentro de bodega
    public function getInsumosCentroCostosByBodega($bodega)
    {
        try{

            $insumos = DB::table('hojas_activos as ha')
                ->join('detalles_hoja_activo as dha','dha.hoja_activo_id','=','ha.id')
                ->join('insumos as i','i.id','=','dha.insumo_id')
                ->join('bodegas as b','b.id','=','ha.bodega_id')
                ->join('electricistas as el','el.id','=','ha.usuario_asignado')
                ->join('estado_hoja_activo as eha','eha.id','=','ha.estado')
                ->join('estados_insumos as ei','ei.id','=','dha.estado_insumo_id')
                ->select('i.nombre as insumo','i.id as codigo','dha.*','ha.*','el.nombre as electricista',
                    'ei.nombre as estado','eha.nombre as estadoha','dha.cod_aux as cod_aux')
                ->where('b.id',$bodega)
                ->get();

            /*$insumos = DB::table('insumos as ins')
                ->join('insumos-centro_costos as icc','icc.id_insumos','=','ins.id')
                ->join('estados_insumos as ei','ei.id','=','icc.estado_insumo')
                ->select(DB::raw('ei.nombre as estado,ins.nombre as insumo, sum(icc.existencia) as existencia'))
                ->where('icc.bodega_id',$bodega)
                ->groupBy('ins.nombre','ei.nombre')
                ->get();*/


            return $insumos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //Detalles de hojas de activos para centros de costos
    public function getInsumosHAByCC($cc)
    {
        try{

            $insumos = DB::table('hojas_activos as ha')
                ->join('detalles_hoja_activo as dha','dha.hoja_activo_id','=','ha.id')
                ->join('centro_costos as cc','cc.id','=','ha.centro_costo_id')
                ->join('insumos as i','i.id','=','dha.insumo_id')
                ->join('insumos_categorias as ica','ica.id','=','i.categoria_insumo_id')
                ->join('electricistas as el','el.id','=','ha.usuario_asignado')
                ->join('estado_hoja_activo as eha','eha.id','=','ha.estado')
                ->join('estados_insumos as ei','ei.id','=','dha.estado_insumo_id')
                ->select('i.nombre as insumo','i.id as codigo','dha.*','ha.*','el.nombre as electricista',
                    'ei.nombre as estado','eha.nombre as estadoha')
                ->where('ha.centro_costo_id',$cc)
                ->where('ica.id',4)
                ->get();


            return $insumos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }





    //funcion para obtener un centro de costos en base al id del usuario
    public function getCCByUser($id)
    {
        try{

           $cc = DB::table('centro_costos as cc')->join('users as u','u.centro_costos_id','=','cc.id')
                                                 ->select('cc.nombre as centro_costos','cc.id')
                                                 ->where('u.id',$id)
                                                 ->first();

            return $cc;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }

    }



    //funcion para obtener el nombre de un centro de costos
    public function getNombreCC($id)
    {
        try{

            $cc = DB::table('centro_costos as cc')
                ->select('cc.nombre as nombre','cc.id as id')
                ->where('cc.id',$id)
                ->first();

            return $cc;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para listar bodegas
    public function getBodegas()
    {
        try{

            $bodegas = DB::table('bodegas')->get();

            return $bodegas;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //total de insumos por cc
    public function getTotalInsumosByCC($cc)
    {
        try{

            $suma = DB::table('insumos-centro_costos as icc')->select(DB::raw('sum(icc.existencia) as suma'))
                ->where('icc.id_centro_costos',$cc)->first();

            return $suma;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //total de insumos por bodega
    public function getTotalInsumosByBodega($bodega)
    {
        try{

            $suma = DB::table('insumos-centro_costos as icc')->select(DB::raw('sum(icc.existencia) as suma'))
                ->where('icc.bodega_id',$bodega)->where('icc.hoja_activo_id')->first();

            return $suma;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //obtener precio del insumo dentro del centro de costo
    public function getPriceForInsumo($insumo)
    {
        try{

            $precio = DB::table('movimientos_insumos as mi')
                        ->join('ordenes_compras as o','mi.orden_compra_id','=','o.id')
                        ->join('detalles_orden_compra as do','do.orden_compra_id','=','o.id')
                        ->join('insumos as i','i.id','=','do.insumo_id')
                        ->select('do.preciocompra as precio','i.nombre as insumo')
                        ->where('i.id',$insumo)->get();

            return $precio;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }

    }





}