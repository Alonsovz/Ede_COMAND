@extends('layouts.template')

@section('css')
    <link rel="stylesheet" href="../css/plugins/sweetalert/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.css">
@stop

@section('enunciado')
    Actualizaciones
@stop

@section('modulo')
    Postes
@stop

@section('submodulo')
    <b>Index</b>
@stop

@section('contenido')



    <div class="row" style="margin: 5px;">
        <button type="button" id="btn_nuevasolpostes" class="btn btn-outline btn-success pull-left btn-lg"><i class="fa fa-plus"></i> Nueva Solicitud</button>
    </div>
    <br><br>




    <div class="row hidden" id="formularioposte">
        <div class="col-md-12">
            <div class="ibox" style="border: solid 1px lightgrey" >
                <div class="ibox-title "><b><i class="fa fa-paper-plane"></i> Requerimiento de actualización o censo</b></div>
                <div class="ibox-content" style="border: solid 1px whitesmoke" >
                    <form class="form-horizontal" data-toggle="validator" role="form" id="frm_postes">
                        <div class="row">
                            <h2><b>Rellenar los siguientes campos</b></h2><br>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Departamento: </label>
                                    <select name="departamento" id="departamento" class="form-control" >
                                        <option value="">Seleccione un departamento...</option>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{$departamento->ID}}">{{$departamento->DepName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 hidden" style="margin-left: 10px" id="divmunicipio" >
                                <div class="form-group" id="">
                                    <label>Municipio</label>
                                    <select  id="municipio" name="municipio" class="form-control" >
                                        <option value="">Seleccione un municipio...</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Codigos de proyectos nuevos:</label>
                                    <input type="text" class="form-control" name="codigoproyecto" id="codigoproyecto" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Cantidad de postes:</label>
                                    <input type="number" min="0" step="1" class="form-control" id="cantidadpostes" name="cantidadpostes" >
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Descripcion:</label>
                                    <textarea  id="descripcion" name="descripcion" rows="5"  class="form-control" ></textarea>
                                </div>
                            </div>
                        </div>
                        <div id="barra_progreso" class="hidden row">
                            <h3>Enviando...</h3>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="83"
                                     aria-valuemin="0" aria-valuemax="100" style="width:83%">
                                    80%
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button class="pull-right btn btn-lg btn-danger btn-outline" id="btn_cancelar" style="margin-left: 5px"><i class="fa fa-ban"></i> Cancelar</button>
                            <button class="pull-right btn btn-lg btn-success btn-outline" type="submit"  id="btn_guardarsolicitud"><i class="fa fa-save"></i> Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





@stop


@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/localization/messages_es.js"></script>
    <script src="https://unpkg.com/sweetalert2@7.20.6/dist/sweetalert2.all.js"></script>
    <script type="text/javascript" src="../js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="../js/funciones/postes.js"></script>
    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

@stop

