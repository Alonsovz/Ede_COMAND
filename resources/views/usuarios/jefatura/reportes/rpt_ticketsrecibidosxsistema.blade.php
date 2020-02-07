
<div class="col-md-5">
    <table id="tbl_kilometrajes" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 50px; " >
        <thead id="header" class="">
        <tr style="background-color: lightgrey">
            <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-user"></i> Sistema</th>
            <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-ticket"></i> Conteo</th>

        </tr>
        </thead>
        <tbody>
        @foreach($detalles as $detalle)
            <tr>
                <td style="border: solid 1px black; " class="text-left recibidos"><b>{{$detalle->sistema}}</b></td>
                <td style="border: solid 1px black; width: 75px" class="text-center conteo">{{$detalle->conteo}}</td>
            </tr>
        @endforeach

        </tbody>
        <tfoot id="footer" class="">
        <tr style="background-color: lightskyblue">
            <th class="text-right" style="border: solid 1px grey;" >Total</th>
            <th style="border: solid 1px grey;" class="text-center" id="sum_conteo"></th>

        </tr>
        </tfoot>
    </table>
</div>

<script>
    var suma = 0;

    $('.conteo').each(function(){
        var valor = parseFloat($(this).text());

        suma+=valor;
        console.log(suma);

    });

    $('#sum_conteo').append(Math.round(suma*100)/100);
</script>