@extends('layouts.template')

@section('css')

    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/datapicker/datepicker3.css">

@stop

@section('enunciado')
    Requisiciones
@stop

@section('modulo')
    Requisiciones
@stop

@section('submodulo')
    <b>Revision</b>
@stop

@section('contenido')


<div class="row" >
    <div class="col-lg-12" >
        <div class="wrapper wrapper-content animated fadeInUp" >
            <div class="ibox" style="border: solid lightgrey 1px">
                <div class="ibox-content" >

                    <div class="" style="padding: 20px">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-b-md" style="">

                                    <h1 style="margin-bottom: 40px"><i class="fa fa-file-text-o"></i> Detalles de requisicion <k class="text-primary"><b>N° {{$requisicion->id}}</b></k></h1>
                                    <input type="text" value="{{$requisicion->id}}" class="hidden" id="requisicion">
                                    <div class="col-lg-5">
                                        <dl class="dl-horizontal">

                                            <dt>Solicitante: </dt> <dd><b>{{$requisicion->nombresolicitante}} {{$requisicion->apellidosolicitante}}</b></dd>
                                            <dt>Justificacion:</dt> <dd class="text-info">{{$requisicion->justificacion}}</dd>
                                            <dt>Fecha:</dt> <dd><?php
                                                $fecha = date_create($requisicion->fechasolicitud);
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
                                        <button  data-target="#nuevoinsumo" data-toggle="modal" class="pull-right btn btn-success btn-sm btn_agregarinsumo" id="{{$requisicion->tiporequisicion}}" style="margin-right: 5px"><i class="fa fa-plus"></i> Agregar insumo</button>
                                    </div>
                                </div>
                                <!-- Default panel contents -->

                                <!-- Tabla -->
                                <table class="table  table-bordered" style="color:black"   id="tablainsumos">
                                    <thead class="">
                                    <tr>


                                        <th  style="width: 20px; border: 0.5px solid black">Codigo</th>
                                        <th class="text-center" style="width: 10px; border: 0.5px solid black">Insumo</th>
                                        <th class="text-center" style="width: 10px; border: solid black 0.5px;">Cantidad</th>
                                        <th class="text-center" style="width: 50px; border: 0.5px solid black">Descripcion</th>
                                        <th style="width: 10px; border: 0.5px solid black" class="text-center">Precio uni</th>

                                        <th class="text-center" style="width: 20px;border: solid black 0.5px">Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">

                                    @foreach($insumos as $insumo)

                                        <tr id="{{$insumo->codinsumo}}">

                                            <td style="border:  solid black 0.5px" class="text-center"><input type="text" value="{{$insumo->codinsumo}}" class="form-control codinsumo" readonly="readonly"></td>
                                            <td style="border:  solid black 0.5px">

                                                <div class="input-group col-lg-12" id="the-basics">
                                                    <input readonly="readonly" type="text" autocomplete="off" value="{{$insumo->insumo}}" class="form-control insumo typeahead">
                                                    <span class="input-group-btn hidden">
                                                            <button id="" type="button" class="btn btn-white"><i class="fa fa-refresh"></i></button>
                                                        </span>
                                                </div>
                                            </td>
                                            <td style="border:  solid black 0.5px" class="text-center"><input type="number" min="0" value="{{$insumo->cantidad}}" class="form-control cantidad" ></td>
                                            <td style="border:  solid black 0.5px" ><input type="text" value="{{$insumo->ins_descripcion}}" class="form-control ins_descripcion" ></td>

                                            <td style="border:  solid black 0.5px" class="text-right"><input type="text" value="{{$insumo->precio}}" class="form-control precio"></td>

                                            <td style="border: solid black 0.5px" class="text-center">

                                                <button id="{{$insumo->codinsumo}}" type="button" class="btn btn-danger btn-sm btn_eliminarinsumo"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot style="background-color: lightgoldenrodyellow; color:black; font-weight: bold">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                        <td class="text-right"><small><b>SUB TOTAL</b></small></td>
                                        <td id="subtotal" class="text-right"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>

                                        <td></td>

                                        <td class="text-right"><small><b>IVA</b></small></td>
                                        <td id="iva" class="text-right"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                        <td class="text-right"><small><b>VALOR TOTAL</b></small></td>
                                        <td id="total" class="text-right"></td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>

                                <div class="panel-footer">
                                    <div class="row">

                                        <button style="margin-right: 5px" class="btn btn-sm btn-primary pull-right" id="btn_prepararorden" data-target="#ordencompra" data-toggle="modal"><i class="fa fa-download"></i> Orden de compra</button>
                                        <a href="rq_bandejaadmin" style="margin-left: 5px" class="btn btn-sm btn-warning pull-left"><i class="fa fa-arrow-left"></i> Bandeja</a>

                                        <a href="ocPDF" style="margin-right: 5px" class="btn btn-sm btn-primary pull-right hidden" id="btn_imprimirorden" ><i class="fa fa-print"></i> Imprimir Orden</a>
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
                        </div>
                    </div>

                    <div id="divcodinsumo" class="form-group hidden"><label class="col-lg-2 control-label">Codigo</label>
                        <div class="col-lg-3" id="">
                            <input autocomplete="off" id="codinsumo" required title="Campo obligatorio" type="text" readonly="readonly" placeholder="" class=" form-control ">
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Cantidad</label>
                        <div class="col-lg-3" id="">
                            <input autocomplete="off" id="cantidad"  type="number"  class="form-control ">
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
                <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodalinsumos" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



    <!--MODAL PARA GENERAR DATOS DE LA ORDEN COMPRA RESTANTES-->
