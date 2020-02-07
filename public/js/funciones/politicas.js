$(document).ready(function(){
   // $('.navbar-minimalize').click();

    
        $('#areaDoc').change(function(){
            $('#tipoDiv').removeClass('hidden');
        });


        $('#tipoDoc').change(function(){
            $('#tituloDiv').removeClass('hidden');
        });

        $('#tituloDoc').change(function(){
            $('#botonVer').removeClass('hidden');
        });


        $('#btnVer').click(function(){
            $('#modalPDF').modal('show');
        });   
});  



$("#btnDocsGral").click(function(){
    $("#docsGenerales").removeClass("hidden");
    $("#docsPoliticas").addClass("hidden");
    $("#docsProcedimientos").addClass("hidden");
    $("#visor").html('');
    $("#recargar").hide();
    $("#maximizar").hide();
    $("#titulo").hide();
    $(".docsListOtro").hide();
    $(".docsListPol").hide();
    $(".docsListPro").hide();

    $("#btnDocsGral").css("background-color","black");
    $("#btnDocsGral").css("height","50px");

    $("#btnDocsPol").css("background-color","#024EA4");
    $("#btnDocsPol").css("height","38px");

    $("#btnDocsPro").css("background-color","#AD4F01");
    $("#btnDocsPro").css("height","38px");
});


$("#btnDocsPol").click(function(){
    $("#docsGenerales").addClass("hidden");
    $("#docsPoliticas").removeClass("hidden");
    $("#docsProcedimientos").addClass("hidden");
    $("#visor").html('');
    $("#recargar").hide();
    $("#maximizar").hide();
    $("#titulo").hide();
    $(".docsListOtro").hide();
    $(".docsListPol").hide();
    $(".docsListPro").hide();

    $("#btnDocsPol").css("background-color","black");
    $("#btnDocsPol").css("height","50px");

    $("#btnDocsPro").css("background-color","#AD4F01");
    $("#btnDocsPro").css("height","38px");

    $("#btnDocsGral").css("background-color","#057C13");
    $("#btnDocsGral").css("height","38px");

});

$("#btnDocsPro").click(function(){
    $("#docsGenerales").addClass("hidden");
    $("#docsPoliticas").addClass("hidden");
    $("#docsProcedimientos").removeClass("hidden");
    $("#visor").html('');
    $("#recargar").hide();
    $("#maximizar").hide();
    $("#titulo").hide();
    $(".docsListOtro").hide();
    $(".docsListPol").hide();
    $(".docsListPro").hide();


    $("#btnDocsPro").css("background-color","black");
    $("#btnDocsPro").css("height","50px");


    $("#btnDocsGral").css("background-color","#057C13");
    $("#btnDocsGral").css("height","38px");

    $("#btnDocsPol").css("background-color","#024EA4");
    $("#btnDocsPol").css("height","38px");
});

$(".areaOtros").click(function(){
    $("#recargar").show();
    var idA = this.id;
   $(".docsListOtro").hide();
    $("#DocumOtro"+idA).show();
    $("button[name=btnHideDocG"+idA).removeClass("hidden");
});

 
$(".areaPol").click(function(){
    $("#recargar").show();
    var idA = this.id;
    $(".docsListPol").hide();
    $("#DocumPol"+idA).show();

    
    $("button[name=btnHidePol"+idA).removeClass("hidden");
});

$(".areaPro").click(function(){
    $("#recargar").show();
    var idA = this.id;
   $(".docsListPro").hide();
    $("#DocumPro"+idA).show();
    $("button[name=btnHidePro"+idA).removeClass("hidden");
});

$(".tipDocs").click(function(){
    var idA = this.id;
    $(".docsList").hide(); 
    $(".let2").hide();
    $("#Docum"+idA).show();
    $("#letraDocs"+idA).hide();
    $("#letraDocs"+idA).show();
});


$(".verAnexo").click(function(){
    var idA = this.id;
    $(".anexoList").hide();
    $("#Anexo"+idA).show();
    $("#letraAnexo"+idA).hide();
    $("#letraAnexo"+idA).show();
});


$("#recargar").click(function(){
    location.reload();
});


var verDoc =(ele)=>{
    var idA = $(ele).attr("id");
    var title = $(ele).attr("nombre");
  

  // alert(idA);
    
    $("#visor").html('');
    $("#visor").html('<object data="'+idA+'" type="application/pdf" width="100%" height="530px" ></object>');

    $("#visor").show();
    $("#maximizar").show();
    
    $("#titulo").html(title);
    $("#titulo").show();
}
    


    

$("#maximizar").click(function(){
   var contenido = $("#visor").html(); 
   var tituloModal = $("#titulo").html();

   $("#vista").html(contenido);
   $("#tituloModal").html(tituloModal);
   $("#modalView").modal("show");
});



