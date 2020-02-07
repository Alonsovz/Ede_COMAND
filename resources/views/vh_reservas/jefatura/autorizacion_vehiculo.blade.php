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
    <b>Edicion</b>
@stop

@section('contenido')




    <div class="row">
        @foreach($reserva as $r)
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="m-b-md">

                                        @if($r->estadoreserva=='Solicitud recibida' || $r->estadoreserva=='Vehiculo autorizado')
                                            @if($duenojefe->jefe==Session::get('idusuario'))

                                                <button type="button" id="{{$r->id}}"  class="btn btn-success btn-xs pull-right btn_autorizarvehiculodh" style="margin-left: 5px"><i class="fa fa-hand-o-up" >
                                                    </i> Autorizar como jefe y dueño
                                                </button>

                                            @elseif($duenojefe->jefe!=Session::get('idusuario'))
                                                <button type="button" id="{{$r->id}}"  class="btn btn-success btn-xs pull-right btn_autorizarvehiculo" style="margin-left: 5px"><i class="fa fa-hand-o-up" >
                                                    </i> Autorizar Vehiculo
                                                </button>
                                            @endif

                                            <button type="button" id="btn_denegarreserva"  class="btn btn-danger btn-xs pull-right btn_denegarvehiculo"><i class="fa fa-hand-o-down" ></i> Denegar</button>
                                        @endif
                                        <a href="autorizacionvehiculos" class="btn btn-warning btn-xs pull-right" style="margin-right: 5px"><i class="fa fa-arrow-left"></i> Bandeja</a>
                                        <br><br>
                                        <h2>Autorizacion de vehiculo</h2>
                                    </div>
                                    <dl class="dl-horizontal">

                                        @if($r->estadoreserva=='Solicitud recibida')
                                            <dt>Estado:</dt> <dd><span class="label label-success">{{$r->estadoreserva}}</span></dd>
                                        @endif
                                        @endforeach
                                    </dl>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-5">
                                    <dl class="dl-horizontal">

                                        <dt>Empleado:</dt> <dd>{{$r->empleado}}</dd>
                                        <dt>Conductor:</dt> <dd>{{$r->nombreconductor}} {{$r->apellidoconductor}}</dd>
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

                        </div>
                    </div>
                </div>
            </div>

    </div>






    <div class="row hidden" id="formularioresolucion">
        @foreach($reserva as $r)
            <div class="col-md-12">
                <div class="ibox" >
                    <div class="ibox-title">
                        <div class="alert alert-warning alert-dismissible" style="color: black">
                            <i class="fa fa-info-circle"></i> Es importante conocer el motivo de la denegación para la solicitud de reserva del empleado
                        </div>
                    </div>
                    <div class="ibox-content" style="background-color: lightgrey; padding-left: 50px">

                        <form class="form-horizontal" id="formularioreserva">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Motivo para la denegacion *</label>
                                        <textarea  id="resolucion" name="resolucion" rows="5"  class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success btn_guardardenegacion" id="{{$r->id}}">
                                            <i class="fa fa-save"></i> Guardar resolucion</button>
                                        <a  href="reservasjefatura" class="btn btn-danger"><i class="fa fa-close"></i> Cancelar</a>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
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