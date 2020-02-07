@extends('layouts.template')

@section('css')

    <link rel="stylesheet" href="../css/plugins/sweetalert/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.css">

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


        {{--<div class="col-lg-6">
            <div class="ibox" style="color: black">
                <div class="ibox-title">
                    <h3><i class="fa fa-info-circle"></i> Indicadores</h3>
                </div>
                <div class="ibox-content">

                    <input type="radio" class="" checked="checked"  value="all" id="filtro1" name="filtros">
                    Mostrar todos
                    <br>
                    <input type="radio" class=""  value="f1" id="filtro1" name="filtros">
                    Reservas mayores a 1 dia
                    <br>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-3 pull-right " style="margin-right: 10px">
                <div class="form-group">
                    <label><i class="fa fa-car"></i> Buscar por Vehiculo</label>
                    <input type="text" class="form-control" id="vehiculo">
                </div>
            </div>
        </div>--}}

        <div class="row">
            <div class="col-md-3 pull-right " style="margin-right: 10px">
                <div class="form-group">
                </div>
            </div>
        </div>
        <br>

        <br>
        <h1>
            <i class="fa fa-dropbox"></i> Activos asignados


                <button data-toggle="modal" data-target="#modalnuevoactivo" class="btn btn-outline btn-primary btn-lg pull-right" style="border:solid 1px black; margin-left: 5px" type="button"><i class="fa fa-plus-circle"></i> Nuevo Activo</button>
                <button data-toggle="modal" data-target="#modalvalidacion" class="btn btn-outline btn-success btn-lg pull-right" style="border:solid 1px black" type="button"><i class="fa fa-hand-o-up"></i> Validar mis activos</button>
                <a href="imprimirmisactivos"  class="btn btn-outline btn-warning btn-lg pull-right" style="margin-right: 5px;border:solid 1px black" type="button" ><i class="fa fa-print"></i> Imprimir Listado </a>

        </h1>


        <br><br>
        <div id="kilometraje1" class="">
            <table id="tbl_activos" class="dataTables-example1 table table-hover  table-mail " style="color: black;margin-top: 20px; font-size: 12px" >
                <thead id="header" class="">
                <tr style="background-color: lightgrey">
                    <th class="text-center" style="border: solid 1px grey;">Activo</th>
                    <th class="text-center" style="border: solid 1px grey;">Cod. VNR</th>
                    <th class="text-center" style="border: solid 1px grey;">Cod. COMANDA</th>
                    <th class="text-center" style="border: solid 1px grey;">Color</th>
                    <th class="text-center" style="border: solid 1px grey;">Marca</th>
                    <th class="text-center" style="border: solid 1px grey;">Modelo</th>
                    <th class="text-center" style="border: solid 1px grey;">Ubicacion</th>
                    <th class="text-center" style="border: solid 1px grey;"></th>
                    <th class="text-center" style="border: solid 1px grey;"></th>

                </tr>
                </thead>
                <tbody>
                @foreach($activos as $a)
                    @if($a->estado_activo!=4)
                    <tr style="">
                        <td style="border: solid 1px grey; "><b>{{$a->tipo_activo}}</b></td>
                        <td style="border: solid 1px grey; ">{{$a->codigo_vnr}}</td>
                        <td style="border: solid 1px grey; ">{{$a->codigo_comanda}}</td>
                        <td class="text-center" style="border: solid 1px grey; ">{{$a->color}}</td>
                        <td class="text-center" style="border: solid 1px grey;">{{$a->marca}}</td>
                        <td class="text-center" style="border: solid 1px grey;">{{$a->modelo}}</td>
                        @if($a->ubicacion)
                            <td class="text-center" style="border: solid 1px grey;">{{$a->ubicacion}}</td>
                        @else
                            <td class="text-center" style="border: solid 1px grey;">Oficina</td>
                        @endif

                        <td style="border: solid 1px black;" class="text-center">
                            <button id="{{$a->id}}" data-toggle="modal" data-target="#modaltraslado" class="btn btn-default btn-md traslado" style="border:solid 1px black; margin-left: 5px" type="button"><i class="fa fa-paper-plane"></i> Traslado</button>
                        </td>
                        <td style="border: solid 1px black;" class="text-center">
                            <button id="{{$a->id}}" data-toggle="modal" data-target="#motivoba_modal" class="btn btn-default btn-md iniciarbaja" style="border:solid 1px black; margin-left: 5px" type="button"><i class="fa fa-download"></i> Baja</button>
                        </td>

                    </tr>
                    @endif
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




    {{--MODAL PARA LA VALIDACION DE LOS ACTIVOS DEL EMPLEADO--}}
    <div class="modal inmodal fade" id="modalvalidacion" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Validación de mis activos</h5>
                    <h2><i class="fa fa-dropbox"></i></h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class=" alert alert-info">
                            <h1><strong>Estimado usuario!</strong></h1>
                            Si ya validaste los activos que segun sistema se encuentran asignados a tu persona favor enviar validación,
                            o puedes enviar un comentario informando cualquier tipo de anomalia en tus asignaciones.
                        </div>
                    </div>
                    <form class="form-horizontal" id="frm_insumos">




                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default  btn-lg btn-outline" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                    <button type="button" class="btn btn-danger btn-lg" id="btn_novalidacion" data-toggle="modal" data-target="#comentarionegacion" data-dismiss="modal"><i class="fa fa-thumbs-o-down"></i> NO</button>
                    <button type="button" class="btn btn-primary btn-lg" id="btn_enviarvalidacion" data-dismiss="modal"><i class="fa fa-thumbs-o-up"></i> SI</button>

                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA NUEVO ACTIVO--}}
    <div class="modal inmodal fade" id="modalnuevoactivo" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Nueva hoja de activo</h5>
                    <h2><i class="fa fa-file-text"></i></h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="frm_adqactivo" method="post" data-toggle="validator" role="form">

                            <h1>Detalles de Activo</h1>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group" id="the-basics1"><label>Activo: </label>
                                            <input type="text" class="form-control typeahead1" id="insumo" name="insumo">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group"><label>Cantidad: </label>
                                            <input type="number" min="0" name="cantidad" value="1" readonly="readonly"  class="form-control" id="cantidad">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group" id=""><label>Marca: </label>
                                        <input type="text" class="form-control " id="marca" name="marca">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Modelo: </label>
                                        <input type="text"  name="modelo"    class="form-control" id="modelo">
                                    </div>
                                </div>
                                <div class="row">



                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Precio: </label>
                                        <input type="text"  step="any" name="precio"   class="form-control" id="precio">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group" id=""><label>Color: </label>
                                        <input type="text" class="form-control " id="color" name="color">
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Categoria: </label>
                                        <select name="categoria" id="categoria" class="form-control">
                                            <option value=""></option>
                                            <option value="4">Mobiliario y Equipo</option>
                                            <option value="2">Herramientas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 hidden" id="divcategoria" >
                                    <div class="form-group"><label>Bodega: </label>
                                        <select name="bodega" id="bodega" class="form-control" style="background: lightgreen">
                                            <option value=""></option>
                                           @foreach($bodegas as $bodega)
                                                <option value="{{$bodega->id}}"><b>{{$bodega->codigo}}</b></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Proveedor: </label>
                                        <input type="text" class="form-control" id="proveedor" name="proveedor">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Finalidad de activo: </label>
                                        <select name="finalidad" id="finalidad" class="form-control">
                                            <option value=""></option>
                                            <option value="Comercialización">Comercialización</option>
                                            <option value="Distribución">Distribución</option>
                                            <option value="General">General</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>CCF: </label>
                                        <input type="text" class="form-control" id="ccf" name="ccf" placeholder="Numero de credito fiscal">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Fecha de compra: </label>
                                        <input type="date" class="form-control" id="fechacompra" name="fechacompra" placeholder="Numero de credito fiscal">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                            </div>

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>Otras Especificaciones: </label>
                                        <textarea rows="3" class="form-control" name="otrasespecificaciones" id="otrasespecificaciones" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Entregado de bodega: </label>
                                        <select name="estado" id="estado" class="form-control">
                                            <option value=""></option>
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>



                            <br>
                            <h1>Ubicación de Activo</h1>
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Agencia: </label>
                                        <select name="agencia" id="agencias" class="form-control">
                                            <option value=""></option>
                                            @foreach($agencias as $agencia)
                                                <option value="{{$agencia->id}}">{{$agencia->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Centro costos: </label>
                                        <select name="cc" id="ccostos" class="form-control">
                                            <option value=""></option>
                                            @foreach($centros as $cc)
                                                <option value="{{$cc->id}}">{{$cc->id}}. {{$cc->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Depto Edesal: </label>

                                        <select  name="deptoedesal" id="deptoedesal" class="form-control">
                                            <option value=""></option>
                                            @foreach($areas as $area)
                                                <option value="{{$area->id}}">{{$area->nombre}}</option>
                                                @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Departamento: </label>

                                            <select name="departamento" id="departamento" class="form-control">
                                                <option value=""></option>
                                                @foreach($departamentos as $departamento)
                                                    <option value="{{$departamento->ID}}">{{$departamento->DepName}}</option>
                                                @endforeach
                                            </select>

                                    </div>
                                </div>


                            </div>


                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Municipio: </label>

                                        <select  name="municipio" id="municipio" class="form-control">

                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 5px">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>Justificacion de compra: </label>

                                            <textarea name="justificacion" id="justificacion" cols="40" rows="4" class="form-control"></textarea>

                                    </div>
                                </div>

                            </div>


                            <button type="submit" style="border:solid black 1px" id="" class="btn btn-primary  btn-lg btn-outline btn_generarhojaactivo"  ><i class="fa fa-save"></i> Generar Hoja</button>
                            <button type="button" style="border:solid black 1px" class="btn btn-default  btn-lg btn-outline" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>

                        </form>

                    </div>
                </div>

                <div class="modal-footer">


                </div>
            </div>
        </div>
    </div>




    {{--MODAL PARA TRASLADO --}}
    <div class="modal inmodal fade" id="modaltraslado" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Traslado de activo fijo</h5>
                    <h2><i class="fa fa-paper-plane"></i></h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="frm_traslado" method="post" data-toggle="validator" role="form">

                            <h1>Detalles de Activo <small>(a trasladar)</small></h1>
                            <div class="row">

                                <div class="col-lg-7">
                                    <div class="form-group" id="the-basics1"><label>Insumo: </label>
                                        <input type="text" class="form-control typeahead1" readonly="readonly" id="insumo_tr" name="insumo_tr">
                                    </div>
                                </div>


                            </div>
                            <div class="row">


                                <div class="col-lg-4">
                                    <div class="form-group"><label>Modelo: </label>
                                        <input type="text"  name="modelo_tr" readonly="readonly"    class="form-control" id="modelo_tr">
                                    </div>
                                </div>

                                    <div class="col-lg-3">
                                        <div class="form-group" id=""><label>Color: </label>
                                            <input type="text" class="form-control " readonly="readonly" id="color_tr" name="color_tr">
                                        </div>
                                    </div>

                                <div class="col-lg-4">
                                    <div class="form-group" id=""><label>Marca: </label>
                                        <input type="text" class="form-control " readonly="readonly" id="marca_tr" name="marca_tr">
                                    </div>
                                </div>


                            </div>

                            <br>
                            <h1>Detalles de traslado</h1>
                            <div class="row">
                                <div class="col-lg-4" >
                                    <div  id="the-basics" class="form-group"><label>Tipo de traslado: </label>
                                        <select class="form-control" name="tipotraslado" id="tipotraslado">
                                            <option value=""></option>
                                            @foreach($tipostraslados as $tipo)
                                                <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4" >
                                    <div  id="the-basics" class="form-group"><label>Nuevo responsable: </label>
                                        <input type="text" class="form-control typeahead" id="empleado_tr" name="empleado_tr">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Agencia: </label>
                                        <select name="agencia_tr" id="agencias_tr" class="form-control">
                                            <option value=""></option>
                                            @foreach($agencias as $agencia)
                                                <option value="{{$agencia->id}}">{{$agencia->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="form-group"><label>Centro costos: </label>
                                        <select name="cc_tr" id="ccostos_tr" class="form-control">
                                            <option value=""></option>
                                            @foreach($centros as $cc)
                                                <option value="{{$cc->id}}">{{$cc->id}}. {{$cc->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Departamento: </label>

                                        <select name="departamento_tr" id="departamento_tr" class="form-control">
                                            <option value=""></option>
                                            @foreach($departamentos as $departamento)
                                                <option value="{{$departamento->ID}}">{{$departamento->DepName}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Municipio: </label>

                                        <select  name="municipio_tr" id="municipio_tr" class="form-control">

                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label>Observaciones:</label>
                                        <textarea name="observaciones_tr" class="form-control" id="observaciones_tr" cols="5" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <br><br>

                            <button type="submit" style="border:solid black 1px" id="btn_generartraslado" class="btn btn-primary  btn-lg btn-outline"  ><i class="fa fa-save"></i> Generar traslado</button>
                            <button type="button" style="border:solid black 1px" class="btn btn-default  btn-lg btn-outline" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>

                        </form>

                    </div>
                </div>

                <div class="modal-footer">


                </div>
            </div>
        </div>
    </div>


    {{--modal para comentario de negacion--}}
    <div class="modal inmodal fade" id="comentarionegacion" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Validación de mis activos</h5>
                    <h2><i class="fa fa-dropbox"></i></h2>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning"><i class="fa fa-info"></i> Necesitamos saber tus razones de la no validación de tus activos</div>
                    <form class="form-horizontal" id="frm_insumos">
                        <div class="form-group"><label class="col-lg-2 control-label">Comentario</label>
                            <div class="col-lg-8" id="the-basics">
                                <textarea name="" id="comentario" cols="80" rows="5"></textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-lg" id="btn_enviarnovalidacion"  ><i class="fa fa-save"></i> Enviar</button>
                </div>
            </div>
        </div>
    </div>



    {{--INICIAR EL PROCESO DE BAJA DE UN ACTIVO--}}
    <div class="modal inmodal fade" id="motivoba_modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Iniciar Baja de Activo</h5>
                    <h2><i class="fa fa-download"></i></h2>

                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_insumos">
                        <div class="form-group"><label class="col-lg-2 control-label">Activo</label>
                            <div class="col-lg-3" id="the-basics">
                                <input type="text" id="activo" class="form-control idha" readonly="true">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Motivo de baja:</label>
                            <div class="col-lg-4" id="the-basics">
                                <select name="" class="form-control" id="motivobaja">
                                    <option value=""></option>
                                    <option value="1">Robo</option>
                                    <option value="2">Extravio</option>
                                    <option value="3">Arruinado</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Justificación:</label>
                            <div class="col-lg-8" id="the-basics">
                                <textarea class="form-control" name="" id="justificacionbaja" cols="80" rows="5"></textarea>
                            </div>
                        </div>

                    </form>
                </div>



                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodalinsumos" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                    <button type="button" class="btn btn-success btn-sm btn_bajaactivo" id="" ><i class="fa fa-download"></i> Imprimir Hoja</button>
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
    <script src="https://unpkg.com/sweetalert2@7.20.6/dist/sweetalert2.all.js"></script>

    <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>

    <script src="../js/plugins/fullcalendar/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script type="text/javascript" src="../js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/localization/messages_es.js"></script>

    <script type="text/javascript" src='../js/funciones/activos.js'></script>









@stop

