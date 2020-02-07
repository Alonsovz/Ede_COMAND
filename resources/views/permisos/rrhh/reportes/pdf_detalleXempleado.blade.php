
<html>
<head>

    <title></title>
    <style>
        body{
            font-family: Verdana, Arial, sans-serif;
            font-size: 11px;
        }
    </style>
</head>
<body>
<div style="margin-bottom: 50px">
    <img  src="C:\xampp\htdocs\COMANDA_PROD\public\images\edesal1.png" alt="">
</div>
<p>Impresion: <?php echo date('d/m/Y H:i'). ' via COMANDA'; ?></p>
<div style="position: absolute" >
    <table width="100%">
        <thead id="header" class="">
        <tr style="background-color: lightgrey; border-bottom: solid 3px lightgrey" >
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="3" style="font-size: 16px"><strong>{{$empleado}}</strong></td>
        </tr>
        @foreach($tipos as $tipo)
            <?php $conteo=0; ?>
            <tr><td></td><td  colspan="2" style="font-size: 14px; color:black; border-bottom: solid 2px black; background-color: lightgrey"><strong>{{$tipo->tipo}}</strong></td></tr>
            <tr><td></td><td><b>Fecha inicio</b></td><td><b>Fecha fin</b></td></tr>
            @for($i=0; $i<=count($detalles)-1; $i++)
                @if($tipo->tipo==$detalles[$i]->tipo_permiso)
                    <tr>
                        <td></td>
                        <td style="font-size: 12px">
                            {{$detalles[$i]->inicio}}
                        </td>
                        <td style="font-size: 12px">
                            {{$detalles[$i]->fin}}
                        </td>
                    </tr>
                        <?php $conteo++; ?>
                @endif

            @endfor
            <tr><td></td><td style="background-color: lightskyblue"><b>Total</b> {{$conteo}}</td></tr>

        @endforeach
        </tbody>
        <tfoot id="footer" class="hidden">

        </tfoot>
    </table>
</div>

</body>
</html>


