<?php
/**
 * User: DHernandez
 * Date: 26/3/2018
 * Time: 15:35
 */

namespace App\Repositories\CentroCostos;

use DB;

class BodegaRepository
{
    //funcion para poder listar los insumos que estan contenidos en las bodegas
    public function getInsumosByBodegaUser($user)
    {
        try
        {
            /*$insumos = DB::table('insumos-centro_costos as icc')
                        ->join('bodegas as b','b.id','=','icc.bodega_id')
                        ->join('insumos as i','i.id','=','icc.id_insumos')
                        ->join('estados_insumos as e','e.id','=','icc.estado_insumo')
                        ->select('i.nombre as insumo','i.activo as activo','icc.existencia as existencia','e.nombre as estado','icc.cod_aux as codigo_aux','i.id as codigo','icc.hoja_activo_id as hoja')
                        ->where('b.supervisor',$user)
                        ->get();*/


            $insumos = DB::table('emp_activos as a')
                                                ->leftjoin('bodegas as b','b.id','=','a.bodega_id')
                                                ->leftjoin('estados_insumos as e','e.id','=','a.vida_util')
                                                ->leftjoin('estado_hoja_activo as eha','eha.id','=','a.estado_activo')
                                                ->select('a.*','e.nombre as vidautil','b.codigo as bodega','eha.nombre as estadoactivo')
                                                ->where('b.supervisor',$user)
                                                ->get();

            return $insumos;
        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //funcion para listar los activos de una bodega x
    public function getActivosByBodega($bodega)
    {
        $activos = DB::table('emp_activos as a')
            ->leftjoin('bodegas as b','b.id','=','a.bodega_id')
            ->leftjoin('estados_insumos as e','e.id','=','a.vida_util')
            ->leftjoin('estado_hoja_activo as eha','eha.id','=','a.estado_activo')
            ->select('a.*','e.nombre as vidautil','b.codigo as bodega','eha.nombre as estadoactivo')
            ->where('b.id',$bodega)
            ->get();

        return $activos;

    }


    //funcion para listar las hojas de activo segun bodega
    public function getDetallesBodega($user)
    {

        try{

            $queryrun = DB::table('hojas_activos as ha')
                        ->join('detalles_hoja_activo as dha','dha.hoja_activo_id','=','ha.id')
                        ->join('insumos as i','i.id','=','dha.insumo_id')
                        ->join('estado_hoja_activo as eha','eha.id','=','ha.estado')
                        ->join('bodegas as b','b.id','=','ha.bodega_id')
                        ->join('electricistas as el','el.id','=','ha.usuario_asignado')
                        ->join('estados_insumos as ei','ei.id','=','dha.estado_insumo_id')
                        ->select('i.nombre as insumo','i.id as codigo','dha.*','ha.*','el.nombre as electricista','ei.nombre as estado','eha.nombre as estadoha')
                        ->where('b.supervisor',$user)
                        ->get();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para contabilidad para listar las herramientas que esten en proceso de baja
    public function contabilidadInsumosByBajas()
    {
        try{

            $queryrun = DB::table('hojas_activos as ha')
                ->leftjoin('detalles_hoja_activo as dha','dha.hoja_activo_id','=','ha.id')
                ->leftjoin('insumos as i','i.id','=','dha.insumo_id')
                ->leftjoin('estado_hoja_activo as eha','eha.id','=','ha.estado')
                ->leftjoin('bodegas as b','b.id','=','ha.bodega_id')
                ->leftjoin('electricistas as el','el.id','=','ha.usuario_asignado')
                ->leftjoin('estados_insumos as ei','ei.id','=','dha.estado_insumo_id')
                ->select('i.nombre as insumo','i.id as codigo','dha.*','ha.*','el.nombre as electricista','ei.nombre as estado','eha.nombre as estadoha','ha.id as hoja')
                ->where('dha.estado_HA',1)
                ->get();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //obtener detalles segun hoja de activo
    public function getDetallesByHojaActivo($hoja,$aux)
    {
        try
        {

            $insumos = DB::table('hojas_activos as ha')
                ->leftjoin('detalles_hoja_activo as dha','dha.hoja_activo_id','=','ha.id')
                ->leftjoin('insumos as i','i.id','=','dha.insumo_id')
                ->leftjoin('motivos_bajas as mb','mb.id','=','dha.motivo_baja_id')
                ->leftjoin('estado_hoja_activo as eha','eha.id','=','ha.estado')
                ->leftjoin('electricistas as el','el.id','=','ha.usuario_asignado')
                ->leftjoin('estados_insumos as ei','ei.id','=','dha.estado_insumo_id')
                ->select('mb.nombre as motivobaja','i.nombre as insumo','i.id as codigo','dha.cod_aux','dha.marca','dha.modelo','dha.serie','dha.cantidad','el.nombre as electricista','ei.nombre as estado','eha.nombre as estadoha')
                ->where('dha.hoja_activo_id',$hoja)
                ->where('dha.cod_aux',$aux)
                ->get();

            return $insumos;
        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //conteo de insumos en detalle
    public function getTotalInsumosByHojaActivo($hoja,$aux)
    {
        try
        {
            $queryrun = DB::table('detalles_hoja_activo as d')
                ->select(DB::raw('SUM(d.cantidad) as total'))
                ->where('d.hoja_activo_id',$hoja)
                ->where('d.cod_aux',$aux)
                ->first();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para estados de insumos
    public function estados($user,$insumo)
    {
        try
        {
            $queryrun = DB::table('hojas_activos as ha')
                ->join('detalles_hoja_activo as dha','dha.hoja_activo_id','=','ha.id')
                ->join('insumos as i','i.id','=','dha.insumo_id')
                ->join('bodegas as b','b.id','=','ha.bodega_id')
                ->join('electricistas as el','el.id','=','ha.usuario_asignado')
                ->join('estados_insumos as ei','ei.id','=','dha.estado_insumo_id')
                ->select('i.nombre as insumo','i.id as codigo','dha.*','ha.*','el.nombre as electricista','ei.nombre as estado')
                ->where('b.supervisor',$user)
                ->where('dha.insumo_id',$insumo)
                ->where('ha.estado',2)
                ->get();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //query para poder mostrar los cambios de estados en las herramientas de las bodegas en un periodo determinado
    public function query_cambiosEstadosHerram($desde,$hasta,$bodega)
    {
        try{

            $query = DB::table('bitacora_actualizacion_ins as b')
                            ->join('estados_insumos as e','e.id','=','b.estado')
                            ->join('users as u','u.id','=','b.user_id')
                            ->join('insumos as i','i.id','=','b.insumo')
                            ->select('b.*','u.nombre','u.apellido','i.nombre as insumo','e.nombre as estado')
                            ->whereBetween('b.fecha_actualizacion',[$desde,$hasta])
                            ->where('b.bodega_id',$bodega)
                            ->get();

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



}