@extends('layouts.template')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
              
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">                 
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/alertify.min.css"/>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/semantic.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">


@stop



@section('contenido')



<div class="btn-group btn-group-toggle" data-toggle="buttons" >
                <label>
                  <a class="btn btn-info" id="btnShowDocView" style="background-color:#5752D9; color:white;">  <i class="fa fa-plus"></i> Agregar </a>
                  <div style="text-align:center;" id="flechaAdd"
                  class="hidden"><i class="fa fa-arrow-up"></i></div>
                </label>
                <label >
                 <a class="btn btn-info" id="btnShowDocControl" style="background-color:#246B73; color:white;">
                   <i class="fa fa-eye"></i> Ver tabla de control </a>
                   <div style="text-align:center;" id="flechaCtrl"
                   class="hidden"><i class="fa fa-arrow-up"></i></div>
                </label>
                <label>
                  <a class="btn btn-info" id="btnShowDocVinculacion" style="background-color:#2B8C83; color:white;"> <i class="fa fa-cogs"></i> Vinculación de documentos </a>
                  <div style="text-align:center;" id="flechaVin"
                  class="hidden"><i class="fa fa-arrow-up"></i></div>
                </label>
</div><br><br>

<div class="row" id="verDocView">
    <h2 style="text-align:center; font-weight:bold;color:#880202"><i class="fa fa-cogs"></i> <i class="fa fa-file"></i> Tabla de Control General </h2>

    <div class="row">
        <div class="col-lg-12">
            <table id="dtControl" class="dataTables-example1 table table-hover
            table-responsive table-striped  table-mail dataTables-example" 
            style="color: black;margin-top: 20px; text-align:center;" >
                    <thead>
                        <tr style="background-color: #1B588F;color:white;">
                        <th style="border: solid 1px grey;text-align:center;">Gerencia</th>
                        <th style="border: solid 1px grey;text-align:center;">Área</th>
                        <th style="border: solid 1px grey;text-align:center;">Indicador</th>
                            <th style="border: solid 1px grey;text-align:center;">Título</th>
                            <th style="border: solid 1px grey;text-align:center;">Tipo de Documento</th>
                            <th style="border: solid 1px grey;text-align:center;">Estado</th>
                            <th style="border: solid 1px grey;text-align:center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($documentos as $docs)
                            <tr  style='background-color:#E1E1E1'>
                            <td style='border-bottom: solid 1px grey;'>{{$docs->gerencia}}</td>
                            <td style='border-bottom: solid 1px grey;'>{{$docs->area}}</td>
                            <td style='border-bottom: solid 1px grey;'>{{$docs->codIndicador}}</td>
                                <td style='border-bottom: solid 1px grey;'>{{$docs->titulo}}</td>
                                <td style='border-bottom: solid 1px grey;'>{{$docs->nombreDoc}}</td>
                                <td style='border-bottom: solid 1px grey;'>
                                @if($docs->estado == 1)
                                    <div style="color:white;background-color:#0C8D13;">Desarrollado</div>
                                @else
                                    <div style="color:white;background-color:#D14031">Faltante</div>
                                @endif
                                    
                                </td>
                                <td style='border-bottom: solid 1px grey;'>

                                <button id="{{$docs->idDoc}}" titulo="{{$docs->titulo}}"
                                descripcion = "{{$docs->descripcion}}"
                                    area = "{{$docs->idAreaGestion}}" idTipoDoc="{{$docs->idTipoDoc}}"
                                    periodoAp = "{{$docs->periodoAplicacion}}" 
                                    indicador = "{{$docs->codIndicador}}" 
                                    fechaCreacion = "{{$docs->fechaCreacion}}"
                                    ruta = "{{$docs->ruta}}"
                                    estado = "{{$docs->estado}}"
                                    gerencia = "{{$docs->idGerencia}}"
                                    onclick="verDocControl(this)"
                                class="btn btn-info btn-sm" style="background-color:#D4943E;">
                                    <i class="fa fa-edit"></i> 
                                </button>

                                <button id="{{$docs->idDoc}}" titulo="{{$docs->titulo}}" onclick="eliminarDocControl(this)"
                                class="btn btn-info btn-sm" style="background-color:red;">
                                    <i class="fa fa-trash"></i> 
                                </button>

                                </td>
                            </tr>
                            @endforeach
                    </tbody>
            </table>
    </div>
    </div>
