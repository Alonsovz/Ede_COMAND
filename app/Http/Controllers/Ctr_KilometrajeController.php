<?php

namespace App\Http\Controllers;

use App\Ctr_Kilometraje;
use App\VH_Vehiculos;
use Illuminate\Http\Request;
use DB;
use App\Repositories\User\UserRepository;
use App\Repositories\VH_Reservas\vh_ReservaRepository;
use App\Repositories\VH_Vehiculos\VH_VehiculoRepository;
use App\Repositories\Ctr_Kilometraje\Ctr_KilometrajeRepository;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\PDF;
use Session;
use Mail;


class Ctr_KilometrajeController extends Controller
{

    public $user;
    public $reserva;
    public $kilometraje;


    //constructor
    function __construct(UserRepository $user,VH_VehiculoRepository $reserva,Ctr_KilometrajeRepository $kilometraje)
    {
        $this->user = $user;
        $this->reserva = $reserva;
        $this->kilometraje = $kilometraje;
    }


    //metodo index para crear un nuevo registro de kilometraje
    public function index()
    {
        //vehiculos
        $vehiculos = DB::table('vh_vehiculos')->get();
        return view('vh_reservas.admin.kilometraje.index')->with('vehiculos',$vehiculos);
    }



    //metodo para guardar un registro de kilometraje
    public function save(Request $request)
    {
        //creamos objeto para guardar info del kilometraje
        $kilometraje = new Ctr_Kilometraje();

        //inicializamos una transaccion
        DB::beginTransaction();

        //fechas
        $ini = date_create_from_format('d/m/Y H:i',$request['horarioinicio']);
        $fin = date_create_from_format('d/m/Y H:i',$request['horariofinal']);

        //empleado
        $array = explode(' ',$request['empleado']);
        $empleado = $this->user->findUserByName($array[0],$array[1]);

        //llenamos el objeto con la informacion enviada por medio de AJAX
        $kilometraje->horario_inicio    = date_format($ini,'Ymd H:i');
        $kilometraje->horario_fin       = date_format($fin,'Ymd H:i');
        $kilometraje->km_inicial        = $request['kminicial'];
        $kilometraje->km_final          = $request['kmfinal'];
        $kilometraje->galones_cargados  = (double)$request['galones'];
        $kilometraje->costo_cargado     = (double)$request['costo'];
        $kilometraje->num_recibo        = $request['recibo'];
        $kilometraje->trabajo_realizado = $request['trabajo'];
        $kilometraje->vh_vehiculo_id    = $request['vehiculo'];
        $kilometraje->empleado          = $empleado->id;
        $kilometraje->fecha_creacion    = date('Ymd H:i');
        $kilometraje->vh_reserva_id     = $request['reserva'];




        //persistimos el objeto
       if($kilometraje->save())
       {


           //creamos un objeto de tipo vehiculo para actualizar el recorrido de km
           $vh = VH_Vehiculos::find($kilometraje->vh_vehiculo_id);
           $vh->conteo_km = (int)$vh->conteo_km + (int)$request['recorrido'];




           //persistimos el
           if($vh->save())
           {
               DB::commit();
           }

           if($vh->conteo_km>=5000)
           {
               Session::put('vehiculo',$vh->numeracion);
               Session::put('recorrido',$vh->conteo_km);
               Session::put('mensajekm','El vehiculo necesita mantenimiento');

               Mail::send('email.mantenimientos.recorridovh', ['duenovehiculo' => $vh], function ($m) use ($vh) {
                   $m->from('comanda@edesal.com', 'COMANDA');
                   $m->to('dhernandez@edesal.com', '')->subject('Recorrido de vehiculo actualizado!');
               });
           }


           return response()->json(true);
       }
       else
       {
           DB::rollback();
           return response()->json(false);
       }


    }


    //lanzar la ficha de mtto para un nuevo mtto
    public function fichaMtto()
    {
        $tiposmtto = DB::table('vh_tipo_mtto')->get();
        $vehiculos = DB::table('vh_vehiculos')->get();

        return view('mantenimiento.mantenimiento')->with('vehiculos',$vehiculos)->with('tiposmtto',$tiposmtto);
    }



