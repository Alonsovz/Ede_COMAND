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
            font-size: 10px;
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
            font-size: 10px;
        }
        table.minimalistBlack thead {
            background: #CFCFCF;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border: 1px solid #000000;

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

        }
        table.minimalistBlack tfoot {
            font-size: 10px;
            font-weight: bold;
            color: #000000;

        }
        table.minimalistBlack tfoot td {
            font-size: 10px;
        }
    </style>
</head>
<body>

<div style="font-family: Helvetica, Arial, sans-serif">
    <div>
        <img style="" src="C:\xampp\htdocs\COMANDA\public\images\edesal1.png" alt="">
    </div>

    <div style="margin-top: 80px; ">
        <b style="margin-left: 90px;font-size: 20px;">EMPRESA DISTRIBUIDORA ELECTRICA SALVADOREÑA</b>
    </div>

    <div style="margin-top: 10px; ">
        <b style="margin-left: 175px;font-size: 16px;">Reporte de movimientos de insumos de limpieza</b>
    </div>
    <div style="margin-top: 10px; ">
        <b style="margin-left: 240px;font-size: 12px;">Desde: {{$desde}}   Hasta: {{$hasta}}  </b>
    </div>
    <div style="margin-top: 10px; ">

    </div>
</div>
<div style="margin-top: 60px">
    <table class="minimalistBlack" style="font-family: Tahoma, Helvetica, Arial">
        <thead>
        <tr><td>CC:</td><td><b style="font-size: 12px;">{{$ccnombre->nombre}}</b></td><td></td><td></td><td></td><td></td></tr>
        <tr style="border:black solid 0.5px">
            <th style="width: 10px; border:black solid 0.5px">Codigo</th>
            <th style="width:350px; border:black solid 0.5px">Insumo</th>
            <th style="width:10px; border:black solid 0.5px">Cant_inicial</th>
            <th style="width:10px; border:black solid 0.5px">Cant_adquirida</th>
            <th style="width:10px; border:black solid 0.5px">Cant_consumida</th>
            <th style="width:10px; border:black solid 0.5px">Cant_final</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0; $i<count($queryrun); $i++)



            <tr>
                <td style="border:black solid 0.5px; padding-left: 20px">{{$queryrun[$i]->codigo}}</td>
                <td style="border:black solid 0.5px">{{$queryrun[$i]->insumo}}</td>
                <td style="border:black solid 0.5px">{{$queryrun[$i]->cant_ini}}</td>
                <td style="border:black solid 0.5px; padding-left: 20px">{{$queryrun[$i]->cant_adquirida}}</td>
                <td style="border:black solid 0.5px; padding-left: 20px">{{$queryrun[$i]->cant_consumida}}</td>
                <td style="border:black solid 0.5px; padding-left: 20px">
                    {{$queryrun[$i]->cant_ini+$queryrun[$i]->cant_adquirida-$queryrun[$i]->cant_consumida}}
                </td>
            </tr>
        @endfor
        </tbody>
        <tfoot>

        </tfoot>
    </table>

</div>
{{--
<script type="text/php">
    if ( isset($pdf) ) {
        $font = Font_Metrics::get_font("arial", "normal")
        $pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
    }
</script>--}}


</body>



</html>