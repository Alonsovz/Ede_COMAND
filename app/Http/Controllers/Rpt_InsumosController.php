<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

class Rpt_InsumosController extends Controller
{



    public function index()
    {
        $centrocostos = DB::table('centro_costos')->get();
        $bodegas = DB::table('bodegas')->get();

        return view('insumos.admin.reportes.index')->with('centrocostos',$centrocostos)->with('bodegas',$bodegas);
    }
}
