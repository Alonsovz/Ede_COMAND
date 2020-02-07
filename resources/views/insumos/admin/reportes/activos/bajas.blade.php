<link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">

<table style="border: 0.5px solid black;color: black" class="dataTables-example1 table  table-bordered table-mail dataTables-example" >
    <thead style="border:0.5px solid black" id="header" class="">
    <tr style="background-color: lightgrey; color: black;">
        <th style="border:black solid 0.5px; width: 20px">Codigo</th>
        <th style="border:black solid 0.5px; width: 200px">Insumo</th>
        <th style="border:black solid 0.5px; width: 20px">Cantidad</th>
        <th style="border:black solid 0.5px; width: 20px">Usuario Asignado</th>
        <th style="border:black solid 0.5px; width: 20px">Fecha de baja</th>

    </tr>
    </thead>
    <tbody style="border:1px solid black" id="">
    {{--php variable--}}

    @foreach($bajas as $q)
        @if($q->estado==3)
        <tr>
            <td style="border:black solid 0.5px">{{$q->codigo}}</td>
            <td style="border:black solid 0.5px">{{$q->insumo}}</td>
            <td style="border:black solid 0.5px">{{$q->cantidad}}</td>
            <td style="border:black solid 0.5px">{{$q->electricista}}</td>
            @if($q->fecha_baja=='')
                <td style="border:black solid 0.5px"><n>No establecida</n></td>
            @else
                <td style="border:black solid 0.5px">
                    <?php
                        $fecha  = date_create($q->fecha_baja);
                        echo date_format($fecha,'d/m/Y');
                    ?>
                </td>
            @endif

        </tr>
        @endif
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

