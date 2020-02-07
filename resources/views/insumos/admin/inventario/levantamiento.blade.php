@extends('layouts.template')

@section('css')

    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
@stop

@section('enunciado')
    Insumos
@stop

@section('modulo')
    Insumos
@stop

@section('submodulo')
    <b>Inventario inicial</b>
@stop

@section('contenido')


    <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-success btn-md dropdown-toggle"> Seleccione un tipo de insumo <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li id="herramientas"><a href="#">Herramienta Electricista</a></li>
            <li id="papeleria"><a href="#">Papeleria</a></li>
            <li id="limpieza"><a href="#">Limpieza</a></li>
            <li id="oficina"><a href="#">Herramienta Oficina</a></li>

        </ul>
    </div>

    {{--DIV PARA HERRAMIENTAS DE ELECTRICISTAS--}}
    <div class="row hidden" id="divherramientas" style="margin-top: 25px">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-heading">
                    <div class="ibox-title">
                        <div class="row" style="padding-right: 10px; padding-left: 10px">
                            <h3><i class="fa fa-file-text"></i> Formulario de levantamiento de inventario <small><b>Herramientas de  Electricistas</b></small></h3>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            <div class="row">

                                <button style="margin-right: 10px" class="btn pull-right btn-warning btn-sm" data-target="#modalherramienta" data-toggle="modal">
                                    <i class="fa fa-plus-circle"></i> Agregar insumos
                                </button>
                            </div>
                        </div>
                        <div class="panel-body">

                        </div>
                        <table class="table  table-hover" id="tablainsumos">
                            <thead>
                            <tr>
                                <th style="width: 10px">Estado Herram.</th>
                                <th style="width: 10px">Codigo</th>
                                <th style="width: 150px">Insumo</th>
                                <th style="width: 180px">Bodega</th>
                                <th style="width: 20px">Cantidad</th>
                                <th style="width: 20px">Accion</th>
                            </tr>
                            </thead>
                            <tbody id="cuerpotabla">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="ibox-footer" style="background-color: white">
                    <div class="row" style="margin-top: 30px">
                        <button type="button" class="btn btn-danger btn-sm pull-right" style="margin-left: 5px; margin-right: 15px">Cancelar</button>
                        <button type="button" class="btn btn btn-primary btn-sm pull-right " id="btn_guardarinventarioherram">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--DIV PARA HERRAMIENTAS DE OFICINA--}}
    <div class="row hidden" id="divoficina" style="margin-top: 25px">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-heading">
                    <div class="ibox-title">
                        <div class="row" style="padding-right: 10px; padding-left: 10px">
                            <h3><i class="fa fa-file-text"></i> Formulario de levantamiento de inventario <small><b>Herramientas de Oficina</b></small></h3>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            <div class="row">

                                <button style="margin-right: 10px" class="btn pull-right btn-warning btn-sm" data-target="#modaloficina" data-toggle="modal">
                                    <i class="fa fa-plus-circle"></i> Agregar insumos
                                </button>
                            </div>
                        </div>
                        <div class="panel-body">

                        </div>
                        <table class="table  table-hover" id="tablainsumosoficina">
                            <thead>
                            <tr>
                                <th style="width: 10px">Estado Herram.</th>
                                <th style="width: 10px">Codigo</th>
                                <th style="width: 150px">Insumo</th>
                                <th style="width: 180px">Centro de costo</th>
                                <th style="width: 20px">Cantidad</th>
                                <th style="width: 20px">Accion</th>
                            </tr>
                            </thead>
                            <tbody id="cuerpotabla">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="ibox-footer" style="background-color: white">
                    <div class="row" style="margin-top: 30px">
                        <button type="button" class="btn btn-danger btn-sm pull-right" style="margin-left: 5px; margin-right: 15px">Cancelar</button>
                        <button type="button" class="btn btn btn-primary btn-sm pull-right " id="btn_guardarinvoficina">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--DIV PARA INSUMOS DE LIMPIEZA -->
    <div class="row hidden" id="divlimpieza" style="margin-top: 25px">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-heading">
                    <div class="ibox-title">
                        <div class="row" style="padding-right: 10px; padding-left: 10px">
                            <h3><i class="fa fa-file-text"></i> Formulario de levantamiento de inventario <small><b>Limpieza</b></small></h3>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            <div class="row">

                                <button style="margin-right: 10px" class="btn pull-right btn-warning btn-sm" data-target="#modallimpieza" data-toggle="modal">
                                    <i class="fa fa-plus-circle"></i> Agregar insumos
                                </button>
                            </div>
                        </div>
                        <div class="panel-body">

                        </div>
                        <table class="table  table-hover" id="tablainsumoslimpieza">
                            <thead>
                            <tr>

                                <th style="width: 10px">Codigo</th>
                                <th style="width: 150px">Insumo</th>
                                <th style="width: 150px">Descripcion</th>
                                <th style="width: 20px">Cantidad</th>
                                <th style="width: 20px">Accion</th>
                            </tr>
                            </thead>
                            <tbody id="cuerpotabla">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="ibox-footer" style="background-color: white">
                    <div class="row" style="margin-top: 30px">
                        <button type="button" class="btn btn-danger btn-sm pull-right" style="margin-left: 5px; margin-right: 15px">Cancelar</button>
                        <button type="button" class="btn btn btn-primary btn-sm pull-right " id="btn_guardarlimpieza">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--DIV PARA HERRAMIENTAS DE PAPELERIA--}}
    <div class="row hidden" id="divpapeleria" style="margin-top: 25px">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-heading">
                    <div class="ibox-title">
                        <div class="row" style="padding-right: 10px; padding-left: 10px">
                            <h3><i class="fa fa-file-text"></i> Formulario de levantamiento de inventario <small><b>Papeleria</b></small></h3>

                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            <div class="row">

                                <button style="margin-right: 10px" class="btn pull-right btn-warning btn-sm" data-target="#modalpapeleria" data-toggle="modal">
                                    <i class="fa fa-edit"></i> Agregar insumos
                                </button>
                            </div>
                        </div>
                        <div class="panel-body">

                        </div>
                        <table class="table  table-hover" id="tablainsumospapeleria">
                            <thead>
                            <tr>
                                <th style="width: 10px">N°</th>
                                <th style="width: 10px">Codigo</th>
                                <th style="width: 150px">Insumo</th>
                                <th style="width: 180px">Descripcion</th>
                                <th style="width: 20px">Cantidad</th>
                                <th style="width: 20px">Accion</th>
                            </tr>
                            </thead>
                            <tbody id="cuerpotabla">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="ibox-footer" style="background-color: white">
                    <div class="row" style="margin-top: 30px">
                        <button type="button" class="btn btn-danger btn-sm pull-right" style="margin-left: 5px; margin-right: 15px">Cancelar</button>
                        <button type="button" class="btn btn btn-primary btn-sm pull-right " id="btn_guardarinventariopapeleria">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>










    <!--MODAL PARA EL INGRESO DE INSUMOS LIMPIEZA-->
    <div class="modal inmodal fade" id="modallimpieza" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Agregar Insumos</h5>
                    <h2><i class="fa fa-table"></i></h2>

                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_insumoslimpieza">

                        <div class="form-group"><label class="col-lg-2 control-label">Insumo</label>

                            <div class="col-lg-8" id="the-basicslimpieza">
                                <input id="insumo3" required title="Campo obligatorio" type="text" placeholder="Digite el insumo" class="form-control typeahead">
                                <br><br>
                                {{--<button class="btn btn-warning btn-xs " data-toggle="modal" data-target="#modalnuevoinsumo1" id="btn_nuevoinsumolimpieza"><i class="fa fa-plus-circle"></i> Nuevo insumo</button>--}}
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-lg-8" id="the-basicslimpieza">

                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group hidden"><label class="col-lg-2 control-label">Codigo</label>

                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="codinsumo3" type="text" readonly="readonly" placeholder="" class=" form-control ">
                            </div>
                        </div>

                        <div id="divcodinsumo" class="form-group "><label class="col-lg-2 control-label">UM</label>

                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="unidadlimpieza" type="text" readonly="readonly" placeholder="" class=" form-control ">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Cantidad</label>
                            <div class="col-lg-3" id="">
                                <input min="0" autocomplete="off" id="cantidad3" required title="Campo obligatorio" type="number" placeholder="" class="form-control ">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" id="btn_insertarfilalimpieza" type="button">Insertar fila</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodalinsumos1" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL PARA EL INGRESO DE INSUMOS PAPELERIA-->
    <div class="modal inmodal fade" id="modalpapeleria" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Agregar Insumos</h5>
                    <h2><i class="fa fa-table"></i></h2>

                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_insumospapeleria">

                        <div class="form-group"><label class="col-lg-2 control-label">Insumo</label>

                            <div class="col-lg-8" id="the-basicspapeleria">
                                <input id="insumo1" required title="Campo obligatorio" type="text" placeholder="Digite el insumo" class="form-control typeahead">
                                <br><br>
                                {{--<button class="btn btn-warning btn-xs " data-toggle="modal" data-target="#modalnuevoinsumo1" id="btn_nuevoinsumolimpieza"><i class="fa fa-plus-circle"></i> Nuevo insumo</button>--}}

                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group hidden"><label class="col-lg-2 control-label">Codigo</label>

                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="codinsumo1" required title="Campo obligatorio" type="text" readonly="readonly" placeholder="" class=" form-control ">
                            </div>
                        </div>

                        <div id="divcodinsumo" class="form-group "><label class="col-lg-2 control-label">UM</label>

                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="unidadpape"  type="text" readonly="readonly" placeholder="" class=" form-control ">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Cantidad</label>

                            <div class="col-lg-3" id="">
                                <input min="0" autocomplete="off" id="cantidad1" required title="Campo obligatorio" type="number" placeholder="" class="form-control ">
                            </div>
                        </div>


                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" id="btn_insertarfilapapeleria" type="button">Insertar fila</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodalinsumos1" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL PARA EL INGRESO DE INSUMOS HERRAMIENTAS-->
    <div class="modal inmodal fade" id="modalherramienta" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <h5 class="modal-title">Agregar Insumos</h5>
                    <h2><i class="fa fa-table"></i></h2>

                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_insumosherramientas">

                        <div class="form-group"><label class="col-lg-2 control-label">Insumo</label>

                            <div class="col-lg-8" id="the-basicsherramientas">
                                <input id="insumo2" required title="Campo obligatorio" type="text" placeholder="Digite el insumo" class="form-control typeahead">
                                <br><br>
                                {{--<button class="btn btn-warning btn-xs " data-toggle="modal" data-target="#modalnuevoinsumo1" id="btn_nuevoinsumolimpieza"><i class="fa fa-plus-circle"></i> Nuevo insumo</button>--}}
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group hidden"><label class="col-lg-2 control-label">Codigo</label>
                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="codinsumo" required title="Campo obligatorio" type="text" readonly="readonly" placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group "><label class="col-lg-2 control-label">UM</label>
                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="unidadelec" required title="Campo obligatorio" type="text" readonly="readonly" placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divestados" class="form-group "><label class="col-lg-2 control-label">Estado</label>

                            <div class="col-lg-4" id="">
                                <select name="estadoherram" id="estadoherram" class="form-control">
                                    <option value="">Seleccione..</option>
                                    @foreach($estados as $estado)
                                        <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Cantidad</label>

                            <div class="col-lg-3" id="">
                                <input min="0" autocomplete="off" id="cantidad" required title="Campo obligatorio" type="number" placeholder="" class="form-control ">
                            </div>
                        </div>

                        {{--<div class="form-group"><label class="col-lg-2 control-label">Bodega</label>
                            <div class="col-lg-6" id="">
                                <select name="" class="form-control" id="bodega">
                                    <option value="">seleccione una bodega...</option>
                                    @foreach($bodegas as $bodega)
                                        <option value="{{$bodega->id}}">{{$bodega->codigo}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>--}}


                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" id="btn_insertarfilaherramienta" type="button">Insertar fila</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodalinsumos2" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL PARA EL INGRESO DE INSUMOS DE HERRAMIENTAS DE OFICINA--}}
    <div class="modal inmodal fade" id="modaloficina" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <h5 class="modal-title">Agregar Insumos</h5>
                    <h2><i class="fa fa-table"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_oficina">

                        <div class="form-group"><label class="col-lg-2 control-label">Insumo</label>

                            <div class="col-lg-8" id="the-basicsoficina">
                                <input id="insumo4" required title="Campo obligatorio" type="text" placeholder="Digite el insumo" class="form-control typeahead">
                                <br><br>
                                {{--<button class="btn btn-warning btn-xs " data-toggle="modal" data-target="#modalnuevoinsumo1" id="btn_nuevoinsumolimpieza"><i class="fa fa-plus-circle"></i> Nuevo insumo</button>--}}
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group hidden"><label class="col-lg-2 control-label">Codigo</label>
                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="codinsumoof" required title="Campo obligatorio" type="text" readonly="readonly" placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divestados" class="form-group "><label class="col-lg-2 control-label">Estado</label>

                            <div class="col-lg-4" id="">
                                <select name="estadoherram" id="estadoherramof" class="form-control">
                                    <option value="">Seleccione..</option>
                                    @foreach($estados as $estado)
                                        <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Cantidad</label>

                            <div class="col-lg-3" id="">
                                <input min="0" autocomplete="off" id="cantidadof" required title="Campo obligatorio" type="number" placeholder="" class="form-control ">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Centro de costo</label>
                            <div class="col-lg-6" id="">
                                <select name="" class="form-control" id="centrocosto">
                                    <option value="">seleccione un cc...</option>
                                    @foreach($centrocostos as $cc)
                                        <option value="{{$cc->id}}">{{$cc->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" id="btn_insertarfilaoficina" type="button">Insertar fila</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodalinsumos2" data-dismiss="modal">Cerrar</button>
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


    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <script src="../js/funciones/inventario.js"></script>



@stop