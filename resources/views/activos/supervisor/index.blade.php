@extends('layouts.template')

@section('css')

    <link rel="stylesheet" href="../css/plugins/sweetalert/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">

    <style>
        body{
            color: black;
        }
    </style>
@stop

@section('enunciado')
    Activos
@stop

@section('modulo')
    Activos
@stop

@section('submodulo')
    <b>EDESAL</b>
@stop

@section('contenido')




    <div class="row" id="">

        <br>
        <h1><i class="fa fa-dropbox"></i> Activos asignados</h1><br><br>
        <div class="form-group">
            <button class="btn btn-lg btn-danger btn-outline pull-right" style="margin-right: 5px" id="btn_eliminaractivos">
                <i class="fa fa-trash"></i> Eliminar
            </button>
            <button data-toggle="modal" data-target="#nuevoactivo" class="btn btn-lg btn-success btn-outline pull-right" style="margin-right: 5px" id="btn_eliminaractivos">
                <i class="fa fa-plus-circle"></i> Nuevo activo
            </button>
            <div class="btn-group pull-right" style="margin-right: 5px">
                <button data-toggle="dropdown" class="btn btn-warning btn-outline btn-lg dropdown-toggle"><i class="fa fa-pdf"></i> Reportes <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#" id="" data-toggle="modal" data-target="#activosxempleado">Activos por empleado</a></li>
                    <li><a href="#" id="" data-toggle="modal" data-target="#generalactivos">General de activos</a></li>

                    <li class="divider"></li>

                </ul>
            </div>
        </div>
        <br><br><br><br>

    </div>
    <div class="row">
        <div id="kilometraje1" class="col-lg-12" style="">
            <div class="ibox" style="border:solid lightgrey 1px; ">
                <div class="ibox-content" style="overflow-x: scroll;overflow-y: hidden">
                    <table id="tbl_activosemp" class="dataTables-example1 table-responsive table table-hover  table-mail " style="color: black;margin-top: 20px; font-size: 12px" >
                        <thead id="header" class="">
                        <tr style="background-color: lightgrey">
                            <th class="text-center" style="border: solid 1px grey;"></th>
                            <th class="text-center" style="border: solid 1px grey;">Empleado/Vehiculo</th>
                            <th class="text-center" style="border: solid 1px grey;">Activo</th>
                            <th class="text-center" style="border: solid 1px grey;">VNR</th>
                            <th class="text-center" style="border: solid 1px grey;">Cta. Conta</th>
                            <th class="text-center" style="border: solid 1px grey;">Cod. Conta.</th>
                            <th class="text-center" style="border: solid 1px grey;">Cod. COMANDA.</th>
                            <th class="text-center" style="border: solid 1px grey;">Color</th>
                            <th class="text-center" style="border: solid 1px grey;">Marca</th>
                            <th class="text-center" style="border: solid 1px grey;">Modelo</th>
                            <th class="text-center" style="border: solid 1px grey;">Fecha de compra</th>
                            <th class="text-center" style="border: solid 1px grey;">CCF</th>
                            <th class="text-center" style="border: solid 1px grey;">Proveedor</th>
                            <th class="text-center" style="border: solid 1px grey;">Valor</th>
                            <th class="text-center" style="border: solid 1px grey;">Area de inversion</th>
                            <th class="text-center" style="border: solid 1px grey;">Ubicacion</th>
                            <th class="text-center" style="border: solid 1px grey;">CC</th>
                            <th class="text-center" style="border: solid 1px grey;">Editar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activos as $a)
                            <tr style="">
                                <td style="border: solid 1px grey; "><input value="{{$a->id}}" name="activos" type="checkbox"></td>
                                @if($a->empleado)
                                    <td style="border: solid 1px grey; "><b>{{$a->nombre}} {{$a->apellido}}</b></td>
                                    @else
                                    <td style="border: solid 1px grey; "><b>{{$a->bodega}}</b></td>
                                    @endif
                                <td style="border: solid 1px grey; ">{{$a->tipo_activo}}</td>
                                <td style="border: solid 1px grey; ">{{$a->codigo_vnr}}</td>
                                <td style="border: solid 1px grey; ">{{$a->cuenta_contable}}</td>
                                <td style="border: solid 1px grey; ">{{$a->codigo_conta}}</td>
                                <td style="border: solid 1px grey; ">{{$a->codigo_comanda}}</td>
                                <td style="border: solid 1px grey; ">{{$a->color}}</td>
                                <td class="text-center" style="border: solid 1px grey;">{{$a->marca}}</td>
                                <td class="text-center" style="border: solid 1px grey;">{{$a->modelo}}</td>
                                @if($a->fecha_compra)
                                    <td class="text-center" style="border: solid 1px grey;"><?php $fecha = date_create($a->fecha_compra); echo date_format($fecha,'d/m/Y') ?></td>
                                @else
                                    <td class="text-center" style="border: solid 1px grey;">N/A</td>
                                @endif
                                <td class="text-center" style="border: solid 1px grey;">{{$a->ccf}}</td>
                                <td class="text-center" style="border: solid 1px grey;">{{$a->proveedor}}</td>
                                <td class="text-right" style="border: solid 1px grey;"><b>{{$a->valor}}</b></td>
                                <td class="text-center" style="border: solid 1px grey;">{{$a->area_inversion}}</td>
                                @if($a->ubicacion)
                                    <td class="text-center" style="border: solid 1px grey;">{{$a->ubicacion}}</td>
                                @else
                                    <td class="text-center" style="border: solid 1px grey;">Oficina</td>
                                @endif
                                <td class="text-center" style="border: solid 1px grey;">{{$a->centro_costo}}</td>
                                <td style="border: solid black 1px"><button type="button" id="{{$a->id}}" class="btn btn-info edicion" data-toggle="modal" data-target="#editaractivo">
                                        <i class="fa fa-edit"></i> Editar
                                    </button></td>
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
        </div>
    </div>





    {{--MODAL PARA EDICION DE ACTIVO EMPLEADO --}}
    <div class="modal inmodal fade" id="editaractivo" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Editar Activo</h5>
                    <h2><i class="fa fa-edit"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_edicionactivo">

                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Empleado:</label>
                            <div class="col-lg-4 hidden" id="">
                                <input autocomplete="off" id="id" name="id" required title="Campo obligatorio" type="text" readonly="readonly" placeholder="" class=" form-control ">
                            </div>
                            <div class="col-lg-4" id="the-basics">
                                <input autocomplete="off" id="empleado" name="empleado" required title="Campo obligatorio" type="text"  placeholder="" class=" form-control typeahead ">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Activo:</label>

                            <div class="col-lg-8" id="the-basics">
                                <input id="activo" required title="Campo obligatorio" name="activo" type="text" placeholder="" class="form-control typeahead">
                            </div>
                        </div>

                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Marca:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="marca" name="marca" required title="Campo obligatorio" type="text"  placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Modelo:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="modelo" name="modelo" required title="Campo obligatorio" type="text"  placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Color:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="color" name="color" required title="Campo obligatorio" type="text"  placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Fecha:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="fecha" name="fecha" required title="Campo obligatorio" type="text"  placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">CCF:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="ccf" name="ccf" required title="Campo obligatorio" type="text" placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Proveedor:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="proveedor" name="proveedor" required title="Campo obligatorio" type="text" r placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Valor:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="valor" name="valor" required title="Campo obligatorio" type="number" min="0"  placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Area de inversion:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" name="areainversion" id="areainversion" required title="Campo obligatorio" type="text"  placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Finalidad:</label>
                            <div class="col-lg-4" id="">
                                <select name="finalidad" id="finalidad" class="form-control">
                                    <option value=""></option>
                                    <option value="Comercializacion">Comercializacion</option>
                                    <option value="Distribucion">Distribucion</option>
                                    <option value="General">General</option>
                                </select>
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Ubicacion:</label>
                            <div class="col-lg-8" id="">
                                <textarea class="form-control" name="ubicacion" id="ubicacion" cols="20" rows="5"></textarea>
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Bodega:</label>
                            <div class="col-lg-4" id="">
                                <select  class="form-control" id="bodega" name="bodega">
                                    <option value=""></option>
                                    @foreach($bodegas as $bodega)
                                        <option value="{{$bodega->id}}">{{$bodega->codigo}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-sm btn-primary" id="btn_guardaredicion" type="button"><i class="fa fa-save"></i> Guardar edicion</button>
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cancelaredicion" data-dismiss="modal"><i class="fa fa-cloe"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>






    {{--MODAL PARA NUEVO ACTIVO--}}
    <div class="modal inmodal fade" id="nuevoactivo" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Nuevo Activo</h5>
                    <h2><i class="fa fa-dropbox"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_nuevoactivo">

                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Empleado:</label>

                            <div class="col-lg-4" id="the-basics">
                                <input autocomplete="off" id="n_empleado" name="n_empleado" required title="Campo obligatorio" type="text" placeholder="" class=" form-control typeahead">
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Activo:</label>

                            <div class="col-lg-8" id="">
                                <input id="n_activo" name="n_activo" required title="Campo obligatorio"  type="text" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Marca:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="n_marca" name="n_marca"  required title="Campo obligatorio" type="text"  placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Modelo:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="n_modelo" name="n_modelo"  required title="Campo obligatorio" type="text"  placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Color:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="n_color" name="n_color"  required title="Campo obligatorio" type="text"  placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Fecha:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="n_fecha" name="n_fecha"  required title="Campo obligatorio" type="text"  placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">CCF:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="n_ccf" name="n_ccf" required title="Campo obligatorio" type="text" placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Proveedor:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="n_proveedor" name="n_proveedor"  required title="Campo obligatorio" type="text" r placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Valor:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off" id="n_valor" name="n_valor"  required title="Campo obligatorio" type="number" min="0"  placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Area de inversion:</label>
                            <div class="col-lg-4" id="">
                                <input autocomplete="off"  id="n_areainversion" name="n_areainversion" required title="Campo obligatorio" type="text"  placeholder="" class=" form-control ">
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Finalidad:</label>
                            <div class="col-lg-4" id="">
                                <select name="n_finalidad" id="n_finalidad" class="form-control">
                                    <option value=""></option>
                                    <option value="Comercializacion">Comercializacion</option>
                                    <option value="Distribucion">Distribucion</option>
                                    <option value="General">General</option>
                                </select>
                            </div>
                        </div>
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Ubicacion:</label>
                            <div class="col-lg-8" id="">
                                <textarea class="form-control"  id="n_ubicacion" name="n_ubicacion" cols="20" rows="5"></textarea>
                            </div>
                        </div>

                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Bodega:</label>
                            <div class="col-lg-4" id="">
                                <select  class="form-control" id="n_bodega" name="n_bodega">
                                    <option value=""></option>
                                    @foreach($bodegas as $bodega)
                                        <option value="{{$bodega->id}}">{{$bodega->codigo}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-sm btn-primary" id="btn_guardaractivo" type="button"><i class="fa fa-save"></i> Guardar activo</button>
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cancelaredicion" data-dismiss="modal"><i class="fa fa-cloe"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA PARAMENTROS DEL REPORTE DE GENERACION DE ACTIVOS POR EMPLEADO--}}
    <div class="modal inmodal fade" id="activosxempleado" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Parametros</h5>
                    <h2><i class="fa fa-file-text"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_nuevoactivo">
                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Empleado:</label>
                            <div class="col-lg-4" id="the-basics">
                                <input autocomplete="off" id="rpt_empleado" name="rpt_empleado" required title="Campo obligatorio" type="text" placeholder="" class=" form-control typeahead">
                            </div>
                        </div>

                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Formato:</label>
                            <div class="col-lg-4" id="the-basics">
                                <label for="">PDF
                                    <input autocomplete="off" id="" name="formatoactxempleado" value="pdf" required title="Campo obligatorio" type="radio" placeholder="" class="  typeahead">
                                </label>
                                <label for="">Excel
                                    <input autocomplete="off" id="" name="formatoactxempleado" value="excel" required title="Campo obligatorio" type="radio" placeholder="" class="  typeahead">
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" id="btn_generarActXEmple" type="button"><i class="fa fa-save"></i> Generar reporte</button>
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cancelaredicion" data-dismiss="modal"><i class="fa fa-cloe"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>




    {{--MODAL PARA PARAMETROS DEL REPORTE DE ACTIVOS EN GENERAL--}}
    <div class="modal inmodal fade" id="generalactivos" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Matriz de activos</h5>
                    <h2><i class="fa fa-file-text"></i></h2>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_nuevoactivo">

                        <div id="divcodinsumo" class="form-group"><label class="col-lg-2 control-label">Formato:</label>
                            <div class="col-lg-4" id="the-basics">
                                <label for="">PDF
                                    <input autocomplete="off" id="" name="formatoactxempleado" value="pdf" required title="Campo obligatorio" type="radio" placeholder="" class="  typeahead">
                                </label>
                                <label for="">Excel
                                    <input autocomplete="off" id="" name="formatoactxempleado" value="excel" required title="Campo obligatorio" type="radio" placeholder="" class="  typeahead">
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" id="btn_generarsabana" type="button"><i class="fa fa-save"></i> Generar reporte</button>
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cancelaredicion" data-dismiss="modal"><i class="fa fa-cloe"></i> Cancelar</button>
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
    <script src="https://unpkg.com/sweetalert2@7.20.6/dist/sweetalert2.all.js"></script>

    <script src="../js/plugins/fullcalendar/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>


    <script type="text/javascript" src="../js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script type="text/javascript" src='../js/funciones/activos.js'></script>



@stop

