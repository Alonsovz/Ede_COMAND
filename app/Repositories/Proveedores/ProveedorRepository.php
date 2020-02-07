<?php
/**

 * User: Daniel Hernandez
 * Date: 13/12/2017
 * Time: 04:06 PM
 */

namespace App\Repositories\Proveedores;
use App\Proveedor;
use DB;

class ProveedorRepository
{

    //obtener todos los proveedores
    public function getProveedores()
    {
        try{
            $proveedores = DB::table('proveedores')->get();

            return $proveedores;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //obtener proveedor por id
    public function getProveedorById($id)
    {
        try{
            $proveedor = DB::table('proveedores')->where('id',$id)->first();

            return $proveedor;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    //obtener proveedor por id
    public function getProveedorByIdGET($id)
    {
        try{
            $proveedor = DB::table('proveedores')->where('id',$id)->get();

            return $proveedor;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //obtener proveedor por id
    public function getProveedorByIdELOQUENT($id)
    {
        try{
            $proveedor = Proveedor::find($id);

            return $proveedor;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }




    //guardar proveedor
    public function saveProveedor($proveedor)
    {
        try{

            $queryrun = $proveedor->save();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    //obtener ultimo id de proveedor ingresado
    public function getLastProveedor()
    {
        try{

            $queryrun = DB::table('proveedores')->latest()->first();

            return $queryrun;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
}