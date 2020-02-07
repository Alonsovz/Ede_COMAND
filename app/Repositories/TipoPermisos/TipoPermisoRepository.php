<?php

namespace App\Repositories\TipoPermisos;
use DB;
use Tipo_Permiso;


class TipoPermisoRepository
{
	


	//metodo para obtener todos los tipos de permisos guardados en la base de datos
	public function getTiposPermisos()
	{
		try 
		{

			$tipospermisos = DB::table('tipos_permisos')->get();

			return $tipospermisos;
			
		} catch (\Exception $e) {
			
			return "Error ".$e->getMessage();
		}

	}

}