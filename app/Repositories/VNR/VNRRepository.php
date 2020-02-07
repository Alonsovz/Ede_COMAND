<?php
/**

 * User: Fabio Mejía
 * Date: 26/09/2019
 * Time: 10:18 AM
 */

namespace App\Repositories\VNR;

use App\Ingreso;
use DB;
use Dompdf\Exception;


class VNRRepository
{


  


    //obtener tickets completos
    public function getIngresos()
    {
        try{

            $ingresos = DB::connection('saf')->select("select t3.*, cargo - abono as saldo

            from (
            
            
            select a.*,
                   b.periodo_año as periodoanio,
                   b.periodo_mes,
                   b.concepto,
                   b.usuario,
                   b.fecha_transaccion,
                   b.partida_id,
                   c.partida_referencia,
                   cargo =
                  CASE b.tipo_movimiento_id
                     WHEN 'C' THEN b.valor
                     ELSE 0
                  END,
                   abono =
                  CASE b.tipo_movimiento_id
                     WHEN 'A' THEN b.valor
                     ELSE 0
                  END
            from transaccion_temporal_finanzas_ingresos a,
                 transaccion b, 
                 partida c
            where  a.cuenta = b.cuenta 
               and b.periodo_mes <= 5
               and b.periodo_año = 2019
               and b.partida_id = c.partida_id
               and c.estado_partida_id = 3
            ) t3
            order by t3.cuenta, 
                     t3.nombre_cuenta
            ");

        return response()->json($ingresos);



        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }




    





    


    

}