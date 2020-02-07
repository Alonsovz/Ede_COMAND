<div class="col-lg-12">
    <div class="wrapper wrapper-content animated fadeInUp">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="m-b-md">

                            <a style="margin-left: 5px" data-toggle="modal" data-target="#reasignarticket" id="{{$ticket->id}}" class="reasignar btn btn-warning pull-right btn-xs">
                                <i class="fa fa-refresh"></i> Reasignar ticket
                            </a>
                            <a href="#"   class="btn btn-xs btn-success pull-right btn_aceptarticket" id="{{$ticket->id}}" data-toggle="modal" data-target="#modaledicion">
                                <i class="fa fa-thumbs-up"></i> Aceptar ticket
                            </a>
                            <button class="btn btn-danger btn-xs pull-right" style="margin-right: 5px" id="btn_regresarbandeja"><i class="fa fa-arrow-left"></i> Regresar a bandeja</button>

                            <h3><b>ID:</b> {{$ticket->id}}</h3>

                            <i class="fa fa-clock-o"></i>
                            <?php
                            $fecha = date_create($ticket->fechasolicitud);
                            echo date_format($fecha,'d/m/Y');
                            ?>
                            <h2>{{$ticket->titulo}}</h2>
                        </div>
                        <dl class="dl-horizontal">
                            <dt>Estado:</dt> <dd>
                                <span class="label label-success">Recibido</span>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <dl class="dl-horizontal">

                            <dt>Solicitante: </dt> <dd><b>{{$ticket->nombre}} {{$ticket->apellido}}</b></dd>
                            <dt>Descripcion:</dt> <dd>{{$ticket->descripcion}}</dd>
                            <dt>Sistema:</dt> <dd><a href="#" class="text-navy"> {{$ticket->sistema}}</a> </dd>
                            <dt>Modulo:</dt> <dd> 	{{$ticket->modulo}}</dd>
                        </dl>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>


<div class="modal inmodal fade" id="reasignarticket" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><img src="../images/reasignar.png" height="100" width="100" alt=""></h4>
                <h1><small>Reasignar</small></h1>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group"><label class="col-lg-4 control-label">Asignacion de ticket</label>

                        <div class="col-lg-5">
                            <select name="" class="form-control" id="usuario" required title="Campo obligatorio">
                                <option value="">usuarios...</option>
                                @foreach($usuarios as $usuario)

                                    <option value="{{$usuario->id}}">{{$usuario->nombre}} {{$usuario->apellido}}</option>

                                @endforeach
                            </select>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn_reasignarticket">Reasignar</button>
            </div>
        </div>
    </div>
</div>




<script src="../js/funciones/extra.js"></script>
