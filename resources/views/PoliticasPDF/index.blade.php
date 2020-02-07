@extends('layouts.template')

@section('css')

  <style>

.button_slide {
    color:white;
  border-radius: 5%;;
  padding: 8px 16px;
  font-size:12px;
  cursor: pointer;
  font-weight:bold;
  box-shadow: inset 0 0 0 0 white;
  -webkit-transition: ease-out 0.4s;
  -moz-transition: ease-out 0.4s;
  transition: ease-out 0.4s;
}



.slide_left:hover {
  box-shadow: inset 0 0 0 50px black;
  color:white;
}

</style>

<link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">  
@stop



@section('contenido')
<?php

$serverName = "192.168.50.2";
$connectionInfo = array( "Database"=>"comanda_db", "UID"=>"sa", "PWD"=>"saedesal");
$conn = sqlsrv_connect( $serverName, $connectionInfo );

  if (!$conn)
      {exit("Fallo conexion: " . $conn);}
?>
<div class="row">
                    <div class="col-lg-2"><br>
                    <button class="button_slide slide_left" id="buscador" style="background-color:#906805;
         color:white;font-size:11px;font-weight:none;"> <i class="fa fa-search"></i> Buscar por palabra
         </button> 
                    </div>
                    <div class="col-lg-3"><br>
                    <button class="button_slide slide_left" id="btnInfoGerencias" style="background-color:#A00BD4;
                    color:white;font-size:11px;font-weight:none;">
                     Información sobre desarrollo de documentos por gerencia
                    </button> 
                    </div>

                    <div class="col-lg-7">
                    <h2 style="color:#036A6C;font-weight:bold;margin-left:12%;"><b>
                    <i class="fa fa-archive"></i> <i class="fa fa-file"></i> Consulta de documentos EDESAL</b></h2>

                    </div>
                </div>


<div class="row" id="vistaBuscador" style="display:none"><br><br>
    <div class="col-lg-12">
        <div class="col-lg-2">
        <button class="button_slide slide_left" id="general" style="background-color:#906805;
         color:white;font-size:13px;font-weight:none;display:none"> <i class="fa fa-home"></i> Vista General
        </button>
        </div>
        <div class="col-lg-3" style="font-size:13px;text-align:right">
            <label><i class="fa fa-pencil"></i> Dígite la palabra clave: </label>
        </div>
        
        <div class="col-lg-5"> 
            <input type="text" id="palabra" name="palabra" class="form-control" placeholder="Palabra de búsqueda"> 
        </div>

        <div class="col-lg-1">
            <button class="btn btn-danger btn-sm" id="buscar">
                <i class="fa fa-search"></i> Buscar
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-3" style="text-align:left;align-items:center;"><br><br>
                <div id="respuesta"></div>
            </div>
            <div class="col-lg-3" ><br><br>
                <div id="info" style="text-align:left;display:none"></div>
            </div>
          
            <div class="col-lg-6">  <br><br>
            
            <button id="maximizar1" class="button_slide slide_left" style="background-color:#02889B;
         color:white;display:none">
         <i class='fa fa-arrows-alt' style='text-align:center;'></i></button>  &nbsp; &nbsp; &nbsp;
            <a style="font-size:17px;font-weight:bold;color:#7301E5;margin:auto;" id="titulo1"></a>
              
            <br> <br> 
                <div id="visor1"  style="display:none;"></div>
            </div>
        </div>
    </div>
</div>    



