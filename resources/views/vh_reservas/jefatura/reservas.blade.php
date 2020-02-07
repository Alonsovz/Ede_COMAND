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
    <b>Jefatura</b>
@stop

@section('contenido')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <div class="row">
                            <div class="col-lg-8">
                                <h2><i class="fa fa-folder"></i> Bandejas de reservas</h2>
                                <ul class="category-list pull-left." style="padding: 0">
                                    <li><a href="#"> <i class="fa fa-circle text-warning"></i> Solicitud recibida</a></li>
                                    <li><a href="#"> <i class="fa fa-circle text-primary"></i> Vehiculo autorizado</a></li>
                                </ul>
                            </div>
                        </div>
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

                <form action="" method='' >
                    <div id="p_recibidas" class="">
                        <h3>
                            <strong><i class="fa fa-car"></i> Solicitudes Nuevas</strong>
                        </h3>
                        <table class="dataTables-example1 table   table-mail dataTables-example" style="color: black;">
                            <thead id="header" class="">
                            <tr style="background-color: lightgrey">
                                <th style="border: solid grey 1px">ID</th>
                                <th style="border: solid grey 1px">Empleado</th>
                                <th style="border: solid grey 1px">Motivo</th>
                                <th style="border: solid grey 1px">Estado</th>
                                <th style="border: solid grey 1px">Fecha de sol.</th>
                                <th style="border: solid grey 1px"></th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reservas as $reserva)
                                @if($reserva->estadoreserva=='Solicitud recibida' || $reserva->estadoreserva=='Vehiculo autorizado')
                                <tr>
                                    <td style="border: grey solid 1px; background-color: lightblue"><b>{{$reserva->id}}</b></td>
                                    <td style="border: grey solid 1px"><b>{{$reserva->empleado}}</b></td>
                                    <td style="border: grey solid 1px">{{$reserva->motivo}}</td>

                                    @if($reserva->estadoreserva=='Solicitud recibida')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-warning">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>
                                    @elseif($reserva->estadoreserva=='Solicitud denegada')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>
                                    @elseif($reserva->estadoreserva=='Solicitud aprobada')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-primary">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>
                                    @elseif($reserva->estadoreserva=='Vehiculo autorizado')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-success">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>
                                    @elseif($reserva->estadoreserva=='Vehiculo denegado')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>

                                    @elseif($reserva->estadoreserva=='Solicitud cancelada')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>

                                    @endif
                                    <td style="border: grey solid 1px">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechasolicitud);
                                            echo date_format($date,"d/m/Y");
                                            ?>
                                        </small>
                                    </td>
                                    <td style="border: grey solid 1px">
                                        <a href="resolucionjefaturavh_reserva?id={{$reserva->id}}" id="{{$reserva->id}}" class="edicionreserva btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
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