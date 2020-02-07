$(document).ready(function(){

    alertify.defaults.title = "Confirmación";
    alertify.defaults.transition = "zoom";
    alertify.defaults.theme.ok = "btn btn-info";
    alertify.defaults.theme.cancel = "btn btn-danger";  

   $("#areaDoc").select2();
   $("#clasDoc").select2();
   $("#periodoAp").select2();
   
   $("#gerenciaDoc").select2();
});


$(document).on('change', 'input[type=file]', function(e) {
    
    var TmpPath = $(this).val();
        

    $('#ruta').val(TmpPath.substr(12));
    $('#rutaCtrl').val(TmpPath.substr(12))
  });

$('#btnGerencias').click(function(){
    $('#modalGerencias').modal('show');
   
    $("#insertGerencia").removeClass("hidden");
    $("#editGerencia").addClass("hidden");

}); 


$('#btnAreas').click(function(){
    $('#modalAreas').modal('show');

    $("#insertArea").removeClass("hidden");
    $("#editArea").addClass("hidden");
}); 



$('#btnTDocs').click(function(){
    $('#modalTDocs').modal('show');
});          


$(".cerrar").click(function(){
    location.reload();
});


var editarGerencia =(ele)=>{
    var nombre = $(ele).attr("nombre");
    var id = $(ele).attr("id");
    var iniciales = $(ele).attr("iniciales");

    $("#txtGerencia").val(nombre);
    $("#idGerencia").val(id);
    $("#txtInicialesGerencia").val(iniciales);

    $("#insertGerencia").addClass("hidden");
    $("#editGerencia").removeClass("hidden");
}


var editarArea =(ele)=>{
    var nombre = $(ele).attr("nombre");
    var id = $(ele).attr("id");
    var gerencia = $(ele).attr("idGerencia");
    var iniciales = $(ele).attr("iniciales");

    $("#txtAreaGestion").val(nombre);
    $("#txtIdArea").val(id);
    $("#idGerenciaArea").val(gerencia);
    $("#txtInicialesArea").val(iniciales);

    $("#insertArea").addClass("hidden");
    $("#editArea").removeClass("hidden");
}

var editarTDoc =(ele)=>{
    var nombre = $(ele).attr("nombre");
    var id = $(ele).attr("id");

    $("#txtTipoDoc").val(nombre);
    $("#idTipoDoc").val(id);

    $("#insertTDoc").addClass("hidden");
    $("#editTDoc").removeClass("hidden");
}

var eliminarGerencia =(ele)=>{

    var nombre = $(ele).attr("nombre");
    var id = $(ele).attr("id");

    $('#modalGerencias').modal('hide');

    alertify.confirm("¿Desea eliminar a "+nombre+"?",
            function(){
                $.ajax({
                    url:'deleteGerencias',
                    datatype:'json',
                    type:'post',
                    data:{id: id},
                    success:function(data)
                    {

                            new PNotify({
                                title: 'Muy bien!',
                                text: 'Gerencia eliminada con éxito',
                                type: 'error',
                                delay:4000,
                                after_close:location.reload(),
                            });

                        //    $('#modalTDocs').modal('show');

                        location.reload();
                    }
                });
            },
            function(){
               
                alertify.error('Cancelado');
                $('#modalGerencias').modal('show');
            }); 

}



var eliminarArea =(ele)=>{

    var nombre = $(ele).attr("nombre");
    var id = $(ele).attr("id");

    $('#modalAreas').modal('hide');

    alertify.confirm("¿Desea eliminar el área: "+nombre+"?",
            function(){
                
                $.ajax({
                    url:'deleteAreas',
                    datatype:'json',
                    type:'post',
                    data:{id: id},
                    success:function(data)
                    {
            
                        $("#modaAreas").modal("toggle");
            
                      
                            new PNotify({
                                title: 'Muy bien!',
                                text: 'Area eliminada con éxito',
                                type: 'error'
                            });
                           // $('#modalAreas').modal('show');l
                           location.reload();
                    }
                });
            },
            function(){
               
                alertify.error('Cancelado');
                $('#modalAreas').modal('show');
            }); 

}


