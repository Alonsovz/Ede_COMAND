@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@stop

@section('enunciado')
    Insumos
@stop

@section('modulo')
    Insumos
@stop

@section('submodulo')
    <b>Ordenes</b>
@stop

@section('contenido')
    <div class="row">
      @if($orden->ordenes_estado_id!=5)
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="ibox">
                        <div class="ibox-content">
                            <input type="text" class="hidden" id="centrocostos" value="{{$orden->centrocostos}}">
                            <div class="" style="padding: 20px">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="m-b-md">

                                            <h1 style="margin-bottom: 40px"><i class="fa fa-shopping-cart"></i> Administracion de orden <b class="text-success"> N° {{$orden->idordencompra}}</b></h1>
                                            <input type="text" class="hidden" id="ordencompra" value="{{$orden->idordencompra}}">
                                        </div>
                                        <dl class="dl-horizontal">
                                            <dt>Estado:</dt>
                                            <dd>
                                                @if($orden->estado=='Aprobado')
                                                    <td><span class="label label-info bg-info pull-center">Aprobada</span></td>
                                                @elseif($orden->estado=='En progreso')
                                                    <td><span class="label label-warning bg-warning pull-center">En progreso</span></td>
                                                @elseif($orden->estado=='Cerrado')
                                                    <td><span class="label label-danger bg-danger pull-center">Cerrada</span></td>
                                                @endif
                                            </dd>

                                            <dt>Solicitante</dt>
                                            <dd>
                                                <span class="text-success">{{$orden->nombresolicitante}} {{$orden->apellidosolicitante}}</span>
                                            </dd>

                                            <dt>Proveedor:</dt>
                                            <dd>
                                                <span class="text-danger">{{$orden->proveedor}}</span>
                                            </dd>

                                            <dt>Requisicion Vinculada:</dt>
                                            <dd>
                                                <span class="">{{$orden->id}}</span>
                                            </dd>


                                            <dt>Fecha de creacion:</dt>
                                            <dd>
                                        <span class="text-"><?php
                                            $fecha = date_create($orden->fecha_creacion);
                                            echo date_format($fecha,'d/m/Y');
                                            ?>
                                        </span>
                                            </dd>

                                            <dt>Fecha de entrega:</dt>
                                            <dd>
                                        <span class="text-">
                                            <?php
                                            $fecha = date_create($orden->fecha_entrega);
                                            echo date_format($fecha,'d/m/Y');
                                            ?>
                                        </span>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>

                                <hr>
                                <br><br>
                                @if($orden->estado!='Cerrado')
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Credito Fiscal:</label>
                                                <input type="text" id="ccf" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group" id="">
                                                <label>Proveedor: </label>
                                                <div class="input-group col-lg-10 " id="the-basics1">
                                                    <select name="" id="proveedor" class="form-control">
                                                        <option value="">proveedores...</option>
                                                        @foreach($proveedores as $proveedor)
                                                            <option value="{{$proveedor->id}}">{{$proveedor->nombreentidad}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input  type="text" id="proveedor" placeholder="digite el nombre de proveedor" name="" class="hidden form-control typeahead " value="">
                                                </div>
                                            </div>
                                            <div class="form-group" id="">

                                                <div class="input-group col-lg-10 " id="the-basics1">
                                                    <button type="button" data-toggle="modal" data-target="#modal_nuevoproveedor" class="btn btn-xs btn-warning"><i class="fa fa-plus-circle"></i> Agregar proveedor</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Fecha de compra</label>
                                            <div class='input-group' id=''>
                                                <input id="fechacompra" type='date' class="form-control" />
                                        
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>




                        </div>

                        <div class="ibox-footer">
                            <div class="row" id="divdetallesorden">
                                <div class="col-lg-12">
                                    <table style="color:black" class="table  table-bordered"   id="">
                                        <thead class="">
                                        <tr>

                                            <th class="text-center" style="width: 10px; border: 0.5px solid black">Codigo</th>
                                            <th  style="width: 200px; border: 0.5px solid black">Insumo</th>
                                            <th class="text-center" style="width: 10px; border: 0.5px solid black">Cantidad</th>
                                            <th style="width: 10px; border: 0.5px solid black" class="text-center">Precio apro</th>
                                            <th style="width: 10px; border: 0.5px solid black" class="text-center">Precio compra (sin IVA)</th>
                                            <th style="width: 60px; border: 0.5px solid black" class="text-center">Marca</th>
                                            <th style="width: 60px; border: 0.5px solid black" class="text-center">Modelo</th>
                                            <th style="width: 60px; border: 0.5px solid black" class="text-center">Serie</th>
                                        </tr>
                                        </thead>
                                        <tbody id="">

                                        @foreach($detalles as $detalle)
                                            <input type="text" class="hidden" id="tiporequisicion" value="{{$detalle->tiporequisicion}}">
                                            <tr id="{{$detalle->codinsumo}}">

                                                <td style="border:solid black 0.5px" class="text-center"><input type="text" value="{{$detalle->codinsumo}}" class="form-control codinsumo" readonly="readonly"></td>
                                                <td style="border:solid black 0.5px"><input type="text" value="{{$detalle->insumo}}" class="form-control insumo " readonly="readonly"></td>
                                                <td style="border:solid black 0.5px" class="text-center"><input type="number" min="0" value="{{$detalle->cantidad}}" class="form-control cantidad" readonly="readonly"></td>
                                                <td style="border:solid black 0.5px" class="text-right"><input type="text" value="{{$detalle->precio}}" class="form-control precio" readonly="readonly"></td>
                                                @if($orden->estado=='Cerrado')
                                                    <td style="border:solid black 0.5px" class="text-right"><input type="text" readonly="true" value="{{$detalle->preciocompra}}"  class="form-control preciocompra" ></td>
                                                    <td style="border:solid black 0.5px"></td>
                                                    <td style="border:solid black 0.5px"></td>
                                                    <td style="border:solid black 0.5px"></td>
                                                @else

                                                    <td style="border:solid black 0.5px" class="text-right"><input type="text"  class="form-control preciocompra" ></td>
                                                    <td style="border:solid black 0.5px" class="text-right"><input type="text"  class="form-control marca" ></td>
                                                    <td style="border:solid black 0.5px" class="text-right"><input type="text"  class="form-control modelo" ></td>
                                                    <td style="border:solid black 0.5px" class="text-right"><input type="text"  class="form-control serie" ></td>

                                                @endif

                                            </tr>
                                        @endforeach

                                        </tbody>
                                        <tfoot style="background-color: lightblue;font-weight: bold">
                                        <tr>

                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px" class="text-right"><small><b>SUB TOTAL</b></small></td>
                                            <td style="border:solid black 0.5px" id="subtotal"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                        </tr>
                                        <tr>

                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px" class="text-right"><small><b>IVA</b></small></td>
                                            <td style="border:solid black 0.5px" id="iva"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                        </tr>
                                        <tr>

                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px" class="text-right"><small><b>VALOR TOTAL</b></small></td>
                                            <td style="border:solid black 0.5px" id="total"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <a href="ord_bandejaadmin"  class="pull-left btn btn-danger btn-md" style="margin-left: 15px" ><i class="fa fa-arrow-left"></i> Ordenes</a>
                                <div class="row">
                                    @if($orden->estado=='Aprobado')
                                        @if($orden->tipo_requisicion_id==1 || $orden->tipo_requisicion_id==3 || $orden->tipo_requisicion_id==4)
                                            <button style="margin-right: 30px" type="button" class="btn btn-success btn-lg btn-outline  pull-right" id="btn_descargacc" data-dismiss="modal">
                                                <i class="fa fa-download"></i> Descargar en CC
                                            </button>

                                        @elseif($orden->tipo_requisicion_id==2)
                                            <button style="margin-right: 30px" type="button" class="btn btn-success btn-lg btn-outline pull-right  " id="btn_descargabodega" data-dismiss="modal">
                                                <i class="fa fa-download"></i> Descargar en Bodega
                                            </button>
                                        @endif
                                    @endif
                                </div>
                                <div style="margin-left: 10px" id="barra_progreso" class="hidden">
                                    <h3>Descargando...</h3>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="83"
                                             aria-valuemin="0" aria-valuemax="100" style="width:83%">
                                            80%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row hidden" id="divhojaactivo">

                                <h1 style="margin-left:10px;margin-bottom: 30px">Adquisicion de activo <small><span class="label label-info">Rellenar los siguientes campos es obligatorio</span></small></h1>
                                <form id="frm_adqactivo">
                                    <div class="row">

                                        <div class="col-lg-8">
                                            <div class="form-group"><label class="col-lg-2 control-label">Asignarse a: </label>
                                                <div class="col-lg-8">
                                                    <select name="" id="electricista" class="form-control">
                                                        <option value="">Electricista...</option>
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
                                                    <select name="" id="ccostos" class="form-control">
                                                        <option value="">Centro costos...</option>
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
                                                    <select name="" id="agencia" class="form-control">
                                                        <option value="">Agencias...</option>
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
                                                    <select name="" id="bodega" class="form-control">
                                                        <option value="">Bodegas...</option>
                                                        @foreach($bodegas as $bodega)
                                                            <option value="{{$bodega->id}}">{{$bodega->codigo}}</option>
                                                        @endforeach
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
                                                    <select name="" id="departamento" class="form-control">
                                                        <option value="">Departamento...</option>
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
                                                    <select  name="" id="municipio" class="form-control">
                                                        <option value="">Municipios...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-lg-8">
                                            <div class="form-group"><label class="col-lg-2 control-label">Justificacion: </label>
                                                <div class="col-lg-10">
                                                    <textarea name="" id="justificacion" cols="30" rows="6" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group"><label class="col-lg-2 control-label">Estado: </label>
                                                <div class="col-lg-8">
                                                    <select name="" id="estadoinsumo" class="form-control">
                                                        <option value="">seleccione...</option>
                                                        <option value="1">Buena condicion</option>
                                                        <option value="2">Deteriorado</option>
                                                        <option value="3">Arruinado</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <a href='imprimirhojaactivo?occ={{$orden->idordencompra}}' class="btn btn-warning btn-md pull-right hidden" id="btn_imprimirhoja" style="margin-right: 25px; margin-top: 40px"><i class="fa fa-print"></i> Imprimir hoja</a>

                                        <button type="button" class="btn btn-success btn-md pull-right" id="btn_guardarhojaactivo" style="margin-right: 25px; margin-top: 40px"><i class="fa fa-download"></i> Guardar y descargar</button>
                                        <a href="ord_bandejaadmin" class="btn btn-md btn-danger pull-left" style="margin-left: 20px; margin-top: 40px"><i class="fa fa-arrow-left"></i> Bandeja</a>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        @elseif($orden->ordenes_estado_id==5)
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="ibox">
                        <div class="ibox-content">
                            <input type="text" class="hidden" id="centrocostos" value="{{$orden->centrocostos}}">
                            <div class="" style="padding: 20px">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="m-b-md">

                                            <h1 style="margin-bottom: 40px"><i class="fa fa-shopping-cart"></i> Orden re-aperturada<b class="text-success"> N° {{$orden->idordencompra}}</b></h1>
                                            <input type="text" class="hidden" id="ordencompra" value="{{$orden->idordencompra}}">
                                        </div>
                                        <dl class="dl-horizontal">
                                            <dt>Estado:</dt>
                                            <dd>
                                                @if($orden->estado=='Aprobado')
                                                    <td><span class="label label-info bg-info pull-center">Aprobada</span></td>
                                                @elseif($orden->estado=='En progreso')
                                                    <td><span class="label label-warning bg-warning pull-center">En progreso</span></td>
                                                @elseif($orden->estado=='Cerrado')
                                                    <td><span class="label label-danger bg-danger pull-center">Cerrada</span></td>
                                                @endif
                                            </dd>

                                            <dt>Solicitante</dt>
                                            <dd>
                                                <span class="text-success">{{$orden->nombresolicitante}} {{$orden->apellidosolicitante}}</span>
                                            </dd>

                                            <dt>Proveedor:</dt>
                                            <dd>
                                                <span class="text-danger">{{$orden->proveedor}}</span>
                                            </dd>

                                            <dt>Requisicion Vinculada:</dt>
                                            <dd>
                                                <span class="">{{$orden->id}}</span>
                                            </dd>


                                            <dt>Fecha de creacion:</dt>
                                            <dd>
                                        <span class="text-"><?php
                                            $fecha = date_create($orden->fecha_creacion);
                                            echo date_format($fecha,'d/m/Y');
                                            ?>
                                        </span>
                                            </dd>

                                            <dt>Fecha de entrega:</dt>
                                            <dd>
                                        <span class="text-">
                                            <?php
                                            $fecha = date_create($orden->fecha_entrega);
                                            echo date_format($fecha,'d/m/Y');
                                            ?>
                                        </span>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>

                                <hr>
                                <br><br>
                                @if($orden->estado!='Cerrado')
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Credito Fiscal:</label>
                                                <input type="text" id="ccf" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group" id="">
                                                <label>Proveedor: </label>
                                                <div class="input-group col-lg-10 " id="the-basics1">
                                                    <select name="" id="proveedor" class="form-control">
                                                        <option value="">proveedores...</option>
                                                        @foreach($proveedores as $proveedor)
                                                            <option value="{{$proveedor->id}}">{{$proveedor->nombreentidad}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input  type="text" id="proveedor" placeholder="digite el nombre de proveedor" name="" class="hidden form-control typeahead " value="">
                                                </div>
                                            </div>
                                            <div class="form-group" id="">

                                                <div class="input-group col-lg-10 " id="the-basics1">
                                                    <button type="button" data-toggle="modal" data-target="#modal_nuevoproveedor" class="btn btn-xs btn-warning"><i class="fa fa-plus-circle"></i> Agregar proveedor</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Fecha de compra</label>
                                            <div class='input-group date' id='datetimepicker1'>
                                                <input id="fechacompra" type='text' class="form-control" />
                                                <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>




                        </div>

                        <div class="ibox-footer">
                            <div class="row" id="divdetallesorden">
                                <div class="col-lg-12">
                                    <table style="color:black" class="table  table-bordered"   id="">
                                        <thead class="">
                                        <tr>

                                            <th class="text-center" style="width: 10px; border: 0.5px solid black">Codigo</th>
                                            <th  style="width: 200px; border: 0.5px solid black">Insumo</th>
                                            <th class="text-center" style="width: 10px; border: 0.5px solid black">Cantidad</th>
                                            <th style="width: 10px; border: 0.5px solid black" class="text-center">Precio apro</th>
                                            <th style="width: 10px; border: 0.5px solid black" class="text-center">Precio compra (sin IVA)</th>
                                            <th style="width: 60px; border: 0.5px solid black" class="text-center">Marca</th>
                                            <th style="width: 60px; border: 0.5px solid black" class="text-center">Modelo</th>
                                            <th style="width: 60px; border: 0.5px solid black" class="text-center">Serie</th>
                                        </tr>
                                        </thead>
                                        <tbody id="">

                                        @foreach($detalles as $detalle)
                                            <input type="text" class="hidden" id="tiporequisicion" value="{{$detalle->tiporequisicion}}">
                                            <tr id="{{$detalle->codinsumo}}">

                                                <td style="border:solid black 0.5px" class="text-center"><input type="text" value="{{$detalle->codinsumo}}" class="form-control codinsumo" readonly="readonly"></td>
                                                <td style="border:solid black 0.5px"><input type="text" value="{{$detalle->insumo}}" class="form-control insumo " readonly="readonly"></td>
                                                <td style="border:solid black 0.5px" class="text-center"><input type="number" min="0" value="{{$detalle->cantidad}}" class="form-control cantidad" readonly="readonly"></td>
                                                <td style="border:solid black 0.5px" class="text-right"><input type="text" value="{{$detalle->precio}}" class="form-control precio" readonly="readonly"></td>
                                                @if($orden->estado=='Cerrado')
                                                    <td style="border:solid black 0.5px" class="text-right"><input type="text" readonly="true" value="{{$detalle->preciocompra}}"  class="form-control preciocompra" ></td>
                                                    <td style="border:solid black 0.5px"></td>
                                                    <td style="border:solid black 0.5px"></td>
                                                    <td style="border:solid black 0.5px"></td>
                                                @else

                                                    <td style="border:solid black 0.5px" class="text-right"><input type="text"  class="form-control preciocompra" ></td>
                                                    <td style="border:solid black 0.5px" class="text-right"><input type="text"  class="form-control marca" ></td>
                                                    <td style="border:solid black 0.5px" class="text-right"><input type="text"  class="form-control modelo" ></td>
                                                    <td style="border:solid black 0.5px" class="text-right"><input type="text"  class="form-control serie" ></td>

                                                @endif

                                            </tr>
                                        @endforeach

                                        </tbody>
                                        <tfoot style="background-color: lightblue;font-weight: bold">
                                        <tr>

                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px" class="text-right"><small><b>SUB TOTAL</b></small></td>
                                            <td style="border:solid black 0.5px" id="subtotal"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                        </tr>
                                        <tr>

                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px" class="text-right"><small><b>IVA</b></small></td>
                                            <td style="border:solid black 0.5px" id="iva"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                        </tr>
                                        <tr>

                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px" class="text-right"><small><b>VALOR TOTAL</b></small></td>
                                            <td style="border:solid black 0.5px" id="total"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                            <td style="border:solid black 0.5px"></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <a href="ord_bandejaadmin"  class="pull-left btn btn-danger btn-md" style="margin-left: 15px" ><i class="fa fa-arrow-left"></i> Ordenes</a>
                                <div class="row">
                                    @if($orden->estado=='Aprobado' || $orden->estado=='Abierto')
                                        @if($orden->tipo_requisicion_id==1 || $orden->tipo_requisicion_id==3 || $orden->tipo_requisicion_id==4)
                                            <button style="margin-right: 30px" type="button" class="btn btn-success btn-lg btn-outline  pull-right" id="btn_descargacc" data-dismiss="modal">
                                                <i class="fa fa-download"></i> Descargar en CC
                                            </button>

                                        @elseif($orden->tipo_requisicion_id==2)
                                            <button style="margin-right: 30px" type="button" class="btn btn-success btn-lg btn-outline pull-right  " id="btn_descargabodega" data-dismiss="modal">
                                                <i class="fa fa-download"></i> Descargar en Bodega
                                            </button>
                                        @endif
                                    @endif
                                </div>
                                <div style="margin-left: 10px" id="barra_progreso" class="hidden">
                                    <h3>Descargando...</h3>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="83"
                                             aria-valuemin="0" aria-valuemax="100" style="width:83%">
                                            80%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row hidden" id="divhojaactivo">

                                <h1 style="margin-left:10px;margin-bottom: 30px">Adquisicion de activo <small><span class="label label-info">Rellenar los siguientes campos es obligatorio</span></small></h1>
                                <form id="frm_adqactivo">
                                    <div class="row">

                                        <div class="col-lg-8">
                                            <div class="form-group"><label class="col-lg-2 control-label">Asignarse a: </label>
                                                <div class="col-lg-8">
                                                    <select name="" id="electricista" class="form-control">
                                                        <option value="">Electricista...</option>
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
                                                    <select name="" id="ccostos" class="form-control">
                                                        <option value="">Centro costos...</option>
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
                                                    <select name="" id="agencia" class="form-control">
                                                        <option value="">Agencias...</option>
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
                                                    <select name="" id="bodega" class="form-control">
                                                        <option value="">Bodegas...</option>
                                                        @foreach($bodegas as $bodega)
                                                            <option value="{{$bodega->id}}">{{$bodega->codigo}}</option>
                                                        @endforeach
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
                                                    <select name="" id="departamento" class="form-control">
                                                        <option value="">Departamento...</option>
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
                                                    <select  name="" id="municipio" class="form-control">
                                                        <option value="">Municipios...</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col-lg-8">
                                            <div class="form-group"><label class="col-lg-2 control-label">Justificacion: </label>
                                                <div class="col-lg-10">
                                                    <textarea name="" id="justificacion" cols="30" rows="6" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group"><label class="col-lg-2 control-label">Estado: </label>
                                                <div class="col-lg-8">
                                                    <select name="" id="estadoinsumo" class="form-control">
                                                        <option value="">seleccione...</option>
                                                        <option value="1">Buena condicion</option>
                                                        <option value="2">Deteriorado</option>
                                                        <option value="3">Arruinado</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <a href='imprimirhojaactivo?occ={{$orden->idordencompra}}' class="btn btn-warning btn-md pull-right hidden" id="btn_imprimirhoja" style="margin-right: 25px; margin-top: 40px"><i class="fa fa-print"></i> Imprimir hoja</a>

                                        <button type="button" class="btn btn-success btn-md pull-right" id="btn_guardarhojaactivo" style="margin-right: 25px; margin-top: 40px"><i class="fa fa-download"></i> Guardar y descargar</button>
                                        <a href="ord_bandejaadmin" class="btn btn-md btn-danger pull-left" style="margin-left: 20px; margin-top: 40px"><i class="fa fa-arrow-left"></i> Bandeja</a>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        @endif
    </div>

    <!--NUEVO PROVEEDOR-->
    <div class="modal inmodal fade" id="modal_nuevoproveedor" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Nuevo proveedor</h5>
                    <h2><i class="fa fa-user"></i></h2>

                </div>
                <div class="modal-body">
                    <form id="frm_proveedor">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group" id="the-basics">
                                    <label>Nombre entidad: </label>
                                    <input  id="entidad"   type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="the-basics">
                                    <label>Razon social: </label>
                                    <input  id="razonsocial"   type="text" class="form-control" >
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group" id="the-basics">
                                    <label>Contacto: </label>
                                    <input  id="contacto"   type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="the-basics">
                                    <label>Direccion: </label>
                                    <input  id="direccion"   type="text" class="form-control">
                                </div>
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group" id="the-basics">
                                    <label>Correo electronico: </label>
                                    <input  id="correo"   type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="the-basics">
                                    <label>Telefono: </label>
                                    <input  id="telefono"   type="text" class="form-control">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" id="btn_guardarnuevoproveedor" data-dismiss="modal">Guardar</button>
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cerrarmodalinsumos" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@stop



@section('scripts')
    <script src="../js/plugins/fullcalendar/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script src="../js/funciones/ordenes.js"></script>
@stop