    //funcion para mostrar los kilometrajes ingresados
    public function show()
    {
        $kilometrajes = $this->kilometraje->getKilometrajesAll();
        $kilometrajesmayores2dias = $this->kilometraje->getRegistrosReservasMayoresDosDias();

        return view('vh_reservas.admin.kilometraje.show')->with('kilometrajes',$kilometrajes)->with('kilometrajes2',$kilometrajesmayores2dias);

        //return response()->json($kilometrajes);
    }



    //funcion para editar kiometraje y mostrar la vista con los campos listados
    public function edit(Request $request)
    {
        $kilometraje = $this->kilometraje->getKilometrajeByID($request['kilometraje']);
        $vehiculos = DB::table('vh_vehiculos')->get();

        return view('vh_reservas.admin.kilometraje.edit')->with('kilometraje',$kilometraje)->with('vehiculos',$vehiculos);

        //return response()->json($kilometraje);
    }



    //actualizar kilometraje
    public function update(Request $request)
    {
        //creamos objeto para guardar info del kilometraje
        $kilometraje = Ctr_Kilometraje::find($request['id']);

        //fechas
        $ini = date_create_from_format('d/m/Y H:i',$request['horarioinicio']);
        $fin = date_create_from_format('d/m/Y H:i',$request['horariofinal']);

        //empleado
        $array = explode(' ',$request['empleado']);
        $empleado = $this->user->findUserByName($array[0],$array[1]);

        //llenamos el objeto con la informacion enviada por medio de AJAX
        $kilometraje->horario_inicio    = date_format($ini,'Ymd H:i');
        $kilometraje->horario_fin       = date_format($fin,'Ymd H:i');
        $kilometraje->km_inicial        = $request['kminicial'];
        $kilometraje->km_final          = $request['kmfinal'];
        $kilometraje->galones_cargados  = (double)$request['galones'];
        $kilometraje->costo_cargado     = (double)$request['costo'];
        $kilometraje->num_recibo        = $request['recibo'];
        $kilometraje->trabajo_realizado = $request['trabajo'];
        $kilometraje->vh_vehiculo_id    = $request['vehiculo'];
        $kilometraje->empleado          = $empleado->id;
        $kilometraje->fecha_creacion    = date('Ymd H:i');
        $kilometraje->vh_reserva_id     = $request['reserva'];


        //persistimos el objeto
        $queryrun = $kilometraje->save();

        return response()->json($queryrun);
    }


    //listar el ultimo kilometraje
    public function getUltimoKm(Request $request)
    {
        $km = $this->kilometraje->getLastKilometrajeForVH($request['vehiculo']);

        return response()->json($km);
    }




    //index de reportes de kilometraje
    public function indexReportes()
    {
        return view('vh_reservas.admin.kilometraje.reportes.index');
    }



    //funcion para obtener el query del resumen por vehiculo
    public function queryResumenXVehiculo(Request $request)
    {
        $desde = $request['desde'].' 00:00';
        $hasta = $request['hasta'].' 23:59';

        $d = date_create($desde);
        $h = date_create($hasta);

        $dd = date_format($d,'d/m/Y');
        $hh = date_format($h,'d/m/Y');

        $query = $this->kilometraje->getResumenPorVehiculoKM($desde,$hasta);

        return view('vh_reservas.admin.kilometraje.reportes.Vehiculos.ResumenVehiculos')->with('query',$query)->with('desde',$dd)->with('hasta',$hh);
    }




    //Funcion para generar el excel de resumenxVehiculo
    public function resumenXVehiculoExcel(Request $request)
    {



        //cantidades adquiridas y consumidas
        $queryrun = $this->kilometraje->getResumenPorVehiculoKM($request['desde'].' 0:00',$request['hasta'].' 23:59');


        Excel::create('resumenvehiculos', function($excel) use($queryrun) {
            $excel->sheet('detalles', function($sheet) use($queryrun) {



                $sheet->loadView('vh_reservas.admin.kilometraje.reportes.Vehiculos.ResumenxVehiculosExcel')
                    ->with('query',$queryrun);


            });
        })->export('xls');
    }



    //Generar el pdf del resumen por vehiculo
    public function resumenXVehiculoPDF(Request $request)
    {
        $queryrun = $this->kilometraje->getResumenPorVehiculoKM($request['desde'].' 0:00',$request['hasta'].' 23:59');

        $pdf = \App::make('dompdf.wrapper');

        $view =  \View::make('vh_reservas.admin.kilometraje.reportes.Vehiculos.ResumenxVehiculosPDF', compact('queryrun'))->render();

        $pdf->loadHTML($view);

        return $pdf->stream('resumenxvehiculos.pdf');
    }


