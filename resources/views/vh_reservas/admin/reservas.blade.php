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
    <b>Supervisor</b>
@stop

@section('contenido')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <div class="row">
                            <div class="col-lg-8">
                                <h2><i class="fa fa-folder"></i> Bandejas</h2>
                                <button id="btn_enviadas" class="btn btn-info btn-md"><i class="fa fa-envelope"></i> Nuevas Solicitudes</button>
                                <button id="btn_aprobadas" class="btn btn-success btn-md"><i class="fa fa-thumbs-up"></i> Aprobadas</button>
                                <button id="btn_denegadas" class="btn btn-danger btn-md"><i class="fa fa-thumbs-down"></i> Denegadas y Finalizadas</button>
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
                <div class="hidden" id="p_recibidas">
                    <h2><strong><i class="fa fa-car"></i> Solicitudes Nuevas</strong></h2>
                    <table id="nuevasreservas" class="dataTables-example1 table table-hover  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                        <thead id="header" class="">
                        <tr style="background-color: lightgrey">
                            <th style="border: solid 1px grey;">ID</th>
                            <th style="border: solid 1px grey;">Vehiculo</th>
                            <th style="border: solid 1px grey;">Empleado</th>
                            <th style="border: solid 1px grey;">Motivo</th>
                            <th style="border: solid 1px grey;">Estado</th>
                            <th style="border: solid 1px grey;">Fecha de sol.</th>
                            <th style="border: solid 1px grey;">Horario inicio</th>
                            <th style="border: solid 1px grey;">Horario fin</th>
                            <th style="border: solid 1px grey;"></th>
                            <th style="border: solid 1px grey;"></th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservas as $reserva)
                            @if($reserva->estadoreserva=='Solicitud recibida')
                                <tr>
                                    <td style="border: 1px grey solid; background-color: lightblue"><small><b>{{$reserva->id}}</b></small></td>
                                    <td style="border: 1px grey solid; background-color: lightblue"><small><b>{{$reserva->vehiculo}}</b></small></td>
                                    <td style="border: 1px grey solid"><small><b>{{$reserva->empleado}}</b></small></td>
                                    <td style="border: 1px grey solid">{{$reserva->motivo}}</td>
                                    @if($reserva->estadoreserva=='Solicitud recibida')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-success">{{$reserva->estadoreserva}}</b></i></small>
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
                                            <small><i><b class="label label-warning">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>
                                    @elseif($reserva->estadoreserva=='Vehiculo denegado')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>

                                    @elseif($reserva->estadoreserva=='Solicitud cancelada')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>
                                    @elseif($reserva->estadoreserva=='Reserva finalizada')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-info">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>
                                    @endif


                                    <td style="border: 1px grey solid">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechasolicitud);
                                            echo date_format($date,"d/m/Y");
                                            ?>
                                        </small>
                                    </td>
                                    <td class="text-center" style="border: 1px grey solid">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechainicio);
                                            echo date_format($date,"d/m/Y H:i");
                                            ?>
                                        </small>
                                    </td>
                                    <td class="text-center" style="border: 1px grey solid">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechafin);
                                            echo date_format($date,"d/m/Y H:i");
                                            ?>
                                        </small>
                                    </td>
                                    <td style="border: 1px grey solid">

                                        <a href="edicionreservaadmin?id={{$reserva->id}}" id="{{$reserva->id}}" class="edicionreserva btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                    </td>
                                    <td style="border: 1px grey solid">
                                        <button data-target='#myModal' data-toggle='modal' type="button" id="{{$reserva->id}}" class=" btn btn-sm btn-danger cancelarreserva">
                                            <i class="fa fa-trash"></i>
                                        </button>
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
                <div class="hidden" id="p_aprobadas">
                    <h2><strong><i class="fa fa-car"></i> Solicitudes Aprobadas</strong></h2>
                    <table id="reservasaprobadas" class="dataTables-example1 table table-hover  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                        <thead id="header" class="">
                        <tr style="background-color: lightgrey">
                            <th style="border: solid 1px grey;">ID</th>
                            <th style="border: solid 1px grey;">Vehiculo</th>
                            <th style="border: solid 1px grey;">Empleado</th>
                            <th style="border: solid 1px grey;">Motivo</th>
                            <th style="border: solid 1px grey;">Estado</th>
                            <th style="border: solid 1px grey;">Fecha de sol.</th>
                            <th style="border: solid 1px grey;">Horario inicio</th>
                            <th style="border: solid 1px grey;">Horario fin.</th>
                            <th style="border: solid 1px grey;"></th>
                            <th style="border: solid 1px grey;"></th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservas as $reserva)
                            @if($reserva->estadoreserva=='Solicitud aprobada' || $reserva->estadoreserva=='Vehiculo autorizado')
                                <tr>
                                    <td style="border: 1px grey solid; background-color: lightblue"><small><b>{{$reserva->id}}</b></small></td>
                                    <td style="border: 1px grey solid; background-color: lightblue"><small><b>{{$reserva->vehiculo}}</b></small></td>
                                    <td style="border: 1px grey solid"><small><b>{{$reserva->empleado}}</b></small></td>
                                    <td style="border: 1px grey solid">{{$reserva->motivo}}</td>
                                    @if($reserva->estadoreserva=='Solicitud recibida')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-success">{{$reserva->estadoreserva}}</b></i></small>
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
                                            <small><i><b class="label label-warning">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>
                                    @elseif($reserva->estadoreserva=='Vehiculo denegado')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>

                                    @elseif($reserva->estadoreserva=='Solicitud cancelada')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>
                                    @elseif($reserva->estadoreserva=='Reserva finalizada')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-info">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>

                                    @endif


                                    <td style="border: 1px grey solid">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechasolicitud);
                                            echo date_format($date,"d/m/Y");
                                            ?>
                                        </small>
                                    </td>
                                    <td class="text-center" style="border: 1px grey solid">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechainicio);
                                            echo date_format($date,"d/m/Y H:i");
                                            ?>
                                        </small>
                                    </td>
                                    <td class="text-center" style="border: 1px grey solid">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechafin);
                                            echo date_format($date,"d/m/Y H:i");
                                            ?>
                                        </small>
                                    </td>
                                    <td style="border: 1px grey solid">

                                        <a href="edicionreservaadmin?id={{$reserva->id}}" id="{{$reserva->id}}" class="edicionreserva btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                    </td>
                                    <td style="border: 1px grey solid">
                                        <button data-target='#myModal' data-toggle='modal' type="button" id="{{$reserva->id}}" class=" btn btn-sm btn-danger cancelarreserva">
                                            <i class="fa fa-trash"></i>
                                        </button>
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
                <div class="hidden" id="p_denegadas">
                    <h2><strong><i class="fa fa-car"></i> Solicitudes Finalizadas ó Denegadas</strong></h2>
                    <table id="reservasdenegadas" class="dataTables-example1 table table-hover  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                        <thead id="header" class="">
                        <tr style="background-color: lightgrey">
                            <th style="border: solid 1px grey;">ID</th>
                            <th style="border: solid 1px grey;">Vehiculo</th>
                            <th style="border: solid 1px grey;">Empleado</th>
                            <th style="border: solid 1px grey;">Motivo</th>
                            <th style="border: solid 1px grey;">Estado</th>
                            <th style="border: solid 1px grey;">Fecha de sol.</th>
                            <th style="border: solid 1px grey;">Horario incio</th>
                            <th style="border: solid 1px grey;">Horario fin</th>
                            <th style="border: solid 1px grey;">Accion</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservas as $reserva)
                            @if($reserva->estadoreserva=='Solicitud denegada' || $reserva->estadoreserva=='Vehiculo denegado' || $reserva->estadoreserva=='Reserva finalizada')
                                <tr>
                                    <td style="border: 1px grey solid; background-color: lightblue"><small><b>{{$reserva->id}}</b></small></td>
                                    <td style="border: 1px grey solid; background-color: lightblue"><small><b>{{$reserva->vehiculo}}</b></small></td>
                                    <td style="border: 1px grey solid"><small><b>{{$reserva->empleado}}</b></small></td>
                                    <td style="border: 1px grey solid">{{$reserva->motivo}}</td>
                                    @if($reserva->estadoreserva=='Solicitud recibida')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-success">{{$reserva->estadoreserva}}</b></i></small>
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
                                            <small><i><b class="label label-warning">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>
                                    @elseif($reserva->estadoreserva=='Vehiculo denegado')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>

                                    @elseif($reserva->estadoreserva=='Solicitud cancelada')
                                        <td style="border: 1px grey solid">
                                            <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>
                                        </td>
                                    @elseif($reserva->estadoreserva=='Reserva finalizada')
                                        <td style="border: 1px grey solid">
                                            <small style="color: black;font-weight: bold"><b class="label label-default" style="color: black">{{$reserva->estadoreserva}}</b></small>
                                        </td>

                                    @endif


                                    <td style="border: 1px grey solid">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechasolicitud);
                                            echo date_format($date,"d/m/Y");
                                            ?>
                                        </small>
                                    </td>
                                    <td class="text-center" style="border: 1px grey solid">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechainicio);
                                            echo date_format($date,"d/m/Y H:i");
                                            ?>
                                        </small>
                                    </td>
                                    <td class="text-center" style="border: 1px grey solid">
                                        <small>
                                            <?php
                                            $date=date_create($reserva->fechafin);
                                            echo date_format($date,"d/m/Y H:i");
                                            ?>
                                        </small>
                                    </td>
                                    <td style="border: 1px grey solid">

                                        <a href="edicionreservaadmin?id={{$reserva->id}}" id="{{$reserva->id}}" class="edicionreserva btn btn-sm btn-info">
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