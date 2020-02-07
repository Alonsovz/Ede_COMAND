
<div class="col-md-8">
    <table id="tbl_kilometrajes" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 50px; " >
        <thead id="header" class="">
        <tr style="background-color: lightgrey">
            <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-user"></i> Empleado</th>
            <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-ticket"></i> Requerimientos</th>
            <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-ticket"></i> Incidencias</th>
            <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-ticket"></i> Actualizacion DB</th>
            <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-ticket"></i> Proyectos</th>
            <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-ticket"></i> Total</th>

        </tr>
        </thead>
        <tbody>
        @foreach($detalles as $detalle)
            <tr>
                <td style="border: solid 1px black; width: 200px " class="text-left "><b>{{$detalle->nombre}} {{$detalle->apellido}}</b></td>
                <td style="border: solid 1px black; width: 75px " class="text-center "><b>{{$detalle->requerimientos}}</b></td>
                <td style="border: solid 1px black; width: 75px " class="text-center "><b>{{$detalle->incidencias}}</b></td>
                <td style="border: solid 1px black; width: 75px " class="text-center "><b>{{$detalle->actualizacion_db}}</b></td>
                <td style="border: solid 1px black; width: 75px " class="text-center "><b>{{$detalle->proyectos}}</b></td>
                <td style="border: solid 1px black; width: 75px" class="text-center tickets">{{$detalle->conteo}}</td>
            </tr>
        @endforeach

        </tbody>
        <tfoot id="footer" class="">
        <tr style="background-color: lightskyblue">
            <th style="border: solid 1px grey;" class="text-center" id=""></th>
            <th style="border: solid 1px grey;" class="text-center" id=""></th>
            <th style="border: solid 1px grey;" class="text-center" id=""></th>
            <th style="border: solid 1px grey;" class="text-center" id=""></th>
            <th class="text-right" style="border: solid 1px grey;" >Total</th>
            <th style="border: solid 1px grey;" class="text-center" id="conteo_tickets"></th>

        </tr>
        </tfoot>
    </table>
</div>

<script>
    var suma = 0;
    $('.tickets').each(function(){
        var valor = parseFloat($(this).text());

        suma+=valor;
        console.log(suma);

    });

    $('#conteo_tickets').append(Math.round(suma*100)/100);
</script>