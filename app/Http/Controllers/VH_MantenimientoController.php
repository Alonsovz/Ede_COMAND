<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VH_MantenimientoController extends Controller
{
    //funcion para retornar la vista del formulario de nueva solicitud
    public function index()
    {
        return view('vh_mantenimientos.index');
    }
}
