@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.19.0/sweetalert2.min.css">
@stop

@section('enunciado')
    Insumos
@stop

@section('modulo')
    Insumos
@stop

@section('submodulo')
    <b>Mantenimiento</b>
@stop

@section('contenido')
    <div class="row" id="divbandeja">


        <div class="btn-group" style="margin-left: 15px">
            <button data-toggle="dropdown" class="btn btn-success btn-outline btn-lg dropdown-toggle"><i class="fa fa-wrench"></i> Mantenimientos <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" id="btn_ver_insumos">Insumos</a></li>
                <li><a href="#" id="btn_ver_proveedores">Proveedores</a></li>
                <li class="divider"></li>

            </ul>
        </div>
        <br>
        <br>


        <!--DATATABLE PARA INSUMOS-->
        <div class="col-lg-12 hidden animated fadeInRight" id="insumos" >
            <div class="mail-box-header">
                <h2>
                    Insumos
                </h2>
                <div class="pull-right"> <button type="button" data-toggle="modal" data-target="#nuevoinsumo" class="btn btn-block btn-success btn-lg  btn-outline compose-mail" href="">
                        <i class="fa fa-plus-circle"></i> Nuevo insumo
                    </button>
                </div>
                <div class="mail-tools tooltip-demo m-t-md">

                </div>
                <br><br>
            </div>
            <div class="mail-box" style="padding: 5px;">

                <table id="tablainsumos" class="dataTables-example1 table-bordered table table-hover table-striped table-mail dataTables-example" style="color:black" >
                    <thead id="header" class="">
                    <tr style="background-color: lightgrey">
                        <th style="border: solid 1px black;">Codigo</th>
                        <th style="border: solid 1px black;">Insumo</th>
                        <th style="border: solid 1px black;">Categoria</th>
                        <th style="border: solid 1px black;">Descripcion</th>
                        <th style="border: solid 1px black;">Precio</th>
                        <th style="border: solid 1px black;">UM</th>
                        <th style="border: solid 1px black;"></th>
                        <th style="border: solid 1px black;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($insumos as $i)
                        <tr>
                            <td style="border: solid 1px black;">{{$i->id}}</td>
                            <td style="border: solid 1px black;">{{$i->nombre}}</td>
                            <td style="border: solid 1px black;">{{$i->categoria}}</td>
                            <td style="border: solid 1px black;">{{$i->descripcion}}</td>
                            <td style="border: solid 1px black;">{{$i->precio}}</td>
                            <td style="border: solid 1px black;">{{$i->um}}</td>
                            <td style="border: solid 1px black;" data-toggle="modal" data-target="#eliminarinsumo" class="text-center"><button class="btn btn-md btn-danger btn_deleteinsumo" id="{{$i->nombre}}"><i class="fa fa-trash"></i></button></td>
                            <td style="border: solid 1px black;" class="text-center"><a id="{{$i->id}}" data-target="#edicioninsumo" data-toggle="modal" class="btn btn-md btn-info verinsumo"><i class="fa fa-edit"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot id="footer" class="hidden">
                    <tr>
                        <th>Rendering engine</th>
                        <th>Browser</th>
                        <th>Platform(s)</th>
                        <th>Engine version</th>
                        <th>CSS grade</th>
                    </tr>
                    </tfoot>
                </table>




            </div>
        </div>
        <!--FIN DE DATATABLE PARA INSUMOS-->

        <!--DATATABLE PARA PROVEEDORES-->
        <div class="col-lg-12 animated fadeInRight hidden" id="proveedores">
            <div class="mail-box-header">
                <h2>
                    Proveedores
                </h2>
                <div class="pull-right"> <button type="button" data-toggle="modal" data-target="#nuevoproveedor" class="btn btn-block btn-success btn-lg  btn-outline compose-mail" href="">
                        <i class="fa fa-plus-circle"></i> Nuevo proveedor
                    </button>
                </div>
                <br>
                <br>
                <div class="mail-tools tooltip-demo m-t-md">


                </div>
            </div>

            <div class="mail-box" style="padding: 5px;">

                <table class="dataTables-example1 table table-hover table-striped table-mail dataTables-example" >
                    <thead id="header" class="">
                    <tr style="border: 1px solid black; background-color: lightgrey">
                        <th style="border:solid black 1px; color: black">ID</th>
                        <th style="border:solid black 1px; color: black">Contacto</th>
                        <th style="border:solid black 1px; color: black">Entidad</th>
                        <th style="border:solid black 1px; color: black">Razon Social</th>
                        <th style="border:solid black 1px; color: black">Telefono</th>
                        <th style="border:solid black 1px; color: black">Accion</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($proveedores as $proveedor)
                        <tr>
                            <td style="border: 1px solid black;color:black">{{$proveedor->id}}</td>
                            <td style="border: 1px solid black;color:black">{{$proveedor->nombrecontacto}}</td>
                            <td style="border: 1px solid black;color:black">{{$proveedor->nombreentidad}}</td>
                            <td style="border: 1px solid black;color:black">{{$proveedor->razonsocial}}</td>
                            <td style="border: 1px solid black;color:black">{{$proveedor->telefonomovil}}</td>
                            <td style="border: 1px solid black;color:black"><button id="{{$proveedor->id}}" data-toggle="modal" data-target="#edicionproveedor" class="btn btn-info btn-md editarproveedor"><i class="fa fa-edit"></i></button></td>

                        </tr>

                    @endforeach
                    </tbody>
                    <tfoot id="footer" class="hidden">
                    <tr>
                        <th>Rendering engine</th>
                        <th>Browser</th>
                        <th>Platform(s)</th>
                        <th>Engine version</th>
                        <th>CSS grade</th>
                    </tr>
                    </tfoot>
                </table>




            </div>
        </div>
        <!--FIN DE DATATABLE PARA PROVEEDORES-->
    </div>




    <!--MODAL PARA MOSTRAR EL FORMULARIO PARA NUEVO insumo-->
    <div class="modal inmodal" id="nuevoinsumo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInLeft">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-truck modal-icon"></i>
                    <h4 class="modal-title"><small>Nuevo insumo</small></h4>
                    <small class="font-bold" id="empleadosolicitud"></small>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="">

                        <div class="form-group"><label class="col-lg-2 control-label">Nombre:</label>

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
                                    <option value="2">Herramienta Electricista</option>
                                    <option value="3">Limpieza</option>
                                    <option value="4">Herramienta Oficina</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">UM:</label>

                            <div class="col-lg-4" >
                                <select name="" id="unidad_nuevo" class="form-control">
                                    <option value="">seleccione una unidad...</option>
                                   @foreach($unidades as $unidad)
                                        <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                                       @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Activo:</label>
                            <div class="col-lg-4" >
                                <select name="" id="activo_nuevo" class="form-control">
                                    <option value="">Seleccione una opcion...</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-primary" id="btn_guardarinsumo" data-dismiss="modal" type="button"><i class="fa fa-save"></i> Guardar insumo</button>
                                <button type="button" class="btn btn-danger btn-sm" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                </div>
            </div>

        </div>

    </div>


    {{--MODAL PARA eliminar DE INSUMO--}}
    <div class="modal inmodal" id="eliminarinsumo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInLeft">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h1> <i class="fa fa-trash modal-icon"></i></h1>
                    <h4 class="modal-title"><small>Eliminar Insumo</small></h4>
                    <small class="font-bold" id="empleadosolicitud"></small>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fa fa-warning"></i>
                        <b>Esta seguro de eliminar el insumo de la base de datos... </b>
                    </div>

                    <form class="form-horizontal">
                        <div class="form-group"><label class="col-lg-2 control-label">Insumo:</label>
                            <div class="col-lg-4" >
                                <input type="text" id="insumo" class="form-control" readonly="true">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label"></label>
                            <div class="col-lg-4" >
                                <button type="button" id="btn_sieliminar" class="btn btn-danger"><i class="fa fa-trash"></i> Si Eliminar</button>
                                <button type="button" data-dismiss="modal" class="btn btn-white"><i class="fa fa-close" data-dismiss="modal"></i> Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                </div>
            </div>

        </div>

    </div>



    {{--MODAL para edicion un insumo--}}
    <div class="modal inmodal" id="edicioninsumo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInLeft">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-truck modal-icon"></i>
                    <h4 class="modal-title"><small>Edicion de Isumo</small></h4>
                    <small class="font-bold" id="empleadosolicitud"></small>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="">

                        <div class="form-group"><label class="col-lg-2 control-label">Codigo:</label>
                            <div class="col-lg-8" >
                                <input type="text" id="codigo1" readonly="true" class="form-control">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Nombre:</label>

                            <div class="col-lg-8" >
                                <input type="text" id="nombreinsumo1" class="form-control">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Descripcion:</label>

                            <div class="col-lg-8" >
                                <textarea name="" id="desc" class="form-control"  cols="30" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Precio:</label>

                            <div class="col-lg-4" >
                                <input type="number"  min="0" id="precioinsumo1" class="form-control">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Categoria:</label>
                            <div class="col-lg-4" >
                                <select name="" id="categ" class="form-control">
                                    <option value=""></option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Activo:</label>
                            <div class="col-lg-4" >
                                <select name="" id="activo" class="form-control">

                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">UM:</label>

                            <div class="col-lg-4" >
                                <select name="" id="unidad_edicion" class="form-control">

                                    @foreach($unidades as $unidad)
                                        <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-primary" id="btn_guardaredicion" data-dismiss="modal" type="button"><i class="fa fa-save"></i> Guardar insumo</button>
                                <button type="button" class="btn btn-danger btn-sm" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                </div>
            </div>

        </div>

    </div>










    <!--MODAL PARA MOSTRAR EL FORMULARIO PARA NUEVO PROVEEDOR-->
    <div class="modal inmodal" id="nuevoproveedor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-truck modal-icon"></i>
                    <h4 class="modal-title"><small>Nuevo proveedor</small></h4>
                    <small class="font-bold" id="empleadosolicitud"></small>
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
                    <button type="button" id="btn_guardarproveedor" class="btn btn-success btn-md" data-dismiss="modal">Guardar</button>
                    <button type="button" id="btn_cerrarupdatepermisos" class="btn btn-danger btn-md" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>

    </div>



    <!--MODAL PARA MOSTRAR EL FORMULARIO DE LA EDICION DE UN PROVEEDOR-->
    <div class="modal inmodal" id="edicionproveedor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-truck modal-icon"></i>
                    <h4 class="modal-title"><small>Edicion</small></h4>
                    <small class="font-bold" id="empleadosolicitud"></small>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group" id="the-basics">
                                <label>Nombre entidad: </label>
                                <input  id="entidad1"   type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="the-basics">
                                <label>Razon social: </label>
                                <input  id="razonsocial1"   type="text" class="form-control" >
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group" id="the-basics">
                                <label>Contacto: </label>
                                <input  id="contacto1"   type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="the-basics">
                                <label>Direccion: </label>
                                <input  id="direccion1"   type="text" class="form-control">
                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group" id="the-basics">
                                <label>Correo electronico: </label>
                                <input  id="correo1"   type="text" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="the-basics">
                                <label>Telefono: </label>
                                <input  id="telefono1"   type="text" class="form-control">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btn_actualizarproveedor" class="btn btn-success btn-md" data-dismiss="modal">Actualizar</button>
                    <button type="button" id="btn_cerrarupdatepermisos" class="btn btn-danger btn-md" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>

    </div>

@stop


@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.19.0/sweetalert2.min.js"></script>

    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>
    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>
    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script src="../js/funciones/insumos.js"></script>
    <script src="../js/funciones/proveedores.js"></script>


@stop