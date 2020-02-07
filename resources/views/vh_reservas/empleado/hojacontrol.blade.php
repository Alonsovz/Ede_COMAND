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
<p style="font-family: Tahoma, Helvetica, Arial"><img  src="C:\xampp\htdocs\SAE\public\images\edesal1.png" alt=""></p>
<p style="font-family: font-family: Tahoma, Helvetica, Arial"><b style="font-size: 14px; margin-left: 250px">CONTROL DE USO DE VEHICULO</b></p>


<div>
    <h5><b style="font-family: Tahoma, Helvetica, Arial">Información de solicitud N° {{$reserva->id}}</b></h5>
    <table class="minimalistBlack" style="font-family: Tahoma, Helvetica, Arial">
        <tbody>
            <tr>
                <td>Fecha solicitud:</td>
                <td><b><?php
                        $date=date_create($reserva->fechasolicitud);
                        echo date_format($date,"d/m/Y");
                        ?></b></td>
                <td>Departamento:</td>
                <td><b>{{$reserva->departamento}}</b></td>
            </tr>
            <tr>
                <td>Solicito la reserva:</td>
                <td><b>{{$reserva->empleado}}</b></td>
                <td>Conductor:</td>
                <td><b>{{$reserva->nombreconductor}} {{$reserva->apellidoconductor}}</b></td>
            </tr>
            <tr>
                <td>Placa:</td>
                <td><b>{{$reserva->placa}}</b></td>
                <td>No. Equipo:</td>
                <td><b>{{$reserva->vehiculo}}</b></td>
            </tr>
            <tr>
                <td>Fecha inicio de uso:</td>
                <td><b><?php
                        $date=date_create($reserva->fechainicio);
                        echo date_format($date,"d/m/Y H:i");
                        ?></b></td>
                <td>Fecha fin de uso:</td>
                <td><b><?php
                        $date=date_create($reserva->fechafin);
                        echo date_format($date,"d/m/Y H:i");
                        ?></b></td>
            </tr>

            <tr>
                <td>Destino:</td>
                <td><b>{{$reserva->destino}}</b></td>
                <td>Motivo:</td>
                <td><b>{{$reserva->motivo}}</b></td>
            </tr>
            <tr>
                <td>Aprobado por:</td>
                <td><b>@foreach($dueño as $d){{$d->nombre}} {{$d->apellido}}@endforeach</b></td>
                <td>Jefe inmediato:</td>
                <td>
                    <b>{{$reserva->nombrejefe}} {{$reserva->apellidojefe}}</b>
                </td>
            </tr>
        </tbody>
        <tfoot>
        <tr style="background-color: lightgrey">
        <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</div>
<div style="margin-top: 5px">
<h5><b style="font-family: Tahoma, Helvetica, Arial">Información de la condición del vehiculo utilizado</b></h5>
    <table class="minimalistBlack1" style="font-family: Tahoma, Helvetica, Arial">
    <tbody>
    <tr>
    <td><b>Condiciones del vehiculo</b></td>
        <td><b>A la entrega</b></td>
        <td><b>A la devolucion</b></td>
        <td><b>Marcador de combustible</b></td>
    </tr>

    <tr>
    <td>Odometro</td>
        <td></td>
        <td></td>
        <td rowspan="7" >
        <img style="margin-left: 50px" src="C:\xampp\htdocs\SAE\public\images\combustible.jpg" width="100" height="90" alt="">
        </td>
    </tr>
    <tr>
    <td>Llanta de repuesto</td>
        <td>Si:____  No:____</td>
        <td>Si:____  No:____</td>

    </tr>
    <tr>
    <td>Mica</td>
        <td>Si:____  No:____</td>
        <td>Si:____  No:____</td>

    </tr>

    <tr>
    <td>LLave de ruedas</td>
        <td>Si:____  No:____</td>
        <td>Si:____  No:____</td>


    </tr>
            <tr>
                <td>Extintor</td>
                <td>Si:____  No:____</td>
                <td>Si:____  No:____</td>

            </tr>
            <tr>
                <td>Receptor de radio</td>
                <td>Si:____  No:____</td>
                <td>Si:____  No:____</td>

            </tr>
            <tr>
                <td>Funciona A/C</td>
                <td>Si:____  No:____</td>
                <td>Si:____  No:____</td>
            </tr>
            <tr>
                <td>Tarjeta de circulacion</td>
                <td>Si:____  No:____</td>
                <td>Si:____  No:____</td>
                <td>A la entrega</td>
            </tr>

            <tr>
                <td>Abolladuras o golpes</td>
                <td>Si:____  No:____</td>
                <td>Si:____  No:____</td>
                <td rowspan="4">
                    <img style="margin-left: 50px" src="C:\xampp\htdocs\SAE\public\images\combustible.jpg" width="100" height="90" alt="">
                </td>
            </tr>
            <tr>
                <td>Conos</td>
                <td>Si:____  No:____</td>
                <td>Si:____  No:____</td>
            </tr>
            <tr>
                <td>Vidrios en buen estado</td>
                <td>Si:____  No:____</td>
                <td>Si:____  No:____</td>
            </tr>


            <tr>
                <td>Otros:</td>
                <td colspan="2"></td>

            </tr>

            <tr>
                <td colspan="3"></td>
                <td>A la devolucion</td>
            </tr>
            <tr style="background-color: lightgrey">
                <td><b>Firma de Cesar Perez o CALL CENTER</b></td>
                <td colspan="2"></td>
                <td></td>
            </tr>



        </tbody>
        <tfoot style="background-color: lightgrey">
            <tr>
                <td><b>Salida de porteria</b></td>
                <td></td>
                <td><b>Entrada de porteria</b></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Fecha:</b></td>
                <td></td>
                <td><b>Fecha:</b></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Hora:</b></td>
                <td></td>
                <td><b>Hora:</b></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Firma portero:</b></td>
                <td></td>
                <td><b>Firma portero:</b></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

</body>
</html>

