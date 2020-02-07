

<table id="tbl_kilometrajes" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 20px; font-size: 12px" >
    <thead id="header" class="">
    <tr style="background-color: lightgrey">
        <th class="text-center" style="border: solid 1px grey;">Categoria</th>
        <th class="text-center" style="border: solid 1px grey;">Recibidos</th>
        <th class="text-center" style="border: solid 1px grey;">Solucionados</th>
        <th class="text-center" style="border: solid 1px grey;">Pendientes</th>
        <th class="text-center" style="border: solid 1px grey;">Tiempo dedicado</th>
    </tr>
    </thead>
    <tbody>
        @foreach($detalles as $detalle)
            <tr>
                @if($detalle->categoria)
                    <td>{{$detalle->categoria}}</td>
                    @else
                    <td style="background-color: coral"><b><i class="fa fa-info-circle"></i> Sin categoria</b></td>
                @endif
                <td class="text-center recibidos">{{$detalle->recibidos}}</td>
                <td class="text-center solucionados">{{$detalle->solucionados}}</td>
                <td class="text-center pendientes">{{$detalle->recibidos - $detalle->solucionados}}</td>
                @if($detalle->tiempo_dedicado)
                        <td class="text-center tiempo">{{$detalle->tiempo_dedicado}}</td>
                    @else
                        <td class="text-center tiempo">0</td>
                @endif
            </tr>
        @endforeach

    </tbody>
    <tfoot id="footer" class="">
    <tr>
        <th style="border: solid 1px grey;" >Totales</th>
        <th style="border: solid 1px grey;" class="text-center" id="sum_recibidos"></th>
        <th style="border: solid 1px grey;" class="text-center" id="sum_solucionados"></th>
        <th style="border: solid 1px grey;" class="text-center" id="sum_pendientes"></th>
        <th style="border: solid 1px grey;" class="text-center" id="sum_tiempo"></th>
    </tr>
    </tfoot>
</table>

<script>
    var sumarecibidos = 0;
    var sumasolucionados = 0;
    var sumapendientes = 0;
    var sumatiempo = 0;

    $('.recibidos').each(function(){
        var valor = parseFloat($(this).text());
        sumarecibidos += valor;
    });

    $('.solucionados').each(function(){
        var valor = parseFloat($(this).text());
        sumasolucionados += valor;
    });

    $('.pendientes').each(function(){
        var valor = parseFloat($(this).text());
        sumapendientes += valor;
    });

    $('.tiempo').each(function(){
        var valor = parseFloat($(this).text());
        sumatiempo += valor;
    });

    $('#sum_recibidos').append(sumarecibidos);
    $('#sum_solucionados').append(sumasolucionados);
    $('#sum_pendientes').append(sumapendientes);
    $('#sum_tiempo').append(sumatiempo);


</script>