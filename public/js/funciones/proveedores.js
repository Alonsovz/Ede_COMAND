$(document).ready(function(){

    var idproveedor = '';

    //evento para guardar un proveedor
    $('#btn_guardarproveedor').click(function(){
        if($('#entidad').val()=="" || $('#razonsocial').val()=="" || $('#telefono').val()=="")
        {
            new PNotify({
                title:'Verificar',
                text:'No se permiten campos vacios para el ingreso de un nuevo proveedor',
                type:'warning'
            });
        }
        else
        {
            $.ajax({
                url:'guardarproveedor',
                datatype:'json',
                type:'post',
                data:{entidad:$('#entidad').val(),razonsocial:$('#razonsocial').val(),contacto:$('#contacto').val(),
                    direccion:$('#direccion').val(),correoelectronico:$('#correo').val(),telefono:$('#telefono').val()},
                success:function(data){
                    if(data==="success")
                    {
                        new PNotify({
                            title:'muy bien!',
                            text:'Proveedor ingresado con exito',
                            type:'success'
                        });
                        location.reload();
                    }
                }
            });
        }
    });


    //ver proveedores
    $('#btn_ver_proveedores').click(function(){
       $('#proveedores').removeClass('hidden');
       $('#insumos').addClass('hidden');
    });




    //evento para poder editar un proveedor
    $('.editarproveedor').click(function(){


        idproveedor = this.id;
        $.getJSON('getproveedorbyid',{id:idproveedor},function(data){


           $.each(data,function(index){
               $('#razonsocial1').val(data[index].razonsocial);
               $('#entidad1').val(data[index].nombreentidad);
               $('#contacto1').val(data[index].nombrecontacto);
               $('#direccion1').val(data[index].direccion);
               $('#correo1').val(data[index].correoelectronico);
               $('#telefono1').val(data[index].telefonomovil);
           });
        });


    });


    //evento para actualizar la informacion del proveedor
    $('#btn_actualizarproveedor').click(function(){
        $.ajax({
            url:'actualizarproveedor',
            datatype:'json',
            type:'post',
            data:{id:idproveedor,entidad:$('#entidad1').val(),razonsocial:$('#razonsocial1').val(),contacto:$('#contacto1').val(),
                direccion:$('#direccion1').val(),correoelectronico:$('#correo1').val(),telefono:$('#telefono1').val()},
            success:function(data){
                if(data==="success")
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Informacion actualizada con exito',
                        type:'success'
                    });
                    location.reload();
                }
                else
                {
                    new PNotify({
                        title:'oh no',
                        text:'Ocurrio un error en la actualizacion de la informacion',
                        type:'error'
                    });
                }

            }

        });
    });




});