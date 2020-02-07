<?php

namespace App\Repositories\VH_Reservas;
use Faker\Provider\DateTime;
use Illuminate\Support\Facades\DB;
use App\VH_Reserva;

/**
 * .
 * User: Daniel Hernandez
 * Date: 02/10/2017
 * Time: 10:13 AM
 */
class vh_ReservaRepository
{



    //funcion para guardar una reserva
    public function saveReserva($reserva)
    {
        try{

            $queryrun = $reserva->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

  //funcion para obtener todos los estados ingresados en el sistema
    public function getReservasForCalendario()
    {
    
        try{
            $reservas = DB::table('vh_reservas')
                ->join('vh_vehiculos as vh','vh.id','=','vh_reservas.vh_vehiculo_id')
                ->select(
                        'vh_reservas.id as id',
                        'vh_reservas.empleado as empleado',
                        'vh.numeracion as title',
                        'vh_reservas.fechainicio as start',
                        'vh_reservas.fechafin as end'
                        )
                ->where('vh_reservas.vh_estado_id',3)
                ->orWhere('vh_reservas.vh_estado_id',1)
                ->orWhere('vh_reservas.vh_estado_id',4)
                ->get();

            return $reservas;

        }catch(\Exception $e){

            return $e;
        }
    }



    //funcion para poder listar una reserva por medio de su ID
    public function getReservaByIDGet($id)
    {
        try{

            $reserva = DB::table('vh_reservas')
                ->join('vh_vehiculos','vh_reservas.vh_vehiculo_id','=','vh_vehiculos.id')
                ->join('vh_estados','vh_reservas.vh_estado_id','=','vh_estados.id')
                ->join('users','vh_reservas.jefe_inmediato','=','users.id')
                ->select('vh_reservas.*',
                    'vh_estados.estado as estadoreserva',
                    'vh_vehiculos.numeracion as vehiculo',
                    'vh_vehiculos.placa as placa',
                    'users.nombre as nombrejefe',
                    'users.apellido as apellidojefe')
                ->where('vh_reservas.id',$id)
                ->get();

            return $reserva;

        }catch(\Exception $e){

            return $e;
        }
    }



    //funcion para obtener las reservas segun el empleado logueado
    public function getReservasByEmpleado($idempleado)
    {
        try{

            $reservas = DB::table('vh_reservas')
                                ->join('vh_vehiculos','vh_reservas.vh_vehiculo_id','=','vh_vehiculos.id')
                                ->join('vh_estados','vh_reservas.vh_estado_id','=','vh_estados.id')
                                ->join('users','vh_reservas.jefe_inmediato','=','users.id')
                                ->select('vh_reservas.*',
                                'vh_estados.estado as estadoreserva',
                                'vh_vehiculos.numeracion as vehiculo',
                                'vh_vehiculos.placa as placa',
                                'users.nombre as nombrejefe',
                                'users.apellido as apellidojefe')
                                ->where('vh_reservas.user_id',$idempleado)
                                ->get();



            return $reservas;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para obtener una reserva por medio de su id
    public function getReservaById($id)
    {
        try{

            $reservas = DB::table('vh_reservas')
                ->join('vh_vehiculos','vh_reservas.vh_vehiculo_id','=','vh_vehiculos.id')
                ->join('vh_estados','vh_reservas.vh_estado_id','=','vh_estados.id')
                ->join('departamentos','vh_reservas.departamento_id','=','departamentos.id')
                ->join('users','vh_reservas.jefe_inmediato','=','users.id')
                ->join('users as users1','vh_reservas.conductor','=','users1.id')
                ->select('vh_reservas.*',
                    'vh_estados.estado as estadoreserva',
                    'vh_vehiculos.numeracion as vehiculo',
                    'vh_vehiculos.id as idvehiculo',
                    'vh_vehiculos.placa as placa',
                    'departamentos.nombre as departamento',
                    'departamentos.id as iddepartamento',
                    'users.nombre as nombrejefe',
                    'users1.nombre as nombreconductor',
                    'users1.apellido as apellidoconductor',
                    'users.apellido as apellidojefe')->where('vh_reservas.id',$id)->get();



            return $reservas;
        }catch(\Exception $e)
        {

        }
    }




    //funcion para actualizar una reserva
    public function updateReserva($reserva)
    {
        try{

            $queryrun = $reserva->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //metodo para obtener una reserva para el metodo UPDATE
    public function getReservaFirst($id)
    {
        try{

            $reserva = VH_Reserva::find($id);

            return $reserva;

        }catch(\Exception $e)
        {

        }
    }





    //obtener reservas sin restriccion para la vista del administrador de las reservas
    public function getReservasByAdmin()
    {
        try{

            $reservas = DB::table('vh_reservas')
                ->join('vh_vehiculos','vh_reservas.vh_vehiculo_id','=','vh_vehiculos.id')
                ->join('vh_estados','vh_reservas.vh_estado_id','=','vh_estados.id')
                ->join('users','vh_reservas.jefe_inmediato','=','users.id')
                ->select('vh_reservas.*',
                    'vh_estados.estado as estadoreserva',
                    'vh_vehiculos.numeracion as vehiculo',
                    'vh_vehiculos.placa as placa',
                    'users.nombre as nombrejefe',
                    'users.apellido as apellidojefe')
                ->get();

            return $reservas;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //conteo de reservas
    public function conteoReservas()
    {
        try{

            $conteo = DB::table('vh_reservas')->where('vh_estado_id',1)->count();

            return $conteo;

        }catch(\Exception $e){

        }
    }


    //ultima reserva ingresada
    public function getReservaLast()
    {
        try{

           $reserva = DB::table('vh_reservas')
               ->join('vh_vehiculos','vh_reservas.vh_vehiculo_id','=','vh_vehiculos.id')
               ->join('vh_estados','vh_reservas.vh_estado_id','=','vh_estados.id')
               ->join('users','vh_reservas.jefe_inmediato','=','users.id')
               ->select('vh_reservas.*',
                   'vh_estados.estado as estadoreserva',
                   'vh_vehiculos.numeracion as vehiculo',
                   'vh_vehiculos.placa as placa',
                   'users.nombre as nombrejefe',
                   'users.correo as correojefe',
                   'users.apellido as apellidojefe')
               ->orderBy('vh_reservas.id','desc')
               ->first();

            return $reserva;

        }catch(\Exception $e){

        }
    }


    //funcion para eloquent find by id
    public function findById($id)
    {
        try{

            $reserva = VH_Reserva::find($id);

            return $reserva;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //listar las reservas para que las jefaturas puedan aprobar
    public function getReservasByJefatura($jefatura)
    {
        try{

            $reservas = DB::table('vh_reservas')
                ->join('vh_vehiculos','vh_reservas.vh_vehiculo_id','=','vh_vehiculos.id')
                ->join('vh_estados','vh_reservas.vh_estado_id','=','vh_estados.id')
                ->join('users','vh_reservas.jefe_inmediato','=','users.id')
                ->join('users as users1','vh_reservas.conductor','=','users1.id')
                ->select('vh_reservas.*',
                    'vh_estados.estado as estadoreserva',
                    'vh_vehiculos.numeracion as vehiculo',
                    'vh_vehiculos.placa as placa',
                    'users.nombre as nombrejefe',
                    'users1.nombre as nombreconductor',
                    'users1.apellido as apellidoconductor',
                    'users.apellido as apellidojefe')
                ->where('vh_reservas.jefe_inmediato',$jefatura)
                ->get();

            return $reservas;

        }catch(\Exception $e)
        {

        }
    }

    //funcion para obtener una reserva por medio de su id
    public function getReservaByIdFirst($id)
    {
        try{

            $reservas = DB::table('vehiculos_dueños')
                ->leftjoin('vh_reservas','vh_reservas.vh_vehiculo_id','=','vehiculos_dueños.vh_vehiculo_id')
                ->leftjoin('vh_vehiculos','vh_reservas.vh_vehiculo_id','=','vh_vehiculos.id')
                ->leftjoin('vh_estados','vh_reservas.vh_estado_id','=','vh_estados.id')
                ->leftjoin('departamentos','vh_reservas.departamento_id','=','departamentos.id')
                ->leftjoin('users','vh_reservas.jefe_inmediato','=','users.id')
                ->leftjoin('users as u2','u2.id','=','vh_reservas.user_id')
                ->leftjoin('users as u1','u1.id','=','vehiculos_dueños.user_id')
                ->leftjoin('users as u3','u3.id','=','vh_reservas.conductor')
                ->select('vh_reservas.*',
                    'vh_estados.estado as estadoreserva',
                    'vh_vehiculos.numeracion as vehiculo',
                    'vh_vehiculos.placa as placa',
                    'vh_vehiculos.id as idvehiculo',
                    'departamentos.nombre as departamento',
                    'departamentos.id as iddepartamento',
                    'users.nombre as nombrejefe',
                    'u2.correo as correoempleado',
                    'u3.nombre as nombreconductor','u3.apellido as apellidoconductor',
                    'u1.nombre as nombredueno'.'u1.apellido as apellidodueno',
                    'users.apellido as apellidojefe','users.correo as correojefe')->where('vh_reservas.id',$id)->first();



            return $reservas;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para obtener las reservas segun el vehiculo que el dueño tenga asignado
    public function getReservasFromDueños($dueño)
    {
        try{

            $reservas = DB::table('vh_reservas')
                ->join('vh_vehiculos','vh_reservas.vh_vehiculo_id','=','vh_vehiculos.id')
                ->join('vehiculos_dueños','vehiculos_dueños.vh_vehiculo_id','=','vh_vehiculos.id')
                ->join('vh_estados','vh_reservas.vh_estado_id','=','vh_estados.id')
                ->join('users','vehiculos_dueños.user_id','=','users.id')
                ->select('vh_reservas.*',
                    'vh_estados.estado as estadoreserva',
                    'vh_vehiculos.numeracion as vehiculo',
                    'vh_vehiculos.placa as placa',
                    'users.nombre as nombrejefe',
                    'users.apellido as apellidojefe')
                ->where('vehiculos_dueños.user_id',$dueño)
                ->get();

            return $reservas;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //verificar si un jefe es dueño de carro a la vez
    public function getDueñoJefeByReserva($reserva)
    {
        try{

            $queryrun = DB::table('vh_reservas as vhr')
                            ->select('vhr.jefe_inmediato as jefe')
                            ->where('vhr.id',$reserva)
                            ->first();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //listar reserva por fechas y vehiculo
    public function getReservaByDateAndVehiculo($vehiculo,$desde1,$desde2)
    {
       try{

           $reservas = DB::table('vh_reservas')
               ->join('vh_vehiculos','vh_reservas.vh_vehiculo_id','=','vh_vehiculos.id')
               ->join('vh_estados','vh_reservas.vh_estado_id','=','vh_estados.id')
               ->join('departamentos','vh_reservas.departamento_id','=','departamentos.id')
               ->join('users','vh_reservas.jefe_inmediato','=','users.id')
               ->join('users as u2','u2.id','=','vh_reservas.user_id')
               ->select('vh_reservas.*',
                   'vh_estados.estado as estadoreserva',
                   'vh_vehiculos.numeracion as vehiculo',
                   'vh_vehiculos.placa as placa',
                   'vh_vehiculos.id as idvehiculo',
                   'departamentos.nombre as departamento',
                   'departamentos.id as iddepartamento',
                   'users.nombre as nombrejefe',
                   'u2.correo as correoempleado',
                   'users.apellido as apellidojefe','users.correo as correojefe')
               ->where('vh_reservas.vh_vehiculo_id',$vehiculo)
               ->whereBetween('vh_reservas.fechainicio',[$desde1,$desde2])
               ->get();

           return $reservas;

       }catch(\Exception $e)
       {
           return $e->getMessage();
       }
    }







}