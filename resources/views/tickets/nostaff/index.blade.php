@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
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
    <div class="row">
        <div class="col-md-offset-3">
            <img src="images/office1.png" width="500" height="200" alt="">
        </div>
    </div>

    <div class="row" style="margin-top: 15px">
        <div class="col-md-offset-4">
            <button id="btn_ticketexpress" class="btn btn-success btn-sm">Ticket express</button>
            <button id="btn_ticketpersonalizado" class="btn btn-warning btn-sm">Ticket personalizado</button>
        </div>
    </div>

    <div class="row hidden" style="margin-top: 20px" id="ticketexpress">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-bolt"></i> Ticket Express</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" id="frm_express">

                        <div class="form-group"><label class="col-lg-2 control-label">Titulo</label>

                            <div class="col-lg-6">
                                <input id="tituloexpress" required title="Campo obligatorio" type="text" placeholder="Titulo" class="form-control">

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Asignacion de ticket</label>

                            <div class="col-lg-5">
                                <select name="" class="form-control" id="usuarioexpress" required title="Campo obligatorio">
                                    <option value="">usuarios...</option>
                                    @foreach($usuarios as $usuario)

                                        <option value="{{$usuario->id}}">{{$usuario->nombre}} {{$usuario->apellido}}</option>

                                        @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                            <div class="col-lg-10">
                                <textarea name="" id="descripcionexpress" cols="30" rows="4" class="form-control" required title="Campo obligatorio"></textarea>
                            </div>
                        </div>


                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" id="btn_guardarexpress" type="button">Enviar Ticket</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="row hidden" style="margin-top: 20px" id="ticketpersonalizado">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-tag"></i> Ticket Personalizado</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">
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




                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" id="btn_guardarpersonalizado" type="button">Enviar Ticket</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <script src="../js/funciones/tickets.js"></script>

@stop