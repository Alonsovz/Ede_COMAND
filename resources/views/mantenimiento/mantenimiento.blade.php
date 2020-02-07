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

@stop

@section('modulo')

@stop

@section('submodulo')
    <b></b>
@stop

@section('contenido')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h2><i class="fa fa-file-text"></i> Nueva ficha de mantenimiento</h2>
                    <br><br>
                    <form action="" class="form-horizontal">
                        <div class="row">
                            <div class="col-lg-2" style="margin-left: 10px">
                                <div class="form-group">
                                    <label for="">Vehiculo:</label>
                                    <select name="" class="form-control" id="">
                                        @foreach($vehiculos as $vehiculo)
                                            <option value="{{$vehiculo->id}}">{{$vehiculo->numeracion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4" style="margin-left: 25px">
                                <div class="form-group">
                                    <label for="">Tipo de mantenimiento:</label>
                                    <select name="" class="form-control" id="">
                                        @foreach($tiposmtto as $mtto)
                                            <option value="{{$mtto->id}}">{{$mtto->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8" style="margin-left: 10px">
                                <div class="form-group">
                                    <label for="">Descripción del mantenimiento:</label>
                                    <textarea name="" class="form-control" id="" cols="30" rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3" style="margin-left: 10px">
                                <div class="form-group">
                                    <label for="">Fecha proyectada de finalización: (Entrega del vehiculo)</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>


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




    <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>

    <!-- funciones personalizadas para permisos -->
    <script type="text/javascript" src='../js/funciones/permisos.js'></script>

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>






@stop