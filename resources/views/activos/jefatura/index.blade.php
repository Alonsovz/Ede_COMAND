@extends('layouts.template')

@section('css')

    <link rel="stylesheet" href="../css/plugins/sweetalert/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">

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
    <b>Mis activos</b>
@stop

@section('contenido')




    <div class="row" id="">




        <div class="row">
            <div class="col-md-3 pull-right " style="margin-right: 10px">
                <div class="form-group">
                </div>
            </div>
        </div>
        <br>

        <br>
        <h1>
            <i class="fa fa-dropbox"></i> Activos asignados en la rama de jefatura

        </h1>

        <br><br>
        <div id="kilometraje1" class="">
            <table id="tbl_kilometrajes" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 20px; font-size: 12px" >
                <thead id="header" class="">
                <tr style="background-color: lightgrey">
                    <th class="text-center" style="border: solid 1px grey;">Empleado</th>
                    <th class="text-center" style="border: solid 1px grey;">Activo</th>
                    <th class="text-center" style="border: solid 1px grey;">Marca</th>
                    <th class="text-center" style="border: solid 1px grey;">Modelo</th>
                    <th class="text-center" style="border: solid 1px grey;">Ubicacion</th>
                    <th class="text-center" style="border: solid 1px grey;">Fecha</th>
                </tr>
                </thead>
                <tbody>
                @foreach($activos as $a)
                    <tr style="">
                        <td style="border: solid 1px grey; ">{{$a->nombre}} {{$a->apellido}}</td>
                        <td style="border: solid 1px grey; "><b>{{$a->tipo_activo}}</b></td>
                        <td class="text-center" style="border: solid 1px grey;">{{$a->marca}}</td>
                        <td class="text-center" style="border: solid 1px grey;"><b>{{$a->modelo}}</td>
                        @if($a->ubicacion)
                            <td class="text-center" style="border: solid 1px grey;"><b>{{$a->ubicacion}}</td>
                        @else
                            <td class="text-center" style="border: solid 1px grey;"><b>Oficina</td>
                        @endif
                        @if($a->fecha)
                            <td class="text-center" style="border: solid 1px grey;"><?php $fecha = date_create($a->fecha); echo date_format($fecha,'d/m/Y') ?></td>

                        @else
                            <td class="text-center" style="border: solid 1px grey;">N/A</td>
                        @endif

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






@stop


@section('scripts')
    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>

    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>
    <script src="https://unpkg.com/sweetalert2@7.20.6/dist/sweetalert2.all.js"></script>

    <script src="../js/plugins/fullcalendar/moment.min.js"></script>



    <script type="text/javascript" src="../js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>


    <script type="text/javascript" src='../js/funciones/activos.js'></script>









@stop

