@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
@stop


@section('enunciado')
    Administracion
@stop

@section('modulo')
    Adminitracion
@stop

@section('submodulo')
    Nuevo sistema
@stop

@section('contenido')




    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-heading">
                    <div class="ibox-title">
                        <h2><i class="fa fa-desktop"></i> Sistemas</h2>
                        <button id="btn_nuevosistema" class="pull-right btn btn-success btn-sm">Nuevo sistema</button>
                        <br><br>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table  table-hover dataTables-example1" id="tbl_sistemas">
                            <thead class="hidden">
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>

                            </thead>
                            <tbody>
                            @foreach($sistemas as $sistema)

                                    <tr>
                                        <td><i class="fa fa-desktop"></i> <b>{{$sistema->nombre}}</b></td>
                                        <td>{{$sistema->descripcion}}</td>
                                        <td>
                                            <button type="button" data-toggle="modal" data-target="#edicionsistema" id="{{$sistema->id}}" class="btn btn-white btn_editarsistema"><i class="fa fa-edit"></i></button>
                                            <button type="button" data-toggle="modal" data-target="#edicionsistema" id="{{$sistema->id}}" class="btn btn-white btn_borrarsistema"><i class="fa fa-trash"></i></button>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="ibox-footer hidden" id="footeribox">
                    <form class="form-horizontal" id="frm_sistema">

                        <div class="form-group"><label class="col-lg-2 control-label">Nombre</label>

                            <div class="col-lg-6">
                                <input id="nombresistema"  type="text" placeholder="Nombre del sistema" class="form-control">

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                            <div class="col-lg-6">
                                <textarea class="form-control" id="descripcionsistema"  cols="30" rows="10"></textarea>

                            </div>
                        </div>



                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-primary" id="btn_guardarsistema" type="button">Guardar sistema</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <div class="modal inmodal fade" id="edicionsistema" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"><i class="fa fa-pencil"></i> Edicion de sistema</h4>

                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_edicionsistema">

                        <div class="form-group"><label class="col-lg-2 control-label">Nombre</label>

                            <div class="col-lg-6">
                                <input id="ed_nombre"  type="text" placeholder="Nombre del sistema" class="form-control">

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                            <div class="col-lg-8">
                                <textarea class="form-control" id="ed_descripcion"  cols="30" rows="10"></textarea>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="" class="btn btn-primary btn_guardaredicion">Guardar edicion</button>
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

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <script src="../js/funciones/sistemas.js"></script>



@stop