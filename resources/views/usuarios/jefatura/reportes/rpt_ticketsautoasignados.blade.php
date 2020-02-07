
<div style="width: 1000px">
    <div class="">

        <table id="tbl_kilometrajes" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 50px; " >
            <thead id="header" class="">
            <tr style="background-color: lightgrey">
                <td colspan="3" style="border:solid 1px black"> <h3><i class="fa fa-calculator"></i> Conteo</h3></td>
            </tr>
            <tr style="background-color: lightgrey">
                <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-ticket"></i> Registrados en COMANDA</th>
                <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-user"></i> Auto-Asignados</th>
                <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-users"></i> Asignado por usuario final</th>

            </tr>
            </thead>
            <tbody>
            @foreach($detalles as $detalle)
                <tr>
                    <td style="border: solid 1px black; width: 75px" class="text-center recibidos"><b>{{$detalle->recibidos}}</b></td>
                    <td style="border: solid 1px black; width: 75px" class="text-center conteo">{{$detalle->auto_asignados}}</td>
                    <td style="border: solid 1px black; width: 100px" class="text-center conteo">{{$detalle->recibidos - $detalle->auto_asignados}}</td>
                </tr>
            @endforeach

            </tbody>
            <tfoot id="footer" class="">

            </tfoot>
        </table>
    </div>

    {{--no uso de comanda--}}
    <div class="">

        <table id="tbl_kilometrajes" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 50px; " >
            <thead id="header" class="">
            <tr style="background-color: lightgrey">
                <td colspan="2" style="border:solid 1px black"><h3><i class="fa fa-users"></i> Top 10  (No uso de COMANDA)</h3></td>
            </tr>
            <tr style="background-color: lightgrey">
                <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-users"></i> Usuario</th>
                <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-ticket"></i> Conteo</th>


            </tr>
            </thead>
            <tbody>
            @foreach($usuarios as $detalle)
                <tr>
                    <td style="border: solid 1px black; width: 75px" class="text-left recibidos"><b>{{$detalle->nombre}} {{$detalle->apellido}}</b></td>
                    <td style="border: solid 1px black; width: 75px" class="text-center conteo">{{$detalle->conteo}}</td>

                </tr>
            @endforeach

            </tbody>
            <tfoot id="footer" class="">

            </tfoot>
        </table>
    </div>

    {{--top de quien mas pide en COMANDA--}}
    <div class="">

        <table id="tbl_kilometrajes" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 50px; " >
            <thead id="header" class="">
            <tr style="background-color: lightgrey"><td style="border:solid 1px black" colspan="2"><h3><i class="fa fa-users"></i> Top 10 Solicitudes (Solicitantes con mas frecuencia)</h3></td></tr>
            <tr style="background-color: lightgrey">
                <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-users"></i> Usuario</th>
                <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-ticket"></i> Conteo</th>
            </tr>
            </thead>
            <tbody>
            @foreach($solicitantes as $detalle)
                <tr>
                    <td style="border: solid 1px black; width: 75px" class="text-left recibidos"><b>{{$detalle->nombre}} {{$detalle->apellido}}</b></td>
                    <td style="border: solid 1px black; width: 75px" class="text-center conteo">{{$detalle->conteo}}</td>
                </tr>
            @endforeach

            </tbody>
            <tfoot id="footer" class="">

            </tfoot>
        </table>
    </div>
</div>


{{--Conteo--}}


<script>

</script>