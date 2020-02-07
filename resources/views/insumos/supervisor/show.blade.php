@extends('layouts.template')

@section('css')

    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/datapicker/datepicker3.css">

@stop

@section('enunciado')
    Insumos
@stop

@section('modulo')
    Insumos
@stop

@section('submodulo')
    <b>Requisiciones</b>
@stop

@section('contenido')


    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">

                        <div class="" style="padding: 20px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md" style="">

                                        <h1 style="margin-bottom: 40px"><i class="fa fa-file-text-o"></i> Detalles de requisicion <k class="text-primary"><b>N° {{$requisicion->id}}</b></k></h1>
                                        <input type="text" value="{{$requisicion->id}}" class="hidden" id="requisicion">
                                        <div class="col-lg-5">
                                            <dl class="dl-horizontal">

                                                <dt>Tipo de Req:</dt>
                                                <dd class="">
                                                    <b>{{$requisicion->tiporequisicion}}</b>
                                                </dd>

                                                <dt>Autorizante: </dt> <dd><b>{{$requisicion->nombreautorizante}} {{$requisicion->apellidoautorizante}}</b></dd>

                                                <dt>Justificacion:</dt> <dd class="text-info">{{$requisicion->justificacion}}</dd>

                                                <dt>Fecha solicitud:</dt> <dd><?php
                                                    $fecha = date_create($requisicion->fechasolicitud);
                                                    echo date_format($fecha,'d/m/Y');
                                                    ?></dd>

                                                <dt>Fecha aprobacion:</dt> <dd><?php
                                                    $fecha = date_create($requisicion->fechaaprobacion);
                                                    echo date_format($fecha,'d/m/Y');
                                                    ?></dd>

                                                <dt>Estado:</dt>
                                                <dd class="">
                                                    <b>{{$requisicion->estado}}</b>
                                                </dd>
                                            </dl>

                                        </div>


                                    </div>

                                </div>
                            </div>




                        </div>




                    </div>
                    <div class="ibox-footer">
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="row">
                                            @if($requisicion->estado=='Recibida')
                                            <button id="btn_editarrequisicion"  class="pull-right btn btn-warning btn-sm" style="margin-right: 5px"><i class="fa fa-edit"></i> Editar Requisicion</button>
                                            @endif
                                            <button data-target="#nuevoinsumo" data-toggle="modal" id="{{$requisicion->tiporequisicion}}"
                                                    class="hidden pull-right btn btn-success btn-sm btn_agregarinsumo" style="margin-right: 5px">
                                                <i class="fa fa-plus"></i> Agregar insumo</button>

                                        </div>
                                    </div>
                                    <!-- Default panel contents -->

                                    <!-- Tabla -->
                                    <table class="table  table-bordered"   id="tablainsumos" style="color: black">
                                        <thead class="">
                                        <tr>
                                            <th style="width: 10px; border: black solid 0.8px">N°</th>
                                            <th class="text-center" style="width: 10px; border: solid black 0.8px;">Codigo</th>
                                            <th  style="width: 200px; border: black solid 0.8px">Insumo</th>
                                            <th class="text-center" style="width: 10px; border: black solid 0.8px">Cantidad</th>
                                            <th class="text-center" style="width: 10px; border: black solid 0.8px">Precio</th>
                                            <th style="width: 10px; border: black solid 0.8px" class="text-center">Accion</th>


                                        </tr>
                                        </thead>
                                        <tbody id="">

                                        @foreach($insumos as $insumo)

                                            <tr id="{{$insumo->codinsumo}}">
                                                <td style="border:  black solid 0.8px"></td>
                                                <td style="border:  black solid 0.8px" class="text-center"><input readonly="readonly" type="text" value="{{$insumo->codinsumo}}" class="form-control codinsumo" readonly="readonly"></td>
                                                <td style="border:  black solid 0.8px">

                                                    <div class="input-group col-lg-12" id="the-basics">
                                                        <input readonly="readonly" type="text" autocomplete="off" value="{{$insumo->insumo}}" class="form-control insumo typeahead">
                                                        <span class="input-group-btn hidden">
                                                            <button id="" type="button" class="btn btn-white"><i class="fa fa-refresh"></i></button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td style="border:  black solid 0.8px" class="text-center"><input type="text" readonly="readonly" min="0" value="{{$insumo->cantidad}}" class="form-control cantidad" ></td>
                                                <td style="border:  black solid 0.8px" class="text-center"><input type="text" readonly="readonly" min="0" value="{{$insumo->precio}}" class="form-control precio" ></td>


                                                <td id="eliminarinsumo"  style="border:  black solid 0.8px" class="text-center ">
                                                    <button id="{{$insumo->codinsumo}}" type="button" class="btn btn-danger btn-sm btn_eliminarinsumo hidden"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                        <tfoot class="hidden" style="background-color: lightyellow; font-weight: bold">
                                        <tr>
                                            <td style="border:  black solid 0.8px"></td>
                                            <td style="border:  black solid 0.8px"></td>
                                            <td style="border:  black solid 0.8px"></td>
                                            <td style="border:  black solid 0.8px"></td>

                                            <td style="border:  black solid 0.8px" class="text-right"><small><b>SUB TOTAL</b></small></td>
                                            <td style="border:  black solid 0.8px" id="subtotal" class="text-right"></td>
                                            <td style="border:  black solid 0.8px"></td>
                                        </tr>
                                        <tr>
                                            <td style="border:  black solid 0.8px"></td>
                                            <td style="border:  black solid 0.8px"></td>

                                            <td style="border:  black solid 0.8px"></td>

                                            <td style="border:  black solid 0.8px" class="text-right"><small><b>IVA</b></small></td>
                                            <td style="border:  black solid 0.8px" id="iva" class="text-right"></td>
                                            <td style="border:  black solid 0.8px"></td>
                                        </tr>
                                        <tr>
                                            <td style="border:  black solid 0.8px"></td>
                                            <td style="border:  black solid 0.8px"></td>
                                            <td style="border:  black solid 0.8px"></td>

                                            <td style="border:  black solid 0.8px" class="text-right"><small><b>VALOR TOTAL</b></small></td>
                                            <td style="border:  black solid 0.8px" id="total" class="text-right"></td>
                                            <td style="border:  black solid 0.8px"></td>
                                        </tr>
                                        </tfoot>
                                    </table>

                                    <div class="panel-footer">
                                        <div class="row">
                                            <a href="rq_bandejasuperv" style="margin-left: 5px" class="btn btn-sm btn-danger pull-left"><i class="fa fa-arrow-left"></i> Bandeja</a>
                                            <button type="button" id="{{$requisicion->id}}" style="margin-right: 5px" class="btn btn-sm btn-primary pull-right hidden btn_guardaredicion"><i class="fa fa-check"></i> Guardar requisicion</button>
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




    <!--MODAL PÁRA NUEVO INSUMO-->
    <div class="modal inmodal fade" id="nuevoinsumo" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Agregar Insumos</h5>
                    <h2><i class="fa fa-table"></i></h2>

                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_insumos">

                        <div class="form-group"><label class="col-lg-2 control-label">Insumo</label>

                            <div class="col-lg-8" id="the-basics">
                                <input id="insumo" required title="Campo obligatorio" type="text" placeholder="Digite el insumo" class="form-control typeahead">
                                <br><br>
                                <button style="margin-top: 5px" data-target="#modalnuevoinsumo" data-toggle="modal" type="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Nuevo insumo</button>                            </div>
                        </div>
                        <br>

                        <div id="divcodinsumo" class="form-group hidden"><label class="col-lg-2 control-label">Codigo</label>
                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="codinsumo" required title="Campo obligatorio" type="text" readonly="readonly" placeholder="" class=" form-control ">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Cantidad</label>
                            <div class="col-lg-3" id="">
                                <input min="0" autocomplete="off" id="cantidad"  type="number"  class="form-control ">
                            </div>
                        </div>


                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" id="btn_insertarfila" type="button">Insertar fila</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodalinsumos" data-dismiss="modal">Finalizar</button>
                </div>
            </div>
        </div>
    </div>







    <!---MODAL PARA NUEVO INSUMO-->
    <div class="modal inmodal fade" id="modalnuevoinsumo" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Nuevo insumo</h5>
                    <h2><i class="fa fa-cubes"></i></h2>

                </div>
                <div class="modal-body" style="background-color: lightgrey">
                    <form class="form-horizontal" id="">

                        <div class="form-group"><label class="col-lg-2 control-label">Nombre de insumo:</label>

                            <div class="col-lg-8" >
                                <input type="text" id="nombreinsumo" class="form-control">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Descripcion:</label>

                            <div class="col-lg-8" >
                                <textarea name="" id="descripcioninsumo" class="form-control" cols="30" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Precio:</label>

                            <div class="col-lg-4" >
                                <input type="number"  min="0" id="precioinsumo" class="form-control">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Categoria:</label>

                            <div class="col-lg-4" >
                                <select name="" id="categoriainsumo" class="form-control">
                                    <option value="">categorias...</option>
                                    <option value="1">Papeleria</option>
                                    <option value="2">Herramienta</option>
                                    <option value="1003">Limpieza</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" id="btn_guardarinsumo" data-dismiss="modal" type="button">Guardar insumo</button>
                                <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodaltiporeq" data-dismiss="modal">Cerrar</button>
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

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <!-- funciones para calendario -->
    <script type="text/javascript" src='../js/plugins/datapicker/bootstrap-datepicker.js'></script>
    <!-- funciones para registrar los tiempos de los permisos por medio de la libreria clockpicker-->
    <script type="text/javascript" src='../js/plugins/clockpicker/clockpicker.js'></script>

    <script type="text/javascript" src="../js/funciones/clockanddate.js"></script>

    <script src="../js/funciones/detallesrequisicion.js"></script>

@stop










