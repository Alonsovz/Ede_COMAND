@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
@stop


@section('enunciado')
    Tickets
@stop

@section('modulo')
    Tickets
@stop

@section('submodulo')
    Tickets Completados
@stop

@section('contenido')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5></h5>
                    <div class="ibox-tools">
                        <button id="btn_regresarbandeja" class="btn btn-danger btn-xs"><i class="fa fa-arrow-left"></i> Regresar a bandeja</button>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="m-b-lg">


                        <div class="m-t-md ">

                            <div class="pull-right hidden ">
                                <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-comments"></i> </button>
                                <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-user"></i> </button>
                                <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-list"></i> </button>
                                <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-pencil"></i> </button>
                                <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-print"></i> </button>
                                <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-cogs"></i> </button>
                            </div>

                            <h2> Resoluciones de tickets</h2>



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
                                @if($ticket->estado_id=='6' || $ticket->estado_id=='8' || $ticket->estado_id=='10' )
                                    <tr>
                                        <td class="" style="width: 15px">
                                            @if($ticket->estado=='Enviado')
                                                <span class="label label-primary">Enviado</span>
                                            @elseif($ticket->estado=='Recibido')
                                                <span class="label label-warning">Recibido</span>
                                            @elseif($ticket->estado=='Solucion Denegado')
                                                <span class="label label-info">Solucion denegada</span>
                                            @elseif($ticket->estado=='Solucionado')
                                                <span class="label label-info">Solucionado</span>
                                            @elseif($ticket->estado=='Cerrado')
                                                <span class="label label-danger">Cerrado</span>

                                            @endif
                                        </td>
                                        <td class="issue-info" style="width: 60px">
                                            <a href="#">
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
                                            <a href="resolucionstaff?ticket={{$ticket->id}}" class="btn btn-white btn-xs"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
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


    <script src="../js/funciones/resolucionestickets.js"></script>

@stop