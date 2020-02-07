@extends('layouts.template')

@section('css')
 	<link href="../css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/plugins/datapicker/datepicker3.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/clockpicker/clockpicker.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" href="../css/plugins/sweetalert/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">


@stop

@section('enunciado')
	Permisos
@stop

@section('modulo')
	Permisos
@stop

@section('submodulo')
	<b>Index</b>
@stop

@section('contenido')


	
	<a class="btn btn-success btn-lg btn-outline" href="#" id="btn_mostrarformulario">
  		<i class="fa fa-plus"></i> Nuevo Permiso
  	</a>

    <div class="row " id="frm_nuevopermiso">
        <div class="col-md-12">
            <div class="ibox" >
                <div class="ibox-title"><b><i class="fa fa-paper-plane"></i> Formulario solicitud de ausencia laboral</b></div>
                <div class="ibox-content" style="background-color: lightgrey; padding-left: 50px" >
                    <form class="form-horizontal" id="frm_solicitudpermiso">
                        <div class="row">
                            <h2>Datos Generales</h2>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre Completo *</label>
                                    <input autocomplete="off" id="nombrecompleto"   name="nombrecompleto" type="text"  class="form-control" required title="Campo obligatorio">
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
                            <div class="col-md-4" >
                                <div class="form-group" id="">
                                    <label>Departamento *</label>
                                    <select class="form-control" id="departamento" name="departamento">
                                        <option>
                                            seleccione un tipo...
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
                                        <option>
                                            seleccione un tipo...
                                        </option>
                                        @foreach($tipopermisos as $tp)
                                            <option value="{{$tp->id}}">{{$tp->tipo}}</option>
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
                                        <input id="fechainicio" type='text' class="form-control" />
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
                                        <input id="fechafin" type='text' class="form-control" />
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
                            <button class="pull-right btn btn-sm btn-danger" id="" onclick="location.reload()" style="margin-left: 5px"><i class="fa fa-close"></i> Cancelar</button>
                            <button class="pull-right btn btn-sm btn-primary " type="button"  id="btn_guardarpermiso"> <i class="fa fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>















































    
    

  	<!-- Formulario para ingresar un nuevo permiso -->
    
  	<div class="row">
     
  	 	 <div class="col-lg-12 hidden" id="frm_nuevopermiso" >
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Solicitud de Permiso por Ausencia de Laboral</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                              
                            </div>
                        </div>
                        <div class="ibox-content">

                            <h2>
                                Nueva solicitud
                            </h2>
                            
                            

                            <form id="form" action="#" class="wizard-big form-horizontal">
                                <h1>Datos Generales</h1>
                                <fieldset>
                                    <h2></h2>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label>Nombre Completo *</label>
                                                <input autocomplete="off" id="nombrecompleto"   name="nombrecompleto" type="text" class="form-control" required title="Campo obligatorio">
                                            </div>

                                            <div class="form-group" id="the-basics">
                                                <label>Jefe inmediato *</label>
                                                <input  id="jefe" name="jefe" type="text" class="typeahead form-control" required title="Campo obligatorio">
                                            </div>
                                            
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
                                        <div class="col-lg-4">
                                            <div class="text-center">
                                                <div style="margin-top: 20px">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                                <h1>Tipo de Permiso</h1>
                                <fieldset>
                                    <h2></h2>
                                    <div class="row">

                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <label>Tipo de Permiso *</label>
                                                <select id="tipopermiso" name="tipopermiso" class="form-control" required title="Campo obligatorio">
                                                    <option>seleccione un tipo de permiso..</option>
                                                    @foreach($tipopermisos as $tipopermiso)
                                                        <option value="{{$tipopermiso->id}}">{{$tipopermiso->tipo}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>                                       
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label for="">Fecha de inicio</label>
                                                <div class='input-group date' id='datetimepicker1'>
                                                    <input id="horario1" type='text' class="form-control"  style="border: black solid 1px" />
                                                    <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="margin-left: 10px">

                                            <div class="form-group">
                                                <label for="">Fecha de finalizacion</label>
                                                <div class='input-group date' id='datetimepicker2'>
                                                    <input id="horario2" type='text' class="form-control" style="border: black solid 1px" />
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row hidden" style="margin-top: 10px" id="horarios2">
                                        <div class="col-lg-4">
                                            <div class="form-group" id="data_1">
                                                <label>Hora de salida</label>
                                                <div class="input-group clockpicker" data-autoclose="true"">
                                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                    <input type="text" id="horasalida" name="horasalida" class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4" style="margin-left: 10px">
                                            <div class="form-group" id="data_2">
                                                <label>Hora de entrada</label>
                                                <div class="input-group clockpicker" data-autoclose="true"">
                                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                    <input type="text" id="horaentrada" name="horaentrada" class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <h1>Motivo del Permiso</h1>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <label>Motivo del permiso *</label>
                                                <textarea  id="motivopermiso" name="motivopermiso" rows="10"  class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                            </form>
                        </div>
                    </div>
                </div>
            
  	</div>              

@stop

@section('scripts')

    <script src="../js/plugins/fullcalendar/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Steps -->
    <script src="../js/plugins/staps/jquery.steps.min.js"></script>

    <!-- Jquery Validate -->
    <script src="../js/plugins/validate/jquery.validate.min.js"></script>


    <script type="text/javascript" src="../js/plugins/sweetalert/sweetalert.min.js"></script>

    <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>

    <!-- funciones personalizadas para permisos -->
    <script type="text/javascript" src='../js/funciones/permisos.js'></script>

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>


    



@stop