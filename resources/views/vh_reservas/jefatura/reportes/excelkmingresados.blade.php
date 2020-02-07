

<table id="tbl_kilometrajes" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 20px; font-size: 11px" >
    <thead id="header" class="">
    <tr style="">
        <th class="text-center" style="border: solid 1px grey;">ID</th>
        <th class="text-center" style="border: solid 1px grey;">Vehiculo</th>
        <th class="text-center" style="border: solid 1px grey;">Empleado</th>
        <th class="text-center" style="border: solid 1px grey;">Hoja de Reserva</th>
        <th class="text-center" style="border: solid 1px grey;">Motivo</th>
        <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-calendar"></i> <br>Inicio</th>
        <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-calendar"></i> <br>Fin</th>
        <th class="text-center" style="border: solid 1px grey;">Km inicial</th>
        <th class="text-center" style="border: solid 1px grey;">Km Final</th>
        <th class="text-center" style="border: solid 1px grey;">Galones</th>
        <th class="text-center" style="border: solid 1px grey;">Costo ($)</th>
        <th class="text-center" style="border: solid 1px grey;">Num. Recibo</th>
        <th class="text-center" style="border: solid 1px grey;">Hora de creacion</th>



    </tr>
    </thead>
    <tbody>

    @foreach($kilometrajes as $k)
        {{--Realizamos la diferencia entre las fechas para mostrar un formato segun indicadores--}}
        @php
            $fecha1 = new DateTime($k->fecha_creacion);

            $hora = $fecha1->format('H:i');

        @endphp


            <tr style="">
                <td style="border: solid 1px grey; "><b>{{$k->id}}</b></td>
                <td class="text-center" style="border: solid 1px grey;">{{$k->vehiculo}}</td>
                <td style="border: solid 1px grey;"><b>{{$k->nombreempleado}} {{$k->apellidoempleado}}</b></td>
                @if($k->reserva=='')
                    <td class="text-center" style="border: solid 1px grey;">N/A</td>
                @else
                    <td class="text-center" style="border: solid 1px grey;">{{$k->reserva}}</td>
                @endif
                <td style="border: solid 1px grey;">{{$k->trabajo_realizado}}</td>
                <td class="text-center" style="border: solid 1px grey;"><?php $fecha = date_create($k->horario_inicio); echo date_format($fecha,'d/m/Y H:i') ?></td>
                <td class="text-center" style="border: solid 1px grey;"><?php $fecha = date_create($k->horario_fin); echo date_format($fecha,'d/m/Y H:i') ?></td>
                <td class="" style="border: solid 1px grey;">{{$k->km_inicial}}</td>
                <td class="" style="border: solid 1px grey;">{{$k->km_final}}</td>
                <td class="text-center" style="border: solid 1px grey;">{{$k->galones_cargados}}</td>
                @if($k->costo_cargado=='')
                    <td style="border: solid 1px grey;"><b></b></td>
                @else
                    <td style="border: solid 1px grey;"><b>${{$k->costo_cargado}}</b></td>
                @endif
                <td style="border: solid 1px grey;">{{$k->num_recibo}}</td>
                <td style="border: solid 1px grey;"><?php $fecha = date_create($k->fecha_creacion); echo date_format($fecha,'d/m/Y H:i') ?></td>

            </tr>


    @endforeach
    </tbody>
    <tfoot id="footer" class="hidden">
    <tr>

    </tr>
    </tfoot>
</table>










