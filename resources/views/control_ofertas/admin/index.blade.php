@extends('layouts.template')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
@stop


@section('enunciado')
    Control de Ofertas
@stop

@section('modulo')
    Control de ofertas
@stop

@section('submodulo')
Index
@stop

@section('contenido')
    <div class="btn-group">
        <button id="btn_nuevaoferta" class="btn btn-success btn-outline btn-lg dropdown-toggle">
            <i class="fa fa-money"></i> Nueva oferta
        </button>
    </div>



    {{--FORMULARIO PARA LAS NUEVAS OFERTAS--}}
    <div class="row hidden" style="margin-top: 20px" id="ofertafrm">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">

                    <h5><i class="fa fa-bolt"></i> Nueva Oferta</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>


                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" id="frm_express">

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

                        <div class="form-group"><label class="col-lg-2 control-label">Adjuntar archivo</label>

                            <div class="col-lg-6 input-group">
                                <input readonly="true" id="archivoexpress" required title="Campo obligatorio" type="text" placeholder="Archivo" class="form-control">
                            </div>
                        </div>


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