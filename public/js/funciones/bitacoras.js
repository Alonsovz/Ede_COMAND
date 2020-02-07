$(document).ready(function() {

    //evento para nueva bitacora
    $('#btn_nuevabitacora').click(function(){

        $('#boardbitacora').slideUp('slow');

            $('#nuevabitacora').html(" ");


            $.ajax({
                url:'nuevabitacora',
                datatype:'json',
                type:'post',
                success:function(data)
                {
                    $('#nuevabitacora').removeClass('hidden');
                    $('#nuevabitacora').append(data);
                }
            });



    });



    //evento para busqueda de ticket
    $('#btn_buscarticket').click(function(){
       $('.ibox-content').slideUp('slow');
       $('#funciona').removeClass('hidden');
       $('#ticket').val(" ");
    });


    //adjuntamos un numero de ticket para nuestra bitacora
   $('.tablatickets').on('click','.adjuntar',function(){
        var id = this.id;
        $('#funciona').addClass('hidden');
        $('.ibox-content').slideDown('slow');
        $('#ticket').val(id);

        $.getJSON('getlineasbitacora',{ticket:this.id},function(data){
            $('#tbl_lineas tbody').empty();
            var fila = '';
           $.each(data,function(index)
           {
               fila +="<tr><td width='200px'><small>"+data[index].descripcion+"</small></td><td width='20px'><small>"+moment(data[index].fechabitacora).format('DD/MM/YYYY')+"</small></td></tr>"
           });

           console.log(fila);
           $('#tbl_lineas tbody').append(fila);

        });

    });


    //evento para registrar una bitacora
    $('#btn_registrarbitacora').click(function(){

        var fecha = moment($('#fechabitacora').val(),'DD/MM/YYYY');

       if($('#fechabitacora').val()=='' || $('#tiempodedicado').val()=='' || $('#descripcion').val()=='' || $('#ticket').val()=='')
        {
            new PNotify({
                title:'Revisar',
                text:'No se permiten campos vacios para el registro de bitacora',
                type:'warning'
            });
        }
        else
       {
           $.ajax({
               url:'savebitacora',
               datatype:'json',
               type:'post',
               data:{opcion:1,ticket:$('#ticket').val(),fechabitacora:moment(fecha).format('YYYYMMDD H:mm'),
                   tiempodedicado:$('#tiempodedicado').val(),descripcion:$('#descripcion').val()},
               success:function(data)
               {
                   if(data===true)
                   {
                       new PNotify({
                           title:'muy bien!',
                           text:'Bitacora ingresada con exito!',
                           type:'success'
                       });


                       document.getElementById('frm_nuevabitacora').reset();
                       $('#iboxfooter').slideUp('slow');
                       $('#tbl_lineas tbody').empty();

                   }
                   else
                   {
                       new PNotify({
                           title:'Error!',
                           text:'Ocurrio un error mientras se ingresaba la bitacora!',
                           type:'error',
                       });

                   }
               }
           });
       }
    });


    //evento para poder regresar a la bandeja de bitacora
    $('#mibitacora').click(function(){
       location.href = 'mibitacora';
    });



    //evento para regresar a bandeja
    $('#regresarbandeja').click(function(){

        location.href = 'recibidosstaff';
    });
    
    //evento para lineas
    $('#verlineas').click(function(){
       
        $('#iboxfooter').slideDown('slow',function(){
            $('#iboxfooter').removeClass('hidden');
        });
    });



});