var eliminarTDoc=(ele)=>{

    var nombre = $(ele).attr("nombre");
    var id = $(ele).attr("id");

    $('#modalTDocs').modal('hide');

    alertify.confirm("¿Desea eliminar el tipo de documento: "+nombre+"?",
            function(){
                


                $.ajax({
                    url:'deleteTDocs',
                    datatype:'json',
                    type:'post',
                    data:{id: id},
                    success:function(data)
                    {

                            new PNotify({
                                title: 'Muy bien!',
                                text: 'Tipo de Documento eliminado con éxito',
                                type: 'error',
                                delay:4000,
                                after_close:location.reload(),
                            });

                        //    $('#modalTDocs').modal('show');

                        location.reload();
                    }
                });
            },
            function(){
               
                alertify.error('Cancelado');
                $('#modalTDocs').modal('show');
            }); 

}



$("#editGerencia").click(function(){
    var nombre = $("#txtGerencia").val();
    var iniciales = $("#txtInicialesGerencia").val();
    var id = $("#idGerencia").val();

    $('#modalGerencias').modal('hide');

    alertify.confirm("¿Desea modificar el elemento seleccionado?",
            function(){
                
                $.ajax({
                    url:'updateGerencias',
                    datatype:'json',
                    type:'post',
                    data:{id: id,
                        nombre:nombre,
                        iniciales:iniciales,
                    },
                    success:function(data)
                    {
            
                       // $("#modalGerencias").modal("toggle");
            
                      
                            new PNotify({
                                title: 'Muy bien!',
                                text: 'Gerencia modificada con éxito',
                                type: 'success'
                            });
                            $("#insertGerencia").removeClass("hidden");
                            $("#editGerencia").addClass("hidden");
                           location.reload();
                    }
                });
            },
            function(){
               
                alertify.error('Cancelado');
                $('#modalGerencias').modal('show');
            }); 
});


$("#editArea").click(function(){
    var nombre = $("#txtAreaGestion").val();
    var id = $("#txtIdArea").val();
    var idGerencia = $("#idGerenciaArea").val();
    var iniciales = $("#txtInicialesArea").val();

    $('#modalAreas').modal('hide');

    alertify.confirm("¿Desea modificar el elemento seleccionado?",
            function(){
                
                $.ajax({
                    url:'updateAreas',
                    datatype:'json',
                    type:'post',
                    data:{id: id,
                        nombre:nombre,
                        idGerencia:idGerencia,
                        iniciales:iniciales,
                    },
                    success:function(data)
                    {
            
                       // $("#modalGerencias").modal("toggle");
            
                      
                            new PNotify({
                                title: 'Muy bien!',
                                text: 'Area modificada con éxito',
                                type: 'success'
                            });
                            $("#insertArea").removeClass("hidden");
                            $("#editArea").addClass("hidden");
                           location.reload();
                    }
                });
            },
            function(){
               
                alertify.error('Cancelado');
                $('#modalAreas').modal('show');
            }); 
});


$("#editTDoc").click(function(){
    var nombre = $("#txtTipoDoc").val();
    var id = $("#idTipoDoc").val();

    $('#modalTDocs').modal('hide');

    alertify.confirm("¿Desea modificar el elemento seleccionado?",
            function(){
                
                $.ajax({
                    url:'updateTipoDocs',
                    datatype:'json',
                    type:'post',
                    data:{id: id,
                        nombre:nombre,
                    },
                    success:function(data)
                    {
                        new PNotify({
                            title: 'Muy bien!',
                            text: 'Tipo de documento modificado con éxito',
                            type: 'success'
                        });
                        $("#insertTDoc").removeClass("hidden");
                        $("#editTDoc").addClass("hidden");
                        location.reload();
                    }
                });
            },
            function(){
               
                alertify.error('Cancelado');
                $('#modalTDocs').modal('show');
            }); 
});



$("#insertTDoc").click(function(){
    var nombre = $("#txtTipoDoc").val();

    $('#modalTDocs').modal('hide');

    alertify.confirm("¿Desea insertar el nuevo tipo de documento?",
            function(){
                
                $.ajax({
                    url:'insertTipoDocs',
                    datatype:'json',
                    type:'post',
                    data:{
                        nombre:nombre,
                    },
                    success:function(data)
                    {
                        new PNotify({
                            title: 'Muy bien!',
                            text: 'Tipo de documento ingresado con éxito',
                            type: 'success'
                        });
                        $("#insertTDoc").removeClass("hidden");
                        $("#editTDoc").addClass("hidden");
                        location.reload();
                    }
                });
            },
            function(){
               
                alertify.error('Cancelado');
                $('#modalTDocs').modal('show');
            }); 
});




