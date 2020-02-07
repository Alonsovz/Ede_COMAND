@extends('layouts.template')

@section('css')
 	<link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link href="../css/plugins/steps/jquery.steps.css" rel="stylesheet">
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
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content mailbox-content">
                        <div class="file-manager">
                            <a class="btn btn-block btn-primary compose-mail" href="indexpermisos">Nueva solicitud</a>
                            <div class="space-25"></div>
                            <h5></h5>
                            <ul class="folder-list m-b-md" style="padding: 0">
                                <li><a href="permisosjefatura"> <i class="fa fa-inbox "></i>Solicitudes <span class="label label-warning pull-right">{{$conteo}}</span> </a></li>
                                <li><a href="aprobadosjefatura"> <i class="fa fa-envelope-o"></i>Aprobadas</a></li>
                                <li><a href="rechazadosjefatura"> <i class="fa fa-certificate"></i>Rechazadas</a></li>
                                
                               
                            </ul>
                            <h5>Categorias</h5>
                            <ul class="category-list" style="padding: 0">
                                <li><a href="#"> <i class="fa fa-circle text-primary"></i> Solicitud recibida </a></li>
                                <li><a href="#"> <i class="fa fa-circle text-warning"></i> Gestionando</a></li>
                            </ul>

                        
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>


            <!--DATATABLE PARA PERMISOS-->
            <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">

                
                <h2>

                    Solicitudes ({{$conteo}})
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                   
                    

                </div>
            </div>
                <div class="mail-box">

                <table class="dataTables-example1 table table-hover table-mail dataTables-example" >
                    <thead id="header" class="hidden">
                    <tr>
                        <th></th>
                        <th>Rendering engine</th>
                        <th>Browser</th>
                        <th>Platform(s)</th>
                       
                        <th>CSS grade</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permisos as $permiso)
                        
                        <tr class="gradeU">
                            
                            <td>{{$permiso->empleado}}</td>
                            <td class="mail-ontact">
                            @if($permiso->estado=='Aprobacion de jefatura')
                                <span class="label label-danger pull-right">{{$permiso->estado}}</span>
                            </td>
                            @endif
                            <td class="center"><b>{{$permiso->tipopermiso}}</b></td>
                            <td class="center">
                                <small>
                                    <?php
                                        $date=date_create($permiso->fechasolicitud);
                                        echo date_format($date,"d/m/Y");
                                    ?>
                                </small>
                            </td>
                            <td class="check-mail">
                               <button data-target='#myModal' data-toggle='modal' type="button" id="{{$permiso->id}}" class="btn_verdetallepermiso btn btn-sm btn-white"> 
                                <i class="fa fa-eye"></i> 
                               </button>
                            </td>
                        </tr>
                       
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
            <!--FIN DE DATATABLE PARA PERMISOS-->
        </div>



        <!--MODAL PARA MOSTRAR EL DETALLE DEL PERMISO SELECCIONADO-->
        <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <i class="fa fa-clipboard modal-icon"></i>
                                            <h4 class="modal-title"><small>Detalles de solicitud</small></h4>
                                            <small class="font-bold" id="empleadosolicitud"></small>
                                        </div>
                                <div class="modal-body">
                    <div class="row">
                         <div class="col-lg-12 " id="frm_nuevopermiso" >
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
                                                <h1>Datos Generales</h1>
                                                <fieldset>
                                                    <h2></h2>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <div class="form-group">
                                                                <label>Nombre Completo *</label>
                                                                <input autocomplete="off" id="nombrecompleto" readonly="true"   name="nombrecompleto" type="text" class="form-control">
                                                            </div>

                                                            <div class="form-group" id="the-basics">
                                                                <label>Jefe inmediato *</label>
                                                                <input  id="jefe" name="jefe" type="text" readonly="true" class="typeahead form-control" >
                                                            </div>
                                                            
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
                                                <h1>Tipo de Permiso</h1>
                                                <fieldset>
                                                    <h2></h2>
                                                    <div class="row">

                                                        <div class="col-lg-7">
                                                            <div class="form-group">
                                                                <label>Tipo de Permiso *</label>
                                                                <input type="text" name="tipopermiso" id="tipopermiso" class="form-control" readonly="true">
                                                            </div>
                                                        </div>                                       
                                                    </div>

                                                    <div class="row" style="margin-top: 10px">
                                                        <div class="col-lg-4">
                                                            <div class="form-group" id="data_1">
                                                                <label>Fecha de inicio</label>
                                                                <div class="input-group date">
                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                    <input type="text" readonly="true" id="fechainicio" name="fechainicio" class="form-control" value="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4" style="margin-left: 10px">
                                                            <div class="form-group" id="data_2">
                                                                <label>Fecha de finalizacion</label>
                                                                <div class="input-group date">
                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                    <input type="text" id="fechafin" readonly="true" name="fechafin" class="form-control" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="row " style="margin-top: 10px" id="horarios1">
                                                        <div class="col-lg-4">
                                                            <div class="form-group" id="data_1">
                                                                <label>Hora de inicio</label>
                                                                <div class="input-group clockpicker" data-autoclose="true"">
                                                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    <input type="text" id="horainicio" readonly="true" name="horainicio" class="form-control" value="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4" style="margin-left: 10px">
                                                            <div class="form-group" id="data_2">
                                                                <label>Hora de finalizacion</label>
                                                                <div class="input-group clockpicker" data-autoclose="true"">
                                                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    <input type="text" id="horafin" readonly="true" name="horafin" class="form-control" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row hidden" style="margin-top: 10px" id="horarios2">
                                                        <div class="col-lg-4">
                                                            <div class="form-group" id="data_1">
                                                                <label>Hora de salida</label>
                                                                <div class="input-group clockpicker" data-autoclose="true"">
                                                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    <input type="text" id="horasalida" name="horasalida" class="form-control" value="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4" style="margin-left: 10px">
                                                            <div class="form-group" id="data_2">
                                                                <label>Hora de entrada</label>
                                                                <div class="input-group clockpicker" data-autoclose="true"">
                                                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                                                    <input type="text" id="horaentrada" name="horaentrada" class="form-control" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <h1>Motivo del Permiso</h1>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-lg-7">
                                                            <div class="form-group">
                                                                <label>Motivo del permiso *</label>
                                                                <textarea readonly="true"  id="motivopermiso" name="motivopermiso" rows="10"  class="form-control">
                                                                    
                                                                </textarea>
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
                                            <button type="button" id="btn_cerrarupdatepermisos" class="btn btn-white hidden" data-dismiss="modal">Cerrar</button>
                                            
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

    <!--funciones para step de actualizacion de permisos-->
    <script src="../js/plugins/staps/stepsUpdatePermisoJefatura.js"></script>

    <script type="text/javascript" src='../js/funciones/updatepermisostep.js'></script>
    
     <!--funciones para la vista bandejarrhh-->
    <script type="text/javascript" src="../js/funciones/bandejapermisos.js"></script>

    <!-- Jquery Validate -->
    <script src="../js/plugins/validate/jquery.validate.min.js"></script>

    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
@stop