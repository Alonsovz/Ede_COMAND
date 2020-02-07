@extends('layouts.template')

@section('css')
    <link href="../css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/plugins/fullcalendar/fullcalendar.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/datapicker/datepicker3.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/clockpicker/clockpicker.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" href="../css/plugins/timerpicker/timerpicker.css">
    <link rel="stylesheet" href="../css/plugins/sweetalert/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">

    <style>
        body{
            color: black;
        }
    </style>
@stop

@section('enunciado')
    Reserva de vehiculos
@stop

@section('modulo')
    Kilometraje
@stop

@section('submodulo')
    <b>Listado</b>
@stop

@section('contenido')




    <div class="row" id="">
        <a href="indexkilometraje" class="btn btn-outline btn-lg btn-success"><i class="fa fa-plus-circle"></i> Nuevo Kilometraje</a><br><br>
        <h1><i class="fa fa-dashboard"></i> Control de Kilometraje</h1><br><br>

        <div class="col-lg-6">
            <div class="ibox" style="color: black">
                <div class="ibox-title">
                    <h3><i class="fa fa-info-circle"></i> Indicadores</h3>
                </div>
                <div class="ibox-content">

                    <input type="radio" class="" checked="checked"  value="all" id="filtro1" name="filtros">
                    Mostrar todos
                    <br>
                    <input type="radio" class=""  value="f1" id="filtro1" name="filtros">
                    Reservas mayores a 1 dia
                    <br>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-3 pull-right " style="margin-right: 10px">
                <div class="form-group">
                    <label><i class="fa fa-car"></i> Buscar por Vehiculo</label>
                    <input type="text" class="form-control" id="vehiculo">
                </div>
            </div>
        </div>

        <br>
        <div id="kilometraje1" class="">
        <table id="tbl_kilometrajes" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 20px; font-size: 11px" >
            <thead id="header" class="">
            <tr style="background-color: lightgrey">
                <th class="text-center" style="border: solid 1px grey;">ID</th>
                <th class="text-center" style="border: solid 1px grey;">Vehiculo</th>
                <th class="text-center" style="border: solid 1px grey;">Empleado</th>
                <th class="text-center" style="border: solid 1px grey;">Hoja de Reserva</th>
                <th class="text-center" style="border: solid 1px grey;">Motivo</th>
                <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-calendar"></i> <br>Inicio</th>
                <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-calendar"></i> <br>Fin</th>
                <th class="text-center" style="border: solid 1px grey;">Km inicial</th>
                <th class="text-center" style="border: solid 1px grey;">Km Final</th>
                <th class="text-center" style="border: solid 1px grey;">Galones</th>
                <th class="text-center" style="border: solid 1px grey;">Costo ($)</th>
                <th class="text-center" style="border: solid 1px grey;">Num. Recibo</th>
                <th class="text-center"  style="border: solid 1px grey;"></th>


            </tr>
            </thead>
            <tbody>
                @foreach($kilometrajes as $k)
                    {{--Realizamos la diferencia entre las fechas para mostrar un formato segun indicadores--}}
                  @php
                    $fecha1 = new DateTime($k->horario_inicio);
                    $fecha2 = new DateTime($k->horario_fin);

                    $dif = $fecha1->diff($fecha2);
                    $diferencia = $dif->d;

                  @endphp

                        <tr style="">
                            <td style="border: solid 1px grey; "><b>{{$k->id}}</b></td>
                            <td class="text-center" style="border: solid 1px grey;">{{$k->vehiculo}}</td>
                            <td style="border: solid 1px grey;"><b>{{$k->nombreempleado}} {{$k->apellidoempleado}}</b></td>
                            @if($k->reserva=='')
                                <td class="text-center" style="border: solid 1px grey;">N/A</td>
                            @else
                                <td class="text-center" style="border: solid 1px grey;">{{$k->reserva}}</td>
                            @endif
                            <td style="border: solid 1px grey;">{{$k->trabajo_realizado}}</td>
                            <td class="text-center" style="border: solid 1px grey;"><?php $fecha = date_create($k->horario_inicio); echo date_format($fecha,'d/m/Y H:i') ?></td>
                            <td class="text-center" style="border: solid 1px grey;"><?php $fecha = date_create($k->horario_fin); echo date_format($fecha,'d/m/Y H:i') ?></td>
                            <td class="" style="border: solid 1px grey;">{{$k->km_inicial}}</td>
                            <td class="" style="border: solid 1px grey;">{{$k->km_final}}</td>
                            <td class="text-center" style="border: solid 1px grey;">{{$k->galones_cargados}}</td>
                            @if($k->costo_cargado=='')
                                <td style="border: solid 1px grey;"><b></b></td>
                            @else
                                <td style="border: solid 1px grey;"><b>${{$k->costo_cargado}}</b></td>
                            @endif
                            <td style="border: solid 1px grey;">{{$k->num_recibo}}</td>
                            <td style="border: solid 1px grey;"><a href="edit_kilometraje?kilometraje={{$k->id}}"  class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Editar</a> </td>

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
        </div>

    </div>

    <div id="kilometraje2" class="hidden">
        <table id="tbl_kilometrajes" class="dataTables-example2 table table-hover  table-mail  " style="color: black;margin-top: 20px; font-size: 11px" >
            <thead id="header" class="">
            <tr style="background-color: lightgrey">
                <th class="text-center" style="border: solid 1px grey;">ID</th>
                <th class="text-center" style="border: solid 1px grey;">Vehiculo</th>
                <th class="text-center" style="border: solid 1px grey;">Empleado</th>
                <th class="text-center" style="border: solid 1px grey;">Hoja de Reserva</th>
                <th class="text-center" style="border: solid 1px grey;">Motivo</th>
                <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-calendar"></i> <br>Inicio</th>
                <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-calendar"></i> <br>Fin</th>
                <th class="text-center" style="border: solid 1px grey;">Km inicial</th>
                <th class="text-center" style="border: solid 1px grey;">Km Final</th>
                <th class="text-center" style="border: solid 1px grey;">Galones</th>
                <th class="text-center" style="border: solid 1px grey;">Costo ($)</th>
                <th class="text-center" style="border: solid 1px grey;">Num. Recibo</th>
                <th class="text-center"  style="border: solid 1px grey;"></th>


            </tr>
            </thead>
            <tbody>
            @foreach($kilometrajes2 as $k)
                {{--Realizamos la diferencia entre las fechas para mostrar un formato segun indicadores--}}
                @php
                    $fecha1 = new DateTime($k->horario_inicio);
                    $fecha2 = new DateTime($k->horario_fin);

                    $dif = $fecha1->diff($fecha2);
                    $diferencia = $dif->d;

                @endphp

                <tr style="">
                    <td style="border: solid 1px grey; "><b>{{$k->id}}</b></td>
                    <td class="text-center" style="border: solid 1px grey;">{{$k->vehiculo}}</td>
                    <td style="border: solid 1px grey;"><b>{{$k->nombre}} {{$k->apellido}}</b></td>
                    @if($k->reserva=='')
                        <td class="text-center" style="border: solid 1px grey;">N/A</td>
                    @else
                        <td class="text-center" style="border: solid 1px grey;">{{$k->reserva}}</td>
                    @endif
                    <td style="border: solid 1px grey;">{{$k->trabajo_realizado}}</td>
                    <td class="text-center" style="border: solid 1px grey;"><?php $fecha = date_create($k->horario_inicio); echo date_format($fecha,'d/m/Y H:i') ?></td>
                    <td class="text-center" style="border: solid 1px grey;"><?php $fecha = date_create($k->horario_fin); echo date_format($fecha,'d/m/Y H:i') ?></td>
                    <td class="" style="border: solid 1px grey;">{{$k->km_inicial}}</td>
                    <td class="" style="border: solid 1px grey;">{{$k->km_final}}</td>
                    <td class="text-center" style="border: solid 1px grey;">{{$k->galones_cargados}}</td>
                    @if($k->costo_cargado=='')
                        <td style="border: solid 1px grey;"><b></b></td>
                    @else
                        <td style="border: solid 1px grey;"><b>${{$k->costo_cargado}}</b></td>
                    @endif
                    <td style="border: solid 1px grey;">{{$k->num_recibo}}</td>
                    <td style="border: solid 1px grey;"><a href="edit_kilometraje?kilometraje={{$k->id}}"  class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Editar</a> </td>

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
    </div>


@stop


@section('scripts')
    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>

    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>
    <script src="https://unpkg.com/sweetalert2@7.20.6/dist/sweetalert2.all.js"></script>
    <script src="../js/plugins/staps/reservas_steps.js"></script>
    <script src="../js/plugins/validate/jquery.validate.min.js"></script>
    <script src="../js/plugins/fullcalendar/moment.min.js"></script>
    <script src="../js/plugins/fullcalendar/fullcalendar.js"></script>
    <script src='../js/plugins/fullcalendar/locale/es.js'></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>


    <!-- funciones para calendario -->
    <script type="text/javascript" src='../js/plugins/datapicker/bootstrap-datepicker.js'></script>

    <!-- funciones para registrar los tiempos de los permisos por medio de la libreria clockpicker-->
    <script type="text/javascript" src='../js/plugins/clockpicker/clockpicker.js'></script>

    <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>

    <script type="text/javascript" src="../js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <script src="../js/funciones/vh_kilometraje.js"></script>


    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>







@stop

