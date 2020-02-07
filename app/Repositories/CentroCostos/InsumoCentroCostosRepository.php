<?php
/**

 * User: Daniel Hernandez
 * Date: 15/12/2017
 * Time: 12:53 AM
 */

namespace App\Repositories\CentroCostos;
use App\InsumoCentroCostos;
use DB;



class InsumoCentroCostosRepository
{
    //funcion para realizar la carga de insumos en el centro de costos respectivo
    public function saveInsumosCentroCostos($objeto)
    {
        try{

            $queryrun = $objeto->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }








    //funcion para obtener la existencia de un producto
    public function getExistencia($idinsumo,$idcc)
    {
        try{

            $queryrun = DB::table('insumos as ins')
                ->join('insumos-centro_costos as icc','icc.id_insumos','=','ins.id')
                ->select(DB::raw('sum(icc.existencia) as existencia'))
                ->where('icc.id_centro_costos',$idcc)
                ->where('icc.id_insumos',$idinsumo)
                ->groupBy('ins.id')
                ->first();


            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //actualizar existencia del insumo
    public function updateExistencia($linea)
    {
        try{

           $queryrun = $linea->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //buscar linea de centro de costo
    public function findLineaCC($id)
    {
        try{

            $queryrun = InsumoCentroCostos::find($id);

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para buscar una linea por medio del producto
    public function findLineaCCByInsumo($idinsumo,$cc)
    {
        try{

            $queryrun = DB::table('insumos-centro_costos')->where('id_insumos',$idinsumo)->where('id_centro_costos',$cc)->first();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //funcion para buscar una linea por medio del producto
    public function findLineaCCByBodega($idinsumo,$bodega)
    {
        try{

            $queryrun = DB::table('insumos-centro_costos')->where('id_insumos',$idinsumo)->where('bodega_id',$bodega)->first();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


}