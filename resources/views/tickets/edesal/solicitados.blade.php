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
    Solicitados
@stop

@section('contenido')
    <div class="row" id="tablatickets">
        <div class="col-lg-12">
            <div class="ibox" style="border: lightgrey solid 1px;background-color:#FFFFFF">

                <div class="ibox-content" style="padding: 5px">
                    <a href="tck_edesalindex" style="margin-right: 5px;background-color:purple;" class="btn btn-success btn-md pull-left"  type="button"><i class="fa fa-ticket"></i> Nuevo ticket</a>
                    <a href="tck_edesalshow" style="background-color:black;" class="btn btn-info btn-md pull-left"  type="button"><i class="fa fa-ticket"></i>Tickets Recibidos</a>
                </div>
                
                    
                
                <div class="ibox-content" id="" style="border: 1px solid #FFFFFF">
                    
                  
                    <a href="" style="color:white;background-color:#80807F;width:20%" 
                    class="btn  btn-default btn-md pull-right"  type="button" id="btnCerrados" >
                    
                    <span><i class="fa fa-ticket" ></i> Tickets Soli. Cerrados</span>
                    <span class="pull-right label" 
                     style="font-size:14px;color:white;background-color:#035373;">
                    {{$cerrado}} </span>
                </a>
                    <a href="" style="color:black;" class="btn  btn-warning btn-md pull-right hidden"   type="button" id="btnSolicitados" ><i class="fa fa-ticket" ></i>Regresar</a>
                    <br><br>
                    <div id="tablaGeneral" style="border: 1px solid #FFFFFF">
                    <h2 style="color:blue"><i class="fa fa-home"></i> <strong>Pantalla General</strong></h2><br>
                    <h1><i class="fa fa-ticket"></i> <strong>Tickets Solicitados</strong></h1><br>
                    
                    

        <a style="margin-left: 5px; color:white;background-color:#1C84C6;width:20%;" 
            class="btn btn-info  btn-md pull-left"   type="button" id="btnSoliRecibidos" >
            <span> <i class="fa fa-ticket" ></i> Tickets Soli. (Recibidos) </span>
                <span class="pull-right label" 
                style="font-size:14px;color:white;background-color:#035373;">
                {{$recibidos}} </span>
        </a>
        <a  style="margin-left: 5px; color:black;background-color:#F8AC59;width:23%;text-align:center;font-weight:bold;"
            class="btn  btn-warining btn-md pull-left" id="btnSoliProceso"  type="button" >
            <span> <i class="fa fa-hand-o-up" ></i> Tickets Soli. (En Proceso)</span>

            
                <span class="pull-right label" 
                style="font-size:14px;color:white;background-color:#035373;">
                {{$process}} </span>
        </a>
        <a  style="margin-left: 5px; color:white;background-color:#1AB394;width:23%;text-align:center;font-weight:bold;"
            class="btn  btn-info btn-md pull-left" id="btnSoliSolucionados"  type="button" >
            <span><i class="fa fa-ticket" ></i> Tickets Soli. (Solucionados)</span>
            
            <span class="pull-right label" 
                style="font-size:14px;color:white;background-color:#035373;">
                {{$solu}} </span>
        </a>
        <a style="margin-left: 5px;color:white;background-color:#EC4758;width:23%;text-align:center;font-weight:bold;"
            class="btn  btn-danger btn-md pull-left"   type="button" id="btnSoliRechazados" >
            <span> <i class="fa fa-ticket" ></i> Tickets Soli. (Rechazados)</span>

            <span class="pull-right label" 
                style="font-size:14px;color:white;background-color:#035373;">
                {{$recha}} </span>
        </a>
                    

                   
                    <div id="soliRecibidos" class="ibox-content" style="border: 1px solid #FFFFFF">
                        <br>
                        <h2 style="color:#1C84C6"><i class="fa fa-ticket"></i> <strong>Recibidos</strong></h2><br>
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
                        @foreach($tickets as $ticket)
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


                <div id="soliProceso" class="ibox-content hidden">
                        <br>
                        <h2 style="color:#FA870A"><i class="fa fa-ticket"></i> <strong>En Proceso</strong></h2><br>
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
                        @foreach($tickets as $ticket)
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



                <div id="soliSolucionados" class="ibox-content hidden">
                        <br>
                        <h2 style="color:#04A081"><i class="fa fa-ticket"></i> <strong>Solucionados</strong></h2><br>
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
                        @foreach($tickets as $ticket)
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




                <div id="soliRechazados" class="ibox-content hidden">
                        <br>
                        <h2 style="color:#EC4758"><i class="fa fa-ticket"></i> <strong>Rechazados</strong></h2><br>
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
                        @foreach($tickets as $ticket)
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


                </div>



                <div class="row hidden" id="cerradosSolicitados">

            <h1><i class="fa fa-ticket"></i> <strong>Tickets Solicitados Cerrados</strong></h1><br>
                           
            <br>
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