var verDocu =(ele)=>{
    var idA = $(ele).attr("id");
    var title = $(ele).attr("nombre");
    var ruta = $(ele).attr("ruta");
    var fila='';
    var fila1='';
    
    $("#info").hide();
    $("#visor1").html('');
    $("#visor1").html('<object data="'+ruta+'" type="application/pdf" width="100%" height="530px" ></object>');

    $("#visor1").show();
    $("#maximizar1").show();
    
    $("#titulo1").html(title);
    $("#titulo1").show();

   

    $.ajax({
        url:'detalleDocumento',
        datatype:'json',
        type:'post',
        data:{id: idA},
        success:function(data)
        {
            for(var i=0; i<data.length; i++)
            {
                fila1+="<div style='background-color:#D8D8D8;";
                fila1+="-webkit-box-shadow: 10px 10px 5px 0px rgba(133,131,133,1);";
                fila1+="-moz-box-shadow: 10px 10px 5px 0px rgba(133,131,133,1);";
                fila1+="box-shadow: 10px 10px 5px 0px rgba(133,131,133,1);'>";
                fila1+="<div style='margin-left:20px'>"
                fila1+="<br><h3 style='color:blue;'>Detalles del documento </h3>";
                fila1+="<b>Gerencia: </b> "+data[i].gerencia+" ";
                fila1+="<br><br><b>Área: </b> "+data[i].area+"";
                fila1+="<br><br><b>Clasificación: </b> "+data[i].clasificacion+"";
                fila1+="<br><br><b>Fecha de creación: </b> "+data[i].fechaCreacion+"";
                fila1+="<br><br><b>Descripción: </b> "+data[i].descripcion+" <br><br></div></div>";
            }
            $("#info").html(fila1);
            $("#info").show();
        }
    });
}
    
var verDocInfo =(ele)=>{
    var idA = $(ele).attr("id");
    var title = $(ele).attr("nombre");
    var fila='';
    var fila1='';

    $("#infoModal").html('');

    $.ajax({
        url:'detalleDocumento',
        datatype:'json',
        type:'post',
        data:{id: idA},
        success:function(data)
        {
            for(var i=0; i<data.length; i++)
            {
                fila1+="<div style='background-color:#D8D8D8;font-size:16px;";
                fila1+="-webkit-box-shadow: 10px 10px 5px 0px rgba(133,131,133,1);";
                fila1+="-moz-box-shadow: 10px 10px 5px 0px rgba(133,131,133,1);";
                fila1+="box-shadow: 10px 10px 5px 0px rgba(133,131,133,1);'>";
                fila1+="<br><h3 style='color:blue;margin-left:20px;'>Detalles del documento "+title+"</h3>";
                fila1+="<div style='margin-left:20px;'><b>Gerencia: </b> "+data[i].gerencia+" ";
                fila1+="<br><br><b>Área: </b> "+data[i].area+"";
                fila1+="<br><br><b>Clasificación: </b> "+data[i].clasificacion+"";
                fila1+="<br><br><b>Fecha de creación: </b> "+data[i].fechaCreacion+"";
                fila1+="<br><br><b>Período de Aplicación: </b> "+data[i].periodoAplicacion+"";
                fila1+="<br><br><b>Descripción: </b> "+data[i].descripcion+" <br><br></div></div>";
            }
            $("#infoModal").html(fila1);
            $("#modalInfo").modal("show");
        }
    });
}


$("#maximizar1").click(function(){
   var contenido = $("#visor1").html(); 
   var tituloModal = $("#titulo1").html();
   
   $("#vista").html(contenido);
   $("#tituloModal").html(tituloModal);
   $("#modalView").modal("show");
});



$("#buscador").click(function(){
    $("#vistaBuscador").show();
    $("#general").show();

    $("#vistaNormal").hide();
    $("#buscador").hide();
});

$("#general").click(function(){
    $("#vistaNormal").show();
    $("#buscador").show();

    $("#vistaBuscador").hide();
    $("#general").hide();
});

$("#buscar").click(function(){
    $("#respuesta").html('');
    $("#visor1").html('');
    $("#maximizar1").hide();
    $("#titulo1").hide();
    $("#info").hide();

    var palabra = $("#palabra").val();
    var fila ="";

  $.ajax({
    url:'buscador',
    datatype:'json',
    type:'post',
    data:{palabra: palabra},
    success:function(data)
    {
        if(data.length < 1){
            Swal.fire({
                title: 'No se encontró ningún documento',
                imageUrl: '../images/alert.gif',
                imageWidth: 185,
                imageHeight: 160,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
              });
        }else{
            for(var i=0; i<data.length; i++)
            {
                fila+="<button style='background-color:#A30F06;color:white;' ";
                fila+="id = '"+data[i].idDoc+"' class='button_slide slide_left'> ";
                fila+="<i class='fa fa-file'></i> "+data[i].titulo+" ";
                fila+="</button> ";
                
                fila+="<a class='btn btn-default btn-sm' ruta = '"+data[i].ruta+"' id='"+data[i].idDoc+"' ";
                fila+="nombre = '"+data[i].titulo+"' onclick='verDocu(this)' ";
                fila+="style='background-color:#868585;color:white; ";
                fila+="text-align:center;'> ";
                fila+="<i class='fa fa-eye' style='text-align:center;'></i></a><br><br>"; 
            }
        }
        
        $("#respuesta").html(fila);
        
    }
});






});


