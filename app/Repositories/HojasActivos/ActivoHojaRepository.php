<?php
/**

 * User: Daniel Hernandez
 * Date: 26/12/2017
 * Time: 10:10 PM
 */

namespace App\Repositories\HojasActivos;

use App\DetalleHojaActivo;
use DB;
use App\HojaActivos;


class ActivoHojaRepository
{
    //funcion para almacenar una hoja de activo
    public function saveHojaActivo($hojaactivo)
    {
        try{

            $queryrun = $hojaactivo->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //funcion para obtener la ultima hoja
    public function getLast()
    {
        try{

            $queryrun = DB::table('hojas_activos')->orderBy('id','desc')->first();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para obtener la ultima hoja de activo insertada en la db e imprimirla
    public function getLastHoja($occ)
    {
        try{

            $queryrun = DB::table('hojas_activos as h')
                                ->join('bodegas as b','b.id','=','h.bodega_id')
                                ->join('centro_costos as cc','cc.id','=','h.centro_costo_id')
                                ->join('electricistas as el','el.id','=','h.usuario_asignado')
                                ->join('agencias as a','a.id','=','h.agencia_id')
                                ->join('DEPSV as dep','dep.ID','=','h.departamento_id')
                                ->join('MUNSV as mun','mun.ID','=','h.municipio_id')
                                ->select('h.*','el.nombre as electricista',
                                    'mun.MunName as municipio','dep.DepName as departamento',
                                    'cc.nombre as centrocosto','b.codigo as bodega','a.nombre as agencia')
                                ->where('h.orden_compra_id',$occ)
                                ->first();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para guardar detalles
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



    //linea qb de la hoja de activo
    public function getLineaQBHojaActivo($hoja)
    {
        try{

            $queryrun = DB::table('detalles_hoja_activo')->where('hoja_activo_id',$hoja)->first();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //linea qb de la hoja de activo
    public function getLineaELOQUENTHojaActivo($id)
    {
        try{

            $queryrun = DetalleHojaActivo::find($id);

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para obtener la hoja de activo ELOQUENT
    public function getELOQUENTHojaActivo($id)
    {
        try{

            $queryrun = DB::table('hojas_activos as h')
                ->leftjoin('bodegas as b','b.id','=','h.bodega_id')
                ->join('centro_costos as cc','cc.id','=','h.centro_costo_id')
                ->join('electricistas as el','el.id','=','h.usuario_asignado')
                ->join('agencias as a','a.id','=','h.agencia_id')
                ->join('DEPSV as dep','dep.ID','=','h.sv_departamento_id')
                ->join('MUNSV as mun','mun.ID','=','h.sv_municipio_id')
                ->select('h.*','el.nombre as electricista',
                    'mun.MunName as municipio','dep.DepName as departamento',
                    'cc.nombre as centrocosto','b.codigo as bodega','a.nombre as agencia')
                ->where('h.id',$id)
                ->first();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
}