<div class="row" style="height:100%;" id="vistaNormal">
        <div class="col-lg-12">
            <div class="col-lg-6">
                <br>
                <button  class="button_slide slide_left" style="background-color:#E12B02;
                    color:white;font-size:13px;font-weight:none;display:none"id="recargar">
                    <i class="fa fa-history"></i> Cerrar todo
                </button><br><br>
                   
              
                <button class="button_slide slide_left" style="background-color:#057C13; color:white;"
                id="btnDocsGral">
                    <i class="fa fa-file"></i> Documentos Generales
                </button>
                <button class="button_slide slide_left" style="background-color:#024EA4; color:white;"
                id="btnDocsPol">
                    <i class="fa fa-file"></i> Políticas
                </button>
                <button class="button_slide slide_left" style="background-color:#AD4F01; color:white;"
                id="btnDocsPro">
                    <i class="fa fa-file"></i> Procedimientos
                </button><br><br>


                    <div id="docsGenerales" style="margin-left:45px;" class="hidden">
                        <h3 style="font-weight:bold;">Documentos Generales (Áreas) </h3>

                        @foreach($AreasOtros as $areaOtros)
                        <i class='fa fa-bookmark-o'></i>
                        <button id="{{$areaOtros -> idAreaGestion}}" name="Area{{$areaOtros -> idAreaGestion}}"  
                        class="button_slide slide_left areaOtros" style="background-color:#62AB6A; color:white;">
                        <i class="fa fa-cube"></i> {{$areaOtros -> nombreArea}}
                        </button>
                        
                        
                        <button class='btn btn-default btn-sm hidden' 
                        style='background-color:#057C13; color:white;' name='btnHideDocG{{$areaOtros -> idAreaGestion}}' id="{{$areaOtros -> idAreaGestion}}"
                        onclick='hideDocG(this)'><i class='fa fa-arrow-up'></i></button>
                        
                        <br><br>

                        <?php
                            $sql = "SELECT distinct  d.*  from docs_documentosGral d
                            inner join docs_tipoDocumentosGral td on td.idTipoDoc = d.idTipoDoc
                            where  d.idTipoDoc not in (1,2,3,7) and d.estado = 1
                            and  d.idAreaGestion = ".$areaOtros->idAreaGestion." order by d.titulo asc";

                            $rs1 = sqlsrv_query( $conn, $sql );
                            echo "<div style='list-style:none;display:none;margin-left: 20px;max-height:350px;overflow-y:auto;
                            background-color:#D9D8DA; class='docsListOtro' id='DocumOtro$areaOtros->idAreaGestion'>";
                                                
                                        echo "<h3 style='font-weight:bold;text-align:center;
                                        color:blue;'>Documentos Generales Disponibles</h3>";
                                               

                                while ($row = sqlsrv_fetch_array( $rs1, SQLSRV_FETCH_ASSOC))
                                {
                                                $idDoc=$row["idDoc"];
                                                $nomDoc=$row["titulo"];
                                                $descripcion=$row["descripcion"];
                                                $ruta=$row["ruta"];
                                                    
                                                    echo "<i class='fa fa-long-arrow-right'></i>
                                                     <a style='font-weight:bold; color:black;' 
                                                            id = '$idDoc'>
                                                            <i class='fa fa-file'></i> ".utf8_encode($nomDoc)."
                                                         </a><br> 
                                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                          <button class='btn btn-default btn-sm verDoc' id='$ruta'
                                                         nombre = '".utf8_encode($nomDoc)."' onclick='verDoc(this)'
                                                         style='background-color:#4EAF59;color:white;
                                                         text-align:center;'>
                                                         <i class='fa fa-eye' style='text-align:center;'></i> Ver</button>
                                                         
                                                         <button class='btn btn-default btn-sm verDoc' id='$idDoc'
                                                         nombre = '".utf8_encode($nomDoc)."' onclick='verDocInfo(this)'
                                                         style='background-color:#258831;color:white;
                                                         text-align:center;'>
                                                         <i class='fa fa-list' style='text-align:center;'></i> Detalles</button><br><br>";

                                }
                                echo "</div>";

                        ?>
                        @endforeach
                    </div>



                    <div id="docsPoliticas" style="margin-left:45px;" class="hidden">
                        <h3 style="font-weight:bold;">Políticas (Áreas) </h3>

                        @foreach($AreasPolitica as $areaPoli)
                        <i class='fa fa-bookmark-o'></i>
                        <button id="{{$areaPoli -> idAreaGestion}}" name="Area{{$areaPoli -> idAreaGestion}}"  
                        class="button_slide slide_left areaPol" style="background-color:#547AA6; color:white;">
                        <i class="fa fa-cube"></i> {{$areaPoli -> nombreArea}}
                        </button>
                        <button class='btn btn-default btn-sm hidden' 
                        style='background-color:#024EA4; color:white;' name='btnHidePol{{$areaPoli -> idAreaGestion}}' id="{{$areaPoli -> idAreaGestion}}"
                        onclick='hidePol(this)'><i class='fa fa-arrow-up'></i></button>
                        <br><br>
                        <?php
                          
                          $sql2 = "SELECT distinct  d.*  from docs_documentosGral d
                          inner join docs_tipoDocumentosGral td on td.idTipoDoc = d.idTipoDoc
                          where  d.idTipoDoc  = 1 and d.estado = 1
                          and  d.idAreaGestion = ".$areaPoli->idAreaGestion." order by d.titulo asc";

                            $rs2 = sqlsrv_query( $conn, $sql2 );
                          echo "<div style='list-style:none;display:none;margin-left: 20px;max-height:350px;overflow-y:auto;
                          background-color:#D9D8DA;' class='docsListPol' id='DocumPol$areaPoli->idAreaGestion'>";
                                                
                                        echo "<h3 style='font-weight:bold;text-align:center;
                                        color:blue;'>Políticas Disponibles</h3><br>";
                            while ($row = sqlsrv_fetch_array( $rs2, SQLSRV_FETCH_ASSOC))
                              {
                                $idDoc=$row["idDoc"];
                                $nomDoc=$row["titulo"];
                                $descripcion=$row["descripcion"];
                                $ruta=$row["ruta"];
                                                  
                                                  echo "<i class='fa fa-long-arrow-right'></i>
                                                  <a style='font-weight:bold; color:black;' 
                                                         id = '$idDoc'>
                                                         <i class='fa fa-file'></i> ".utf8_encode($nomDoc)."
                                                      </a><br>
                                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                       <button class='btn btn-default btn-sm verDoc' id='$ruta'
                                                       nombre = '".utf8_encode($nomDoc)."' onclick='verDoc(this)'
                                                       style='background-color:#3E7EC6;color:white;
                                                       text-align:center;'>
                                                       <i class='fa fa-eye' style='text-align:center;'></i> Ver</button>
                                                       
                                                       <button class='btn btn-default btn-sm verDoc' id='$idDoc'
                                                       nombre = '".utf8_encode($nomDoc)."' onclick='verDocInfo(this)'
                                                       style='background-color:#1A5292;color:white;
                                                       text-align:center;'>
                                                       <i class='fa fa-list' style='text-align:center;'></i> Detalles</button><br><br>";

                              }
                        echo "</div><br>";
                      ?>

                        @endforeach
                    </div>


                    <div id="docsProcedimientos" style="margin-left:45px;" class="hidden">
                        <h3 style="font-weight:bold;">Procedimientos (Áreas) </h3>

                        @foreach($AreasProcedimientos as $areaPro)
                        <i class='fa fa-bookmark-o'></i>
                        <button id="{{$areaPro -> idAreaGestion}}" name="Area{{$areaPro -> idAreaGestion}}"  
                        class="button_slide slide_left areaPro" style="background-color:#B18A69; color:white;">
                        <i class="fa fa-cube"></i> {{$areaPro -> nombreArea}}
                        </button>
                        <button class='btn btn-default btn-sm hidden' 
                        style='background-color:#AD4F01; color:white;'
                        name='btnHidePro{{$areaPro -> idAreaGestion}}' id="{{$areaPro -> idAreaGestion}}"
                        onclick='hidePro(this)'><i class='fa fa-arrow-up'></i></button> 
                        <br><br>

                            <?php
                            
                            $sql3 = "SELECT distinct  d.*  from docs_documentosGral d
                            where  d.idTipoDoc = 2 and d.estado = 1
                            and  d.idAreaGestion = ".$areaPro->idAreaGestion." order by d.titulo asc";

                            $rs3 = sqlsrv_query( $conn, $sql3 );
                            echo "<div style='list-style:none;display:none;margin-left: 20px;max-height:350px;overflow-y:auto;
                            background-color:#D9D8DA; class='docsListPro' id='DocumPro$areaPro->idAreaGestion'>";
                                                
                            echo "<h3 style='font-weight:bold;text-align:center;
                            color:blue;'>Procedimientos Disponibles</h3>";
                            while ($row = sqlsrv_fetch_array( $rs3, SQLSRV_FETCH_ASSOC))
                                {
                                    $idDoc=$row["idDoc"];
                                    $nomDoc=$row["titulo"];
                                    $descripcion=$row["descripcion"];
                                    $ruta=$row["ruta"];
                                                    
                                                    echo "<i class='fa fa-long-arrow-right'></i>
                                                    <a style='font-weight:bold; color:black;' 
                                                           id = '$idDoc'>
                                                           <i class='fa fa-file'></i> ".utf8_encode($nomDoc)."
                                                           <button class='btn btn-default btn-sm' 
                                                           style='background-color:#AD4F01; color:white;' id=".$idDoc." name='btnVi$idDoc' onclick='verAnexos(this)'><i class='fa fa-arrow-down'></i></button> 
                                                           <button class='btn btn-default btn-sm hidden' 
                                                           style='background-color:#AD4F01; color:white;'' name='btnFal$idDoc' id=".$idDoc." onclick='hideAnexos(this)'><i class='fa fa-arrow-up'></i></button> 
                                                        </a><br>
                                                        
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <button class='btn btn-default btn-sm verDoc' id='$ruta'
                                                        nombre = '".utf8_encode($nomDoc)."' onclick='verDoc(this)'
                                                        style='background-color:#C2804A;color:white;
                                                        text-align:center;'>
                                                        <i class='fa fa-eye' style='text-align:center;'></i> Ver</button>
                                                        
                                                        <button class='btn btn-default btn-sm verDoc' id='$idDoc'
                                                        nombre = '".utf8_encode($nomDoc)."' onclick='verDocInfo(this)'
                                                        style='background-color:#AB5916;color:white;
                                                        text-align:center;'>
                                                        <i class='fa fa-list' style='text-align:center;'></i> Detalles</button><br><br>";


                                                        echo "<div id='Anexo$idDoc' class='' style='display:none;margin-left:70px;background-color:white;margin-bottom:10px;
                                                        margin-right:10px;'>
                                                        <h3 style='font-weight:bold;text-align:center;
                                                        color:blue;'>Anexos Disponibles</h3>";
                                                        
                                                        $sql4 = "SELECT distinct  d.*  from docs_documentosGral d
                                                        inner join docs_RelacionPadre_Hijos r on r.idDocPadre = d.idDoc
                                                        where  r.idDocHijo = $idDoc and d.estado = 1  order by d.titulo asc";  
                                                        
                                                        $rs4 = sqlsrv_query( $conn, $sql4 );
                                                        while ($row = sqlsrv_fetch_array( $rs4, SQLSRV_FETCH_ASSOC))
                                                        {
                                                            $idDocA=$row["idDoc"];
                                                            $nomDocA=$row["titulo"];
                                                            $descripcionA=$row["descripcion"];
                                                            $rutaA=$row["ruta"];

                                                            echo "<i class='fa fa-long-arrow-right'></i>
                                                            <a style='font-weight:bold; color:black;'>
                                                            <i class='fa fa-file'></i> ".utf8_encode($nomDocA)."
                                                           
                                                            </a><br>
                                                            
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <button class='btn btn-default btn-sm verDoc' id='$rutaA'
                                                            nombre = '".utf8_encode($nomDocA)."' onclick='verDoc(this)'
                                                            style='background-color:#4A61EF;color:white;
                                                            text-align:center;'>
                                                            <i class='fa fa-eye' style='text-align:center;'></i> Ver</button>
                                                        
                                                                <button class='btn btn-default btn-sm verDoc' id='$idDocA'
                                                                nombre = '".utf8_encode($nomDocA)."' onclick='verDocInfo(this)'
                                                                style='background-color:#1A2A90;color:white;
                                                                text-align:center;'>
                                                                <i class='fa fa-list' style='text-align:center;'></i> Detalles</button><br><br>";


                                                        }
                                                        echo "</div>";
                                                        




                                }
                        echo "</div><br>";
                        ?>
                        @endforeach
                    </div>
                
            </div> &nbsp; &nbsp; &nbsp;

                <button id="maximizar" class="button_slide slide_left" style="background-color:#02889B;
                    color:white;display:none">
                    <i class='fa fa-arrows-alt' style='text-align:center;'></i>
                </button>  &nbsp; &nbsp; &nbsp;
                <a style="font-size:17px;font-weight:bold;color:#7301E5;margin:auto;" id="titulo"></a>
                <br><br>          
            <div class="col-lg-6" style="display:none;" id="visor"></div> 

     </div> 
