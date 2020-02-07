$(document).ready(function(){

    //evento para mostrar formulario de nuevo modulo
    $('#btn_nuevomodulo').click(function(){
       $('.ibox-content').slideUp('slow');
       $('.ibox-footer').removeClass('hidden');
    });



    //evento para guardar un modulo
    $('#btn_guardarmodulo').click(function(){
       $.getJSON('savemodulo',{nombre:$('#nombremodulo').val(),descripcion:$('#descripcionmodulo').val(),
           sistema:$('#sistema option:selected').val()},function(data){

           if(data==="success")
           {
               new PNotify({
                   title:'muy bien!',
                   text:'Modulo ingresado con exito!',
                   type:'success'
               });

               location.href = 'modulos';
           }
           else
           {
               new PNotify({
                   title:'error!',
                   text:'ocurrio un error mientras se ingresaba el modulo!',
                   type:'error'
               });
           }
       });
    });


});