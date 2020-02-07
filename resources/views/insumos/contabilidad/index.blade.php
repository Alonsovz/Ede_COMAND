{{--vista para supervisar las herramientas en las bodegas--}}
@extends('layouts.template')

@section('css')

    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/datapicker/datepicker3.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.css">

    <style>
        body{
            color: black;
        }
    </style>

@stop

@section('enunciado')
    Insumos
@stop

@section('modulo')
    Insumos
@stop

@section('submodulo')
    <b>Bajas de activos</b>
@stop

@section('contenido')

    <div class="row" style="margin-top: 50px" id="registrosalida">
        <div class="ibox">

            <div class="ibox-title">
                <h1><i class="fa fa-download"></i> Bajas de activos</h1>
            </div>




            <div class="ibox-content">
                <table class="dataTables-example1 table table-hover table-mail dataTables-example tablabajas" id="" style="color: black;">
                    <thead id="header" class="">
                    <tr style="background-color: lightgrey;">
                        <th class="text-center" style="border:  solid black 1px;">Cod. VNR</th>
                        <th class="text-center" style="border:  solid black 1px;">Cod. COMANDA</th>
                        <th class="text-center" style="border:  solid black 1px;">Cuenta contable</th>
                        <th class="text-center" style="border:  solid black 1px;">Activo</th>
                        <th class="text-center" style="border:  solid black 1px;">Usuario asignado</th>
                        <th class="text-center" style="border:  solid black 1px;">Bodega</th>
                        <th class="text-center" style="border:  solid black 1px;">Accion</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($detalles as $detalle)
                            <tr>
                                <td style="border:solid 1px black" class="text-center">{{$detalle->codigo_vnr}}</td>
                                <td style="border:solid 1px black" class="text-center">{{$detalle->codigo_comanda}}</td>
                                <td style="border:solid 1px black" class="text-center">{{$detalle->cuenta_contable}}</td>
                                <td class="text-center" style="border:solid 1px black">{{$detalle->tipo_activo}}</td>
                                <td style="border:solid 1px black" class="text-center">{{$detalle->nombre}} {{$detalle->apellido}}</td>
                                <td style="border:solid 1px black" class="text-center">{{$detalle->bodega}}</td>
                                <td  style="border:solid 1px black" class="text-center"><button class="btn btn-danger btn-xs finbaja" id="{{$detalle->idbaja}}"><i class="fa fa-download"></i> Finalizar baja</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot id="footer" class="hidden">
                    <tr>
                        <th>Codigo</th>
                        <th>Insumo</th>
                        <th>Sin asignar</th>
                        <th>Acccion</th>
                    </tr>
                    </tfoot>
                </table>

            </div>




@stop

@section('scripts')

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/localization/messages_es.js"></script>

            <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
            <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
            <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
            <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>

            <!--funciones para datatables-->
            <script src="../js/plugins/dataTables/datatables.min.js"></script>

            <!--funciones para el lenguaje de las datatables-->
            <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>

            <!-- funciones para los mensajes de alerta -->
            <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

            <!-- funciones para calendario -->
            <script type="text/javascript" src='../js/plugins/datapicker/bootstrap-datepicker.js'></script>
            <!-- funciones para registrar los tiempos de los permisos por medio de la libreria clockpicker-->
            <script type="text/javascript" src='../js/plugins/clockpicker/clockpicker.js'></script>

            <script type="text/javascript" src="../js/funciones/clockanddate.js"></script>

            <script type="text/javascript" src="../js/funciones/insumos_movimientos.js"></script>



@stop








