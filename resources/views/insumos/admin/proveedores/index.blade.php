@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
@stop

@section('enunciado')
    Insumos
@stop

@section('modulo')
    Insumos
@stop

@section('submodulo')
    <b>Proveedores</b>
@stop

@section('contenido')
    <div class="row" id="divbandeja">


        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <button type="button" data-toggle="modal" data-target="#nuevoproveedor" class="btn btn-block btn-primary compose-mail" href="">Nuevo proveedor</button>
                        <div class="space-25"></div>
                        <h5></h5>
                        <ul class="folder-list m-b-md" style="padding: 0">
                            <li><a href=""> <i class="fa fa-inbox "></i>Proveedores <span class="label label-warning pull-right"></span> </a></li>
                        </ul>
                        <h5></h5>
                        <ul class="category-list" style="padding: 0">
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>


        <!--DATATABLE PARA PROVEEDORES-->
        <div class="col-lg-12 animated fadeInRight" >
            <div class="mail-box-header">
                <h2>
                    Proveedores
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">


                </div>
            </div>
            <div class="mail-box" style="padding: 5px;">

                <table class="dataTables-example1 table table-hover table-striped table-mail dataTables-example" >
                    <thead id="header" class="">
                    <tr>
                        <th>Contacto</th>
                        <th>Entidad</th>
                        <th>Razon Social</th>
                        <th>Telefono</th>
                        <th>Accion</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($proveedores as $proveedor)
                                <tr>
                                    <td>{{$proveedor->nombrecontacto}}</td>
                                    <td>{{$proveedor->nombreentidad}}</td>
                                    <td>{{$proveedor->razonsocial}}</td>
                                    <td>{{$proveedor->telefonomovil}}</td>
                                    <td><button id="{{$proveedor->id}}" data-toggle="modal" data-target="#edicionproveedor" class="btn btn-white btn-xs editarproveedor"><i class="fa fa-edit"></i></button></td>

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

    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>
    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>
    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script src="../js/funciones/proveedores.js"></script>

@stop