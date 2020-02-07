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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@stop

@section('enunciado')
    Reserva de vehiculos
@stop

@section('modulo')
    Reserva de vehiculos
@stop

@section('submodulo')
    <b>index</b>
@stop

@section('contenido')



    <div class="row" style="margin: 5px;">

        <button type="button" id="nuevareserva" class="btn btn-outline btn-success pull-left btn-lg"><i class="fa fa-plus"></i> Nueva reserva</button>
        <a style="margin-left: 5px" href="misreservas" type="button" class="btn btn-outline btn-warning pull-left btn-lg"><i class="fa fa-book fa-fw"></i> Mis reservas</a>

    </div>
    <br><br>
    <div class="alert alert-info">
        <b><i class="fa fa-info-circle"></i> Por medio del calendario podemos visualizar las reservas que ya se encuentran aprobadas de todo el personal EDESAL</b>
    </div>
    <div  class="row animated fadeInDown" id="calendario">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Calendario de reservas</h5>
                    <table></table>
                    <div class="ibox-tools">
                        <a class="collapse-link"F>
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">

                        </a>


                    </div>
                </div>
                <div class="ibox-content" style="">
                    <div id="calendar">

                    </div>
                </div>
            </div>
        </div>
    </div>



    <button id="modalevento" class="hidden" data-target="#myModal" data-toggle="modal"></button>

    <!--MODAL PARA MOSTRAR EL EVENTO SELECCIONADO-->
    <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-calendar modal-icon"></i>
                    <h4 class="modal-title"><small>Detalles de reserva</small></h4>
                    <small class="font-bold" id="empleadosolicitud"></small>
                </div>
                <div class="modal-body">

                    <div class="form-group" id="the-basics">
                        <label>Empleado solicitante </label>
                        <input  id="empleado1" name="empleado1" type="text" class="typeahead form-control" readonly="true">
                    </div>

                    <div class="form-group" id="the-basics">
                        <label>Motivo de solicitud</label>
                        <textarea class="form-control" readonly="true" name="" id="motivo1" cols="30" rows="3"></textarea>
                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group" id="the-basics">
                                <label>Vehiculo reservado </label>
                                <input  id="vhreservado" readonly="true" name="vhreservado" type="text" class="typeahead form-control" required title="Campo obligatorio">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group" id="the-basics">
                                <label>Horario de inicio </label>
                                <input  id="fechainicio1" readonly="true" name="fechainicio1" type="text" class="typeahead form-control" required title="Campo obligatorio">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" id="the-basics">
                                <label>Horario de finalizacion </label>
                                <input  id="fechafin1" readonly="true" name="fechafin1" type="text" class="typeahead form-control" required title="Campo obligatorio">
                            </div>
                        </div>
                    </div>





                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_cerrarupdatepermisos" class="btn btn-danger" data-dismiss="modal">Cerrar</button>

                </div>
            </div>

        </div>

    </div>



    <div class="row hidden" id="formularioreserva">
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
                                <div class="form-group" id="the-basics1">
                                    <label>Conductor *</label>
                                    <select class="form-control" name="conductor" id="conductor">
                                        <option value=""></option>
                                        @foreach($usuarios as $u)
                                            <option value="{{$u->id}}">{{$u->nombre}} {{$u->apellido}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-left: 10px">
                                <div class="form-group" id="the-basics">
                                    <label>Jefe inmediato *</label>
                                    <input  id="jefe" name="jefe" type="text" class="typeahead form-control" required title="Campo obligatorio">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Departamento *</label>
                                    <select class="form-control" id="departamento" name="departamento">
                                        <option>
                                            seleccione un departamento...
                                        </option>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de reserva *</label>
                                    <select class="form-control" id="tipo" name="tipo">
                                        <option>
                                            seleccione un tipo de reserva...
                                        </option>
                                        @foreach($tiposreservas as $tr)
                                            <option value="{{$tr->id}}">{{$tr->nombre}}</option>
                                        @endforeach
                                    </select>
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
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="120" value="120">EQ 120
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
                                                    <input type="radio" name="vehiculos" id="18" value="300">EQ 300
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="18" value="12">EQ 12
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">

                                <div class="ibox">
                                    <div class="ibox-title" style="background-color: #F29D07">
                                        <h5 style="color: black"><i class="fa fa-car"></i> Servicios de Ingeniería</h5>
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
                                                    <input type="radio" name="vehiculos" id="121" value="121">121
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
                                                    <input type="radio" name="vehiculos" id="17" value="21">EQ 21
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="18" value="22">EQ 22
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
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="18" value="112">EQ 112
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="18" value="23">EQ 23
                                                </label>
                                            </div>

                                            <div class="radio">
                                                <label for="">
                                                    <input type="radio" name="vehiculos" id="21" value="15">EQ 15
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
                                    <label for="">Horario de inicio</label>
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
                            <div class="form-group">
                                <button style="margin-left: 15px" type="button" id="disponibilidad" class="btn btn-md btn-warning"><i class="fa fa-search"></i> Comprobar disponibilidad</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Destino *</label>
                                    <input type="text" class="form-control" id="destino">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Motivo de solicitud *</label>
                                    <textarea  id="motivo" name="motivo" rows="5"  class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div id="barra_progreso" class="hidden row">
                            <h3>Enviando...</h3>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="83"
                                     aria-valuemin="0" aria-valuemax="100" style="width:83%">
                                    80%
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
    <script src="https://unpkg.com/sweetalert2@7.20.6/dist/sweetalert2.all.js"></script>
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

    <script type="text/javascript" src="../js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/funciones/reservas.js"></script>
    <script src="../js/funciones/vh_reservas.js"></script>


    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>







@stop

