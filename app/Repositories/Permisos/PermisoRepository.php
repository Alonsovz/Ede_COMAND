<?php

namespace App\Repositories\Permisos;

use App\Permiso;
use DB;
use Session;


class PermisoRepository
{
	
	//funcion para guardar un permiso
	public function savePermiso($permiso)
	{
		try {

			$queryrun = $permiso->save();

			return $queryrun;
			
		} catch (\Exception $e) {
			
			return $e->getMessage();
		}
	}


	//funcion para obtener todos los permisos sin restriccion para recursos humanos
	public function getPermisos()
	{
		try {

			$permisos = DB::table('permisos')
							->join('users as empleado','empleado.id','=','permisos.user_id')
							->join('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
							->join('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
							->join('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
							->select('permisos.*',
								'empleado.nombre as nombreempleado',
								'empleado.apellido as apellidoempleado',
								'jefatura.nombre as nombrejefe',
								'jefatura.apellido as apellidojefe',
								'rh_estados.nombre as estado',
								'tipos_permisos.tipo as tipopermiso')

							->orderBy('permisos.id','desc')
							->get();

			return $permisos;
			
		} catch (\Exception $e) {
			
			return $e->getMessage();
		}
	}


	//funcion para devolver permisos segun jefatura
	public function getPermisosJefatura()
	{
		try {

			$permisos = DB::table('permisos')
							->leftjoin('users as empleado','empleado.id','=','permisos.user_id')
							->leftjoin('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
							->leftjoin('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
							->leftjoin('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
							->select('permisos.*',
								'empleado.nombre as nombreempleado',
								'empleado.apellido as apellidoempleado',
								'jefatura.nombre as nombrejefe',
								'jefatura.apellido as apellidojefe',
								'rh_estados.nombre as estado',
								'tipos_permisos.tipo as tipopermiso')
							->where('permisos.jefeinmediato',Session::get('idusuario'))
							->orderBy('permisos.id','desc')
							->get();

			return $permisos;
			
		} catch (\Exception $e) {
			
			return $e->getMessage();
		}
	}


	//funcion para obtener los permisos segun el empleado activo
	public function getPermisosEmpleado()
	{
		try {

			$permisos = DB::table('permisos')
							->leftjoin('users as empleado','empleado.id','=','permisos.user_id')
							->leftjoin('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
							->leftjoin('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
							->leftjoin('departamentos','departamentos.id','=','permisos.departamento_id')
							->leftjoin('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
							->select('permisos.*',
								'empleado.nombre as nombreempleado',
								'empleado.apellido as apellidoempleado',
								'jefatura.nombre as nombrejefe',
								'jefatura.apellido as apellidojefe',
								'rh_estados.nombre as estado',
								'tipos_permisos.tipo as tipopermiso',
								'departamentos.nombre as departamento')
							->where('permisos.user_id',Session::get('idusuario'))
							->orderBy('permisos.id','desc')
							->get();

			return $permisos;
			
		} catch (\Exception $e) {
			
			return $e->getMessage();
		}
	}




	//funcion para obtener el conteo de permisos en estado de solicitud enviada
	public function getConteo()
	{
		try {

			$conteopermiso = DB::table('permisos')->where('rh_estados_id',1)->count();

			return $conteopermiso;
			
		} catch (\Exception $e) {
			
		}
	}

	//conteo de permisos para jefatura
	public function getConteoJefatura()
	{
		try {

			$conteopermiso = DB::table('permisos')
								->where('rh_estados_id',1)
								->where('permisos.jefeinmediato',Session::get('idusuario'))
								->count();

			return $conteopermiso;
			
		} catch (\Exception $e) {
			
		}
	}

	//funcion para obtener el conteo de los permisos aprobados por jefatura
	public function getConteoAprobados()
	{
		try {

			$conteo = DB::table('permisos')
						->where('permisos.jefeinmediato',Session::get('idusuario'))
						
						->count();

			return $conteo;
			
		} catch (\Exception $e) {
			
			return $e->getMessage();

		}
	}






	//funcion para obtener el conteo de los permisos solicitados por el usuario activo
	public function getConteoEmpleado()
	{
		try {

			$conteopermiso = DB::table('permisos')
								->where('rh_estados_id',1)
								->where('permisos.user_id',Session::get('idusuario'))
								->count();

			return $conteopermiso;
			
		} catch (\Exception $e) {
			
		}
	}



	//funcion para poder obtener el detalle de un permiso por medio de su id GET
	public function getPermisoById($id)
	{
		try {

			$permiso = DB::table('permisos')
							->leftjoin('users as empleado','empleado.id','=','permisos.user_id')
							->leftjoin('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
							->leftjoin('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
							->leftjoin('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
							->leftjoin('departamentos','permisos.departamento_id','=','departamentos.id')
							->select('permisos.*',
								'empleado.nombre as nombreempleado',
								'empleado.apellido as apellidoempleado',
								'jefatura.nombre as nombrejefe',
								'jefatura.apellido as apellidojefe',
								'rh_estados.nombre as estado',
								'departamentos.nombre as departamento',
								'tipos_permisos.tipo as tipopermiso')
							->where('permisos.id',$id)	
							->get();

			return $permiso;
			
		} catch (\Exception $e) {
			
			return $e->getMessage();
		}
	}



	//obtener un permiso por medio de su id FIRST
	public function getPermiso($id)
	{
		try {

            $permiso = DB::table('permisos')
                ->join('users as empleado','empleado.id','=','permisos.user_id')
                ->join('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
                ->join('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
                ->join('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
                ->join('departamentos','permisos.departamento_id','=','departamentos.id')
                ->select('permisos.*',
                    'empleado.nombre as nombreempleado',
                    'empleado.apellido as apellidoempleado',
                    'empleado.correo as correoempleado',
                    'jefatura.nombre as nombrejefe',
                    'jefatura.apellido as apellidojefe',
                    'jefatura.correo as correojefatura',
                    'rh_estados.nombre as estado',
                    'departamentos.nombre as departamento',
                    'tipos_permisos.tipo as tipopermiso')
                ->where('permisos.id',$id)
                ->first();

			 return $permiso;
			
		} catch (\Exception $e) {
			
			return $e->getMessage();
		}
	}

	//funcion para obtener un permiso completo FIRST
	public function getPermisoFirst($id)
	{
		try {

			$permiso = DB::table('permisos')
							->join('users as empleado','empleado.id','=','permisos.user_id')
							->join('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
							->join('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
							->join('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
							->join('departamentos','permisos.departamento_id','=','departamentos.id')
							->select('permisos.*',
								'empleado.nombre as nombreempleado',
								'empleado.apellido as apellidoempleado',
								'jefatura.nombre as nombrejefe',
								'jefatura.apellido as apellidojefe',
								'rh_estados.nombre as estado',
								'departamentos.nombre as departamento',
								'tipos_permisos.tipo as tipopermiso')
							->where('permisos.id',$id)	
							->first();

			return $permiso;
			
		} catch (\Exception $e) {
			
			return $e->getMessage();
		}
	}



	//funcion para actualizar permiso 
	public function updateEstado($permiso)
	{
		try {

			 Permiso::where('id',$permiso->id)
					->update(

						array
						(
							'rh_estados_id'			=> $permiso->rh_estados_id,
							'gocesueldo'			=> $permiso->gocesueldo,
							'constancia' 			=> $permiso->constancia,
							'comentario' 			=> $permiso->comentario,
							'comentariodenegacion' 	=> $permiso->comentariodenegacion,
                            'urlpdf'                => $permiso->urlpdf,
						)

					);

			return "success";
			
			
		} catch (\Exception $e) {
			
			return $e->getMessage();
		}
	}


	//funcion para poder listar los permisos aprobados por jefatura
	public function aprobadosJefatura()
	{
		try {

			$permisos = DB::table('permisos')
							->join('users as empleado','empleado.id','=','permisos.user_id')
							->join('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
							->join('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
							->join('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
							->join('departamentos','permisos.departamento_id','=','departamentos.id')
							->select('permisos.*',
								'empleado.nombre as nombreempleado',
								'empleado.apellido as apellidoempleado',
								'jefatura.nombre as nombrejefe',
								'jefatura.apellido as apellidojefe',
								'rh_estados.nombre as estado',
								'departamentos.nombre as departamento',
								'tipos_permisos.tipo as tipopermiso')
							->where('permisos.rh_estados_id',3)
							->orWhere('permisos.rh_estados_id',4)
							->where('permisos.jefeinmediato',Session::get('idusuario'))	
							->get();

			return $permisos;
			
		} catch (\Exception $e) {
			
		}
	}



	//metodo para devolver la vista de aprobados para recursos humanos
	public function aprobadosRRHH()
	{
		try {

			$permisos = DB::table('permisos')
							->leftjoin('users as empleado','empleado.id','=','permisos.user_id')
							->leftjoin('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
							->leftjoin('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
							->leftjoin('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
							->leftjoin('departamentos','permisos.departamento_id','=','departamentos.id')
							->select('permisos.*',
								'empleado.nombre as nombreempleado',
								'empleado.apellido as apellidoempleado',
								'jefatura.nombre as nombrejefe',
								'jefatura.apellido as apellidojefe',
								'rh_estados.nombre as estado',
								'departamentos.nombre as departamento',
								'tipos_permisos.tipo as tipopermiso')
							->orderBy('permisos.id','desc')
							->get();

							

			return $permisos;
			
		} catch (\Exception $e) {
			
		}
	}



	//funcion para mostrar los permisos aprobados por empleado
	public function aprobadosEmpleado()
	{
		try {
			
			$permisos = DB::table('permisos')
							->leftjoin('users as empleado','empleado.id','=','permisos.user_id')
							->leftjoin('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
							->leftjoin('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
							->leftjoin('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
							->leftjoin('departamentos','permisos.departamento_id','=','departamentos.id')
							->select('permisos.*',
								'empleado.nombre as nombreempleado',
								'empleado.apellido as apellidoempleado',
								'jefatura.nombre as nombrejefe',
								'jefatura.apellido as apellidojefe',
								'rh_estados.nombre as estado',
								'departamentos.nombre as departamento',
								'tipos_permisos.tipo as tipopermiso')
							->where('permisos.user_id',Session::get('idusuario'))

							->orderBy('permisos.id','desc')
							->get();

							$permisos->reverse();

			return $permisos;
			
		} catch (\Exception $e) {
			
		}
	}



	//funcion para mostrar los permisos rechazados para los empleado
    public function rechazadosEmpleados()
    {
        try {

            $permisos = DB::table('permisos')
                ->leftjoin('users as empleado','empleado.id','=','permisos.user_id')
                ->leftjoin('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
                ->leftjoin('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
                ->leftjoin('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
                ->leftjoin('departamentos','permisos.departamento_id','=','departamentos.id')
                ->select('permisos.*',
                    'empleado.nombre as nombreempleado',
                    'empleado.apellido as apellidoempleado',
                    'jefatura.nombre as nombrejefe',
                    'jefatura.apellido as apellidojefe',
                    'rh_estados.nombre as estado',
                    'departamentos.nombre as departamento',
                    'tipos_permisos.tipo as tipopermiso')
                ->where('permisos.user_id',Session::get('idusuario'))
                ->Where('permisos.rh_estados_id',6)
                ->orderBy('permisos.id','desc')
                ->get();

            $permisos->reverse();

            return $permisos;

        } catch (\Exception $e) {

            return $e;
        }
    }





	//funcion para mostrar los rechazados por jefatura
	public function rechazadosJefatura()
	{
		$permisos = DB::table('permisos')
							->join('users as empleado','empleado.id','=','permisos.user_id')
							->join('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
							->join('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
							->join('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
							->join('departamentos','permisos.departamento_id','=','departamentos.id')
							->select('permisos.*',
								'empleado.nombre as nombreempleado',
								'empleado.apellido as apellidoempleado',
								'jefatura.nombre as nombrejefe',
								'jefatura.apellido as apellidojefe',
								'rh_estados.nombre as estado',
								'departamentos.nombre as departamento',
								'tipos_permisos.tipo as tipopermiso')
							->where('permisos.rh_estados_id',6)
							->where('permisos.jefeinmediato',Session::get('idusuario'))	
							->get();

			return $permisos;
	}




	//funcion para mostrar los permisos rechazados de todas las jefaturas
	public function rechazadosRRHH()
	{
		$permisos = DB::table('permisos')
							->join('users as empleado','empleado.id','=','permisos.user_id')
							->join('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
							->join('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
							->join('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
							->join('departamentos','permisos.departamento_id','=','departamentos.id')
							->select('permisos.*',
								'empleado.nombre as nombreempleado',
								'empleado.apellido as apellidoempleado',
								'jefatura.nombre as nombrejefe',
								'jefatura.apellido as apellidojefe',
								'rh_estados.nombre as estado',
								'departamentos.nombre as departamento',
								'tipos_permisos.tipo as tipopermiso')
							->where('permisos.rh_estados_id',6)
							->get();

			return $permisos;
	}


	//funcion para editar un permiso por parte del empleado
	public function editPermiso($permiso)
	{
		try {

			return Permiso::where('id',$permiso->id)->update(

				array(

						'empleado' 				=> $permiso->empleado,		                
				        'departamento_id'       => $permiso->departamento_id,       
				        'jefeinmediato' 		=> $permiso->jefeinmediato,
				        'tipo_permiso_id'       => $permiso->tipo_permiso_id,      
				        'fechainicio'      		=> $permiso->fechainicio, 
				        'fechafin'        		=> $permiso->fechafin,
				        'horainicio'            => $permiso->horainicio,     
				        'horafin'               => $permiso->horafin,  
				        'horasalida'            => $permiso->horasalida,     
				        'horaentrada'           => $permiso->horaentrada,
				        'motivopermiso'         => $permiso->motivopermiso
    					
					));
			
		} catch (\Exception $e) {
			
			return $e->getMessage();

		}
	}




	//ultimo permiso ingresado
    public function getLastPermiso()
    {
        try{

            $permiso = DB::table('permisos')
                ->join('users as empleado','empleado.id','=','permisos.user_id')
                ->join('users as jefatura','jefatura.id','=','permisos.jefeinmediato')
                ->join('rh_estados','rh_estados.id','=','permisos.rh_estados_id')
                ->join('tipos_permisos','permisos.tipo_permiso_id','=','tipos_permisos.id')
                ->join('departamentos','permisos.departamento_id','=','departamentos.id')
                ->select('permisos.*',
                    'empleado.nombre as nombreempleado',
                    'empleado.apellido as apellidoempleado',
                    'empleado.correo as correoempleado',
                    'jefatura.nombre as nombrejefe',
                    'jefatura.apellido as apellidojefe',
                    'jefatura.correo as correojefatura',
                    'rh_estados.nombre as estado',
                    'departamentos.nombre as departamento',
                    'tipos_permisos.tipo as tipopermiso')
                ->orderBy('permisos.id','desc')
                ->first();

            return $permiso;

        }catch(\Exception $e){
            return $e;
        }
    }




	//funcion para listar los permisos por area segun rango de fechas
    public function permisosByArea($desde,$hasta)
    {
        try{
            $grafico = DB::table('permisos')
                ->select(DB::raw('count(permisos.id) as conteo, d.nombre as name'))
                ->join('departamentos as d','d.id','=','permisos.departamento_id')
                ->whereBetween('fechainicio',array($desde,$hasta))
                ->groupBy('d.nombre')
                ->get();

            return $grafico;

        }catch(\Exception $e){

            return $e;
        }
    }



    //funcion para listar los permisos por empleado historico por meses
    public function permisosByEmpleadoHistorico($iduser)
    {
        try{

            $grafico =  DB::select('
                
                set language spanish
                select   DATENAME(month, p.fechainicio) as name,count(*) as conteo from permisos p
                where p.fechainicio between \'20180101\' and \'20181231\' and p.user_id=? and p.tipo_permiso_id !=7
                group by DATENAME(month,p.fechainicio),MONTH(p.fechainicio)
                order by MONTH(p.fechainicio) asc
                ',[$iduser]);

            return $grafico;

        }catch(\Exception $e){

            return $e;
        }
    }



    //lanzar query del grafico de los permisos solicitados por area
    public function graph_tipoPermisosByArea($id)
    {
        try{

            $grafico = DB::select('
                
                set language spanish
                select DATEPART(m,p.fechainicio) as mes,  DATENAME(month, p.fechainicio) as name,count(*) as conteo from permisos p 
                where p.fechainicio between \'20180101\' and \'20181231\' and p.departamento_id='.$id.' and p.tipo_permiso_id !=7
                group by DATENAME(month,p.fechainicio),DATEPART(m,p.fechainicio)
                order by DATEPART(m,p.fechainicio) asc 
                
            ');

            return $grafico;

        }catch(\Exception $e){
            return $e;
        }



    }

    //obtener permiso por ELOQUENT
    public function eloquentFindPermiso($id)
    {
        try{

            $permiso = Permiso::find($id);

            return $permiso;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    public function rpt_detalles($desde,$hasta)
    {
        try{
            $detalles = DB::select("SELECT u.nombre + isnull(' '+u.apellido,'') As Empleado,

                        Enfermedad = (SELECT COUNT(p.id) FROM permisos p
                                      INNER JOIN users u2 ON p.user_id = u2.id
                                      WHERE p.tipo_permiso_id = 1 AND u.id = u2.id  AND  p.fechainicio BETWEEN '$desde' AND '$hasta'),
                        
                        Consulta_medica = (SELECT COUNT(p.id) FROM permisos p
                                      INNER JOIN users u2 ON p.user_id = u2.id
                                      WHERE p.tipo_permiso_id = 2 AND u.id = u2.id  AND  p.fechainicio BETWEEN '$desde' AND '$hasta'),
                        
                        Accidente_laboral = (SELECT COUNT(p.id) FROM permisos p
                                      INNER JOIN users u2 ON p.user_id = u2.id
                                      WHERE p.tipo_permiso_id = 3 AND u.id = u2.id  AND  p.fechainicio BETWEEN '$desde' AND '$hasta'),
                        
                        Requerimiento_judicial = (SELECT COUNT(p.id) FROM permisos p
                                      INNER JOIN users u2 ON p.user_id = u2.id
                                      WHERE p.tipo_permiso_id = 4 AND u.id = u2.id  AND  p.fechainicio BETWEEN '$desde' AND '$hasta'),
                        
                        Matrimonio = (SELECT COUNT(p.id) FROM permisos p
                                      INNER JOIN users u2 ON p.user_id = u2.id
                                      WHERE p.tipo_permiso_id = 5 AND u.id = u2.id  AND  p.fechainicio BETWEEN '$desde' AND '$hasta'),
                        
                        Maternidad_Paternidad = (SELECT COUNT(p.id) FROM permisos p
                                      INNER JOIN users u2 ON p.user_id = u2.id
                                      WHERE p.tipo_permiso_id = 6 AND u.id = u2.id  AND  p.fechainicio BETWEEN '$desde' AND '$hasta'),
                        
                        Vacaciones = (SELECT COUNT(p.id) FROM permisos p
                                      INNER JOIN users u2 ON p.user_id = u2.id
                                      WHERE p.tipo_permiso_id = 7 AND u.id = u2.id  AND  p.fechainicio BETWEEN '$desde' AND '20180831'),
                        
                        Otro = (SELECT COUNT(p.id) FROM permisos p
                                      INNER JOIN users u2 ON p.user_id = u2.id
                                      WHERE p.tipo_permiso_id = 8 AND u.id = u2.id  AND  p.fechainicio BETWEEN '$desde' AND '$hasta'),
                        
                        Tiempo_libre_remunerado = (SELECT COUNT(p.id) FROM permisos p
                                      INNER JOIN users u2 ON p.user_id = u2.id
                                      WHERE p.tipo_permiso_id = 9 AND u.id = u2.id  AND  p.fechainicio BETWEEN '$desde' AND '$hasta'),
                        
                        Tiempo_libre_no_remunerado = (SELECT COUNT(p.id) FROM permisos p
                                      INNER JOIN users u2 ON p.user_id = u2.id
                                      WHERE p.tipo_permiso_id = 10 AND u.id = u2.id  AND  p.fechainicio BETWEEN '$desde' AND '$hasta'),
                        
                        Defunsion = (SELECT COUNT(p.id) FROM permisos p
                                      INNER JOIN users u2 ON p.user_id = u2.id
                                      WHERE p.tipo_permiso_id = 11 AND u.id = u2.id  AND  p.fechainicio BETWEEN '$desde' AND '$hasta'),
                        
                        Tiempo_compensado = (SELECT COUNT(p.id) FROM permisos p
                                      INNER JOIN users u2 ON p.user_id = u2.id
                                      WHERE p.tipo_permiso_id = 12 AND u.id = u2.id  AND  p.fechainicio BETWEEN '$desde' AND '$hasta')
                        
                        
                        
                        FROM permisos p
                        INNER JOIN users u ON p.user_id = u.id
                        WHERE p.fechainicio BETWEEN '$desde' AND '$hasta'
                        GROUP BY u.nombre + isnull(' '+u.apellido,''),u.id
                        ORDER BY u.nombre + isnull(' '+u.apellido,'') ASC",[$desde,$hasta]);

            return $detalles;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }




    //funcion para sacar el query de los detalles de los permisos solicitados
    public function rpt_detalles1($desde,$hasta,$empleado)
    {
        try{
            $detalles = DB::select("SELECT tp.tipo as name,COUNT(p.id) conteo
                        FROM permisos p
                        INNER JOIN tipos_permisos tp ON p.tipo_permiso_id = tp.id
                        INNER JOIN users u ON p.user_id = u.id
                        WHERE p.fechainicio BETWEEN ? AND ? AND u.id = ?
                        GROUP BY tp.tipo",[$desde,$hasta,$empleado]);

            return $detalles;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }



    //funcion para query de los detalles de los permisos solicitados por empleado
    public function queryDetallePorEmpleado($desde,$hasta,$empleado)
    {
        try{

            $query = DB::select("set LANGUAGE spanish SELECT tp.tipo as tipo_permiso,CONVERT(VARCHAR(17),p.fechainicio,113) as inicio,CONVERT(VARCHAR(17),p.fechafin,113) as fin,count(p.id) as conteo FROM permisos p
                                    INNER JOIN tipos_permisos tp ON p.tipo_permiso_id = tp.id
                                    WHERE p.user_id = ".$empleado." AND p.fechainicio BETWEEN '$desde' AND '$hasta'
                                    GROUP BY tp.tipo,p.fechainicio,p.fechafin
                                    ORDER BY p.fechainicio");

            return $query;

        }catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }

	
}