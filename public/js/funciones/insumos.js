

$(document).ready(function(){


    //funcion para guardar insumo
    $('#btn_guardarinsumo').click(function(){
        $.ajax({
            url:'guardarinsumo',
            datatype:'json',
            type:'post',
            data:{activo:$('#activo_nuevo option:selected').val(),insumo:$('#nombreinsumo').val(),descripcion:$('#descripcioninsumo').val(),precio:$('#precioinsumo').val(),
                categoria:$('#categoriainsumo option:selected').val(),unidad:$('#unidad_nuevo option:selected').val()},
            success:function(data)
            {
                if(data===true)
                {
                    new PNotify({
                        title:'muy bien',
                        text:'Insumo guardado con exito!',
                        type:'success'
                    });

                    location.reload();

                }
                else
                {
                    new PNotify({
                        title:'oh no',
                        text:'Ocurrio un error mientras se guardaba la informacion del insumo!',
                        type:'error'
                    });
                }
            }
        });
    });

    //evento para edicion
    $('#tablainsumos').on('click','.verinsumo',function(){
        $.getJSON('buscarinsumo',{id:this.id},function(data){
            $.each(data,function(index){
                $('#codigo1').val(data[index].id);
                $('#nombreinsumo1').val(data[index].nombre);
                $('#desc').val(data[index].descripcion);
                $('#precioinsumo1').val(data[index].precio);
                $('#categ').append("<option selected='selected' value="+data[index].categoria_insumo_id+">"+data[index].categoria+"</option>");
                $('#unidad_edicion').append("<option selected='selected' value="+data[index].unidad_medida_id+">"+data[index].um+"</option>");

                if(data[index].activo)
                {
                    $('#activo').append("<option selected='selected' value="+data[index].activo+">"+data[index].activo+"</option>");
                }
                else
                {
                    $('#activo').append("<option selected='selected' value=''>Seleccione una opcion...</option>");
                }
            });
        });
    });



    //ver insumos
    $('#btn_ver_insumos').click(function(){
        $('#insumos').removeClass('hidden');
        $('#proveedores').addClass('hidden');
    });






    //evento para guardar la edicion del insumo
    $('#btn_guardaredicion').click(function(){

       $.ajax({
           url:'editarinsumo',
           datatype:'json',
           type:'post',
           data:{activo:$('#activo option:selected').val(),insumo:$('#nombreinsumo1').val(),descripcion:$('#desc').val(),precio:$('#precioinsumo1').val(),
            categoria:$('#categ option:selected').val(),id:$('#codigo1').val()},
           success:function(data){
               if(data===true)
               {
                   new PNotify({
                       title:'muy bien',
                       text:'Actualizacion exitosa!',
                       type:'success'
                   });

                   location.reload();

               }
               else
               {
                   new PNotify({
                       title:'oh no',
                       text:'Ocurrio un error mientras se guardaba la informacion del insumo!',
                       type:'error'
                   });
               }
           }

       }) ;
    });


    //eliminar un insumo
    $('.btn_deleteinsumo').click(function(){
        $('#insumo').val(this.id);
    });

    $('#btn_sieliminar').click(function(){
       $.getJSON('deleteinsumo',{id:$('#insumo').val()},function(data){
           if(data===true)
           {
               new PNotify({
                   title:'muy bien',
                   text:'Eliminación exitosa!',
                   type:'success'
               });

               location.reload();

           }
           else
           {
               new PNotify({
                   title:'oh no',
                   text:'Ocurrio un error!',
                   type:'error'
               });
           }
       }) ;
    });




});