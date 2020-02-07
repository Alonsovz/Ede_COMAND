<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ENRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    //buscamos los detalles del NIS (lecturas,etc)
    public function detallesNIS(Request $request)
    {
        //$lecturas = DB::connection('facturacion')->table('FE_LECTURAS as fe')->where('fe.num_suministro',$request['NIS'])->get();
        $detalles = DB::connection('facturacion')->select("SELECT TOP 1 c.NOMBRES as nombres, c.APELLIDOS as apellidos,c.direccion,lec.numero_medidor,FS.CODIGO_TARIFA as tarifa
                                                        FROM FE_CLIENTE c
                                                        INNER JOIN FE_SUMINISTROS FS ON c.CODIGO_CLIENTE = FS.CODIGO_CLIENTE
                                                        INNER JOIN FE_LECTURAS lec ON FS.num_suministro = lec.num_suministro
                                                        WHERE FS.num_suministro = ?",[$request['NIS']]);

        return response()->json($detalles);
    }


    //obtener lecturas segun NIS
    public function getLecturas(Request $request)
    {
        $lecturas = DB::connection('facturacion')
            ->table('FE_LECTURAS')->where('num_suministro',$request['NIS'])->where('CODIGO_CONSUMO','CO011')->orderBy('fecha_lectura','desc')->get();

        return response()->json($lecturas);
    }


    //obtener los medidores
    public function getMedidoresHistorico(Request $request)
    {
        $medidores = DB::connection('facturacion')->table('FE_APARATOS')->where('num_suministro',$request['NIS'])->get();

        return response()->json($medidores);
    }


    //sumatoria de lecturas nuevas para calculo de ENR
    public function sumatoriaLecturasNuevas(Request $request)
    {


        try{
            $codigoconsumo = "CO011";

            $query = DB::connection('facturacion')->table('FE_LECTURAS as fe')
                ->where('fe.fecha_lectura_ant','>=',$request['desde'])
                ->where('fe.fecha_lectura','<=',$request['hasta'])
                ->where('fe.num_suministro',$request['NIS'])
                ->where('fe.CODIGO_CONSUMO',$codigoconsumo)
                ->sum('fe.consumo');

            return response()->json($query);

        }catch(\Exception $e)
        {
            $query = $e->getMessage();
            return response()->json($query);
        }


    }



    public function create()
    {
        return view('enr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
