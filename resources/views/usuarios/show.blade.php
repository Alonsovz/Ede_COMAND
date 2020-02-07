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
    Usuarios
@stop

@section('contenido')




    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-heading">
                    <div class="ibox-title">
                        <h2><i class="fa fa-users"></i> Usuarios</h2>
                        <button id="" type="button" class="pull-right btn btn-success btn-sm" data-toggle="modal" data-target="#nuevousuario"><i class="fa fa-plus"></i> Nuevo usuario</button>
                        <br><br>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table  table-hover dataTables-example1" id="tablausuarios">
                            <thead class="" style="border: solid black 1px; background-color: lightgrey">
                            <th style="border: solid black 1px;" >ID</th>
                            <th style="border: solid black 1px;">Usuario</th>
                            <th style="border: solid black 1px;">Alias</th>
                            <th style="border: solid black 1px;">Correo</th>
                            <th style="border: solid black 1px;"></th>
                            <th style="border: solid black 1px;"></th>

                            </thead>
                            <tbody>
                                @foreach($usuarios as $usuario)
                                    <tr>
                                        <td style=""><b>{{$usuario->id}}</b></td>
                                        <td>{{$usuario->nombre}} {{$usuario->apellido}}</td>
                                        <td>{{$usuario->alias}}</td>
                                        <td>{{$usuario->correo}}</td>
                                        <td><button class="btn btn-white btn_mostrarfooter" id="{{$usuario->id}}"><i class="fa  fa-eye"></i></button></td>
                                        <td><button class="btn btn-danger"><i class="fa  fa-trash"></i></button></td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="ibox-footer hidden" id="footeribox">
                    <form class="form-horizontal" id="frm_sistema">

                        <h1>Información General</h1>
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group"><label class="col-lg-2 control-label">Nombre: </label>
                                    <div class="col-lg-6">
                                        <input id="nombre"  type="text"  class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="form-group"><label class="col-lg-2 control-label">Apellido: </label>
                                    <div class="col-lg-6">
                                        <input id="apellido"  type="text"  class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group"><label class="col-lg-2 control-label">Alias: </label>
                                    <div class="col-lg-6">
                                        <input id="alias"  type="text"  class="form-control">
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-5">
                                <div class="form-group"><label class="col-lg-2 control-label">Correo: </label>
                                    <div class="col-lg-6">
                                        <input id="correo"  type="text"  class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>

                        <h1>Información Administrativa</h1>
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group"><label class="col-lg-2 control-label">Dpto: </label>
                                    <div class="col-lg-6">
                                        <select name="" id="departamento" class="form-control">
                                           @foreach($departamentos as $departamento)
                                                <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="form-group"><label class="col-lg-2 control-label">Jefatura: </label>
                                    <div class="col-lg-6">
                                        <select name="" id="jefeinmediato" class="form-control">
                                            @foreach($usuarios as $usuario)
                                                <option value="{{$usuario->id}}">{{$usuario->nombre}} {{$usuario->apellido}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <button type="button" style="color:black" class="btn btn-white btn-md" id="btn_verroles"><i class="fa fa-user"></i> Ver roles</button>
                        <br><br>
                        <div class="row hidden" id="tablaroles">

                            <div class="col-lg-6">

                                <h1>Roles  <button type="button" data-toggle="modal" data-target="#nuevorol" class="btn btn-xs btn-info"><i class="fa fa-plus"></i> Asignar nuevo Rol</button></h1>
                                <br>
                                <table style="color: black;" class="table table-bordered table-responsive" id="tabla_roles">
                                    <thead>
                                            <th>Rol</th>
                                            <th>Descripcion</th>
                                            <th></th>
                                    </thead>
                                    <tbody id="cuerpotabla">

                                    </tbody>
                                </table>
                            </div>


                        </div>

                        <br><br><br>
                        <div class="form-group" >
                            <div class="col-lg-offset-2 col-lg-10">
                                <button style="margin-left: 5px" class="btn btn-sm btn-primary pull-right" id="btn_guardarinfogeneral" type="button"><i class="fa fa-save"></i> Guardar</button>
                                <button class="btn btn-sm btn-danger pull-right" id="btn_cancelar" type="button"><i class="fa fa-close"></i> Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="modal inmodal fade" id="nuevorol" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Asignar nuevo rol</h5>
                    <h2><i class="fa fa-user"></i></h2>

                </div>
                <div class="modal-body">

                    <table style="color: black;" class="dataTables-example1 table table-bordered table-responsive datatable">
                        <thead style="background: lightgrey;">
                        <th>Rol</th>
                        <th>Descripcion</th>
                        <th></th>
                        </thead>
                        <tbody id="cuerpotabla">
                        @foreach($roles as $rol)
                            <tr>
                                <td><b>{{$rol->nombre}}</b></td>
                                <td>{{$rol->descripcion}}</td>
                                @if($rol->nombre=='vh_dueño')
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning asignar_rol" data-toggle="modal" data-target="#vehiculo" id="{{$rol->id}}"><i class="fa fa-save"></i> Asignar</button>
                                    </td>
                                @elseif($rol->nombre=='supervisor_ins')
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning asignar_rol" data-toggle="modal" data-target="#insumos" data-dismiss="modal" id="{{$rol->id}}"><i class="fa fa-save"></i> Asignar</button>
                                    </td>
                                @else
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success asignar_rol " data-dismiss="modal" id="{{$rol->id}}"><i class="fa fa-save"></i> Asignar</button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cerrar" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA ASIGNACION DE VEHICULO--}}
    <div class="modal inmodal fade" id="vehiculo" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Asignar Vehiculo</h5>
                    <h2><i class="fa fa-car"></i></h2>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="alert alert-warning"><b><i class="fa fa-info-circle"></i> Es necesario que se asigne un vehiculo para el rol que se establecio</b></div>
                        <div class="col-lg-12">
                            <div class="form-group"><label class="col-lg-2 control-label">Vehiculo: </label>
                                <div class="col-lg-12">
                                    <select name="" id="vehiculo" class="form-control">
                                        @foreach($vehiculos as $vehiculo)
                                            <option value="{{$vehiculo->id}}">{{$vehiculo->numeracion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cerrar" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" id="btn_guardarinfo_vh" data-dismiss="modal"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

        {{--MODAL PARA ASIGNACION DE CENTRO DE COSTOS Y BODEGA--}}
        <div class="modal inmodal fade" id="insumos" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h5 class="modal-title">Asignar CC y Bodega</h5>
                        <h2><i class="fa fa-car"></i></h2>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="alert alert-warning"><b><i class="fa fa-info-circle"></i> Es necesario que se asigne un centro de costos y bodega para el rol que se establecio</b></div>
                            <div class="col-lg-12">
                                <div class="form-group"><label class="col-lg-2 control-label">Bodega: </label>
                                    <div class="col-lg-12">
                                        <select name="" id="bodega" class="form-control">
                                            @foreach($bodegas as $bodega)
                                                <option value="{{$bodega->id}}">{{$bodega->codigo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group"><label class="col-lg-2 control-label">CC: </label>
                                    <div class="col-lg-12">
                                        <select name="" id="centrocosto" class="form-control">
                                            @foreach($centrocostos as $cc)
                                                <option value="{{$cc->id}}">{{$cc->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" id="btn_cerrar" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                            <button type="button" class="btn btn-primary btn-sm" id="btn_guardarinfo_insum" ><i class="fa fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </div>
            </div>







            {{--modal para nuevo usuario--}}
            <div class="modal inmodal fade" id="nuevousuario" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h5 class="modal-title">Nuevo Usuario</h5>
                            <h2><i class="fa fa-user"></i></h2>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" id="frm_nuevousuario">

                                <h1>Información General</h1>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group"><label class="col-lg-2 control-label">Nombre: </label>
                                            <div class="col-lg-6">
                                                <input id="nombre1"  type="text"  class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-5">
                                        <div class="form-group"><label class="col-lg-2 control-label">Apellido: </label>
                                            <div class="col-lg-6">
                                                <input id="apellido1"  type="text"  class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group"><label class="col-lg-2 control-label">Alias: </label>
                                            <div class="col-lg-6">
                                                <input id="alias1"  type="text"  class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-5">
                                        <div class="form-group"><label class="col-lg-2 control-label">Correo: </label>
                                            <div class="col-lg-6">
                                                <input id="correo1"  type="text"  class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br><br>

                                <h1>Información Administrativa</h1>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group"><label class="col-lg-2 control-label">Dpto: </label>
                                            <div class="col-lg-6">
                                                <select name="" id="departamento1" class="form-control">
                                                    @foreach($departamentos as $departamento)
                                                        <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-5">
                                        <div class="form-group"><label class="col-lg-2 control-label">Jefatura: </label>
                                            <div class="col-lg-8">
                                                <select name="" id="jefeinmediato1" class="form-control">
                                                    @foreach($usuarios as $usuario)
                                                        <option value="{{$usuario->id}}">{{$usuario->nombre}} {{$usuario->apellido}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <br><br><br>
                                <div class="form-group" >
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button style="margin-left: 5px" class="btn btn-sm btn-primary pull-right" id="btn_guardarusuario" data-dismiss="modal" type="button"><i class="fa fa-save"></i> Guardar</button>
                                        <button class="btn btn-sm btn-danger pull-right" data-dismiss="modal" id="btn_cancelar" type="button"><i class="fa fa-close"></i> Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>







            @stop

@section('scripts')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Nestable/2012-10-15/jquery.nestable.min.js"></script>
    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>

    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <script src="../js/funciones/informatica.js"></script>








@stop