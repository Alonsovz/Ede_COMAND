@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet" href="../css/plugins/typeahead/typeahead.css">
@stop

@section('enunciado')
    RRHH
@stop

@section('modulo')
    RRHH
@stop

@section('submodulo')
    <b>Estadisticas</b>
@stop

@section('contenido')
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-heading">
                <div class="ibox-title" style="height: 120px; border:solid 1px lightgrey">
                    <h1><i class="fa fa-bar-chart-o"></i> Estadisticas de RRHH</h1>
                    <div class="btn-group ">
                        <button data-toggle="dropdown" class="btn btn-success btn-outline btn-md dropdown-toggle"><i class="fa fa-ticket"></i> Reportes <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" id="rpt_cantidadpermisosempleado" >Cantidad permisos (Empleado)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="ibox-content" style="border:solid 1px lightgrey">

                <form class="form-horizontal ocultar hidden" id="frm_reporte1">
                    <h4><i class="fa fa-file-text-o"></i> Parametros</h4>
                    <div class="form-group"><label class="col-lg-2 control-label">Empleado:</label>

                        <div class="col-lg-5" id="the-basics">
                            <input id="empleado" name="" type="text" class="form-control typeahead ">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-lg-2 control-label">Fecha:</label>

                        <div class="col-lg-4" id="">
                            <input id="parametros1" name="parametros1" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label"></label>
                        <div class="col-lg-8" id="">
                            <button type="button" id="btn_generarreporteporempleado" class="btn btn-primary"><i class="fa fa-download"></i> Generar</button>
                            <button type="button" class="btn btn-default cancelarparametrizacion"><i class="fa fa-close"></i> Cancelar</button>
                        </div>
                    </div>

                </form>
            </div>
            <div id="reporte1" class="ibox-footer" style="border:solid 1px lightgrey">

            </div>
        </div>
    </div>
@stop



@section('scripts')

    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>


    <script type="text/javascript" src="../js/funciones/reportesRRHH.js"></script>
    <script type="text/javascript" src="../js/plugins/moment/moment.js"></script>
    <script type="text/javascript" src="../js/daterangepicker.js"></script>


    <!--funciones para graficos-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>

    <!--funciones para autocomplete-->
    <script src="../js/plugins/typeahead/typeahead.js"></script>
@stop