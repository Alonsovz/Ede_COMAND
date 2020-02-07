<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Sistemas\SistemaRepository;
use App\Sistema;

class SistemaController extends Controller
{
    public $sistema;

    //constructor
    function __construct(SistemaRepository $sistema)
    {
        $this->sistema = $sistema;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sistemas = $this->sistema->getSistemas();

        return view('sistemas.index')->with('sistemas',$sistemas);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sistema = new Sistema();

        $sistema->nombre = $request['nombre'];
        $sistema->descripcion = $request['descripcion'];

        //persistimos el objeto
        $queryrun = $this->sistema->save($sistema);

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


    public function edit(Request $request)
    {
        $sistema = $this->sistema->getSistemaByID($request['id']);
        return response()->json($sistema);
    }


    public function update(Request $request)
    {
        $sistema = $this->sistema->getSistemaByIDELOQUENT($request['id']);

        $sistema->nombre = $request['nombre'];
        $sistema->descripcion = $request['descripcion'];

        //persistimos el objeto
        $queryrun = $this->sistema->update($sistema);

        if($queryrun==1)
        {
            return response()->json("success");

        }
        else
        {
            return response()->json($queryrun);
        }

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
