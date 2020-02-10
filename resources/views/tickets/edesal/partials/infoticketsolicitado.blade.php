@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">


@stop



@section('enunciado')
    Tickets
@stop

@section('modulo')
    Tickets
@stop

@section('submodulo')
    Seguimiento de ticket
@stop

@section('contenido')


    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-tools">
                @if($ticket->estado=='En proceso')
                    <strong class="pull-left"><?php
                        $datetime1 = new DateTime("now");
                        $datetime2 = new DateTime($ticket->fechaentregareal);
                        $interval = date_diff($datetime1, $datetime2);
                        echo $interval->format('%R%a dias');
                        ?> restantes</strong><br>
                    <div class="progress progress-striped active m-b-sm">
                        <div style="width: 45%;" class="progress-bar"></div>
                    </div>
                    <p><a href="rpt_ticketdetalles?id={{$ticket->id}}" style="color:black" class="btn  btn-md pull-right btn-outline btn-default" type="button"><i class="fa fa-file-pdf-o"></i> Generar reporte</a></p>
                    @else
                @endif
                    <a href="tck_edesalshow" class="btn btn-default" style="color:black"><i class="fa fa-arrow-left"></i> Regresar</a>
            </div>
        </div>
        <div class="ibox-content">
            <h2><i class="fa fa-ticket"></i> Informacion de ticket</h2>
            <dl class="dl-horizontal">
                <dt><i class="fa fa-user"></i> Asignado:</dt>
                <dd><b>{{$ticket->nombre}} {{$ticket->apellido}}</b></dd>

                <dt><i class="fa fa-calendar"></i> Solicitud:</dt>
                <dd>
                    <?php
                    $fecha = date_create($ticket->fechasolicitud);
                    echo date_format($fecha,'d/m/Y');
                    ?>

                </dd>
                <dt><i class="fa fa-calendar"></i> Fecha para entrega:</dt>
                <dd>
                    <?php
                    $fecha = date_create($ticket->fechaentregareal);
                    echo date_format($fecha,'d/m/Y');
                    ?>
                </dd>
                <dt><i class="fa fa-file-text"></i> Descripcion:</dt>
                <dd class="text-success">{{$ticket->descripcion}}</dd>
                <dt><i class="fa fa-calendar"></i> Fecha de solucion:</dt>
                <dd>
                    <?php
                    $fecha = date_create($ticket->fechasolucion);
                    echo date_format($fecha,'d/m/Y');
                    ?>
                </dd>
                <br>


                @if($ticket->estado=='En proceso')
                   <dt><i class="fa fa-thumbs-up"></i> Resolucion:</dt>
                   <dd><b class="text-primary"> El ticket se encuentra en proceso...</b></dd>
                    @elseif($ticket->estado=='Solucionado')
                    <dd class="">
                        <div class="alert alert-success" style="height: 125px;">
                            {{$ticket->solucion}}<br>
                            <button class="btn btn-sm btn-success pull-right" data-target="#validacionticket" data-toggle="modal" style="margin-top:40px"><i class="fa fa-lightbulb-o"></i> Validar resolución</button>
                        </div>
                    </dd>


                @endif


            </dl>

        </div>





        {{--DIV PARA RESOLUCIONES--}}
        @if($ticket->estado==='Cerrado')
        <div class="ibox-footer">
            <div class="alert alert-success">
                <h2><i class="fa fa-file-text-o"></i> Resolución</h2><br>
                <p><b>Solucion establecida:</b></p>
                <p>{{$ticket->solucion}}</p>
                <hr>
                <p><b>Comentario de usuario solicitante:</b></p>
                <p>{{$ticket->comentarioresolucion}}</p>
            </div>
        </div>
        @endif








        {{--interacccion con el usuario asignado--}}
        <div class="ibox-footer" style="margin-top: 20px">
            <h2><i class="fa fa-comments"></i> <i class="fa fa-users"></i> Interacción en el proceso de resolución de Ticket</h2>
            <div style="margin-top: 75px" class="row m-t-sm">
                <div class="col-lg-12">
                    <div class="panel blank-panel">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class=""><a href="#tab-1" data-toggle="tab" aria-expanded="false"><i class="fa fa-envelope"></i> Mensajes</a></li>
                                    <li class="active"><a href="#tab-2" data-toggle="tab" aria-expanded="true"><i class="fa fa-file-text-o"></i> Bitacora</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div class="tab-pane" id="tab-1">

                                    <button data-target="#mensajenuevo" data-toggle="modal" style="margin-bottom: 10px" id="btn_nuevomensaje" class="btn btn-xs btn-success">
                                        <i class="fa fa-envelope"></i> Nuevo mensaje</button>
                                    <table class="table table-striped dataTables-example1 ">
                                        <thead class="hidden">
                                        <tr>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($mensajes as $mensaje)
                                            <tr>
                                                <td>
                                                    <div class="feed-element">
                                                        <a href="#" class="pull-left">
                                                            <img alt="image" class="img-circle" src="{{$mensaje->avatar}}">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right"></small>
                                                            <strong>{{$mensaje->nombreemisor}} {{$mensaje->apellidoemisor}}</strong> escribio:<br>
                                                            <small class="text-muted"> <?php
                                                                $fecha = date_create($ticket->fechasolicitud);
                                                                echo date_format($fecha,'d/m/Y');
                                                                ?></small>
                                                            <div class="well">
                                                                {{$mensaje->mensaje}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>


                                </div>
                                <div class="tab-pane active" id="tab-2">
                                    {{--<button style="margin-bottom: 10px" data-target="#nuevabitacora" data-toggle="modal" class="btn btn-xs btn-success"><i class="fa fa-plus-circle"></i> Nueva bitacora</button>--}}
                                    <br>
                                    <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail " style="color: black;margin-top: 20px" >
                                        <thead id="header" class="">
                                        <tr style="background-color: lightgrey">
                                            <th style="border: solid 1px grey;">N°</th>
                                            <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-clock-o"></i></th>
                                            <th style="border: solid 1px grey;">Descripcion</th>
                                            <th class="text-center" style="border: solid 1px grey;"><i class="fa fa-calendar"></i></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($bitacoras as $bitacora)
                                            <tr>
                                                <td style="border: solid 1px grey;"><b>{{$bitacora->id}}</b></td>
                                                <td class="text-center" style="border: solid 1px grey;"><?php echo ($bitacora->tiempodedicado*60)." minutos" ?></td>
                                                <td style="border: solid 1px grey;"><small><b>{{$bitacora->descripcion}}</b></small></td>
                                                <td class="text-center" style="border: solid 1px grey;"><?php
                                                    $fecha = date_create($bitacora->fechabitacora);
                                                    echo date_format($fecha,'d/m/Y');
                                                    ?></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>





    {{--VALIDACION DE RESOLUCION DE TICKET--}}
    <div class="modal inmodal fade" id="validacionticket" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small>Validación</small></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_nuevabitacora">


                        <div class="form-group"><label class="col-lg-2 control-label">Criterio de aceptacion:</label>

                            <div class="col-lg-5 input-group">
                                <select name="" id="criterioaceptacion" class="form-control">
                                    <option value="">Seleccione una opcion...</option>
                                    <option value="8">Aceptar resolucion</option>
                                    <option value="10">Denegar resolucion</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group " id="comentariodenegacion"><label class="col-lg-2 control-label">Comentario:</label>
                            <div class="col-lg-8 input-group">
                                <textarea class="form-control" name="" id="denegacioncomentario" cols="70" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="form-group" >
                            <div class="col-lg-10 input-group">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary pull-right btn_validarresolucion" id="{{$ticket->id}}" type="button"><i class="fa fa-save"></i> Validar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="cerrar1" data-dismiss="modal" style="margin-right: 5px"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA MENSAJES--}}
    <div class="modal inmodal fade" id="mensajenuevo" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small>Nuevo mensaje</small></h4>
                </div>
                <div class="modal-body">
                    <form  class="form-horizontal">
                        <div class="form-group"><label class="col-lg-2 control-label">Mensaje</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" name="" id="mensaje" cols="80" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-primary btn_enviarmensaje" id="{{$ticket->id}}" type="button">
                                    <i class="fa fa-save"></i> Enviar Mensaje</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="cerrar1" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA BITACORAS--}}
    <div class="modal inmodal fade" id="nuevabitacora" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small>Nueva Bitacora</small></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_nuevabitacora">


                        <div class="form-group"><label class="col-lg-2 control-label">Ticket de bitacora</label>

                            <div class="col-lg-3 input-group">
                                <input id="ticket" readonly="readonly"  type="text" placeholder="" value="{{$ticket->id}}" class="form-control">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>
                            <div class="col-lg-8 input-group">
                                <textarea class="form-control" name="" id="descripcion" cols="70" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Tiempo dedicado</label>
                            <div class="col-lg-2 input-group">
                                <input class="form-control" step="0.25" type="number" id="tiempo">
                            </div>
                            <div class="alert alert-info hidden col-lg-4 input-group" style="margin-left: 145px" style="color:black" id="conversiontiempo">

                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="">Fecha de bitacora</label>
                            <div class='col-lg-4 date input-group' id='datetimepicker3'>
                                <input id="fechabitacora" type='text' class="form-control" />
                                <span class="input-group-addon" >
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                            </div>
                        </div>



                        <div class="form-group" >
                            <div class="col-lg-10 input-group">
                                <button class="btn btn-sm btn-primary pull-right" id="btn_registrarbitacora" type="button"><i class="fa fa-save"></i> Guardar bitacora</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="cerrar1" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="../js/plugins/dataTables/datatables.min.js"></script>
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>

    <script type="text/javascript" src="../js/plugins/moment/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>


    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <script src="../js/funciones/administracionticket.js"></script>

@stop