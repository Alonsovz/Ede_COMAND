<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title></title>
    <style>
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
            font-size: 13px;
        }
        table.minimalistBlack thead {
            background: #CFCFCF;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.minimalistBlack thead th {
            font-size: 9px;
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
            font-size: 1px;
            font-weight: bold;
            color: #000000;
            border-top: 1px solid #000000;
        }
        table.minimalistBlack tfoot td {
            font-size: 9px;
        }
    </style>
</head>
<body>

<div style=" font-family: Tahoma, Helvetica, Arial">
    <div>
        <img style="" src="C:\xampp\htdocs\COMANDA\public\images\edesal1.png" alt="">
    </div>
    <div style="margin-top: 15px; ">
        <b style="margin-left: 200px;font-size: 25px;">EDESAL S.A DE C.V</b> <b style="margin-left: 150px;font-size: 13px">ORDEN DE COMPRA</b>
    </div>
    <div style="margin-top: 5px">
       <b style="margin-left: 640px;font-size: 13px font-family: Tahoma, Helvetica, Arial">N° {{$lastorden->id}}</b>
    </div>
    <div style="margin-top: 5px">
        <b style="margin-left: 635px;font-size: 13px font-family: Tahoma, Helvetica, Arial">Papeleria</b>
    </div>
    <div style="margin-top: 60px">
         <b style="font-size: 9px">FECHA CREACION: <?php $fecha = date_create($lastorden->fecha_creacion); echo date_format($fecha,'d/m/Y')?></b>
    </div>
    <div style="margin-top: 16px">
         <b style="font-size: 9px">FECHA ENTREGA: <?php $fecha = date_create($lastorden->fecha_entrega); echo date_format($fecha,'d/m/Y')?></b>
    </div>
    <div style="margin-top: 16px">
        <b style="font-size: 9px">PROVEEDOR PROPU.:  {{$proveedor->nombreentidad}}</b>
    </div>
    <div style="margin-top: 16px">
         <b style="font-size: 9px">TERM. PAGO: {{$terminopago->termino}}</b>
    </div>

</div>

<div style="margin-top: 30px">
    <table class="minimalistBlack" style="font-family: Tahoma, Helvetica, Arial;font-size: 9px">
        <thead>
        <tr>
            <th style="width: 10px">Cantidad</th>
            <th style="width:160px">Insumo</th>
            <th style="width:160px">Descripcion</th>
            <th style="width:10px">Precio/uni</th>
            <th style="width:10px">Total</th>

        </tr>
        </thead>
        <tbody>
        @foreach($detalles as $detalle)
            <tr>
                <td style="font-size: 9px">{{$detalle->cantidad}}</td>
                <td style="font-size: 9px">{{$detalle->insumo}}</td>
                <td style="font-size: 9px">{{$detalle->ins_descripcion}}</td>
                <td style="margin-left: 80px; font-size: 9px">$ <?php echo round($detalle->precio,2) ?></td>
                <td style="margin-left: 80px; font-size: 9px">$ <?php echo round($detalle->precio*$detalle->cantidad,2) ?></td>
            </tr>
        @endforeach

        </tbody>
        <tfoot>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>SUBTOTAL</td>
                <td>$ <?php echo round($subtotal->subtotal,2) ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>IVA</td>
                <td>$ <?php echo round((0.13*$subtotal->subtotal),2) ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="total">TOTAL</td>
                <td class="total">$ <?php echo round(($subtotal->subtotal*0.13 + $subtotal->subtotal),2)?></td>
            </tr>
        </tfoot>
    </table>
</div>
<div style="margin-top: 30px">
    <table class="" style="font-family: Tahoma, Helvetica, Arial">
        <thead>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </thead>
        <tbody>
            <tr><td>Aprobado por:</td><td><b>{{$user->nombre}} {{$user->apellido}}</b></td><td style="padding-left: 05px"></td><td>Solicitado por:</td><td><b>{{$solicitante}}</b></td></tr>
            <tr style="margin-top: 50px"><td></td><td></td><td style="padding-left: 25px"></td><td></td><td></td></tr>
            <tr style="margin-top: 50px"><td></td><td></td><td style="padding-left: 25px"></td><td></td><td></td></tr>
            <tr style="margin-top: 50px"><td></td><td></td><td style="padding-left: 25px"></td><td></td><td></td></tr>
            <tr style="margin-top: 50px"><td></td><td></td><td style="padding-left: 25px"></td><td></td><td></td></tr>
            <tr style="margin-top: 50px"><td></td><td></td><td style="padding-left: 25px"></td><td></td><td></td></tr>
            <tr><td>Entregado:</td><td style="border-bottom: solid black 1px"></td><td style="padding-left: 65px"></td><td>Recibido:</td><td style="border-bottom: solid black 1px"></td></tr>
        </tbody>

    </table>
</div>




</body>
</html>