@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
@stop


@section('enunciado')
    Tickets
@stop

@section('modulo')
    Tickets
@stop

@section('submodulo')

@stop

@section('contenido')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <a href="ticketscompletados" class="btn btn-white btn-xs" id="btn_ticketscompletados"><i class="fa fa-table"></i> Tickets Completados</a>
                <button class="btn btn-white btn-xs"><i class="fa fa-desktop"></i> Nuevo Sistema</button>
                <button class="btn btn-white btn-xs"><i class="fa fa-cubes"></i> Nuevo Modulo</button>
            </h3>
        </div>

    </div>
    <div class="row" id="boardtickets">
        <div class="col-lg-4" >
            <div class="ibox" >
                <div class="ibox-content" style="height: 600px; overflow-y:  scroll" >
                    <h3>Backlog</h3>


                    <div class="input-group">
                        <input type="text" placeholder="Busqueda de ticket. " class="input input-sm form-control">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-sm btn-white">Buscar ticket</button>
                         </span>
                    </div>




                    @foreach($tickets as $ticket)
                        @if($ticket->estado_id=='1')
                            <ul class="sortable-list connectList agile-list ui-sortable" id="todo">
                                <li class="success-element ui-sortable-handle" id="task1">
                                    <a href=""><b>{{$ticket->id}}</b></a><br>
                                    <p>{{$ticket->titulo}}</p>
                                    <p>
                                        Solicitante: <b>{{$ticket->nombre}} {{$ticket->apellido}}</b>
                                    </p>
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-success btn_ticketrecibido" id="{{$ticket->id}}">ver</a>
                                        <i class="fa fa-clock-o"></i>
                                        <?php
                                        $fecha = date_create($ticket->fechasolicitud);
                                        echo date_format($fecha,'d/m/Y');
                                        ?>
                                    </div>
                                </li>
                            </ul>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="ibox">
                <div class="ibox-content" style="height: 600px; overflow-y:  scroll" >
                    <h3>
                            En proceso
                    </h3>
                    <div class="input-group">
                        <input type="text" placeholder="Busqueda de ticket. " class="input input-sm form-control">
                        <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-white">Buscar ticket</button>
                                </span>
                    </div>

                    <div class="ibox-content">
                        <div class="spiner-example hidden" style="margin-top: 0px">
                            <div class="sk-spinner sk-spinner-three-bounce">
                                <div class="sk-bounce1"></div>
                                <div class="sk-bounce2"></div>
                                <div class="sk-bounce3"></div>
                            </div>
                        </div>
                        @foreach($tickets as $ticket)
                            @if($ticket->estado_id=='2' || $ticket->estado_id=='5')
                                @if($ticket->estado_id=='2')
                                    <ul class="sortable-list connectList agile-list ui-sortable" id="todo">
                                        <li class="info-element ui-sortable-handle" id="task1">
                                            <a href=""><b>{{$ticket->id}}</b></a><br>
                                            <p>{{$ticket->titulo}}</p>
                                            <p>
                                                Solicitante: <b>{{$ticket->nombre}} {{$ticket->apellido}}</b>
                                            </p>
                                            <div class="agile-detail">
                                                <a href="administrarticket?id={{$ticket->id}}" class="pull-right btn btn-xs btn-info " id="{{$ticket->id}}">Administrar</a>
                                                <i class="fa fa-clock-o"></i>
                                                <?php
                                                $fecha = date_create($ticket->fechasolicitud);
                                                echo date_format($fecha,'d/m/Y');
                                                ?>
                                            </div>
                                        </li>
                                    </ul>

                               @elseif($ticket->estado_id=='5')

                                    <ul class="sortable-list connectList agile-list ui-sortable" id="todo">
                                        <li class="warning-element ui-sortable-handle" id="task1">
                                            <a href=""><b>{{$ticket->id}}</b></a><br>
                                            <p>{{$ticket->titulo}}</p>
                                            <p>
                                                Solicitante: <b>{{$ticket->nombre}} {{$ticket->apellido}}</b>
                                            </p>
                                            <div class="agile-detail">
                                                <a href="administrarticket?id={{$ticket->id}}"  class="pull-right btn btn-xs btn-info " id="">Administrar</a>
                                                <a  class="pull-right btn btn-xs btn-danger administrarbitacora " style="margin-right: 5px" id="{{$ticket->id}}">Bitacoras</a>
                                                <i class="fa fa-clock-o"></i>
                                                <?php
                                                $fecha = date_create($ticket->fechasolicitud);
                                                echo date_format($fecha,'d/m/Y');
                                                ?>
                                            </div>
                                        </li>
                                    </ul>

                               @endif
                            @endif
                        @endforeach
                    </div>


                </div>
            </div>
        </div>
        <div class="col-lg-2 hidden" >
            <div class="ibox" >
                <div class="ibox-content" style="height: 600px">
                    <h3>Completado</h3>
                    <div class="input-group">
                        <input type="text" placeholder="Busqueda de ticket. " class="input input-sm form-control">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-sm btn-info">Buscar ticket</button>
                        </span>
                    </div>


                </div>
            </div>
        </div>

    </div>



    <div class="row hidden" id="detalllesticketrecibido">

    </div>

    <div class="row hidden" id="nuevabitacora">

    </div>
@stop

@section('scripts')
    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>

    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>

    <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>


    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <script src="../js/funciones/tickets.js"></script>

@stop