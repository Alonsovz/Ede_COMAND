@extends('layouts.template')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
              
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">                 
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/alertify.min.css"/>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/semantic.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />


@stop

@section('contenido')
<div class="btn-group btn-group-toggle" data-toggle="buttons" >
                <label>
                  <a class="btn btn-info" id="btnShowDocView"
                   style="background-color:#5752D9; color:white;">  <i class="fa fa-plus"></i> Agregar </a>
                  <div style="text-align:center;" id="flechaAdd"
                  class="hidden"><i class="fa fa-arrow-up"></i></div>
                </label>
                <label >
                 <a class="btn btn-info" id="btnShowDocControl"
                  style="background-color:#246B73; color:white;">
                   <i class="fa fa-eye"></i> Ver tabla de control </a>
                   <div style="text-align:center;" id="flechaCtrl"
                   class="hidden"><i class="fa fa-arrow-up"></i></div>
                </label>
                <label>
                  <a class="btn btn-info" id="btnShowDocVinculacion"
                   style="background-color:#2B8C83; color:white;"> 
                   <i class="fa fa-cogs"></i> Vinculación de documentos </a>
                  <div style="text-align:center;" id="flechaVin"
                  class="hidden"><i class="fa fa-arrow-up"></i>
                </div>
                </label>
</div><br><br>


<div class="row">
    <h2 style="color:blue;font-weight:bold;text-align:center;">Vinculación de documentos.</h2><br>
    <center>
    <button  class="btn btn-success" id="btnProcPoli"
    style="margin-bottom:  5px;color:white;margin-left: 5px;border: solid 1px black;
    background-color:#C22400;">
        <i class="fa fa-file" ></i> Procedimiento a Políticas </button>

    <button  class="btn btn-warning"  id="btnFlujosPro"
        style="margin-bottom:  5px;color:white;margin-left: 5px;border: solid 1px black;
        background-color:#014F5C;">
        <i class="fa fa-file"></i> Flujograma a Procedimientos
    </button>

    <button  class="btn btn-info" id="btnOtrosPro"
    style="margin-bottom:  5px;color:white;margin-left: 5px;border: solid 1px black;
    background-color:#401603;">
    <i class="fa fa-file"></i> Otros Documentos a Procedimientos ó Políticas.
    </button></center>
