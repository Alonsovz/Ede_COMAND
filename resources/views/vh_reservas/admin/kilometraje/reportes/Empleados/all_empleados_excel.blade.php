


<table style="border: 0.5px solid black;color: black" class="dataTables-example1 table  table-bordered table-mail dataTables-example" >
    <thead style="border:0.5px solid black" id="header" class="">
    <tr style="background-color: lightgrey; color: black;">
        <th class="text-center" style="border:black solid 0.5px; width: 20px">Empleado</th>
        <th class="text-center" style="border:black solid 0.5px; width: 50px">Km recorridos</th>
        <th class="text-center" style="border:black solid 0.5px; width: 20px">Galones cargados</th>
        <th class="text-center" style="border:black solid 0.5px; width: 20px">Costo cargado</th>
        <th class="text-center" style="border:black solid 0.5px; width: 20px">Horas de uso</th>
    </tr>
    </thead>
    <tbody style="border:1px solid black" id="">
    @foreach($query as $q)
        <tr>
            <td  class="text-left" style="border:black solid 0.5px;"><b>{{$q->Empleado}}</b></td>
            <td class="text-center" style="border:black solid 0.5px">{{$q->km_recorridos}}</td>
            <td class="text-center" style="border:black solid 0.5px">{{$q->galones_cargados}}</td>
            <td class="text-right" style="border:black solid 0.5px"><b>$ {{$q->costo_cargado}}</b></td>
            <td class="text-center" style="border:black solid 0.5px"><b>{{$q->horas_uso}}</b></td>
        </tr>
    @endforeach
    </tbody>
    <tfoot id="footer" class="hidden">

    </tfoot>
</table>




