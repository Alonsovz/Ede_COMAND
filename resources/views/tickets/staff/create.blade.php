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
Nuevo ticket
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
            <button id="btn_ticketextraordinario" class="btn btn-warning btn-sm">Ticket extraordinario</button>
            <button id="btn_ticketquick" class="btn btn-default btn-sm">Ticket quick</button>
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



    <div class="row hidden" style="margin-top: 20px" id="ticketextraordinario">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-diamond"></i> Ticket Extraordinario</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-toggle-down"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" id="frm_extraordinario">

                        <div class="form-group"><label class="col-lg-2 control-label">Titulo</label>

                            <div class="col-lg-6">
                                <input type="text" placeholder="Titulo" id="tituloextraordinario" class="form-control">

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Asignacion de ticket</label>

                            <div class="col-lg-5" id="the-basics">

                                <input type="text" placeholder="Digite el nombre del usuario" class="form-control typeahead" id="usuarioextraordinario" >
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

                                <textarea name="" class="form-control" id="descextraordinario" cols="10" rows="5"></textarea>
                            </div>
                        </div>




                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" id="btn_guardarextraordinario" type="button">Enviar Ticket</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <div class="row hidden" style="margin-top: 20px" id="ticketquick">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-bomb"></i> Ticket Quick</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-toggle-down"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" id="frm_quick">

                        <h3><b>Datos del ticket</b></h3>

                        <div class="form-group"><label class="col-lg-2 control-label">Titulo</label>

                            <div class="col-lg-6">
                                <input type="text" placeholder="Titulo" id="tituloquick" class="form-control">

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Asignacion de ticket</label>

                            <div class="col-lg-5" id="the-basics">
                                <input type="text" class="form-control typeahead" id="usuarioquick">

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Sistemas</label>

                            <div class="col-lg-5">
                                <select name="" class="form-control" id="sistemasquick">
                                    <option value="">Selecciones un sistema...</option>
                                    @foreach($sistemas as $sistema)

                                        <option value="{{$sistema->id}}">{{$sistema->nombre}}</option>

                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group hidden" id="divmoduloquick"><label class="col-lg-2 control-label">Modulos</label>

                            <div class="col-lg-5">
                                <select name="" class="form-control" id="moduloquick">
                                    <option value="">Selecciones un modulo...</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                            <div class="col-lg-6">

                                <textarea name="" class="form-control" id="descripcionquick" cols="10" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Solucion</label>

                            <div class="col-lg-6">

                                <textarea name="" class="form-control" id="solucionquick" cols="10" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group " id="divmoduloquick"><label class="col-lg-2 control-label">Fecha de solucion</label>
                            <div class="col-lg-5">
                                <input type="text" id="datetimepicker2" class="form-control fsolucion">
                            </div>
                        </div>


                        <h3><b>Datos de bitacora</b></h3>

                        <div class="form-group"><label class="col-lg-2 control-label">Tiempo dedicado</label>

                            <div class="col-lg-2">

                                <input type="number" class="form-control" id="tiempodedicado" step="0.25">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Linea de bitacora</label>

                            <div class="col-lg-6">
                                <textarea name="" class="form-control" disabled="disabled" id="lineabitacora" cols="30" rows="2"></textarea>
                            </div>
                        </div>



                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" id="btn_guardarquick" type="button">Enviar Ticket</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>


    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <script src="../js/funciones/tickets.js"></script>

@stop