$("#insertGerencia").click(function(){
    var nombre = $("#txtGerencia").val();
    var iniciales = $("#txtInicialesGerencia").val();
    
    $('#modalGerencias').modal('hide');

    alertify.confirm("¿Desea insertar la nueva gerencia?",
            function(){
                
                $.ajax({
                    url:'insertGerencias',
                    datatype:'json',
                    type:'post',
                    data:{
                        nombre:nombre,
                        iniciales:iniciales,
                    },
                    success:function(data)
                    {
                        new PNotify({
                            title: 'Muy bien!',
                            text: 'Gerencia ingresada con éxito',
                            type: 'success'
                        });
                        $("#insertGerencia").removeClass("hidden");
                        $("#editGerencia").addClass("hidden");
                        location.reload();
                    }
                });
            },
            function(){
               
                alertify.error('Cancelado');
                $('#modalGerencias').modal('show');
            }); 
});



$("#insertArea").click(function(){
    var nombre = $("#txtAreaGestion").val();
    var idGerenciaArea = $("#idGerenciaArea").val();
    var iniciales = $("#txtInicialesArea").val();

    $('#modalAreas').modal('hide');

    alertify.confirm("¿Desea insertar la nueva área de gestión?",
            function(){
                
                $.ajax({
                    url:'insertAreas',
                    datatype:'json',
                    type:'post',
                    data:{
                        nombre:nombre,
                        idGerenciaArea : idGerenciaArea,
                        iniciales:iniciales,
                    },
                    success:function(data)
                    {
                        new PNotify({
                            title: 'Muy bien!',
                            text: 'Área de gestión ingresada con éxito',
                            type: 'success'
                        });
                        $("#insertArea").removeClass("hidden");
                        $("#editArea").addClass("hidden");
                        location.reload();
                    }
                });
            },
            function(){
               
                alertify.error('Cancelado');
                $('#modalAreas').modal('show');
            }); 
});


$("#subirArchivo").click(function(){

    const form = $('#frmDocumento');

                const datosFormulario = new FormData(form[0]);


                $.ajax({
                enctype: 'multipart/form-data',
                contentType: false,
                processData: false,
                cache: false,
                type: 'POST',
                url: 'guardarDocumentos',
                data: datosFormulario,
                success: function(r) {
                    if(r == 1){
                        Swal.fire({
                            title: 'Documento guardado con éxito',
                            imageUrl: '../images/ok.gif',
                            imageWidth: 185,
                            imageHeight: 160,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                          }).then((result) => {
                            location.reload();
                        }); 
                    }
                }
                });

});



$("#estadoDoc").change(function(){
    var valor = $(this).val();
   
       if(valor == 1){
           $("#divDoc").show();
           $("#ruta").val('');
       }else{
           $("#divDoc").hide();
           $("input[name=archivo").val('');
           $("#ruta").val('No definida');
       }
   });
   
   
   $("#estadoAnexo").change(function(){
       var valor = $(this).val();
      
          if(valor == 1){
              $("#divDocAn").show();
          }else{
              $("#divDocAn").hide();
              $("input[name=archivoAnexo").val('');
          }
      });

$("#btnProcPoli").click(function(){
    $("#proceDiv").removeClass("hidden");
    $("#flujosDiv").addClass("hidden");
    $("#otrosDiv").addClass("hidden");

    $("#btnFlujosPro").removeClass("btn btn-warning");
    $("#btnOtrosPro").removeClass("btn btn-info");

    $("#btnProcPoli").addClass("btn btn-success");
});

$("#btnFlujosPro").click(function(){
    $("#proceDiv").addClass("hidden");
    $("#flujosDiv").removeClass("hidden");
    $("#otrosDiv").addClass("hidden");

    $("#btnProcPoli").removeClass("btn btn-success");
    $("#btnOtrosPro").removeClass("btn btn-info");

    $("#btnFlujosPro").addClass("btn btn-warning");
});

$("#btnOtrosPro").click(function(){
    $("#proceDiv").addClass("hidden");
    $("#flujosDiv").addClass("hidden");
    $("#otrosDiv").removeClass("hidden");

    $("#btnProcPoli").removeClass("btn btn-success");
    $("#btnFlujosPro").removeClass("btn btn-warning");

    $("#btnOtrosPro").addClass("btn btn-info");
});


