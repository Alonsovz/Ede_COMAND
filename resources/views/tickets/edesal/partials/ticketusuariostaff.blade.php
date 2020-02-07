

<h2><i class="fa fa-ticket"></i> Tickets</h2>
<table id="tbl_kilometrajes" class="dataTables-example1 table table-hover  table-mail dataTables-example" style="color: black;margin-top: 20px; font-size: 11px; " >
    <thead id="header" class="">
    <tr style="background-color: lightcyan">
        <th class="text-center" style="border: solid 1px grey;">Num. Ticket</th>
        <th class="text-center" style="border: solid 1px grey;">Estado</th>
        <th class="text-center" style="border: solid 1px grey;">Descripcion</th>
        <th class="text-center" style="border: solid 1px grey;">Solicitante</th>
        <th class="text-center" style="border: solid 1px grey;">Fecha de solicitud</th>
        <th class="text-center" style="border: solid 1px grey;">Fecha de solucion aprox.</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tickets as $t)
        <tr>
            <td class="text-center" style="border: solid 1px grey;"><b>{{$t->idticket}}</b></td>
            <td class="text-center" style="border: solid 1px grey;">{{$t->estadoticket}}</td>
            <td style="border: solid 1px grey;">{{$t->descripcion}}</td>
            <td style="border: solid 1px grey;">{{$t->solicitante}}</td>
            <td style="border: solid 1px grey;"><?php $fecha = date_create($t->fechasolicitud); echo date_format($fecha,'d/m/Y') ?></td>
           @if($t->fechaentregareal)
                <td style="border: solid 1px grey;"><?php $fecha = date_create($t->fechaentregareal); echo date_format($fecha,'d/m/Y') ?></td>
            @else
                <td class="text-center" style="border: solid 1px grey;"><b>Fecha no establecida</b></td>
            @endif

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


