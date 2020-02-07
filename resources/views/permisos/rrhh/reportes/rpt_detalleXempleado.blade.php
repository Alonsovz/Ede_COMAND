<link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">



<table class=" table-responsive table table-hover ">
    <thead id="header" class="">
    <tr style="background-color: lightgrey">
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="3" style="font-size: 16px"><strong>{{$empleado}}</strong></td>
    </tr>
    @foreach($tipos as $tipo)
        <tr class="hidden"><td class="hidden">{{$conteo=0}}</td></tr>
        <tr><td></td><td colspan="2" style="font-size: 14px; color:blue; border-bottom: solid 2px black"><strong>{{$tipo->tipo}}</strong></td></tr>
        <tr><td></td><td><b>Fecha inicio</b></td><td><b>Fecha fin</b></td></tr>
        @for($i=0; $i<=count($detalles)-1; $i++)
            @if($tipo->tipo==$detalles[$i]->tipo_permiso)
                <tr>
                    <td></td>
                    <td style="font-size: 12px">
                        {{$detalles[$i]->inicio}}
                    </td>
                    <td style="font-size: 12px">
                        {{$detalles[$i]->fin}}
                    </td>
                </tr>
                <b class="hidden">{{$conteo++}}</b>
            @endif

        @endfor
        <tr ><td></td><td style="background-color: lightskyblue"><b>Total</b> {{$conteo}}</td><td></td></tr>

    @endforeach
    </tbody>
    <tfoot id="footer" class="hidden">

    </tfoot>
</table>


<script src="../js/plugins/dataTables/datatables.min.js"></script>

<!--funciones para el lenguaje de las datatables-->
<script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>