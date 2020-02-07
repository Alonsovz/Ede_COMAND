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
    <b>Requisiciones</b>
@stop

@section('contenido')
    <div class="row" id="divbandeja">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content"  >
                    <div class="file-manager">
                        <a href='nuevarequisicion' class="btn btn-block btn-primary compose-mail" href="">Nueva requisicion</a>

                        <div class="space-25"></div>
                        <h5></h5>
                        <ul class="folder-list m-b-md" style="padding: 0">
                            <li><a href=""> <i class="fa fa-inbox "></i>Requisiciones <span class="label label-warning pull-right"></span> </a></li>
                        </ul>
                        <h5></h5>
                        <ul class="category-list" style="padding: 0">
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>


        <!--DATATABLE PARA PERMISOS-->
        <div class="col-lg-12 animated fadeInRight" style="" >
            <div class="mail-box-header">
                <h2>
                    Requisiciones
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">


                </div>
            </div>
            <div class="mail-box" style="padding: 5px; ">

                <table style="color: black; border: solid black 0.5px;" class="dataTables-example1 table-responsive table-bordered table table-hover table-mail dataTables-example" >
                    <thead id="header" class="">
                    <tr>
                        <th style="color: grey; border: solid grey 0.5px;" class="text-center">N° de Req</th>
                        <th style="color: grey; border: solid grey 0.5px;" class="text-center">Estado Req.</th>
                        <th style="color: grey; border: solid grey 0.5px;" class="text-center">Justificacion</th>
                        <th style="color: grey; border: solid grey 0.5px;" class="text-center">Fecha Sol.</th>
                        <th style="color: grey; border: solid grey 0.5px;" class="text-center">Accion</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requisiciones as $requisicion)
                        @if($requisicion->estado!='Cancelada')
                        <tr class="gradeU">

                            <td style="width: 50px; border: solid black 0.3px"><b>{{$requisicion->id}}</b></td>

                            @if($requisicion->estado=='Recibida')
                                <td  style="width: 30px; border: solid black 0.3px" class=" text-center">
                                    <span class="label label-info bg-info pull-right">Nueva requisicion</span>

                                </td>
                            @elseif($requisicion->estado=='Aprobada')
                                <td  style="width: 30px; border: solid black 0.3px" class=" text-center">
                                    <span class="label label-success bg-success pull-right">Requisicion aprobada</span>
                                </td>
                            @elseif($requisicion->estado=='Denegada')
                                <td  style="width: 30px; border: solid black 0.3px" class=" text-center">
                                    <span class="label label-danger bg-danger pull-right">Requisicion denegada</span>
                                </td>
                            @endif
                            <td  style="width: 50px; border: solid black 0.3px" class="center text-default">{{$requisicion->justificacion}}</td>
                            <td class="center" style="width: 30px; border: solid black 0.3px">
                                <small>
                                    <i class="fa fa-calendar"></i>
                                    <?php
                                    $fecha = date_create($requisicion->fechasolicitud);
                                    echo date_format($fecha,'d/m/Y');
                                    ?>
                                </small>
                            </td>
                            <td  style="width: 50px; border: solid black 0.3px" class="check-mail">
                                @if($requisicion->estado=='Recibida')
                                    <button id="{{$requisicion->id}}" type="button" class="btn btn-xs btn-danger btn_eliminarrequisicion">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                @endif
                                <a href="verdetallesrequisicionsuperv?idrequisicion={{$requisicion->id}}"
                                   id="{{$requisicion->id}}" class=" btn btn-xs btn-warning btn_detallesrequisicion">
                                    <i class="fa fa-eye"></i> Ver detalles
                                </a>

                            </td>
                        </tr>
                    @endif
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






    <div class="row hidden" id="divdetalles">

    </div>


@stop


@section('scripts')

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

    <script src="../js/funciones/requisiciones.js"></script>



@stop