//when the Add Field button is clicked
$("#add").click(function (e) {
    //Append a new row of code to the "#items" div
    $("#items").append('<div><input name="input[]" type="text" /><button class="delete">Delete</button></div>'); 
});


$("body").on("click", ".delete", function (e) {
	$(this).parent("div").remove();
});



$("#btnInfoGerencias").click(function(){
    $("#modalInfoGerencias").modal("show");
});

verDetalleGerencia=(ele)=>{
    
    var idGerencia = $(ele).attr("id");
    var title = $(ele).attr("nombre"); 

    var fila1 ='';
    $.ajax({
        url:'proFaltantes',
        datatype:'json',
        type:'post',
        data:{idGerencia: idGerencia},
        success:function(data)
        {
            
                if(data.length < 1){
                    fila1+="<h1 style='color:purple;font-weight:bold;text-align:center;margin-top:50px;'>No hay datos guardados</h1>";
                
                }else{
                    for(var i=0; i<data.length; i++)
                    {
                fila1+="<div style='margin-left:20px;text-align:left;'><b>Título: </b> "+data[i].titulo+"";
                fila1+="<br><b>Área: </b> "+data[i].area+" <br><br></div></div>";
                }
            }
            $("#procedimientosFaltantes").html(fila1);
           
        }
    });



    var fila2 ='';
    $.ajax({
        url:'polFaltantes',
        datatype:'json',
        type:'post',
        data:{idGerencia: idGerencia},
        success:function(data)
        {
           
                if(data.length < 1){
                    fila2+="<h1 style='color:purple;font-weight:bold;text-align:center;margin-top:50px;'>No hay datos guardados</h1>";
                
                }else{
                        for(var i=0; i<data.length; i++)
                        {
                            fila2+="<div style='margin-left:20px;text-align:left;'><b>Título: </b> "+data[i].titulo+"";
                            fila2+="<br><b>Área: </b> "+data[i].area+" <br><br></div></div>";
                        }
                    }
            $("#politicasFaltantes").html(fila2);
           
        }
    });


    var fila3 ='';
    $.ajax({
        url:'proDesa',
        datatype:'json',
        type:'post',
        data:{idGerencia: idGerencia},
        success:function(data)
        {
            
           
                if(data.length < 1){
                    fila3+="<h1 style='color:purple;font-weight:bold;text-align:center;margin-top:50px;'>No hay datos guardados</h1>";
                
                }else{
                    for(var i=0; i<data.length; i++)
                    {
                fila3+="<div style='margin-left:20px;text-align:left;'><b>Título: </b> "+data[i].titulo+"";
                fila3+="<br><b>Área: </b> "+data[i].area+" <br><br></div></div>";
                }
            }
            $("#proDes").html(fila3);
           
        }
    });


    var fila4 ='';
    $.ajax({
        url:'polDesa',
        datatype:'json',
        type:'post',
        data:{idGerencia: idGerencia},
        success:function(data)
        {
            
                if(data.length < 1){
                    fila4+="<h1 style='color:purple;font-weight:bold;text-align:center;margin-top:50px;'>No hay datos guardados</h1>";
                
                }else{
                    for(var i=0; i<data.length; i++)
            {
                    fila4+="<div style='margin-left:20px;text-align:left;'><b>Título: </b> "+data[i].titulo+"";
                    fila4+="<br><b>Área: </b> "+data[i].area+" <br><br></div></div>";
                }
           
                
            }
            $("#polDes").html(fila4);
           
        }
    });

    


    $("#tituloDocGerencia").text(title);

    $("#modalInfoGerencias").modal("hide");
    $("#modalInfoGerenciaDoc").modal("show");

}

$("#cerrarInfoGe").click(function(){
    
    $("#modalInfoGerenciaDoc").modal("hide");
    $("#modalInfoGerencias").modal("show");
});


verAnexos=(ele)=>{
    var id = $(ele).attr("id");

    $("#Anexo"+id).show();
    

    $("button[name=btnVi"+id).addClass("hidden");

    //$(".btnVi"+idDoc).addClass("hidden");
    $("button[name=btnFal"+id).removeClass("hidden");
}


var hideAnexos=(ele)=>{
    var id = $(ele).attr("id");
    $("#Anexo"+id).hide();


    $("button[name=btnVi"+id).removeClass("hidden");

    //$(".btnVi"+idDoc).addClass("hidden");
    $("button[name=btnFal"+id).addClass("hidden");
    $("#visor").html('');
    $("#recargar").hide();
    $("#maximizar").hide();
    $("#titulo").hide();
}


var hidePro=(ele)=>{
    var idA = $(ele).attr("id");
    $("#DocumPro"+idA).hide();
    $("button[name=btnHidePro"+idA).addClass("hidden");
}


var hidePol=(ele)=>{
    var idA = $(ele).attr("id");
    $("#DocumPol"+idA).hide();
    $("button[name=btnHidePol"+idA).addClass("hidden");
}


var hideDocG=(ele)=>{
    var idA = $(ele).attr("id");
    $("#DocumOtro"+idA).hide();
    $("button[name=btnHideDocG"+idA).addClass("hidden");
}