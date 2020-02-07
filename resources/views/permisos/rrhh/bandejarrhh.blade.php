@extends('layouts.template')

@section('css')
 	<link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">

    <link rel="stylesheet" type="text/css" href="../css/plugins/datapicker/datepicker3.css">
    <link rel="stylesheet" type="text/css" href="../css/plugins/clockpicker/clockpicker.css">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
@stop

@section('enunciado')
	Permisos
@stop

@section('modulo')
	Permisos
@stop

@section('submodulo')
	<b>Bandeja</b>
@stop

@section('contenido')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content ">
                    <div class="file-manager">
                        <div class="space-25"></div>
                        <h5></h5>
                        <div class="alert alert-warning alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <a class="alert-link">Estimado Empleado</a>
                            La solicitud por ausencia laboral tendra validez si el estado
                            se encuentra en "Revision rrhh" lo cual significa que el jefe inmediato y RRHH aprobaron la
                            solicitud.
                        </div>
                        <div class="row">

                            <div class="col-lg-8">
                                <h2><i class="fa fa-folder"></i> Bandejas</h2>
                                <button id="btn_enviadas" class="btn btn-outline btn-info btn-lg"><i class="fa fa-envelope"></i> Nuevas Solicitudes</button>
                                <button id="btn_aprobadas" class="btn btn-outline btn-success btn-lg"><i class="fa fa-thumbs-up"></i> Aprobadas</button>
                                <button id="btn_denegadas" class="btn btn-outline btn-danger btn-lg"><i class="fa fa-thumbs-down"></i> Denegadas</button>
                            </div>
                        </div>

                        <h5 style="margin-top: 125px">Estados</h5>
                        <ul class="category-list pull-left." style="padding: 0">

                            <li><a href="#" class="col-lg-2" style="background-color: dodgerblue; color: white"> <i class="" ></i> Solicitud recibida</a></li>
                            <li><a href="#" class="col-lg-2" style="background-color: orange; color: black;"> <i class="" ></i> Aprobado por jefatura</a></li>
                            <li><a href="#" class="col-lg-4" style="background-color: springgreen; color: black"> <i class="" ></i> Fin del proceso(Revision de RRHH)</a></li>
                        </ul>


                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="ibox-footer" >
                    <div class="" id="p_recibidas">
                        <h2><i class="fa fa-file-text"></i> Nuevas solicitudes</h2>
                        <table  class=" dataTables-example1 table table-hover table-responsive  table-mail dataTables-example"
                                style="color: black;font-size: 13px">
                            <thead id="header" style="background-color: lightgrey;">
                            <tr>
                                <th class="text-center" style="border: solid grey 1px">Id de solicitud</th>
                                <th class="text-center" style="border: solid grey 1px">Empleado</th>
                                <th class="text-center" style="border: solid grey 1px">Estado</th>
                                <th class="text-center" style="border: solid grey 1px">Tipo de permiso</th>
                                <th class="text-center" style="border: solid grey 1px">Fecha de solicitud</th>
                                <th class="text-center" style="border: solid grey 1px">Inicio de permiso</th>
                                <th class="text-center" style="border: solid grey 1px">Fin de permiso</th>
                                <th class="text-center" style="border: solid grey 1px"></th>
                                <th class="text-center" style="border: solid grey 1px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permisos as $permiso)
                                @if($permiso->estado=='Solicitud recibida')

                                    <tr class="gradeU">

                                        <td class="bg-info" style="width: 30px; border: solid grey 1px">
                                            <small><b>{{$permiso->id}}</b></small>
                                        </td>
                                        <td class="bg-info" style="width: 100px; border: solid grey 1px">
                                            <small><b>{{$permiso->empleado}}</b></small>
                                        </td>

                                        <td class="mail-ontact" style="width: 20px; border: solid grey 1px">
                                            @if($permiso->estado=='Gestionando solicitud')
                                                <span class="label label-warning pull-right">{{$permiso->estado}}</span>

                                            @elseif($permiso->estado=='Solicitud recibida')
                                                <span class="label label-success pull-right">{{$permiso->estado}}</span>

                                            @elseif($permiso->estado=='Aprobacion de jefatura')
                                                <span class="label label-info pull-right">{{$permiso->estado}}</span>

                                            @elseif($permiso->estado=='Solicitud denegada')
                                                <span class="label label-danger pull-right">{{$permiso->estado}}</span>


                                            @elseif($permiso->estado=='Revision rrhh')
                                                <span class="label label-primary pull-right">{{$permiso->estado}}</span>
                                            @endif
                                        </td>

                                        <td class="center" style="width: 75px; border: solid grey 1px">
                                            <b>
                                                <small>
                                                    {{$permiso->tipopermiso}}
                                                </small>
                                            </b>
                                        </td>

                                        <td class="center" style="width: 30px; border: solid grey 1px">
                                            <small>
                                                <?php
                                                $date = date_create($permiso->fechasolicitud);
                                                echo date_format($date, "d/m/Y");
                                                ?>
                                            </small>
                                        </td>
                                        <td class="center" style="width: 30px; border: solid grey 1px">
                                            <small>
                                                <?php
                                                $date = date_create($permiso->fechainicio);
                                                echo date_format($date, "d/m/Y");
                                                ?>
                                            </small>
                                        </td>
                                        <td class="center" style="width: 30px; border: solid grey 1px">
                                            <small>
                                                <?php
                                                $date = date_create($permiso->fechafin);
                                                echo date_format($date, "d/m/Y");
                                                ?>
                                            </small>
                                        </td>
                                        <td class="check-mail" style="width: 50px; border: solid grey 1px">
                                            <button data-target='#modalver' data-toggle='modal' type="button"
                                                    id="{{$permiso->id}}" class="btn_verdetallepermiso btn btn-md btn-default" style="border:solid 1px black">
                                                <i class="fa fa-eye"></i> Ver
                                            </button>

                                        </td>
                                        <td style="width: 50px; border: solid grey 1px">
                                            @if($permiso->estado=='Solicitud recibida')
                                                <a href="editarpermiso_emp?id={{$permiso->id}}"
                                                   class="btn_vieweditar btn btn-md btn-default" style="border:solid 1px black">
                                                    <i class="fa fa-pencil"></i> Editar
                                                </a>
                                            @endif
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



                    <div class="hidden" id="p_aprobados">
                        <h2><i class="fa fa-file-text"></i> Solicitudes Aprobadas</h2>
                        <table  class=" dataTables-example1 table table-hover table-responsive  table-mail dataTables-example"
                                style="color: black">
                            <thead id="header" style="background-color: lightgrey;">
                            <tr>
                                <th class="text-center" style="border: solid grey 1px">Id de solicitud</th>
                                <th class="text-center" style="border: solid grey 1px">Empleado</th>
                                <th class="text-center" style="border: solid grey 1px">Estado</th>
                                <th class="text-center" style="border: solid grey 1px">Tipo de permiso</th>
                                <th class="text-center" style="border: solid grey 1px">Fecha de solicitud</th>
                                <th class="text-center" style="border: solid grey 1px">Inicio de permiso</th>
                                <th class="text-center" style="border: solid grey 1px">Fin de permiso</th>
                                <th class="text-center" style="border: solid grey 1px"></th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permisos as $permiso)
                                @if($permiso->estado=='Aprobacion de jefatura' || $permiso->estado=='Revision rrhh')

                                    <tr class="gradeU">

                                        <td class="bg-info" style="width: 30px; border: solid grey 1px">
                                            <small><b>{{$permiso->id}}</b></small>
                                        </td>
                                        <td class="bg-info" style="width: 100px; border: solid grey 1px">
                                            <small><b>{{$permiso->empleado}}</b></small>
                                        </td>

                                        <td class="mail-ontact" style="width: 20px; border: solid grey 1px">
                                            @if($permiso->estado=='Gestionando solicitud')
                                                <span class="label label-warning pull-right">{{$permiso->estado}}</span>

                                            @elseif($permiso->estado=='Solicitud recibida')
                                                <span class="label label-success pull-right">{{$permiso->estado}}</span>

                                            @elseif($permiso->estado=='Aprobacion de jefatura')
                                                <span class="label label-warning pull-right">{{$permiso->estado}}</span>

                                            @elseif($permiso->estado=='Solicitud denegada')
                                                <span class="label label-danger pull-right">{{$permiso->estado}}</span>


                                            @elseif($permiso->estado=='Revision rrhh')
                                                <span class="label label-primary pull-right">{{$permiso->estado}}</span>
                                            @endif
                                        </td>

                                        <td class="center" style="width: 75px; border: solid grey 1px">
                                            <b>
                                                <small>
                                                    {{$permiso->tipopermiso}}
                                                </small>
                                            </b>
                                        </td>

                                        <td class="center" style="width: 30px; border: solid grey 1px">
                                            <small>
                                                <?php
                                                $date = date_create($permiso->fechasolicitud);
                                                echo date_format($date, "d/m/Y");
                                                ?>
                                            </small>
                                        </td>
                                        <td class="center" style="width: 30px; border: solid grey 1px">
                                            <small>
                                                <?php
                                                $date = date_create($permiso->fechainicio);
                                                echo date_format($date, "d/m/Y");
                                                ?>
                                            </small>
                                        </td>
                                        <td class="center" style="width: 30px; border: solid grey 1px">
                                            <small>
                                                <?php
                                                $date = date_create($permiso->fechafin);
                                                echo date_format($date, "d/m/Y");
                                                ?>
                                            </small>
                                        </td>
                                        <td class="check-mail" style="width: 50px; border: solid grey 1px">
                                            <button data-target='#modalrevision' data-toggle='modal' type="button" id="{{$permiso->id}}" class="btn_verdetallepermiso
                                            btn btn-md btn-white" style="border:solid 1px black">
                                                <i class="fa fa-eye"></i> Ver
                                            </button>
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
                    <div class="hidden" id="p_denegados">
                        <h2><i class="fa fa-file-text"></i> Solitudes denegadas</h2>
                        <table  class=" dataTables-example1 table table-hover table-responsive  table-mail dataTables-example"
                                style="color: black">
                            <thead id="header" style="background-color: lightgrey;">
                            <tr>
                                <th class="text-center" style="border: solid grey 1px">Id de solicitud</th>
                                <th class="text-center" style="border: solid grey 1px">Empleado</th>
                                <th class="text-center" style="border: solid grey 1px">Estado</th>
                                <th class="text-center" style="border: solid grey 1px">Tipo de permiso</th>
                                <th class="text-center" style="border: solid grey 1px">Fecha de solicitud</th>
                                <th class="text-center" style="border: solid grey 1px">Inicio de permiso</th>
                                <th class="text-center" style="border: solid grey 1px">Fin de permiso</th>
                                <th class="text-center" style="border: solid grey 1px">Accion</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permisos as $permiso)
                                @if($permiso->estado=='Solicitud denegada')

                                    <tr class="gradeU">

                                        <td class="bg-info" style="width: 30px; border: solid grey 1px">
                                            <small><b>{{$permiso->id}}</b></small>
                                        </td>

                                        <td class="bg-info" style="width: 30px; border: solid grey 1px">
                                            <small><b>{{$permiso->empleado}}</b></small>
                                        </td>

                                        <td class="mail-ontact" style="width: 20px; border: solid grey 1px">
                                            @if($permiso->estado=='Gestionando solicitud')
                                                <span class="label label-warning pull-right">{{$permiso->estado}}</span>

                                            @elseif($permiso->estado=='Solicitud recibida')
                                                <span class="label label-success pull-right">{{$permiso->estado}}</span>

                                            @elseif($permiso->estado=='Aprobacion de jefatura')
                                                <span class="label label-info pull-right">{{$permiso->estado}}</span>

                                            @elseif($permiso->estado=='Solicitud denegada')
                                                <span class="label label-danger pull-right">{{$permiso->estado}}</span>


                                            @elseif($permiso->estado=='Revision rrhh')
                                                <span class="label label-primary pull-right">{{$permiso->estado}}</span>
                                            @endif
                                        </td>

                                        <td class="center" style="width: 75px; border: solid grey 1px">
                                            <b>
                                                <small>
                                                    {{$permiso->tipopermiso}}
                                                </small>
                                            </b>
                                        </td>

                                        <td class="center" style="width: 30px; border: solid grey 1px">
                                            <small>
                                                <?php
                                                $date = date_create($permiso->fechasolicitud);
                                                echo date_format($date, "d/m/Y");
                                                ?>
                                            </small>
                                        </td>
                                        <td class="center" style="width: 30px; border: solid grey 1px">
                                            <small>
                                                <?php
                                                $date = date_create($permiso->fechainicio);
                                                echo date_format($date, "d/m/Y");
                                                ?>
                                            </small>
                                        </td>
                                        <td class="center" style="width: 30px; border: solid grey 1px">
                                            <small>
                                                <?php
                                                $date = date_create($permiso->fechafin);
                                                echo date_format($date, "d/m/Y");
                                                ?>
                                            </small>
                                        </td>
                                        <td class="check-mail" style="width: 50px; border: solid grey 1px">
                                            <button data-target='#modalver' data-toggle='modal' type="button"
                                                    id="{{$permiso->id}}" class="btn_verdetallepermiso btn btn-sm btn-default">
                                                <i class="fa fa-eye"></i> Ver
                                            </button>
                                            @if($permiso->estado=='Solicitud recibida')
                                                <a href="editarpermiso_emp?id={{$permiso->id}}"
                                                   class="btn_vieweditar btn btn-sm btn-default">
                                                    <i class="fa fa-pencil"></i> Editar
                                                </a>
                                            @endif

                                            @if($permiso->estado=='Solicitud aprobada')
                                                <a href="descargarpdf?idpermiso={{$permiso->id}}" id="{{$permiso->id}}"
                                                   class="btn_descargarpdf btn btn-sm btn-white">
                                                    <i class="fa fa-file-pdf-o"></i> Editar
                                                </a>
                                            @endif


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
            </div>
        </div>



        <div class="modal inmodal" id="modalver" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <h2 class="text-warning"><strong><i class="fa fa-exclamation-circle"></i> Esta solicitud aun no ha sido aprobada por jefatura</strong></h2>
                        <button type="button" class="close" data-dismiss="modal"><span
                                    aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <i class="fa fa-clipboard modal-icon"></i>
                        <h4 class="modal-title">
                            <small>Detalles de solicitud</small>
                        </h4>
                        <small class="font-bold" id="empleadosolicitud"></small>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 " id="frm_nuevopermiso">
                                <div class="ibox">
                                    <div class="ibox-title">

                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>

                                        </div>
                                    </div>
                                    <div class="ibox-content">


                                        <form id="form" action="#" class="wizard-big form-horizontal">

                                            <fieldset>
                                                <h2></h2>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Nombre Completo *</label>
                                                            <input autocomplete="off" id="nombrecompleto" readonly="true"
                                                                   name="nombrecompleto" type="text" class="form-control"
                                                                   required title="Campo obligatorio">
                                                        </div>
                                                    </div>



                                                    <div class="col-lg-4" style="margin-left: 5px">
                                                        <div class="form-group">
                                                            <label>Departamento *</label>
                                                            <input type="text" id="departamento" class="form-control" name="departamento" readonly="true">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="text-center">
                                                            <div style="margin-top: 20px">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </fieldset>

                                            <fieldset>
                                                <h2></h2>
                                                <div class="row">

                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label>Tipo de Permiso *</label>
                                                            <input type="text" name="tipopermiso" id="tipopermiso"
                                                                   class="form-control" readonly="true">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top: 10px">
                                                    <div class="col-lg-4">
                                                        <div class="form-group" id="data_1">
                                                            <label>Fecha de inicio</label>
                                                            <div class="input-group date">
                                                            <span class="input-group-addon"><i
                                                                        class="fa fa-calendar"></i></span>
                                                                <input type="text" readonly="true" id="fechainicio"
                                                                       name="fechainicio" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4" style="margin-left: 10px">
                                                        <div class="form-group" id="data_2">
                                                            <label>Fecha de finalizacion</label>
                                                            <div class="input-group date">
                                                            <span class="input-group-addon"><i
                                                                        class="fa fa-calendar"></i></span>
                                                                <input type="text" id="fechafin" readonly="true"
                                                                       name="fechafin" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label>Motivo del permiso *</label>
                                                            <textarea readonly="true" id="motivopermiso"
                                                                      name="motivopermiso" rows="3 " class="form-control">
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <fieldset>

                                            </fieldset>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn_cerrarupdatepermisos" class="btn btn-white hidden"
                                data-dismiss="modal">Cerrar
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal inmodal" id="modalrevision" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                    aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <i class="fa fa-clipboard modal-icon"></i>
                        <h4 class="modal-title">
                            <small>Detalles de solicitud</small>
                        </h4>
                        <small class="font-bold" id="empleadosolicitud"></small>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 " id="frm_nuevopermiso">
                                <div class="ibox">
                                    <div class="ibox-title">

                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>

                                        </div>
                                    </div>
                                    <div class="ibox-content">


                                        <form id="form" action="#" class="wizard-big form-horizontal">

                                            <fieldset>
                                                <h2></h2>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label>Nombre Completo *</label>
                                                            <input autocomplete="off" id="nombrecompleto1" readonly="true"
                                                                   name="nombrecompleto" type="text" class="form-control"
                                                                   required title="Campo obligatorio">
                                                        </div>
                                                    </div>



                                                    <div class="col-lg-4" style="margin-left: 5px">
                                                        <div class="form-group">
                                                            <label>Departamento *</label>
                                                            <input type="text" id="departamento1" class="form-control" name="departamento" readonly="true">
                                                        </div>
                                                    </div>

                                                </div>

                                            </fieldset>

                                            <fieldset>
                                                <h2></h2>
                                                <div class="row">

                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label>Tipo de Permiso *</label>
                                                            <input type="text" name="tipopermiso1" id="tipopermiso1"
                                                                   class="form-control" readonly="true">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top: 10px">
                                                    <div class="col-lg-4">
                                                        <div class="form-group" id="data_1">
                                                            <label>Fecha de inicio</label>
                                                            <div class="input-group date">
                                                            <span class="input-group-addon"><i
                                                                        class="fa fa-calendar"></i></span>
                                                                <input type="text" readonly="true" id="fechainicio1"
                                                                       name="fechainicio1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4" style="margin-left: 10px">
                                                        <div class="form-group" id="data_2">
                                                            <label>Fecha de finalizacion</label>
                                                            <div class="input-group date">
                                                            <span class="input-group-addon"><i
                                                                        class="fa fa-calendar"></i></span>
                                                                <input type="text" id="fechafin1" readonly="true"
                                                                       name="fechafin1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label>Motivo del permiso *</label>
                                                            <textarea readonly="true" id="motivopermiso1"
                                                                      name="motivopermiso1" rows="3 " class="form-control">
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <div style="margin-top: 20px">
                                                                <label>Goce de sueldo *</label>
                                                                <input type="text" id="gocesueldo" class="form-control" name="gocesueldo" readonly="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <fieldset>
                                                <div id="recursoshumanos" >
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label>Presentara constancia</label>
                                                                <select class="form-control" id="constancia" readonly="true" name="constancia">
                                                                    <option value=""></option>
                                                                    <option value="1">Si</option>
                                                                    <option value="0">No</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-7">
                                                            <div class="form-group">
                                                                <label>Comentario</label>
                                                                <textarea id="comentario" readonly="true" name="comentario" rows="4" class="form-control"></textarea>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <button id="btn_revisionsolicitud" disabled type="button" class=" btn btn-success btn-md">
                                                        <i class="fa fa-save"></i> Revision completa
                                                    </button>

                                                    <button type="button" id="btn_cerrarupdatepermisos"  class=" btn btn-danger btn-md " data-dismiss="modal">
                                                        <i class="fa fa-close"></i> Cerrar
                                                    </button>

                                                    <div class="row hidden" id="barraprogreso">
                                                        <b>Generando PDF...</b>
                                                        <div style="margin-top: 20px; margin-left: 0" class="progress progress-striped active">

                                                            <div style="width: 75%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" role="progressbar" class="progress-bar progress-bar-warning">
                                                                <span class="sr-only">40% Complete (success)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn_cerrarupdatepermisos" class="btn btn-white hidden"
                                data-dismiss="modal">Cerrar
                        </button>

                    </div>
                </div>
            </div>
        </div>



@stop


@section('scripts')

    <script src="../js/plugins/fullcalendar/moment.min.js"></script>


    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>

    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>


    
    <!--funciones para la vista bandejarrhh-->
    <script type="text/javascript" src="../js/funciones/bandejapermisos.js"></script>

    <!-- Jquery Validate -->
    <script src="../js/plugins/validate/jquery.validate.min.js"></script>

            <!-- funciones para los mensajes de alerta -->
            <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

  

@stop