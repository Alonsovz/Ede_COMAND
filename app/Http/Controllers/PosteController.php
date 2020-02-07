<?php

namespace App\Http\Controllers;

use App\Poste;
use Illuminate\Http\Request;

use DB;
use Session;

use App\Repositories\Postes\PosteRepository;

class PosteController extends Controller
{

    public $poste;

    function __construct(PosteRepository $poste)
    {
        $this->poste = $poste;
    }


    public function index()
    {
        $departamentos = DB::table('DEPSV')->get();

        return view('mod_postes.postes.index')->with('departamentos',$departamentos);

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
        //creamos una transaccion
        DB::beginTransaction();

        $poste = $request->all();

        //creamos objeto para persistir la informacion enviada por el formulario
        $posteDTO = new Poste();

        $posteDTO->departamento_id      = $poste['departamento'];
        $posteDTO->municipio_id         = $poste['municipio'];
        $posteDTO->codigos_proyectos    = $poste['codigoproyecto'];
        $posteDTO->cantidad_postes      = $poste['cantidadpostes'];
        $posteDTO->descripcion          = $poste['descripcion'];
        $posteDTO->fecha_solicitud      = date('Ymd H:i');

        $query = $this->poste->save($posteDTO);

        //persistimos el objeto
        if($query)
        {
            DB::commit();
            return response()->json($query);
        }
        else
        {
            DB::rollback();
            return response()->json($query);

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
}
