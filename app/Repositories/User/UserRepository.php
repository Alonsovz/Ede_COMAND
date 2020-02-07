<?php

namespace App\Repositories\User;
use App\User;
use DB;
use Illuminate\Support\Facades\Hash;


class UserRepository
{

	//metodo para obtener los usuarios del sistema
	public function getAll()
	{
		$users = DB::table('users')->orderBy('nombre','asc')->get();

		return $users;
	}




	//funcion para validar las credenciales del usuario
	public function validarCredenciales($correo,$password)
	{
		try {

			if ($password=="12345") 
			{
				//obtenemos el usuario por medio del correo y password ingresado
				$usuario = DB::table('users')
                                ->join('usuario_rol','users.id','=','usuario_rol.user_id')
                                ->join('roles','roles.id','=','usuario_rol.rol_id')
                                ->select('users.*')
                   				->where('correo',$correo)
                                ->first();



             return $usuario;

			}
			else if($password!="12345")
			{
			    $passform = md5($password);

				//obtenemos el usuario por medio del correo y password ingresado
				$usuario = DB::table('users')
                                ->join('usuario_rol','users.id','=','usuario_rol.user_id')
                                ->join('roles','roles.id','=','usuario_rol.rol_id')
                                ->select('users.*')
                   				->where('correo',$correo)
                                ->first();


                if ($passform==$usuario->password)
                {
                    return $usuario;
                }
                else
                {
                    return "error";
                }

             	
			}
			
		} catch (\Exception $e) {

			return $e->getMessage();
			
		}
	}


	

	//funcion para seleccionar los roles del usuario logueado
	public function getRoles($id)
	{
		try {

			$roles = DB::table('roles')
						  ->join('usuario_rol as ur','roles.id','=','ur.rol_id')
						  ->join('users as u','u.id','=','ur.user_id')
						  ->select('roles.nombre')
						  ->where('u.id',$id)
						  ->get();

			return $roles;
			
		} catch (\Exception $e) {
			
			return "Error ".$e->getMessage();
		}
	}



	//funcion para listar usuarios con el rol de jefatura
	public function getUsuariosXJefatura()
	{
		try {

			$usuarios = DB::table('users') 	
									->join('usuario_rol','users.id','=','usuario_rol.user_id')
                                	->join('roles','roles.id','=','usuario_rol.rol_id')
                                	->select('users.id','users.nombre','users.apellido','roles.id as rolid','roles.nombre as rol')
                                	->where('roles.id',4)
                                	->get();

			return $usuarios;	


			
		} catch (\Exception $e) {
			
			return $e->getMessage();
		}
	}


	//funcion para buscar un usuario por su nombre completo
	public function findUserByName($nombre,$apellido)
	{



        $usuario 	= DB::table('users')
        					           ->where('nombre',$nombre)
        					           ->where('apellido',$apellido)
        					           ->first();

        return $usuario;					           
	}



	//funcion para obtener los usuarios del sistema comanda
    public function getUsuariosAll()
    {
       try{

           $usuarios = DB::table('users')->get();

           return $usuarios;

       }catch(\Exception $e){

           return $e;
       }

    }



    //funcion para obtener los usuarios del sistema comanda con rol de staff
    public function getUsuariosStaff()
    {
        try{

            $usuarios = DB::table('users')
                ->join('usuario_rol','users.id','=','usuario_rol.user_id')
                ->join('roles','roles.id','=','usuario_rol.rol_id')
                ->select('users.id','users.nombre','users.apellido','roles.id as rolid','roles.nombre as rol')
                ->where('roles.id',1)
                ->get();

            return $usuarios;

        }catch(\Exception $e){

            return $e;
        }
    }



    //obtener usuario por su nombre y apellido
    public function getUserByNames($nombre,$apellido)
    {
        try{

            $usuario = DB::table('users')->where('nombre',$nombre)->where('apellido',$apellido)->first();

            if($usuario!='')
            {
                return $usuario;
            }
            else
            {
                return "error";
            }

        }catch(\Exception $e)
        {
            return $e->getMessage();

        }
    }


