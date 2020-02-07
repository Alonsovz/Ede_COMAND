@extends('layouts.template')

@section('css')

    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
@stop

@section('enunciado')
    Requisiciones
@stop

@section('modulo')
    Requisiciones
@stop

@section('submodulo')
    <b>Nueva requisicion</b>
@stop

@section('contenido')



    <div class="row">
        <img src="../images/order1.png" alt="" height="80" width="80" style="margin-left: 15px">
    </div><br><br>
    <button class="btn btn-success btn-lg btn-outline " data-toggle="modal" data-target="#requisiciontipo"  id="btn_nuevarequisicion">
        <i class="fa fa-plus"></i> Nueva requisición
    </button>
    <br><br>

    <div class="row  hidden" id="divrequisicion">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-heading">
                    <div class="ibox-title">
                        <div class="row" style="padding-right: 10px; padding-left: 10px">
                            <h3><i class="fa fa-file-text"></i> Formulario de requisicion</h3>
                            <h2 class="pull-right">N° Requisicion <b id="numerorequisicion">{{$requisicion}}</b></h2>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <h1 style="margin-bottom: 30px">General <small></small></h1>

                    <form class="form-horizontal">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group"><label class="col-lg-2 control-label">Solicitante: </label>
                                    <div class="col-lg-7">
                                        <input readonly="readonly" value="{{Session::get('nombreusuario')}}" type="text" class="form-control" id="solicitante">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group"><label class="col-lg-2 control-label">Fecha: </label>
                                    <div class="col-lg-5">
                                        <input type="text"
                                               value="<?php echo date('d/m/Y') ?>" readonly="readonly" class="form-control" id="fecha">
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="row hidden">
                            <div class="col-lg-8">
                                <div class="form-group"><label class="col-lg-2 control-label">Area: </label>
                                    <div class="col-lg-4">
                                        <select name="" id="departamento" class="form-control">
                                            <option value="">Areas...</option>
                                                @foreach($departamentos as $departamento)
                                                    <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group"><label class="col-lg-2 control-label">Justificacion: </label>
                                    <div class="col-lg-8">
                                        <textarea name="" id="justificacion" class="form-control" cols="200" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>







                    </form>
                </div>


                <div class="ibox-footer">

                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                           <div class="row">
                               <button style="margin-right: 10px" class="btn pull-right btn-info btn-sm" id="btn_edicion">
                                   <i class="fa fa-edit"></i> Edicion de requisicion
                               </button>
                               <button style="margin-right: 10px" class="btn pull-right btn-warning btn-sm" id="btn_nuevoinsumo" data-target="#nuevoinsumo" data-toggle="modal">
                                   <i class="fa fa-plus-circle"></i> Agregar insumos
                               </button>
                           </div>
                        </div>
                        <div class="panel-body">

                        </div>
                    <table class="table  table-hover" id="tablainsumos">
                        <thead>
                        <tr>
                            <th style="width: 10px">N°</th>
                            <th style="width: 10px">Codigo</th>
                            <th style="width: 150px">Insumo</th>
                            <th style="width: 180px">Descripcion</th>
                            <th style="width: 20px">Cantidad</th>
                            <th style="width: 20px">Precio</th>
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
                       <div style="margin-left: 10px" id="barra_progreso" class="hidden">
                           <h3>Enviando...</h3>
                           <div class="progress">
                               <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="83"
                                    aria-valuemin="0" aria-valuemax="100" style="width:83%">
                                   80%
                               </div>
                           </div>
                       </div>
                       <button type="button" class="btn btn-danger btn-lg btn-outline pull-right" style="margin-left: 5px; margin-right: 15px"><i class="fa fa-close"></i> Cancelar</button>
                       <button type="button" class="btn btn btn-primary btn-lg btn-outline  pull-right hidden barra" id="btn_enviarrequisicionpape"> <i class="fa fa-save"></i> Enviar requisicion</button>
                       <button type="button" class="btn btn btn-primary btn-lg btn-outline  pull-right hidden barra" id="btn_enviarrequisicionherram"> <i class="fa fa-save"></i> Enviar requisicion</button>
                       <button type="button" class="btn btn btn-primary btn-lg btn-outline  pull-right hidden barra" id="btn_enviarrequisicionlimp"> <i class="fa fa-save"></i> Enviar requisicion</button>
                       <button type="button" class="btn btn btn-primary btn-lg btn-outline  pull-right hidden barra" id="btn_enviarrequisicionoficina"> <i class="fa fa-save"></i> Enviar requisicion</button>
                   </div>
                   </div>
            </div>
        </div>
    </div>




    <!--MODAL PARA EL INGRESO DE INSUMOS-->
    <div class="modal inmodal fade" id="nuevoinsumo" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Agregar Insumos</h5>
                    <h2><i class="fa fa-table"></i></h2>

                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_insumos">
                        <div class="form-group"><label class="col-lg-2 control-label">Insumo</label>
                            <div class="col-lg-9" id="the-basics">
                                <input id="insumo" required title="Campo obligatorio" type="text" placeholder="Digite el insumo" class="form-control typeahead">
                                {{--<button style="margin-top: 5px" data-target="#modalnuevoinsumo" data-toggle="modal" type="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Nuevo insumo</button>--}}
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label"></label>
                            <div style="margin-left: 15px" id="alertaestado" class="alert alert-dismissable alert-warning col-lg-9 hidden">

                            </div>
                        </div>

                        <div class="row hidden" style="margin-top: 50px" id="detallesbodega">
                           <div class="col-lg-8" style="margin-left: 145px">
                               <div class="ibox">

                                   <div class="ibox-title">
                                       <h3 class="text-primary"><i class="fa fa-home"></i> Detalles de asignaciones
                                       </h3>

                                   </div>

                                   <div class="ibox-content">
                                       <table class="dataTables-example1 table table-hover table-mail dataTables-example" id="tabladetalles" >
                                           <thead id="header" class="">
                                           <tr>
                                               <th>Codigo</th>
                                               <th>Insumo</th>
                                               <th>Usuario Asignado</th>
                                               <th>Estado</th>
                                               <th></th>
                                               <th></th>
                                           </tr>
                                           </thead>
                                           <tbody>
                                           {{--@foreach($detalles as $detalle)
                                               <tr>
                                                   <td>{{$detalle->codigo}}</td>
                                                   <td>{{$detalle->insumo}}</td>
                                                   <td>{{$detalle->electricista}}</td>
                                                   <td>{{$detalle->estado}}</td>
                                                   <td><button class="btn btn-info btn-xs btn_editaractivo" id="{{$detalle->insumo}}-{{$detalle->hoja_activo_id}}"><i class="fa fa-edit"></i> Editar</button></td>
                                                   <td><button class="btn btn-success btn-xs btn_imprimirhoja"><i class="fa fa-file-pdf-o"></i> Imprimir</button></td>
                                               </tr>
                                           @endforeach--}}
                                           </tbody>
                                           <tfoot id="footer" class="hidden">
                                           <tr>
                                               <th>Codigo</th>
                                               <th>Insumo</th>
                                               <th>Sin asignar</th>
                                               <th>Estado</th>
                                               <th>Acccion</th>
                                           </tr>
                                           </tfoot>
                                       </table>

                                   </div>

                                   {{--<div class="ibox-footer hidden " id="divedicionactivo">

                                       <h1 style="margin-left:10px;margin-bottom: 30px">Edicion de activo <small></small></h1>
                                       <form id="frm_adqactivo">

                                           <div class="row">
                                               <div class="col-lg-8">
                                                   <div class="form-group"><label class="col-lg-2 control-label">Insumo: </label>
                                                       <div class="col-lg-8">
                                                           <input type="text" class="form-control" id="insumo1" readonly="true">
                                                       </div>
                                                   </div>
                                               </div>

                                               <div class="col-lg-4">
                                                   <div class="form-group"><label class="col-lg-2 control-label">Estado: </label>
                                                       <div class="col-lg-8">
                                                           <select name="" id="estados" class="form-control">
                                                               <option value="">seleccione un estado...</option>
                                                               @foreach($estados as $estado)
                                                                   <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                                               @endforeach
                                                           </select>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                           <br>
                                           <br>
                                           <div class="row">
                                               <button style="margin-right: 5px" type="button" class="btn btn-primary pull-right btn_guardaredicion"><i class="fa fa-save"></i> Guardar edicion</button>
                                           </div>
                                       </form>

                                   </div>--}}
                               </div>
                           </div>
                        </div>
                        <div id="divcodinsumo" class="form-group hidden"><label class="col-lg-2 control-label">Codigo</label>
                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="codinsumo" required title="Campo obligatorio" type="text" readonly="readonly" placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group "><label class="col-lg-2 control-label">UM</label>
                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="unidad" required title="Campo obligatorio" type="text" readonly="readonly" placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group "><label class="col-lg-2 control-label">Descripcion</label>
                            <div class="col-lg-9" id="">
                                <textarea name="" id="descins" class="form-control" cols="30" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Cantidad</label>
                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="cantidad" min="0" required title="Campo obligatorio" type="number" placeholder="" class="form-control ">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Precio</label>
                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="precioini" min="0" required title="Campo obligatorio" type="number" placeholder="" class="form-control ">
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





    <!--MODAL PARA LA EDICION DE INSUMOS ANTES DE ENVIAR LA REQUISICION-->
    <div class="modal inmodal fade" id="editarinsumo" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Editar Seleccion</h5>
                    <h2><i class="fa fa-edit"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_insumos">

                        <div class="form-group"><label class="col-lg-2 control-label">Insumo</label>

                            <div class="col-lg-8" id="the-basics">
                                <input id="insumo_edit" required title="Campo obligatorio" type="text" placeholder="Digite el insumo" class="form-control typeahead">
                                {{--<button style="margin-top: 5px" data-target="#modalnuevoinsumo" data-toggle="modal" type="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Nuevo insumo</button>--}}
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group hidden"><label class="col-lg-2 control-label">Codigo</label>

                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="codinsumo_edit" required title="Campo obligatorio" type="text" readonly="readonly" placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Cantidad</label>

                            <div class="col-lg-3" id="">
                                <input autocomplete="off" id="cantidad_edit" min="0" required title="Campo obligatorio" type="number" placeholder="" class="form-control ">
                            </div>
                        </div>


                        <div class="form-group" >

                        </div>
                    </form>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-sm btn-success" id="btn_guardaredicion" type="button">Guardar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cancelaredicion" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>




    <!--MODAL PARA SELECCION DEL TIPO DE REQUISICION-->
    <div class="modal inmodal fade" id="requisiciontipo" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Tipo de requisicion</h5>
                    <h2><i class="fa fa-flag-checkered"></i></h2>

                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="">

                        <div class="form-group"><label class="col-lg-2 control-label">Requisicion:</label>

                            <div class="col-lg-8" >
                                <select name="" class="form-control" id="tiporequisicion">
                                    <option value="0">Seleccione...</option>
                                    <option value="1">Papeleria</option>
                                    <option value="2">Herramientas Electricista</option>
                                    <option value="3">Limpieza</option>
                                    <option value="4">Herramientas de Oficina</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" id="btn_seleccionartipo" type="button">Seleccionar</button>
                                <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodaltiporeq" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">

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

    <script src="../js/funciones/requisiciones.js"></script>




@stop