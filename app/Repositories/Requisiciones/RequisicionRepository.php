<?php
/**

 * User: Daniel Hernandez
 * Date: 01/12/2017
 * Time: 09:14 AM
 */

namespace App\Repositories\Requisiciones;

use DB;
use App\Requisicion;
use Session;

class RequisicionRepository
{

    //funcion para generar nuevo numero de requisicion
    public function generarIdRequisicion()
    {
        try{

            $ultimoid = DB::table('requisiciones_insumos')->latest('id')->first();


            $requisicion = $ultimoid->id+1;

            return $requisicion;

        }catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para guardar una requisicion
    public function saveRequisicion($requisicion)
    {
        try{

            $queryrun = $requisicion->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //mostrar requisiciones para administradr
    public function getRequisicionesByAdmin()
    {
        try{

            $requisiciones = DB::table('requisiciones_insumos as ri')
                            ->leftjoin('users as u1','u1.id','=','ri.user_solicitante')
                            ->leftjoin('estados_requisiciones as er','er.id','=','ri.estado_requisicion_id')
                            ->leftjoin('tipos_requisiciones as tr','tr.id','=','ri.tipo_requisicion_id')
                            ->leftjoin('centro_costos as c','c.id','=','u1.centro_costos_id')
                            ->select('er.nombre as estado',
                                    'u1.nombre as nombresolicitante',
                                    'u1.apellido as apellidosolicitante',
                                    'tr.nombre as tiporequisicion',
                                    'ri.*')
                            ->where('c.administrador',Session::get('idusuario'))
                            ->get();

            return $requisiciones;


        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //conteo de requisiciones nuevas
    public function conteoRequisicionesNuevas()
    {
        try{

            $conteo = DB::table('requisiciones_insumos')
                ->leftjoin('users as u1','u1.id','=','requisiciones_insumos.user_solicitante')
                ->leftjoin('centro_costos as c','c.id','=','u1.centro_costos_id')
                ->where('c.administrador',Session::get('idusuario'))
                ->where('estado_requisicion_id',2)->count();

            return $conteo;


        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para obtener una requisicion segun su id
    public function getRequisicionById($id)
    {
        try{

            $requisicion = DB::table('requisiciones_insumos as ri')
                ->leftjoin('users as u1','u1.id','=','ri.user_solicitante')
                ->leftjoin('users as u2','u2.id','=','ri.user_autorizante')
                ->leftjoin('estados_requisiciones as er','er.id','=','ri.estado_requisicion_id')
                ->leftjoin('tipos_requisiciones as tr','tr.id','=','ri.tipo_requisicion_id')
                ->select('er.nombre as estado',
                    'tr.nombre as tiporequisicion',
                    'u2.nombre as nombreautorizante',
                    'u2.apellido as apellidoautorizante',
                    'u1.nombre as nombresolicitante',
                    'u1.apellido as apellidosolicitante',
                    'ri.*')
                ->where('ri.id',$id)
                ->first();

            return $requisicion;


        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //busqueda de requisicion por ID ELOQUENT
    public function EloquentFindRequisicionById($id)
    {
        try{

            $requisicion = Requisicion::find($id);

            return $requisicion;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //actualizar una requisicion
    public function updateRequisicion($requisicion)
    {
        try{

            $queryrun = $requisicion->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para listar las requisiciones
    public function getRequisicionesBySupervisor($id)
    {
        try{

            $requisiciones = DB::table('requisiciones_insumos as ri')
                ->leftjoin('users as u1','u1.id','=','ri.user_autorizante')
                ->leftjoin('estados_requisiciones as er','er.id','=','ri.estado_requisicion_id')
                ->select('er.nombre as estado',
                    'u1.nombre as nombreautorizante',
                    'u1.apellido as apellidoautorizante',
                    'ri.*')
                ->where('ri.user_solicitante',$id)
                ->get();

            return $requisiciones;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }





}