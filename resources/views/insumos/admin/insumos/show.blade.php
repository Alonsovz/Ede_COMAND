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
    <b>Insumos</b>
@stop

@section('contenido')
    <div class="row" id="divbandeja">


        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <button type="button" data-toggle="modal" data-target="#nuevoinsumo" class="btn btn-block btn-success btn-lg btn-outline compose-mail" href="">
                            <i class="fa fa-plus-circle"></i> Nuevo insumo
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!--DATATABLE PARA PERMISOS-->
        <div class="col-lg-12 animated fadeInRight" >
            <div class="mail-box-header">
                <h2>
                    Insumos
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">


                </div>
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
        <!--FIN DE DATATABLE PARA PERMISOS-->
    </div>




    <!--MODAL PARA MOSTRAR EL FORMULARIO PARA NUEVO PROVEEDOR-->
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
                                <input type="text"  min="0" id="unidadmedida" class="form-control">
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


    {{--MODAL PARA ELIMINAR DE INSUMO--}}
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
                                <button type="button" class="btn btn-white"><i class="fa fa-close" data-dismiss="modal"></i> Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                </div>
            </div>

        </div>

    </div>



    {{--MODAL para Edicion un insumo--}}
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
                                <textarea name="" id="desc" class="form-control" cols="30" rows="4"></textarea>
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
                                    <option value="">Si</option>
                                    <option value="">No</option>

                                </select>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">UM:</label>

                            <div class="col-lg-4" >
                                <input type="text"  min="0" id="unidadmedida" class="form-control">
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


@stop