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
    Reservas
@stop

@section('modulo')
    Reservas de vehiculos
@stop

@section('submodulo')
    <b>Verificacion</b>
@stop

@section('contenido')

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                @foreach($reserva as $r)
                                    <div class="m-b-md">

                                        <a href="vhadminreservas" class="btn btn-danger btn-xs pull-right" style="margin-right: 5px"><i class="fa fa-arrow-left"></i> Reservas</a>
                                        @if($r->estadoreserva=='Solicitud aprobada')
                                            <a href="reservafinalizada?id={{$r->id}}" class="btn btn-success btn-xs pull-right" style="margin-right: 5px"><i class="fa fa-thumbs-up"></i> Reserva finalizada</a>

                                        @endif
                                        <h2>Verificacion de Reserva</h2>
                                    </div>
                                    <dl class="dl-horizontal">

                                        @if($r->estadoreserva=='Solicitud recibida')
                                            <dt>Estado:</dt> <dd><span class="label label-success">{{$r->estadoreserva}}</span></dd>
                                        @endif
                                        @endforeach
                                    </dl>
                            </div>
                        </div>
                        @foreach($reserva as $r)
                            <div class="row">
                                <div class="col-lg-5">
                                    <dl class="dl-horizontal">

                                        <dt>Empleado:</dt> <dd>{{$r->empleado}}</dd>
                                        <dt>Vehiculo:</dt> <dd>  {{$r->vehiculo}}</dd>
                                        <dt>Jefe Inmediato:</dt> <dd><a href="#" class="text-navy">{{$r->nombrejefe}} {{$r->apellidojefe}}</a> </dd>
                                        <dt>Motivo:</dt> <dd> {{$r->motivo}}</dd>

                                    </dl>
                                </div>
                                <div class="col-lg-7" id="cluster_info">
                                    <dl class="dl-horizontal">

                                        <dt>Inicio de la reserva:</dt>
                                        <dd>

                                            <?php
                                            $date=date_create($r->fechainicio);
                                            echo date_format($date,"d/m/Y H:i");
                                            ?>

                                        </dd>
                                        <dt>Fin de la reserva:</dt>
                                        <dd>

                                            <?php
                                            $date=date_create($r->fechafin);
                                            echo date_format($date,"d/m/Y H:i");
                                            ?>


                                        </dd>


                                    </dl>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    @if($r->estadoreserva=='Solicitud denegada')

                                        <dl class="dl-horizontal">
                                            <dt>Resolucion:</dt>
                                            <dd>
                                                {{$r->resolucion}}
                                            </dd>
                                        </dl>

                                    @elseif($r->estadoreserva=='Solicitud recibida')
                                        <dl class="dl-horizontal">
                                            <dt>Porcentaje del proceso de reserva:</dt>
                                            <dd>
                                                <div class="progress progress-striped active m-b-sm">
                                                    <div style="width: 45%;" class="progress-bar"></div>

                                                </div>

                                            </dd>
                                        </dl>
                                    @elseif($r->estadoreserva=='Solicitud aprobada')
                                        <dl class="dl-horizontal">
                                            <dt>Resolucion:</dt>
                                            <dd>
                                                <b>Solicitud Aprobada</b>

                                            </dd>
                                        </dl>
                                    @endif
                                </div>
                            </div>
                            <div class="row m-t-sm" id="calendariodiv">
                                <div class="col-lg-12">
                                    <div class="panel blank-panel">
                                        <div class="panel-heading">
                                            <div class="panel-options">
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div id="calendar">

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row hidden" id="formularioedicion">
        <div class="col-md-12">
            <div class="ibox" >
                <div class="ibox-title"><b><i class="fa fa-paper-plane"></i> Formulario para edicion de reserva</b></div>
                <div class="ibox-content" style="background-color: lightgrey; padding-left: 50px">
                    <form class="form-horizontal" id="formularioreserva">
                        <div class="row">
                            <h2>Informacion General</h2>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre Completo *</label>

                                    <input autocomplete="off" id="nombrecompleto"   name="nombrecompleto" value="{{$r->empleado}}" type="text" class="form-control" required title="Campo obligatorio">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-left: 10px">
                                <div class="form-group" id="the-basics">
                                    <label>Jefe inmediato *</label>
                                    <input  id="jefe" name="jefe" type="text" value="{{$r->nombrejefe}} {{$r->apellidojefe}}" class="typeahead form-control" required title="Campo obligatorio">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Departamento *</label>
                                    <select class="form-control" id="departamento" name="departamento">
                                        <option value="{{$r->departamento_id}}">
                                            {{$r->departamento}}
                                        </option>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row" style="margin-top: 15px">
                            <h2>Informacion de solicitud</h2>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Vehiculo de solicitud *</label>
                                    <select id="vehiculo" name="vehiculo" class="form-control" required title="Campo obligatorio">
                                        <option value="{{$r->vh_vehiculo_id}}">{{$r->vehiculo}}</option>
                                        @foreach($vehiculos as $vehiculo)
                                            <option value="{{$vehiculo->id}}">{{$vehiculo->numeracion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="">Horario de inicio</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input id="horario1" type='text' value="<?php $fecha=date_create($r->fechainicio); echo date_format($fecha,'d/m/Y H:i'); ?>" class="form-control" />
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
                                        <input id="horario2" type='text' value="<?php $fecha=date_create($r->fechafin); echo date_format($fecha,'d/m/Y H:i'); ?>" class="form-control" />
                                        <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <button style="margin-left: 15px" type="button" id="disponibilidad" class="btn btn-xs btn-warning">Comprobar disponibilidad</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Motivo del permiso *</label>
                                    <textarea  id="motivo" name="motivo" rows="5"  class="form-control">{{$r->motivo}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button class="pull-right btn btn-sm btn-danger" id="btn_cancelarreserva" style="margin-left: 5px">Cancelar</button>
                            <button class="pull-right btn btn-sm btn-success btn_actualizarreserva " type="button"  id="{{$r->id}}">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach




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