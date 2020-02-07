{{--vista para supervisar las herramientas en las bodegas--}}
@extends('layouts.template')

@section('css')

    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/datapicker/datepicker3.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.css">

    <style>
        body{
            color: black;
        }
    </style>

@stop

@section('enunciado')
    Insumos
@stop

@section('modulo')
    Insumos
@stop

@section('submodulo')
    <b>Mi Bodega</b>
@stop

@section('contenido')

    <div class="row" style="margin-top: 50px" id="registrosalida">
        <div class="ibox">

            <div class="ibox-heading">
                <div class="ibox-title">
                    <h1 class="text-primary"><i class="fa fa-home"></i> Supervisión de bodegas
                        <a   class="pull-right btn btn-lg btn-default rpt_dispoherram" id="{{$bodega->id}}"  style="margin-right: 5px; border:solid 1px black; color: black;"><i class="fa fa-file-pdf-o"></i> Reporte Disponibilidad</a>
                        {{--<button type="button" data-toggle="modal" data-target="#modalnuevoactivo" class="pull-right btn btn-lg btn-default hojaactivo"  style="margin-right: 5px; border:solid 1px black; color: black;"><i class="fa fa-plus"></i> Nueva hoja de activo</button>--}}

                        @if(Session::get('idusuario')==14)
                            <button   data-toggle="modal" data-target="#modalnuevoactivo2" style="border:solid 1px black; margin-right: 5px" class="btn btn-outline btn-success btn-lg  pull-right"><i class="fa fa-file-text"></i> Hoja de activo</button>
                        @endif

                        {{--<a   class="pull-right btn btn-lg btn-default" id="detallesdiv" style="margin-right: 5px; border:solid 1px black; color: black;"><i class="fa fa-file-text"></i> Ver Hojas de activos</a>--}}

                    </h1>
                    <br><br><br><br>




                </div>


            </div>




            <div class="ibox-content">

                <ul class="category-list pull-left." style="padding: 0">
                    <li><a href="#" class="col-lg-2" style="background-color: lightsalmon; color: black"> <i class="" ></i> <b>Requiere hoja de activo</b></a></li>

                </ul>
                <br><br>
                <table class="dataTables-example1 table table-hover table-mail dataTables-example tablamovimientos" id="" style="color: black; font-size: 11px">
                    <thead id="header" class="">
                    <tr style="background-color: lightgrey;">


                        <th class="text-center" style="border:  solid black 1px;">ID</th>
                        <th class="text-center" style="border:  solid black 1px;">Activo</th>
                        <th class="text-center" style="border:  solid black 1px;">Bodega</th>
                        <th class="text-center" style="border:  solid black 1px;">Marca</th>
                        <th class="text-center" style="border:  solid black 1px;">Modelo</th>
                        <th class="text-center" style="border:  solid black 1px;">Color</th>
                        <th class="text-center" style="border:  solid black 1px;">Estado</th>
                        <th class="text-center" style="border:  solid black 1px;">Vida util</th>

                        <th class="text-center" style="border:  solid black 1px;"></th>
                        <th class="text-center" style="border:  solid black 1px;"></th>
                        <th class="text-center" style="border:  solid black 1px;"></th>
                        <th class="text-center" style="border:  solid black 1px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($insumos as $insumo)
                        @if($insumo->estadoactivo=="Proceso de baja" || $insumo->estadoactivo=="Activa" || $insumo->estadoactivo=="No activa")
                          @if($insumo->estadoactivo=="No activa")
                              <tr style="background-color: lightsalmon">
                                  <td style="border:  solid black 1px;" class="">{{$insumo->id}}</td>
                                  <td style="border:  solid black 1px;" class="">{{$insumo->tipo_activo}}</td>
                                  <td style="border:  solid black 1px;" class="text-center">{{$insumo->bodega}}</td>
                                  <td class="text-center" style="border:  solid black 1px;">{{$insumo->marca}}</td>
                                  <td class="text-center" style="border:  solid black 1px;"> {{$insumo->modelo}}</td>
                                  <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->color}}</b></td>
                                  <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->estadoactivo}}</b></td>
                                  @if($insumo->vidautil=='Arruinado')
                                      <td  class="text-center" style="border:  solid black 1px; background: lightcoral;"><b>{{$insumo->vidautil}}</b></td>
                                  @else
                                      <td class="text-center" style="border:  solid black 1px;">{{$insumo->vidautil}}</td>
                                  @endif
                                  <td  class="text-center" style="border:  solid black 1px; "><button id="{{$insumo->id}}-{{$insumo->tipo_activo}}" style="border:solid 1px black" type="button" data-toggle="modal" data-target="#modalvidautil" class="btn btn-white btn-xs cambiarvidautil"><i class="fa fa-exchange"></i> Cambiar estado</button></td>
                                  <td  class="text-center" style="border:  solid black 1px; "><button style="border:solid 1px black" type="button" data-toggle="modal" data-target="" class="btn btn-white btn-xs"><i class="fa fa-paper-plane"></i> Traslado</button></td>

                                  @if($insumo->vidautil=="Arruinado")
                                      <td  class="text-center" style="border:  solid black 1px;"><button id="{{$insumo->id}}" style="border:solid 1px black" type="button" data-toggle="modal" data-target="#motivoba_modal" class="btn btn-danger btn-xs iniciarbaja"><i class="fa fa-download"></i> Iniciar baja</button></td>

                                  @else
                                      <td style="border: solid 1px black;"></td>
                                  @endif
                                  <td style="border: solid 1px black;"><button id="{{$insumo->id}}" data-toggle="modal" data-target="#modalnuevoactivo" style="border:solid 1px black" class="btn btn-success btn-xs verinfoactivo"><i class="fa fa-file-text"></i> Hoja de activo</button></td>

                              </tr>
                              @else
                              <tr>
                                  <td style="border:  solid black 1px;" class="">{{$insumo->id}}</td>
                                  <td style="border:  solid black 1px;" class="">{{$insumo->tipo_activo}}</td>
                                  <td style="border:  solid black 1px;" class="text-center">{{$insumo->bodega}}</td>
                                  <td class="text-center" style="border:  solid black 1px;">{{$insumo->marca}}</td>
                                  <td class="text-center" style="border:  solid black 1px;"> {{$insumo->modelo}}</td>
                                  <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->color}}</b></td>
                                  <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->estadoactivo}}</b></td>
                                  @if($insumo->vidautil=='Arruinado')
                                      <td  class="text-center" style="border:  solid black 1px; background: lightcoral;"><b>{{$insumo->vidautil}}</b></td>
                                  @else
                                      <td class="text-center" style="border:  solid black 1px;">{{$insumo->vidautil}}</td>
                                  @endif
                                  <td  class="text-center" style="border:  solid black 1px; "><button id="{{$insumo->id}}-{{$insumo->tipo_activo}}" style="border:solid 1px black" type="button" data-toggle="modal" data-target="#modalvidautil" class="btn btn-white btn-xs cambiarvidautil"><i class="fa fa-exchange"></i> Cambiar estado</button></td>
                                  <td  class="text-center" style="border:  solid black 1px; "><button style="border:solid 1px black" type="button" data-toggle="modal" id="{{$insumo->id}}" data-target="#modaltraslado" class="btn btn-white btn-xs traslado"><i class="fa fa-paper-plane"></i> Traslado</button></td>

                                  @if($insumo->vidautil=="Arruinado")
                                      <td  class="text-center" style="border:  solid black 1px;"><button id="{{$insumo->id}}" style="border:solid 1px black" type="button" data-toggle="modal" data-target="#motivoba_modal" class="btn btn-danger btn-xs iniciarbaja"><i class="fa fa-download"></i> Iniciar baja</button></td>

                                  @else
                                      <td style="border: solid 1px black;"></td>
                                  @endif
                                  <td style="border:solid 1px black"></td>

                              </tr>
                              @endif
                        @endif
                    @endforeach
                    </tbody>
                    <tfoot id="footer" class="hidden">
                    <tr>
                        <th>Codigo</th>
                        <th>Insumo</th>
                        <th>Sin asignar</th>
                        <th>Estado</th>
                        <th>Acccion</th>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="ibox-footer hidden " id="divhojaactivo">

            </div>
    </div>


        <div class="ibox-footer hidden">

        </div>
    </div>





    {{--MODAL PARA VIDA UTIL--}}
    <div class="modal inmodal fade" id="modalvidautil" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Cambio de estado</h5>
                    <h2><i class="fa fa-flag"></i></h2>

                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="frm_insumos">
                        <div class="form-group"><label class="col-lg-2 control-label">Herramienta:</label>
                            <div class="col-lg-6" id="the-basics">
                                <input type="text" id="herramienta" class="form-control idha" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-2 control-label">Estado:</label>
                            <div class="col-lg-4" id="the-basics">
                                <select name="" class="form-control" id="vidautil">
                                    <option value=""></option>
                                    <option value="3">Arruinado</option>
                                    <option value="2">Deteriorado</option>
                                    <option value="1">Buena condicion</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>



                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodalinsumos" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                    <button type="button" class="btn btn-success btn-sm btn_guardarcambiovidautil" id="" ><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>




    {{--BAJA DE ACTIVO--}}
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
                        <div class="form-group"><label class="col-lg-2 control-label">ID HA:</label>
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
                    <a target="_blank" type="button" class="btn btn-success btn-sm btn_bajaactivo" id="" ><i class="fa fa-download"></i> Imprimir Hoja</a>
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
                        <form id="frm_adqactivo1" method="post" data-toggle="validator" role="form">

                            <h1>Detalles de Activo</h1>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group"><label>Id: </label>
                                        <input type="text" readonly="readonly"  name="id"    class="form-control" id="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-5">
                                    <div class="form-group"><label>Activo: </label>
                                        <input type="text"  name="activo1"    class="form-control" id="activo1">
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="form-group" id="the-basics"><label>Usuario al que se asignara: </label>
                                        <input type="text"  name="usuarioasignado"  class="form-control typeahead" id="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group" id=""><label>Marca: </label>
                                        <input type="text" class="form-control " id="marca1" name="marca1">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Modelo: </label>
                                        <input type="text"  name="modelo1"    class="form-control" id="modelo1">
                                    </div>
                                </div>
                                <div class="row">



                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Precio: </label>
                                        <input type="text"  step="any" name="precio1"   class="form-control" id="precio1">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group" id=""><label>Color: </label>
                                        <input type="text" class="form-control " id="color1" name="color1">
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Proveedor: </label>
                                        <input type="text" class="form-control" id="proveedor1" name="proveedor1">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>CCF: </label>
                                        <input type="text" class="form-control" id="ccf1" name="ccf1" placeholder="Numero de credito fiscal">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Fecha de compra: </label>
                                        <input type="text" placeholder="Formato DD/MM/YYYY" class="form-control" id="fechacompra1" name="fechacompra1" >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>Otras Especificaciones: </label>
                                        <textarea rows="3" class="form-control" name="otrasespecificaciones1" id="otrasespecificaciones1" ></textarea>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Finalidad de activo: </label>
                                        <select name="finalidad1" id="finalidad1" class="form-control">
                                            <option value=""></option>
                                            <option value="Comercialización">Comercialización</option>
                                            <option value="Distribución">Distribución</option>
                                            <option value="General">General</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Entregado de bodega: </label>
                                        <select name="estado1" id="estado1" class="form-control">
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
                                        <select name="agencia1" id="agencias1" class="form-control">
                                            <option value=""></option>
                                            @foreach($agencias as $agencia)
                                                <option value="{{$agencia->id}}">{{$agencia->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Centro costos: </label>
                                        <select  name="cc1" id="ccostos" class="form-control">
                                            @foreach($centrocostos as $cc)
                                                <option value="{{$cc->id}}">{{$cc->nombre}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Bodega: </label>
                                        <select name="bodega1" id="bodega1" class="form-control">
                                            @foreach($bodegas as $bodega)
                                                <option value="{{$bodega->id}}">{{$bodega->codigo}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Departamento: </label>

                                        <select name="departamento1" id="departamento1" class="form-control">
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

                                        <select  name="municipio1" id="municipio1" class="form-control">

                                        </select>

                                    </div>
                                </div>
                            </div>




                            <div class="row" style="margin-top: 5px">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>Justificacion de compra: </label>

                                        <textarea name="justificacion1" id="justificacion1" cols="40" rows="4" class="form-control"></textarea>

                                    </div>
                                </div>

                            </div>


                            <button type="submit" style="border:solid black 1px" id="" class="btn btn-primary  btn-lg btn-outline btn_generarhojaactivo1"  ><i class="fa fa-save"></i> Generar Hoja</button>
                            <button type="button" style="border:solid black 1px" class="btn btn-default  btn-lg btn-outline" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>

                        </form>

                    </div>
                </div>

                <div class="modal-footer">


                </div>
            </div>
        </div>
    </div>


    {{--MODAL PARA SUPERVISORES DE BODEGAS DE ELECTRICISTAS--}}
    <div class="modal inmodal fade" id="modalnuevoactivo2" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Nueva hoja de activo</h5>
                    <h2><i class="fa fa-file-text"></i></h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="frm_adqactivo2" method="post" data-toggle="validator" role="form">

                            <h1>Detalles de Activo</h1>

                            <div class="row">

                                <div class="col-lg-5">
                                    <div class="form-group"><label>Activo: </label>
                                        <input type="text"  name="activo2"    class="form-control" id="activo2">
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="form-group" id="the-basics"><label>Usuario al que se asignara: </label>
                                        <input type="text"  name="usuarioasignado2"  class="form-control typeahead" id="usuarioasignado2">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group" id=""><label>Marca: </label>
                                        <input type="text" class="form-control " id="marca2" name="marca2">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Modelo: </label>
                                        <input type="text"  name="modelo2"    class="form-control" id="modelo2">
                                    </div>
                                </div>
                                <div class="row">



                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Precio: </label>
                                        <input type="text"  step="any" name="precio2"   class="form-control" id="precio2">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group" id=""><label>Color: </label>
                                        <input type="text" class="form-control " id="color2" name="color2">
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Proveedor: </label>
                                        <input type="text" class="form-control" id="proveedor2" name="proveedor2">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>CCF: </label>
                                        <input type="text" class="form-control" id="ccf2" name="ccf2" placeholder="Numero de credito fiscal">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Fecha de compra: </label>
                                        <input type="date" class="form-control" id="fechacompra2" name="fechacompra2" >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>Otras Especificaciones: </label>
                                        <textarea rows="3" class="form-control" name="otrasespecificaciones2" id="otrasespecificaciones2" ></textarea>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Finalidad de activo: </label>
                                        <select name="finalidad2" id="finalidad2" class="form-control">
                                            <option value=""></option>
                                            <option value="Comercialización">Comercialización</option>
                                            <option value="Distribución">Distribución</option>
                                            <option value="General">General</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Entregado de bodega: </label>
                                        <select name="estado2" id="estado2" class="form-control">
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
                                        <select name="agencia2" id="agencias2" class="form-control">
                                            <option value=""></option>
                                            @foreach($agencias as $agencia)
                                                <option value="{{$agencia->id}}">{{$agencia->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Centro costos: </label>
                                        <select  name="cc2" id="ccosto2" class="form-control">
                                            @foreach($centrocostos as $cc)
                                                <option value="{{$cc->id}}">{{$cc->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group"><label>Bodega: </label>
                                        <select name="bodega2" id="bodega2" class="form-control">
                                            @foreach($bodegas as $bodega)
                                                <option value="{{$bodega->id}}">{{$bodega->codigo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group"><label>Departamento: </label>

                                        <select name="departamento2" id="departamento2" class="form-control">
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

                                        <select  name="municipio2" id="municipio2" class="form-control">

                                        </select>

                                    </div>
                                </div>
                            </div>




                            <div class="row" style="margin-top: 5px">
                                <div class="col-lg-8">
                                    <div class="form-group"><label>Justificacion de compra: </label>

                                        <textarea name="justificacion2" id="justificacion2" cols="40" rows="4" class="form-control"></textarea>

                                    </div>
                                </div>

                            </div>


                            <button type="submit" style="border:solid black 1px" id="" class="btn btn-primary  btn-lg btn-outline btn_generarhojaactivo2"  ><i class="fa fa-save"></i> Generar Hoja</button>
                            <button type="button" style="border:solid black 1px" class="btn btn-default  btn-lg btn-outline" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>

                        </form>

                    </div>
                </div>

                <div class="modal-footer">


                </div>
            </div>
        </div>
    </div>



@stop

@section('scripts')

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/localization/messages_es.js"></script>

    <!--funcion typeahead para el autocomplete de los jefes inmediatos-->
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>

    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>

    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

            <script src="../js/plugins/fullcalendar/moment.min.js"></script>

    <!-- funciones para calendario -->
    <script type="text/javascript" src='../js/plugins/datapicker/bootstrap-datepicker.js'></script>
    <!-- funciones para registrar los tiempos de los permisos por medio de la libreria clockpicker-->
    <script type="text/javascript" src='../js/plugins/clockpicker/clockpicker.js'></script>

    <script type="text/javascript" src="../js/funciones/clockanddate.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script type="text/javascript" src="../js/funciones/insumos_movimientos.js"></script>
    <script type="text/javascript" src="../js/funciones/activos.js"></script>




@stop








