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
            font-size: 9px;
        }

        table.minimalistBlack {

            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }
        table.minimalistBlack td, table.minimalistBlack th {

            padding: 5px 4px;
        }
        table.minimalistBlack tbody td {
            font-size: 9px;
        }
        table.minimalistBlack thead {
            background: #CFCFCF;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border: 1px solid #000000;

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

        }
        table.minimalistBlack tfoot {
            font-size: 9px;
            font-weight: bold;
            color: #000000;

        }
        table.minimalistBlack tfoot td {
            font-size: 9px;
        }
    </style>
</head>
<body>

<div style="font-family: Helvetica, Arial, sans-serif">
    <div>
        <img style="" src="C:\xampp\htdocs\COMANDA\public\images\edesal1.png" alt="">
    </div>

    <div style="margin-top: 80px; ">
        <b style="margin-left: 150px;font-size: 20px;">EMPRESA DISTRIBUIDORA ELECTRICA SALVADOREÑA</b>
    </div>

    <div style="margin-top: 10px; ">
        <b style="margin-left: 250px;font-size: 16px;">Reporte de Disponibilidad de herramientas</b>
    </div>
    <div style="margin-top: 10px; ">
        <b style="margin-left: 330px;font-size: 12px;">Fecha: <?php echo date('d/m/Y') ?></b>
    </div>
    <div style="margin-top: 10px; ">

    </div>
</div>
<div style="margin-top: 60px">
    <table class="minimalistBlack" style="font-family: Tahoma, Helvetica, Arial">
        <thead style="border:0.5px solid black" id="header" class="">
        <tr><td><h3>Bodega:</h3></td><td colspan="3"><h3><b>{{$bodega->codigo}}</b></h3></tr>
        <tr style="background-color: lightgrey; color: black;">
            <th style="border:black solid 0.5px; width: 20px">Codigo</th>
            <th style="border:black solid 0.5px; width: 200px">Insumo</th>
            <th style="border:black solid 0.5px; width: 20px">Existencia</th>
            <th style="border:black solid 0.5px; width: 20px">Estado</th>
        </tr>
        </thead>
        <tbody style="border:1px solid black" id="">
        @foreach($insumos as $q)
            <tr>
                <td style="border:black solid 0.5px">{{$q->codigo}}</td>
                <td style="border:black solid 0.5px">{{$q->insumo}}</td>
                <td style="border:black solid 0.5px">{{$q->existencia}}</td>
                <td style="border:black solid 0.5px">{{$q->estado}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>


</body>



</html>