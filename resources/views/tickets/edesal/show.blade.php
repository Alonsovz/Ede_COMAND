@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<style>
    .titulo1{
        color: blue !important;
        font-weight:bold;
        margin-left:15px;
        font-size:25px;
    }
    .titulo2{
        color: green !important;
        font-weight:bold;
        margin-left:20px;
        font-size:19px;
    }
    .tab-pane{
        margin-top:30px;
    }


    .conteo{
        font-size:14px;color:white;background-color:#035373;
    }

    

</style>
@stop


@section('enunciado')
    Tickets
@stop

@section('modulo')
    Tickets
@stop



@section('contenido')

<div class="row">
        <div class="col-l-12">
            <div class="ibox" style="border: lightgrey solid 1px;background-color:#FFFFFF">
                <div class="ibox-title" style="padding: 15px;">
                 
                    <div class="tabbable-panel" id="vistaTickets">
                            <ul class="nav nav-tabs">
                                <li class="">
                                    <a href="tck_edesalindex">
                                        <i class="fa fa-arrow-up"></i>
                                        <i class="fa fa-ticket"></i>
                                         Nuevo ticket
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="#vistaRecibidos" data-toggle="tab">
                                        <i class="fa fa-arrow-down"></i>
                                        Recibidos
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#vistaSolicitados" data-toggle="tab">
                                        <i class="fa fa-arrow-up"></i>
                                        Solicitados
                                    </a>
                                </li>
                                
                            </ul>
                        <div class="tabbable-line tabs-below">
                            <div class="tab-content">                        
                                <div class="tab-pane active" id="vistaRecibidos">
                                    <h2 class="titulo1">
                                        <img src="../images/ticketsImg/ticket.png" width="40" height="40">
                                        <img src="../images/ticketsImg/paper-plane.png" width="40" height="40">
                                       
                                        Tickets Recibidos
                                    </h2>
                                  <div class="tabbable-panel">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#reciNoIniciados" data-toggle="tab">
                                                    <i class="fa fa-eye"></i>
                                                    <i class="fa fa-exclamation-circle"></i>
                                                    Aun no iniciados
                                                    <span class="pull-right label conteo">
                                                        {{$recibidos}}
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#reciProceso" data-toggle="tab">
                                                    <i class="fa fa-cogs"></i>
                                                    En Proceso
                                                    <span class="pull-right label conteo">
                                                        {{$process}} 
                                                    </span>
                                                </a>
                                            </li>
                                        
                                            <li class="">
                                                <a href="#reciCompletados" data-toggle="tab">
                                                    <i class="fa fa-check-circle"></i>
                                                    Solucionado 
                                                    <span class="pull-right label conteo">
                                                        {{$solu}} 
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#reciCerrados" data-toggle="tab">
                                                    <i class="fa fa-archive"></i>
                                                    Cerrados
                                                    <span class="pull-right label conteo">
                                                        {{$cerrados}}
                                                        </span>
                                                </a>
                                            </li>

                                            <li class="">
                                                <a href="#reciRechazados" data-toggle="tab">
                                                <i class="fa fa-close"></i>
                                                Rechazados
                                                <span class="pull-right label conteo">
                                                {{$recha}} </span>
                                                </a>
                                            </li>

                                            
                                        </ul>
                                        <div class="tabbable-line tabs-below">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="reciNoIniciados">
                                                    <div class="row" style="border-top: 1px solid black;"></div>
                                                        <h2 class="titulo2">
                                                        <img src="../images/ticketsImg/timer.png" width="40" height="40">
                                                        Aún no Iniciados</h2>
                                                    <div class="row" style="border-top: 1px solid black;"></div><br>

                                                    <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example"
                                                        style="color: black;margin-top: 20px" >
                                                        <thead id="header" class="">
                                                        <tr style="background-color: lightgrey">
                                                            <th style="border: solid 1px grey;">N° de ticket</th>
                                                            <th style="border: solid 1px grey;" class="text-center"><i class="fa fa-clock-o"></i></th>
                                                            <th style="border: solid 1px grey;">Titulo</th>
                                                            <th style="border: solid 1px grey;">Solicitante</th>
                                                            <th style="border: solid 1px grey;" class="text-center">Fecha de Solicitud</th>
                                                            <th style="border: solid 1px grey;" class="text-center">Fecha de entrega</th>
                                                            <th style="border: solid 1px grey;"></th>



                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($tickets as $ticket)
                                                                @if($ticket->estado=='Recibido')
                                                                <tr style="background-color: deepskyblue;" id="dtRecibi">

                                                                    <td style="border: solid 1px grey; "><b>{{$ticket->id}}</b></td>
                                                                    <td style="border: solid 1px grey; width: 100px">
                                                                    @if($ticket->estado=='En proceso')
                                                                            <strong class="pull-left"><?php
                                                                                $datetime1 = new DateTime("now");
                                                                                $datetime2 = new DateTime($ticket->fechaentregareal);
                                                                                $interval = date_diff($datetime1, $datetime2);
                                                                                echo $interval->format('%R%a dias');
                                                                                ?> restantes</strong><br>
                                                                            <div class="progress" style="height: 10px;">
                                                                                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                    <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
                                                                    <td style="border: solid 1px grey;" class="text-center">
                                                                        <small>
                                                                            <?php
                                                                            $date=date_create($ticket->fechasolicitud);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        </small>
                                                                    </td>
                                                                    <td style="border: solid 1px grey;" class="text-center">
                                                                        <small>
                                                                            @if($ticket->estado=='En proceso')
                                                                                    <?php
                                                                                    $date=date_create($ticket->fechaentregareal);
                                                                                    echo date_format($date,"d/m/Y");
                                                                                    ?>
                                                                                @elseif($ticket->estado=='Recibido')
                                                                                    <?php
                                                                                    $date=date_create($ticket->fechasolaprox);
                                                                                    echo date_format($date,"d/m/Y");
                                                                                    ?>
                                                                            @endif
                                                                        </small>
                                                                    </td>
                                                                    <td style="border: solid 1px grey;">
                                                                        @if($ticket->estado=='Recibido')
                                                                        <button id="{{$ticket->id}}" type="button" style="border:solid 1px black" class="btn btn-md btn-default tck_infoticket" style="color:black">
                                                                            <i class="fa fa-eye"></i> Ver
                                                                        </button>
                                                                        @endif
                                                                        @if($ticket->estado=='En proceso')
                                                                            <a href="administrarticket?id={{$ticket->id}}" style="border:solid 1px black" type="button" class="btn btn-md btn-default  btn_administrarticket" id="{{$ticket->id}}" >
                                                                                <i class="fa fa-cog"></i> Administrar</a>
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
                                                <div class="tab-pane" id="reciProceso">
                                                    <div class="row" style="border-top: 1px solid black;"></div>
                                                        <h2 class="titulo2">
                                                        <img src="../images/ticketsImg/process.png" width="40" height="40">
                                                        En Proceso</h2>
                                                    <div class="row" style="border-top: 1px solid black;"></div><br>


                                                    <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example"
                                                        style="color: black;margin-top: 20px" >
                                                        <thead id="header" class="">
                                                        <tr style="background-color: lightgrey">
                                                            <th style="border: solid 1px grey;">N° de ticket</th>
                                                            <th style="border: solid 1px grey;" class="text-center"><i class="fa fa-clock-o"></i></th>
                                                            <th style="border: solid 1px grey;">Titulo</th>
                                                            <th style="border: solid 1px grey;">Solicitante</th>
                                                            <th style="border: solid 1px grey;" class="text-center">Fecha de Solicitud</th>
                                                            <th style="border: solid 1px grey;" class="text-center">Fecha de entrega</th>
                                                            <th style="border: solid 1px grey;"></th>



                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($tickets as $ticket)
                                                                
                                                            
                                                                    @if($ticket->estado=='En proceso')
                                                                    <tr style="background-color: lightcyan">

                                                                        <td style="border: solid 1px grey;"><b>{{$ticket->id}}</b></td>
                                                                        <td style="border: solid 1px grey; width: 100px">
                                                                            @if($ticket->estado=='En proceso')
                                                                                <strong class="pull-left"><?php
                                                                                    $datetime1 = new DateTime("now");
                                                                                    $datetime2 = new DateTime($ticket->fechaentregareal);
                                                                                    $interval = date_diff($datetime1, $datetime2);
                                                                                    echo $interval->format('%R%a dias');
                                                                                    ?> restantes</strong><br>
                                                                                <div class="progress" style="height: 10px;">
                                                                                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                </div>
                                                                            @endif
                                                                        </td>
                                                                        <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                        <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
                                                                        <td style="border: solid 1px grey;" class="text-center">
                                                                            <small>
                                                                                <?php
                                                                                $date=date_create($ticket->fechasolicitud);
                                                                                echo date_format($date,"d/m/Y");
                                                                                ?>
                                                                            </small>
                                                                        </td>
                                                                        <td style="border: solid 1px grey;" class="text-center">
                                                                            <small>
                                                                                @if($ticket->estado=='En proceso')
                                                                                    <?php
                                                                                    $date=date_create($ticket->fechaentregareal);
                                                                                    echo date_format($date,"d/m/Y");
                                                                                    ?>
                                                                                @elseif($ticket->estado=='Recibido')
                                                                                    <?php
                                                                                    $date=date_create($ticket->fechasolaprox);
                                                                                    echo date_format($date,"d/m/Y");
                                                                                    ?>
                                                                                @endif
                                                                            </small>
                                                                        </td>
                                                                        <td style="border: solid 1px grey;">
                                                                            @if($ticket->estado=='Recibido')
                                                                                <button id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
                                                                                    <i class="fa fa-eye"></i> Ver
                                                                                </button>
                                                                            @endif
                                                                            @if($ticket->estado=='En proceso')
                                                                                <a href="administrarticket?id={{$ticket->id}}" type="button" style="border:solid 1px black" class="btn btn-md btn-default btn_administrarticket" id="{{$ticket->id}}" >
                                                                                    <i class="fa fa-cog"></i> Administrar</a>
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
                                                <div class="tab-pane" id="reciCompletados">
                                                    <div class="row" style="border-top: 1px solid black;"></div>
                                                        <h2 class="titulo2">
                                                        <img src="../images/ticketsImg/work.png" width="40" height="40">
                                                        Completados</h2>
                                                    <div class="row" style="border-top: 1px solid black;"></div><br>

                                                    <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                                                        <thead id="header" class="">
                                                        <tr style="background-color: lightgrey">
                                                            <th style="border: solid 1px grey;">N° de ticket</th>
                                                            <th style="border: solid 1px grey;">Estado</th>
                                                            <th style="border: solid 1px grey;">Titulo</th>
                                                            <th style="border: solid 1px grey;">Solicitante</th>
                                                            <th style="border: solid 1px grey;">Fecha de Solicitud</th>
                                                            <th style="border: solid 1px grey;">Fecha de Entrega</th>
                                                            <th style="border: solid 1px grey;"></th>



                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($tickets as $ticket)
                                                            @if($ticket->estado=='Solucionado')
                                                                <tr>
                                                                    <td style="border: solid 1px grey; background-color: lightblue"><b>{{$ticket->id}}</b></td>
                                                                    @if($ticket->estado=='Recibido')
                                                                        <td style="border: solid 1px grey;"><span class="label label-success">{{$ticket->estado}}</span></td>
                                                                    @elseif($ticket->estado=='En proceso')
                                                                        <td style="border: solid 1px grey;"><span class="label label-warning">{{$ticket->estado}}</span></td>
                                                                    @elseif($ticket->estado=='Solucionado')
                                                                        <td style="border: solid 1px grey;"><span class="label label-primary">{{$ticket->estado}}</span></td>
                                                                    @elseif($ticket->estado=='Rechazado')
                                                                        <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                                                    @endif
                                                                    <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                    <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
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
                                                                            @if($ticket->estado==='En proceso' )
                                                                                <?php
                                                                                $date=date_create($ticket->fechaentregareal);
                                                                                echo date_format($date,"d/m/Y");
                                                                                ?>
                                                                            @elseif($ticket->estado==='Solucionado' || $ticket->estado==='Cerrado')
                                                                                <?php
                                                                                $date=date_create($ticket->fechasolucion);
                                                                                echo date_format($date,"d/m/Y");
                                                                                ?>
                                                                            @elseif($ticket->estado=='Recibido')
                                                                                <?php
                                                                                $date=date_create($ticket->fechasolaprox);
                                                                                echo date_format($date,"d/m/Y");
                                                                                ?>
                                                                            @endif
                                                                        </small>
                                                                    </td>
                                                                    <td style="border: solid 1px grey;">
                                                                        <a href="administrarticket?id={{$ticket->id}}" id="{{$ticket->id}}" type="button" style="border:solid 1px black" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
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
                                                <div class="tab-pane" id="reciCerrados">
                                                    <div class="row" style="border-top: 1px solid black;"></div>
                                                        <h2 class="titulo2">
                                                        <img src="../images/ticketsImg/close.png" width="40" height="40">
                                                        Cerrados</h2>
                                                    <div class="row" style="border-top: 1px solid black;"></div><br>
                                                    <table id="reservasdenegadas" 
                                                        class="dataTables-example1 table table-hover table-responsive table-striped
                                                        table-mail dataTables-example" style="color: black;margin-top: 20px;width:100%;" >
                                                            <thead id="header" class="">
                                                            <tr style="background-color: lightgrey">
                                                                <th style="border: solid 1px grey;">N° de ticket</th>
                                                                <th style="border: solid 1px grey;">Estado</th>
                                                                <th style="border: solid 1px grey;">Titulo</th>
                                                                <th style="border: solid 1px grey;">Solicitante</th>
                                                                <th style="border: solid 1px grey;">Fecha de Solicitud</th>
                                                                <th style="border: solid 1px grey;">Fecha de Entrega</th>
                                                                <th style="border: solid 1px grey;"></td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($tickets as $ticket)
                                                                @if($ticket->estado=='Cerrado')
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
                                                                        @endif
                                                                        <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                        <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
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
                                                                                @if($ticket->estado==='En proceso' )
                                                                                    <?php
                                                                                    $date=date_create($ticket->fechaentregareal);
                                                                                    echo date_format($date,"d/m/Y");
                                                                                    ?>
                                                                                @elseif($ticket->estado==='Solucionado' || $ticket->estado==='Cerrado')
                                                                                    <?php
                                                                                    $date=date_create($ticket->fechasolucion);
                                                                                    echo date_format($date,"d/m/Y");
                                                                                    ?>
                                                                                @elseif($ticket->estado=='Recibido')
                                                                                    <?php
                                                                                    $date=date_create($ticket->fechasolaprox);
                                                                                    echo date_format($date,"d/m/Y");
                                                                                    ?>
                                                                                @endif
                                                                            </small>
                                                                        </td>
                                                                        <td style="border: solid 1px grey;">
                                                                            <a href="administrarticket?id={{$ticket->id}}" id="{{$ticket->id}}" type="button" style="border:solid 1px black" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
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

                                                <div class="tab-pane" id="reciRechazados">
                                                    <div class="row" style="border-top: 1px solid black;"></div>
                                                        <h2 class="titulo2">
                                                        <img src="../images/ticketsImg/cancel.png" width="40" height="40">
                                                        Rechazados</h2>
                                                    <div class="row" style="border-top: 1px solid black;"></div><br>
                                                    <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                                                        <thead id="header" class="">
                                                        <tr style="background-color: lightgrey">
                                                            <th style="border: solid 1px grey;">N° de ticket</th>
                                                            <th style="border: solid 1px grey;">Estado</th>
                                                            <th style="border: solid 1px grey;">Titulo</th>
                                                            <th style="border: solid 1px grey;">Solicitante</th>
                                                            <th style="border: solid 1px grey;">Fecha de Solicitud</th>
                                                            <th style="border: solid 1px grey;">Fecha de Entrega</th>
                                                            <th style="border: solid 1px grey;"></th>



                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($tickets as $ticket)
                                                            @if($ticket->estado=='Rechazado')
                                                                <tr>
                                                                    <td style="border: solid 1px grey; background-color: lightblue"><b>{{$ticket->id}}</b></td>
                                                                    @if($ticket->estado=='Recibido')
                                                                        <td style="border: solid 1px grey;"><span class="label label-success">{{$ticket->estado}}</span></td>
                                                                    @elseif($ticket->estado=='En proceso')
                                                                        <td style="border: solid 1px grey;"><span class="label label-warning">{{$ticket->estado}}</span></td>
                                                                    @elseif($ticket->estado=='Solucionado')
                                                                        <td style="border: solid 1px grey;"><span class="label label-primary">{{$ticket->estado}}</span></td>
                                                                    @elseif($ticket->estado=='Rechazado')
                                                                        <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                                                    @endif
                                                                    <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                    <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
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
                                                                            @if($ticket->estado==='En proceso' )
                                                                                <?php
                                                                                $date=date_create($ticket->fechaentregareal);
                                                                                echo date_format($date,"d/m/Y");
                                                                                ?>
                                                                            @elseif($ticket->estado==='Solucionado' || $ticket->estado==='Cerrado')
                                                                                <?php
                                                                                $date=date_create($ticket->fechasolucion);
                                                                                echo date_format($date,"d/m/Y");
                                                                                ?>
                                                                            @elseif($ticket->estado=='Recibido')
                                                                                <?php
                                                                                $date=date_create($ticket->fechasolaprox);
                                                                                echo date_format($date,"d/m/Y");
                                                                                ?>
                                                                            @endif
                                                                        </small>
                                                                    </td>
                                                                    <td style="border: solid 1px grey;">
                                                                        <a href="administrarticket?id={{$ticket->id}}" id="{{$ticket->id}}" type="button" style="border:solid 1px black" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
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





                                </div>
                                <div class="tab-pane" id="vistaSolicitados">
                                    <h2 class="titulo1">
                                        <img src="../images/ticketsImg/ticket.png" width="40" height="40">
                                        <img src="../images/ticketsImg/origami.png" width="40" height="40">
                                        Tickets Solicitados
                                    </h2>
                                    <div class="tabbable-panel">
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#soliRecibidos" data-toggle="tab">
                                                        <i class="fa fa-eye"></i>
                                                        <i class="fa fa-check"></i>
                                                        Recibidos 
                                                        <span class="pull-right label conteo">
                                                            {{$recibidosSoli}} 
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#soliProceso" data-toggle="tab">
                                                        <i class="fa fa-cogs"></i>
                                                        En Proceso
                                                        <span class="pull-right label conteo">
                                                                {{$processSoli}} 
                                                        </span>
                                                    </a>
                                                </li>
                                            
                                                <li class="">
                                                    <a href="#soliSolucionados" data-toggle="tab">
                                                        <i class="fa fa-check-circle"></i>
                                                        Solucionados
                                                        
                                                        <span class="pull-right label conteo">
                                                            {{$soluSoli}} 
                                                        </span>
                                                        </a>
                                                </li>
                                                <li class="">
                                                    <a href="#soliRechazados" data-toggle="tab">
                                                        <i class="fa fa-close"></i>
                                                        Rechazados
                                                        <span class="pull-right label conteo">
                                                            {{$rechaSoli}} 
                                                        </span>
                                                        </a>
                                                </li>
                                                <li class="">
                                                    <a href="#soliCerrados" data-toggle="tab">
                                                        <i class="fa fa-archive"></i>
                                                        Cerrados
                                                        <span class="pull-right label conteo">
                                                            {{$cerradoSoli}} 
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tabbable-line tabs-below">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="soliRecibidos">
                                                    <div class="row" style="border-top: 1px solid black;"></div>
                                                        <h2 class="titulo2">
                                                        <img src="../images/ticketsImg/request.png" width="40" height="40">
                                                        Recibidos</h2>
                                                    <div class="row" style="border-top: 1px solid black;"></div><br>
                                                    <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                                                        <thead id="header" class="">
                                                        <tr style="background-color: lightgrey">
                                                            <th style="border: solid 1px grey;">N° de ticket</th>
                                                            <th style="border: solid 1px grey;">Estado</th>
                                                            <th style="border: solid 1px grey;">Titulo</th>
                                                            <th style="border: solid 1px grey;">Usuario Asignado</th>
                                                            <th style="border: solid 1px grey;">Fecha de Solicitud</th>
                                                            <th style="border: solid 1px grey;">F. Solucion aproximada</th>
                                                            <th style="border: solid 1px grey;"></th>



                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($ticketsSoli as $ticket)
                                                        @if($ticket->estado == 'Recibido')
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
                                                                    @elseif($ticket->estado=='En pausa')
                                                                        <td style="border: solid 1px grey;"><span class="label label-info">{{$ticket->estado}}</span></td>
                                                                    @elseif($ticket->estado=='Cancelado')
                                                                        <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                                                    @endif
                                                                    <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                    <td style="border: solid 1px grey;"><small><b>{{$ticket->nombreasignado}} {{$ticket->apellidoasignado}}</b></small></td>
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
                                                                            $date=date_create($ticket->fechasolaprox);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        </small>
                                                                    </td>
                                                                    <td style="border: solid 1px grey;">

                                                                                <a href="verticketsolicitado?id={{$ticket->id}}" id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
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
                                                    <div class="tab-pane" id="soliProceso">
                                                        <div class="row" style="border-top: 1px solid black;"></div>
                                                            <h2 class="titulo2">
                                                            <img src="../images/ticketsImg/process.png" width="40" height="40">
                                                            En Proceso</h2>
                                                        <div class="row" style="border-top: 1px solid black;"></div><br>

                                                        


                                                        <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                                                            <thead id="header" class="">
                                                            <tr style="background-color: lightgrey">
                                                                <th style="border: solid 1px grey;">N° de ticket</th>
                                                                <th style="border: solid 1px grey;">Estado</th>
                                                                <th style="border: solid 1px grey;">Titulo</th>
                                                                <th style="border: solid 1px grey;">Usuario Asignado</th>
                                                                <th style="border: solid 1px grey;">Fecha de Solicitud</th>
                                                                <th style="border: solid 1px grey;">F. Solucion aproximada</th>
                                                                <th style="border: solid 1px grey;"></th>



                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($ticketsSoli as $ticket)
                                                            @if($ticket->estado == 'En proceso')
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
                                                                        @elseif($ticket->estado=='En pausa')
                                                                            <td style="border: solid 1px grey;"><span class="label label-info">{{$ticket->estado}}</span></td>
                                                                        @elseif($ticket->estado=='Cancelado')
                                                                            <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                                                        @endif
                                                                        <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                        <td style="border: solid 1px grey;"><small><b>{{$ticket->nombreasignado}} {{$ticket->apellidoasignado}}</b></small></td>
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
                                                                                $date=date_create($ticket->fechasolaprox);
                                                                                echo date_format($date,"d/m/Y");
                                                                                ?>
                                                                            </small>
                                                                        </td>
                                                                        <td style="border: solid 1px grey;">

                                                                                    <a href="verticketsolicitado?id={{$ticket->id}}" id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
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
                                                    <div class="tab-pane" id="soliSolucionados">
                                                    <div class="row" style="border-top: 1px solid black;"></div>
                                                            <h2 class="titulo2">
                                                            <img src="../images/ticketsImg/work.png" width="40" height="40">
                                                            Solucionados</h2>
                                                        <div class="row" style="border-top: 1px solid black;"></div><br>


                                                        <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                                                            <thead id="header" class="">
                                                            <tr style="background-color: lightgrey">
                                                                <th style="border: solid 1px grey;">N° de ticket</th>
                                                                <th style="border: solid 1px grey;">Estado</th>
                                                                <th style="border: solid 1px grey;">Titulo</th>
                                                                <th style="border: solid 1px grey;">Usuario Asignado</th>
                                                                <th style="border: solid 1px grey;">Fecha de Solicitud</th>
                                                                <th style="border: solid 1px grey;">F. Solucion aproximada</th>
                                                                <th style="border: solid 1px grey;"></th>



                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($ticketsSoli as $ticket)
                                                            @if($ticket->estado == 'Solucionado')
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
                                                                        @elseif($ticket->estado=='En pausa')
                                                                            <td style="border: solid 1px grey;"><span class="label label-info">{{$ticket->estado}}</span></td>
                                                                        @elseif($ticket->estado=='Cancelado')
                                                                            <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                                                        @endif
                                                                        <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                        <td style="border: solid 1px grey;"><small><b>{{$ticket->nombreasignado}} {{$ticket->apellidoasignado}}</b></small></td>
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
                                                                                $date=date_create($ticket->fechasolaprox);
                                                                                echo date_format($date,"d/m/Y");
                                                                                ?>
                                                                            </small>
                                                                        </td>
                                                                        <td style="border: solid 1px grey;">

                                                                                    <a href="verticketsolicitado?id={{$ticket->id}}" id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
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
                                                    <div class="tab-pane" id="soliRechazados">
                                                        <div class="row" style="border-top: 1px solid black;"></div>
                                                            <h2 class="titulo2">
                                                            <img src="../images/ticketsImg/cancel.png" width="40" height="40">
                                                            Rechazados</h2>
                                                        <div class="row" style="border-top: 1px solid black;"></div><br>
                                                        <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                                                            <thead id="header" class="">
                                                            <tr style="background-color: lightgrey">
                                                                <th style="border: solid 1px grey;">N° de ticket</th>
                                                                <th style="border: solid 1px grey;">Estado</th>
                                                                <th style="border: solid 1px grey;">Titulo</th>
                                                                <th style="border: solid 1px grey;">Usuario Asignado</th>
                                                                <th style="border: solid 1px grey;">Fecha de Solicitud</th>
                                                                <th style="border: solid 1px grey;">F. Solucion aproximada</th>
                                                                <th style="border: solid 1px grey;"></th>



                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($ticketsSoli as $ticket)
                                                            @if($ticket->estado == 'Rechazado')
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
                                                                        @elseif($ticket->estado=='En pausa')
                                                                            <td style="border: solid 1px grey;"><span class="label label-info">{{$ticket->estado}}</span></td>
                                                                        @elseif($ticket->estado=='Cancelado')
                                                                            <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                                                        @endif
                                                                        <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                        <td style="border: solid 1px grey;"><small><b>{{$ticket->nombreasignado}} {{$ticket->apellidoasignado}}</b></small></td>
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
                                                                                $date=date_create($ticket->fechasolaprox);
                                                                                echo date_format($date,"d/m/Y");
                                                                                ?>
                                                                            </small>
                                                                        </td>
                                                                        <td style="border: solid 1px grey;">

                                                                                    <a href="verticketsolicitado?id={{$ticket->id}}" id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
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
                                                    <div class="tab-pane" id="soliCerrados">
                                                    <div class="row" style="border-top: 1px solid black;"></div>
                                                            <h2 class="titulo2">
                                                            <img src="../images/ticketsImg/close.png" width="40" height="40">
                                                            Cerrados</h2>
                                                        <div class="row" style="border-top: 1px solid black;"></div><br>


                                                        <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                                                            <thead id="header" class="">
                                                            <tr style="background-color: lightgrey">
                                                                <th style="border: solid 1px grey;">N° de ticket</th>
                                                                <th style="border: solid 1px grey;">Estado</th>
                                                                <th style="border: solid 1px grey;">Titulo</th>
                                                                <th style="border: solid 1px grey;">Usuario Asignado</th>
                                                                <th style="border: solid 1px grey;">Fecha de Solicitud</th>
                                                                <th style="border: solid 1px grey;">F. Solucion aproximada</th>
                                                                <th style="border: solid 1px grey;"></th>
                                    
                                    
                                    
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($ticketsSoli as $ticket)
                                                            @if($ticket->estado=='Cerrado')
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
                                                                        @elseif($ticket->estado=='En pausa')
                                                                            <td style="border: solid 1px grey;"><span class="label label-info">{{$ticket->estado}}</span></td>
                                                                        @elseif($ticket->estado=='Cancelado')
                                                                            <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                                                        @endif
                                                                        <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                        <td style="border: solid 1px grey;"><small><b>{{$ticket->nombreasignado}} {{$ticket->apellidoasignado}}</b></small></td>
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
                                                                                $date=date_create($ticket->fechasolaprox);
                                                                                echo date_format($date,"d/m/Y");
                                                                                ?>
                                                                            </small>
                                                                        </td>
                                                                        <td style="border: solid 1px grey;">
                                    
                                                                                    <a href="verticketsolicitado?id={{$ticket->id}}" id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
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

                                



                                </div>
                            </div>
                            
                        </div>
			        </div>

                    
                </div>
            </div>
        </div>
    </div>

    
    <div class="row hidden" id="divinfoticket">
    </div>



    {{--MODAL PARA TICKET GENERAL--}}
    <div class="modal inmodal fade" id="ticketgeneral" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title"></h5>
                    <h1><i class="fa fa-ticket"></i></h1>
                </div>
                <div class="modal-body">
                   <div class="row">
                       <div class="col-lg-12">
                           <div class="ibox float-e-margins">
                               <div class="ibox-title">

                                   <h5><i class="fa fa-bolt"></i> Ticket General</h5>
                                   <div class="ibox-tools">
                                       <a class="collapse-link">
                                           <i class="fa fa-chevron-up"></i>
                                       </a>


                                   </div>
                               </div>
                               <div class="ibox-content">
                                   <form class="form-horizontal" id="frm_express">
                                       <div class="alert alert-info alert-dismissible" style="color:black">
                                           <i class="fa fa-info"></i>
                                           El ticket general puedes utlizarlo para cualquier
                                           requerimiento que necesites entre tu area y otra en especifico
                                       </div>
                                       <div class="form-group"><label class="col-lg-2 control-label">Titulo:</label>

                                           <div class="col-lg-6 input-group">
                                               <input id="tituloexpress" required title="Campo obligatorio" type="text" placeholder="Titulo" class="form-control">
                                           </div>
                                       </div>

                                       <div class="form-group">
                                           <label class="col-lg-2 control-label">Asignar a:</label>
                                           <div class="col-lg-5 input-group" id="the-basics" >
                                               <input type="text" placeholder="Digite el nombre del usuario" class="form-control typeahead" id="usuarioexpress" >
                                           </div>
                                       </div>

                                       {{-- <div class="form-group"><label class="col-lg-2 control-label">Adjuntar archivo</label>

                                            <div class="col-lg-6 input-group">
                                                <input readonly="true" id="archivoexpress" required title="Campo obligatorio" type="text" placeholder="Archivo" class="form-control">
                                            </div>
                                        </div>--}}


                                       <div class="form-group">
                                           <label class="col-lg-2 control-label" for="">Fecha de solucion aproximada:</label>
                                           <div class='col-lg-4 date input-group' id='datetimepicker1'>
                                               <input id="fechasolaproxexpress" type='text' class="form-control" />
                                               <span class="input-group-addon" >
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                           </div>
                                       </div>



                                       <div class="form-group"><label class="col-lg-2 control-label">Descripcion:</label>

                                           <div class="col-lg-6 input-group">
                                               <textarea name="" class="form-control" id="descripcionexpress" cols="10" rows="5"></textarea>
                                           </div>
                                       </div>


                                       <div class="form-group" >
                                           <div class="col-lg-offset-2 col-lg-8 input-group">
                                               <button class="btn btn-md btn-primary" id="btn_guardarexpress" type="button"><i class="fa fa-save"></i> Enviar Ticket</button>
                                           </div>
                                       </div>
                                   </form>
                               </div>
                           </div>
                       </div>
                   </div>
                </div>

                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA TICKET DE INFORMATICA--}}
    <div class="modal inmodal fade" id="ticketinformatica" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title"></h5>
                    <h1><i class="fa fa-ticket"></i></h1>
                </div>
                <div class="modal-body">
                    @if(Session::get('idusuario')==1 || Session::get('idusuario')==2 || Session::get('idusuario')==3 || Session::get('idusuario')==4)
                        <div class="row " style="margin-top: 20px" id="ticketextraordinario">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5><i class="fa fa-diamond"></i> Ticket Informatica</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-toggle-down"></i>
                                            </a>

                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <form class="form-horizontal" id="frm_extraordinario">

                                            <div class="form-group"><label class="col-lg-2 control-label">Titulo:</label>

                                                <div class="col-lg-6 input-group">
                                                    <input type="text" placeholder="Titulo" id="tituloextraordinario" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-lg-2 control-label">Asignado a:</label>

                                                <div class="col-lg-5 input-group" id="the-basics">
                                                    <input type="text" id="usuarioextraordinario" class="form-control" value="{{Session::get('nombreusuario')}}" readonly="readonly">
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-lg-2 control-label">Solicitante:</label>

                                                <div class="col-lg-5 input-group" id="the-basics">
                                                    <input type="text" id="usersolicitante" class="form-control typeahead" >
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="">Fecha de solucion aproximada:</label>
                                                <div class='col-lg-4 date input-group' id='datetimepicker2'>
                                                    <input id="fechasolaproxextraordinario" type='text' class="form-control" />
                                                    <span class="input-group-addon" >
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-lg-2 control-label">Sistemas:</label>

                                                <div class="col-lg-5 input-group">
                                                    <select name="" class="form-control" id="sistemaspersonalizado">
                                                        <option value="">Seleccione un sistema...</option>
                                                        @foreach($sistemas as $sistema)

                                                            <option value="{{$sistema->id}}">{{$sistema->nombre}}</option>

                                                        @endforeach
                                                    </select>
                                                    <div class="alert-dismissible alert alert-warning" style="color: black;"><i class="fa fa-warning"></i>
                                                        El campo de sistema puede
                                                        quedar vacio si tu ticket es en relacion a otra incidencia o requerimiento
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group hidden" id="divmodulos"><label class="col-lg-2 control-label">Modulos:</label>

                                                <div class="col-lg-5 input-group">
                                                    <select name="" class="form-control" id="modulos">
                                                        <option value="">Selecciones un modulo...</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-lg-2 control-label">Descripcion:</label>

                                                <div class="col-lg-6 input-group">

                                                    <textarea name="" class="form-control" id="descextraordinario" cols="10" rows="5"></textarea>
                                                </div>
                                            </div>




                                            <div class="form-group" >

                                                @if(Session::get('idusuario')==1 || Session::get('idusuario')==2 || Session::get('idusuario')==3 || Session::get('idusuario')==4)
                                                    <div class="col-lg-offset-2 col-lg-10 input-group">
                                                        <button class="btn btn-md btn-primary" id="btn_guardarextraordinario1" type="button"><i class="fa fa-save"></i> Enviar Ticket</button>
                                                    </div>
                                                @else
                                                    <div class="col-lg-offset-2 col-lg-10 input-group">
                                                        <button class="btn btn-md btn-primary" id="btn_guardarextraordinario" type="button"><i class="fa fa-save"></i> Enviar Ticket</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row " style="margin-top: 20px" id="ticketextraordinario">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5><i class="fa fa-diamond"></i> Ticket Informatica</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-toggle-down"></i>
                                            </a>

                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <form class="form-horizontal" id="frm_extraordinario">

                                            <div class="form-group"><label class="col-lg-2 control-label">Titulo</label>

                                                <div class="col-lg-6 input-group">
                                                    <input type="text" placeholder="Titulo" id="tituloextraordinario" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-lg-2 control-label">Asignacion de usuario</label>

                                                <div class="col-lg-5 input-group" id="the-basics">
                                                    <select name="" id="usuarioextraordinario" class="form-control">
                                                        <option value="">Seleccione un usuario...</option>
                                                        @foreach($usuarios as $usuario)
                                                            <option value="{{$usuario->id}}">{{$usuario->nombre}} {{$usuario->apellido}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="">Fecha de solucion aproximada</label>
                                                <div class='col-lg-4 date input-group' id='datetimepicker2'>
                                                    <input id="fechasolaproxextraordinario" type='text' class="form-control" />
                                                    <span class="input-group-addon" >
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-lg-2 control-label">Sistemas</label>

                                                <div class="col-lg-5 input-group">
                                                    <select name="" class="form-control" id="sistemaspersonalizado">
                                                        <option value="">Seleccione un sistema...</option>
                                                        @foreach($sistemas as $sistema)

                                                            <option value="{{$sistema->id}}">{{$sistema->nombre}}</option>

                                                        @endforeach
                                                    </select>
                                                    <div class="alert-dismissible alert alert-warning" style="color: black;"><i class="fa fa-warning"></i>
                                                        El campo de sistema puede
                                                        quedar vacio si tu ticket es en relacion a otra incidencia o requerimiento
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group hidden" id="divmodulos"><label class="col-lg-2 control-label">Modulos</label>

                                                <div class="col-lg-5 input-group">
                                                    <select name="" class="form-control" id="modulos">
                                                        <option value="">Selecciones un modulo...</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                                                <div class="col-lg-6 input-group">

                                                    <textarea name="" class="form-control" id="descextraordinario" cols="10" rows="5"></textarea>
                                                </div>
                                            </div>




                                            <div class="form-group" >
                                                <div class="col-lg-offset-2 col-lg-10 input-group">
                                                    <button class="btn btn-md btn-primary" id="btn_guardarextraordinario" type="button"><i class="fa fa-save"></i> Enviar Ticket</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    {{--AUTO TICKET--}}
    <div class="modal inmodal fade" id="autoticket" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title"></h5>
                    <h1><i class="fa fa-ticket"></i></h1>
                </div>
                <div class="modal-body">
                    <div class="row " style="margin-top: 20px" id="ticketquick">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><i class="fa fa-bomb"></i> Auto Ticket</h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-toggle-down"></i>
                                        </a>

                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <form class="form-horizontal" id="frm_quick">

                                        <h2><b>Datos del ticket</b></h2>

                                        <div class="form-group"><label class="col-lg-2 control-label">Titulo</label>

                                            <div class="col-lg-6 input-group">
                                                <input type="text" placeholder="Titulo" id="tituloquick" class="form-control">

                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-lg-2 control-label">Solicitante</label>

                                            <div class="col-lg-5 input-group" id="the-basics">
                                                <input type="text" class="form-control typeahead" id="usuarioquick">
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-lg-2 control-label">Categoria de ticket</label>

                                            <div class="col-lg-5 input-group" id="the-basics">
                                                <select name="" id="categoriaquick" class="form-control">
                                                    <option value="">seleccione una categoria</option>
                                                    @foreach($categorias as $categoria)
                                                        <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-lg-2 control-label">Sistemas</label>

                                            <div class="col-lg-5 input-group">
                                                <select name="" class="form-control" id="sistemasquick">
                                                    <option value="">Selecciones un sistema...</option>
                                                    @foreach($sistemas as $sistema)

                                                        <option value="{{$sistema->id}}">{{$sistema->nombre}}</option>

                                                    @endforeach
                                                </select>
                                                <div class="alert alert-info alert-dismissible" style="color:black">
                                                    <i class="fa fa-info"></i>
                                                    El campo de sistema puede
                                                    quedar vacio si tu ticket es en relacion a otra incidencia o requerimiento
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group hidden" id="divmoduloquick"><label class="col-lg-2 control-label">Modulos</label>

                                            <div class="col-lg-5 input-group">
                                                <select name="" class="form-control" id="modquick">
                                                    <option value="">Seleccione un modulo...</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                                            <div class="col-lg-6 input-group">

                                                <textarea name="" class="form-control" id="descripcionquick" cols="10" rows="3"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-lg-2 control-label">Solucion</label>

                                            <div class="col-lg-6 input-group">

                                                <textarea name="" class="form-control" id="solucionquick" cols="10" rows="3"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label" for="">Fecha de solucion</label>
                                            <div class='col-lg-4 date input-group' id='datetimepicker3'>
                                                <input id="fechasolautoticket" type='text' class="form-control" />
                                                <span class="input-group-addon" >
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                            </div>
                                        </div>


                                        <h2><b>Datos de bitacora</b></h2>

                                        <div class="form-group"><label class="col-lg-2 control-label">Tiempo dedicado</label>

                                            <div class="col-lg-2 input-group">

                                                <input type="number" class="form-control" id="tiempodedicado" step="0.25">
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-lg-2 control-label">Linea de bitacora</label>

                                            <div class="col-lg-6 input-group">
                                                <textarea name="" class="form-control" disabled="disabled" id="lineabitacora" cols="30" rows="2"></textarea>
                                            </div>
                                        </div>



                                        <div class="form-group" >
                                            <div class="col-lg-offset-2 col-lg-10 input-group">
                                                <button class="btn btn-md btn-primary" id="btn_guardarquick" type="button"><i class="fa fa-save"></i> Enviar Ticket</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>



@stop

@section('scripts')
    <script src="../js/plugins/fullcalendar/moment.min.js"></script>

    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <script src="../js/plugins/dataTables/datatables.min.js"></script>
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>
    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>
    <script src="../js/funciones/tickets.js"></script>
                                    
   
@stop