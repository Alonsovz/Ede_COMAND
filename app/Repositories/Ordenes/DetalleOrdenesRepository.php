<?php
/**

 * User: Daniel Hernandez
 * Date: 14/12/2017
 * Time: 02:37 PM
 */

namespace App\Repositories\Ordenes;
use DB;
use App\DetalleOrden;

class DetalleOrdenesRepository
{
    //guardar detalles de orden
    public function saveDetalles($detalles)
    {
        try{

            $queryrun = $detalles->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para listar detalles de la orden
    public function getDetallesOrden($id)
    {
        try{

            $detalles =  DB::table('insumos')
                ->leftjoin('detalles_orden_compra as od','od.insumo_id','=','insumos.id')
                ->leftjoin('ordenes_compras as oc','oc.id','=','od.orden_compra_id')
                ->leftjoin('requisiciones_insumos as ri','oc.requisicion_id','=','ri.id')
                ->leftjoin('users as u','u.id','=','ri.user_solicitante')
                ->leftjoin('proveedores as p','p.id','=','oc.proveedor_id')
                ->leftjoin('ordenes_term_pagos as otp','otp.id','=','oc.termino_pago_id')
                ->select('ri.tipo_requisicion_id as tiporequisicion','otp.nombre as terminopago','insumos.nombre as insumo','od.cantidad as cantidad',
                    'insumos.id as codinsumo','od.preciouni as precio','p.razonsocial','oc.fecha_compra','od.preciocompra as preciocompra','od.ins_descripcion as ins_descripcion')
                ->where('od.orden_compra_id',$id)
                ->get();

            return $detalles;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para calcular el iva
    public function getIva($idordencompra)
    {
        try{

            $iva = DB::table('detalles_orden_compra as doc')->select(DB::raw('sum(doc.preciouni*0.13) AS iva'))
                    ->where('doc.orden_compra_id',$idordencompra)
                    ->first();

            return $iva;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para calcular el subtotal de la orden de compra
    public function getSubTotal($idordencompra)
    {
        try{

            $subtotal = DB::table('detalles_orden_compra as doc')
                ->select(DB::raw('sum(doc.preciouni*doc.cantidad) as subtotal'))
                ->where('doc.orden_compra_id',$idordencompra)
                ->first();

            return $subtotal;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //funcion para listar el usuario que solicito la requisicion
    public function getSolicitanteOCC($occ)
    {
        try{

            $solicitante = DB::table('users as u')
                ->join('requisiciones_insumos as ri','u.id','=','ri.user_solicitante')
                ->join('ordenes_compras as oc','oc.requisicion_id','=','ri.id')
                ->select('u.nombre as nombreempleado','u.apellido as apellidoempleado')
                ->where('oc.id',$occ)
                ->first();

            return $solicitante;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //seleccionar el tipo de requisicion emitida por el id de la orden
    public function getTipoRequisicion($occ)
    {
        try{

            $solicitante = DB::table('tipos_requisiciones as tr')
                ->join('requisiciones_insumos as ri','ri.tipo_requisicion_id','=','tr.id')
                ->join('ordenes_compras as oc','oc.requisicion_id','=','ri.id')
                ->select('tr.nombre')
                ->where('oc.id',$occ)
                ->first();

            return $solicitante;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //obtener total de la orden de compra
    public function getTotal($idordencompra)
    {
        try{

            $total = DB::table('detalles_orden_compra as doc')
                ->select(DB::raw('sum(doc.cantidad) as total'))
                ->where('doc.orden_compra_id',$idordencompra)
                ->first();

            return $total;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
}