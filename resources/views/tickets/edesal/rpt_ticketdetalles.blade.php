<!doctype html>
<html lang="en">
<head>

    <title></title>



    <style>

        table.minimalistBlack1 {
            border: 1px solid #000000;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }
        table.minimalistBlack1 td, table.minimalistBlack1 th {
            border:1px solid black;
            padding: 5px 4px;
        }
        table.minimalistBlack1 tbody td {
            font-size: 11px;
        }
        table.minimalistBlack1 thead {
            background: #CFCFCF;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.minimalistBlack1 thead th {
            font-size: 11px;
            font-weight: bold;
            color: #000000;
            text-align: left;
        }
        .total{
            background: #CFCFCF;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.minimalistBlack1 tfoot {
            border:none;
            font-size: 11px;
            font-weight: bold;
            color: #000000;

        }
        table.minimalistBlack1 tfoot td {
            border: none;
            font-size: 11px;
        }





        table.minimalistBlack {
            border: 1px solid #000000;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }
        table.minimalistBlack td, table.minimalistBlack th {

            padding: 5px 4px;
        }
        table.minimalistBlack tbody td {
            font-size: 11px;
        }
        table.minimalistBlack thead {
            background: #CFCFCF;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.minimalistBlack thead th {
            font-size: 11px;
            font-weight: bold;
            color: #000000;
            text-align: left;
        }
        .total{
            background: #CFCFCF;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.minimalistBlack tfoot {
            font-size: 11px;
            font-weight: bold;
            color: #000000;
            border-top: 1px solid #000000;
        }
        table.minimalistBlack tfoot td {
            font-size: 11px;
        }
    </style>
</head>
<body>
<p style="font-family: Tahoma, Helvetica, Arial"><img  src="C:\xampp\htdocs\COMANDA\public\images\edesal1.png" alt=""></p>
<p style="font-family: font-family: Tahoma, Helvetica, Arial"><b style="font-size: 14px; margin-left: 250px">DETALLES DE TICKET N° {{$ticket->id}}</b></p>

<div>
    <h5><i class="fa fa-ticket"></i> <b style="font-family: Tahoma, Helvetica, Arial">Informacion general</b></h5>
    <table class="minimalistBlack" style="font-family: Tahoma, Helvetica, Arial">

        <tbody>

        <tr>
            <td>Usuario Solicitante:</td>
            <td><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></td>
            <td>Usuario Asignado:</td>
            <td><b>{{$ticket->nombre}} {{$ticket->apellido}}</b></td>
        </tr>
        <tr>
            <td>Fecha solicitud:</td>
            <td><b><?php
                    $fecha = date_create($ticket->fechasolicitud);
                    echo date_format($fecha,'d/m/Y');
                    ?></b></td>
            <td>Fecha de entrega:</td>
            <td><b><?php
                    $fecha = date_create($ticket->fechaentregareal);
                    echo date_format($fecha,'d/m/Y');
                    ?></b></td>
        </tr>
        <tr>
            <td>Descripcion:</td>
            <td><b>{{$ticket->descripcion}}</b></td>
            <td></td>
            <td></td>
        </tr>



        </tbody>
        <tfoot>
        <tr style="background-color: lightgrey">
            <td>Estado:</td>
            <td><b>{{$ticket->estado}}</b></td>
            <td>Deadline:</td>
            <td>
                <b>
                    @if($ticket->estado=='En proceso')
                        <strong class="pull-left"><?php
                            $datetime1 = new DateTime("now");
                            $datetime2 = new DateTime($ticket->fechaentregareal);
                            $interval = date_diff($datetime1, $datetime2);
                            echo $interval->format('%R%a dias');
                            ?> para la entrega</strong>
                        @endif
                </b>
            </td>
        </tr>
        </tfoot>
    </table>
</div>


<h5><b style="font-family: Tahoma, Helvetica, Arial;margin-top: 40px">Bitacora de ticket</b></h5>
<table class="minimalistBlack1" style="font-family: Tahoma, Helvetica, Arial">

    <tbody>
    <tr style="background-color: lightgrey">
        <td><b>ID</b></td>
        <td><b>Descripcion</b></td>
        <td><b>Fecha de bitacora</b></td>
        <td><b>Tiempo dedicado</b></td>
    </tr>

    @foreach($bitacoras as $bitacora)
        <tr>
            <td><b>{{$bitacora->id}}</b></td>
            <td><b>{{$bitacora->descripcion}}</b></td>
            <td><b><?php
                    $fecha = date_create($bitacora->fechabitacora);
                    echo date_format($fecha,'d/m/Y');
                    ?></b></td>
            <td><b><?php
                    $tiempo = ($bitacora->tiempodedicado*60).' Minutos';
                    echo $tiempo;
                    ?></b></td>
        </tr>
        @endforeach
</table>






</body>
</html>