<i class="fa fa-info-circle"></i>
Actualmente ya cuenta con este insumo y se encuentra activo en su bodega, favor dar de baja o pedir autorizacion para tener en existencia uno mas
<br><br>
<table class="dataTables-example1 table table-hover table-mail dataTables-example" id="tabladetalles" >
    <thead id="header" class="">
    <tr>
        <th style="border:black solid 1px">Codigo</th>
        <th style="border:black solid 1px">Insumo</th>
        <th style="border:black solid 1px">Usuario</th>
        <th style="border:black solid 1px">Estado</th>
        <th style="border:black solid 1px"></th>

    </tr>
    </thead>
    <tbody>
    @foreach($detalles as $detalle)
        <tr>

            <td style="border:black solid 1px">{{$detalle->codigo}}</td>
            <td style="border:black solid 1px">{{$detalle->insumo}}</td>
            <td style="border:black solid 1px">{{$detalle->electricista}}</td>
            <td style="border:black solid 1px">{{$detalle->estado}}</td>
            <td style="border:black solid 1px">
                @if($detalle->estado=='Arruinado' || $detalle->estado=='Deteriorado' )
                    <button class="btn btn-outline btn-success btn-xs btn_iniciarbaja" id="{{$detalle->hoja_activo_id}}" type="button">
                        <i class="fa fa-download"></i> Iniciar baja
                    </button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot id="footer" class="hidden">
    <tr>
        <th>Codigo</th>
        <th>Insumo</th>
        <th>Sin asignar</th>
        <th>Estado</th>
        <th>Acccion</th>
    </tr>
    </tfoot>
</table>

<script src="../js/funciones/detallesbodega.js"></script>