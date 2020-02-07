

<table style="border: 0.5px solid black;color: black" class="dataTables-example1 table  table-bordered table-mail dataTables-example" >
    <thead style="border:0.5px solid black" id="header" class="">
    <tr style="">
        <th style="border:black solid 0.5px; width: 20px">Auxiliar</th>
        <th style="border:black solid 0.5px; width: 20px">HA</th>
        <th style="border:black solid 0.5px; width: 50px">Insumo</th>
        <th style="border:black solid 0.5px; width: 20px">Estado</th>
        <th style="border:black solid 0.5px; width: 20px">Actualizacion</th>
        <th style="border:black solid 0.5px; width: 20px">Usuario</th>
    </tr>
    </thead>
    <tbody style="border:1px solid black" id="">
    {{--php variable--}}

    @foreach($cambios as $q)

        <tr>
            <td style="border:black solid 0.5px">{{$q->cod_aux}}</td>
            <td style="border:black solid 0.5px">{{$q->hoja_activo_id}}</td>
            <td style="border:black solid 0.5px">{{$q->insumo}}</td>
            <td style="border:black solid 0.5px">{{$q->estado}}</td>
            @if($q->fecha_actualizacion=='')
                <td style="border:black solid 0.5px"><n>No establecida</n></td>
            @else
                <td style="border:black solid 0.5px">
                    <?php
                    $fecha  = date_create($q->fecha_actualizacion);
                    echo date_format($fecha,'d/m/Y H:i');
                    ?>
                </td>
            @endif
            <td style="border:black solid 0.5px">{{$q->nombre}} {{$q->apellido}}</td>

        </tr>

    @endforeach
    </tbody>

</table>