</div> 



                   
<div class="modal inmodal fade fadeInLeftBig" id="modalView" tabindex="-1" role="dialog"
   aria-hidden="true" data-backdrop="static" data-keyboard="false"  aria-hidden="true">
       <div class="modal-dialog modal-lg" style="  width: 95%;height: 100%; margin: auto;top: 20px;left: 20px;right: 20px;">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <a style="font-size:23px;font-weight:bold;color:black;">Documento: </a> 
                        <a id="tituloModal" style="font-size:23px;font-weight:bold;color:#7301E5;"></a>
                    </div>

                    <div class="modal-body" style="background-color:#545454">
                        <div id="vista"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" id="cerrar1" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                    </div>
            </div>
</div>

        


                   
<div class="modal inmodal fade fadeInLeftBig" id="modalInfo" tabindex="-1" role="dialog"  
    aria-hidden="true" data-backdrop="static" data-keyboard="false"  aria-hidden="true">
       <div class="modal-dialog modal-md" style="">
           <div class="modal-content">
           

                    <div class="modal-body" style="">
                     <div id="infoModal"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" id="cerrar1" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                    </div>
            </div>
        </div>
</div>


<div class="modal inmodal fade fadeInLeftBig" id="modalInfoGerencias" tabindex="-1" role="dialog" 
     aria-hidden="true" data-backdrop="static" data-keyboard="false"  aria-hidden="true">
       <div class="modal-dialog modal-lg" style="">
           <div class="modal-content">

                    <div class="modal-header"   style="background-color:#081F81; color:white;">
                        <a style="font-size:23px;font-weight:bold;color:white;">
                        <i class="fa fa-file"></i> <i class="fa fa-info"></i> Información de Gerencias </a>   
                    </div>

                    <div class="modal-body" style=" max-height: calc(75vh - 150px);
                overflow-y: auto;">
                    <h2 style="text-align:center;
                    font-weight:bold;">Documentos faltantes y desarrollados por Gerencias EDESAL </h2>
                    <br><br>
            
            <table id="dtGerencias" class="dataTables-example1 table table-hover
             table-responsive table-striped  table-mail dataTables-example" 
             style="color: black;margin-top: 20px; text-align:center;" >
                    <thead id="header" class="">
                        <tr style="background-color: black;color:white;">
                            <th style="border: solid 1px grey;text-align:center;">Nombre de Unidad</th>
                            <th style="border: solid 1px grey;text-align:center;
                            background-color: red;color:white;">Faltantes</th>
                            <th style="border: solid 1px grey;text-align:center;
                            background-color: #0D8108;color:white;">Desarrollados</th>
                             <th style="border: solid 1px grey;text-align:center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody >
                    @foreach($infoGerencias as $info)
                    <tr  style='background-color:#E1E1E1'>
                    <td style='border: solid 1px grey;'>{{$info->gerencia}}</td>
                    @if($info->faltantes == 0)
                    <td style='border: solid 1px grey;font-weight:bold;'>{{$info->faltantes}}</td>
                    @else 
                    <td style='border: solid 1px grey;background-color:#FBB5B5;
                    font-weight:bold;'>{{$info->faltantes}}</td>
                    @endif

                    @if($info->desarrollados == 0)
                    <td style='border: solid 1px grey;font-weight:bold;'>{{$info->desarrollados}}</td>
                    @else 
                    <td style='border: solid 1px grey;background-color:#8BC889;
                    font-weight:bold;'>{{$info->desarrollados}}</td>
                    @endif

                    <td style='border: solid 1px grey;
                    font-weight:bold;'>
                        <button class="btn btn-default btn-sm" style="background-color:orange;"
                        id="{{$info->idGerencia}}" nombre="{{$info->gerencia}}"
                        onclick="verDetalleGerencia(this)"> <i class="fa fa-info"></i> </button>
                    </td>

                    
                    </tr>
                        @endforeach
                    </tbody>
            </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" id="cerrar" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                    </div>
            </div>
        </div>
