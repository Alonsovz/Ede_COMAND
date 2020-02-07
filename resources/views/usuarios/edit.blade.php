@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">

@stop


@section('enunciado')
    Mi Perfil
@stop

@section('modulo')
    Mi perfil
@stop

@section('submodulo')

@stop

@section('contenido')
    <div class="row " style="margin-top: 20px" id="">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><i class="fa fa-dashboard"></i> Mi perfil</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" id="frm_express">

                        <div class="form-group"><label class="col-lg-2 control-label">Nueva contraseña</label>

                            <div class="col-lg-6">
                                <input id="nuevacontrasena"  type="password" placeholder="Digite una contraseña" class="form-control">

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Confirmar contraseña</label>

                            <div class="col-lg-6">
                                <input id="confirmarcontrasena"  type="password" placeholder="Confirme su contraseña" class="form-control">

                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-2 control-label">Seleccione un avatar </label>
                            <div class="col-lg-6" id="avatar">
                                @for($i=1; $i<=$conteos; $i++)
                                    <button type="button" class="btn btn-white btn_avatar" id="../avatars/{{$i}}.png">
                                        <img src="../avatars/{{$i}}.png" width="60" height="60" alt="">
                                    </button>
                                @endfor
                            </div>

                        </div>




                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button  class="btn btn-sm btn-success" id="btn_guardarinformacion" type="button">Guardar informacion</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop


@section('scripts')
    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script src="../js/funciones/usuarios.js"></script>
@stop