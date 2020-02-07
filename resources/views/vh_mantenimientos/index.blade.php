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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@stop

@section('enunciado')
    Mantenimientos
@stop

@section('modulo')
    Mantenimiento de vehiculo
@stop

@section('submodulo')
    <b>index</b>
@stop

@section('contenido')

    <div class="row">
        <div class="col-lg-8 col-lg-offset-4">
            <button type="button" id="nuevareserva" class="btn btn-lg btn-outline btn-success"><i class="fa fa-plus"></i> Nueva Solicitud</button>
        </div>
    </div>





    <div class="row hidden" id="formulariosolicitud">
        <div class="col-md-12">
            <div class="ibox" >
                <div class="ibox-title"><b><i class="fa fa-paper-plane"></i> Formulario para ingreso de reserva</b></div>
                <div class="ibox-content" style="background-color: lightgrey; padding-left: 50px">
                    <form class="form-horizontal" id="formularioreserva">
                        <div class="row">
                            <h2><b>Informacion General</b></h2>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre Completo *</label>
                                    <input autocomplete="off" id="nombrecompleto"   name="nombrecompleto" type="text" class="form-control" required title="Campo obligatorio">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-left: 10px">
                                <div class="form-group" id="the-basics">
                                    <label>Jefe inmediato *</label>
                                    <input  id="jefe" name="jefe" type="text" class="typeahead form-control" required title="Campo obligatorio">
                                </div>
                            </div>
                        </div>

                        <br><br>
                        <div class="row" style="margin-top: 15px">
                            <h2><b>Informacion de solicitud</b></h2>
                            <h3 style="margin-top: 15px">Seleccione un vehiculo segun las areas siguientes:</h3>
                            <div class="col-md-3">

                                <div class="ibox">
                                    <div class="ibox-title" style="background-color: lightpink">
                                        <h5 style="color: black;"><i class="fa fa-car"></i> Area Tecnica</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up vh" style="background-color: black"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="form-group  ">
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="18" value="101">EQ 101
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="18" value="16">EQ 16
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="17" value="17">EQ 17
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="114" value="114">EQ 114
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="115" value="115">EQ 115
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="116" value="116">EQ 116
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="117" value="117">EQ 117
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="102" value="102">EQ 102
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <div class="col-md-3">

                                <div class="ibox">
                                    <div class="ibox-title" style="background-color: lightblue">
                                        <h5 style="color: black"><i class="fa fa-car"></i> Finanzas</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up vh" style="background-color: black"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="form-group  ">
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="17" value="Moto">Moto
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="17" value="112">EQ 112
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="17" value="21">EQ 21
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="ibox">
                                    <div class="ibox-title" style="background-color: lightgoldenrodyellow">
                                        <h5 style="color:black"><i class="fa fa-car"></i> Ventas</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link vh">
                                                <i class="fa fa-chevron-up" style="background-color: black"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="form-group  ">
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="18" value="18">EQ 18
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="ibox">
                                    <div class="ibox-title" style="background-color: lightgreen">
                                        <h5 style="color: black"><i class="fa fa-car"></i> Agencia y Calidad</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link vh">
                                                <i class="fa fa-chevron-up" style="background-color: black"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="form-group  ">
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="18" value="19">EQ 19
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="18" value="22">EQ 22
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="18" value="12">EQ 12
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="18" value="111">EQ 111
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="18" value="14">EQ 14
                                                </label>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="">Fecha estimada de uso</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input id="horario1" type='text' class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4" style="margin-left: 10px">

                                <div class="form-group">
                                    <label for="">Horario de finalizacion</label>
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input id="horario2" type='text' class="form-control" />
                                        <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Descripcion de la situacion *</label>
                                    <textarea  id="motivo" name="motivo" rows="5"  class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Detalle de reparacion*</label>
                                    <input autocomplete="off" id="detallereparacion"   name="" type="text" class="form-control" required title="Campo obligatorio">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Finalidad*</label>
                                    <textarea name="" id="finalidad" class="form-control" col="8" rows="5"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <button class="pull-right btn btn-sm btn-danger" id="btn_cancelarreserva" style="margin-left: 5px"><i class="fa fa-ban"></i> Cancelar</button>
                            <button class="pull-right btn btn-sm btn-success hidden" type="button"  id="btn_guardarreserva"><i class="fa fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





@stop


@section('scripts')
    <script src="../js/plugins/staps/reservas_steps.js"></script>
    <script src="../js/plugins/validate/jquery.validate.min.js"></script>
    <script src="../js/plugins/fullcalendar/moment.min.js"></script>
    <script src="../js/plugins/fullcalendar/fullcalendar.js"></script>
    <script src='../js/plugins/fullcalendar/locale/es.js'></script>



    <!-- funciones para calendario -->
    <script type="text/javascript" src='../js/plugins/datapicker/bootstrap-datepicker.js'></script>

    <!-- funciones para registrar los tiempos de los permisos por medio de la libreria clockpicker-->
    <script type="text/javascript" src='../js/plugins/clockpicker/clockpicker.js'></script>

    <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/funciones/reservas.js"></script>
    <script src="../js/funciones/vh_reservas.js"></script>


    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>



    <script type="text/javascript" src="../js/plugins/sweetalert/sweetalert.min.js"></script>



@stop

