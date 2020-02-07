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
    Administracion de ticket
@stop

@section('contenido')

        <div class="wrapper wrapper-content animated fadeInLeftBig">

        

            <div class="ibox"  style="border: solid lightgrey 1px">
                @if($ticket->usuario_compartido!=Session('idusuario'))
                <div class="ibox-title">
                    <div class="ibox-tools">
                    <a href="#refAdministracion" class="btn btn-success " style="margin-bottom:  5px;color:white;margin-left: 5px;border: solid 1px black">
                                <i class="fa fa-ticket" ></i>Administración de Ticket</a>
                    <a href="#refBitacora" class="btn btn-default " style="margin-bottom:  5px;background-color:green;color:white;margin-left: 5px;border: solid 1px black">
                                <i class="fa fa-comments" ></i> Historial de resolución</a>
                            <a href="tck_edesalshow" class="btn btn-lg btn-default " style="margin-bottom:  5px;color:black;margin-right: 5px;border: solid 1px black">
                                <i class="fa fa-arrow-left" ></i> Regresar</a>
                        <a href="rpt_ticketdetalles?id={{$ticket->id}}" style="color:black; border:solid 1px black" class="btn  btn-lg pull-right btn-outline btn-default" type="button"><i class="fa fa-file-pdf-o"></i> Generar reporte</a>


                    </div>
                </div>
                
                @endif
                <div class="ibox-content">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            <h1>  <small><b>TICKET {{$ticket->id}}</b></small></h1>
                            @if($ticket->estado==='En proceso')
                                <strong class="pull-left"><?php
                                    $datetime1 = new DateTime("now");
                                    $datetime2 = new DateTime($ticket->fechaentregareal);
                                    $interval = date_diff($datetime1, $datetime2);
                                    echo $interval->format('%R%a dias');
                                    ?> restantes para entrega</strong><br>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 45%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>


                            @endif
                        </div>

                        <div class="panel-body">
                            <h3><i class="fa fa-info-circle"></i> {{$ticket->titulo}}</h3>
                        </div>


                        <dl class="dl-horizontal">
                            <dt><i class="fa fa-user"></i> Solicitante:</dt>
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


                        </dl>


                    </div>

                    
                </div>

                
                @if($ticket->estado==='En proceso' || $ticket->estado==='En pausa')
                        @if($ticket->usuario_compartido!=Session('idusuario'))
                <div class="ibox-footer" style="border-top: 1px black solid" id="refAdministracion">


                        <div class="row">
                            <div class="col-lg-12" >
                                <h2><i class="fa fa-cog"></i> <b>Administración de ticket</b></h2>
                                <br>
                                <div class="row" style="margin-top: 5px">
                                    <div style="color:black; margin-left: 15px" class="alert alert-warning col-lg-10" >
                                        <i class="fa fa-info-circle"></i> Los campos sistema y modulo pueden establecerse vacios si su ticket
                                        es en relacion a otra incidencia o requerimiento
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label for="" class="control-label">Categoria de ticket</label>
                                        <select name="" class="form-control" id="categoria" >
                                            <option value="{{$ticket->categoria_id}}">{{$ticket->categoria}}</option>
                                            @foreach($categorias as $categoria)

                                                <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>

                                            @endforeach
                                        </select>

                                    </div>
                                </div>


                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-5">
                                <label class="control-label">Estado</label>
                                <select name="" class="form-control" id="estado" >
                                    <option value="{{$ticket->estado_id}}">{{$ticket->estado}}</option>
                                    <option value="5">En proceso</option>
                                    <option value="6">Solucionado</option>
                                    <option value="9">Cancelado</option>
                                    <option value="13">En pausa</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-9">
                                <button class="btn btn-md btn-default" style="border:solid 1px black" id="establecersistema"><i class="fa fa-laptop"></i> Establecer un sistema y modulo para tu ticket</button>
                                <button class="btn btn-md btn-danger btn-outline" data-toggle="modal" data-target="#modalreasignar" style="border:solid 1px black" id="establecersistema"><i class="fa fa-users"></i> Reasignar ticket</button>
                            </div>
                        </div>
                        <div class="row hidden" id="sistemamodulo">

                            <div class="col-lg-5">
                                <label for="" class="control-label">Sistema</label>
                                <select name="" class="form-control" id="sistemas" >
                                    <option value="{{$ticket->sistema_id}}">{{$ticket->sistema}}</option>
                                    @foreach($sistemas as $sistema)
                                        <option value="{{$sistema->id}}">{{$sistema->nombre}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-lg-5">
                                <label for="" class="control-label">Modulo</label>
                                <select name="" class="form-control" id="modulo" >
                                    <option value="{{$ticket->modulo_id}}">{{$ticket->modulo}}</option>
                                    @foreach($modulos as $modulo)
                                        <option value="{{$modulo->id}}">{{$modulo->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <br>
                        <div class="row hidden" id="soluciondiv">
                            <div class="col-lg-5">
                                <label class="control-label">Solucion</label>
                                <textarea class="form-control" name="" id="solucionticket" cols="80" rows="5"></textarea>
                            </div>
                            <div class="col-md-6" style="margin-left: 10px">
                                <label class="control-label">Fecha de solucion</label>
                                <div class='col-lg-6 date input-group' id='datetimepicker4'>
                                    <input id="fechasolucionreal" type='text'  value="<?php $fecha = date('d/m/Y H:i'); echo $fecha ?>" class="form-control" />
                                    <span class="input-group-addon" >
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-lg-12">
                                <a href="tck_edesalshow" class="btn btn-md btn-warning pull-right" style="margin-left: 5px"><i class="fa fa-arrow-left" ></i> Regresar</a>
                                <button class="btn btn-primary btn-md pull-right btn_guardarcambios" type="button" id="{{$ticket->id}}">
                                    <i class="fa fa-save"></i> Guardar cambios</button>
                            </div>
                        </div>
                </div>
                
                        @endif
                @elseif($ticket->estado==='Solucionado' || $ticket->estado==='Cerrado')
                        @if($ticket->usuario_compartido!=Session('idusuario'))
                    <div class="ibox-footer">
                    <div class="alert alert-info">
                            <h2><i class="fa fa-file-text-o"></i>  Petición</h2>
                            <p><b>Descripción:</b></p>
                            <p>{{$ticket->descripcion}}</p>
                            <hr>
                            
                        </div>

                        <div class="alert alert-success">
                            <h2><i class="fa fa-file-text-o"></i>  Resolución</h2>
                            
                            <hr>
                            <p><b>Solucion establecida:</b></p>
                            <p>{{$ticket->solucion}}</p>
                            <hr>
                        </div>

                        <div class="alert alert-warning">
                            <h2><i class="fa fa-comments"></i>Comentarios</h2>
                            <hr>
                            <p><b>Comentario de usuario solicitante:</b></p>
                            <p>{{$ticket->comentarioresolucion}}</p>
                            <hr>
                        </div>
                    </div>
                            @endif
                @endif
            




                
                <div class="ibox-footer" style="border-top: solid 1px black" id="refBitacora">
                    <h2><i class="fa fa-comments"></i> <i class="fa fa-users"></i><b> Historial en el proceso de resolución de Ticket </b></h2>
                    <div style="margin-top: 75px" class="row m-t-sm">
                    <a href="#"  class="btn btn-success" id="volver">
                    Volver a encabezado
                </a>
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
                                            @if($ticket->usuario_compartido!=Session('idusuario'))
                                           <b style="color:blue;font-size:16px;">
                                            ¿Agregar un mensaje  para el solicitante  del ticket? </b>
                                            <br><br>
                                            <button data-target="#mensajenuevo" data-toggle="modal" style="margin-bottom: 10px" id="btn_nuevomensaje" class="btn btn-success">
                                                <i class="fa fa-envelope"></i> Si
                                            </button>
                                            <br>
                                            @endif
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
                                            @if($ticket->usuario_compartido!=Session('idusuario'))
                                            <b style="color:blue;font-size:15px;">
                                            ¿Desea adicionar explicaciones al historial o a la bitacora de peticiones? </b>
                                            <br><br>
                                            <button style="margin-bottom: 10px" data-target="#nuevabitacora" data-toggle="modal" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                                                Si
                                            </button>
                                            <br>
                                            @endif
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
        </div>
        





    {{--MODAL PARA SOLUCION DE TICKET--}}
    <div class="modal inmodal fade" id="fechasolucion" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small>Fecha de solucion</small></h4>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-7" style="margin-left: 10px">

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="">Fecha de solucion</label>
                                <div class='col-lg-4 date input-group' id='datetimepicker4'>
                                    <input id="fechasolaproxexpress" type='text' class="form-control" />
                                    <span class="input-group-addon" >
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3" style="margin-left: 10px">
                            <div class="form-group">
                                <label for="">Tiempo dedicado</label>
                                <div class='input-group date' id=''>
                                    <input id="tiempodedicado" type='number' step="0.25" min="0" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="cerrar1" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                    <button type="button"  class="btn btn-primary btn-sm btn_guardar" data-dismiss="modal" id="{{$ticket->id}}"><i class="fa fa-save"></i> Guardar cambios</button>
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


                            <div class="form-group"><label class="col-lg-2 control-label">Ticket de bitacora:</label>

                                <div class="col-lg-3 input-group">
                                    <input id="ticket" readonly="readonly"  type="text" placeholder="" value="{{$ticket->id}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 control-label">Descripcion:</label>
                                <div class="col-lg-8 input-group">
                                    <textarea class="form-control" name="" id="descripcion" cols="70" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 control-label">Tiempo dedicado:</label>
                                <div class="col-lg-2 input-group">
                                    <input class="form-control" step="0.25" type="number" id="tiempo">
                                </div>
                                <div class="alert alert-info hidden col-lg-4 input-group" style="margin-left: 145px" style="color:black" id="conversiontiempo">

                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="">Fecha de bitacora:</label>
                                <div class='col-lg-4 date input-group' id='datetimepicker3'>
                                    <input id="fechabitacora" type='text' class="form-control" />
                                    <span class="input-group-addon" >
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 control-label">Establecer como solución:</label>
                                <div class="col-lg-2 input-group">
                                    <input style="margin-left: -55px" class="form-control" name="solucioncheck" type="checkbox" id="solucioncheck">
                                </div>
                            </div>





                            <div class="form-group" >
                                <div class="col-lg-10 input-group">
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary pull-right" id="btn_registrarbitacora" type="button"><i class="fa fa-save"></i> Guardar bitacora</button>
                        <button style="margin-right: 5px" type="button" class="btn btn-danger btn-sm" id="cerrar1" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>



    {{--MODAL PARA REASIGNAR TICKET--}}
        <div class="modal inmodal fade fadeInLeftBig" id="modalreasignar" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><small>Reasignar ticket</small></h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-lg-12" style="margin-left: 10px">

                                <div class="form-group">
                                    <label for="">Usuario</label>
                                    <div class='input-group ' >
                                        <select name="" id="usuario" class="form-control">
                                            <option value="">usuarios...</option>
                                            @foreach($usuarios as $usuario)
                                                <option value="{{$usuario->id}}">{{$usuario->nombre}} {{$usuario->apellido}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Motivo de reasignación:</label>
                                    <textarea name="" id="" cols="30" rows="10" id="motivoreasignacion"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" id="cerrar1" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                        <button type="button"  class="btn btn-primary btn-sm btn_reasignarticket" data-dismiss="modal" id="{{$ticket->id}}"><i class="fa fa-save"></i> Guardar</button>
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
    <script src="../js/funciones/infoticket.js"></script>

@stop