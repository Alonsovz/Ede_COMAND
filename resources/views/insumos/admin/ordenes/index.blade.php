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
    <b>Ordenes</b>
@stop

@section('contenido')
    <div class="row" id="divbandeja">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <a class="btn btn-block btn-primary compose-mail" href=""><i class="fa fa-refresh"></i> Actualizar</a>
                        <div class="space-25"></div>
                        <h5></h5>
                        <ul class="folder-list m-b-md" style="padding: 0">
                            <li><a href=""> <i class="fa fa-inbox "></i>Ordenes <span class="label label-warning pull-right"></span> </a></li>



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
        <div class="col-lg-12 animated fadeInRight" >
            <div class="mail-box-header">
                <h2>
                    Ordenes de compras
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">


                </div>
            </div>
            <div class="mail-box" style="padding: 5px;">

                <table style="color:black" class="dataTables-example1 table table-bordered  table-hover table-mail dataTables-example" >
                    <thead id="header" class="" style="background-color: lightgrey">
                    <tr>
                        <th style="border:solid black 0.5px">No OC</th>
                        <th style="border:solid black 0.5px">Estado</th>
                        <th style="border:solid black 0.5px">No Requ.</th>
                        <th style="border:solid black 0.5px">Tipo de req</th>
                        <th style="border:solid black 0.5px">Solicitante</th>
                        <th style="border:solid black 0.5px">Proveedor</th>
                        <th style="border:solid black 0.5px">Fecha entrega</th>
                        <th style="border:solid black 0.5px">Acccion</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ordenes as $orden)

                            <tr class="gradeU">
                                <td style="border:solid black 0.5px"><i class="fa fa-shopping-cart"></i> <b>{{$orden->idordencompra}}</b></td>
                                @if($orden->estado=='Aprobado')
                                    <td style="border:solid black 0.5px"><span class="label label-info bg-info pull-center">Aprobada</span></td>
                               @elseif($orden->estado=='En progreso')
                                    <td style="border:solid black 0.5px"><span class="label label-warning bg-warning pull-center">En progreso</span></td>
                                @elseif($orden->estado=='Cerrado')
                                    <td style="border:solid black 0.5px"><span class="label label-danger bg-danger pull-center">Cerrada</span></td>
                                @elseif($orden->estado=='Abierto')
                                    <td style="border:solid black 0.5px"><span class="label label-default bg-default pull-center">Re-aperturada</span></td>
                                @endif
                                    <td style="border:solid black 0.5px; background-color: lightblue" class="center text-default"><i class="fa fa-file-text-o"></i> <span class="">{{$orden->requisicion_id}}</span></td>
                                    <td style="border:solid black 0.5px; background-color: lightblue" class="center text-default"><i class="fa fa-file-text-o"></i> <span class="">{{$orden->tiporeq}}</span></td>
                                    <td style="border:solid black 0.5px; background-color: lightblue" class="center text-default"><i class="fa fa-file-text-o"></i> <span class="">{{$orden->nombresolicitante}} {{$orden->apellidosolicitante}} </span></td>
                                <td style="border:solid black 0.5px" class="mail-ontact">
                                 <b>{{$orden->proveedor}}</b>
                                </td>
                                    <td class="center" style="border:solid black 0.5px">

                                            <i class="fa fa-calendar"></i>
                                            <?php
                                            $fecha = date_create($orden->fecha_entrega);
                                            echo date_format($fecha,'d/m/Y');
                                            ?>

                                    </td>


                                <td class="check-mail" style="border:solid black 0.5px">
                                    <a href="ord_admin?idorden={{$orden->idordencompra}}"   id="{{$orden->id}}" class=" btn btn-sm btn-white ">
                                        <i class="fa fa-eye"></i>
                                    </a>
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





@stop