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
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@stop

@section('enunciado')
    Reserva de vehiculos
@stop

@section('modulo')
    Kilometraje
@stop

@section('submodulo')
    <b>Reportes</b>
@stop

@section('contenido')

    <button id="nuevoreporte" class="btn btn-lg btn-outline btn-success hidden" onclick="location.reload()">Nuevo reporte</button>
    <div class="dropdown " id="menureportes">
        <a data-toggle="dropdown" class="dropdown-toggle btn btn-lg btn-outline btn-primary" href="#">
            <span class="">Reportes <b class="caret"></b></span>
        </a>
        <ul class="dropdown-menu animated fadeInRight m-t-xs">
            <li><a data-toggle="modal" data-target="#parametros_resumenvh" href="#"><b>1. Resumen por vehiculos</b></a></li>
            <li><a href="#" data-toggle="modal" data-target="#parametros_resumen_empleados"><b>2. Resumen por empleados</b></a></li>
        </ul>
    </div>


    {{--DIV PARA RENDER DE RESUMEN DE VEHICULOS--}}
    <div class="row">
        <br><br>

        {{--RENDER PARA EL RESUMEN POR VEHICULOS--}}
        <div class="col-md-10 hidden"  id="renderresumenvh">

            <div class="alert alert-info alert-dismissable">
                <h2>
                    <i class="fa fa-file-text"></i> Resumen por vehiculo
                    <button id="resumenxvehiculoexcel" style="margin-left: 5px" class="btn btn-default pull-right "><i class="fa fa-file-excel-o"></i> Generar Excel</button>
                    <button id="resumenxvehiculopdf" class="btn btn-default pull-right "><i class="fa fa-file-pdf-o" ></i> Generar PDF</button>
                </h2>

            </div>

        </div>


        {{--RENDER PARA EL RESUMEN POR EMPLEADOS--}}
        <div class="col-md-10 hidden"  id="renderresumenempleados">

            <div class="alert alert-info alert-dismissable">
                <h2>
                    <i class="fa fa-file-text"></i> Resumen por Empleados
                    <button id="empleadosexcel" style="margin-left: 5px" class="btn btn-default pull-right "><i class="fa fa-file-excel-o"></i> Generar Excel</button>
                    <button id="resumenxempleadospdf" class="btn btn-default pull-right "><i class="fa fa-file-pdf-o" ></i> Generar PDF</button>
                </h2>

            </div>

        </div>


    </div>



    {{--MODAL PARA LOS PARAMETROS DEL REPORTE DEL RESUMEN POR VEHICULO--}}
    <div class="modal inmodal fade" id="parametros_resumenvh" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h1>Resumen por vehiculos</h1>
                    <h4 class="modal-title"><small><i class="fa fa-file"></i> Parametros de reporte</small></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fechas *</label>
                        <input autocomplete="off" id="fecha1" name="fecha1" type="text" class="form-control" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_resumenporvehiculo" class="btn btn-primary btn-sm" data-dismiss="modal">Generar</button>
                </div>
            </div>
        </div>
    </div>



    {{--MODAL PARA LOS PARAMETROS DEL REPORTE DEL RESUMEN POR EMPLEADOS--}}
    <div class="modal inmodal fade" id="parametros_resumen_empleados" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h2>Resumen por empleados</h2>
                    <h4 class="modal-title"><small><i class="fa fa-file"></i> Parametros de reporte</small></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fechas *</label>
                        <input autocomplete="off" id="fecha2" name="fecha2" type="text" class="form-control" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_generarresumenempleados" class="btn btn-primary btn-sm" data-dismiss="modal">Generar</button>
                </div>
            </div>
        </div>
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
    <script type="text/javascript" src="../js/daterangepicker.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>


    <!-- funciones para calendario -->
    <script type="text/javascript" src='../js/plugins/datapicker/bootstrap-datepicker.js'></script>


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

