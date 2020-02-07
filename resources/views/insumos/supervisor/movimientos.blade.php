@extends('layouts.template')

@section('css')

    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/datapicker/datepicker3.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.css">

    <style>
        body{
            color:black;;
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
    <b>Movimientos</b>
@stop

@section('contenido')



<div class="row" style="margin-top: 50px" id="registrosalida">
    <div class="ibox">

        <div class="ibox-title">
            <h1 class="text-primary"><i class="fa fa-home"></i> {{$centrocostos->centro_costos}}
                <a href="" class="pull-right btn btn-md btn-white" id="actualizarpagina" style="margin-right: 5px"><i class="fa fa-refresh"></i> Actualizar</a>
            </h1>

        </div>

        <div class="ibox-content" id="contenido">
            <br><br>
            <h3>Filtrar por: </h3>
            <button class="btn btn-lg  btn-outline btn-success" id="limpieza" >Limpieza</button>
            <button class="btn btn-lg btn-outline btn-primary" id="oficina" >Oficina</button>
            <button class="btn btn-lg  btn-outline btn-warning" id="papeleria"  >Papeleria</button>
            <br>
            <br>

            <div class="tbl_limpieza hidden">
                <table class="dataTables-example1 tablamovimientos table table-hover table-mail dataTables-example" id="" >
                <thead id="header" class="">
                <tr>
                    <th>Codigo</th>
                    <th>Insumo</th>
                    <th>Descripcion</th>
                    <th>Existencia</th>
                    <th>Accion</th>
                </tr>
                </thead>
                <tbody>
                   @foreach($insumos as $insumo)
                       @if($insumo->categoria=='Limpieza')
                       <tr>
                            <td>{{$insumo->id}}</td>
                            <td><i class="fa fa-cube"></i> {{$insumo->insumo}}</td>
                            <td></td>
                            <td><b>{{$insumo->existencia}}</b></td>
                            <td>
                                <button class="btn btn-xs btn-danger btn_formulariosalida" id="{{$insumo->insumo}}">
                                    <i class="fa fa-download"></i>
                                        Salida
                                </button>

                                <button type="button" data-toggle="modal" data-target="#modaldetallesins" class="btn btn-xs btn-warning detallesinsumo " id="{{$insumo->id}}">
                                    <i class="fa fa-eye"></i>
                                        Detalles
                                </button>

                            </td>
                       </tr>
                       @endif
                       @endforeach
                </tbody>
                <tfoot id="footer" class="hidden">
                <tr>
                    <th></th>
                    <th>Insumo</th>
                    <th>Descripcion</th>
                    <th>Existencia</th>
                    <th>Accion</th>
                </tr>
                </tfoot>
            </table>
            </div>

            <div class="tbl_papeleria hidden">
                <table class="dataTables-example1 tablamovimientos table table-hover table-mail dataTables-example" id="" >
                <thead id="header" class="">
                <tr>
                    <th>Codigo</th>
                    <th>Insumo</th>
                    <th>Descripcion</th>
                    <th>Existencia</th>
                    <th>Accion</th>
                </tr>
                </thead>
                <tbody>
                @foreach($insumos as $insumo)
                    @if($insumo->categoria=='Papeleria')
                    <tr>
                        <td>{{$insumo->id}}</td>
                        <td><i class="fa fa-cube"></i> {{$insumo->insumo}}</td>
                        <td></td>
                        <td><b>{{$insumo->existencia}}</b></td>
                        <td>
                            <button class="btn btn-xs btn-danger btn_formulariosalida" id="{{$insumo->insumo}}">
                                <i class="fa fa-download"></i>
                                Salida
                            </button>

                            <button type="button" data-toggle="modal" data-target="#modaldetallesins" class="btn btn-xs btn-warning detallesinsumo " id="{{$insumo->id}}">
                                <i class="fa fa-eye"></i>
                                Detalles
                            </button>

                        </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
                <tfoot id="footer" class="hidden">
                <tr>
                    <th></th>
                    <th>Insumo</th>
                    <th>Descripcion</th>
                    <th>Existencia</th>
                    <th>Accion</th>
                </tr>
                </tfoot>
            </table>
            </div>

            <div class="tbl_oficina hidden">
                <table class="dataTables-example1  tablamovimientos table table-hover table-mail dataTables-example" id="tbl_activos" >
                <thead id="header" class="">
                <tr>
                    <th class="text-center" style="border: solid 1px grey;">ID</th>
                    <th class="text-center" style="border: solid 1px grey;">Activo</th>
                    <th class="text-center" style="border: solid 1px grey;">Empleado</th>
                    <th class="text-center" style="border: solid 1px grey;">Cod. VNR</th>
                    <th class="text-center" style="border: solid 1px grey;">Cod. COMANDA</th>
                    <th class="text-center" style="border: solid 1px grey;">Color</th>
                    <th class="text-center" style="border: solid 1px grey;">Marca</th>
                    <th class="text-center" style="border: solid 1px grey;">Modelo</th>
                    <th class="text-center" style="border: solid 1px grey;">Ubicacion</th>
                    <th class="text-center" style="border: solid 1px grey;"></th>
                    <th class="text-center" style="border: solid 1px grey;"></th>
                    <th class="text-center" style="border: solid 1px grey;"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($activos as $a)
                    @if($a->estado_activo!=4)
                    <tr style="">
                        <td style="border: solid 1px grey; "><b>{{$a->id}}</b></td>
                        <td style="border: solid 1px grey; "><b>{{$a->tipo_activo}}</b></td>
                        <td style="border: solid 1px grey; "><b>{{$a->nombre}} {{$a->apellido}}</b></td>
                        <td class="text-center" style="border: solid 1px grey; ">{{$a->codigo_vnr}}</td>
                        <td class="text-center" style="border: solid 1px grey; ">{{$a->codigo_comanda}}</td>
                        <td class="text-center" style="border: solid 1px grey; ">{{$a->color}}</td>
                        <td class="text-center" style="border: solid 1px grey;">{{$a->marca}}</td>
                        <td class="text-center" style="border: solid 1px grey;">{{$a->modelo}}</td>
                        @if($a->ubicacion)
                            <td class="text-center" style="border: solid 1px grey;">{{$a->ubicacion}}</td>
                        @else
                            <td class="text-center" style="border: solid 1px grey;">Oficina</td>
                        @endif


                        <td style="border: solid 1px black;" class="text-center">
                            @if($a->estado_activo==2)
                            <button id="{{$a->id}}" data-toggle="modal" data-target="#modaltraslado" class="btn btn-default btn-md traslado" style="border:solid 1px black; margin-left: 5px" type="button"><i class="fa fa-paper-plane"></i> Traslado</button>
                            @endif
                        </td>
                        <td style="border: solid 1px black;" class="text-center">
                            @if($a->estado_activo==2)
                            <button id="{{$a->id}}" data-toggle="modal" data-target="#motivoba_modal" class="btn btn-default btn-md iniciarbaja" style="border:solid 1px black; margin-left: 5px" type="button"><i class="fa fa-download"></i> Baja</button>
                            @endif
                        </td>

                        <td style="border: solid 1px black;" class="text-center">
                        @if($a->estado_activo==3)
                                <button id="{{$a->id}}"  class="btn btn-outline btn-primary btn-md pull-right hojaactivo" style="border:solid 1px black; margin-left: 5px" type="button"><i class="fa fa-plus-circle"></i> Generar H.A</button>
                            @endif
                        </td>



                    </tr>
                    @endif
                @endforeach
                </tbody>
                <tfoot id="footer" class="hidden">
                <tr>
                    <th></th>
                    <th>Insumo</th>
                    <th>Descripcion</th>
                    <th>Existencia</th>
                    <th>Existencia</th>
                    <th>Existencia</th>
                    <th>Existencia</th>
                    <th>Accion</th>

                </tr>
                </tfoot>
            </table>
            </div>

            {{--DETALLES DE HOJAS DE ACTIVOS PARA CENTROS DE COSTOS--}}
            <div class="detallesHA hidden">
                <br><br>
                <div class="col-lg-4" style="background-color: greenyellow; color: black;"><h4><i class="fa fa-info-circle"></i> En proceso de baja por contabilidad</h4></div>
                <br><br><br>
                <table class="dataTables-example1 table table-hover table-mail dataTables-example" id="tabladetalles" >
                    <thead style="background: lightgrey;" id="header" class="">
                    <tr>
                        <th class="text-center" style="border: solid 1px black;" >Hoja</th>
                        <th class="text-center" style="border: solid 1px black;" >Auxiliar</th>
                        <th class="text-center" style="border: solid 1px black;" >Insumo</th>
                        <th class="text-center" style="border: solid 1px black;" >Usuario Asignado</th>
                        <th class="text-center" style="border: solid 1px black;" >Estado</th>
                        <th class="text-center" style="border: solid 1px black;" ></th>
                        <th class="text-center" style="border: solid 1px black;" ></th>
                        <th class="text-center" style="border: solid 1px black;" ></th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($detalles as $detalle)
                        @if($detalle->estado_HA!=3)
                            @if($detalle->estado_HA==1)
                                <tr style="background: yellowgreen;">
                                    <td>{{$detalle->id}}</td>
                                    <td>{{$detalle->cod_aux}}</td>
                                    <td>{{$detalle->insumo}}</td>
                                    <td>{{$detalle->electricista}}</td>
                                    <td>{{$detalle->estado}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                </tr>
                            @else
                                <tr>
                                    <td>{{$detalle->id}}</td>
                                    <td>{{$detalle->cod_aux}}</td>
                                    <td>{{$detalle->insumo}}</td>
                                    <td>{{$detalle->electricista}}</td>
                                    <td>{{$detalle->estado}}</td>
                                    <td><button style="border:solid 1px black" class="btn btn-default btn-md btn_editaractivo" id="{{$detalle->cod_aux}}"><i class="fa fa-edit"></i> Editar</button></td>
                                    <td><a style="border:solid 1px black;" href="imprimirhojaactivo?id={{$detalle->hoja_activo_id}}&&aux={{$detalle->cod_aux}}" class="btn btn-default btn-md btn_imprimirhoja"><i class="fa fa-file-pdf-o"></i> Imprimir</a></td>
                                    @if($detalle->estado=='Arruinado' && $detalle->estadoha!='Proceso de baja')
                                        <td>
                                            <button style="border:solid 1px black" class="btn btn-default btn-md iniciarbaja " data-toggle="modal" data-target="#motivoba_modal" id="{{$detalle->cod_aux}}">
                                                <i class="fa fa-download"></i> Iniciar proceso de baja
                                            </button>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif

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
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>





        </div>



        <div class="ibox-footer hidden " id="divedicionactivo">

            <h1 style="margin-left:10px;margin-bottom: 30px">Edicion de activo <small></small></h1>
            <form id="">

                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group"><label class="col-lg-2 control-label">Insumo: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="insumo1" readonly="true">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group"><label class="col-lg-2 control-label">Estado: </label>
                            <div class="col-lg-8">
                                <select name="" id="estados" class="form-control">
                                    <option value="">seleccione un estado...</option>
                                    @foreach($estados as $estado)
                                        <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <button style="margin-right: 5px" type="button" class="btn btn-primary pull-right btn_guardaredicion"><i class="fa fa-save"></i> Guardar edicion</button>

                </div>
            </form>

        </div>

        </div>

        <div class="ibox-footer hidden" id="divformsalida">

                <span class="label label-info"><i class="fa fa-warning"></i> Rellene los siguientes campos para generar una salida de Insumo</span>


            <div class="row" style="margin-top: 25px">
                <form class="form-horizontal" id="frm_express">

                    <div class="form-group"><label class="col-lg-2 control-label">Insumo</label>

                        <div class="col-lg-5" >
                            <input type="text" id="insumosalida" readonly="readonly" class="form-control">
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Cantidad</label>
                        <div class="col-lg-2">
                            <input type="number" min="1" id="cantidadsalida" class="form-control">
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Asignar a:</label>
                        <div class="col-lg-5" id="the-basics">
                            <input type="text"  id="usuarioasignado" class="form-control typeahead">
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Comentario:</label>
                        <div class="col-lg-5" id="the-basics">
                            <textarea cols="8" id="descripcion" rows="4" class="form-control"></textarea>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-sm btn-success" id="btn_generarsalida" type="button">Generar salida</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="ibox-footer hidden" id="divhojaactivo">
            <div class="alert alert-warning alert-dismissable"><i class="fa fa-info-circle"></i> Recuerde que todo activo debe cumplir con  las siguientes dos condiciones:
                <br><br>
                <ul>
                    <li><b>El insumo debera ser mayor a $50.00</b></li>
                    <li><b>Y su vida util debe estar comprendida en mas de 2 años</b></li>
                </ul>
            </div>
            <br>
            <form id="frm_updateactivo" method="post" data-toggle="validator" role="form">

                <h1>Detalles de Activo</h1>
                <div class="row">
                    <div class="col-lg-4">
                        <div id="the-basics" class="form-group"><label>Responsable de activo: </label>
                            <input type="text"  class="form-control typeahead" name="responsable" id="responsable" >
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group" id="the-basics1"><label>Activo: </label>
                            <input readonly="readonly" type="text" class="form-control typeahead1" id="insumo" name="insumo">
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
                        <div class="form-group"><label>Proveedor: </label>
                            <input type="text" class="form-control" id="proveedor" name="proveedor">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group"><label>CCF: </label>
                            <input type="text" class="form-control" id="ccf" name="ccf" placeholder="Numero de credito fiscal">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group"><label>Fecha de compra: </label>
                            <input type="text" class="form-control" id="fechacompra" name="fechacompra" placeholder="Numero de credito fiscal">
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
                        <div class="form-group"><label>Departamento: </label>

                            <select name="departamento" id="departamento" class="form-control">
                                <option value=""></option>
                                @foreach($departamentos as $departamento)
                                    <option value="{{$departamento->ID}}">{{$departamento->DepName}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group"><label>Municipio: </label>

                            <select  name="municipio" id="municipio" class="form-control">

                            </select>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group"><label>Departamento Edesal: </label>

                            <select  name="deptoedesal" id="deptoedesal" class="form-control">
                                <option value=""></option>
                                @foreach($areas as $area)
                                    <option value="{{$area->id}}">{{$area->nombre}}</option>
                                @endforeach
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


                <button type="submit" style="border:solid black 1px" id="" class="btn btn-primary  btn-lg btn-outline"  ><i class="fa fa-save"></i> Generar Hoja</button>
                <button type="button" style="border:solid black 1px" class="btn btn-default  btn-lg btn-outline" id="" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>

            </form>

        </div>


    </div>


    {{--PROCESO DE BAJA A  INICIAR--}}
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




    {{--Modal para detalles del insumo utilizado--}}
    <div class="modal inmodal fade" id="modaldetallesins" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Detalles de insumo</h4>
                <h2><i class="fa fa-file-text"></i></h2>

            </div>
            <div class="modal-body">
                <form id="" class="form-horizontal">

                    <div class="form-group"><label class="col-lg-2 control-label">Insumo: </label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" id="insumodetalles" readonly="true">
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Fechas: </label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="fecha1" id="fecha1" >
                        </div>
                    </div>
                    <br><br>
                    <div id="div_tabla_detalles" class="hidden">

                    </div>



                    <div class="row">
                        <button type="button"  class="btn btn-primary btn-md pull-right btn-md" id="btn_verconsumos" ><i class="fa fa-save"></i> Ver consumos</button>
                        <a type="button"  class="btn btn-primary btn-md pull-right btn-md hidden" id="btn_generarpdfconsumos" ><i class="fa fa-file-pdf-o"></i> Generar PDF</a>
                        <button style="margin-right: 5px"  type="button" class="btn btn-danger pull-right btn-md" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                    </div>
                </form>
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


@stop

@section('scripts')

    <script type="text/javascript" src="../js/plugins/moment/moment.js"></script>


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

    <!-- funciones para calendario -->
    <script type="text/javascript" src='../js/plugins/datapicker/bootstrap-datepicker.js'></script>
    <!-- funciones para registrar los tiempos de los permisos por medio de la libreria clockpicker-->
    <script type="text/javascript" src='../js/plugins/clockpicker/clockpicker.js'></script>

    <script type="text/javascript" src="../js/funciones/clockanddate.js"></script>

    <script type="text/javascript" src="../js/daterangepicker.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script type="text/javascript" src="../js/funciones/insumos_movimientos.js"></script>
    <script type="text/javascript" src="../js/funciones/activos.js"></script>



@stop





