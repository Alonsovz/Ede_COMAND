@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link href="../css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/plugins/datapicker/datepicker3.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/clockpicker/clockpicker.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
@stop

@section('enunciado')
    Reservas
@stop

@section('modulo')
    Reservas de vehiculos
@stop

@section('submodulo')
    <b>Dueño</b>
@stop

@section('contenido')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <div class="row">
                            <div class="col-lg-8">
                                <h2><i class="fa fa-folder"></i> Bandeja de Reservas</h2>
                            </div>
                        </div>

                        <ul class="category-list pull-left." style="padding: 0">
                            <li><a href="#"> <i class="fa fa-circle text-warning"></i> Solicitud recibida</a></li>
                            <li><a href="#"> <i class="fa fa-circle text-primary"></i> Vehiculo autorizado</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <!--DATATABLE PARA RESERVAS-->
        <div class="col-lg-12 animated fadeInRight">
            <div class="mail-box-header">


                <div class="mail-tools tooltip-demo m-t-md">



                </div>
            </div>
            <div class="mail-box" id="boxmail" style="padding: 5px">
                <form action="">
                    <div id="p_recibidas" class="">
                        <h3>
                            <strong><i class="fa fa-car"></i> Solicitudes</strong>
                        </h3><br>
                        <table class="dataTables-example1 table table-mail dataTables-example" style="color: black" >
                            <thead id="header" class="">
                            <tr style="background-color: lightgrey;">
                                <th style="border:solid 1px grey">ID</th>
                                <th style="border:solid 1px grey">Vehiculo</th>
                                <th style="border:solid 1px grey">Empleado</th>
                                <th style="border:solid 1px grey">Motivo</th>
                                <th style="border:solid 1px grey">Estado</th>
                                <th style="border:solid 1px grey">Fecha sol.</th>
                                <th class="text-center" style="border:solid 1px grey"><i class="fa fa-calendar"></i> Inicio</th>
                                <th class="text-center" style="border:solid 1px grey"><i class="fa fa-calendar"></i> Fin</th>
                                <th style="border:solid 1px grey"></th>



                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reservas as $reserva)
                                @if($reserva->estadoreserva=='Solicitud recibida' ||
                                $reserva->estadoreserva=='Vehiculo autorizado' || $reserva->estadoreserva=='Solicitud aprobada' || $reserva->estadoreserva=='Reserva finalizada')
                                <tr>
                                    <td style="border: solid grey 1px; background-color: lightblue"><b>{{$reserva->id}}</b></td>
                                    <td style="border: solid grey 1px; background-color: lightblue"><b>{{$reserva->vehiculo}}</b></td>
                                    <td style="border: solid grey 1px; width: 200px"><b>{{$reserva->empleado}}</b></td>
                                    <td style="border: solid grey 1px">{{$reserva->motivo}}</td>

                                    <td style="border: 1px grey solid">

                                        @if($reserva->estadoreserva=='Solicitud recibida')
                                            <small><i><b class="label label-warning">{{$reserva->estadoreserva}}</b></i></small>

                                        @elseif($reserva->estadoreserva=='Vehiculo denegado')
                                            <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>


                                        @elseif($reserva->estadoreserva=='Vehiculo autorizado')
                                            <small><i><b class="label label-success">{{$reserva->estadoreserva}}</b></i></small>

                                        @elseif($reserva->estadoreserva=='Solicitud aprobada')
                                            <small><i><b class="label label-primary">{{$reserva->estadoreserva}}</b></i></small>

                                        @elseif($reserva->estadoreserva=='Reserva finalizada')
                                            <small><i><b style="color: black;" class="label label-default">{{$reserva->estadoreserva}}</b></i></small>

                                        @elseif($reserva->estadoreserva=='Solicitud cancelada')
                                            <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>

                                        @endif

                                    </td>
                                    <td style="border: solid grey 1px">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechasolicitud);
                                            echo date_format($date,"d/m/Y");
                                            ?>
                                        </small>
                                    </td>
                                    <td style="border: solid grey 1px">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechainicio);
                                            echo date_format($date,"d/m/Y");
                                            ?>
                                        </small>
                                    </td>
                                    <td style="border: solid grey 1px">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechafin);
                                            echo date_format($date,"d/m/Y");
                                            ?>
                                        </small>
                                    </td>
                                    <td style="border: solid grey 1px">

                                        @if($reserva->estadoreserva=='Solicitud denegada' || $reserva->estadoreserva=='Solicitud aprobada')

                                        @elseif($reserva->estadoreserva=='Solicitud recibida')
                                            <a href="vh_autorizacion?id={{$reserva->id}}" id="{{$reserva->id}}" class="edicionreserva btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif

                                    </td>


                                </tr>
                                @endif

                            @endforeach
                            </tbody>
                            <tfoot id="footer" class="hidden">
                            <tr>
                                <th>Rendering engine</th>
                                <th>Browser</th>
                                <th>Platform(s)</th>
                                <th>Engine version</th>
                                <th>CSS grade</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>

            </div>



        @stop


        @section('scripts')



            <!--funciones para datatables-->
                <script src="../js/plugins/dataTables/datatables.min.js"></script>

                <!--funciones para el lenguaje de las datatables-->
                <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>

                <!--funciones para step de actualizacion de permisos-->
                <script src="../js/plugins/staps/stepsUpdatePermisoEmpleado.js"></script>

                <script type="text/javascript" src='../js/funciones/updatepermisostep.js'></script>

                <script type="text/javascript" src='../js/funciones/updatepermisostep1.js'></script>



                <!-- Jquery Validate -->
                <script src="../js/plugins/validate/jquery.validate.min.js"></script>

                <!-- funciones para los mensajes de alerta -->
                <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

                <!-- funciones para calendario -->
                <script type="text/javascript" src='../js/plugins/datapicker/bootstrap-datepicker.js'></script>

                <!-- funciones para registrar los tiempos de los permisos por medio de la libreria clockpicker-->
                <script type="text/javascript" src='../js/plugins/clockpicker/clockpicker.js'></script>

                <script type="text/javascript" src="../js/funciones/clockanddate.js"></script>

                <script type="text/javascript" src="../js/funciones/bandeja_vhreservas.js"></script>
@stop