<div class="modal inmodal fade" id="ordencompra" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h5 class="modal-title">Orden de compra</h5>
                <h1><i class="fa fa-shopping-cart"></i></h1>

            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frm_ordencompra">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="">
                                <label>Proveedor: </label>
                                <div class="input-group col-lg-10 " id="the-basics1">
                                    <select name="" id="proveedor" class="form-control">
                                        <option value="">proveedores...</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{$proveedor->id}}">{{$proveedor->nombreentidad}}</option>
                                        @endforeach
                                    </select>
                                    <input  type="text" id="proveedor" placeholder="digite el nombre de proveedor" name="" class="hidden form-control typeahead " value="">
                                </div>
                            </div>
                            <div class="form-group" id="">

                                <div class="input-group col-lg-10 " id="the-basics1">
                                    <button type="button" data-toggle="modal" data-target="#modal_nuevoproveedor" class="btn btn-xs btn-warning"><i class="fa fa-plus-circle"></i> Agregar proveedor</button>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px">
                        <div class="col-lg-12">
                            <div class="form-group" id="">
                                <label>Terminos de pago: </label>
                                <div class="input-group col-lg-10 " id="the-basics1">
                                    <select name="" id="terminopago" class="form-control">
                                        <option value="">terminos...</option>
                                        @foreach($terminos as $termino)
                                            <option value="{{$termino->id}}">{{$termino->nombre}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group" id="data_1">
                                <label>Fecha de entrega: </label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input  type="text" id="fechaentrega" name="" class="form-control " value="">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-sm btn-success" id="btn_guardarorden" type="button">Guardar Orden</button>
                <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodalorden" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>




<!--NUEVO PROVEEDOR-->
<div class="modal inmodal fade" id="modal_nuevoproveedor" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h5 class="modal-title">Nuevo proveedor</h5>
                <h2><i class="fa fa-user"></i></h2>

            </div>
            <div class="modal-body">
                <form id="frm_proveedor">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group" id="the-basics">
                                <label>Nombre entidad: </label>
                                <input  id="entidad"   type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="the-basics">
                                <label>Razon social: </label>
                                <input  id="razonsocial"   type="text" class="form-control" >
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group" id="the-basics">
                                <label>Contacto: </label>
                                <input  id="contacto"   type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="the-basics">
                                <label>Direccion: </label>
                                <input  id="direccion"   type="text" class="form-control">
                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group" id="the-basics">
                                <label>Correo electronico: </label>
                                <input  id="correo"   type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="the-basics">
                                <label>Telefono: </label>
                                <input  id="telefono"   type="text" class="form-control">
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="btn_guardarnuevoproveedor" data-dismiss="modal">Guardar</button>
                <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodalinsumos" data-dismiss="modal">Cerrar</button>
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

    <script src="../js/funciones/admin_detalles_req.js"></script>

@stop










