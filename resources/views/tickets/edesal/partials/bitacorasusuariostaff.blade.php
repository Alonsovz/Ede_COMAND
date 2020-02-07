


<table id="tbl_kilometrajes" class="dataTables-example1 table table-hover table-bordered  table-mail dataTables-example" style="color: black;margin-top: 20px; font-size: 11px; " >
    <thead id="header" class="">
    <tr style="">
        <th style="border:solid black 1px;" colspan="3"><h2><i class="fa fa-ticket"></i> Bitacoras</h2></th>
    </tr>
    </thead>
    <tbody>
    @for($i=0; $i<=count($tickets)-1; $i++)
        @php $bandera = $tickets[$i]->id; @endphp
            <tr style="background-color: lightgrey"><td style="border: solid black 1px" colspan="3"><b>Ticket N°</b> {{$bandera}} {{$tickets[$i]->titulo}}</td></tr>
        @for($k=0; $k<=count($bitacoras)-1; $k++)
            @if($bandera==$bitacoras[$k]->id)
                <tr>
                    <td style="border:solid 1px black"><textarea readonly="readonly" name="" id="" cols="110" rows="5">{{strip_tags($bitacoras[$k]->bitacora)}}</textarea></td>
                    <td style="border:solid 1px black">{{$bitacoras[$k]->tiempo*60}} Minutos</td>
                    <td style="border:solid 1px black"> <?php $fecha = date_create($bitacoras[$k]->fechacreacion); echo date_format($fecha,'d/m/Y') ?></td>
                </tr>
            @endif
        @endfor
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


