<?php

/**

 * User: Daniel Hernandez
 * Date: 19/03/2018
 * Time: 08:40 PM
 */
class Busqueda
{
    //funcion para busqueda de elementos por el metodo secuencial
    public static function busqueda_secuencial($a,$n,$x)
    {
        for ($i=0; $i<$n; $i++)
        {

            if($x==$a[$i]->cod)
            {
                return $a[$i]->cant_inicial;
            }

        }
        return 0;

    }

    //funcion para busqueda de elementos por el metodo secuencial
    public static function busqueda_precio_adq($a,$n,$x,$cantidad)
    {
        for ($i=0; $i<$n; $i++)
        {

            if($x==$a[$i]->codigo)
            {
                return $a[$i]->precio * $cantidad;
            }

        }
        return 0;

    }

    //funcion para listar el costo consumido
    public static function busqueda_costo_consumido($b,$a,$n,$x,$cantidad)
    {
        $precioadq = 0;
        $precioini = 0;

        for ($i=0; $i<count($a); $i++)
        {
            if($x==$a[$i]->codigo)
            {
                $precioini = $a[$i]->precio;
            }
        }

        for($j=0; $j<count($b); $j++)
        {
            if($x==$b[$j]->codigo)
            {
                $precioadq = $b[$j]->precio;
            }

        }

        if(isset($precioadq) && isset($precioini))
        {
            $costopromedio = ($precioini+$precioadq)/2;

            return $cantidad*$costopromedio;
        }
        else
        {
            return 0;
        }



    }

    //funcion para listar los precios de las cantidades iniciales de los movimientos de los insumos de limpieza
    public static function busquedaCodPrecio($b,$a,$n,$x)
    {
        $precio = 0;
        $cantidad = 0;

        for ($i=0; $i<$n; $i++)
        {
            if($x==$a[$i]->codigo)
            {
                $precio = $a[$i]->precio;
            }
        }

        for($j=0; $j<count($b); $j++)
        {
            if($x==$b[$j]->cod)
            {
                $cantidad = $b[$j]->cant_inicial;
            }

        }

        if(isset($cantidad) && isset($precio))
        {
            return $cantidad*$precio;
        }
        else
        {
            return 0;
        }


    }



    //busqueda de costo consumido

    public static function b_costo_consumido($b,$a,$n,$x,$cantidad)
    {
        $precioadq = 0;
        $precioini = 0;

        for ($i=0; $i<count($a); $i++)
        {
            if($x==$a[$i]->codigo)
            {
                $precioini = $a[$i]->precio;
            }
        }

        for($j=0; $j<count($b); $j++)
        {
            if($x==$b[$j]->codigo)
            {
                $precioadq = $b[$j]->precio;
            }

        }

        if(isset($precioadq) && isset($precioini))
        {
            $costopromedio = ($precioini+$precioadq)/2;

            return $costopromedio;
        }
        else
        {
            return 0;
        }



    }
}