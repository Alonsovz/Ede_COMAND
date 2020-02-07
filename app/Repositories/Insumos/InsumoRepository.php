<?php
/**

 * User: Daniel Hernandez
 * Date: 01/12/2017
 * Time: 09:15 AM
 */



namespace App\Repositories\Insumos;
use App\Insumo;
use DB;

class InsumoRepository
{
    //obtener los insumos almacenados en la base de datos
    public function getInsumosAll()
    {
        try{

            $insumos = DB::table('insumos as i')
                ->leftjoin('insumos_categorias as ic','ic.id','=','i.categoria_insumo_id')
                ->leftjoin('ins_unidades_medida as ium','i.unidad_medida_id','=','ium.id')
                ->select('i.*','ic.nombre as categoria','ium.nombre as um')
                ->get();

            return $insumos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //obtener insumo por nombre
    public function getInsumoByNombre($nombre)
    {
        try{

            $insumo = DB::table('insumos as i')
                ->leftjoin('insumos_categorias as ic','ic.id','=','i.categoria_insumo_id')
                ->leftjoin('ins_unidades_medida as ium','i.unidad_medida_id','=','ium.id')
                ->select('i.*','ic.nombre as categoria','ium.nombre as um')
                ->where('i.nombre',$nombre)
                ->get();

            return $insumo;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //funcion para obtener los insumos de la categoria papeleria
    public function getInsumosForPapeleria()
    {
        try{

            $insumos = DB::table('insumos')->where('categoria_insumo_id',1)->get();

            return $insumos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //funcion para obtener los insumos de la categoria papeleria
    public function getInsumosByOficina()
    {
        try{

            $insumos = DB::table('insumos')->where('categoria_insumo_id',4)->get();

            return $insumos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //funcion para obtener los insumos de la categoria papeleria
    public function getInsumosByHerramienta()
    {
        try{

            $insumos = DB::table('insumos')->where('categoria_insumo_id',2)->get();

            return $insumos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para obtener los insumos de la categoria papeleria
    public function getInsumosByLimpieza()
    {
        try{

            $insumos = DB::table('insumos')->where('categoria_insumo_id',3)->get();

            return $insumos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }




    //busqueda de id de insumo por nombre
    public function findIdByname($nombre)
    {
        try{

            $insumos = DB::table('insumos')->where('nombre',$nombre)->first();

            return $insumos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para guardar un insumo
    public function saveInsumo($insumo)
    {
        try{

            $queryrun = $insumo->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }




    //funcion para lanzar el reporte de la disponibilidad de insumos de papeleria
    public function movimientoPapeleria($cc,$desde,$hasta)
    {
        try{

            $queryrun =
                DB::select("
                        
              SELECT i.id as codigo, i.nombre as insumo,
                        SUM(CASE when m.fecha_movimiento< ? THEN m.cantidad_movimiento ELSE 0 END) as cant_ini,
                        SUM(CASE WHEN m.cantidad_movimiento>0 and m.fecha_movimiento between ? and ? THEN m.cantidad_movimiento ELSE 0  END) as cant_adquirida,
                        SUM(CASE WHEN m.cantidad_movimiento<0 and m.fecha_movimiento between ? and ? THEN m.cantidad_movimiento ELSE 0  END)*-1 as cant_consumida
                        FROM insumos i
                        INNER JOIN movimientos_insumos m ON  i.id = m.insumo_id
                        WHERE m.centro_costos_id = ? and i.categoria_insumo_id = 1
                        GROUP BY i.id,i.nombre
                        order by i.id asc",[$desde,$desde,$hasta,$desde,$hasta,$cc]);

            return $queryrun;

        }catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para listar las cantidades iniciales de los movimientos de papeleria
    public function cantInicialPape($cc,$desde)
    {

        try{

            $query = DB::select('select i.id as cod,sum(m.cantidad_movimiento) as cant_inicial
                        from movimientos_insumos m
                        inner join insumos i on i.id = m.insumo_id
                        where m.centro_costos_id=? and m.fecha_movimiento<?
                        and i.categoria_insumo_id=1
                        group by i.nombre,i.id
                        order by i.id asc',[$cc,$desde]);

            return $query;

        }catch(\Exception $e)
        {

        }
    }



    public function movimientoLimpieza($cc,$desde,$hasta)
    {
        try{

            $queryrun =
                DB::select("
                        SELECT i.id as codigo, i.nombre as insumo,
                        SUM(CASE when m.fecha_movimiento< ? THEN m.cantidad_movimiento ELSE 0 END) as cant_ini,
                        SUM(CASE WHEN m.cantidad_movimiento>0 and m.fecha_movimiento between ? and ? THEN m.cantidad_movimiento ELSE 0  END) as cant_adquirida,
                        SUM(CASE WHEN m.cantidad_movimiento<0 and m.fecha_movimiento between ? and ? THEN m.cantidad_movimiento ELSE 0  END)*-1 as cant_consumida
                        FROM insumos i
                        INNER JOIN movimientos_insumos m ON  i.id = m.insumo_id
                        WHERE m.centro_costos_id = ? and i.categoria_insumo_id = 3
                        GROUP BY i.id,i.nombre
                        order by i.id asc",[$desde,$desde,$hasta,$desde,$hasta,$cc]);

            return $queryrun;

        }catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para listar la existencia de las herramientas por bodega
    public function dispoHerramientas($bodega)
    {
        try{

            $query = DB::select("
                                select i.nombre as insumo, i.id as codigo, c.existencia as existencia,e.nombre as estado from insumos i
                                inner join [insumos-centro_costos] c ON i.id = c.id_insumos
                                inner join estados_insumos e ON c.estado_insumo = e.id
                                inner join insumos_categorias ca ON i.categoria_insumo_id = ca.id
                                where c.bodega_id = ?
                     ",[$bodega]);

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para listar las cantidades iniciales de los movimientos de papeleria
    public function cant_InicialLimpieza($cc,$desde)
    {
        try{

            $query = DB::select('select i.id as cod,sum(m.cantidad_movimiento) as cant_inicial
                        from movimientos_insumos m
                        inner join insumos i on i.id = m.insumo_id
                        where m.centro_costos_id=? and m.fecha_movimiento<?
                        and i.categoria_insumo_id=3
                        group by i.nombre,i.id
                        order by i.id desc',[$cc,$desde]);

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para listar los precios de las cantidades iniciales
    public function precios_cant_ini($cc,$desde)
    {
        try{

            $query = DB::select('SELECT i.id AS codigo, do.cantidad as cantidad, AVG(do.preciocompra) AS precio FROM detalles_orden_compra do
                    INNER JOIN ordenes_compras o ON do.orden_compra_id = o.id
                    INNER JOIN requisiciones_insumos ri ON ri.id = o.requisicion_id
                    INNER JOIN users u ON u.id = ri.user_solicitante
                    INNER JOIN insumos i ON i.id = do.insumo_id
                    WHERE  o.fecha_creacion < ? AND u.centro_costos_id=?
                    GROUP BY i.id,do.cantidad',[$desde,$cc]);

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //funcion para listar los precios de las cantidades iniciales
    public function precios_cant_adquirida($cc,$desde,$hasta)
    {
        try{

            $query = DB::select('SELECT i.id AS codigo,  AVG(do.preciocompra) AS precio FROM detalles_orden_compra do
                        INNER JOIN ordenes_compras o ON do.orden_compra_id = o.id
                        INNER JOIN requisiciones_insumos ri ON ri.id = o.requisicion_id
                        INNER JOIN users u ON u.id = ri.user_solicitante
                        INNER JOIN insumos i ON i.id = do.insumo_id
                        WHERE  o.fecha_creacion BETWEEN ? AND ? AND u.centro_costos_id=? AND i.categoria_insumo_id=3
                        GROUP BY i.id',[$desde,$hasta,$cc]);

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //buscar insumo por ELOQUENT
    public function findInsumoQUERYBUILDER($id)
    {
        try{

            $query = DB::table('insumos as i')
                ->leftjoin('insumos_categorias as ic','ic.id','=','i.categoria_insumo_id')
                ->leftjoin('ins_unidades_medida as ium','i.unidad_medida_id','=','ium.id')
                ->select('i.*','ic.nombre as categoria','ium.nombre as um','i.activo as activo')
                ->where('i.id',$id)
                ->get();

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //obtener insumo por id
    public function getInsumoPorID($id)
    {
        try{

            $query = DB::table('insumos as i')
                ->leftjoin('insumos_categorias as ic','ic.id','=','i.categoria_insumo_id')
                ->leftjoin('ins_unidades_medida as ium','i.unidad_medida_id','=','ium.id')
                ->select('i.*','ic.nombre as categoria','ium.nombre as um','i.activo as activo')
                ->where('i.id',$id)
                ->first();

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para obtener el historico de movimientos de un insumo dentro de su cc
    public function getHistoricoInsumoMovimientos($insumo,$fecha1,$fecha2)
    {
        try{



        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //metodo para obtener las bajas de activo segun bodega
    public function getBajasPorBodega($bodega)
    {
        try{

            $baja = DB::table('hojas_activos as ha')
                ->join('detalles_hoja_activo as dha','dha.hoja_activo_id','=','ha.id')
                ->join('insumos as i','i.id','=','dha.insumo_id')
                ->join('estado_hoja_activo as eha','eha.id','=','ha.estado')
                ->join('electricistas as el','el.id','=','ha.usuario_asignado')
                ->join('estados_insumos as ei','ei.id','=','dha.estado_insumo_id')
                ->select('i.nombre as insumo','i.id as codigo','dha.*','ha.*','el.nombre as electricista','ei.nombre as estado_activo','eha.nombre as estadoha')
                ->where('ha.bodega_id',$bodega)
                ->get();

            return $baja;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para listar los consumos de un insumo en un rango de fechas
    public function listarConsumosInsumo_supervCC($desde,$hasta,$insumo,$cc)
    {
        try{

            $consumos = DB::table('movimientos_insumos as mi')
                        ->join('insumos as i','i.id','=','mi.insumo_id')
                        ->join('users as u','u.id','=','mi.usuario_asignado')
                        ->select('mi.*','u.nombre as nombreasignado','u.apellido as apellidoasignado','i.nombre as insumo')
                        ->whereBetween('mi.fecha_movimiento',[$desde,$hasta])
                        ->where('mi.insumo_id',$insumo)
                        ->where('mi.centro_costos_id',$cc)
                        ->get();

            return $consumos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //listar consumos de papeleria histocia con la columna de cc
    public function listarConsumosHistoricosXcc($desde,$hasta)
    {
        try{

            $consumos = DB::table('movimientos_insumos as mi')
                ->join('insumos as i','i.id','=','mi.insumo_id')
                ->join('users as u','u.id','=','mi.usuario_asignado')
                ->leftjoin('centro_costos as cc','cc.id','u.centro_costos_id')
                ->select('mi.*','u.nombre as nombreasignado','u.apellido as apellidoasignado','u.centro_costos_id as cc','cc.nombre as centrocosto','i.nombre as insumo')
                ->where('i.categoria_insumo_id',1)
                ->whereBetween('mi.fecha_movimiento',[$desde,$hasta])
                ->get();

            return $consumos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }




}