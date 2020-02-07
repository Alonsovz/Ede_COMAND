@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.10.0/sweetalert2.css">
@stop

@section('enunciado')
    Reservas
@stop

@section('modulo')
    Reservas de vehiculos
@stop

@section('submodulo')
    <b>Bandejas</b>
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
                                <button id="btn_denegadas" class="btn btn-danger btn-md"><i class="fa fa-thumbs-down"></i> Denegadas</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--DATATABLE PARA RESERVAS-->
        <div class="col-lg-12 animated fadeInRight">
            <div class="mail-box-header">


            </div>
            <div class="mail-box" id="boxmail" style="padding: 5px">
                <div class="alert alert-warning alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <a class="alert-link" >Estimado Empleado</a>
                    Recuerda que tu solicitud para reserva de vehiculos tendra validez si el estado
                    se encuentra en <b>"Solicitud aprobada"</b> lo cual significa que tu jefe inmediato y el dueño de vehiculo aprobaron tu solicitud.
                </div>
                <form action="" method='' >
                    <div id="p_recibidas" class="hidden">
                        <h2><strong><i class="fa fa-car"> </i> Solicitudes Nuevas</strong></h2>
                        <table class="dataTables-example1 table table-bordered  table-mail dataTables-example" style="color:black;" >
                            <thead id="header" class="">
                            <tr style="background-color: lightgrey;">
                                <th style="border: solid grey 1px">ID de solicitud</th>
                                <th style="border: solid grey 1px">Vehiculo</th>
                                <th style="border: solid grey 1px">Motivo</th>
                                <th style="border: solid grey 1px">Estado</th>
                                <th style="border: solid grey 1px">Fecha de sol.</th>
                                <th style="border: solid grey 1px">Fechas solicitadas</th>
                                <th style="border: solid grey 1px"></th>
                                <th style="border: solid grey 1px"></th>
                                <th style="border: solid grey 1px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reservas as $reserva)
                                @if($reserva->estadoreserva=='Solicitud recibida')
                                    <tr>
                                        <td style="border: 1px grey solid;background-color: lightblue"><b>{{$reserva->id}}</b></td>
                                        <td style="border: 1px grey solid;background-color: lightblue"><b>{{$reserva->vehiculo}}</b></td>
                                        <td style="border: 1px grey solid">{{$reserva->motivo}}</td>

                                        <td style="border: 1px grey solid">

                                            @if($reserva->estadoreserva=='Solicitud recibida')
                                                <small><i><b class="label label-success">{{$reserva->estadoreserva}}</b></i></small>

                                            @elseif($reserva->estadoreserva=='Vehiculo denegado')
                                                <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>


                                            @elseif($reserva->estadoreserva=='Vehiculo autorizado')
                                                <small><i><b class="label label-warning">{{$reserva->estadoreserva}}</b></i></small>

                                            @elseif($reserva->estadoreserva=='Solicitud aprobada')
                                                <small><i><b class="label label-primary">{{$reserva->estadoreserva}}</b></i></small>

                                            @elseif($reserva->estadoreserva=='Solicitud denegada')
                                                <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>

                                            @endif

                                        </td>
                                        <td style="border: 1px grey solid">
                                            <small>
                                                <?php
                                                $date=date_create($reserva->fechasolicitud);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                            </small>
                                        </td>
                                        <td style="border: 1px grey solid">
                                            <small>
                                                <?php
                                                $date=date_create($reserva->fechainicio);
                                                $date1=date_create($reserva->fechafin);

                                                echo date_format($date,"d/m/Y").'-'.date_format($date1,"d/m/Y");
                                                ?>
                                            </small>
                                        </td>
                                        <td style="border: 1px grey solid" class="text-center">

                                            @if($reserva->estadoreserva=='Solicitud recibida' || $reserva->estadoreserva=='Vehiculo autorizado')
                                                <a href="reservaedicion?id={{$reserva->id}}" id="{{$reserva->id}}" class="edicionreserva btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endif


                                        </td>
                                        <td style="border: 1px grey solid" class="text-center">

                                            @if($reserva->estadoreserva=='Solicitud recibida' || $reserva->estadoreserva=='Vehiculo autorizado')
                                                <button data-target='#myModal' data-toggle='modal' type="button" id="{{$reserva->id}}" class=" btn btn-sm btn-danger cancelarreserva">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td style="border: 1px grey solid">
                                            @if($reserva->estadoreserva=='Solicitud aprobada')
                                                <a href="vh_imprimirhoja?id={{$reserva->id}}"   class=" btn btn-sm btn-warning imprimirhoja">
                                                    <i class="fa fa-file-pdf-o"></i> Hoja de control
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

                    <div id="p_aprobadas" class="hidden">
                        <h2><strong><i class="fa fa-car"> </i> Solicitudes Aprobadas</strong></h2>
                        <table class="dataTables-example1 table table-bordered  table-mail dataTables-example" style="color:black;" >
                            <thead id="header" class="">
                            <tr style="background-color: lightgrey;">
                                <th style="border: solid grey 1px">ID de solicitud</th>
                                <th style="border: solid grey 1px">Vehiculo</th>
                                <th style="border: solid grey 1px">Motivo</th>
                                <th style="border: solid grey 1px">Estado</th>
                                <th style="border: solid grey 1px">Fecha de sol.</th>
                                <th class="text-center" style="border: solid grey 1px; "><i class="fa fa-calendar"></i> Inicia</th>
                                <th class="text-center" style="border: solid grey 1px; "><i class="fa fa-calendar"></i> Finaliza</th>
                                <th style="border: solid grey 1px"></th>
                                <th style="border: solid grey 1px"></th>
                                <th style="border: solid grey 1px" class="text-center">Hoja de control</th>
                                <th style="border: solid grey 1px" class="text-center">Finalizar reserva</th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reservas as $reserva)
                                @if($reserva->estadoreserva=='Solicitud aprobada' || $reserva->estadoreserva=='Vehiculo autorizado')
                                    <tr>
                                        <td style="border: 1px grey solid;background-color: lightblue"><b>{{$reserva->id}}</b></td>
                                        <td style="border: 1px grey solid;background-color: lightblue"><b>{{$reserva->vehiculo}}</b></td>
                                        <td style="border: 1px grey solid">{{$reserva->motivo}}</td>

                                        <td style="border: 1px grey solid">

                                            @if($reserva->estadoreserva=='Solicitud recibida')
                                                <small><i><b class="label label-success">{{$reserva->estadoreserva}}</b></i></small>

                                            @elseif($reserva->estadoreserva=='Vehiculo denegado')
                                                <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>


                                            @elseif($reserva->estadoreserva=='Vehiculo autorizado')
                                                <small><i><b class="label label-warning">{{$reserva->estadoreserva}}</b></i></small>

                                            @elseif($reserva->estadoreserva=='Solicitud aprobada')
                                                <small><i><b class="label label-primary">{{$reserva->estadoreserva}}</b></i></small>

                                            @elseif($reserva->estadoreserva=='Solicitud denegada')
                                                <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>

                                            @endif

                                        </td>
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

                                            @if($reserva->estadoreserva=='Solicitud recibida' || $reserva->estadoreserva=='Vehiculo autorizado')
                                                <a href="reservaedicion?id={{$reserva->id}}" id="{{$reserva->id}}" class="edicionreserva btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endif


                                        </td>
                                        <td style="border: 1px grey solid">

                                            @if($reserva->estadoreserva=='Solicitud recibida' || $reserva->estadoreserva=='Vehiculo autorizado')
                                                <button data-target='#myModal' data-toggle='modal' type="button" id="{{$reserva->id}}" class=" btn btn-sm btn-danger cancelarreserva">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td style="border: 1px grey solid">
                                            @if($reserva->estadoreserva=='Solicitud aprobada')
                                                <a href="vh_imprimirhoja?id={{$reserva->id}}"   class=" btn btn-sm btn-success imprimirhoja">
                                                    <i class="fa fa-file-pdf-o"></i> <b>Hoja de control</b>
                                                </a>
                                            @endif
                                        </td>
                                        <td style="border: 1px grey solid">
                                            @if($reserva->estadoreserva=='Solicitud aprobada')
                                                <button type="button" id="{{$reserva->id}}" class="btn btn-danger btn-sm pull-right finalizarreserva" style="margin-right: 5px"><i class="fa fa-power-off"></i> Finalizar</button>
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

                    <div id="p_denegadas" class="hidden">
                        <h2><strong><i class="fa fa-car"> </i> Solicitudes Denegadas o Canceladas</strong></h2>
                        <table class="dataTables-example1 table table-bordered  table-mail dataTables-example" style="color:black;" >
                            <thead id="header" class="">
                            <tr style="background-color: lightgrey;">
                                <th style="border: solid grey 1px">ID de solicitud</th>
                                <th style="border: solid grey 1px">Motivo</th>
                                <th style="border: solid grey 1px">Estado</th>
                                <th style="border: solid grey 1px">Fecha de sol.</th>
                                <th style="border: solid grey 1px"></th>
                                <th style="border: solid grey 1px"></th>
                                <th style="border: solid grey 1px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reservas as $reserva)
                                @if($reserva->estadoreserva=='Solicitud cancelada' || $reserva->estadoreserva=='Reserva finalizada' || $reserva->estadoreserva=='Vehiculo denegado')
                                    <tr>
                                        <td style="border: 1px grey solid;background-color: lightblue"><b>{{$reserva->id}}</b></td>
                                        <td style="border: 1px grey solid">{{$reserva->motivo}}</td>

                                        <td style="border: 1px grey solid">

                                            @if($reserva->estadoreserva=='Solicitud recibida')
                                                <small><i><b class="label label-success">{{$reserva->estadoreserva}}</b></i></small>

                                            @elseif($reserva->estadoreserva=='Vehiculo denegado')
                                                <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>


                                            @elseif($reserva->estadoreserva=='Vehiculo autorizado')
                                                <small><i><b class="label label-warning">{{$reserva->estadoreserva}}</b></i></small>

                                            @elseif($reserva->estadoreserva=='Solicitud aprobada')
                                                <small><i><b class="label label-primary">{{$reserva->estadoreserva}}</b></i></small>

                                            @elseif($reserva->estadoreserva=='Solicitud denegada')
                                                <small><i><b class="label label-danger">{{$reserva->estadoreserva}}</b></i></small>

                                            @endif

                                        </td>
                                        <td style="border: 1px grey solid">
                                            <small>
                                                <?php
                                                $date=date_create($reserva->fechasolicitud);
                                                echo date_format($date,"d/m/Y");
                                                ?>
                                            </small>
                                        </td>
                                        <td style="border: 1px grey solid">

                                            @if($reserva->estadoreserva=='Solicitud recibida' || $reserva->estadoreserva=='Vehiculo autorizado')
                                                <a href="reservaedicion?id={{$reserva->id}}" id="{{$reserva->id}}" class="edicionreserva btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endif


                                        </td>
                                        <td style="border: 1px grey solid">

                                            @if($reserva->estadoreserva=='Solicitud recibida' || $reserva->estadoreserva=='Vehiculo autorizado')
                                                <button data-target='#myModal' data-toggle='modal' type="button" id="{{$reserva->id}}" class=" btn btn-sm btn-danger cancelarreserva">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td style="border: 1px grey solid">
                                            @if($reserva->estadoreserva=='Solicitud aprobada')
                                                <a href="vh_imprimirhoja?id={{$reserva->id}}"   class=" btn btn-sm btn-warning imprimirhoja">
                                                    <i class="fa fa-file-pdf-o"></i> Hoja de control
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

                <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.10.0/sweetalert2.js"></script>


                <!--funciones para datatables-->
                <script src="../js/plugins/dataTables/datatables.min.js"></script>

                <!--funciones para el lenguaje de las datatables-->
                <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>

                <!-- funciones para los mensajes de alerta -->
                <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

                <script type="text/javascript" src="../js/funciones/vh_reservas.js"></script>
@stop