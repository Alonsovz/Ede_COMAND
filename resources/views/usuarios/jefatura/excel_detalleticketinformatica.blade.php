

<table id="tbl_kilometrajes" class="" style="color: black;margin-top: 20px; font-size: 12px" >
    <thead id="header" class="">
    <tr style="">
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
            <td>{{$detalle->categoria}}</td>
            <td class="text-center recibidos">{{$detalle->recibidos}}</td>
            <td class="text-center solucionados">{{$detalle->solucionados}}</td>
            <td class="text-center pendientes">{{$detalle->recibidos - $detalle->solucionados}}</td>
            <td class="text-center tiempo">{{$detalle->tiempo_dedicado}}</td>
        </tr>
    @endforeach

    </tbody>

</table>

