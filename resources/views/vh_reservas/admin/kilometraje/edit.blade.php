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
@stop

@section('enunciado')
    Reserva de vehiculos
@stop

@section('modulo')
    Kilometraje
@stop

@section('submodulo')
    <b>Editar</b>
@stop

@section('contenido')


    <div class="row hidden" id="btn_regresar">
        <a href="showkilometraje" class="btn btn-lg btn-outline btn-primary"><i class="fa fa-arrow-left"></i> Regresar</a>
    </div>


    <div class="row " id="divkilometraje">
        <div class="col-md-12">
            <div class="ibox" >
                <div class="ibox-title">
                    <h1><i class="fa fa-pencil"></i> Formulario de Edicion</h1>
                </div>
                <div class="ibox-content" style="background-color: lightgrey; padding-left: 50px">
                    <form class="form-horizontal" id="frm_kilometraje">
                        <div class="row">
                            <h2><b>1. Informacion General</b></h2>
                            <div class="col-md-4">
                                <div class="form-group" id="the-basics">
                                    <label>Empleado:</label>
                                    <input autocomplete="off" id="empleado" value="{{$kilometraje->nombreempleado}} {{$kilometraje->apellidoempleado}}"   name="empleado" type="text" class="form-control typeahead" >
                                </div>
                            </div>

                            <div class="col-md-4" style="margin-left: 15px">
                                <div class="form-group">
                                    <label>Vehiculo:</label>
                                    <select name="" id="vehiculo" class="form-control">
                                        <option value="{{$kilometraje->vh_vehiculo_id}}">{{$kilometraje->vehiculo}}</option>
                                        @foreach($vehiculos as $vehiculo)
                                            <option value="{{$vehiculo->id}}">{{$vehiculo->numeracion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>


                        <br>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Km inicial: </label>
                                    <input autocomplete="off" id="kminicio" value="{{$kilometraje->km_inicial}}"   name="" type="text"  class="form-control km" >
                                </div>
                            </div>

                            <div class="col-md-4" style="margin-left: 15px">
                                <div class="form-group">
                                    <label>Km Final: </label>
                                    <input autocomplete="off" id="kmfinal" value="{{$kilometraje->km_final}}"   name="" type="text" class="form-control km" >
                                </div>
                            </div>

                        </div>


                        <br>

                        <div class="row">
                            <h2><b>2. Costos</b></h2>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Galones cargados: </label>
                                    <input type="text" id="galones" class="form-control" value="{{$kilometraje->galones_cargados}}"/>
                                </div>
                            </div>

                            <div class="col-md-3" style="margin-left: 100px">
                                <div class="form-group">
                                    <label>Costo cargado: <b>($)</b> </label>
                                    <input type="text" class="form-control" id="costocargado_edit" value="{{$kilometraje->costo_cargado}}">
                                </div>
                            </div>

                            <div class="col-md-3" style="margin-left: 75px">
                                <div class="form-group">
                                    <label>Numero de recibo:  </label>
                                    <input autocomplete="off" id="recibo" value="{{$kilometraje->num_recibo}}"   name="" type="text" class="form-control" >
                                </div>
                            </div>

                        </div>


                        <br>

                        <div class="row">
                            <h2><b>3. Horario y motivos</b></h2>
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="">Horario de inicio: </label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input id="horario1" type='text' class="form-control hor1" value="<?php $fecha = date_create($kilometraje->horario_inicio); echo date_format($fecha,'d/m/Y H:i');  ?>" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4" style="margin-left: 10px">

                                <div class="form-group">
                                    <label for="">Horario de finalizacion: </label>
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input id="horario2" type='text' value="<?php $fecha = date_create($kilometraje->horario_fin); echo date_format($fecha,'d/m/Y H:i');  ?>" class="form-control hor2" />
                                        <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <button id="btn_verreservas" type="button" class="btn btn-md btn-success"><i class="fa fa-eye"></i> Ver Reservas</button>
                        </div>

                        <div class="row " id="divreservas">


                        </div>
                        <div class="row">
                            <br><br>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Reserva: </label>
                                    <input type="text"  id="txt_reseva" readonly="true" value="{{$kilometraje->vh_reserva_id}}" name="" rows="8"  class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <br><br>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Trabajo realizado: </label>
                                    <textarea  id="trabajorealizado" name="motivo" rows="8"  class="form-control">{{$kilometraje->trabajo_realizado}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <a href="showkilometraje" class="pull-right btn btn-md btn-danger" id="" style="margin-left: 5px"><i class="fa fa-ban"></i> Cancelar</a>
                            <button class="pull-right btn btn-md btn-success btn_actualizarkilometraje " type="button"  id="{{$kilometraje->id}}"><i class="fa fa-save"></i> Actualizar</button>
                        </div>
                    </form>
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

