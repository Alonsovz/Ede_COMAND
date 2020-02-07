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
        <b style="margin-left: 250px;font-size: 16px;">Reporte de costos para insumos de limpieza</b>
    </div>
    <div style="margin-top: 10px; ">
        <b style="margin-left: 310px;font-size: 12px;">Desde: {{$desde}}   Hasta: {{$hasta}}  </b>
    </div>
    <div style="margin-top: 10px; ">

    </div>
</div>
<div style="margin-top: 60px">
    <table class="minimalistBlack" style="font-family: Tahoma, Helvetica, Arial">
        <thead style="border:0.5px solid black" id="header" class="">
        <tr><td><h3>CC:</h3></td><td><h3><b>{{$ccnombre->nombre}}</b></h3></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        <tr style="background-color: lightgrey; color: black;">
            <th style="border:black solid 0.5px;width: 10px ">Código</th>
            <th style="border:black solid 0.5px; width: 300px">Insumo</th>
            <th style="border:black solid 0.5px; width: 10px">Cant_inicial</th>
            <th style="border:black solid 0.5px; width: 10px">Costo_ini</th>
            <th style="border:black solid 0.5px; width: 10px">Cant_adquirida</th>
            <th style="border:black solid 0.5px; width: 10px">Costo_adq</th>
            <th style="border:black solid 0.5px; width: 10px">Cant_consumida</th>
            <th style="border:black solid 0.5px; width: 10px">Costo_consu</th>
            <th style="border:black solid 0.5px; width: 10px">Cant_final</th>
            <th style="border:black solid 0.5px; width: 10px">Costo_fin</th>
        </tr>
        </thead>
        <tbody style="border:1px solid black" id="">
        @for($i=0; $i<count($movimientos); $i++)
            <tr>
                <td style="border:black solid 0.5px;width: 10px ">{{$movimientos[$i]->codigo}}</td>
                <td style="border:black solid 0.5px;width: 300px ">{{$movimientos[$i]->insumo}}</td>
                @if(count($cant_ini)>0)
                    <td style="border:black solid 0.5px; width: 10px; padding-left: 20px">
                        {{Busqueda::busqueda_secuencial($cant_ini,count($cant_ini),$movimientos[$i]->codigo)}}
                    </td>
                    <td style="border:black solid 0.5px;width: 10px; padding-left: 20px ">
                        <b>
                            $ {{
                        Busqueda::busquedaCodPrecio($cant_ini,$precios_cant_ini,count($precios_cant_ini),$movimientos[$i]->codigo)
                        }}
                        </b>
                    </td>
                @else
                    <td style="border:black solid 0.5px; width: 10px; padding-left: 20px">
                        0
                    </td>
                    <td style="border:black solid 0.5px; width: 10px; padding-left: 20px">
                        <b>
                            $ 0
                        </b>
                    </td>
                @endif
                <td style="border:black solid 0.5px;width: 10px; padding-left: 20px ">{{$movimientos[$i]->cant_adquirida}}</td>
                <td style="border:black solid 0.5px;width: 10px; padding-left: 20px ">
                    <b>
                        $ {{Busqueda::busqueda_precio_adq($precios_cant_adq,count($precios_cant_adq),$movimientos[$i]->codigo,$movimientos[$i]->cant_adquirida)}}

                    </b>
                </td>
                <td style="border:black solid 0.5px;width: 10px; padding-left: 20px ">{{$movimientos[$i]->cant_consumida}}</td>
                <td style="border:black solid 0.5px;width: 10px; padding-left: 20px ">
                    <b>
                        $ {{Busqueda::busqueda_costo_consumido($precios_cant_adq,$precios_cant_ini,count($precios_cant_adq),$movimientos[$i]->codigo,$movimientos[$i]->cant_consumida)}}
                    </b>
                </td>
                @if(count($cant_ini)>0)
                    <td style="border:black solid 0.5px; padding-left: 20px">
                        {{Busqueda::busqueda_secuencial($cant_ini,count($cant_ini),$movimientos[$i]->codigo) + $movimientos[$i]->cant_adquirida - $movimientos[$i]->cant_consumida}}
                    </td>
                    <td style="border:black solid 0.5px;width: 10px; padding-left: 20px ">
                        <b>$ {{
                        (Busqueda::busqueda_secuencial($cant_ini,count($cant_ini),$movimientos[$i]->codigo) + $movimientos[$i]->cant_adquirida - $movimientos[$i]->cant_consumida)
                        *Busqueda::b_costo_consumido($precios_cant_adq,$precios_cant_ini,count($precios_cant_adq),$movimientos[$i]->codigo,$movimientos[$i]->cant_consumida)
                    }}</b>
                    </td>
                @else
                    <td style="border:black solid 0.5px; padding-left: 20px">
                        {{$movimientos[$i]->cant_adquirida - $movimientos[$i]->cant_consumida}}
                    </td>
                    <td style="border:black solid 0.5px;width: 10px; padding-left: 20px ">$ 0</td>
                @endif

            </tr>
        @endfor
        </tbody>
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