</div>



    <div class="row">
    <div class="col-lg-12 hidden" style="border: #8F8E8E solid 1px;background-color:#DDDDDD" 
        id="proceDiv"><br><br>   
        <h3 style="color:#02306D;font-weight:bold;text-align:center;">
        Procedimientos disponibles para relacionar a políticas</h3>


        <table id="" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example"
               style="color: black;margin-top: 20px" >
            <thead id="header" class="">
            <tr style="background-color: lightgrey">
                <th style="border: solid 1px grey;color:white;background-color:#DF645C;">Título</th>
                <th style="border: solid 1px grey;color:white;background-color:#DF645C;">Descripción</th>
                <th style="border: solid 1px grey;color:white;background-color:#DF645C;">Área</th>
                <th style="border: solid 1px grey;color:yellow;background-color:#C22400;text-align:center;">Acciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach($procedimientos as $pro)
                <tr>  
                    <td style="border: solid 1px grey;">{{$pro->titulo}}</td>
                    <td style="border: solid 1px grey;">{{$pro->descripcion}}</td>
                    <td style="border: solid 1px grey;">{{$pro->area}}</td>
                    <td style="border: solid 1px grey;text-align:center;">
                        <button class="btn btn-danger btn-sm" style="background-color:#469B08;color:white;"
                            id="{{$pro->idDoc}}" nombre="{{$pro->titulo}}" 
                            titulo="Políticas asociadas al procedimiento :" 
                            onclick="detallesPro(this)">
                            Detalles
                        </button>
                        <button class="btn btn-info btn-sm" style="background-color:#4D4C4C;color:white;"
                            id="{{$pro->idDoc}}" nombre="{{$pro->titulo}}" 
                            titulo="Políticas disponibles para relacionar al procedimiento :" 
                            validacion = "1" onclick="vincular(this)">
                            Vincular
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
           
        </table>
    </div>


    <div class="col-lg-12 hidden" style="border: #8F8E8E solid 1px;background-color:#DDDDDD" id="flujosDiv"><br><br>   
        <h3 style="color:#02306D;font-weight:bold;text-align:center;">
        Flujogramas disponibles para relacionar a Procedimientos</h3>


        <table id="" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example"
               style="color: black;margin-top: 20px" >
            <thead id="header" class="">
            <tr style="background-color: lightgrey">
                <th style="border: solid 1px grey;color:white;background-color:#4698A5;">Título</th>
                <th style="border: solid 1px grey;color:white;background-color:#4698A5;">Descripción</th>
                <th style="border: solid 1px grey;color:white;background-color:#4698A5;">Área</th>
                <th style="border: solid 1px grey;color:yellow;background-color:#004f5b;text-align:center;">Acciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach($flujogramas as $flujo)
                <tr>  
                    <td style="border: solid 1px grey;">{{$flujo->titulo}}</td>
                    <td style="border: solid 1px grey;">{{$flujo->descripcion}}</td>
                    <td style="border: solid 1px grey;">{{$flujo->area}}</td>
                    <td style="border: solid 1px grey;text-align:center;">
                    <button class="btn btn-danger btn-sm" style="background-color:#469B08;color:white;"
                    id="{{$flujo->idDoc}}" nombre="{{$flujo->titulo}}" titulo="Procedimientos asociados al flujograma :" 
                    onclick="detallesPro(this)">
                    Detalles</button>
                    <button class="btn btn-info btn-sm" style="background-color:#4D4C4C;color:white;"
                    id="{{$flujo->idDoc}}" nombre="{{$flujo->titulo}}" titulo="Procedimientos disponibles para relacionar al flujograma :" 
                    validacion = "2" onclick="vincular(this)">
                    Vincular</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
           
        </table>
    </div>




    <div class="col-lg-12 hidden" style="border: #8F8E8E solid 1px;background-color:#DDDDDD" id="otrosDiv"><br><br>   
        <h3 style="color:#02306D;font-weight:bold;text-align:center;">
        Otros documentos disponibles para relacionar a Políticas ó Procedimientos</h3>


        <table id="" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example"
               style="color: black;margin-top: 20px" >
            <thead id="header" class="">
            <tr style="background-color: lightgrey">
                <th style="border: solid 1px grey;color:white;background-color:#725142;">Título</th>
                <th style="border: solid 1px grey;color:white;background-color:#725142;">Descripción</th>
                <th style="border: solid 1px grey;color:white;background-color:#725142;">Área</th>
                <th style="border: solid 1px grey;color:white;background-color:#725142;">Tipo de documento</th>
                <th style="border: solid 1px grey;color:yellow;background-color:#401603;text-align:center;">Acciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach($otros as $otro)
                <tr>  
                    <td style="border: solid 1px grey;">{{$otro->titulo}}</td>
                    <td style="border: solid 1px grey;">{{$otro->descripcion}}</td>
                    <td style="border: solid 1px grey;">{{$otro->area}}</td>
                    <td style="border: solid 1px grey;">{{$otro->tipodoc}}</td>
                    <td style="border: solid 1px grey;text-align:center;">
                    <button class="btn btn-danger btn-sm" style="background-color:#469B08;color:white;"
                    id="{{$otro->idDoc}}" nombre="{{$otro->titulo}}" titulo="Procedimientos ó políticas asociadas al {{$otro->tipodoc}} :" 
                    onclick="detallesPro(this)">
                    Detalles</button>
                    <button class="btn btn-info btn-sm" style="background-color:#4D4C4C;color:white;"
                    id="{{$otro->idDoc}}" nombre="{{$otro->titulo}}" titulo="Procedimientos ó políticas disponibles para relacionar al {{$otro->tipodoc}} :" 
                    validacion = "3" onclick="vincular(this)">
                    Vincular</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
           
        </table>
    </div>
    </div>



