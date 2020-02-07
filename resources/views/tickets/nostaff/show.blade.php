@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
@stop


@section('enunciado')
    Tickets
@stop

@section('modulo')
    Tickets
@stop

@section('submodulo')
Tickets Solicitados
@stop

@section('contenido')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Tickets solicitados</h5>
                    <div class="ibox-tools">
                        <a href="indexnostaff" class="btn btn-primary btn-xs">Nuevo ticket</a>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="m-b-lg">

                        <div class="m-t-md">
                            <div class="pull-right ">
                                <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-print"></i> Imprimir Reporte</button>
                            </div>
                            <h2> Historico de tickets solicitados <b>{{$conteo}}</b>.</h2>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table class="table  table-hover dataTables-example1">
                            <thead class="hidden">
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>

                            </thead>
                            <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td class="" style="width: 15px">
                                       @if($ticket->estado=='Enviado')
                                        <span class="label label-primary">Enviado</span>
                                       @elseif($ticket->estado=='Recibido')
                                            <span class="label label-warning">Recibido</span>
                                        @elseif($ticket->estado=='En proceso')
                                            <span class="label label-info">En proceso</span>
                                        @elseif($ticket->estado=='Solucionado')
                                            <span class="label label-success">Recibido</span>
                                        @elseif($ticket->estado=='Cerrado')
                                            <span class="label label-danger">Cerrado</span>

                                        @endif
                                    </td>
                                    <td class="issue-info" style="width: 60px">
                                        <a href="#" class="text-success">
                                            {{$ticket->id}}
                                        </a>

                                        <small>
                                            {{$ticket->titulo}}
                                        </small>
                                    </td>
                                    <td style="width: 60px">
                                        {{$ticket->descripcion}}
                                    </td>
                                    <td class="issue-info" style="width: 30px">
                                        <a href="">
                                            <i class="fa fa-user"></i>
                                        </a>
                                        <small>{{$ticket->nombre}} {{$ticket->apellido}}</small>
                                    </td>
                                    <td style="width: 30px">
                                        <small>
                                            <b>
                                                <?php
                                                $date = date_create($ticket->fechasolicitud);
                                                echo date_format($date,'d/m/Y');
                                                ?>
                                            </b>
                                        </small>
                                    </td>
                                    <td class="text-right" style="width: 60px">
                                       <a href="editticketns?ticket={{$ticket->id}}" class="btn btn-white btn-xs"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                             @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>











    <!--MODAL PARA EDICION DEL TICKET SELECCIONADO-->
    <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Modal title</h4>
                    <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                </div>
                <div class="modal-body">
                    <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                        printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                        remaining essentially unchanged.</p>
                    <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                        printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                        remaining essentially unchanged.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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

    <script type="text/javascript" src="../js/funciones/tickets.js"></script>

@stop