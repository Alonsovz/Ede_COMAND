@extends('layouts.template')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
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

<div class="ibox-title" style="padding: 5px">
<a href="tck_solicitadosedesal" style="margin-right: 5px" class="btn  btn-warning btn-md pull-left"   type="button" ><i class="fa fa-ticket" ></i> Tickets solictados</a>
    <a href="tck_edesalshow" style="margin-left: 5px" class="btn btn-info btn-md pull-left"  type="button"><i class="fa fa-ticket"></i>Tickets Recibidos</a>
</div>
<br>
    <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-success btn-outline btn-lg dropdown-toggle"><i class="fa fa-ticket"></i> Nuevo Ticket <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" id="btn_ticketexpress">Ticket General</a></li>
            <li><a href="#" id="btn_ticketextraordinario">Ticket Informatica</a></li>
            <li class="divider"></li>
            <li><a href="#" id="btn_ticketquick">Auto-ticket</a></li>
        </ul>
    </div>





    {{--TICKET GENERAL PARA LAS AREAS EN GENERAL DE EDESAL--}}
    <div class="row hidden" style="margin-top: 20px" id="ticketexpress">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">

                    <h5><i class="fa fa-bolt"></i> Ticket General</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>


                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" id="frm_express">
                        <div class="alert alert-info alert-dismissible" style="color:black">
                            <i class="fa fa-info"></i>
                            El ticket general puedes utlizarlo para cualquier
                            requerimiento que necesites entre tu area y otra en especifico
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Titulo</label>

                            <div class="col-lg-6 input-group">
                                <input id="tituloexpress" required title="Campo obligatorio" type="text" placeholder="Titulo" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Asignacion de usuario</label>
                            <div class="col-lg-5 input-group" id="the-basics" >
                                <input type="text" placeholder="Digite el nombre del usuario" class="form-control typeahead" id="usuarioexpress" >
                            </div>
                        </div>

                       {{-- <div class="form-group"><label class="col-lg-2 control-label">Adjuntar archivo</label>

                            <div class="col-lg-6 input-group">
                                <input readonly="true" id="archivoexpress" required title="Campo obligatorio" type="text" placeholder="Archivo" class="form-control">
                            </div>
                        </div>--}}


                                <div class="form-group">
                                    <label class="col-lg-2 control-label" for="">Fecha de solucion aproximada</label>
                                    <div class='col-lg-4 date input-group' id='datetimepicker1'>
                                        <input id="fechasolaproxexpress" type='text' class="form-control" />
                                        <span class="input-group-addon" >
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>



                        <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                            <div class="col-lg-6 input-group">
                                <textarea name="" class="form-control" id="descripcionexpress" cols="10" rows="5"></textarea>
                            </div>
                        </div>


                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-8 input-group">
                                <button class="btn btn-md btn-primary" id="btn_guardarexpress" type="button"><i class="fa fa-save"></i> Enviar Ticket</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{--TICKET INFORMATICA--}}
    @if(Session::get('idusuario')==1 || Session::get('idusuario')==2 || Session::get('idusuario')==3 || Session::get('idusuario')==4)
        <div class="row hidden" style="margin-top: 20px" id="ticketextraordinario">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-diamond"></i> Ticket Informatica</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-toggle-down"></i>
                            </a>

                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" id="frm_extraordinario">

                            <div class="form-group"><label class="col-lg-2 control-label">Titulo:</label>

                                <div class="col-lg-6 input-group">
                                    <input type="text" placeholder="Titulo" id="tituloextraordinario" class="form-control">
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 control-label">Asignado a:</label>

                                <div class="col-lg-5 input-group" id="the-basics">
                                    <input type="text" id="usuarioextraordinario" class="form-control" value="{{Session::get('nombreusuario')}}" readonly="readonly">
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 control-label">Solicitante:</label>

                                <div class="col-lg-5 input-group" id="the-basics">
                                    <input type="text" id="usersolicitante" class="form-control typeahead" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="">Fecha de solucion aproximada:</label>
                                <div class='col-lg-4 date input-group' id='datetimepicker2'>
                                    <input id="fechasolaproxextraordinario" type='text' class="form-control" />
                                    <span class="input-group-addon" >
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 control-label">Sistemas:</label>

                                <div class="col-lg-5 input-group">
                                    <select name="" class="form-control" id="sistemaspersonalizado">
                                        <option value="">Seleccione un sistema...</option>
                                        @foreach($sistemas as $sistema)

                                            <option value="{{$sistema->id}}">{{$sistema->nombre}}</option>

                                        @endforeach
                                    </select>
                                    <div class="alert-dismissible alert alert-warning" style="color: black;"><i class="fa fa-warning"></i>
                                        El campo de sistema puede
                                        quedar vacio si tu ticket es en relacion a otra incidencia o requerimiento
                                    </div>
                                </div>
                            </div>

                            <div class="form-group hidden" id="divmodulos"><label class="col-lg-2 control-label">Modulos:</label>

                                <div class="col-lg-5 input-group">
                                    <select name="" class="form-control" id="modulos">
                                        <option value="">Selecciones un modulo...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 control-label">Descripcion:</label>

                                <div class="col-lg-6 input-group">

                                    <textarea name="" class="form-control" id="descextraordinario" cols="10" rows="5"></textarea>
                                </div>
                            </div>




                            <div class="form-group" >

                                @if(Session::get('idusuario')==1 || Session::get('idusuario')==2 || Session::get('idusuario')==3 || Session::get('idusuario')==4)
                                    <div class="col-lg-offset-2 col-lg-10 input-group">
                                        <button class="btn btn-md btn-primary" id="btn_guardarextraordinario1" type="button"><i class="fa fa-save"></i> Enviar Ticket</button>
                                    </div>
                                    @else
                                    <div class="col-lg-offset-2 col-lg-10 input-group">
                                        <button class="btn btn-md btn-primary" id="btn_guardarextraordinario" type="button"><i class="fa fa-save"></i> Enviar Ticket</button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row hidden" style="margin-top: 20px" id="ticketextraordinario">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-diamond"></i> Ticket Informatica</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-toggle-down"></i>
                            </a>

                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" id="frm_extraordinario">

                            <div class="form-group"><label class="col-lg-2 control-label">Titulo</label>

                                <div class="col-lg-6 input-group">
                                    <input type="text" placeholder="Titulo" id="tituloextraordinario" class="form-control">
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 control-label">Asignacion de usuario</label>

                                <div class="col-lg-5 input-group" id="the-basics">
                                    <select name="" id="usuarioextraordinario" class="form-control">
                                        <option value="">Seleccione un usuario...</option>
                                        @foreach($usuarios as $usuario)
                                            <option value="{{$usuario->id}}">{{$usuario->nombre}} {{$usuario->apellido}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="">Fecha de solucion aproximada</label>
                                <div class='col-lg-4 date input-group' id='datetimepicker2'>
                                    <input id="fechasolaproxextraordinario" type='text' class="form-control" />
                                    <span class="input-group-addon" >
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 control-label">Sistemas</label>

                                <div class="col-lg-5 input-group">
                                    <select name="" class="form-control" id="sistemaspersonalizado">
                                        <option value="">Seleccione un sistema...</option>
                                        @foreach($sistemas as $sistema)

                                            <option value="{{$sistema->id}}">{{$sistema->nombre}}</option>

                                        @endforeach
                                    </select>
                                    <div class="alert-dismissible alert alert-warning" style="color: black;"><i class="fa fa-warning"></i>
                                        El campo de sistema puede
                                        quedar vacio si tu ticket es en relacion a otra incidencia o requerimiento
                                    </div>
                                </div>
                            </div>

                            <div class="form-group hidden" id="divmodulos"><label class="col-lg-2 control-label">Modulos</label>

                                <div class="col-lg-5 input-group">
                                    <select name="" class="form-control" id="modulos">
                                        <option value="">Selecciones un modulo...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                                <div class="col-lg-6 input-group">

                                    <textarea name="" class="form-control" id="descextraordinario" cols="10" rows="5"></textarea>
                                </div>
                            </div>




                            <div class="form-group" >
                                <div class="col-lg-offset-2 col-lg-10 input-group">
                                    <button class="btn btn-md btn-primary" id="btn_guardarextraordinario" type="button"><i class="fa fa-save"></i> Enviar Ticket</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    <div class="row hidden" style="margin-top: 20px" id="ticketextraordinario">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-diamond"></i> Ticket Informatica</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-toggle-down"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" id="frm_extraordinario">

                        <div class="form-group"><label class="col-lg-2 control-label">Titulo</label>

                            <div class="col-lg-6 input-group">
                                <input type="text" placeholder="Titulo" id="tituloextraordinario" class="form-control">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Asignacion de usuario</label>

                            <div class="col-lg-5 input-group" id="the-basics">
                                <select name="" id="usuarioextraordinario" class="form-control">
                                    <option value="">Seleccione un usuario...</option>
                                    @foreach($usuarios as $usuario)
                                        <option value="{{$usuario->id}}">{{$usuario->nombre}} {{$usuario->apellido}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="">Fecha de solucion aproximada</label>
                            <div class='col-lg-4 date input-group' id='datetimepicker2'>
                                <input id="fechasolaproxextraordinario" type='text' class="form-control" />
                                <span class="input-group-addon" >
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Sistemas</label>

                            <div class="col-lg-5 input-group">
                                <select name="" class="form-control" id="sistemaspersonalizado">
                                    <option value="">Seleccione un sistema...</option>
                                    @foreach($sistemas as $sistema)

                                        <option value="{{$sistema->id}}">{{$sistema->nombre}}</option>

                                    @endforeach
                                </select>
                                <div class="alert-dismissible alert alert-warning" style="color: black;"><i class="fa fa-warning"></i>
                                    El campo de sistema puede
                                    quedar vacio si tu ticket es en relacion a otra incidencia o requerimiento
                                </div>
                            </div>
                        </div>

                        <div class="form-group hidden" id="divmodulos"><label class="col-lg-2 control-label">Modulos</label>

                            <div class="col-lg-5 input-group">
                                <select name="" class="form-control" id="modulos">
                                    <option value="">Selecciones un modulo...</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                            <div class="col-lg-6 input-group">

                                <textarea name="" class="form-control" id="descextraordinario" cols="10" rows="5"></textarea>
                            </div>
                        </div>




                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10 input-group">
                                <button class="btn btn-md btn-primary" id="btn_guardarextraordinario" type="button"><i class="fa fa-save"></i> Enviar Ticket</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{--AUTO TICKET--}}
    <div class="row hidden" style="margin-top: 20px" id="ticketquick">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-bomb"></i> Auto Ticket</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-toggle-down"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" id="frm_quick">

                        <h2><b>Datos del ticket</b></h2>

                        <div class="form-group"><label class="col-lg-2 control-label">Titulo</label>

                            <div class="col-lg-6 input-group">
                                <input type="text" placeholder="Titulo" id="tituloquick" class="form-control">

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Solicitante</label>

                            <div class="col-lg-5 input-group" id="the-basics">
                                <input type="text" class="form-control typeahead" id="usuarioquick">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Categoria de ticket</label>

                            <div class="col-lg-5 input-group" id="the-basics">
                                <select name="" id="categoriaquick" class="form-control">
                                    <option value="">seleccione una categoria</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Sistemas</label>

                            <div class="col-lg-5 input-group">
                                <select name="" class="form-control" id="sistemasquick">
                                    <option value="">Selecciones un sistema...</option>
                                    @foreach($sistemas as $sistema)

                                        <option value="{{$sistema->id}}">{{$sistema->nombre}}</option>

                                    @endforeach
                                </select>
                                <div class="alert alert-info alert-dismissible" style="color:black">
                                    <i class="fa fa-info"></i>
                                    El campo de sistema puede
                                    quedar vacio si tu ticket es en relacion a otra incidencia o requerimiento
                                </div>
                            </div>
                        </div>

                        <div class="form-group hidden" id="divmoduloquick"><label class="col-lg-2 control-label">Modulos</label>

                            <div class="col-lg-5 input-group">
                                <select name="" class="form-control" id="modquick">
                                    <option value="">Seleccione un modulo...</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                            <div class="col-lg-6 input-group">

                                <textarea name="" class="form-control" id="descripcionquick" cols="10" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Solucion</label>

                            <div class="col-lg-6 input-group">

                                <textarea name="" class="form-control" id="solucionquick" cols="10" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="">Fecha de solucion</label>
                            <div class='col-lg-4 date input-group' id='datetimepicker3'>
                                <input id="fechasolautoticket" type='text' class="form-control" />
                                <span class="input-group-addon" >
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                            </div>
                        </div>


                        <h2><b>Datos de bitacora</b></h2>

                        <div class="form-group"><label class="col-lg-2 control-label">Tiempo dedicado</label>

                            <div class="col-lg-2 input-group">

                                <input type="number" class="form-control" id="tiempodedicado" step="0.25">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Linea de bitacora</label>

                            <div class="col-lg-6 input-group">
                                <textarea name="" class="form-control" disabled="disabled" id="lineabitacora" cols="30" rows="2"></textarea>
                            </div>
                        </div>



                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10 input-group">
                                <button class="btn btn-md btn-primary" id="btn_guardarquick" type="button"><i class="fa fa-save"></i> Enviar Ticket</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@stop

@section('scripts')
    <script src="../js/plugins/fullcalendar/moment.min.js"></script>
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <script src="../js/funciones/tickets.js"></script>

@stop