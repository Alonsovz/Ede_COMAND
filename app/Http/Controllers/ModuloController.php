<?php

namespace App\Http\Controllers;

use App\Modulo;
use Illuminate\Http\Request;
use App\Repositories\Modulos\ModuloRepository;
use Illuminate\Http\Response;
use App\Repositories\Sistemas\SistemaRepository;



class ModuloController extends Controller
{

    //variables globales
    public $modulo;
    public $sistema;


    //constructor
    function __construct(ModuloRepository $modulo,SistemaRepository $sistema)
    {
        $this->modulo = $modulo;
        $this->sistema = $sistema;
    }


    public function index()
    {
        $modulos = $this->modulo->getModulos();
        $sistemas = $this->sistema->getSistemas();

        return view('modulos.index')->with('modulos',$modulos)->with('sistemas',$sistemas);

        //return json_encode($modulos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $modulo = new Modulo();

        $modulo->nombre = $request['nombre'];
        $modulo->descripcion = $request['descripcion'];
        $modulo->sistema_id = $request['sistema'];


        //persistimos el objeto modulo
        $queryrun = $this->modulo->save($modulo);

        if($queryrun==true)
        {
            return response()->json("success");
        }
        else
        {
            return response()->json($queryrun);
        }

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



    //funcion para obtener los modulos de la base de datos
    public function getModulosById(Request $request)
    {
        $modulos = $this->modulo->getModulosById($request['idmodulo']);

        return json_encode($modulos);
    }







}
