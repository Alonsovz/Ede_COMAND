$(document).ready(function(){
   //varaiables globales
    var avatar = '';

    $('.btn_avatar').click(function(){
       avatar = this.id;
       $('#avatar').html('');
       $('#avatar').append('AVATAR SELECCIONADO');

    });

    //evento para guardar la edicion del usuario
    $('#btn_guardarinformacion').click(function(){
       if($('#nuevacontrasena').val()!==$('#confirmarcontrasena').val())
       {
           new PNotify({
               title:'Verificar',
               text:'Las contraseñas ingresadas no coinciden',
               type:'warning'
           });
       }
       else if($('#nuevacontrasena').val()==='' || $('#confirmarcontrasena').val()==='')
       {
           new PNotify({
               title:'Verificar',
               text:'No se permiten campos vacios',
               type:'warning'
           });
       }
       else
       {
           $.ajax({
               url:'editperfil',
               datatype:'json',
               type:'post',
               data:{avatar:avatar,contrasena:$('#nuevacontrasena').val()},
               success:function(data){
                    if(data==="success")
                    {
                        new PNotify({
                            title:'muy bien',
                            text:'Informacion actualizada con exito!',
                            type:'success'
                        });

                        location.href = 'cerrarsesion';
                    }
                    else
                    {
                        new PNotify({
                            title:'Error',
                            text:'Ocurrio un error mientras se actualizaba la informacion!',
                            type:'error'
                        });
                    }
               }
           });
       }


    });
});