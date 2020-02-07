<!doctype html>
<html lang="en">
<head>

    <title></title>

    <style>

        body{
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        }

        table.minimalistBlack1 {
            border: 1px solid #000000;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }
        table.minimalistBlack1 td, table.minimalistBlack1 th {
            border:1px solid black;
            padding: 5px 4px;
        }
        table.minimalistBlack1 tbody td {
            font-size: 11px;
        }
        table.minimalistBlack1 thead {
            background: #CFCFCF;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.minimalistBlack1 thead th {
            font-size: 11px;
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
        table.minimalistBlack1 tfoot {
            border:none;
            font-size: 11px;
            font-weight: bold;
            color: #000000;

        }
        table.minimalistBlack1 tfoot td {
            border: none;
            font-size: 11px;
        }



        table.minimalistBlack {
            border: 1px solid #000000;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }
        table.minimalistBlack td, table.minimalistBlack th {

            padding: 5px 4px;
        }
        table.minimalistBlack tbody td {
            font-size: 11px;
        }
        table.minimalistBlack thead {
            background: #CFCFCF;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.minimalistBlack thead th {
            font-size: 11px;
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
            font-size: 11px;
            font-weight: bold;
            color: #000000;
            border-top: 1px solid #000000;
        }
        table.minimalistBlack tfoot td {
            font-size: 11px;
        }
    </style>
</head>
<body>
<p style="font-family: Tahoma, Helvetica, Arial"><img  src="C:\xampp\htdocs\COMANDA\public\images\edesal1.png" alt=""></p>
<p style="font-family: font-family: Tahoma, Helvetica, Arial"><b style="font-size: 25px; margin-left: 275px">MIS ACTIVOS</b></p>


<div>
    <h5><b style="font-family: Tahoma, Helvetica, Arial">Listado de activos asignados a la fecha</b></h5>
    <h5 style="font-weight: 100"><b style="font-family: Tahoma, Helvetica, Arial">Usuario:</b> {{$usuario->nombre}} {{$usuario->apellido}}</h5>
    <h5 style="font-weight: 100"><b style="font-family: Tahoma, Helvetica, Arial">Fecha de impresion:</b> <?php echo date('d/m/Y H:i') ?></h5>
    <table id="tbl_kilometrajes" class="" style="color: black;margin-top: 20px; font-size: 12px;" >
        <thead id="header" class="">
        <tr style="background-color: lightgrey">
            <th class="text-center" style="border: solid 1px grey;">Activo</th>
            <th class="text-center" style="border: solid 1px grey;">Marca</th>
            <th class="text-center" style="border: solid 1px grey;">Modelo</th>
            <th class="text-center" style="border: solid 1px grey;">Color</th>
            <th class="text-center" style="border: solid 1px grey;">Ubicacion</th>
            <th class="text-center" style="border: solid 1px grey;">Fecha</th>

        </tr>
        </thead>
        <tbody>
        @foreach($activos as $a)
            <tr style="">
                <td style="border: solid 1px grey; width: 250px ">{{$a->tipo_activo}}</td>
                <td class="text-center" style="border: solid 1px grey;width: 100px">{{$a->marca}}</td>
                <td class="text-center" style="border: solid 1px grey;width: 150px">{{$a->modelo}}</td>
                <td class="text-center" style="border: solid 1px grey;width: 50px">{{$a->color}}</td>
                <td class="text-center" style="border: solid 1px grey;width: 100px">{{$a->ubicacion}}</td>
                @if($a->fecha)
                    <td class="text-center" style="border: solid 1px grey;width: 20px"><?php $fecha = date_create($a->fecha); echo date_format($fecha,'d/m/Y') ?></td>
                @else
                    <td class="text-center" style="border: solid 1px grey;width: 20px">N/A</td>
                @endif

            </tr>

        @endforeach
        </tbody>

    </table>
</div>


</body>
</html>