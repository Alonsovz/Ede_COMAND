@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css">
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
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox"  style="border: solid lightgrey 1px">
                    <div class="ibox-content">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading"><h1>  <small><b>TICKET {{$ticket->id}}</b></small></h1></div>
                            <div class="panel-body">
                                <h3><i class="fa fa-info-circle"></i> {{$ticket->titulo}}</h3>
                            </div>


                            <dl class="dl-horizontal">
                                <dt><i class="fa fa-user"></i> Solicitante:</dt>
                                <dd>{{$ticket->nombre}}</dd>

                                <dt><i class="fa fa-calendar"></i> Solicitud:</dt>
                                <dd>
                                    <?php
                                    $fecha = date_create($ticket->fechasolicitud);
                                    echo date_format($fecha,'d/m/Y');
                                    ?>
                                </dd>
                                <dt><i class="fa fa-file-text"></i> Descripcion:</dt>
                                <dd class="text-success">{{$ticket->descripcion}}</dd>
                                <dt></dt>


                            </dl>





                        </div>



                        <form class="form-horizontal">
                            <div class="form-group"><label class="col-lg-4 control-label">Categoria</label>

                                <div class="col-lg-5">
                                    <select name="" class="form-control" id="categoria" >
                                        <option value="{{$ticket->categoria_id}}">{{$ticket->categoria}}</option>
                                        @foreach($categorias as $categoria)

                                            <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>

                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-4 control-label">Estado</label>

                                <div class="col-lg-5">
                                    <select name="" class="form-control" id="estado" >
                                        <option value="{{$ticket->estado_id}}">{{$ticket->estado}}</option>
                                        @foreach($estados as $estado)

                                            <option value="{{$estado->id}}">{{$estado->nombre}}</option>

                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-4 control-label">Sistema</label>

                                <div class="col-lg-5">
                                    <select name="" class="form-control" id="sistemas" >
                                        <option value="{{$ticket->sistema_id}}">{{$ticket->sistema}}</option>
                                        @foreach($sistemas as $sistema)

                                            <option value="{{$sistema->id}}">{{$sistema->nombre}}</option>

                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-4 control-label">Modulo</label>

                                <div class="col-lg-5">
                                    <select name="" class="form-control" id="modulo" >
                                        <option value="{{$ticket->modulo_id}}">{{$ticket->modulo}}</option>

                                    </select>

                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-4 control-label">Solucion</label>

                                <div class="col-lg-5">
                                    <textarea class="form-control" name="" id="solucion" cols="30" rows="5"></textarea>

                                </div>
                            </div>



                        </form>

                        <div class="row">
                            <a href="recibidosstaff" class="pull-right btn btn-sm btn-danger" id="" style="margin-left: 5px">
                                <i class="fa fa-arrow-left"></i> Recibidos</a>
                            <button class="pull-right btn btn-sm btn-success btn_guardarcambios" type="button"  id="{{$ticket->id}}">
                                <i class="fa fa-save"></i> Guardar cambios</button>
                        </div>

                        <button id="btn_modal" class="hidden" data-toggle="modal" data-target="#fechasolucion"></button>

                    </div>
                </div>

            </div>
        </div>
    </div>


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
                               <label for="">Fecha</label>
                               <div class='input-group date' id='datetimepicker2'>
                                   <input id="fsolucion" type='text' class="form-control" />
                                   <span class="input-group-addon">
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
@stop

@section('scripts')
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