</div>

<div class="modal inmodal fade fadeInLeftBig" id="modalDetallesDoc" tabindex="-1" role="dialog"  
    data-backdrop="static" data-keyboard="false"  aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:95%;">
        <div class="modal-content">
            <div class="modal-header"   style="background-color:#4A677C; color:white; text-align:left;">
                <a style="font-size:23px;font-weight:bold;color:white;">
                <i class="fa fa-file"></i> Documento :  <a id="tituloModalDoc" style="color:yellow;
                font-size: 19px; font-weight:bold;"></a> </a> 
                
            </div>

            <div class="modal-body">

                <div class="row" style="border: 1px solid #A7A7A7;margin:15px;">
                   
                    <form id="frmDocumentoCtrl" method="POST" method="POST" enctype="multipart/form-data">
                
                
                            <input type="hidden" id="idDetalleDoc" name="idDetalleDoc">
                        <div class="col-lg-12" style="background-color:#DDDDDD">

                            <h2 style="text-align:center;color:blue;font-weight:bold;">Información del documento</h2>
                            <hr>
                            <div class="col-lg-3">
                            <label><i class="fa fa-cube"></i> Selecciona la gerencia responsable:</label>
                        <select class="form-control" id="gerenciaDocCtrl" name="gerenciaDocCtrl">
                                <option value="0" set selected>Selecciona la gerencia</option>
                                @foreach($gerencias as $geren)
                                <option value="{{$geren->idGerencia}}"
                                    >{{$geren->nombreGerencia}}</option>
                                @endforeach
                        </select>
                        </div>
                            <div class="col-lg-3">
                                <label><i class="fa fa-cube"></i> Selecciona el área del documento:</label>
                            <select class="form-control" id="areaDocCtrl" name="areaDocCtrl">
                                    <option value="0" set selected>Selecciona el área</option>
                                    @foreach($areas as $area)
                                    <option value="{{$area->id}}"
                                        >{{$area->area}}</option>
                                    @endforeach
                            </select>
                            </div>
                            <div class="col-lg-3">
                                <label><i class="fa fa-pencil"></i> Clasificación del documento:</label>
                                <select class="form-control" id="clasDocCtrl" name="clasDocCtrl">
                                    <option value="0" set selected>Selecciona la clasificación</option>
                                    @foreach($tDocs as $docs)
                                    <option value="{{$docs->idTipoDoc}}">{{$docs->nombreTipo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label><i class="fa fa-pencil"></i>Período de aplicación:</label>
                                <select class="form-control" id="periodoApCtrl" name="periodoApCtrl">
                                    <option value="No definido" set selected>Selecciona el período de aplicación...</option>                 


                                    <option value="No definido">No definido</option>
                                    <option value="Anual">Anual</option>
                                    <option value="BiMensual">BiMensual</option>
                                    <option value="Cada 18 Meses">Cada 18 Meses</option>
                                    <option value="Cada construcción de nueva red">Cada construcción de nueva red</option>
                                    <option value="De acuerdo a fallas">De acuerdo a fallas</option>
                                    <option value="De acuerdo a mejoras en sistema">De acuerdo a mejoras en sistema</option>

                                    <option value="Diario">Diario</option>
                                    <option value="Diario / Mensual">Diario / Mensual</option>
                                    <option value="Diario / Según requerimientos">Diario / Según requerimientos</option>

                                    <option value="Mensual">Mensual</option>
                                    <option value="Mensual / Anual">Mensual / Anual</option>
                                    <option value="Mensual / Según requerimientos">Mensual / Según requerimientos</option>
                                    <option value="Mensual / Quinquenal">Mensual / Quinquenal</option>

                                    <option value="Por activo">Por activo</option>
                                    <option value="Por cheque">Por cheque</option>
                                    <option value="Por comunicación">Por comunicación</option>

                                    <option value="Quincenal">Quincenal</option>
                                    <option value="Quinquenal">Quinquenal</option>

                                    <option value="Según requerimientos">Según requerimientos</option>
                                    <option value="Según requerimientos de usuarios">Según requerimientos de usuarios</option>

                                    <option value="Semanal">Semanal</option>
                                    <option value="Semestral">Semestral</option>
                                    <option value="Trimestral">Trimestral</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-lg-12" style="background-color:#DDDDDD">
                            <br><br>
                            <div class="col-lg-1" style="margin-right:20px;"> 
                                <label></label>
                                <a id="btnGenerarDocCtrl" class="btn btn-danger btn-sm" 
                                style="color:white;background-color:black;">Generar código</a>
                            </div>
                            <div class="col-lg-3"> 
                                <label><i class="fa fa-archive"></i> Cod. indicador</label>
                                <input type="text" name="codCtrl" id="codCtrl" class="form-control" readonly
                                placeholder="Código Indicador">
                            </div>

                            <div class="col-lg-4">
                                    <label><i class="fa fa-pencil"></i> Título del documento:</label>
                                    <textarea rows="2" id="tituloCtrl" name="tituloCtrl" class="form-control"
                                    placeholder="Título del documento"></textarea>
                            </div>

                            <div class="col-lg-3">
                                <label><i class="fa fa-pencil"></i> Descripción del documento:</label>
                                <textarea rows="3" id="descripcionCtrl" name="descripcionCtrl" class="form-control" placeholder="Descripción del documento"></textarea>
                            </div>

                        </div>
                        <div class="col-lg-12" style="background-color:#DDDDDD">
                            <br><br>
                            <div class="col-lg-3">
                                <label><i class="fa fa-pencil"></i> Fecha de creación :</label>
                                <input type="date" name="fechaCreacionCtrl" id="fechaCreacionCtrl"
                                class=" form-control">  
                            </div>

                            <div class="col-lg-4">
                                <label><i class="fa fa-pencil"></i> Estado del documento:</label>
                                <select class="form-control" id="estadoDocCtrl" name="estadoDocCtrl">
                                        <option value="0" set selected>Selecciona el estado del documento...</option>
                                        <option value="1">Desarrollado</option>
                                        <option value="2">Faltante</option>
                                </select>   
                            </div>
                            <div class="col-lg-5"  style="display:none;" id="divDocCtrl"> 
                                <label><i class="fa fa-archive"></i> Selecciona el documento:</label>
                                <input type="file" name="archivo[]" multiple="multiple" class="form-control">
                                <input type="hidden" name="rutaCtrl" id="rutaCtrl" value="No definida">
                            </div><br><br><br><br><br><br>



                        </div>

                    </form> 
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default"  data-dismiss="modal" 
                style="background-color:#DA4A3E; color:white;">
                    <i class="fa fa-close"></i> Cancelar
                </button>

                <button id="btnModificar" class="btn btn-default"
                style="background-color:#236603; color:white;">
                     <i class="fa fa-edit"></i> Editar
                </button>
           
                
            </div>

        </div>
    </div>
</div>
@stop

@section('scripts')



 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
 


 <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script src="../js/plugins/dataTables/datatables.min.js"></script>
    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
 

   <script src="../js/funciones/subirDocumentos.js"></script>

   <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/alertify.min.js"></script>
<!-- funciones para los mensajes de alerta -->
<script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>
    $(document).ready(function(){
        $("#btnShowDocControl").css({'color':'black','background':'#F3F3F4'});
        $("#flechaCtrl").removeClass("hidden");
    });
</script>
@stop