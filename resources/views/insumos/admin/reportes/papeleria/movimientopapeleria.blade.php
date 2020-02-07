
<link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">

<table style="border: 0.5px solid black;color: black" class="dataTables-example1 table  table-bordered table-mail dataTables-example" >
    <thead style="border:0.5px solid black" id="header" class="">
    <tr style="background-color: lightgrey; color: black;">
        <th style="border:black solid 0.5px">Codigo</th>
        <th style="border:black solid 0.5px">Insumo</th>
        <th style="border:black solid 0.5px">Cant_inicial</th>
        <th style="border:black solid 0.5px">Cant_adquirida</th>
        <th style="border:black solid 0.5px">Cant_consumida</th>
        <th style="border:black solid 0.5px">Cant_final</th>

    </tr>
    </thead>
    <tbody style="border:1px solid black" id="">
        {{--php variable--}}

        @foreach($queryrun as $q)
                <tr>
                    <td style="border:black solid 0.5px">{{$q->codigo}}</td>
                    <td style="border:black solid 0.5px">{{$q->insumo}}</td>
                    <td style="border:black solid 0.5px">{{$q->cant_ini}}</td>
                    <td style="border:black solid 0.5px">{{$q->cant_adquirida}}</td>
                    <td style="border:black solid 0.5px">{{$q->cant_consumida}}</td>
                    <td style="border:black solid 0.5px">{{$q->cant_adquirida+$q->cant_ini-$q->cant_consumida}}</td>
                </tr>

            @endforeach
    </tbody>
    <tfoot id="footer" class="hidden">
    <tr>
        <th>Rendering engine</th>
        <th>Browser</th>
        <th>Platform(s)</th>
        <th>Engine version</th>
        <th>CSS grade</th>
    </tr>
    </tfoot>
</table>

<script src="../js/plugins/dataTables/datatables.min.js"></script>
<script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>