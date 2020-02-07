
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



    @for($i=0; $i<count($queryrun); $i++)



        <tr>
            <td style="border:black solid 0.5px; padding-left: 20px">{{$queryrun[$i]->codigo}}</td>
            <td style="border:black solid 0.5px">{{$queryrun[$i]->insumo}}</td>
            <td style="border:black solid 0.5px">{{$queryrun[$i]->cant_ini}}</td>
            <td style="border:black solid 0.5px; padding-left: 20px">{{$queryrun[$i]->cant_adquirida}}</td>
            <td style="border:black solid 0.5px; padding-left: 20px">{{$queryrun[$i]->cant_consumida}}</td>
            <td style="border:black solid 0.5px; padding-left: 20px">
                {{$queryrun[$i]->cant_ini+$queryrun[$i]->cant_adquirida-$queryrun[$i]->cant_consumida}}
            </td>

        </tr>
    @endfor
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
<script type="text/php">

</script>
<script src="../js/plugins/dataTables/datatables.min.js"></script>
<script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>