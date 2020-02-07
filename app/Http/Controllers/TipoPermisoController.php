<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\TipoPermisos\TipoPermisoRepository;

class TipoPermisoController extends Controller
{
    protected $tipopermiso;


    //metodo constructor    
    function __construct(TipoPermisoRepositorie $tipopermiso)
    {
        $this->tipopermiso = $tipopermiso;
    }


   
    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }

    //funcion para obtener los tipos de permisos
    public function obtenerTiposPermisos()
    {
        $tipospermisos = $this->tipopermiso->getTiposPermisos();

        if ($tipospermisos!=null)
        {
            return $tipospermisos;
            
        }
        else
        {
            return "Error ".$tipospermisos;
        }
    }






}
