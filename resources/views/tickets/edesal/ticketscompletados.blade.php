@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
@stop


@section('enunciado')
    Tickets
@stop

@section('modulo')
    Tickets
@stop

@section('submodulo')
    Completados
@stop

@section('contenido')
    <div class="row" id="tablatickets">
        <div class="col-lg-12">
            <div class="ibox" style="border: lightgrey solid 1px">

                <div class="ibox-title" style="padding: 5px">
                    <a href="tck_edesalindex" class="btn btn-outline  btn-success btn-md pull-right" style="margin-left: 5px" type="button"><i class="fa fa-ticket"></i> Nuevo ticket</a>
                    <a href="tck_edesalshow" class="btn btn-outline  btn-warning btn-md pull-right" style="margin-left: 5px"  type="button"><i class="fa fa-arrow-left"></i> Regresar</a>
                </div>

                <div class="ibox-content">
                    <h1><i class="fa fa-ticket"></i> <strong>Tickets Completados</strong></h1><br>
                    <ul class="category-list pull-left." style="padding: 0">

                        <li><a href="#"> <i class="fa fa-circle text-primary"></i> Recibido</a></li>

                        <li><a href="#"> <i class="fa fa-circle text-warning"></i> En proceso</a></li>

                        <li><a href="#"> <i class="fa fa-circle text-success"></i> Solucionado</a></li>

                        <li><a href="#"> <i class="fa fa-circle text-danger"></i> Cerrado</a></li>

                    </ul>
                    <br>
                    <br>
                    {{--<h2><i class="fa fa-exclamation-circle"></i> Sin procesar... ({{$conteo}})</h2>--}}
                    <br>
                    <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                        <thead id="header" class="">
                        <tr style="background-color: lightgrey">
                            <th style="border: solid 1px grey;">N° de ticket</th>
                            <th style="border: solid 1px grey;">Estado</th>
                            <th style="border: solid 1px grey;">Titulo</th>
                            <th style="border: solid 1px grey;">Usuario Asignado</th>
                            <th style="border: solid 1px grey;">Fecha de Solicitud</th>
                            <th style="border: solid 1px grey;">Fecha de Entrega</th>
                            <th style="border: solid 1px grey;"></th>



                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
                            @if($ticket->estado=='Rechazado' || $ticket->estado=='Cerrado' || $ticket->estado=='Solucionado')
                            <tr>
                                <td style="border: solid 1px grey; background-color: lightblue"><b>{{$ticket->id}}</b></td>
                                @if($ticket->estado=='Recibido')
                                    <td style="border: solid 1px grey;"><span class="label label-success">{{$ticket->estado}}</span></td>
                                @elseif($ticket->estado=='En proceso')
                                    <td style="border: solid 1px grey;"><span class="label label-warning">{{$ticket->estado}}</span></td>
                                @elseif($ticket->estado=='Solucionado')
                                    <td style="border: solid 1px grey;"><span class="label label-primary">{{$ticket->estado}}</span></td>
                                @elseif($ticket->estado=='Cerrado')
                                    <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                @elseif($ticket->estado=='Rechazado')
                                    <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                @endif
                                <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                <td style="border: solid 1px grey;"><small><b>{{$ticket->nombre}} {{$ticket->apellido}}</b></small></td>
                                <td style="border: solid 1px grey;">
                                    <small>
                                        <?php
                                        $date=date_create($ticket->fechasolicitud);
                                        echo date_format($date,"d/m/Y");
                                        ?>
                                    </small>
                                </td>
                                <td style="border: solid 1px grey;">
                                    <small>
                                        <?php
                                        $date=date_create($ticket->fechasolucion);
                                        echo date_format($date,"d/m/Y");
                                        ?>
                                    </small>
                                </td>
                                <td style="border: solid 1px grey;">
                                    <a href="administrarticket?id={{$ticket->id}}" id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
                                        <i class="fa fa-eye"></i> Ver
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
        </div>
    </div>

    <div class="row hidden" id="divinfoticket">

    </div>


@stop

@section('scripts')
    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script src="../js/plugins/dataTables/datatables.min.js"></script>
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>
    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>
    <script src="../js/funciones/tickets.js"></script>

@stop