<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DocsDocumentos;
use DateTime;
use DB;


date_default_timezone_set("America/El_Salvador");

class PoliticasController extends Controller
{

    //vista de vinculación de documentos
    public function vinculacionDocs()
    { 
        
        $politica = DB::select("SELECT distinct d.*, a.nombreArea as area from docs_documentosGral d
        inner join docs_tipoDocumentosGral td on td.idTipoDoc = d.idTipoDoc
        inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
        where td.nombreTipo = 'Política' ");
        
        $procedimientos = DB::select("SELECT distinct d.*, a.nombreArea as area from docs_documentosGral d
        inner join docs_tipoDocumentosGral td on td.idTipoDoc = d.idTipoDoc
        inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
        where td.nombreTipo = 'Procedimiento' ");


        $flujogramas = DB::select("SELECT distinct d.*, a.nombreArea as area from docs_documentosGral d
        inner join docs_tipoDocumentosGral td on td.idTipoDoc = d.idTipoDoc
        inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
        where td.nombreTipo = 'Flujograma' ");

        $otros = DB::select("SELECT distinct d.*, a.nombreArea as area,td.nombreTipo as tipodoc from docs_documentosGral d
        inner join docs_tipoDocumentosGral td on td.idTipoDoc = d.idTipoDoc
        inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
        where  td.nombreTipo not in('Flujograma', 'Procedimiento', 'Política')");

        return view('PoliticasPDF.vinculacionDocs')->with('procedimientos',$procedimientos)
        ->with('flujogramas',$flujogramas)->with('otros',$otros)->with('politica',$politica);
    }



    //vista de treeview
    public function index()
    { 
       

        $AreasPolitica = DB::select("SELECT distinct  a.*  from docs_documentosGral d
        inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
        where d.idTipoDoc = 1 and d.estado= 1 order by a.nombreArea asc");
        
        $AreasProcedimientos = DB::select("SELECT distinct  a.*  from docs_documentosGral d
        inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
        where d.idTipoDoc = 2 and d.estado= 1 order by a.nombreArea asc");


        $AreasFlujogramas = DB::select("SELECT distinct  a.*  from docs_documentosGral d
        inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
        where d.idTipoDoc  in (3,7) and d.estado= 1 order by a.nombreArea asc");

        $AreasOtros = DB::select("SELECT distinct  a.*  from docs_documentosGral d
        inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
        where  d.idTipoDoc  not in (1,2,3,7) and d.estado= 1 order by a.nombreArea asc");

        $infoGerencias = DB::select("
        select g.idGerencia as idGerencia, g.nombreGerencia as gerencia,
        (select count(idDoc) from docs_documentosGral where idGerencia = 
        g.idGerencia and estado = 1) as desarrollados,
        (select count(idDoc) from docs_documentosGral where idGerencia =
         g.idGerencia and estado = 2) as faltantes
        from docs_gerencias g where g.estadoEliminado = 1 and g.idGerencia > 6
        order by 1 asc
         ");

        

        return view('PoliticasPDF.index')->with('AreasOtros',$AreasOtros)
        ->with('AreasProcedimientos',$AreasProcedimientos)
        ->with('AreasPolitica',$AreasPolitica)->with('infoGerencias',$infoGerencias);
    }

    //vista de subida de documentos
    public function tablaControlVista()
    { 
  
        $documentos = DB::select("SELECT distinct d.*, a.nombreArea as area, td.nombreTipo as nombreDoc,
        g.nombreGerencia as gerencia,
        CONVERT(varchar, d.fechaCreacionInicial, 23) as fechaCreacion  from docs_documentosGral d
        inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
        inner join docs_gerencias g on g.idGerencia = d.idGerencia
        inner join docs_tipoDocumentosGral td on td.idTipoDoc = d.idTipoDoc
        where d.estado in (1,2);");


        $clasificacionDoc = DB::table('docs_tipoDocumentosGral')->where('estadoEliminado',1)->get();

        $gerencias = DB::table('docs_gerencias')->where('estadoEliminado',1)->get();

        $gerenciasT = DB::table('docs_gerencias')->where('estadoEliminado',1)
        ->where('idGerencia','>',6)->get();

        $areas = DB::select("SELECT a.idAreaGestion as id, a.nombreArea as area, a.iniciales as iniciales
          from docs_AreasGestion a
        where a.estadoEliminado = 1 ");

        
        $tDocs = DB::table('docs_tipoDocumentosGral')->where('estadoEliminado',1)->get();
        
        return view('PoliticasPDF.tablaControl')->with('gerencias',$gerencias)
        ->with('areas',$areas)->with('tDocs',$tDocs)->with('documentos',$documentos)
        ->with('gerenciasT',$gerenciasT);
    }
    //vista de subida de documentos
    public function subirDocumentosView()
    { 
  
        $documentos = DB::select("SELECT distinct d.*, a.nombreArea as area, td.nombreTipo as nombreDoc,
        g.nombreGerencia as gerencia,
        CONVERT(varchar, d.fechaCreacionInicial, 23) as fechaCreacion  from docs_documentosGral d
        inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
        inner join docs_gerencias g on g.idGerencia = d.idGerencia
        inner join docs_tipoDocumentosGral td on td.idTipoDoc = d.idTipoDoc
        where d.estado in (1,2);");


        $clasificacionDoc = DB::table('docs_tipoDocumentosGral')->where('estadoEliminado',1)->get();

        $gerencias = DB::table('docs_gerencias')->where('estadoEliminado',1)
        ->where('idGerencia','>',6)->get();

        $areas = DB::select("SELECT a.idAreaGestion as id, a.nombreArea as area,
         a.iniciales as iniciales
          from docs_AreasGestion a
        
        where a.estadoEliminado = 1");

        $gerenciasT = DB::table('docs_gerencias')->where('estadoEliminado',1)
        ->where('idGerencia','>',6)->get();
        
        $tDocs = DB::table('docs_tipoDocumentosGral')->where('estadoEliminado',1)->get();
        
        return view('PoliticasPDF.subirDocumentos')->with('gerencias',$gerencias)
        ->with('gerenciasT',$gerenciasT)
        ->with('areas',$areas)->with('tDocs',$tDocs)->with('documentos',$documentos);
    }

    
//listar gerencias DB

    public function listarGerenciasDoc()
    {


        $gerencias = DB::table('docs_gerencias')->where('estadoEliminado',1)->get();

        $respuesta = '"data"'.response()->json($gerencias);
      

        return json_encode($gerencias);
    }

//listar areas DB
    public function listarAreasDocs()
    {

        $areas = DB::select("SELECT a.idAreaGestion as id, a.nombreArea as area
        from docs_AreasGestion a
        where a.estadoEliminado = 1 ");

        return response()->json($areas);
        
    }

//listar tipo de documentos DB 
    public function listarTipoDocs()
    {
        $tDocs = DB::table('docs_tipoDocumentosGral')->where('estadoEliminado',1)->get();

        return response()->json($tDocs);
        
    }

//eliminar tipo de documentos DB 
    public function deleteTipoDoc(Request $request){
       $id = $request['id'];

       $deleteTipoDoc =  DB::table('docs_tipoDocumentosGral')->where('idTipoDoc', $id)
        ->update(['estadoEliminado' => 2]);


        if($deleteTipoDoc==true)
            {
                return "success";
            }
            else
            {
                return "error";
            }
    }


//eliminar areas DB 
    public function deleteArea(Request $request){
        $id = $request['id'];
 
        $deleteArea =  DB::table('docs_AreasGestion')->where('idAreaGestion', $id)
         ->update(['estadoEliminado' => 2]);
 
 
         if($deleteArea==true)
             {
                 return "success";
             }
             else
             {
                 return "error";
             }
     }

//eliminar gerencias DB 
     public function deleteGerencia(Request $request){
        $id = $request['id'];
 
        $deleteGerencia =  DB::table('docs_gerencias')->where('idGerencia', $id)
         ->update(['estadoEliminado' => 2]);
 
 
         if($deleteGerencia==true)
             {
                 return "success";
             }
             else
             {
                 return "error";
             }
     }
   
//editar gerencias DB 
     public function updateGerencia(Request $request){
        $id = $request['id'];
        $nombre = $request['nombre'];
        $iniciales = $request['iniciales'];
 
        $updateGerencia =  DB::table('docs_gerencias')->where('idGerencia', $id)
         ->update(['nombreGerencia' => "$nombre", 'iniciales' => "$iniciales"]);
 
 
         if($updateGerencia==true)
             {
                 return "success";
             }
             else
             {
                 return "error";
             }
     }


//editar areas DB 
     public function updateArea(Request $request){
        $id = $request['id'];
        $nombre = $request['nombre'];
        $idGerencia = $request['idGerencia'];
        $iniciales = $request['iniciales'];
 
        $updateAreas =  DB::table('docs_AreasGestion')->where('idAreaGestion', $id)
         ->update(['nombreArea' => "$nombre" ,'idGerencia' => $idGerencia,'iniciales' => "$iniciales"  ]);
 
 
         if($updateAreas ==true)
             {
                 return "success";
             }
             else
             {
                 return "error";
             }
     }

//editar tipo de documentos DB 
     public function updateTipoDoc(Request $request){
        $id = $request['id'];
        $nombre = $request['nombre'];
 
        $updateTipoDoc =  DB::table('docs_tipoDocumentosGral')->where('idTipoDoc', $id)
         ->update(['nombreTipo' => "$nombre"]);
 
 
         if($updateTipoDoc ==true)
             {
                 return "success";
             }
             else
             {
                 return "error";
             }
    }


   //insertar tipo de documentos DB 
    public function insertTipoDoc(Request $request){
        //$id = $request['id'];
        $nombre = $request['nombre'];
 
        $insertTipoDocs =  DB::table('docs_tipoDocumentosGral')
        ->insert(['nombreTipo' => "$nombre" , 'estadoEliminado' => 1]);
 
 
         if($insertTipoDocs ==true)
             {
                 return "success";
             }
             else
             {
                 return "error";
             }
    }
    

//insertar gerencias DB
public function insertGerencia(Request $request){
        //$id = $request['id'];
        $nombre = $request['nombre'];
        $iniciales = $request['iniciales'];
 
        $insertGerencia =  DB::table('docs_gerencias')
        ->insert(['nombreGerencia' => "$nombre" , 'estadoEliminado' => 1,
        'iniciales' => "$iniciales"]);
 
 
         if($insertGerencia ==true)
             {
                 return "success";
             }
             else
             {
                 return "error";
             }
}


    //insertar areas DB
public function insertArea(Request $request){
        //$id = $request['id'];
        $nombre = $request['nombre'];
        $iniciales = $request['iniciales'];

        $insertArea =  DB::table('docs_AreasGestion')
        ->insert(['nombreArea' => "$nombre", 'estadoEliminado' => 1,
        'iniciales' => "$iniciales"]);
 
 
         if($insertArea ==true)
             {
                 return "success";
             }
             else
             {
                 return "error";
             }
}




public function guardarDocumento(Request $request){
    
    function quitar_tildes($cadena) {
        $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹",'Ñ');
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
        $texto = str_replace($no_permitidas, $permitidas ,$cadena);
        return $texto;
        }


        function limpia_espacios($cadena){
            $cadena = str_replace(' ', '', $cadena);
            return $cadena;
          }

        # definimos la carpeta destino
        $carpetaDestino='../PDF/';
        $carpetaDestinoArchivo='../public/PDF/';
        # obtenemos variables

    $area = $request["areaDoc"];
    $gerenciaDoc = $request["gerenciaDoc"];
    $clasificacion = $request["clasDoc"];
    $periodoAP = $request["periodoAp"];
    $titulo = $request["titulo"];
    $descripcion = $request["descripcion"];
    $estado = $request["estadoDoc"];
    $ruta = limpia_espacios(quitar_tildes($carpetaDestino.$request["ruta"]));
    $fecha = date('Ymd H:i:s');
    $codigo = $request["cod"];
    $fechaSinFormato = date_create_from_format('Y-m-d',$request['fechaCreacion']);

    $fechaCreacion = date_format($fechaSinFormato,'Ymd H:i');
 
    # si hay algun archivo que subir
    if(isset($_FILES["archivo"]) && $_FILES["archivo"]["name"][0])
    {
 
        # recorremos todos los arhivos que se han subido
        for($i=0;$i<count($_FILES["archivo"]["name"]);$i++)
        {
             
 
                # si exsite la carpeta o se ha creado
                if(file_exists($carpetaDestino) || @mkdir($carpetaDestino))
                {
                    $origen=limpia_espacios(quitar_tildes($_FILES["archivo"]["tmp_name"][$i]));
                    $destino=limpia_espacios(quitar_tildes($carpetaDestinoArchivo.$_FILES["archivo"]["name"][$i]));
 
                    # movemos el archivo
                    if(@move_uploaded_file($origen, $destino))
                    {
                        $insertDoc =  DB::table('docs_documentosGral')
                        ->insert(['titulo' => "$titulo" , 'descripcion' => $descripcion,
                         'fechaCreacion' => "$fecha", 'fechaUltimaRevision' => "$fecha",
                         'ruta' => "$ruta","estado" => $estado, 'idTipoDoc' => $clasificacion,
                         'periodoAplicacion' => "$periodoAP", 'idAreaGestion' => $area,
                         'codIndicador' => $codigo,'fechaCreacionInicial' => $fechaCreacion,
                         'idGerencia' => $gerenciaDoc
                         ]);
                 
                 
                         if($insertDoc ==true)
                             {
                                 return 1;
                             }
                             else
                             {
                                 return 4;
                             }
                    }else{
                        return 2;
                    }
                }else{
                    return 3;
                }
          
        }
    }else{
        $insertDocu =  DB::table('docs_documentosGral')
                        ->insert(['titulo' => "$titulo" , 'descripcion' => $descripcion,
                         'fechaCreacion' => "$fecha", 'fechaUltimaRevision' => "$fecha",
                         'ruta' => "$ruta","estado" => $estado, 'idTipoDoc' => $clasificacion,
                         'periodoAplicacion' => "$periodoAP", 'idAreaGestion' => $area,
                         'codIndicador' => $codigo,'fechaCreacionInicial' => $fechaCreacion,
                         'idGerencia' => $gerenciaDoc
                         ]);
                 
                 
                         if($insertDocu ==true)
                             {
                                 return 1;
                             }
                             else
                             {
                                 return 4;
                             }
    }

}




    //listado de politicas asociadas al procedimiento
public function listadoDocumentoAsociado(Request $request){
    $id = $request['id'];

    $areas = DB::select("SELECT distinct d.*, a.nombreArea as area,dp.* from docs_documentosGral d
    inner join docs_tipoDocumentosGral td on td.idTipoDoc = d.idTipoDoc  
    inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
    inner join docs_RelacionPadre_Hijos dp on dp.idDocHijo = d.idDoc
    where dp.idDocPadre = $id ");

        return response()->json($areas);


   
 }


 


 public function proFaltante(Request $request){
    $id = $request['idGerencia'];

    $areas = DB::select("SELECT  d.titulo as titulo, a.nombreArea as area from docs_documentosGral d
      
    inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
    where d.idGerencia = $id and d.idTipoDoc = 2 and d.estado = 2 ");

        return response()->json($areas);


   
 }



 public function polFaltante(Request $request){
    $id = $request['idGerencia'];

    $areas = DB::select("SELECT  d.titulo as titulo, a.nombreArea as area from docs_documentosGral d
      
    inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
    where d.idGerencia = $id  and d.idTipoDoc = 1 and d.estado = 2");

        return response()->json($areas);


   
 }



 public function proDes(Request $request){
    $id = $request['idGerencia'];

    $areas = DB::select("SELECT  d.titulo as titulo, a.nombreArea as area from docs_documentosGral d
      
    inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
    where d.idGerencia = $id and d.idTipoDoc = 2 and d.estado = 1 ");

        return response()->json($areas);


   
 }



 public function polDes(Request $request){
    $id = $request['idGerencia'];

    $areas = DB::select("SELECT  d.titulo as titulo, a.nombreArea as area from docs_documentosGral d
      
    inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
    where d.idGerencia = $id  and d.idTipoDoc = 1 and d.estado = 1");

        return response()->json($areas);


   
 }

 public function buscadorDocs(Request $request)
    {
        $palabra = $request["palabra"];

        $docs = DB::select("SELECT * from docs_documentosGral
        where titulo like '%".$palabra."%' and estado in (1,2) ");

        return response()->json($docs);
        
    }


    public function detalleDocumentos(Request $request)
    {
        $id = $request["id"];

        $info = DB::select("SELECT distinct dg.nombreGerencia as gerencia,  dar.nombreArea as area,
         td.nombreTipo as clasificacion, do.periodoAplicacion as periodoAplicacion,
        CONVERT(VARCHAR(10), do.fechaCreacionInicial , 103) as fechaCreacion,
        do.descripcion as descripcion,'----' as documentoPadre from docs_documentosGral do
        inner join docs_tipodocumentosGral td on td.idTipoDoc = do.idTipoDoc
        inner join docs_AreasGestion dar on dar.idAreaGestion = do.idAreaGestion
        inner join docs_gerencias dg on dg.idGerencia = do.idGerencia
        where do.idDoc = '".$id."' and do.estado in (1,2) ");

        return response()->json($info);
        
    }


 public function mostrarDocumentoDisponible(Request $request){
    $id = $request['id'];

    $areas = DB::select("SELECT distinct d.*, a.nombreArea as area from docs_documentosGral d
    inner join docs_tipoDocumentosGral td on td.idTipoDoc = d.idTipoDoc  
    inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
    inner join docs_RelacionPadre_Hijos dp on dp.idDocHijo = d.idDoc
    where dp.idDocPadre = $id ");

        return response()->json($areas);
 }



 public function relacionarDocumentos(Request $request){
    $idPadre =  $request['idPadre'];
    $idHijo =  $request['idHijo'];


    if( DB::table('docs_RelacionPadre_Hijos')->where('idDocPadre',$idPadre)
    ->where('idDocHijo',$idHijo)->exists() ){
        return 1;
    }else{
        $insertRelacion =  DB::table('docs_RelacionPadre_Hijos')
        ->insert(['idDocPadre' => $idPadre , 'idDocHijo' => $idHijo]);
 
 
         if($insertRelacion ==true)
             {
                 return 2;
             }
    }

 }


 public function eliminarRelacionDoc(Request $request){
    $idPadre = $request['idPadre'];
    $idHijo = $request['idHijo'];

    $deleteRelacion =  DB::table('docs_RelacionPadre_Hijos')->where('idDocPadre',$idPadre)
    ->where('idDocHijo',$idHijo)->delete();

     if($deleteRelacion ==true)
         {
             return 1;
         }
         else
         {
             return 0;
         }
}



public function getInicial(Request $request){
    $identificador = $request['identificador'];
    $identi = $request['identiGe'];

    $iniciales =  DB::select("select (
        select iniciales from docs_gerencias where idGerencia = ".$identi."
        ) as inicialGerencia,
        (
        select iniciales from docs_areasGestion where idAreaGestion = ".$identificador."
        ) as inicialesArea ");
  
     return response()->json($iniciales);    
}

public function getLastDocu(Request $request){
    $identificador = $request['identificador'];
    $idTipoDoc = $request['idDoc'];

    $iniciales =  DB::select("SELECT count(idDoc)+1 as lastDoc from docs_documentosGral
    where idAreaGestion = $identificador and idTipoDoc = $idTipoDoc and estado in(1,2) ");
  
     return response()->json($iniciales);    
}



// eliminar  documentos DB 
    public function eliminarDocumentos(Request $request){
       $id = $request['id'];

       $deleteTipoDoc =  DB::table('docs_documentosGral')->where('idDoc', $id)
        ->update(['estado' => 3]);


        if($deleteTipoDoc==true)
            {
                return 1;
            }
            else
            {
                return 0;
            }
    }


    public function listarDocumentosCtrl(Request $request){
        $id = $request['id'];

        $doc =  DB::select("SELECT distinct d.*, a.nombreArea as area, td.nombreTipo as nombreDoc,
        g.nombreGerencia as gerencia from docs_documentosGral d
        inner join docs_AreasGestion a on a.idAreaGestion = d.idAreaGestion
        inner join docs_gerencias g on g.idGerencia = a.idGerencia
        inner join docs_tipoDocumentosGral td on td.idTipoDoc = d.idTipoDoc
        where d.idDoc = $id ");
      
         return response()->json($doc);    

    }




    public function editarDocumento(Request $request){
    
        function quitar_tildes($cadena) {
            $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
            $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
            $texto = str_replace($no_permitidas, $permitidas ,$cadena);
            return $texto;
            }
    
    
            function limpia_espacios($cadena){
                $cadena = str_replace(' ', '', $cadena);
                return $cadena;
              }
    
            # definimos la carpeta destino
            $carpetaDestino='../PDF/';
            $carpetaDestinoArchivo='../public/PDF/';
            # obtenemos variables
        $id = $request["idDetalleDoc"];
        $area = $request["areaDocCtrl"];
        $gerencia = $request["gerenciaDocCtrl"];
        $clasificacion = $request["clasDocCtrl"];
        $periodoAP = $request["periodoApCtrl"];
        $titulo = $request["tituloCtrl"];
        $descripcion = $request["descripcionCtrl"];
        $estado = $request["estadoDocCtrl"];
        $ruta = limpia_espacios(quitar_tildes($carpetaDestino.$request["rutaCtrl"]));
        $fecha = date('Ymd H:i:s');
        $codigo = $request["codCtrl"];
        $fechaSinFormato = date_create_from_format('Y-m-d',$request['fechaCreacionCtrl']);
    
        $fechaCreacion = date_format($fechaSinFormato,'Ymd H:i');
     
        # si hay algun archivo que subir
        if(isset($_FILES["archivo"]) && $_FILES["archivo"]["name"][0])
        {
     
            # recorremos todos los arhivos que se han subido
            for($i=0;$i<count($_FILES["archivo"]["name"]);$i++)
            {
                 
     
                    # si exsite la carpeta o se ha creado
                    if(file_exists($carpetaDestino) || @mkdir($carpetaDestino))
                    {
                        $origen=limpia_espacios(quitar_tildes($_FILES["archivo"]["tmp_name"][$i]));
                        $destino=limpia_espacios(quitar_tildes($carpetaDestinoArchivo.$_FILES["archivo"]["name"][$i]));
     
                        # movemos el archivo
                        if(@move_uploaded_file($origen, $destino))
                        {
                            $updateDocu = DB::table('docs_documentosGral')->where('idDoc', $id)
                            ->update(['titulo' => "$titulo" , 'descripcion' => $descripcion,
                            'fechaCreacion' => "$fecha", 'fechaUltimaRevision' => "$fecha",
                            'ruta' => "$ruta","estado" => $estado, 'idTipoDoc' => $clasificacion,
                            'periodoAplicacion' => "$periodoAP", 'idAreaGestion' => $area,
                            'codIndicador' => $codigo,'fechaCreacionInicial' => $fechaCreacion,
                            'idGerencia' => $gerencia
                           ]);
                     
                     
                             if($updateDocu ==true)
                                 {
                                     return 1;
                                 }
                                 else
                                 {
                                     return 4;
                                 }
                        }else{
                            return 2;
                        }
                    }else{
                        return 3;
                    }
              
            }
        }else{
            $updateDocu = DB::table('docs_documentosGral')->where('idDoc', $id)
            ->update(['titulo' => "$titulo" , 'descripcion' => $descripcion,
            'fechaCreacion' => "$fecha", 'fechaUltimaRevision' => "$fecha",
            'ruta' => "$ruta","estado" => $estado, 'idTipoDoc' => $clasificacion,
            'periodoAplicacion' => "$periodoAP", 'idAreaGestion' => $area,
            'codIndicador' => $codigo,'fechaCreacionInicial' => $fechaCreacion,
            'idGerencia' => $gerencia
           ]);
                     
                     
                             if($updateDocu ==true)
                                 {
                                     return 1;
                                 }
                                 else
                                 {
                                     return 4;
                                 }
        }
    
    }



}






?>