<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Proveedores\ProveedorRepository;
use App\Proveedor;

class ProveedoresController extends Controller
{
    //variables globales
    public $proveedor;


    //constructor
    function __construct(ProveedorRepository $proveedor)
    {
        $this->proveedor = $proveedor;
    }


    public function index()
    {
        $proveedores = $this->proveedor->getProveedores();

        return view('insumos.admin.proveedores.index')->with('proveedores',$proveedores);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //obtjeto de tipo proveedor
        $proveedor = new Proveedor();

        $proveedor->nombrecontacto      = $request['contacto'];
        $proveedor->nombreentidad       = $request['entidad'];
        $proveedor->razonsocial         = $request['razonsocial'];
        $proveedor->telefonomovil       = $request['telefono'];
        $proveedor->correoelectronico   = $request['correo'];
        $proveedor->direccion           = $request['direccion'];

        //persistimos el objeto
        $queryrun = $this->proveedor->saveProveedor($proveedor);

        if($queryrun==true)
        {
            return response()->json("success");
        }
        else
        {
            return response()->json("error");
        }

    }


    public function show(Request $request)
    {
        $proveedor = $this->proveedor->getProveedorByIdGET($request['id']);

        return json_encode($proveedor);

    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {
        $proveedor = $this->proveedor->getProveedorByIdELOQUENT($request['id']);

        $proveedor->nombrecontacto      = $request['contacto'];
        $proveedor->nombreentidad       = $request['entidad'];
        $proveedor->razonsocial         = $request['razonsocial'];
        $proveedor->telefonomovil       = $request['telefono'];
        $proveedor->correoelectronico   = $request['correo'];
        $proveedor->direccion           = $request['direccion'];

        //persistimos el objeto
        $queryrun = $this->proveedor->saveProveedor($proveedor);

        if($queryrun==true)
        {
            return response()->json("success");
        }
        else
        {
            return response()->json("error");
        }


    }


    public function destroy($id)
    {
        //
    }




    //ingresar un proveedor desde el modulo de requisiciones cuando no exista el proveedor que queremos
    public function saveProveedorAux(Request $request)
    {
        //obtjeto de tipo proveedor
        $proveedor = new Proveedor();

        $proveedor->nombrecontacto      = $request['contacto'];
        $proveedor->nombreentidad       = $request['entidad'];
        $proveedor->razonsocial         = $request['razonsocial'];
        $proveedor->telefonomovil       = $request['telefono'];
        $proveedor->correoelectronico   = $request['correo'];
        $proveedor->direccion           = $request['direccion'];

        //persistimos el objeto
        $this->proveedor->saveProveedor($proveedor);

        //listamos el ultimo proveedor ingresado
        $proveedorlast = $this->proveedor->getLastProveedor();

        return response()->json($proveedorlast->id);

    }
}
