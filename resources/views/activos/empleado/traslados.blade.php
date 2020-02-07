@extends('layouts.template')

@section('css')

    <link rel="stylesheet" href="../css/plugins/sweetalert/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.css">

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
    <b>Traslados</b>
@stop

@section('contenido')






        {{--TABS PANEL PARA LAS DOS BANDEJAS DE ENVIADOS Y RECIBIDOS--}}

            <h1><i class="fa fa-paper-plane"></i> Traslados</h1>
            <br><br>
            <div class="row" id="">
            <div class="panel blank-panel" style="color: black">
                <div class="panel-heading">
                    <div class="panel-options">
                        <ul class="nav nav-tabs">
                            <li style="color: black" class=""><a style="color: black; font-size: 14px" href="#tab-1" data-toggle="tab" ><i class="fa fa-dropbox"></i> Bandeja Enviados</a></li>
                            <li style="color: black" class=""><a style="color: black; font-size: 14px" href="#tab-2" data-toggle="tab" ><i class="fa fa-dropbox"></i> Bandeja Recibidos</a></li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="tab-content">
                        <div class="tab-pane" id="tab-1">
                            <table id="tbl_activos" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 20px; font-size: 12px" >
                                <thead id="header" class="">
                                <tr style="background-color: lightgrey">
                                    <th class="text-center" style="border: solid 1px grey;">Activo</th>
                                    <th class="text-center" style="border: solid 1px grey;">Color</th>
                                    <th class="text-center" style="border: solid 1px grey;">Marca</th>
                                    <th class="text-center" style="border: solid 1px grey;">Modelo</th>
                                    <th class="text-center" style="border: solid 1px grey;">CC Destino</th>
                                    <th class="text-center" style="border: solid 1px grey;">Nuevo reponsable</th>
                                    <th class="text-center" style="border: solid 1px grey;">Estado</th>
                                    <th class="text-center" style="border: solid 1px grey;">Opciones</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($traslados as $a)
                                    <tr style="">
                                        <td style="border: solid 1px grey; "><b>{{$a->tipo_activo}}</b></td>
                                        <td class="text-center" style="border: solid 1px grey; ">{{$a->color}}</td>
                                        <td class="text-center" style="border: solid 1px grey;">{{$a->marca}}</td>
                                        <td class="text-center" style="border: solid 1px grey;">{{$a->modelo}}</td>
                                        <td class="text-center" style="border: solid 1px grey;">{{$a->centrocosto}}</td>
                                        <td class="text-center" style="border: solid 1px grey;">{{$a->nombredestino}} {{$a->apellidodestino}}</td>
                                        <td class="text-center" style="border: solid 1px grey;">{{$a->estado}}</td>
                                        <td style="border: solid 1px black;" class="text-center">
                                            @if($a->estado_traslado==1 || $a->estado_traslado==2)
                                                <button id="{{$a->id}}" data-toggle="modal" data-target="" class="btn btn-default btn-md traslado" style="border:solid 1px black; margin-left: 5px" type="button"><i class="fa fa-close"></i> Cancelar traslado</button>
                                            @endif
                                            {{--si el estado del traslado esta aceptado el boton de imprimir se muestra de lo contrario se olculta esperando respuesta--}}
                                            @if($a->estado_traslado==2)
                                                <a href="pdf_activotraslado?id={{$a->id}}" id="{{$a->id}}"  class="btn btn-default btn-md " style="border:solid 1px black; margin-left: 5px" ><i class="fa fa-print"></i> Imprimir hoja</a>
                                            @endif
                                        </td>

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
                        <div class="tab-pane " id="tab-2">
                            <table id="tbl_activos" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 20px; font-size: 12px" >
                                <thead id="header" class="">
                                <tr style="background-color: lightgrey">
                                    <th class="text-center" style="border: solid 1px grey;">Activo</th>
                                    <th class="text-center" style="border: solid 1px grey;">Color</th>
                                    <th class="text-center" style="border: solid 1px grey;">Marca</th>
                                    <th class="text-center" style="border: solid 1px grey;">Modelo</th>
                                    <th class="text-center" style="border: solid 1px grey;">Reponsable anterior</th>
                                    <th class="text-center" style="border: solid 1px grey;">Opciones</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($trasladosreceptor as $a)
                                    <tr style="">
                                        <td style="border: solid 1px grey; "><b>{{$a->tipo_activo}}</b></td>
                                        <td class="text-center" style="border: solid 1px grey; "><b>{{$a->color}}</b></td>
                                        <td class="text-center" style="border: solid 1px grey;">{{$a->marca}}</td>
                                        <td class="text-center" style="border: solid 1px grey;"><b>{{$a->modelo}}</td>
                                        <td class="text-center" style="border: solid 1px grey;"><b>{{$a->nombreemisor}} {{$a->apellidoemisor}}</td>
                                        <td style="border: solid 1px black;" class="text-center">
                                            @if($a->estado_traslado==1)
                                                <button id="{{$a->id}}" data-toggle="modal" data-target="" class="btn btn-default btn-md traslado" style="border:solid 1px black; margin-left: 5px" type="button"><i class="fa fa-close"></i> Cancelar traslado</button>
                                             @endif
                                            {{--si el estado del traslado esta aceptado el boton de imprimir se muestra de lo contrario se olculta esperando respuesta--}}
                                            @if($a->estado_traslado==1)
                                                <button id="{{$a->id}}"  class="btn btn-default btn-md aceptartraslado" style="border:solid 1px black; margin-left: 5px" type="button"><i class="fa fa-print"></i> Aceptar Traslado</button>
                                            @endif
                                                @if($a->estado_traslado==2)
                                                    <a href="pdf_activotraslado?id={{$a->id}}" id="{{$a->id}}"  class="btn btn-default btn-md " style="border:solid 1px black; margin-left: 5px" ><i class="fa fa-print"></i> Imprimir hoja</a>
                                                @endif
                                        </td>

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
        </div>








@stop


@section('scripts')
    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>

    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>
    <script src="https://unpkg.com/sweetalert2@7.20.6/dist/sweetalert2.all.js"></script>

    <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>

    <script src="../js/plugins/fullcalendar/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script type="text/javascript" src="../js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/localization/messages_es.js"></script>

    <script type="text/javascript" src='../js/funciones/activos.js'></script>









@stop

