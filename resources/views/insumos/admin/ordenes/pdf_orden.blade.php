<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title></title>
    <style>

        body{
            margin-bottom: 0;
            margin-top: 0;
        }



        table.minimalistBlack {
            border: 1px solid #000000;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }
        table.minimalistBlack td, table.minimalistBlack th {
            border: 1px solid #000000;
            padding: 5px 4px;
        }
        table.minimalistBlack tbody td {
            font-size: 10px;
        }
        table.minimalistBlack thead {
            background: #CFCFCF;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.minimalistBlack thead th {
            font-size: 10px;
            font-weight: bold;
            color: #000000;
            text-align: left;
        }
        .total{
            background: #CFCFCF;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.minimalistBlack tfoot {
            font-size: 10px;
            font-weight: bold;
            color: #000000;
            border-top: 1px solid #000000;
        }
        table.minimalistBlack tfoot td {
            font-size: 10px;
        }
        #container div {  }

        #div3 { width:200px; float:right }
        #div1, #div2,#div4 { width:500px;  }
    </style>
</head>
<body>

<div style=" font-family: Tahoma, Helvetica, Arial">
    <div>
        <img style="" src="C:\xampp\htdocs\COMANDA\public\images\edesal1.png" alt="">
    </div>

    <div style="margin-top: 14px; ">
        <b style="margin-left: 170px;font-size: 14px;">EMPRESA DISTRIBUIDORA ELECTRICA SALVADOREÑA</b>
    </div>

    <div style="margin-top: 5px; ">
        <b style="margin-left: 275px;font-size: 16px;">ORDEN DE COMPRA</b>
    </div>


    <div style="position: relative; bottom: 20px;  ">



        <div style="position: relative; margin:0; margin-left: 510px">
            <table class="minimalistBlack" style="width: 10px;" >

                <tbody>
                <tr >
                    <td  style="width: 75px"><b style="font-size: 9px; ">Fecha</b></td>
                    <td  style="width: 120px"><b style="font-size: 10px; font-weight: bold ">{{date('d/m/Y')}}</b></td>
                </tr>
                <tr >
                    <td  style="width: 75px"><b style="font-size: 9px; ">OC #</b></td>
                    <td  style="width: 120px"><b style="font-size: 10px; font-weight: bold ">{{$lastorden->id}}</b></td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div style=" width: 300px;position: absolute; margin-left: 425px; margin-top: 50px">
        <table  class="minimalistBlack" style="font-family: Tahoma, Helvetica, Arial; border: none; ">
            <thead>
            <tr>
                <th colspan="2">Proveedor</th>
            </tr>
            </thead>
            <tbody style="border:none;">
            <tr style="border: none;">
                <td style="border: none">Proveedor propuesto:</td>
                <td style="border: none">{{$proveedor->nombreentidad}}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">Forma de pago:</td>
                <td style="border: none;">{{$terminopago->termino}}</td>
            </tr>

            </tbody>
        </table>
    </div>
    <div style="margin-top: 0px;width: 400px">
        <table class="minimalistBlack" style="font-family: Tahoma, Helvetica, Arial; border: none">
            <thead>
            <tr>
                <th colspan="2">Facturacion y Entrega</th>
            </tr>
            </thead>
            <tbody style="border:none">
                <tr style="border:none">
                    <td style="border:none">Facturar A/N:</td>
                    <td style="border:none">Empresa Distribuidora Electrica Salvadoreña S.A de C.V</td>
                </tr>
                <tr style="border:none">
                    <td style="border:none">Fecha de entrega:</td>
                    <td style="border:none"><?php $fecha = date_create($lastorden->fecha_entrega); echo date_format($fecha,'d/m/Y')?></td>
                </tr>
                <tr style="border:none">
                    <td style="border:none">Lugar de entrega:</td>
                    <td style="border:none">Ciudad Versailles Resid Villa Paris y Prolog Pje #2 Polig #1, Edificio EDESAL</td>
                </tr>
            </tbody>
        </table>
    </div>




    <div style="margin-top: 20px">
        <table class="minimalistBlack" style="font-family: Tahoma, Helvetica, Arial">
            <thead>
            <tr>
                <th colspan="5">Detalle de insumos</th>
            </tr>
            <tr>
                <th style="width:5px; text-align: center">Cantidad</th>
                <th style="width:75px; text-align: center">Insumo</th>
                <th style="width:10px; text-align: center">Descripcion</th>
                <th style="width:10px; text-align: center">Precio/Uni</th>
                <th style="width:10px; text-align: center">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($detalles as $detalle)
                <tr>
                    <td style="font-size: 9px; text-align: center">{{$detalle->cantidad}}</td>
                    <td style="font-size: 9px">{{$detalle->insumo}}</td>
                    <td style="font-size: 9px">{{$detalle->ins_descripcion}}</td>
                    <td style="margin-left: 80px; font-size: 9px; text-align: center;">$ <?php echo round($detalle->precio,2) ?></td>
                    <td style="margin-left: 80px; font-size: 9px; text-align: center;">$ <?php echo round($detalle->precio*$detalle->cantidad,2) ?></td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>SUBTOTAL</td>
                <td style="text-align: center; font-size: 9px">$ <?php echo round($subtotal->subtotal,2) ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>IVA</td>
                <td style="text-align: center; font-size: 9px">$ <?php echo round((0.13*$subtotal->subtotal),2) ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="total">TOTAL</td>
                <td class="total" style="text-align: center; font-size: 9px">$ <?php echo round(($subtotal->subtotal*0.13 + $subtotal->subtotal),2)?></td>
            </tr>
            </tfoot>
        </table>
    </div>

    <div style=" margin-top:10px; width: 400px">
        <table  class="minimalistBlack" style="font-family: Tahoma, Helvetica, Arial; ">
            <thead>
            <tr>
                <th colspan="2">Comentarios o intrucciones especiales</th>
            </tr>
            </thead>
            <tbody style="height: 200px;" >
            <tr >
                <td style="border: none" ></td>
                <td style="border: none"></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"></td>
                <td style="border: none;"></td>
            </tr>
            <tr >
                <td style="border: none" ></td>
                <td style="border: none"></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"></td>
                <td style="border: none;"></td>
            </tr>
            <tr >
                <td style="border: none" ></td>
                <td style="border: none"></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"></td>
                <td style="border: none;"></td>
            </tr>

            </tbody>
        </table>
    </div>


        <div style="position: relative; margin-top:15px;  width: 500px">
            <table class="minimalistBlack" style="border: none">
                <thead>
                    <tr>
                        <th colspan="4">Firmas</th>
                    </tr>
                </thead>
                <tbody style="border:none">
                <tr >
                    <td  style="width: 75px; border:none"><b style="font-size: 9px; ">Aprobado por:</b></td>
                    @if($solicitante=='Claudia Machado' || $solicitante='Alicia Bolaños')
                        <td  style="width: 120px; border:none"><b style="font-size: 10px; font-weight: 400 ">Alicia Bolaños</b></td>
                        @else
                        <td  style="width: 120px; border:none"><b style="font-size: 10px; font-weight: 400 ">Alicia Bolaños</b></td>
                        @endif
                    <td  style="width: 75px; border:none"><b style="font-size: 9px; ">Solicitado por:</b></td>
                    <td  style="width: 120px; border:none"><b style="font-size: 10px; font-weight: 400 ">{{$solicitante}}</b></td>
                </tr>

                <tr >
                    <td  style="width: 75px; border:none"><b style="font-size: 9px; ">Entregado:</b></td>
                    <td  style="width: 120px; border:none"><b style="font-size: 10px; font-weight: bold "></b></td>
                    <td  style="width: 75px; border:none"><b style="font-size: 9px; ">Recibido:</b></td>
                    <td  style="width: 120px; border:none"><b style="font-size: 10px; font-weight: bold "></b></td>
                </tr>

                </tbody>
            </table>
        </div>




</body>
</html>