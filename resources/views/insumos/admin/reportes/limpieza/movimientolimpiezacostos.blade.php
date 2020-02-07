
<link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">


<table style=" font-size: 11px; border: 0.5px solid black;color: black" class="dataTables-example1 table table-responsive  table-bordered table-mail dataTables-example" >
    <thead style="border:0.5px solid black" id="header" class="">
    <tr style="background-color: lightgrey; color: black;">
        <th style="border:black solid 0.5px;width: 10px ">Código</th>
        <th style="border:black solid 0.5px; width: 300px">Insumo</th>
        <th style="border:black solid 0.5px; width: 10px">Cant_inicial</th>
        <th style="border:black solid 0.5px; width: 10px">Costo_ini</th>
        <th style="border:black solid 0.5px; width: 10px">Cant_adquirida</th>
        <th style="border:black solid 0.5px; width: 10px">Costo_adq</th>
        <th style="border:black solid 0.5px; width: 10px">Cant_consumida</th>
        <th style="border:black solid 0.5px; width: 10px">Costo_consu</th>
        <th style="border:black solid 0.5px; width: 10px">Cant_final</th>
        <th style="border:black solid 0.5px; width: 10px">Costo_fin</th>
    </tr>
    </thead>
    <tbody style="border:1px solid black" id="">
       @for($i=0; $i<count($movimientos); $i++)
        <tr>
            <td style="border:black solid 0.5px;width: 10px ">{{$movimientos[$i]->codigo}}</td>
            <td style="border:black solid 0.5px;width: 300px ">{{$movimientos[$i]->insumo}}</td>
            @if(count($cant_ini)>0)
                <td style="border:black solid 0.5px; width: 10px; padding-left: 20px">
                    {{Busqueda::busqueda_secuencial($cant_ini,count($cant_ini),$movimientos[$i]->codigo)}}
                </td>
                <td style="border:black solid 0.5px;width: 10px ">
                   <b>
                       $ {{
                        Busqueda::busquedaCodPrecio($cant_ini,$precios_cant_ini,count($precios_cant_ini),$movimientos[$i]->codigo)
                        }}
                   </b>
                </td>
                @else
                <td style="border:black solid 0.5px; width: 10px; padding-left: 20px">
                    0
                </td>
                <td style="border:black solid 0.5px; width: 10px; padding-left: 20px">
                   <b>
                       $ 0
                   </b>
                </td>
            @endif
            <td style="border:black solid 0.5px;width: 10px ">{{$movimientos[$i]->cant_adquirida}}</td>
            <td style="border:black solid 0.5px;width: 10px ">
                <b>
                    $ {{Busqueda::busqueda_precio_adq($precios_cant_adq,count($precios_cant_adq),$movimientos[$i]->codigo,$movimientos[$i]->cant_adquirida)}}

                </b>
            </td>
            <td style="border:black solid 0.5px;width: 10px ">{{$movimientos[$i]->cant_consumida}}</td>
            <td style="border:black solid 0.5px;width: 10px ">
                <b>
                    $ {{Busqueda::busqueda_costo_consumido($precios_cant_adq,$precios_cant_ini,count($precios_cant_adq),$movimientos[$i]->codigo,$movimientos[$i]->cant_consumida)}}
                </b>
            </td>
            @if(count($cant_ini)>0)
                <td style="border:black solid 0.5px; padding-left: 20px">
                    {{Busqueda::busqueda_secuencial($cant_ini,count($cant_ini),$movimientos[$i]->codigo) + $movimientos[$i]->cant_adquirida - $movimientos[$i]->cant_consumida}}
                </td>
                <td style="border:black solid 0.5px;width: 10px ">
                    <b>$ {{
                        (Busqueda::busqueda_secuencial($cant_ini,count($cant_ini),$movimientos[$i]->codigo) + $movimientos[$i]->cant_adquirida - $movimientos[$i]->cant_consumida)
                        *Busqueda::b_costo_consumido($precios_cant_adq,$precios_cant_ini,count($precios_cant_adq),$movimientos[$i]->codigo,$movimientos[$i]->cant_consumida)
                    }}</b>
                </td>
            @else
                <td style="border:black solid 0.5px; padding-left: 20px">
                    {{$movimientos[$i]->cant_adquirida - $movimientos[$i]->cant_consumida}}
                </td>
                <td style="border:black solid 0.5px;width: 10px ">$ 0</td>
            @endif

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