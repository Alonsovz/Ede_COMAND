<link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">

<br>
<table style="border: 0.5px solid black;color: black" class="dataTables-example1 table  table-bordered table-mail dataTables-example" >
    <thead style="border:0.5px solid black" id="header" class="">
    <tr style="background-color: lightgrey; color: black;">
        <th class="text-center" style="border:black solid 0.5px; width: 20px">Equipo</th>
        <th class="text-center" style="border:black solid 0.5px; width: 50px">Placa</th>
        <th class="text-center" style="border:black solid 0.5px; width: 20px">Galones_Cargados</th>
        <th class="text-center" style="border:black solid 0.5px; width: 20px">Costo_Cargado</th>
        <th class="text-center" style="border:black solid 0.5px; width: 20px">Km_recorridos</th>
    </tr>
    </thead>
    <tbody style="border:1px solid black" id="">
        @foreach($query as $q)
            <tr>
                <td  class="text-center" style="border:black solid 0.5px; background-color: lightskyblue"><b>{{$q->Equipo}}</b></td>
                <td class="text-center" style="border:black solid 0.5px">{{$q->Placa}}</td>
                <td class="text-center" style="border:black solid 0.5px">{{$q->Galones_cargados}}</td>
                <td class="text-right" style="border:black solid 0.5px"><b>$ {{$q->Cost_cargado}}</b></td>
                <td class="text-center" style="border:black solid 0.5px"><b>{{$q->Km_recorridos}}</b></td>
            </tr>
        @endforeach
    </tbody>
    <tfoot id="footer" class="hidden">
    <tr>
        <th>Rendering engine</th>
        <th>Browser</th>
        <th>Platform(s)</th>
        <th>Platform(s)</th>


    </tr>
    </tfoot>
</table>


<script src="../js/plugins/dataTables/datatables.min.js"></script>
<script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>


