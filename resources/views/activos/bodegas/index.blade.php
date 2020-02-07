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

            <div class="ibox-title">
                <h1 class="text-primary"><i class="fa fa-home"></i> {{$bodega->codigo}}
                    <a   class="pull-right btn btn-lg btn-default rpt_dispoherram" id="{{$bodega->id}}"  style="margin-right: 5px; border:solid 1px black; color: black;"><i class="fa fa-file-pdf-o"></i> Reporte Disponibilidad</a>
                    <button type="button" data-toggle="modal" data-target="#modalnuevoactivo" class="pull-right btn btn-lg btn-default hojaactivo"  style="margin-right: 5px; border:solid 1px black; color: black;"><i class="fa fa-plus"></i> Nueva hoja de activo</button>
                    <a   class="pull-right btn btn-lg btn-default" id="detallesdiv" style="margin-right: 5px; border:solid 1px black; color: black;"><i class="fa fa-file-text"></i> Ver Hojas de activos</a>
                </h1>
                <br><br><br><br>
                @if($suma->suma>0)
                    <h2><i class="fa fa-info-circle"></i> Existen <b class="text-danger">{{$suma->suma}}</b> herramienta(s) sin hoja de activo</h2>
                @endif
            </div>




            <div class="ibox-content">
                <table class="dataTables-example1 table table-hover table-mail dataTables-example tablamovimientos" id="" style="color: black;">
                    <thead id="header" class="">
                    <tr style="background-color: lightgrey;">

                        <th class="text-center" style="border:  solid black 1px;">Activo</th>
                        <th class="text-center" style="border:  solid black 1px;">Auxiliar</th>
                        <th class="text-center" style="border:  solid black 1px;">Insumo</th>
                        <th class="text-center" style="border:  solid black 1px;">Existencia</th>
                        <th class="text-center" style="border:  solid black 1px;">Estado</th>
                        <th class="text-center" style="border:  solid black 1px;">Accion</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($insumos as $insumo)
                        @if($insumo->hoja=='')
                            <tr>
                                <td style="border:  solid black 1px;" class="text-center">{{$insumo->activo}}</td>
                                <td class="text-center" style="border:  solid black 1px;">{{$insumo->codigo_aux}}</td>
                                <td style="border:  solid black 1px;"><i class="fa fa-cube"></i> {{$insumo->insumo}}</td>
                                <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->existencia}}</b></td>
                                <td class="text-center" style="border:  solid black 1px;">{{$insumo->estado}}</td>
                                <td class="text-center" style="border:  solid black 1px;">
                                    @if($insumo->activo=='Si')
                                        <button class="btn btn-xs btn-success hojaactivo" id="{{$insumo->codigo_aux}}">
                                            <i class="fa fa-download"></i>
                                            Asignar
                                        </button>
                                    @elseif($insumo->activo=='No')
                                    @endif
                                </td>
                            </tr>
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
                <h1 style="margin-left:10px;margin-bottom: 30px">Adquisicion de activo <br><span class="label label-info">Rellenar los siguientes campos es obligatorio</span></h1>
                <form id="frm_adqactivo" data-toggle="validator" role="form">

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group"><label class="col-lg-2 control-label">Insumo: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="insumo" name="insumo" readonly="true">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group"><label class="col-lg-2 control-label">Cantidad: </label>
                                <div class="col-lg-8">
                                    <input type="number" min="0" name="cantidad" value="1" readonly="readonly"  class="form-control" id="cantidad">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group"><label class="col-lg-2 control-label">Asignarse a: </label>
                                <div class="col-lg-8">
                                    <select name="electricista" id="electricista" class="form-control">
                                        <option value=""></option>
                                        @foreach($electricistas as $elec)
                                            <option value="{{$elec->id}}">{{$elec->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group"><label class="col-lg-2 control-label">Centro costos: </label>
                                <div class="col-lg-8">
                                    <select name="cc" id="ccostos" class="form-control">
                                        <option value=""></option>
                                        @foreach($centrocostos as $cc)
                                            <option value="{{$cc->id}}">{{$cc->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group"><label class="col-lg-2 control-label">Agencia: </label>
                                <div class="col-lg-8">
                                    <select name="agencia" id="agencias" class="form-control">
                                        <option value=""></option>
                                        @foreach($agencias as $agencia)
                                            <option value="{{$agencia->id}}">{{$agencia->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group"><label class="col-lg-2 control-label">Bodega: </label>
                                <div class="col-lg-8">
                                    <select name="bodega" id="bodega" class="form-control">
                                        <option readonly="readonly" value="{{$bodega->id}}">{{$bodega->codigo}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group"><label class="col-lg-2 control-label">Departamento: </label>
                                <div class="col-lg-8">
                                    <select name="departamento" id="departamento" class="form-control">
                                        <option value=""></option>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{$departamento->ID}}">{{$departamento->DepName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group"><label class="col-lg-2 control-label">Munic..: </label>
                                <div class="col-lg-8">
                                    <select  name="municipio" id="municipio" class="form-control">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px">
                        <div class="col-lg-8">
                            <div class="form-group"><label class="col-lg-2 control-label">Justificacion: </label>
                                <div class="col-lg-10">
                                    <textarea name="justificacion" id="justificacion" cols="30" rows="6" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group"><label class="col-lg-2 control-label">Estado: </label>
                                <div class="col-lg-8">
                                    <select name="estadoinsumo" id="estadoinsumo" class="form-control">
                                        <option value="1">Buena condicion</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{--
                          <a href='imprimirhojaactivo?occ={{$orden->idordencompra}}' class="btn btn-warning btn-md pull-right hidden" id="btn_imprimirhoja" style="margin-right: 25px; margin-top: 40px"><i class="fa fa-print"></i> Imprimir hoja</a>
                        --}}
                        <button type="submit" class="btn btn-success btn-md pull-right " id="btn_guardarhojaactivo" style="margin-right: 25px; margin-top: 40px"><i class="fa fa-save"></i> Generar Hoja</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="ibox-footer hidden">
            <div class="ibox-footer " id="divhojaactivo">
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
                                <input type="date" class="form-control" id="fechacompra" name="fechacompra">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div id="the-basics" class="form-group"><label>Responsable de activo: </label>
                                <input type="text"  class="form-control typeahead" name="responsable" id="responsable" >
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
                                    @foreach($centrocostos as $cc)
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
    </div>



    {{--DIV PARA MOSTRAR LOS DETALLES DE LAS HOJAS DE ACTIVOS--}}
    <div class="row hidden" style="margin-top: 50px" id="detallesbodega">
        <div class="ibox">

            <div class="ibox-title">
                <h1 class="text-primary"><i class="fa fa-home"></i> Hojas de activos
                    <button class="btn btn-danger pull-right" onclick="location.reload()"><i class="fa fa-arrow-left"></i> </button>

                </h1>


            </div>


            <div class="ibox-content">
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
                        <th class="text-center" style="border: solid 1px black;" >Editar</th>
                        <th class="text-center" style="border: solid 1px black;" >Imprimir</th>
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
                                    <td><button style="border: 1px solid black" class="btn btn-default btn-md btn_editaractivo" id="{{$detalle->cod_aux}}"><i class="fa fa-edit"></i> Editar</button></td>
                                    <td><a style="border: 1px solid black" href="imprimirhojaactivo?id={{$detalle->hoja_activo_id}}&&aux={{$detalle->cod_aux}}" class="btn btn-default btn-md btn_imprimirhoja"><i class="fa fa-file-pdf-o"></i> Imprimir</a></td>
                                    @if($detalle->estado=='Arruinado' && $detalle->estadoha!='Proceso de baja')
                                        <td>
                                            <button style="border: solid 1px  black;" class="btn btn-default btn-md iniciarbaja " data-toggle="modal" data-target="#motivoba_modal" id="{{$detalle->cod_aux}}">
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

            <div class="ibox-footer hidden " id="divedicionactivo">

                <h1 style="margin-left:10px;margin-bottom: 30px">Edicion de activo <small></small></h1>
                <form id="frm_adqactivo">

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
    </div>






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
                    <button type="button" class="btn btn-success btn-sm btn_bajaactivo" id="" ><i class="fa fa-download"></i> Imprimir Hoja</button>
                </div>
            </div>
        </div>
    </div>




    <div class="form-group hidden"><label class="col-lg-2 control-label">Fechas: </label>
        <div class="col-lg-7">
            <input type="text" class="form-control" name="fecha1" id="fecha1" >
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
                                <div class="col-lg-8">
                                    <div class="form-group" id="the-basics1"><label>Activo: </label>
                                        <input type="text" class="form-control typeahead1" id="insumo1" name="insumo1">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group"><label>Cantidad: </label>
                                        <input type="number" min="0" name="cantidad1" value="1" readonly="readonly"  class="form-control" id="cantidad1">
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
                                        <input type="date" class="form-control" id="fechacompra1" name="fechacompra1" placeholder="Numero de credito fiscal">
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
                                        <select name="cc1" id="ccostos" class="form-control">
                                            <option value=""></option>
                                            @foreach($centrocostos as $cc)
                                                <option value="{{$cc->id}}">{{$cc->id}}. {{$cc->nombre}}</option>
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
                                            <option value=""></option>
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

    <!-- funciones para calendario -->
    <script type="text/javascript" src='../js/plugins/datapicker/bootstrap-datepicker.js'></script>
    <!-- funciones para registrar los tiempos de los permisos por medio de la libreria clockpicker-->
    <script type="text/javascript" src='../js/plugins/clockpicker/clockpicker.js'></script>

    <script type="text/javascript" src="../js/funciones/clockanddate.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script type="text/javascript" src="../js/funciones/insumos_movimientos.js"></script>
    <script type="text/javascript" src="../js/funciones/activos.js"></script>




@stop








