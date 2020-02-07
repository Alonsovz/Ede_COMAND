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

    <img src="../images/estadistica1.png"  alt="" style="margin-bottom: 50px">



        <table class=" table table-hover table-striped table-mail dataTables-example"  >
            <thead style="border: solid 1px black" id="header" class="hidden">
            <tr style="border: solid 1px black">
                <th>d</th>
                <th>d</th>
            </tr>
            </thead>
            <tbody>
            <tr style="background-color: lightgreen; border:solid 1px black"><td colspan="4" class="text-center"><strong>Graficos Estadisticos</strong></td></tr>

            <tr class="gradeU">

                <td style="border:solid 1px black">
                    Grafico de pastel - Permisos solicitados por las areas de EDESAL
                </td>

                <td style="border:solid 1px black" class="check-mail">
                    <button style="border: solid 1px black" data-target='#rangofechas' data-toggle='modal' type="button" id="" class="btn_verdetallepermiso btn btn-sm btn-white">
                        <i class="fa fa-eye"></i> <strong> Generar </strong>
                    </button>
                </td>

            </tr>
            <tr class="gradeU">

                <td style="border:solid 1px black">
                    Grafico de barra - Estadistico por empleado (conteo de permisos por mes)
                </td>

                <td style="border:solid 1px black" class="check-mail">
                    <button style="border: solid 1px black" data-target="#graficobarra1" data-toggle="modal"  type="button" id="" class=" btn btn-sm btn-white">
                        <i class="fa fa-eye"></i> <strong> Generar </strong>
                    </button>
                </td>
            </tr>
            <tr class="gradeU">

                <td style="border:solid 1px black">
                    Grafico de barra - Estadistico por empleado (conteo por categoria)
                </td>

                <td style="border:solid 1px black" class="check-mail">
                    <button style="border: solid 1px black" data-target="#graficoconteocategoria" data-toggle="modal"  type="button" id="" class=" btn btn-sm btn-white">
                        <i class="fa fa-eye"></i> <strong> Generar </strong>
                    </button>
                </td>
            </tr>
            <tr class="gradeU">

                <td style="border:solid 1px black">
                    Grafico de pastel - permisos solicitados por area
                </td>

                <td style="border:solid 1px black" class="check-mail">
                    <button style="border: solid 1px black" data-target="#graficobarra2" data-toggle="modal"  type="button" id="" class=" btn btn-sm btn-white">
                        <i class="fa fa-eye"></i> <strong> Generar </strong>
                    </button>
                </td>
            </tr>
            <tr style="background-color: lightskyblue; border:solid 1px black"><td colspan="4" class="text-center"><strong>Reportes</strong></td></tr>
            <tr>
                <td style="border:solid 1px black">
                    Permisos solicitados por todo el personal administrativo (Rango de fechas)
                </td>

                <td style="border:solid 1px black" class="check-mail">
                    <button style="border: solid 1px black" data-target="#rpt_detalle" data-toggle="modal"  type="button" id="" class=" btn btn-sm btn-white">
                        <i class="fa fa-eye"></i> <strong> Generar </strong>
                    </button>
                </td>
            </tr>
            <tr>
                <td style="border:solid 1px black">
                    Reporte por empleado de los permisos solicitados (Rango de fechas)
                </td>

                <td style="border:solid 1px black" class="check-mail">
                    <button style="border: solid 1px black" data-target="#rpt_detalleporempleado" data-toggle="modal"  type="button" id="" class=" btn btn-sm btn-white">
                        <i class="fa fa-eye"></i> <strong> Generar </strong>
                    </button>
                </td>
            </tr>

            </tbody>
            <tfoot id="footer" class="hidden">
            <tr>
                <th>Rendering engine</th>
                <th>Browser</th>
                <th>Platform(s)</th>

            </tr>
            </tfoot>
        </table>

    <div style="margin-top: 50px; border: solid 1px lightgrey; " id="iboxdetalles"  class="ibox hidden" >
        <div class="ibox-heading" style="padding: 5px">
            <h2><i class="fa fa-users"></i> Permisos Solicitados
                <button id="btn_generarexceldetalle" class="btn btn-lg btn-outline btn-default pull-right" style="border:solid 1px black;"><i class="fa fa-file-excel-o"></i> Exportar a excel</button>
                <button id="btn_generarpdfdetalle" class="btn btn-lg btn-outline btn-default pull-right" style="border:solid 1px black;"><i class="fa fa-file-pdf-o"></i> Exportar a PDF</button>
            </h2>
            <br><br>
        </div>
        <div class="ibox-content" id="detalles" style="overflow-x: scroll; width: 80em">

        </div>
    </div>

        <div  id="container" style="min-width: 400px; height: 400px; margin: 0 auto">

        </div>








    <!--MODAL PARA RANGO DE FECHAS-->
    <div class="modal inmodal fade" id="rangofechas" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small>Rango de fechas</small></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fechas *</label>
                        <input autocomplete="off" id="fecha" name="fecha" type="text" class="form-control" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_generar1" class="btn btn-primary btn-sm">Generar</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA REPORTE POR EMPLEADO DE LOS PERMISOS SOLICITADOS--}}
    <div class="modal inmodal fade" id="rpt_detalleporempleado" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small>Rango de fechas</small></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="the-basics">
                        <label>Empleado *</label>
                        <input autocomplete="off" id="empleadorpt" name="empleadorpt" type="text" class="typeahead form-control" >
                    </div>

                    <div class="form-group">
                        <label>Fechas *</label>
                        <input autocomplete="off" id="fecha_rptporempleado" name="fecha_rptporempleado" type="text" class="form-control" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_generarreporteporempleado" data-dismiss="modal" class="btn btn-primary btn-sm">Generar</button>
                </div>
            </div>
        </div>
    </div>

    {{--reporte detalle de los permisos solicitados--}}
    <div class="modal inmodal fade" id="rpt_detalle" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small>Rango de fechas</small></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fechas *</label>
                        <input autocomplete="off" id="fecha_detalle" name="fecha_detalle" type="text" class="form-control" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_generardetalle" data-dismiss="modal" class="btn btn-primary btn-sm">Generar</button>
                </div>
            </div>
        </div>
    </div>



    <!--MODAL PARA RANGO DE FECHAS Y SELECCIONAR EMPLEADO-->
    <div class="modal inmodal fade" id="graficobarra1" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small>Parametros</small></h4>
                </div>
                <div class="modal-body">

                    <div class="form-group" id="the-basics">
                        <label>Empleado *</label>
                        <input autocomplete="off" id="empleado" name="empleado" type="text" class="typeahead form-control" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar2" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_generar2" class="btn btn-primary btn-sm">Generar</button>
                </div>
            </div>
        </div>
    </div>



    {{--MODAL PARA PARAMETROS DE GRAFICO DE CONTEO POR CATEGORIA DE LOS PERMISOS SOLICITADOS--}}
    <div class="modal inmodal fade" id="graficoconteocategoria" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small>Rango de fechas</small></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fechas *</label>
                        <input autocomplete="off" id="fecha_conteo_categoria" name="fecha_conteo_categoria" type="text" class="form-control" >
                    </div>

                    <div class="form-group" id="the-basics">
                        <label>Empleado *</label>
                        <input autocomplete="off" id="empleado_conteo_categoria" name="empleado_conteo_categoria" type="text" class="form-control typeahead" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar1" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_generar_conteo_categoria" data-dismiss="modal" class="btn btn-primary btn-sm">Generar</button>
                </div>
            </div>
        </div>
    </div>


    <!--MODAL PARA GRAFICO MENSUAL POR AREA-->
    <div class="modal inmodal fade" id="graficobarra2" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><small>Parametros</small></h4>
                </div>
                <div class="modal-body">

                    <div class="form-group" id="the-basics1">
                        <label>Departamento *</label>
                        <input autocomplete="off" id="departamento" name="departamento" type="text" class="typeahead form-control" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white btn-sm" id="cerrar3" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn_generar3" class="btn btn-primary btn-sm">Generar</button>
                </div>
            </div>
        </div>
    </div>


















@stop



@section('scripts')

    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>


    <script type="text/javascript" src="../js/funciones/estadisticas.js"></script>
    <script type="text/javascript" src="../js/plugins/moment/moment.js"></script>
    <script type="text/javascript" src="../js/daterangepicker.js"></script>


    <!--funciones para graficos-->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>

    <!--funciones para autocomplete-->
    <script src="../js/plugins/typeahead/typeahead.js"></script>
@stop