var detallesPro=(ele)=>{

    var nombre = $(ele).attr("nombre");
    var id = $(ele).attr("id");
    var titulo = $(ele).attr("titulo");
    $('#listDocumentosAsociados').html('');
    $("#namePro").text('-' +nombre);
    $("#tituloModal").text(titulo);

    var fila = '';
    $.ajax({
        url:'listadoDocumentosAsociados',
        datatype:'json',
        type:'post',
        data:{id: id,
        },
        success:function(data)
        {
            fila+="<table style='text-align:center;' class='dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example'>";
            fila+="<tr><th style='border: solid 1px grey;color:white;background-color:#6304A9;text-align:center;'> <b>Título</b></th>"; 
            fila+="<th style='border: solid 1px grey;color:white;background-color:#6304A9;text-align:center;'> <b>Área </b> </th>";
            fila+="<th style='border: solid 1px grey;color:white;background-color:#6304A9;text-align:center;'><b>Acciones </b></th> </tr>";
            for(var i=0; i<data.length; i++)
            {
                 fila+="<tr><td  style='border: solid 1px grey;background-color:#D9D9D9'>"+data[i].titulo+"</td> <td style='border: solid 1px grey;background-color:#D9D9D9'>  "+data[i].area+"</td> ";
                 fila+="<td style='border: solid 1px grey;background-color:#D9D9D9'><button class='btn btn-danger btn-sm' idPadre="+data[i].idDocPadre+" ";
                 fila +="idHijo = "+data[i].idDocHijo+" onclick='eliminarRelacion(this)' ><i class='fa fa-trash'></i></button></td></tr>";
            }
            fila+="</table>";

            if(fila == "<table style='text-align:center;' class='dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example'>"
            +"<tr><th style='border: solid 1px grey;color:white;background-color:#6304A9;text-align:center;'> <b>Título</b></th>"
            +"<th style='border: solid 1px grey;color:white;background-color:#6304A9;text-align:center;'> <b>Área </b> </th>"
            +"<th style='border: solid 1px grey;color:white;background-color:#6304A9;text-align:center;'><b>Acciones </b></th> </tr></table>" ){
                $('#listDocumentosAsociados').html('<h3 style="font-weight:bold;text-align:center;">No hay documentos asociados</h3>');
            }else{
                $('#listDocumentosAsociados').html(fila);
            }
           
            
        }
    });

    $('#modalDetalles').modal('show');

}


var vincular=(ele)=>{

    var nombre = $(ele).attr("nombre");
    var id = $(ele).attr("id");
    var titulo = $(ele).attr("titulo");
    var validacion = $(ele).attr("validacion");

    $("#nameDocumento").text('-' +nombre);
    $("#tituloModalVincular").text(titulo);
    
    $("#idDocPadre").val(id);

    $("#idValidacion").val(validacion);

    if(validacion == 1){

        $("#divPoliDisponibles").removeClass("hidden");
        $("#divProDisponibles").addClass("hidden");
        $("#divProPolDisponibles").addClass("hidden");

        //$('#poliDisponibles  option[value="seleccione"]').attr("selected",true);

    }else if(validacion == 2){
        $("#divPoliDisponibles").addClass("hidden");
        $("#divProDisponibles").removeClass("hidden");
        $("#divProPolDisponibles").addClass("hidden");
    }else{
        $("#divPoliDisponibles").addClass("hidden");
        $("#divProDisponibles").addClass("hidden");
        $("#divProPolDisponibles").removeClass("hidden");

    }
   

    $('#modalVincular').modal('show');

}


$(".ex").click(function(){
    $("#divPoliDisponibles").addClass("hidden");
    $("#divProDisponibles").addClass("hidden");
    $("#divProPolDisponibles").addClass("hidden");

   // $('#poliDisponibles  option[value="seleccione"]').attr("selected",true);
});



$("#guardar").click(function(){
    var idPadre = $("#idDocPadre").val();
    var idValidacion = $("#idValidacion").val();
    var idHijo = '';

    if(idValidacion == 1){
        idHijo = $("#poliDisponibles").val();
    }else if(idValidacion == 2){
        idHijo = $("#proDisponibles").val();
    }else{
        idHijo = $("#proPolDisponibles").val();
    }

    

    if(idHijo == 0){
        new PNotify({
            title: '¡ADVERTENCIA!',
            text: 'Seleccione una opción válida!',
            type: 'error',
            delay: 3000,
        });
    }else{

        $('#modalVincular').modal('hide');

        $.ajax({
            url:'relacionarDocumento',
            datatype:'json',
            type:'post',
            data:{
                idPadre:idPadre,
                idHijo:idHijo,
            },
            success:function(data)
            {
                if(data == 1){
                    Swal.fire({
                        title: 'El documento ya está relacionado con el seleccionado...',
                        imageUrl: '../images/alert.gif',
                        imageWidth: 185,
                        imageHeight: 160,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                      }).then((result) => {
                        $('#modalVincular').modal('show');
                    }); 
                    
                }else if(data == 2){
                    Swal.fire({
                        title: 'Documento relacionado con éxito',
                        imageUrl: '../images/ok.gif',
                        imageWidth: 185,
                        imageHeight: 160,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                      }).then((result) => {
                        $('#modalVincular').modal('show');
                    }); 
                      
                }
            }
        });
    }
    

});


