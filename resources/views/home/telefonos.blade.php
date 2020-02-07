@extends('layouts.template')


@section('css')
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
@stop

@section('contenido')
    <div class="row">
        <div class="col-lg-10">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-phone"></i>  Extensiones</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>


                    </div>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped  dataTables-example1 table-hover dataTables-example" >
                            <thead>
                            <tr>
                                <th>Extension</th>
                                <th>Directo</th>
                                <th>Usuario(s)</th>
                                <th class="hidden">Engine version</th>
                                <th class="hidden">CSS grade</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($extensiones as $ex)
                                <tr>
                                    <td>{{$ex->extension}}</td>
                                    <td>{{$ex->directo}}</td>
                                    <td>{{$ex->usuario}}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="hidden">
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
    <script src="js/plugins/dataTables/datatables.min.js"></script>
    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="js/funciones/lenguajeDataTable.js"></script>



@stop