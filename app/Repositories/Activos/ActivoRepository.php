<?php
/**
 * Created by PhpStorm.
 * User: DHernandez
 * Date: 11/7/2018
 * Time: 08:54
 */

namespace App\Repositories\Activos;

use DB;
use Session;

class ActivoRepository
{

    //funcion para retonar los activos de un empleado segun su id
    public function getActivosByIdEmpleado($usuario)
    {
        try{

            $query = DB::table('emp_activos')
                    ->where('emp_activos.empleado',$usuario)
                    ->get();

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para listar los activos de todos los empleados para el supervisor
    public function getActivosAll()
    {
        try{

            $query = DB::table('emp_activos')
                ->leftjoin('users as u','u.id','=','emp_activos.empleado')
                ->leftjoin('bodegas as b','b.id','=','emp_activos.bodega_id')
                ->select('emp_activos.*','u.nombre','u.apellido','b.codigo as bodega')
                ->get();

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para listar los activos de todos los empleados de una jefatura con sesion activa
    public function getActivosAllByJefatura()
    {
        try{

            $query = DB::table('emp_activos')
                ->join('users as u','u.id','=','emp_activos.empleado')
                ->select('emp_activos.*','u.nombre','u.apellido')
                ->where('u.jefe_inmediato',Session::get('idusuario'))
                ->get();

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //buscar la linea del activo por el id de esa linea para editar
    public function findLineaActivoById($id)
    {
        try{

            $query = DB::table('emp_activos as activo')
                ->leftjoin('DEPSV as dep','dep.ID','=','activo.departamento_id')
                ->leftjoin('MUNSV as mun','mun.ID','=','activo.municipio')
                ->leftjoin('agencias as ag','ag.id','=','activo.agencia_id')
                ->leftjoin('users as u','u.id','=','activo.empleado')
                ->leftjoin('bodegas as b','b.id','=','activo.bodega_id')
                ->leftjoin('centro_costos as cc','cc.id','=','activo.centro_costo')
                ->select('activo.*','u.nombre','u.apellido','cc.nombre as centrocosto','ag.nombre as agencia','dep.DepName as departamento','mun.MunName as municipio','b.codigo as bodega','b.id as bodega_id')
                ->where('activo.id',$id)
                ->first();

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //obtener los insumos desde la base de datos
    public function getActivos()
    {
        try{

            $activos = DB::table('activos')->get();

            return $activos;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //listar los traslados segun emisor de traslado
    public function getTrasladosEmisor($usuario)
    {
        try{

            $traslados = DB::table('act_traslados as tr')
                            ->join('emp_activos as em_a','em_a.id','=','tr.emp_activo_id')
                            ->join('DEPSV as dep','dep.ID','=','tr.departamento_destino')
                            ->join('MUNSV as mun','mun.ID','=','tr.municipio_destino')
                            ->join('agencias as ag','ag.id','=','tr.agencia_destino')
                            ->join('users as u','u.id','=','tr.usuario_destino')
                            ->join('users as u1','u1.id','=','tr.usuario_emisor')
                            ->join('centro_costos as cc','cc.id','=','tr.centro_costo_destino')
                            ->join('act_estados_traslados as et','et.id','=','tr.estado_traslado')
                            ->select('em_a.*','tr.*','cc.nombre as centrocosto','em_a.tipo_activo as activo','dep.DepName as departamento','mun.MunName as municipio',
                                'ag.nombre as agencia','et.nombre as estado','u.nombre as nombredestino','u.apellido as apellidodestino','u1.nombre as nombreemisor','u1.apellido as apellidoemisor')
                            ->where('tr.usuario_emisor',$usuario)
                            ->get();


            return $traslados;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para listar los traslados de los usuarios como receptores
    public function getTrasladosReceptor($usuario)
    {
        try{

            $traslados = DB::table('act_traslados as tr')
                ->join('emp_activos as em_a','em_a.id','=','tr.emp_activo_id')
                ->join('DEPSV as dep','dep.ID','=','tr.departamento_destino')
                ->join('MUNSV as mun','mun.ID','=','tr.municipio_destino')
                ->join('agencias as ag','ag.id','=','tr.agencia_destino')
                ->join('users as u','u.id','=','tr.usuario_destino')
                ->join('users as u1','u1.id','=','tr.usuario_emisor')
                ->join('centro_costos as cc','cc.id','=','tr.centro_costo_destino')
                ->select('em_a.*','tr.*','cc.nombre as centrocosto','em_a.tipo_activo as activo','dep.DepName as departamento','mun.MunName as municipio',
                    'ag.nombre as agencia','u.nombre as nombredestino','u.apellido as apellidodestino','u1.nombre as nombreemisor','u1.apellido as apellidoemisor')
                ->where('tr.usuario_destino',$usuario)
                ->get();


            return $traslados;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //obtener un traslado por su id
    public function getTrasladoById($id)
    {
        try{

            $traslado = DB::table('act_traslados as tr')
                ->join('emp_activos as em_a','em_a.id','=','tr.emp_activo_id')
                ->join('DEPSV as dep','dep.ID','=','tr.departamento_destino')
                ->join('MUNSV as mun','mun.ID','=','tr.municipio_destino')
                ->join('agencias as ag','ag.id','=','tr.agencia_destino')
                ->join('users as u','u.id','=','tr.usuario_destino')
                ->join('users as u1','u1.id','=','tr.usuario_emisor')
                ->join('centro_costos as cc','cc.id','=','tr.centro_costo_destino')
                ->select('em_a.*','tr.*','cc.nombre as centrocosto','em_a.tipo_activo as activo','dep.DepName as departamento','mun.MunName as municipio',
                    'ag.nombre as agencia','u.nombre as nombredestino','u.apellido as apellidodestino','u1.nombre as nombreemisor','u1.apellido as apellidoemisor')
                ->where('tr.id',$id)
                ->first();


            return $traslado;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //activo por su id
    public function getActivoById($activo)
    {
        try{

            $activo = DB::table('emp_activos as activo')
                ->leftjoin('DEPSV as dep','dep.ID','=','activo.departamento_id')
                ->leftjoin('MUNSV as mun','mun.ID','=','activo.municipio')
                ->leftjoin('agencias as ag','ag.id','=','activo.agencia_id')
                ->leftjoin('users as u','u.id','=','activo.empleado')
                ->leftjoin('bodegas as b','b.id','=','activo.bodega_id')
                ->leftjoin('centro_costos as cc','cc.id','=','activo.centro_costo')
                ->select('activo.*','u.nombre','u.apellido','cc.nombre as centrocosto','ag.nombre as agencia','dep.DepName as departamento','mun.MunName as municipio','b.codigo as bodega','b.id as bodega_id')
                ->where('activo.id',$activo)
                ->first();

            return $activo;

        }catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para listar todos los activos contenidos en un centro de costo en especifico
    public function getActivosByCC($centrocosto)
    {
        try{

            $query = DB::table('emp_activos')
                ->leftjoin('users as u','u.id','=','emp_activos.empleado')
                ->select('emp_activos.*','u.nombre','u.apellido')
                ->where('emp_activos.centro_costo',$centrocosto)
                ->where('emp_activos.categoria_activo',4)
                ->get();

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //obtejer un registro de baja para poder imprimir la hoja correspondiente y solicitar las firmas para que contabilidad finalize el proceso
    public function getBajaByActivo($activo)
    {
        try{

            $query = DB::table('act_bajas_activos as b')
                            ->leftjoin('motivos_bajas as mb','mb.id','=','b.tipo_baja')
                            ->leftjoin('emp_activos as ea','ea.id','=','b.activo')
                            ->leftjoin('MUNSV as m','m.ID','=','ea.municipio')
                            ->leftjoin('bodegas as bodega','bodega.id','=','ea.bodega_id')
                            ->leftjoin('estado_hoja_activo as eh','eh.id','=','ea.estado_activo')
                            ->leftjoin('DEPSV as d','d.ID','=','ea.departamento_id')
                            ->leftjoin('centro_costos as cc','cc.id','=','ea.centro_costo')
                            ->leftjoin('users as u','u.id','=','ea.empleado')
                            ->leftjoin('agencias as a','a.id','=','ea.agencia_id')
                            ->select('eh.nombre as estadoactivo','bodega.codigo as bodega','mb.nombre as motivobaja','b.justificacion as justificacionbaja','ea.*','cc.nombre as centrocosto','d.DepName as departamento','m.MunName as municipio','a.nombre as agencia','mb.nombre as motivo','u.nombre','u.apellido')
                            ->where('b.activo',$activo)
                            ->first();

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para listar los activos que se encuentran en proceso de baja
    public function getActivosProcesoBaja()
    {
        try{

            $query = DB::table('act_bajas_activos as b')
                ->leftjoin('motivos_bajas as mb','mb.id','=','b.tipo_baja')
                ->leftjoin('emp_activos as ea','ea.id','=','b.activo')
                ->leftjoin('MUNSV as m','m.ID','=','ea.municipio')
                ->leftjoin('DEPSV as d','d.ID','=','ea.departamento_id')
                ->leftjoin('centro_costos as cc','cc.id','=','ea.centro_costo')
                ->leftjoin('users as u','u.id','=','ea.empleado')
                ->leftjoin('bodegas as bodega','bodega.id','=','ea.bodega_id')
                ->leftjoin('agencias as a','a.id','=','ea.agencia_id')
                ->select('bodega.codigo as bodega','b.id as idbaja','b.justificacion as justificacionbaja','ea.*','cc.nombre as centrocosto','d.DepName as departamento','m.MunName as municipio','a.nombre as agencia','mb.nombre as motivo','u.nombre','u.apellido')
                ->where('b.estado',1)
                ->get();

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //listar herramientas para las bodegas virtuales y sus supervisores
    public function getActivosForBodegas($usuario)
    {
        try{

            $query = DB::table('emp_activos as e')
                        ->leftjoin('bodegas as b','b.id','=','e.bodega_id')
                        ->leftjoin('users as u','u.id','=','b.supervisor')
                        ->leftjoin('users as u2','u2.id','=','e.empleado')
                        ->select('e.*','u2.nombre as nombreasignado','u2.apellido as apellidoasignado','b.codigo as bodega')
                        ->where('b.supervisor',$usuario)
                        ->get();

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



}