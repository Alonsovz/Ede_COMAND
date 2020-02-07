<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">


<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-heading">
            <div class="ibox-title">
                <h2><i class="fa fa-ticket"></i> Detalle de ticket #{{$ticket->id}}</h2>
            </div>
        </div>
        <div class="ibox-content">
            <dl class="dl-horizontal">
                <dt><i class="fa fa-user"></i> Solicitante:</dt>
                <dd><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></dd>

                @if($ticket->reasignado==1)
                    <dt><i class="fa fa-file-text"></i> Reasignación:</dt>
                    <dd><b>{{$ticket->desc_reasignacion}}</b></dd>
                @endif

                <dt><i class="fa fa-calendar"></i> Solicitud:</dt>
                <dd>
                    <?php
                    $fecha = date_create($ticket->fechasolicitud);
                    echo date_format($fecha,'d/m/Y');
                    ?>
                        <input id="fechavieja" type="text" class="hidden" value="<?php
                        $fecha = date_create($ticket->fechasolaprox);
                        echo date_format($fecha,'d/m/Y H:i');
                        ?>">
                </dd>
                <dt><i class="fa fa-calendar"></i> Solucion Aproximada:</dt>
                <dd>
                    <?php
                    $fecha = date_create($ticket->fechasolaprox);
                    echo date_format($fecha,'d/m/Y');
                    ?>
                </dd>
                <dt><i class="fa fa-file-text"></i> Descripcion:</dt>
                <dd class="text-success">{{$ticket->descripcion}}</dd>
                <dt></dt>


            </dl>
            <hr>
            <div class="jumbotron">
                <div class="container">
                    <div class="alert alert-warning">
                        <i class="fa fa-info-circle"></i> Si estableciste una nueva fecha de solucion con el solicitante para aceptar el ticket
                        este es el momento de poder establecer la nueva fecha de solucion a su ticket, si no es el caso se mantendra la
                        fecha establecida cuando se ingreso el ticket
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="">Nueva fecha de solución</label>
                        <div class='col-lg-4 date input-group' id='datetimepicker1'>
                            <input id="fechasol" type='text' class="form-control" />
                            <span class="input-group-addon" >
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <a data-toggle="modal" data-target="#modalreasignar" class="pull-right btn btn-md btn-info  " id="{{$ticket->id}}" style="margin-left: 5px; ">
                        <i class="fa fa-users"></i> Reasignar
                    </a>
                    <a class="pull-right btn btn-md btn-primary  btn_aceptartck" id="{{$ticket->id}}" style="margin-left: 5px; ">
                        <i class="fa fa-thumbs-up"></i> Aceptar ticket
                    </a>

                    <button  class="pull-right btn btn-md btn-danger  " data-toggle="modal" data-target="#modalrechazotck" type="button" style="">
                        <i class="fa fa-thumbs-down"></i> Rechazar ticket
                    </button>
                    <button onclick="location.reload()" class="pull-right btn btn-md  btn-default " style="color: black;margin-right: 5px" type="button"  id="{{$ticket->id}}">
                        <i class="fa fa-arrow-left"></i> Regresar
                    </button>


                </div>
            </div>
            <div class="row">

            </div>
        </div>
    </div>
</div>




{{--MODAL PARA COMENTARIO DE DENEGACION DE TICKET--}}
<div class="modal inmodal fade fadeInLeftBig" id="modalrechazotck" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><small>Rechazar Ticket</small></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-dismissible alert-warning">
                    <i class="fa fa-info-circle"></i>
                    El usuario solicitante necesita conocer el motivo del rechazo a su ticket
                </div>
                <div class="row">

                    <div class="col-lg-12" style="margin-left: 10px">

                        <div class="form-group">
                            <label for="">Comentario</label>
                            <div class='input-group ' >
                                <textarea class="form-control" name="" id='comentariorechazo' cols="80" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" id="cerrar1" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                <button type="button"  class="btn btn-primary btn-sm btn_rechazartck" data-dismiss="modal" id="{{$ticket->id}}"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

{{--MODAL PARA REASIGNAR--}}
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
                    <div class="col-lg-12" style="margin-left: 10px">
                        <div class="form-group">
                            <label for="">Motivo de reasignación:</label>
                            <textarea class="form-control" name=""  cols="30" rows="5" id="motivoreasignacion"></textarea>
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


<script src="../js/plugins/fullcalendar/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="../js/funciones/infoticket.js"></script>

<script>

    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
</script>