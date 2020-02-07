
<table class="" id="tabladetallesinsumos" >
    <thead id="header" class="">
    <tr>
        <th>Insumo</th>
        <th>Cantidad</th>
        <th>Fecha_mov</th>
        <th>Usuario asignado</th>
        <th>Centro de costo</th>
        <th>Descripcion</th>

    </tr>
    </thead>
    <tbody id="cuerpotabladetalles">
    @foreach($consumos as $c)
        <tr class="dtl">
            <td>{{$c->insumo}}</td>
            <td>{{$c->cantidad_movimiento * -1}}</td>
            <td><?php $fecha = date_create($c->fecha_movimiento); echo date_format($fecha,'d/m/Y') ?></td>
            <td>{{$c->nombreasignado}} {{$c->apellidoasignado}}</td>
            <td>{{$c->centrocosto}}</td>
            <td>{{$c->descripcion}}</td>
        </tr>
    @endforeach
    </tbody>

</table>