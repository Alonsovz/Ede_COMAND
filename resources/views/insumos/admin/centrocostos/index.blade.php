@extends('layouts.template')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">

@stop

@section('enunciado')
    Insumos
@stop

@section('modulo')
    Insumos
@stop

@section('submodulo')
    <b>Centro costos</b>
@stop

@section('contenido')
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">

                    <div class="ibox-content">

                        <div class="" style="padding: 20px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">

                                        <div class="row">
                                            <img src="../images/stock.png"  alt="">
                                        </div>

                                        <div class="row" style="margin-top: 20px" >
                                            <h1 style="margin-bottom: 40px; margin-left: 15px" class="text-success"> Centros de costos <b class="text-success"></b></h1>
                                        </div>

                                        <div class="row " id="divselect">
                                            <div class="col-lg-10" >
                                                <label for="centrocostos">Seleccionar centros de costos: </label>
                                                <select class="js-example-basic-multiple form-control" name="states[]" id="#mySelect2" multiple="multiple">
                                                    <option value="">centro costos...</option>
                                                    @foreach($centrocostos as $centrocosto)
                                                        <option value="{{$centrocosto->id}}">{{$centrocosto->nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 5px">
                                            <button class="btn btn-primary btn-md" id="btn_verexistencias" style="margin-left: 15px"><i class="fa fa-eye"></i> Ver existencias</button>
                                            <button class="btn btn-white btn-lg hidden" id="nuevabusqueda" onclick="location.reload()" style="margin-left: 15px"><i class="fa fa-search"></i> Nueva busqueda</button>
                                        </div>

                                        <div class="row hidden" id="barraprogreso" style="margin-top: 5px">
                                            <div class="col-md-8">
                                                <div class="progress progress-striped active" style="margin-left: 0px">
                                                    <div style="width: 75%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" role="progressbar" class="progress-bar progress-bar-success">
                                                        <span class="sr-only">40% Complete (success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="ibox-footer ">
                        <div class="row" id="divpaneles">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop


@section('scripts')


    <script src="../js/plugins/dataTables/datatables.min.js"></script>

    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="../js/funciones/centrocostos.js"></script>




@stop