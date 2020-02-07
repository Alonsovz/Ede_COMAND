@extends('layouts.template')

@section('css')

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet" href="../css/plugins/typeahead/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">



@stop

@section('enunciado')
    Insumos
@stop

@section('modulo')
    Reportes
@stop

@section('submodulo')
    <b>Index</b>
@stop

@section('contenido')

    <style>
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }
    </style>

    <div class="dropdown">
        <button class="btn btn-info btn-outline btn-lg hidden" id="btn_nuevoreporte" type="button" onclick="location.reload()" data-toggle="">
            <i class="fa fa-plus"></i> Nuevo Reporte
        </button>
        <button class="btn btn-primary btn-outline btn-lg dropdown-toggle" id="reportesinsumos" type="button" data-toggle="dropdown">Reportes de insumos
            <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li class="dropdown-submenu">
                <a class="test" tabindex="-1" href="#">Papeleria <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a tabindex="-1" data-toggle="modal" data-target="#rangofechas" id="papeleria">Movimientos</a></li>
                    {{--<li><a tabindex="-1" href="#">Disponibilidad</a></li>--}}
                    <li><a tabindex="-1" href="#">Costos por CC</a></li>

                </ul>
            </li>
            <li class="dropdown-submenu">
                <a class="test" tabindex="-1" href="#">Herramientas <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a tabindex="-1" data-target="#modaldispoherram" data-toggle="modal">Disponibilidad</a></li>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a class="test" tabindex="-1" href="#">Limpieza <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a tabindex="-1" data-toggle="modal" data-target="#rangofechas1" id="limpieza">Movimientos</a></li>
                    {{--<li><a tabindex="-1" href="#">Disponibilidad</a></li>--}}
                    <li><a tabindex="-1" data-toggle="modal" data-target="#rangofechas2" href="#">Costos por CC</a></li>
                </ul>
            </li>

            <li class="dropdown-submenu">
                <a class="test" tabindex="-1" href="#">Activos <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a tabindex="-1" data-toggle="modal" data-target="#bodegaba" id="">Bajas</a></li>
                    <li><a tabindex="-1" data-toggle="modal" data-target="#cambiosestados" id="">Cambios de estado</a></li>

                </ul>
            </li>
            <li class="dropdown-submenu">
                <a class="test" tabindex="-1" href="#">Consumos <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a tabindex="-1" data-toggle="modal" data-target="#consumosmodal" id="">Asignaciones por empleado</a></li>
                    <li><a tabindex="-1" data-toggle="modal" data-target="#consumosmodal1" id="">Asignaciones por cc</a></li>

                </ul>
            </li>

        </ul>
    </div>

