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

        <div class="ibox" style="height: 600px; border:solid 1px lightgrey">
            <div class="ibox-heading">
                <div class="ibox-title" style="height: 120px; border:solid 1px lightgrey">
                    <h1><i class="fa fa-bar-chart-o"></i> Cantidad de permisos solicitados por empleado</h1>
                    <button data-toggle="dropdown" class="btn btn-danger btn-outline"><i class="fa fa-arrow-left"></i> Nuevo grafico</button>
                </div>
            </div>
            <div class="ibox-content" id="iboxcontenido" >


            </div>
        </div>

@stop



@section('scripts')



    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>


    <script type="text/javascript" src="../js/funciones/reportesRRHH.js"></script>
    <script type="text/javascript" src="../js/plugins/moment/moment.js"></script>
    <script type="text/javascript" src="../js/daterangepicker.js"></script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["columnchart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Enfermedad', 'Consulta Medica','Accidente Laboral','Requerimiento Judicial','Matrimonio','Maternindad/Paternidad','Vacaciones','Otro','Tiempo Libre Remunerado','Tiempo Libre No Remunerado','Defunsion','Tiempo Compensado'],
                    @foreach($detalles as $detalle)
                [{{$detalle->Enfermedad}},
                    {{$detalle->Consulta_medica}},
                    {{$detalle->Accidente_laboral}},
                    {{$detalle->Requerimiento_judicial}},
                    {{$detalle->Matrimonio}},
                    {{$detalle->Maternidad_Paternidad}},
                    {{$detalle->Vacaciones}},
                    {{$detalle->Otro}},
                    {{$detalle->Tiempo_libre_remunerado}},
                    {{$detalle->Tiempo_libre_no_remunerado}},
                    {{$detalle->Defunsion}},
                    {{$detalle->Tiempo_compensado}}
                ],
                @endforeach
            ]);

            var chart = new google.visualization.ColumnChart(document.getElementById('iboxcontenido'));
            chart.draw(data, {width: 900, height: 400, title: 'Cantidad de permisos solicitados'});
        }
    </script>

    <!--funciones para autocomplete-->
    <script src="../js/plugins/typeahead/typeahead.js"></script>
@stop