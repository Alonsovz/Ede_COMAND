@extends('layouts.template')



@section('enunciado')
    Tickets
@stop

@section('modulo')
    Tickets
@stop

@section('submodulo')

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
                                    <a style="margin-left: 5px" href="ticketscompletados" class="btn btn-info pull-right btn-xs">Bandeja</a>
                                    <a style="margin-left: 5px" href="reabrirticket" class="btn btn-success pull-right btn-xs">Reaperturar ticket</a>
                                    <a href="#" disabled="disabled" readonly="true" class="btn btn-warning btn-xs pull-right" data-toggle="" data-target="#modaledicion">Editar ticket</a>
                                    <h3><b>ID:</b> {{$ticket->id}}</h3>
                                    <h2>{{$ticket->titulo}}</h2>
                                </div>
                                <dl class="dl-horizontal">
                                    <dt>Estado:</dt> <dd>
                                        @if($ticket->estado=='Enviado')
                                            <span class="label label-primary">Enviado</span>
                                        @elseif($ticket->estado=='Recibido')
                                            <span class="label label-warning">Recibido</span>
                                        @elseif($ticket->estado=='En proceso')
                                            <span class="label label-info">En proceso</span>
                                        @elseif($ticket->estado=='Solucionado')
                                            <span class="label label-success">Recibido</span>
                                        @elseif($ticket->estado=='Cerrado')
                                            <span class="label label-danger">Cerrado</span>

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


                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <dl class="dl-horizontal">

                                </dl>
                            </div>
                        </div>
                        <div class="row m-t-sm">
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
                                                <div class="feed-activity-list hidden">
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
                                                    <div class="feed-element">
                                                        <a href="#" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/a3.jpg">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right">2h ago</small>
                                                            <strong>Janet Rosowski</strong> add 1 photo on <strong>Monica Smith</strong>. <br>
                                                            <small class="text-muted">2 days ago at 8:30am</small>
                                                        </div>
                                                    </div>
                                                    <div class="feed-element">
                                                        <a href="#" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/a4.jpg">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right text-navy">5h ago</small>
                                                            <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                                            <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                                            <div class="actions">
                                                                <a class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                                                                <a class="btn btn-xs btn-white"><i class="fa fa-heart"></i> Love</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="feed-element">
                                                        <a href="#" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/a5.jpg">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right">2h ago</small>
                                                            <strong>Kim Smith</strong> posted message on <strong>Monica Smith</strong> site. <br>
                                                            <small class="text-muted">Yesterday 5:20 pm - 12.06.2014</small>
                                                            <div class="well">
                                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                                                Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="feed-element">
                                                        <a href="#" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/profile.jpg">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right">23h ago</small>
                                                            <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                                            <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                                        </div>
                                                    </div>
                                                    <div class="feed-element">
                                                        <a href="#" class="pull-left">
                                                            <img alt="image" class="img-circle" src="img/a7.jpg">
                                                        </a>
                                                        <div class="media-body ">
                                                            <small class="pull-right">46h ago</small>
                                                            <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                                            <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                                        </div>
                                                    </div>
                                                </div>

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



@stop

