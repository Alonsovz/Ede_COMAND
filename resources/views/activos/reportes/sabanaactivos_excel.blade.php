<table  >
    <thead id="header" class="">
    <tr >
        <th >ID_EMP</th>
        <th >Empleado</th>
        <th >Activo</th>
        <th >Cuenta</th>
        <th >Codigo VNR</th>
        <th >Codigo comanda</th>
        <th >Codigo conta</th>
        <th >Activo</th>
        <th>Color</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Fecha</th>
        <th>CCF</th>
        <th>Proveedor</th>
        <th>Valor</th>
        <th>Area de inversion</th>
        <th>Ubicacion</th>


    </tr>
    </thead>
    <tbody>
    @foreach($activos as $a)
        <tr >

            <td>{{$a->empleado}}</td>
            <td><b>{{$a->nombre}} {{$a->apellido}}</b></td>
            <td>{{$a->tipo_activo}}</td>
            <td>{{$a->cuenta_contable}}</td>
            <td>{{$a->codigo_vnr}}</td>
            <td>{{$a->codigo_comanda}}</td>
            <td>{{$a->codigo_conta}}</td>
            <td>{{$a->color}}</td>
            <td>{{$a->marca}}</td>
            <td>{{$a->modelo}}</td>
            @if($a->fecha)
                <td><?php $fecha = date_create($a->fecha); echo date_format($fecha,'d/m/Y') ?></td>

            @else
                <td>N/A</td>
            @endif
            <td>{{$a->ccf}}</td>
            <td>{{$a->proveedor}}</td>
            <td><b>{{$a->valor}}</b></td>
            <td>{{$a->area_inversion}}</td>
            @if($a->ubicacion)
                <td>{{$a->ubicacion}}</td>
            @else
                <td>Oficina</td>
            @endif


        </tr>

    @endforeach
    </tbody>
    <tfoot id="footer" class="hidden">

    </tfoot>
</table>