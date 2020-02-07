 jQuery(document).ready(function($) {

    
    //evento enter sobre el input de password
     $('#password').keypress(function(event){

         if(event.which == 13)
         {
             event.preventDefault();
             $('#btn_ingresar').click();
         }
     });

    //evento click para boton de ingresar a sistema comanda
    $('#btn_ingresar').click(function(event) {



        //funcion ajax para poder validar el usuario que esta ingresando
        $.ajax({
            url: 'login',
            type: 'post',
            datatype: 'text',
            data:{correo:$("#correo").val(),password:$("#password").val()},
            success:function(data){
                if (data=="success") 
                {
                    location.href = "dashboard";
                }
                else
                {
                    notie.alert({ type: 'error', text: 'Credenciales no válidas' })
                }
            }
        });
    
    });


    //evento para la digitacion del correo electronico cuando el usuario quiere cambiar su contraseña
     $('#correo_n').change(function(){
        $.ajax({
            url:'confirmarcorreo',
            datatype:'json',
            type:'post',
            data:{correo:$('#correo_n').val()},
            success:function(data)
            {
                if(data==='no valido')
                {
                    new PNotify({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Verifique si digitó bien su correo!'
                    });


                    $('#btn_guardarnuevacontraseña').addClass('hidden');
                }
                else
                {
                    $('#btn_guardarnuevacontraseña').removeClass('hidden');
                }
            }

        });

     });


     //evento para guardar la nueva contraseña
     $('#btn_guardarnuevacontraseña').click(function(){
         if($('#password_n').val()===''  || $('#password_n').val()!==$('#password2_n').val())
         {
             new PNotify({
                 type: 'warning',
                 title: 'Verificar...',
                 text: 'Campos vacios ó las contraseñas no coinciden!'
             });


             }
         else
         {
             $.ajax({
                 url:'savenuevacontraseña',
                 type:'post',
                 datatype:'json',
                 data:{correo:$("#correo_n").val(),password:$('#password_n').val()},
                 success:function(data)
                 {
                     if(data===true)
                     {
                         new PNotify({
                             type: 'success',
                             title: 'muy bien...',
                             text: 'Contraseña reestablecida con exito!'
                         });

                         location.reload();
                     }
                 }
             });
         }



     });

    
    
});