    //function para el query y render del reporte para mostrarlo en la pantalla COMANDA
    public function queryResumenXEmpleado(Request $request)
    {
        $query = $this->kilometraje->getResumenXEmpleado($request['desde'],$request['hasta']);

        return view('vh_reservas.admin.kilometraje.reportes.Empleados.all_empleados')->with('query',$query);


    }


    //function para generar el excel del reporte de los km recorridos por empleado
    public function generarExcelResumenEmpleados(Request $request)
    {
        $queryrun = $this->kilometraje->getResumenXEmpleado($request['desde'],$request['hasta']);

        Excel::create('resumenempleados', function($excel) use($queryrun) {
            $excel->sheet('detalles', function($sheet) use($queryrun) {

                $sheet->loadView('vh_reservas.admin.kilometraje.reportes.Empleados.all_empleados_excel')
                    ->with('query',$queryrun);

            });
        })->export('xls');
    }


    //funcion para mostrar la vista donde los dueños de los vehiculos podran ver el kilometraje de su carro
    public function showDueñoKM()
    {
        $vehiculos = DB::table('vh_vehiculos as v')
                        ->join('vehiculos_dueños as vd','vd.vh_vehiculo_id','=','v.id')
                        ->where('vd.user_id',Session::get('idusuario'))->get();

        return view('vh_reservas.jefatura.kilometrajes')->with('vehiculos',$vehiculos);
    }



    //funcion para devolver el json con la informacion de los km ingresados segun fechas establecidas
    public function kmIngresadosByFecha(Request $request)
    {

        $d = date_create_from_format('m/d/Y', $request['desde']);
        $h = date_create_from_format('m/d/Y', $request['hasta']);

        $desde = date_format($d,'Ymd');
        $hasta = date_format($h,'Ymd');

        $kilometrajes = $this->kilometraje->kmIngresadosByFecha($desde,$hasta);

        return view('vh_reservas.jefatura.partials.kmbyfecha')->with('kilometrajes',$kilometrajes);
    }


    //generar el excel de los km ingresados por el supervisor segun fechas establecidas
    public function excelKmIngresadosByFecha(Request $request)
    {
        $d = date_create_from_format('m/d/Y', $request['desde']);
        $h = date_create_from_format('m/d/Y', $request['hasta']);

        $desde = date_format($d,'Ymd');
        $hasta = date_format($h,'Ymd');

        $queryrun = $this->kilometraje->kmIngresadosByFecha($desde,$hasta);


        Excel::create('kmingresados', function($excel) use($queryrun) {
            $excel->sheet('detalles', function($sheet) use($queryrun) {

                $sheet->loadView('vh_reservas.jefatura.reportes.excelkmingresados')
                    ->with('kilometrajes',$queryrun);

            });
        })->export('xls');
    }



    //listar los km recorridos de cada vehiculo para los usuarios que poseen rol de dueño
    public function kmRecordidosDuenoVehiculo(Request $request)
    {

        $d = date_create_from_format('m/d/Y', $request['desde']);
        $h = date_create_from_format('m/d/Y', $request['hasta']);

        $desde = date_format($d,'Ymd');
        $hasta = date_format($h,'Ymd');

        $query = $this->kilometraje->getCostosKMGalonesForDuenos($desde.' 00:00',$hasta.' 23:59',Session::get('idusuario'));

       return view('vh_reservas.jefatura.partials.kmbyvehiculo')->with('query',$query);


    }


    //Generar el excel de los km recorridos por vehiculos segun dueño
    public function excelKmRecorridosVH(Request $request)
    {
        $d = date_create_from_format('d/m/Y', $request['desde']);
        $h = date_create_from_format('d/m/Y', $request['hasta']);

        $desde = date_format($d,'Ymd');
        $hasta = date_format($h,'Ymd');

        $query = $this->kilometraje->getCostosKMGalonesForDuenos($desde.' 00:00',$hasta.' 23:59',Session::get('idusuario'));


        Excel::create('kmrecorridosporvehiculo', function($excel) use($query) {
            $excel->sheet('detalles', function($sheet) use($query) {

                $sheet->loadView('vh_reservas.jefatura.reportes.excelkmrecorridosporvehiculo')
                    ->with('query',$query);

            });
        })->export('xls');
    }
}
