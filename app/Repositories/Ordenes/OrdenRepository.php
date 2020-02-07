<?php
/**

 * User: Daniel Hernandez
 * Date: 14/12/2017
 * Time: 02:13 PM
 */

namespace App\Repositories\Ordenes;

use DB;
use App\OrdenCompra;
use Session;

class OrdenRepository
{
    //generar una nueva orden de compra
    public function saveOrden($orden)
    {
        try{

            $queryrun = $orden->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para listar la ultima orden de compra generada
    public function getLastOrden()
    {
        try{

            $query = DB::table('ordenes_compras')->orderBy('id','desc')->first();

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //obtener todas las ordenes del sistema guardadas
    public function getAllOrdenes()
    {
        try{

            $ordenes = DB::table('ordenes_compras as oc')
                ->join('requisiciones_insumos as rq','rq.id','=','oc.requisicion_id')
                ->join('users as u','u.id','=','rq.user_solicitante')
                ->join('tipos_requisiciones as tr','tr.id','=','rq.tipo_requisicion_id')
                ->join('estados_ordenes_compras as eoc','eoc.id','=','oc.ordenes_estado_id')
                ->join('proveedores as p','p.id','=','oc.proveedor_id')
                ->leftjoin('centro_costos as c','c.id','=','u.centro_costos_id')
                ->select(
                            'oc.*',
                            'oc.id as idordencompra',
                            'p.nombreentidad as proveedor',
                            'u.nombre as nombresolicitante',
                            'u.apellido as apellidosolicitante',
                            'rq.*',
                            'tr.nombre as tiporeq',
                            'eoc.nombre as estado'
                        )
                ->where('c.administrador',Session::get('idusuario'))
                ->get();

            return $ordenes;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para obtener una orden segun id
    public function getOrdenById($id)
    {
        try{

            $orden = DB::table('ordenes_compras as oc')
                ->join('requisiciones_insumos as rq','rq.id','=','oc.requisicion_id')
                ->join('users as u','u.id','=','rq.user_solicitante')
                ->join('estados_ordenes_compras as eoc','eoc.id','=','oc.ordenes_estado_id')
                ->join('proveedores as p','p.id','=','oc.proveedor_id')
                ->select(
                    'oc.*',
                    'oc.id as idordencompra',
                    'p.nombreentidad as proveedor',
                    'u.nombre as nombresolicitante',
                    'u.apellido as apellidosolicitante',
                    'u.centro_costos_id as centrocostos',
                    'rq.*',
                    'eoc.nombre as estado'
                )
                ->where('oc.id',$id)
                ->first();

            return $orden;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //obtener orden de compra ELOQUENT por id
    public function eloquentGetOrdenById($id)
    {
        try{

            $query = OrdenCompra::find($id);

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
}