</div>




<div class="modal inmodal fade fadeInLeftBig" id="modalInfoGerenciaDoc" tabindex="-1" role="dialog"  
    aria-hidden="true" data-backdrop="static" data-keyboard="false"  aria-hidden="true">
       <div class="modal-dialog modal-md" style="width: 90%;heigh:50%;">
           <div class="modal-content">
           <div class="modal-header" style="color:white;background-color:black;font-weight:bold;">
                <h2 style="color:white;background-color:black;font-weight:bold;">Detalles de documentos de : <a id="tituloDocGerencia"
                style="color:yellow;font-weight:bold;"></a> </h2>

                <div class="col-lg-12" style="text-align:center;background-color:#E1E1E1;">
                    <div class="col-lg-6" style="text-align:center;border-right:1px solid black;">
                        <h1 style="font-weight:bold;color:red;">Faltantes</h1>
                    </div>
                    <div class="col-lg-6" style="text-align:center;border-left:1px solid black;">
                        <h1 style="font-weight:bold;color:green;text-align:center;">Desarrollados</h1>
                    </div>   
                </div>
            </div>             

                    <div class="modal-body" style='background-color:#E1E1E1;
                    max-height: calc(75vh - 150px);
                overflow-y: auto;'>
                            
                    <div class="row">
                        <div class="col-lg-12" style="text-align:center;">
                            <div class="col-lg-6" style="text-align:center;border-right:1px solid black;">
                                <h2 style="font-weight:bold;color:blue;">Procedimientos</h2>
                                    <div id="procedimientosFaltantes" style="text-align:left;
                                    max-height:150px;overflow-y: auto;min-height:150px;background-color:white;"></div>
                                <h2 style="font-weight:bold;color:blue;">Políticas</h2>
                                <div id="politicasFaltantes" style="text-align:left;
                                    max-height:150px;overflow-y: auto;min-height:150px;background-color:white;"></div>
                            </div>

                         
                      

                            <div class="col-lg-6" style="text-align:center;border-left:1px solid black;">
                           <h2 style="font-weight:bold;color:blue;">Procedimientos</h2>
                            
                            <div id="proDes" style="text-align:left;
                                    max-height:150px;min-height:150px;overflow-y: auto;background-color:white;"></div>

                            <h2 style="font-weight:bold;color:blue;">Políticas</h2>   
                            
                            
                            <div id="polDes" style="text-align:left;
                                    max-height:150px;min-height:150px;overflow-y: auto;background-color:white;"></div>

                        </div>
                        </div>
                    </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" id="cerrarInfoGe" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                    </div>
            </div>
        </div>
</div>


@stop

@section('scripts')


   <script src="../js/funciones/politicas.js"></script>
                                    
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

   <script src="../js/plugins/dataTables/datatables.min.js"></script>
    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>

@stop