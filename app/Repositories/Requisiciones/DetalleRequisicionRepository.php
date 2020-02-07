<?php
/**

 * User: Daniel Hernandez
 * Date: 06/12/2017
 * Time: 04:39 PM
 */

namespace App\Repositories\Requisiciones;

use DB;


class DetalleRequisicionRepository
{
    //funcion para agregar los detalles de una requisicion
    public function saveDetalle($detalles)
    {
        try{

            $queryrun = $detalles->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para obtener los detalles de las requisiciones segun id de requisicion
    public function detallesByIdRequisicion($id)
    {
        try{

           $insumoslist = DB::table('insumos')
                        ->join('requisicion_detalles as rd','rd.insumo_id','=','insumos.id')
                        ->join('requisiciones_insumos as ri','ri.id','=','rd.requisicion_id')
                        ->select('insumos.nombre as insumo','rd.cantidad as cantidad','insumos.id as codinsumo','rd.precio as precio','rd.ins_descripcion as ins_descripcion')
                        ->where('ri.id',$id)
                        ->get();

           return $insumoslist;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para obtener el total de insumos dentro de un detalle de requisicion
    public function getTotalInsumosForRequisicion($requisicion)
    {
        try{

            $total = DB::table('requisicion_detalles as rd')->select(DB::raw('sum(rd.cantidad) as total'))
                            ->where('rd.requisicion_id',$requisicion)->first();

            return $total;

        }catch(\Exception $e)
        {

        }
    }



}