var eliminarRelacion=(ele)=>{

   var idPadre = $(ele).attr("idPadre");
    var idHijo = $(ele).attr("idHijo");


    $('#modalDetalles').modal('hide');

    alertify.confirm("¿Desea eliminar la relación?",
    function(){
        $.ajax({
            url:'eliminarRelacion',
            datatype:'json',
            type:'post',
            data:{
                idPadre: idPadre,
                idHijo:idHijo,
                },
            success:function(data)
            {
                if(data == 1){
                    new PNotify({
                        title: 'Muy bien!',
                        text: 'Relación eliminada con éxito',
                        type: 'success',
                        delay:2000,
                    });
                }
                    

            }
        });
    },
    function(){
    
        alertify.error('Cancelado');
        $('#modalDetalles').modal('show');
    });
}

$("#areaDoc").change(function(){
    $("#cod").val(''); 
});


$("#clasDoc").change(function(){
    $("#cod").val(''); 
});


$("#btnGenerarDoc").click(function(){
    var identificador = $("#areaDoc").val();
    var identiGe = $("#gerenciaDoc").val();

    var idDoc = $("#clasDoc").val();
    var tipoDoc = '';

    if(idDoc==1){
        var tipoDoc = 'Pol';
    }
    else if(idDoc==2){
        var tipoDoc = 'Pro';
    }
    else if(idDoc==5){
        var tipoDoc = 'Anexo';
    } 
    else if(idDoc==6){
        var tipoDoc = 'DocGral';
    } else if(idDoc==7){
        var tipoDoc = 'Flujo';
    }

    var fila = '';

    var lastDoc = '';

    $.ajax({
        url:'getLastDoc',
        datatype:'json',
        type:'post',
        data:{identificador: identificador,
            idDoc:idDoc,
        },

        success:function(data)
        {
             for(var i=0; i<data.length; i++)
            {
                lastDoc+=""+data[i].lastDoc+"";
          }
         
                    
        }
    });
    
    $.ajax({
        url:'getIniciales',
        datatype:'json',
        type:'post',
        data:{identificador: identificador,
            identiGe:identiGe
        },

        success:function(data)
        {
             for(var i=0; i<data.length; i++)
            {
                 fila+=""+data[i].inicialGerencia+"-"+tipoDoc+lastDoc+"-"+data[i].inicialesArea+"";
          }

            $("#cod").val(fila);           
        }
    });


   

 
});



$("#btnShowDocView").click(function(){
    location.href ='subirDocumentos';
});

$("#btnShowDocControl").click(function(){
    location.href ='tablaControl';
});

$("#btnShowDocVinculacion").click(function(){
    location.href ='vinculacion';
});


