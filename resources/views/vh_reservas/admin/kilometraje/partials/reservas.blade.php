<table id="tbl_kilometrajes" class="dataTables-example1 table table-hover  table-mail dataTables-example" style="color: black;margin-top: 20px; font-size: 11px; " >
    <thead id="header" class="">
    <tr style="background-color: lightcyan">
        <th class="text-center" style="border: solid 1px grey;">ID</th>
        <th class="text-center" style="border: solid 1px grey;">Vehiculo</th>
        <th class="text-center" style="border: solid 1px grey;">Empleado</th>
        <th class="text-center" style="border: solid 1px grey;">Motivo</th>
        <th class="text-center" style="border: solid 1px grey;">Accion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($res as $v)
        <tr>
            <td class="text-center" style="border: solid 1px grey;"><b>{{$v->id}}</b></td>
            <td class="text-center" style="border: solid 1px grey;"><b>{{$v->vehiculo}}</b></td>
            <td style="border: solid 1px grey;"><b>{{$v->empleado}}</b></td>
            <td style="border: solid 1px grey;"><b>{{$v->motivo}}</b></td>
            <td class="text-center" style="border: solid 1px grey;"><b><button id="{{$v->id}}" class="btn btn-success btn-xs btn_adjuntarreserva" type="button"><i class="fa fa-paperclip"></i> Seleccionar</button></b></td>
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

<script>
    $('.btn_adjuntarreserva').click(function(){
       $('#txt_reseva').val(this.id);
        $('#divreservas').empty();

    });


</script>
