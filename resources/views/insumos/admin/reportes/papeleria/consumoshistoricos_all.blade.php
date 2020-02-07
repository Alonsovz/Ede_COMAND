
<table class="dataTables-example1 table table-hover table-mail dataTables-example " id="tabladetallesinsumos" style="color: black;" >
    <thead id="header" class="">
    <tr style="background-color: lightgrey">
        <th style="border: 1px solid black">Insumo</th>
        <th style="border: 1px solid black">Cantidad</th>
        <th style="border: 1px solid black">Fecha_mov</th>
        <th style="border: 1px solid black">Usuario asignado</th>
        <th style="border: 1px solid black">Centro de costo</th>
        <th style="border: 1px solid black">Descripcion</th>

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
    <tfoot id="footer" class="hidden">
    <tr>

    </tr>
    </tfoot>
</table>