{{--REPORTE DE PAPELERIA DE DISPONIBILIDAD--}}
    <div class="row" style="margin-top: 30px">
        <div class="col-lg-12 animated fadeInRight hidden" id="renderdispopape" >
            <div class="mail-box-header">
                <h2>
                    Movimientos de Insumos de Papeleria
                    <span id="btn_generarexcelmovpape" style="margin-left: 850px" class=" btn btn-warning btn-sm"><i class="fa fa-file-excel-o"></i> Generar excel</span>
                    <span id="btn_generarpdfmovpape" style="margin-left: 5px" class="pull-right btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Generar pdf</span>
                </h2>

                <div class="mail-tools tooltip-demo m-t-md">
                </div>
            </div>
            <div class="mail-box" style="padding: 5px;" id="rendertable1">


            </div>
        </div>
    </div>


    {{--RENDER PARA BAJAS DE ACTIVO--}}
    <div class="row" style="margin-top: 30px">
        <div class="col-lg-12 animated fadeInRight hidden" id="renderbajas" >
            <div class="mail-box-header">
                <h2>
                    Bajas de activos
                    {{--<span id="btn_generar1_excel" style="margin-left: 775px" class=" btn btn-warning btn-sm"><i class="fa fa-file-excel-o"></i> Generar excel</span>--}}
                    <span id="btn_generarpdfmovpape" style="margin-left: 5px" class="pull-right btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Generar pdf</span>
                </h2>

                <div class="mail-tools tooltip-demo m-t-md">
                </div>
            </div>
            <div class="mail-box" style="padding: 5px;" id="rendertablabajas">


            </div>
        </div>
    </div>


    {{--REPORTE DE LIMPIEZA MOVIMIENTOS--}}
    <div class="row" style="margin-top: 30px">
        <div class="col-lg-12 animated fadeInRight hidden" id="renderdispolimpieza" >
            <div class="mail-box-header">
                <h2>
                    Movimientos de Insumos de Limpieza
                    {{--<span id="btn_generar1_excel" style="margin-left: 775px" class=" btn btn-warning btn-sm"><i class="fa fa-file-excel-o"></i> Generar excel</span>--}}
                    <span id="btn_generarpdfmovlimpieza" style="margin-left: 5px" class="pull-right btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Generar pdf</span>
                </h2>

                <div class="mail-tools tooltip-demo m-t-md">
                </div>
            </div>
            <div class="mail-box" style="padding: 5px;" id="rendertable2">


            </div>
        </div>
    </div>


    {{--REPORTE PARA LOS CAMBIOS DE ESTADOS DE LAS HERRAMIENTAS--}}
    <div class="row" style="margin-top: 30px">
        <div class="col-lg-12 animated fadeInRight hidden" id="renderestadosherram" >
            <div class="mail-box-header">
                <h2>
                    Cambios de estados de herramientas
                    {{--<span id="btn_generar1_excel" style="margin-left: 775px" class=" btn btn-warning btn-sm"><i class="fa fa-file-excel-o"></i> Generar excel</span>--}}
                    <button id="btn_generarexcelestadosherram" style="margin-left: 5px; border:solid 1px black" class="pull-right btn btn-default btn-md" st><i class="fa fa-file-excel-o"></i> Generar Excel</button>
                </h2>

                <div class="mail-tools tooltip-demo m-t-md">
                </div>
            </div>
            <div class="mail-box" style="padding: 5px;" id="viewestadosherram">


            </div>
        </div>
    </div>

    {{--REPORTE DE CONSUMOS--}}
    <div class="row" style="margin-top: 30px">
        <div class="col-lg-12 animated fadeInRight hidden" id="renderdivconsumos" >
            <div class="mail-box-header">
                <h2>
                    Consumo de insumos
                    {{--<span id="btn_generar1_excel" style="margin-left: 775px" class=" btn btn-warning btn-sm"><i class="fa fa-file-excel-o"></i> Generar excel</span>--}}
                    <span id="btn_generarpdfmovlimpieza" style="margin-left: 5px" class="pull-right btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Generar pdf</span>
                </h2>

                <div class="mail-tools tooltip-demo m-t-md">
                </div>
            </div>
            <div class="mail-box" style="padding: 5px;" id="div_tabla_detalles">


            </div>
        </div>
    </div>


    {{--REPORTE DE CONSUMOS HISTORICOS DE PAPELERIA LISTADO POR LOS CC--}}
    <div class="row" style="margin-top: 30px">
        <div class="col-lg-12 animated fadeInRight hidden" id="renderdivconsumoscc" >
            <div class="mail-box-header">
                <h2>
                    Consumo de insumos
                    {{--<span id="btn_generar1_excel" style="margin-left: 775px" class=" btn btn-warning btn-sm"><i class="fa fa-file-excel-o"></i> Generar excel</span>--}}
                    <span id="btn_generarexcelconsumoshistoricos" style="margin-left: 5px; border:solid 1px black" class="pull-right btn btn-info"><i class="fa fa-file-excel-o"></i> Generar excel</span>
                </h2>

                <div class="mail-tools tooltip-demo m-t-md">
                </div>
            </div>
            <div class="mail-box" style="padding: 5px;" id="div_tabla_detallescc">


            </div>
        </div>
    </div>


    {{--REPORTE DE LIMPIEZA COSTOS--}}
    <div class="row" style="margin-top: 30px">
        <div class="col-lg-12 animated fadeInRight hidden" id="renderdispolimpiezacostos" >
            <div class="mail-box-header">
                <h2>
                    Revisión de Costos para Insumos de Papeleria
                    {{--<span id="btn_generar1_excel" style="margin-left: 800px" class=" btn btn-warning btn-sm"><i class="fa fa-file-excel-o"></i> Generar excel</span>--}}
                    <span id="btn_generarpdfmovlimpiezacostos" style="margin-left: 5px" class="pull-right btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Generar pdf</span>
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                </div>
            </div>
            <div class="mail-box" style="padding: 5px;" id="rendertable4">

            </div>
        </div>
    </div>


    {{--REPORTE DE COSTOS PAPELERIA--}}



    {{--REPORTE DE DISPONIBILIDAD DE HERRAMIENTAS--}}
    <div class="row" style="margin-top: 30px">
        <div class="col-lg-12 animated fadeInRight hidden" id="renderdispoherram" >
            <div class="mail-box-header">
                <h2>
                    Disponibilidad de Herramientas

                    <span id="btn_generarpdfdispoherram" style="margin-left: 5px" class="pull-right btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Generar pdf</span>
                </h2>

                <div class="mail-tools tooltip-demo m-t-md">
                </div>
            </div>
            <div class="mail-box" style="padding: 5px;" id="renderdispoherram">


            </div>
        </div>
    </div>


    {{--MODAL DE PAPELERIA DE MOVIMIENTOS--}}
    <div class="modal inmodal fade" id="rangofechas" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small><i class="fa fa-file"></i> Parametros de reporte</small></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fechas *</label>
                        <input autocomplete="off" id="fecha" name="fecha" type="text" class="form-control" >
                    </div>

                    <div class="form-group">
                        <label>Centro de costos *</label>
                        <select name="" id="centrocosto" class="form-control">
                            <option value="">seleccione...</option>
                            @foreach($centrocostos as $cc)
                                <option value="{{$cc->id}}">{{$cc->nombre}}</option>
                                @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_movimientoPapeleria" class="btn btn-primary btn-sm" data-dismiss="modal">Generar</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL DE LIMPIEZA DE MOVIMIENTOS--}}
    <div class="modal inmodal fade" id="rangofechas1" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small><i class="fa fa-file"></i> Parametros de reporte</small></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fechas *</label>
                        <input autocomplete="off" id="fecha1" name="fecha" type="text" class="form-control" >
                    </div>

                    <div class="form-group">
                        <label>Centro de costos *</label>
                        <select name="" id="centrocostolimpieza" class="form-control">
                            <option value="">seleccione...</option>
                            @foreach($centrocostos as $cc)
                                <option value="{{$cc->id}}">{{$cc->nombre}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_movimientoLimpieza" class="btn btn-primary btn-sm" data-dismiss="modal">Generar</button>
                </div>
            </div>
        </div>
    </div>

    {{--MODAL DE LIMPIEZA COSTOS POR CC--}}
    <div class="modal inmodal fade" id="rangofechas2" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small><i class="fa fa-file"></i> Parametros de reporte</small></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fechas *</label>
                        <input autocomplete="off" id="fecha2" name="fecha" type="text" class="form-control" >
                    </div>

                    <div class="form-group">
                        <label>Centro de costos *</label>
                        <select name="" id="centrocostolimpieza1" class="form-control">
                            <option value="">seleccione...</option>
                            @foreach($centrocostos as $cc)
                                <option value="{{$cc->id}}">{{$cc->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_costoslimpieza" class="btn btn-primary btn-sm" data-dismiss="modal">Generar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal inmodal fade" id="modaldispoherram" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small><i class="fa fa-file"></i> Parametros de reporte</small></h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Bodegas *</label>
                        <select name="" id="bodega" class="form-control">
                            <option value="">seleccione...</option>
                            @foreach($bodegas as $b)
                                <option value="{{$b->id}}">{{$b->codigo}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_dispoherram" class="btn btn-primary btn-sm" data-dismiss="modal">Generar</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA EL REPORTE DE BAJAS DE ACTIVO--}}
    <div class="modal inmodal fade" id="bodegaba" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small><i class="fa fa-file"></i> Parametros de reporte</small></h4>
                </div>
                <div class="modal-body">


                    <div class="form-group">
                        <label>Bodegas *</label>
                        <select name="" id="bodegaBA" class="form-control">
                            <option value="">seleccione...</option>
                            @foreach($bodegas as $b)
                                <option value="{{$b->id}}">{{$b->codigo}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="bajasactivo" class="btn btn-primary btn-sm" data-dismiss="modal">Generar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal inmodal fade" id="cambiosestados" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small><i class="fa fa-file"></i> Parametros de reporte</small></h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Fechas *</label>
                        <input autocomplete="off" id="fecha_Estados" name="fecha_Estados" type="text" class="form-control" >
                    </div>

                    <div class="form-group">
                        <label>Bodegas *</label>
                        <select name="" id="bodegaEstados" class="form-control">
                            <option value=""></option>
                            @foreach($bodegas as $b)
                                <option value="{{$b->id}}">{{$b->codigo}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="estadosherramientas" class="btn btn-primary btn-sm" data-dismiss="modal">Generar</button>
                </div>
            </div>
        </div>
    </div>


    {{--CONSUMOS MODAL--}}
    <div class="modal inmodal fade" id="consumosmodal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small><i class="fa fa-file"></i> Parametros de reporte</small></h4>
                </div>
                <div class="modal-body">


                    <div class="form-group">
                        <label>Centros de costos:</label>
                        <select name="" id="ccconsumo" class="form-control">
                            <option value="">seleccione...</option>
                            @foreach($centrocostos as $c)
                                <option value="{{$c->id}}">{{$c->nombre}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Fechas:</label>
                        <input autocomplete="off" id="fechaconsumos" name="fechaconsumos" type="text" class="form-control" >
                    </div>

                    <div class="form-group" id="the-basics">
                        <label>Insumo:</label>
                        <input autocomplete="off" id="insumoconsumo" name="insumo" type="text" class="form-control typeahead" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_verconsumos" class="btn btn-primary btn-sm" data-dismiss="modal">Ver consumos</button>
                </div>
            </div>
        </div>
    </div>




    {{--CONSUMOS DE INSUMOS CON LA COLUMNA DE CENTRO DE COSTOS PARA CADA EMPLEADO--}}
    <div class="modal inmodal fade" id="consumosmodal1" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small><i class="fa fa-file"></i> Parametros de reporte</small></h4>
                </div>
                <div class="modal-body">




                    <div class="form-group">
                        <label>Fechas:</label>
                        <input autocomplete="off" id="fechaconsumoscc" name="fechaconsumoscc" type="text" class="form-control" >
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_verconsumoswithcc" class="btn btn-primary btn-sm" data-dismiss="modal">Ver consumos</button>
                </div>
            </div>
        </div>
    </div>




@stop


@section('scripts')



    <script type="text/javascript" src="../js/plugins/moment/moment.js"></script>
    <script type="text/javascript" src="../js/daterangepicker.js"></script>
    <script src="../js/plugins/typeahead/typeahead.js"></script>
    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script src="../js/funciones/reportes_insumos.js"></script>
@stop