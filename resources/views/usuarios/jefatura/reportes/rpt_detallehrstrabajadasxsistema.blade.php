
<div class="col-md-5">
    <table id="tbl_kilometrajes" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 50px; " >
        <thead id="header" class="">
        <tr style="background-color: lightgrey">
            <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-laptop"></i> Sistema</th>
            <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-clock-o"></i> Horas registradas</th>

        </tr>
        </thead>
        <tbody>
        @foreach($detalles as $detalle)
            <tr>
                <td style="border: solid 1px black; " class="text-left recibidos"><b>{{$detalle->sistema}}</b></td>
                <td style="border: solid 1px black; width: 75px" class="text-center horas">{{$detalle->horas}}</td>
            </tr>
        @endforeach

        </tbody>
        <tfoot id="footer" class="">
        <tr style="background-color: lightskyblue">
            <th class="text-right" style="border: solid 1px grey;" >Total</th>
            <th style="border: solid 1px grey;" class="text-center" id="sum_horas"></th>

        </tr>
        </tfoot>
    </table>
</div>

<script>
    var suma = 0;
    $('.horas').each(function(){
        var valor = parseFloat($(this).text());

        suma+=valor;
        console.log(suma);

    });

    $('#sum_horas').append(Math.round(suma*100)/100);
</script>