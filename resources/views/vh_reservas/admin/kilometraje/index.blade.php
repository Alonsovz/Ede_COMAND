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
   Kilometraje
@stop

@section('submodulo')
    <b>index</b>
@stop

@section('contenido')



    <div class="row" style="margin: 5px;">
        <button type="button" id="btn_nuevokilometraje" class="btn btn-outline btn-success pull-left btn-lg"><i class="fa fa-plus"></i> Mostrar formulario</button>
    </div>
    <br><br>





    <div class="row hidden" id="divkilometraje">
        <div class="col-md-12">
            <div class="ibox" >
                <div class="ibox-title"><b><i class="fa fa-paper-plane"></i> Formulario para nuevo Kilometraje</b></div>
                <div class="ibox-content" style="background-color: lightgrey; padding-left: 50px">
                    <form class="form-horizontal" action="#" id="frm_kilometraje">
                        <div class="row">
                            <h2><b>1. Informacion General</b></h2>
                            <div class="col-md-4">
                                <div class="form-group" id="the-basics">
                                    <label>Empleado:</label>
                                    <input autocomplete="off" id="empleado"   name="empleado" type="text" class="form-control typeahead" >
                                </div>
                            </div>

                            <div class="col-md-3" style="margin-left: 15px">
                                <div class="form-group">
                                    <label>Vehiculo:</label>
                                    <select name="" id="vehiculo" class="form-control">
                                        <option value="">seleccione un vehiculo</option>
                                        @foreach($vehiculos as $vehiculo)
                                            <option value="{{$vehiculo->id}}">{{$vehiculo->numeracion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 hidden" id="ultimokm" style="margin-left: 15px">
                                <div class="form-group">
                                    <label>Ultimo Kilometraje:</label>
                                    <input type="text" readonly="readonly" id="txt_ultimokm" class="form-control"  style="background-color: lightgreen; font-weight: bold">
                                </div>
                            </div>

                            <div class="col-md-2 hidden" id="divultimouso" style="margin-left: 15px">
                                <div class="form-group">
                                    <label>Ultimo uso:</label>
                                    <input type="text" readonly="readonly" id="txt_ultimouso" class="form-control"  style="background-color: lightyellow; font-weight: bold">
                                </div>
                            </div>

                        </div>


                        <br>

                        <div class="row">
                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>Km inicial: </label>

                                    <input autocomplete="off" id="kminicio"   name="" type="text"  class="form-control km" >
                                </div>
                            </div>

                            <div class="col-md-4" style="margin-left: 15px">
                                <div class="form-group">
                                    <label>Km Final: </label>
                                    <input autocomplete="off" id="kmfinal"   name="" type="text" class="form-control km" >
                                </div>
                            </div>

                            <div class="col-md-3 hidden" style="margin-left: 15px" id="divrecoridos">
                                <div class="form-group">
                                    <label>Total de recorrido: </label>
                                    <input readonly="true" style="background-color: yellow; font-weight: bold" autocomplete="off" id="recorrido"   name="" type="text" class="form-control km" >
                                </div>
                            </div>

                        </div>


                        <br>

                        <div class="row">
                            <h2><b>2. Costos</b></h2>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Galones cargados: </label>
                                    <input type="text" class="form-control" id="galones">
                                </div>
                            </div>

                            <div class="col-md-3" style="margin-left: 110px">
                                <div class="form-group">
                                    <label>Costo cargado: <b>($)</b> </label>
                                    <input type="text" class="form-control" id="costo_cargado">
                                </div>
                            </div>

                            <div class="col-md-3" style="margin-left: 75px">
                                <div class="form-group">
                                    <label>Numero de recibo:  </label>
                                    <input autocomplete="off" id="recibo"   name="" type="text" class="form-control" >
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
                                        <input id="horario1" type='text' class="form-control hor1" />
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
                                        <input id="horario2" type='text' class="form-control hor2" />
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
                                    <input type="text"  id="txt_reseva" readonly="true" name="" rows="8"  class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <br><br>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Trabajo realizado: </label>
                                    <textarea  id="trabajorealizado" name="motivo" rows="8"  class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button class="pull-right btn btn-sm btn-danger" id="btn_cancelarreserva" style="margin-left: 5px"><i class="fa fa-ban"></i> Cancelar</button>
                            <button class="pull-right btn btn-sm btn-success hidden " type="button"  id="btn_guardarkilometraje"><i class="fa fa-save"></i> Guardar</button>
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

