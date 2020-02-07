@extends('layouts.template')

@section('css')
    <link href="../css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/plugins/datapicker/datepicker3.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/clockpicker/clockpicker.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">


@stop

@section('enunciado')
    Permisos
@stop

@section('modulo')
    Permisos
@stop

@section('submodulo')
    <b>Edicion</b>
@stop

@section('contenido')



    <h1><i class="fa fa-edit"></i> Editar permiso</h1>


    @foreach($permisos as $permiso)
    <div class="row " id="">
        <div class="col-md-12">
            <div class="ibox" >
                <div class="ibox-title"><b><i class="fa fa-paper-plane"></i> Formulario de edicion</b></div>
                <div class="ibox-content" style="background-color: lightgrey; padding-left: 50px">
                    <form class="form-horizontal" id="frm_solicitudpermiso">
                        <div class="row">
                            <h2>Datos Generales</h2>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre Completo *</label>
                                    <input autocomplete="off" id="nombrecompleto" value="{{$permiso->empleado}}"  name="nombrecompleto" type="text" class="form-control" required title="Campo obligatorio">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-left: 10px">
                                <div class="form-group" id="the-basics">
                                    <label>Jefe inmediato *</label>
                                    <input value="{{$permiso->nombrejefe}} {{$permiso->apellidojefe}}"  id="jefe" name="jefe" type="text" class="typeahead form-control" required title="Campo obligatorio">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" >
                                <div class="form-group" id="">
                                    <label>Departamento *</label>
                                    <select class="form-control" id="departamento" name="departamento">
                                        <option value="{{$permiso->departamento_id}}">
                                            {{$permiso->departamento}}
                                        </option>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <h2>Informacion de permiso</h2>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Tipo de permiso *</label>
                                    <select class="form-control" id="tipopermiso" name="departamento">
                                        <option value="{{$permiso->tipo_permiso_id}}">
                                            {{$permiso->tipopermiso}}
                                        </option>
                                        @foreach($tipopermisos as $tp)
                                            <option value="{{$tp->id}}">{{$tp->tipo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="oldhorario">


                                <div class="col-md-4" style="margin-left: 0px">
                                    <div class="form-group">
                                        <label for="">Fecha de inicio</label>
                                        <div class='input-group ' id=''>
                                            <input readonly="true" value="<?php $fecha1=date_create($permiso->fechainicio); echo date_format($fecha1,'d/m/Y H:i'); ?>" id="fechainicio1" type='text' class="form-control" />
                                        </div>
                                    </div>
                                </div>


                            <div class="col-md-4" style="margin-left: 0px">
                                <div class="form-group">
                                    <label for="">Fecha de finalizacion</label>
                                    <div class='input-group ' id=''>
                                        <input readonly="true" value="<?php $fecha1=date_create($permiso->fechafin); echo date_format($fecha1,'d/m/Y H:i'); ?>" id="fechafin1" type='text' class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="margin-left: 10px">
                                <div class="form-group">
                                    <div class='form-group ' id=''>
                                         <button type="button" id="btn-nuevasfechas" style="margin-left: 5px" class="btn btn-warning btn-xs"><i class="fa fa-plus"></i> Nuevas fechas</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row hidden" id="nuevohorario">
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="">Horario de inicio</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input id="fechainicio2"  type='text' class="form-control" />
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
                                        <input id="fechafin2" type='text' class="form-control" />
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
                                    <label>Motivo de solicitud *</label>
                                    <textarea  id="motivo" name="motivo" rows="5"  class="form-control">{{$permiso->motivopermiso}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button class="pull-right btn btn-sm btn-danger" id="" onclick="location.href='dashboard'" style="margin-left: 5px"><i class="fa fa-close"></i> Cancelar</button>
                            <button class="pull-right btn btn-sm btn-primary btn_actualizarpermiso " type="button"  id="{{$permiso->id}}"> <i class="fa fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach



@stop

@section('scripts')

    <script src="../js/plugins/fullcalendar/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Steps -->
    <script src="../js/plugins/staps/jquery.steps.min.js"></script>

    <!-- Jquery Validate -->
    <script src="../js/plugins/validate/jquery.validate.min.js"></script>




    <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>

    <!-- funciones personalizadas para permisos -->
    <script type="text/javascript" src='../js/funciones/permisos.js'></script>

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>






@stop