var eliminarDocControl=(ele)=>{

    var id = $(ele).attr("id");
     var titulo = $(ele).attr("titulo");
 
     alertify.confirm("¿Desea eliminar el documento "+titulo+"?",
     function(){
         $.ajax({
             url:'eliminarDocumento',
             datatype:'json',
             type:'post',
             data:{
                 id: id,
                 },
             success:function(data)
             {
                 if(data == 1){
                    Swal.fire({
                        title: 'Documento eliminado con éxito',
                        imageUrl: '../images/alert.gif',
                        imageWidth: 185,
                        imageHeight: 160,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                      }).then((result) => {
                        location.reload();
                    }); 
                 }
                     
 
             }
         });
     },
     function(){
     
         alertify.error('Cancelado');
        // $('#modalDetalles').modal('show');
     });
 }


 $("#estadoDocCtrl").change(function(){
    var valor = $(this).val();
   
       if(valor == 1){
           $("#divDocCtrl").show();
          $("#rutaCtrl").val('');
       }else{
          $("#divDocCtrl").hide();
           $("input[name=archivo").val('');
           $("#rutaCtrl").val('No definida');
       }
   });



   $("#btnGenerarDocCtrl").click(function(){
    var identificador = $("#areaDocCtrl").val();
    var identiGe = $("#gerenciaDocCtrl").val();

    var idDoc = $("#clasDocCtrl").val();
    var tipoDoc = '';

    if(idDoc==1){
        var tipoDoc = 'Pol';
    }
    else if(idDoc==2){
        var tipoDoc = 'Pro';
    }
    else if(idDoc==5){
        var tipoDoc = 'Anexo';
    } 
    else if(idDoc==6){
        var tipoDoc = 'DocGral';
    } else if(idDoc==7){
        var tipoDoc = 'Flujo';
    }

    var fila = '';

    var lastDoc = '';

    $.ajax({
        url:'getLastDoc',
        datatype:'json',
        type:'post',
        data:{identificador: identificador,
            idDoc:idDoc,
        },

        success:function(data)
        {
             for(var i=0; i<data.length; i++)
            {
                lastDoc+=""+data[i].lastDoc+"";
          }
         
                    
        }
    });
    
    $.ajax({
        url:'getIniciales',
        datatype:'json',
        type:'post',
        data:{identificador: identificador,
            identiGe:identiGe,
        },

        success:function(data)
        {
             for(var i=0; i<data.length; i++)
            {
                 fila+=""+data[i].inicialGerencia+"-"+tipoDoc+lastDoc+"-"+data[i].inicialesArea+"";
          }

            $("#codCtrl").val(fila);           
        }
    });


   

 
});

 var verDocControl=(ele)=>{

    var id = $(ele).attr("id");
     var titulo = $(ele).attr("titulo");
     var descripcion = $(ele).attr("descripcion");
     var area = $(ele).attr("area");
     var gerencia = $(ele).attr("gerencia");
     var tipoDoc = $(ele).attr("idTipoDoc");
     var periodoAp = $(ele).attr("periodoAp");
     var indicador = $(ele).attr("indicador");
     var fechaCreacion = $(ele).attr("fechaCreacion");
     var ruta = $(ele).attr("ruta");
     var estado = $(ele).attr("estado");
     
     $("#tituloModalDoc").text(titulo);
     
     $("#idDetalleDoc").val(id);
     $("#gerenciaDocCtrl").val(gerencia);
     $("#areaDocCtrl").val(area);
     $("#clasDocCtrl").val(tipoDoc);
     $("#periodoApCtrl").val(periodoAp);
     $("#codCtrl").val(indicador);
     $("#descripcionCtrl").val(descripcion);    
     $("#fechaCreacionCtrl").val(fechaCreacion);

        $("#estadoDocCtrl").val(estado);
     

     $("#rutaCtrl").val(ruta);

     $("#tituloCtrl").text(titulo);

     $('#modalDetallesDoc').modal('show');

 }


 

 $("#btnModificar").click(function(){
        var titulo = $("#tituloCtrl").val();
        $('#modalDetallesDoc').modal('hide');
    alertify.confirm("¿Desea eliminar el documento "+titulo+"?",
     function(){
    const form = $('#frmDocumentoCtrl');

                const datosFormulario = new FormData(form[0]);

               
                $.ajax({
                enctype: 'multipart/form-data',
                contentType: false,
                processData: false,
                cache: false,
                type: 'POST',
                url: 'editarDocumentos',
                data: datosFormulario,
                success: function(r) {
                    if(r == 1){
                        Swal.fire({
                            title: 'Documento modificado con éxito',
                            imageUrl: '../images/ok.gif',
                            imageWidth: 185,
                            imageHeight: 160,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                          }).then((result) => {

                            const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                  confirmButton: 'btn btn-danger',
                                  cancelButton: 'btn btn-success'
                                },
                                buttonsStyling: false,
                              })
                              
                              swalWithBootstrapButtons.fire({
                                title: 'Desea recargar sus datos?',
                                icon: 'info',
                                showCancelButton: true,
                                width: 500,
                                confirmButtonText: 'Si, actualizar!',
                                cancelButtonText: 'No, deseo modificar mas documentos!',                   
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                              }).then((result) => {
                                if (result.value) {
                                    location.reload()
                                  
                                }
                              })
                        }); 
                    }
                }
                });
            },
            function(){
               
                alertify.error('Cancelado');
                $('#modalDetallesDoc').modal('show');
            }); 

});
 