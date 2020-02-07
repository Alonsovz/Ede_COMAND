@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

@stop


@section('enunciado')
    Tickets
@stop

@section('modulo')
    Tickets
@stop

@section('submodulo')
    Supervision
@stop

@section('contenido')
    <div class="row" id="tablatickets">
        <div class="col-lg-12">
            <div class="ibox" style="border: lightgrey solid 1px">

                <div class="ibox-title" style="padding: 5px">

                </div>



                <div class="ibox-content" id="recibidostck">
                    <div class="btn-group pull-right">
                        <button data-toggle="dropdown" class="btn btn-success btn-outline btn-lg dropdown-toggle"><i class="fa fa-ticket"></i> Reportes <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" id="" data-toggle="modal" data-target="#modaldetalleticket">Tipos de tickets</a></li>
                            <li><a href="#" id="" data-toggle="modal" data-target="#modaldetallehoras">Horas Registradas (Empleado)</a></li>
                            <li><a href="#" id="" data-toggle="modal" data-target="#modalsistemasreporte">Horas Registradas (Sistema)</a></li>
                            <li><a href="#" id="" data-toggle="modal" data-target="#modalticketrecibidos">Tickets Recibidos (Empleado)</a></li>
                            <li><a href="#" id="" data-toggle="modal" data-target="#modalticketrecibidosbysistema">Tickets Recibidos (Sistema)</a></li>
                            <li><a href="#" id="" data-toggle="modal" data-target="#modalautoasignados">Tickets Auto-asignados</a></li>

                        </ul>
                    </div>
                    <h1><i class="fa fa-ticket"></i> <strong>Tickets en Proceso</strong></h1><br>
                    <ul class="category-list pull-left." style="padding: 0">

                        <li><a href="#"> <i class="fa fa-circle text-primary"></i> Recibido</a></li>

                        <li><a href="#"> <i class="fa fa-circle text-warning"></i> En proceso</a></li>
                    </ul>
                    <br>
                    <br>

                    <br>
                    <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                        <thead id="header" class="">
                        <tr style="background-color: lightgrey">
                            <th style="border: solid 1px grey;">N° de ticket</th>
                            <th style="border: solid 1px grey;">Asignado</th>
                            <th style="border: solid 1px grey;" class="text-center"><i class="fa fa-clock-o"></i></th>
                            <th style="border: solid 1px grey;">Estado</th>
                            <th style="border: solid 1px grey;">Titulo</th>
                            <th style="border: solid 1px grey;">Solicitante</th>
                            <th style="border: solid 1px grey;" class="text-center">Fecha de Solicitud</th>
                            <th style="border: solid 1px grey;" class="text-center">Fecha de entrega</th>
                            <th style="border: solid 1px grey;"></th>



                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
                            @if($ticket->estado=='Recibido' || $ticket->estado=='En proceso')
                                <tr>

                                    <td style="border: solid 1px grey; background-color: #F5F2DC"><b>{{$ticket->id}}</b></td>
                                    <td style="border: solid 1px grey; background-color: #F5F2DC; width: 150px"><b>{{$ticket->nombreasignado}} {{$ticket->apellidoasignado}}</b></td>
                                    <td style="border: solid 1px grey; width: 100px">
                                        @if($ticket->estado=='En proceso')
                                            <strong class="pull-left"><?php
                                                $datetime1 = new DateTime("now");
                                                $datetime2 = new DateTime($ticket->fechaentregareal);
                                                $interval = date_diff($datetime1, $datetime2);
                                                echo $interval->format('%R%a dias');
                                                ?> restantes</strong><br>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @endif
                                    </td>
                                    @if($ticket->estado=='Recibido')
                                        <td style="border: solid 1px grey;"><span class="label label-success">{{$ticket->estado}}</span></td>
                                    @elseif($ticket->estado=='En proceso')
                                        <td style="border: solid 1px grey;"><span class="label label-warning">{{$ticket->estado}}</span></td>
                                    @endif
                                    <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                    <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
                                    <td style="border: solid 1px grey;" class="text-center">
                                        <small>
                                            <?php
                                            $date=date_create($ticket->fechasolicitud);
                                            echo date_format($date,"d/m/Y");
                                            ?>
                                        </small>
                                    </td>
                                    <td style="border: solid 1px grey;" class="text-center">
                                        <small>
                                            @if($ticket->estado=='En proceso')
                                                <?php
                                                $date=date_create($ticket->fechaentregareal);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                            @elseif($ticket->estado=='Recibido')
                                                <?php
                                                $date=date_create($ticket->fechasolaprox);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                            @endif
                                        </small>
                                    </td>
                                    <td style="border: solid 1px grey;">
                                        @if($ticket->estado=='Recibido')
                                            <button id="{{$ticket->id}}" type="button" class="btn btn-md btn-info btn-outline detallessupervision ">
                                                <i class="fa fa-eye"></i> Supervisar
                                            </button>
                                        @endif
                                        @if($ticket->estado=='En proceso')
                                                <button id="{{$ticket->id}}" type="button" class="btn btn-md btn-info btn-outline detallessupervision ">
                                                    <i class="fa fa-eye"></i> Supervisar
                                                </button>
                                        @endif
                                    </td>

                                </tr>
                            @endif
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
                </div hidh>

                <div class="ibox-content hidden " id="completados">
                    <h1><i class="fa fa-ticket"></i> <strong>Tickets Completados</strong></h1><br>
                    <ul class="category-list pull-left." style="padding: 0">



                        <li><a href="#"> <i class="fa fa-circle text-success"></i> Solucionado</a></li>

                        <li><a href="#"> <i class="fa fa-circle text-danger"></i> Cerrado</a></li>

                    </ul>
                    <br>
                    <br>
                    {{--<h2><i class="fa fa-exclamation-circle"></i> Sin procesar... ({{$conteo}})</h2>--}}
                    <br>
                    <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                        <thead id="header" class="">
                        <tr style="background-color: lightgrey">
                            <th style="border: solid 1px grey;">N° de ticket</th>
                            <th style="border: solid 1px grey;">Estado</th>
                            <th style="border: solid 1px grey;">Titulo</th>
                            <th style="border: solid 1px grey;">Solicitante</th>
                            <th style="border: solid 1px grey;">Fecha de Solicitud</th>
                            <th style="border: solid 1px grey;">Fecha de Entrega</th>
                            <th style="border: solid 1px grey;"></th>



                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
                            @if($ticket->estado=='Rechazado' || $ticket->estado=='Cerrado' || $ticket->estado=='Solucionado')
                                <tr>
                                    <td style="border: solid 1px grey; background-color: lightblue"><b>{{$ticket->id}}</b></td>
                                    @if($ticket->estado=='Recibido')
                                        <td style="border: solid 1px grey;"><span class="label label-success">{{$ticket->estado}}</span></td>
                                    @elseif($ticket->estado=='En proceso')
                                        <td style="border: solid 1px grey;"><span class="label label-warning">{{$ticket->estado}}</span></td>
                                    @elseif($ticket->estado=='Solucionado')
                                        <td style="border: solid 1px grey;"><span class="label label-primary">{{$ticket->estado}}</span></td>
                                    @elseif($ticket->estado=='Cerrado')
                                        <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                    @elseif($ticket->estado=='Rechazado')
                                        <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                    @endif
                                    <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                    <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
                                    <td style="border: solid 1px grey;">
                                        <small>
                                            <?php
                                            $date=date_create($ticket->fechasolicitud);
                                            echo date_format($date,"d/m/Y");
                                            ?>
                                        </small>
                                    </td>
                                    <td style="border: solid 1px grey;">
                                        <small>
                                            @if($ticket->estado==='En proceso' )
                                                <?php
                                                $date=date_create($ticket->fechaentregareal);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                            @elseif($ticket->estado==='Solucionado' || $ticket->estado==='Cerrado')
                                                <?php
                                                $date=date_create($ticket->fechasolucion);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                            @elseif($ticket->estado=='Recibido')
                                                <?php
                                                $date=date_create($ticket->fechasolaprox);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                            @endif
                                        </small>
                                    </td>
                                    <td style="border: solid 1px grey;">
                                        <a href="administrarticket?id={{$ticket->id}}" id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
                                            <i class="fa fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            @endif
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
        </div>
    </div>

    {{--TICKETS RECIBIDOS EN GENERAL--}}
    <div class="row hidden ibox" id="detallesticket">
        <div class="ibox-heading">
            <div class="ibox-title">
                <h1><i class="fa fa-file-text-o"></i> Reporte mensual de tickets <small>Informatica</small></h1>

                <button id="generarexcel" class="btn btn-md btn-default pull-right" style="border: solid 1px black; " type="button"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
                <button class="btn btn-md btn-default pull-right" style="border: solid 1px black; margin-right: 5px" onclick="location.reload()" type="button"><i class="fa fa-arrow-left"></i> Regresar</button>
                <br><br>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row hidden" id="divsupervticket1">

            </div>
        </div>

    </div>

    {{--DETALLE DE HORAS TRABAJADAS--}}
    <div class="row hidden ibox" id="div_horastrabajadas">
        <div class="ibox-heading">
            <div class="ibox-title">
                <h1><i class="fa fa-file-text-o"></i> Reporte mensual de Horas registradas <small>Informatica</small></h1>

                <button id="excel_hrstrabajadas" class="btn btn-md btn-default pull-right" style="border: solid 1px black; " type="button"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
                <button class="btn btn-md btn-default pull-right" style="border: solid 1px black; margin-right: 5px" onclick="location.reload()" type="button"><i class="fa fa-arrow-left"></i> Regresar</button>
                <br><br>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row hidden" id="divsupervticket">

            </div>
        </div>

    </div>


    {{--TICKETS RECIBIDOS POR EMPLEADO--}}
    <div class="row hidden ibox" id="div_ticketsrecibidos">
        <div class="ibox-heading">
            <div class="ibox-title">
                <h1><i class="fa fa-file-text-o"></i> Reporte mensual de Tickets recibidos <small></small></h1>

                <button id="excelticketsrecibidos" class="btn btn-md btn-default pull-right" style="border: solid 1px black; " type="button"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
                <button class="btn btn-md btn-default pull-right" style="border: solid 1px black; margin-right: 5px" onclick="location.reload()" type="button"><i class="fa fa-arrow-left"></i> Regresar</button>
                <br><br>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row hidden" id="divsupervticket3">

            </div>
        </div>

    </div>


    {{--DIV HORAS REGISTRADAS POR SISTEMA--}}
    <div class="row hidden ibox" id="div_horastrabajadasxsistema">
        <div class="ibox-heading">
            <div class="ibox-title">
                <h1><i class="fa fa-file-text-o"></i> Reporte mensual de Horas registradas por sistema <small></small></h1>

                <button id="excelhorasxsistema" class="btn btn-md btn-default pull-right" style="border: solid 1px black; " type="button"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
                <button class="btn btn-md btn-default pull-right" style="border: solid 1px black; margin-right: 5px" onclick="location.reload()" type="button"><i class="fa fa-arrow-left"></i> Regresar</button>
                <br><br>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row hidden" id="divsupervticket2">

            </div>
        </div>

    </div>


    {{--DIV PARA TICKETS RECIBIDOS POR SISTEMA--}}
    <div class="row hidden ibox" id="div_ticketsistemasrecibidos">
        <div class="ibox-heading">
            <div class="ibox-title">
                <h1><i class="fa fa-file-text-o"></i> Reporte mensual de tickets recibidos por sistema <small></small></h1>

                <button id="excelticketsxsistema" class="btn btn-md btn-default pull-right" style="border: solid 1px black; " type="button"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
                <button class="btn btn-md btn-default pull-right" style="border: solid 1px black; margin-right: 5px" onclick="location.reload()" type="button"><i class="fa fa-arrow-left"></i> Regresar</button>
                <br><br>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row hidden" id="divsupervticket4">

            </div>
        </div>

    </div>


    {{--DIV PARA TICKETS AUTOASIGNADOS--}}
    <div class="row hidden ibox" id="div_ticketautoasignados">
        <div class="ibox-heading">
            <div class="ibox-title">
                <h1><i class="fa fa-file-text-o"></i> Reporte mensual de tickets recibidos y auto-asignados <small></small></h1>

                <button id="excelautoasignados" class="btn btn-md btn-default pull-right" style="border: solid 1px black; " type="button"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
                <button class="btn btn-md btn-default pull-right" style="border: solid 1px black; margin-right: 5px" onclick="location.reload()" type="button"><i class="fa fa-arrow-left"></i> Regresar</button>
                <br><br>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row hidden" id="divsupervticket5">

            </div>
        </div>

    </div>


    {{--MODAL PARA PARAMETROS DE REPORTE DE DETALLES DE TICKET DE INFORMATICA--}}
    <div class="modal inmodal fade" id="modaldetalleticket" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Parametros</h5>
                    <h2><i class="fa fa-file-text"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_detalletickets">

                        <div class="form-group"><label class="col-lg-2 control-label">Fecha:</label>

                            <div class="col-lg-8" id="">
                                <input id="fecha" name="fecha" type="text" class="form-control">
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-sm btn-success" id="btn_generardetalletickets" type="button" data-dismiss="modal"><i class="fa fa-eye"></i> Generar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA PARAMETROS DE REPORTE DE DETALLE DE HORAS TRABAJAS POR EMPLEADO--}}
    <div class="modal inmodal fade" id="modaldetallehoras" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Parametros</h5>
                    <h2><i class="fa fa-file-text"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_detalletickets">

                        <div class="form-group"><label class="col-lg-2 control-label">Fecha:</label>

                            <div class="col-lg-8" id="">
                                <input id="hr_fecha" name="hr_fecha" type="text" class="form-control">
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-sm btn-success" id="btn_generardetallehoras" type="button" data-dismiss="modal"><i class="fa fa-eye"></i> Generar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA PARAMETROS DE REPORTE DE DETALLE DE HORAS REGISTRADAS POR SISTEMA--}}
    <div class="modal inmodal fade" id="modalsistemasreporte" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Parametros</h5>
                    <h2><i class="fa fa-file-text"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_detalletickets">

                        <div class="form-group"><label class="col-lg-2 control-label">Fecha:</label>

                            <div class="col-lg-8" id="">
                                <input id="sistema_fecha" name="sistema_fecha" type="text" class="form-control">
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-sm btn-success" id="btn_generarreportesistemas" type="button" data-dismiss="modal"><i class="fa fa-eye"></i> Generar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA PARAMETROS DE REPORTE DE TICKETS RECIBIDOS POR EMPLEADO--}}
    <div class="modal inmodal fade" id="modalticketrecibidos" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Parametros</h5>
                    <h2><i class="fa fa-file-text"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_detalletickets">

                        <div class="form-group"><label class="col-lg-2 control-label">Fecha:</label>

                            <div class="col-lg-8" id="">
                                <input id="tickets_fecha" name="tickets_fecha" type="text" class="form-control">
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-sm btn-success" id="btn_generarptticketsrecibidos" type="button" data-dismiss="modal"><i class="fa fa-eye"></i> Generar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA PARAMETROS DE REPORTE DE TICKETS RECIBIDOS POR SISTEMA--}}

    <div class="modal inmodal fade" id="modalticketrecibidosbysistema" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Parametros</h5>
                    <h2><i class="fa fa-file-text"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_detalletickets">

                        <div class="form-group"><label class="col-lg-2 control-label">Fecha:</label>

                            <div class="col-lg-8" id="">
                                <input id="recibidosXsistema" name="recibidosXsistema" type="text" class="form-control">
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-sm btn-success" id="btn_generarticketrecibidosxsistema" type="button" data-dismiss="modal"><i class="fa fa-eye"></i> Generar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA PARAMETROS DE REPORTE DE TICKETS AUTOASIGNADOS--}}

    <div class="modal inmodal fade" id="modalautoasignados" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Parametros</h5>
                    <h2><i class="fa fa-file-text"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_detalletickets">

                        <div class="form-group"><label class="col-lg-2 control-label">Fecha:</label>

                            <div class="col-lg-8" id="">
                                <input id="autoasignados_fecha" name="autoasignados_fecha" type="text" class="form-control">
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-sm btn-success" id="btn_generarautoasignados" type="button" data-dismiss="modal"><i class="fa fa-eye"></i> Generar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script src="../js/plugins/dataTables/datatables.min.js"></script>
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>

    <script src="../js/plugins/fullcalendar/moment.min.js"></script>
    <script type="text/javascript" src="../js/daterangepicker.js"></script>
    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>
    <script src="../js/funciones/tickets.js"></script>
    <script src="../js/funciones/informatica.js"></script>

@stop