@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
@stop


@section('enunciado')
    Tickets
@stop

@section('modulo')
    Tickets
@stop

@section('submodulo')
    Edicion de tickets
@stop

@section('contenido')

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-b-md">
                                    @if($ticket->estado=='Solucionado')
                                        <a style="margin-left: 5px" id="btn_cerrarticket" data-toggle="modal" data-target="#modalresolucion"  class="btn btn-danger pull-right btn-xs">Resolucion</a>
                                    @endif
                                    <a style="margin-left: 5px" href="ticketsnostaff" class="btn btn-info pull-right btn-xs">Bandeja</a>
                                    <a href="#" disabled="disabled" readonly="true" class="btn btn-warning btn-xs pull-right" data-toggle="" data-target="#modaledicion">Editar ticket</a>
                                    <h3><b>ID:</b> {{$ticket->id}}</h3>
                                    <h2>{{$ticket->titulo}}</h2>
                                </div>
                                <dl class="dl-horizontal">
                                    <dt>Estado:</dt> <dd>
                                        @if($ticket->estado=='Enviado')
                                            <span class="label label-primary">{{$ticket->estado}}</span>
                                        @elseif($ticket->estado=='Recibido')
                                            <span class="label label-info">{{$ticket->estado}}</span>
                                        @elseif($ticket->estado=='En proceso')
                                            <span class="label label-warning">{{$ticket->estado}}</span>
                                        @elseif($ticket->estado=='Solucionado')
                                            <span class="label label-success">{{$ticket->estado}}</span>
                                        @elseif($ticket->estado=='Cerrado')
                                            <span class="label label-danger">{{$ticket->estado}}</span>

                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <dl class="dl-horizontal">

                                    <dt>Usuario asignado: </dt> <dd><b>{{$ticket->nombre}} {{$ticket->apellido}}</b></dd>
                                    <dt>Descripcion:</dt> <dd>{{$ticket->descripcion}}</dd>
                                    <dt>Sistema:</dt> <dd><a href="#" class="text-navy"> {{$ticket->sistema}}</a> </dd>
                                    <dt>Modulo:</dt> <dd> 	{{$ticket->modulo}}</dd>
                                </dl>
                            </div>
                            <div class="col-lg-7" id="cluster_info">
                                <dl class="dl-horizontal">

                                    <dt>Fecha de solicitud:</dt>
                                    <dd>
                                        <?php
                                            $fecha = date_create($ticket->fechasolicitud);
                                            echo date_format($fecha,'d/m/Y');
                                                ?>
                                    </dd>

                                    <dt>Fecha de solucion:</dt>
                                    <dd>
                                        <?php
                                        $fecha = date_create($ticket->fechasolucion);
                                        echo date_format($fecha,'d/m/Y');
                                        ?>
                                    </dd>


                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <dl class="dl-horizontal">
                                    <dt>Resolucion:</dt>
                                    @if($ticket->solucion=='')
                                        <dd>
                                            <div class="progress progress-striped active m-b-sm">
                                                <div style="width: 60%;" class="progress-bar"></div>
                                            </div>

                                        </dd>

                                        @else

                                        <dd class="text-danger">{{$ticket->solucion}}</dd>

                                        @endif
                                </dl>
                            </div>
                        </div>



                        <div style="margin-top: 75px" class="row m-t-sm">
                            <div class="col-lg-12">
                                <div class="panel blank-panel">
                                    <div class="panel-heading">
                                        <div class="panel-options">
                                            <ul class="nav nav-tabs">
                                                <li class=""><a href="#tab-1" data-toggle="tab" aria-expanded="false">Historial de mensajes</a></li>
                                                <li class="active"><a href="#tab-2" data-toggle="tab" aria-expanded="true">Ultima Actividad</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel-body">

                                        <div class="tab-content">
                                            <div class="tab-pane" id="tab-1">

                                             <div class="row">
                                                 <div class="col-lg-12">
                                                     <div class="ibox">
                                                        <div class="ibox-heading">
                                                            <div class="ibox-title">
                                                                <button id="btn_nuevomensaje" class="btn btn-xs btn-primary"><i class="fa fa-envelope"></i> Nuevo mensaje</button>
                                                            </div>
                                                        </div>
                                                         <div class="ibox-content hidden">
                                                             <form action="" class="form-horizontal">
                                                                 <div class="form-group"><label class="col-lg-2 control-label">Mensaje</label>

                                                                     <div class="col-lg-7">
                                                                         <textarea class="form-control" name="" id="mensaje" cols="30"
                                                                                   rows="5"></textarea>

                                                                     </div>
                                                                 </div>
                                                                 <div class="form-group" >
                                                                     <div class="col-lg-offset-2 col-lg-10">
                                                                         <button class="btn btn-sm btn-success" id="btn_enviarmensaje" type="button">Enviar Mensaje</button>
                                                                     </div>
                                                                 </div>
                                                             </form>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>

                                                <table class="table table-striped dataTables-example1 hidden">
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
                                                        <tr>
                                                            <td>
                                                                <div class="feed-element">
                                                                    <a href="#" class="pull-left">
                                                                        <img alt="image" class="img-circle" src="img/a2.jpg">
                                                                    </a>
                                                                    <div class="media-body ">
                                                                        <small class="pull-right">2h ago</small>
                                                                        <strong>Mark Johnson</strong> posted message on <strong>Monica Smith</strong> site. <br>
                                                                        <small class="text-muted">Today 2:10 pm - 12.06.2014</small>
                                                                        <div class="well">
                                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                                            Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>

                                                    </tbody>
                                                </table>


                                            </div>
                                            <div class="tab-pane active" id="tab-2">

                                                <table class="table table-striped dataTables-example1">
                                                    <thead class="hidden">
                                                    <tr>
                                                        <th>Estado</th>
                                                        <th>Tiempo dedicado</th>
                                                        <th>Descripcion</th>
                                                        <th>Fecha de bitacora</th>
                                                        <th></th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($bitacora as $b)
                                                        <tr>
                                                            <td>
                                                                <span class="label label-primary"><i class="fa fa-check"></i> Completado</span>
                                                            </td>
                                                            <td>
                                                                <i class="fa fa-clock-o"></i>
                                                                <?php
                                                                    $tiempo = $b->tiempodedicado;
                                                                    $calculo = $tiempo*60;
                                                                    echo $calculo." minutos"  ;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                {{$b->descripcion}}
                                                            </td>

                                                            <td class="pull-right">
                                                                <i class="fa fa-calendar"></i>
                                                            <?php
                                                                $fecha = date_create($b->fechabitacora);
                                                                echo date_format($fecha,'d/m/Y');
                                                                ?>
                                                            </td>
                                                            <td>

                                                            </td>

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
        </div>
    </div>



    <!--MODAL PARA CERRAR TICKET-->
    <div class="modal inmodal fade" id="modalresolucion" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <p><h1>Resolucion</h1></p>
                    <p>
                        <button class="btn btn-sm btn-white btn_aceptarsolucion " id="{{$ticket->id}}" type="button">Aceptar solucion</button>
                        <button class="btn btn-white btn-sm btn_denegarsolucion" id="{{$ticket->id}}">Denegar solucion</button>
                    </p>
                </div>
                <div class="modal-body hidden" id="bodymodal">
                    <form class="form-horizontal" id="frm_personalizado">

                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">

                            </div>

                            <div class="form-group"><label class="col-lg-2 control-label">Comentario</label>

                                <div class="col-lg-7">
                                    <textarea class="form-control" name="" id="comentario" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group" >
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-sm btn-success btn_enviardenegacion" id="{{$ticket->id}}" type="button">Enviar Resolucion</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" id="cerrarresolucion" class="btn btn-white" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>



    <!--MODAL PARA EDICION DE TICKETS-->
    <div class="modal inmodal fade" id="modaledicion" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><i class="fa fa-pencil"></i></h4>
                    <small class="font-bold"><b>Edicion de ticket</b></small>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_personalizado">

                        <div class="form-group"><label class="col-lg-2 control-label">Titulo</label>

                            <div class="col-lg-6">
                                <input type="text" placeholder="Titulo" id="titulopersonalizado" class="form-control">

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Asignacion de ticket</label>

                            <div class="col-lg-5">
                                <select name="" class="form-control" id="usuariopersonalizado">
                                    <option value="">usuarios...</option>
                                    @foreach($usuarios as $usuario)

                                        <option value="{{$usuario->id}}">{{$usuario->nombre}} {{$usuario->apellido}}</option>

                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Sistemas</label>

                            <div class="col-lg-5">
                                <select name="" class="form-control" id="sistemaspersonalizado">
                                    <option value="">Selecciones un sistema...</option>
                                    @foreach($sistemas as $sistema)

                                        <option value="{{$sistema->id}}">{{$sistema->nombre}}</option>

                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group hidden" id="divmodulos"><label class="col-lg-2 control-label">Modulos</label>

                            <div class="col-lg-5">
                                <select name="" class="form-control" id="modulos">
                                    <option value="">Selecciones un modulo...</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                            <div class="col-lg-6">

                                <textarea name="" class="form-control" id="descpersonalizado" cols="10" rows="5"></textarea>
                            </div>
                        </div>



                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>


@stop



@section('scripts')
    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>

    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <script type="text/javascript" src="../js/funciones/tickets.js"></script>

@stop