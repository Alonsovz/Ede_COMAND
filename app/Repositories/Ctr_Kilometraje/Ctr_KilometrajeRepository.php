<?php


namespace App\Repositories\Ctr_Kilometraje;

use DB;


class Ctr_KilometrajeRepository
{


    //metodo para listar los kilometrajes
    public function getKilometrajesAll()
    {
        try{

            $kilometrajes = DB::table('vh_ctr_kilometraje as k')
                ->leftjoin('vh_vehiculos as vh','k.vh_vehiculo_id','=','vh.id')
                ->leftjoin('vh_reservas as reserva','reserva.id','=','k.vh_reserva_id')
                ->leftjoin('users as u','u.id','=','k.empleado')
                ->select('k.*','reserva.id as reserva','vh.numeracion as vehiculo','u.nombre as nombreempleado','u.apellido as apellidoempleado')
                ->get();

            return $kilometrajes;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para listar las reservas que son de mas de 2 dias
    public function getRegistrosReservasMayoresDosDias()
    {
        try{

            $query = DB::select('SELECT k.id, k.horario_inicio, k.horario_fin,k.km_inicial,k.km_final,k.galones_cargados,k.costo_cargado,k.num_recibo,
                        k.vh_vehiculo_id,k.fecha_creacion,k.vh_reserva_id,k.empleado,k.trabajo_realizado,u.nombre,u.apellido,v.numeracion as vehiculo,
                        r.id as reserva
                        
                        FROM vh_ctr_kilometraje k
                        
                        LEFT JOIN users u ON k.empleado = u.id
                        LEFT JOIN vh_vehiculos v ON v.id = k.vh_vehiculo_id
                        LEFT JOIN vh_reservas r ON k.vh_reserva_id = r.id
                          
                        
                        WHERE DATEDIFF(DAY, k.horario_inicio, k.horario_fin) >= 1');


            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para el reporte del resumen por empleado de los kilometrajes
    public function getResumenXEmpleado($desde,$hasta)
    {
        try{

            $query = DB::select('
                SELECT u.nombre + ISNULL(\' \'+u.apellido,\'\') as Empleado,SUM(km.km_final-km.km_inicial) as km_recorridos,
                SUM(km.galones_cargados) as galones_cargados,SUM(km.costo_cargado) as costo_cargado,
                SUM(DATEDIFF(HOUR,km.horario_inicio,km.horario_fin)) as horas_uso
                FROM vh_ctr_kilometraje km
                INNER JOIN users u ON km.empleado = u.id
                WHERE km.horario_inicio BETWEEN ? AND ?
                GROUP BY u.nombre + ISNULL(\' \'+u.apellido,\'\')        
                ',[$desde,$hasta]);


            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //listar detalles de kilometraje ingresado por su id
    public function getKilometrajeByID($kilometraje)
    {
        try{

            $kilometraje = DB::table('vh_ctr_kilometraje as k')
                ->leftjoin('vh_vehiculos as vh','k.vh_vehiculo_id','=','vh.id')
                ->leftjoin('vh_reservas as reserva','reserva.id','=','k.vh_reserva_id')
                ->leftjoin('users as u','u.id','=','k.empleado')
                ->select('k.*','reserva.id as reserva','vh.numeracion as vehiculo','u.nombre as nombreempleado','u.apellido as apellidoempleado')
                ->where('k.id',$kilometraje)
                ->first();

                return $kilometraje;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para buscar el ultimo kilometraje de un vehiculo
    public function getLastKilometrajeForVH($vehiculo)
    {
        try{

            $kilometraje = DB::table('vh_ctr_kilometraje')->select('km_final','horario_fin')->where('vh_vehiculo_id',$vehiculo)->OrderBy('id','desc')->first();

            return $kilometraje;

        }catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //listar el resumen por vehiculo del kilometraje
    public function getResumenPorVehiculoKM($desde,$hasta)
    {
        try{

            $query = DB::select('SELECT v.numeracion as Equipo,v.placa as Placa,SUM(km.galones_cargados) as Galones_cargados,SUM(costo_cargado) as Cost_cargado,
                      SUM(km.km_final-km.km_inicial) as Km_recorridos
                                FROM vh_vehiculos v
                                INNER JOIN vh_ctr_kilometraje km on km.vh_vehiculo_id = v.id
                                WHERE km.horario_inicio BETWEEN ? AND ?
                                GROUP BY v.numeracion, v.placa',[$desde,$hasta]);

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //funcion para listar los km ingresados dada una fecha desde y hasta
    public function kmIngresadosByFecha($desde,$hasta)
    {
        try{

            $query = DB::table('vh_ctr_kilometraje as k')
                ->join('vh_vehiculos as vh','k.vh_vehiculo_id','=','vh.id')
                ->join('vh_reservas as reserva','reserva.id','=','k.vh_reserva_id')
                ->join('users as u','u.id','=','k.empleado')
                ->select('k.*','reserva.id as reserva','vh.numeracion as vehiculo','u.nombre as nombreempleado','u.apellido as apellidoempleado')
                ->where('k.fecha_creacion','>=',$desde)
                ->where('k.fecha_creacion','<=',$hasta)
                ->get();

            $query1 = DB::select('SELECT k.horario_inicio,k.horario_fin,k.galones_cargados,k.costo_cargado,k.num_recibo, k.fecha_creacion,k.id, vr.id AS reserva, v.numeracion AS vehiculo,k.trabajo_realizado,u.nombre AS nombreempleado,u.apellido AS apellidoempleado,
                                  k.km_inicial,k.km_final,vr.id FROM vh_ctr_kilometraje k
                         INNER JOIN users u ON k.empleado = u.id
                         INNER JOIN vh_vehiculos v ON k.vh_vehiculo_id = v.id
                         LEFT JOIN vh_reservas vr ON k.vh_reserva_id = vr.id
                        WHERE k.fecha_creacion >= ? AND k.fecha_creacion <= ?',[$desde,$hasta]);

            return $query1;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //listar los km recorridos galones y costos cargados para los vehiculos de los dueños
    public function getCostosKMGalonesForDuenos($desde,$hasta,$dueno)
    {
        try{

            $queryrun = DB::select('SELECT v.numeracion as Equipo,v.placa as Placa,SUM(km.galones_cargados) as Galones_cargados,SUM(costo_cargado) as Cost_cargado,
                      SUM(km.km_final-km.km_inicial) as Km_recorridos
                                FROM vh_vehiculos v
                                INNER JOIN vh_ctr_kilometraje km on km.vh_vehiculo_id = v.id
                                INNER JOIN vehiculos_dueños as vhd on vhd.vh_vehiculo_id = km.vh_vehiculo_id
                                WHERE vhd.user_id = ? AND km.horario_inicio BETWEEN ? AND ?
                                GROUP BY v.numeracion, v.placa',[$dueno,$desde,$hasta]);

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



}