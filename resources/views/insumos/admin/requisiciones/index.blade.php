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
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <a class="btn btn-block btn-primary compose-mail" href="" id="actualizarpagina"><i class="fa fa-refresh"></i> Actualizar</a>
                        <div class="space-25"></div>
                        <h5></h5>
                        <ul class="folder-list m-b-md" style="padding: 0">
                            <li><a href=""> <i class="fa fa-inbox "></i>Requisiciones <span class="label label-warning pull-right">{{$conteo}}</span> </a></li>



                        </ul>
                        <h5></h5>
                        <ul class="category-list" style="padding: 0">
                        </ul>


                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>


        <!--DATATABLE PARA REQ-->
        <div class="col-lg-12 animated fadeInRight" >
            <div class="mail-box-header">
                <h2>
                    Requisiciones nuevas ({{$conteo}})
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
            </div>
            </div>
            <div class="mail-box" style="padding: 5px;">

                <table style="border: 0.5px solid black;color: black" class="dataTables-example1 table table-hover table-bordered table-mail dataTables-example" >
                    <thead style="border:0.5px solid black" id="header" class="">
                    <tr style="background-color: lightgrey; color: black;">
                        <th style="border:black solid 0.5px">N° de Req.</th>
                        <th style="border:black solid 0.5px">Tipo Req</th>
                        <th style="border:black solid 0.5px">Solicitante</th>
                        <th style="border:black solid 0.5px" class="text-center">Estado</th>
                        <th style="border:black solid 0.5px">Justificacion</th>
                        <th style="border:black solid 0.5px">Fecha sol.</th>
                        <th style="border:black solid 0.5px">Accion</th>
                    </tr>
                    </thead>
                    <tbody style="border:1px solid black">
                    @foreach($requisiciones as $requisicion)
                            <tr  class="gradeU">
                                <td style="border:black solid 0.5px"><b>{{$requisicion->id}}</b></td>
                                <td style="border:black solid 0.5px;color:black"><span class="">{{$requisicion->tiporequisicion}}</span></td>
                                <td style="border:black solid 0.5px"><b>{{$requisicion->nombresolicitante}} {{$requisicion->apellidosolicitante}}</b></td>

                                @if($requisicion->estado=='Recibida')
                                    <td class=" text-center" style="border:black solid 0.5px">
                                        <span class="label label-info bg-info ">Nueva requisicion</span>
                                    </td>
                                @elseif($requisicion->estado=='Aprobada')
                                    <td class="text-center" style="border:black solid 0.5px">
                                        <span class="label label-success bg-success ">Requisicion aprobada</span>
                                    </td>
                                @elseif($requisicion->estado=='Denegada')
                                    <td class=" text-center" style="border:black solid 0.5px">
                                        <span class="label label-danger bg-danger ">Requisicion denegada</span>
                                    </td>

                                @elseif($requisicion->estado=='Cancelada')
                                    <td class=" text-center" style="border:black solid 0.5px">
                                        <span class="label label-danger bg-danger ">Requisicion cancelada</span>
                                    </td>
                                @endif
                                <td class="center text-default" style="border:black solid 0.5px">{{$requisicion->justificacion}}</td>
                                <td class="center" style="border:black solid 0.5px">
                                    <small>
                                        <i class="fa fa-calendar"></i>
                                        <?php
                                            $fecha = date_create($requisicion->fechasolicitud);
                                            echo date_format($fecha,'d/m/Y');
                                        ?>
                                    </small>
                                </td>
                                <td class="check-mail" style="border:black solid 0.5px">
                                    <a href="verdetallesrequisicion?idrequisicion={{$requisicion->id}}"   id="{{$requisicion->id}}" class=" btn btn-sm btn-white btn_detallesrequisicion">
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
        <!--FIN DE DATATABLE PARA REQ-->
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