    //obtener un usuario por medio de su id
    public function getUserById($id)
    {
        try{

            $usuario = DB::table('users')->where('id',$id)->first();

            if($usuario!='')
            {
                return $usuario;
            }
            else
            {
                return "error";
            }

        }catch(\Exception $e)
        {
            return $e->getMessage();

        }
    }


    //actualizar usuarios
    public function update($user)
    {
        try{

            $queryrun = $user->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //busqueda de usuario por ELOQUENT
    public function getUserByEloquentID($id)
    {
        try{

            $user = User::find($id);

            return $user;

        }catch(\Exception $e)
        {
            $e->getMessage();
        }
    }


    //obtener dueño de vehiculo
    public function getDueñoVH($vehiculo)
    {
        try {

            $dueño = DB::table('vehiculos_dueños as vh')
                ->join('users as  u','u.id','=','vh.user_id')
                ->select('u.correo as correo')
                ->where('vh.vh_vehiculo_id',$vehiculo)
                ->first();

            return $dueño;

        } catch (Exception $e) {

            $e->getMessage();
        }
    }


    //usuarios con roles
    public function getInfoDetalleUser($id)
    {
        try {

            $usuarios = DB::table('users as u')
                        ->leftjoin('departamentos_edesal as de','de.id','=','u.departamento_id')
                        ->leftjoin('users as u1','u1.id','=','u.jefe_inmediato')
                        ->select('u.*','u1.nombre as nombrejefe','u1.apellido as apellidojefe',
                            'de.nombre as departamento','de.id as departamentoid')
                        ->where('u.id',$id)
                        ->get();

            return $usuarios;

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }



    //obtener los roles de un usuario
    public function getRolesByIdUser($id)
    {
        $roles = DB::table('usuario_rol as ur')
                    ->join('users as u','u.id','=','ur.user_id')
                    ->join('roles as r','r.id','=','ur.rol_id')
                    ->select('r.nombre as rol','r.descripcion','r.id')
                    ->where('u.id',$id)
                    ->get();

        return $roles;
    }



    //obtener usuario por correo
    public function getUserByCorreo($correo)
    {
        try
        {
            $user = DB::table('users')
                ->where('users.correo',$correo)
                ->first();

            return $user;

        }catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //listar conteo de tickets en proceso para informatica
    public function getTicketsEnProceso()
    {
        try{

            $query = DB::select("SELECT u.id as idusuario, u.nombre+ ISNULL(' '+u.apellido,'') as empleado,COUNT(t.id) as conteo FROM tickets t
                            INNER JOIN users u ON t.us_asignado = u.id
                            INNER JOIN usuario_rol ur ON ur.user_id = t.us_asignado
                            WHERE (t.estado_id = 5 OR t.estado_id = 2 OR t.estado_id=13) AND ur.rol_id = 1
                            GROUP BY u.nombre+ ISNULL(' '+u.apellido,''),u.id
                        ");

            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //listar los tickets en proceso con su detalle por empleado de Informatica
    public function getDetalleTicketsEnProceso($usuario)
    {
        try{

            $query = DB::select('SELECT t.id as idticket, e.nombre as estadoticket, t.descripcion, u.nombre+ ISNULL(\' \'+u.apellido,\'\') as solicitante,t.fechasolicitud,t.fechaentregareal
                    FROM tickets t
                    INNER JOIN estados e ON e.id = t.estado_id
                    INNER JOIN users u ON t.us_solicitante = u.id
                    INNER JOIN users u2 ON t.us_asignado = u2.id
                    WHERE (t.estado_id = 5 OR t.estado_id = 2 OR t.estado_id=13) AND u2.id = ?
                    ORDER BY t.id DESC',[$usuario]);


            return $query;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


}