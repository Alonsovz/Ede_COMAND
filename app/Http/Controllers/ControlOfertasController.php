<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\ControlOferta;
use App\Repositories\ControlOfertas\ControlOfertasRepository;


class ControlOfertasController extends Controller
{

    public $controloferta;

    //constructor
    function __construct(ControlOfertasRepository $controloferta)
    {
        $this->controloferta = $controloferta;
    }



    //funcion para mostrar la vista del formulario de nueva oferta
    public function index()
    {
        return view('control_ofertas.admin.index');
    }
}
