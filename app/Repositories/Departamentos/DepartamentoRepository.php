<?php

namespace App\Repositories\Departamentos;

use Departamento;
use DB;
use Illuminate\Support\Facades\Log;


class DepartamentoRepository
{
	//metodo para obtener los departamentos guardados en la base de datos
	public function getDepartamentos()
	{
		try 
		{
			$departamentos = DB::table('departamentos')->get();



			return $departamentos;

			
		} catch (\Exception $e) {
			
			return "Error ".$e->getMessage();
		}
	}


	//funcion para realizar la busqueda de un departamento
    public function findDepartamentoByName($departamento)
    {
        try{
            $departamento = DB::table('departamentos')->where('nombre',$departamento)->first();

            return $departamento;

        }catch(\Exception $e){

            return $e;
        }
    }
	
}