<div class="modal inmodal fade fadeInLeftBig" id="modalDetalles" tabindex="-1" role="dialog" 
    data-backdrop="static" data-keyboard="false"  aria-hidden="true">
    <div class="modal-dialog modal-lg" style="">
        <div class="modal-content">
            <div class="modal-header"   style="background-color:#0247B0; color:white;text-align:left;">
                <a style="font-size:17px;font-weight:bold;color:white;text-align:left;">
                <i class="fa fa-book"></i>  
                <a style="font-size:17px;font-weight:bold;color:white;text-align:left;"
                id="tituloModal"></a>  </a> <br> 
                <a style="color:yellow;font-size:17px;font-weight:bold;text-align:left;" id="namePro"></a>         
            </div>
            <div class="modal-body">
               <div id="listDocumentosAsociados"></div>
            </div>
            <div class="modal-footer"   style="background-color:#CBCBCB">
                <button type="button" class="btn btn-default btn-sm"  data-dismiss="modal" 
                style="background-color:#0247B0; color:white;">
                    <i class="fa fa-close"></i> Cancelar</button>
            </div>
        </div>
    </div> 
</div> 



<div class="modal inmodal fade fadeInLeftBig" id="modalVincular" tabindex="-1" role="dialog" 
    data-backdrop="static" data-keyboard="false"  aria-hidden="true">
    <div class="modal-dialog" style="">
        <div class="modal-content">
            <div class="modal-header"   style="background-color:#0247B0; color:white;text-align:left;">
                <a style="font-size:17px;font-weight:bold;color:white;text-align:left;">
                <i class="fa fa-book"></i>  
                <a style="font-size:17px;font-weight:bold;color:white;text-align:left;"
                id="tituloModalVincular"></a>  </a> <br> 
                <a style="color:yellow;font-size:17px;font-weight:bold;text-align:left;" id="nameDocumento"></a>         
            </div>
            <div class="modal-body"    style="background-color:#CBCBCB">
                <input type="hidden" id="idDocPadre">
                <input type="hidden" id="idValidacion">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="hidden" id="divPoliDisponibles">                       
                                <label><i class="fa fa-file"></i> Políticas disponibles: </label>
                                <select  id="poliDisponibles" class="form-control selectpicker" data-live-search="true"
                                style="width:100%;">
                                <option value="0" set selected>Selecciona una opción</option>        
                                @foreach($politica as $poli)
                                            <option value="{{$poli->idDoc}}">
                                             Área:  {{$poli->area}} --- Título: {{$poli->titulo}}
                                            </option>
                                        @endforeach

                                </select>
                        </div>

                        <div class="hidden" id="divProDisponibles">

                                <label><i class="fa fa-file"></i> Procedimientos disponibles: </label>
                                <select  id="proDisponibles" class="form-control selectpicker" data-live-search="true"
                                style="width:100%;">
                                <option value="seleccione" set selected>Selecciona una opción</option>        
                                @foreach($procedimientos as $pro)
                                            <option value="{{$pro->idDoc}}">
                                             Área:  {{$pro->area}} --- Título: {{$pro->titulo}}
                                            </option>
                                        @endforeach

                                </select>


                        </div>
                        <div class="hidden" id="divProPolDisponibles">

                                <label><i class="fa fa-file"></i> Políticas y Procedimientos disponibles: </label>
                                <select  id="proPolDisponibles" class="form-control selectpicker" data-live-search="true"
                                style="width:100%;">
                                <option value="0" set selected>Selecciona una opción</option>        
                                @foreach($procedimientos as $pro)
                                            <option value="{{$pro->idDoc}}">
                                              Área:  {{$pro->area}} --- Título: {{$pro->titulo}}
                                            </option>
                                        @endforeach
                                @foreach($politica as $poli)
                                            <option value="{{$poli->idDoc}}">
                                            Área:  {{$poli->area}} --- Título: {{$poli->titulo}} 
                                            </option>
                                @endforeach
                                </select>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default ex"  data-dismiss="modal" 
                style="background-color:red; color:white;">
                    <i class="fa fa-close"></i> Cancelar</button>

                <button type="button" class="btn btn-default" id="guardar"
                style="background-color:green; color:white;">
                <i class="fa fa-save"></i> Guardar</button>
            </div>
        </div>
    </div> 
</div> 

@stop

@section('scripts')


 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

 

 <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script src="../js/plugins/dataTables/datatables.min.js"></script>
    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>

   <script src="../js/funciones/subirDocumentos.js"></script>

   <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/alertify.min.js"></script>
<!-- funciones para los mensajes de alerta -->
<script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>



<script>
    $(document).ready(function(){
        $("#btnShowDocVinculacion").css({'color':'black','background':'#F3F3F4'});
        $("#flechaVin").removeClass("hidden");
    });
</script>

@stop