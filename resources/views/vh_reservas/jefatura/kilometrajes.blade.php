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
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
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
    <b>Registros</b>
@stop

@section('contenido')

    <div class="row">
         @if(Session::get('idusuario')==7 || Session::get('idusuario')==52)
            <button class="btn-outline btn-lg btn-success btn" id="kmingresado" data-toggle="modal" data-target="#modalregistroskm"><i class="fa fa-table"></i> Kilometraje ingresado</button>
        @endif
        <button class="btn-outline btn-lg btn-warning btn" id="kmporvh" data-toggle="modal" data-target="#modalkmporvehiculo"><i class="fa fa-car"></i> Kilometraje por vehiculos</button>
        <button class="btn-outline btn-lg btn-primary btn hidden" id="btn_nuevoreporte" onclick="location.reload()"><i class="fa fa-car"></i> Nuevo Reporte</button>

    </div>
    <br>

    <div id="barra_progreso" class="hidden row">
        <h3>Generando...</h3>
        <div class="progress">
            <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="83"
                 aria-valuemin="0" aria-valuemax="100" style="width:83%">
                80%
            </div>
        </div>
    </div>
    <br><br>

    <div class="row hidden" id="filtrovh">
        <div class="col-md-3 pull-right " style="margin-right: 10px">
            <div class="form-group">
                <label><i class="fa fa-car"></i> Buscar por Vehiculo</label>
                <input type="text" class="form-control" id="vehiculo"><br>
                <button class="btn btn-md btn-success hidden" id="btn_genearexcelkmingresados"><i class="fa fa-file-excel-o"></i> Generar Excel</button>
                <button class="btn btn-md btn-success hidden" id="btn_generarexcelkmporvh"><i class="fa fa-file-excel-o"></i> Generar Excel</button>
            </div>
        </div>
    </div>

    <div id="renderkmingresados" class="row hidden">
        <h1><i class="fa fa-car"></i> Kilometraje Ingresado</h1><br>

    </div>

    <div id="renderkmingresadosporvh" class="row hidden">
        <h1><i class="fa fa-car"></i> Kilometraje por vehiculo</h1><br>
    </div>



    {{--MODAL PARA INGRESAR PARAMETROS PARA MOSTRAR LA TABLA DE LOS REGISTROS INGRESADOS DE KM--}}
    <div class="modal inmodal fade" id="modalregistroskm" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Parametros</h5>
                    <h2><i class="fa fa-file-text"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_insumos">

                        <div class="form-group"><label class="col-lg-2 control-label">Fecha:</label>

                            <div class="col-lg-8" id="">
                                <input id="fecha1" name="fecha1" type="text" class="form-control">
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-sm btn-success" id="btn_verregistroskm" type="button" data-dismiss="modal"><i class="fa fa-eye"></i> Mostrar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA INGRESAR PARAMETROS PARA MOSTRAR LA TABLA DE LOS REGISTROS POR VEHICULO--}}
    <div class="modal inmodal fade" id="modalkmporvehiculo" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Parametros</h5>
                    <h2><i class="fa fa-file-text"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_insumos">

                        <div class="form-group"><label class="col-lg-2 control-label">Fecha:</label>

                            <div class="col-lg-8" id="">
                                <input id="fecha2" name="fecha2" type="text" class="form-control">
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-sm btn-success" id="btn_generarkmporvehiculo" type="button" data-dismiss="modal"><i class="fa fa-eye"></i> Mostrar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>

@stop


@section('scripts')
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

