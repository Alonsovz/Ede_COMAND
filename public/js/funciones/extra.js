$(document).ready(function(){
    /*---------------------------------------------------------------------------------
     evento para aceptar un ticket
     ----------------------------------------------------------------------------------*/

    $('.btn_aceptarticket').click(function(){

        var id = this.id;
        $.ajax({

            url:'updateticket',
            type:'post',
            datatype:'json',
            data:{id:id,opcion:1},
            success:function(data)
            {
                if(data=='success')
                {
                    new PNotify({
                        title:'Muy bien!',
                        text:'Estado de ticket actualizado con exito!',
                        type:'success'
                    });

                    //actualizamos divs de la vista
                    $('#detalllesticketrecibido').addClass('hidden');
                    $('#detalllesticketrecibido').html(" ");
                    location.href = 'recibidosstaff';

                }
                else
                {
                    new PNotify({
                        title:'Error!',
                        text:'Ocurrio un error mientras se actualizaba el estado',
                        type:'error',
                    });
                }
            }

        });
    });



    //-----------------------------------------------------------------------------------






    //regresar a tablero de tickets
    $('#btn_regresarbandeja').click(function(){

        $('#boardtickets').fadeIn(200,function(){
            $('#detalllesticketrecibido').addClass('hidden');
            $('#boardtickets').removeClass('hidden');
        });


        $('#btn_regresarbandeja').addClass('hidden');
    });



    //evento para poder reasignar un ticket
    $('#btn_reasignarticket').click(function(){
        var id = $('.reasignar').attr('id');
        $.ajax({

            url:'updateticket',
            type:'post',
            datatype:'json',
            data:{id:id,opcion:2,usuario:$('#usuario option:selected').val()},
            success:function(data)
            {
                if(data=='success')
                {
                    new PNotify({
                        title:'Muy bien!',
                        text:'Ticket reasignado con exito!',
                        type:'success'
                    });



                    location.href = 'recibidosstaff';

                }
                else
                {
                    new PNotify({
                        title:'Error!',
                        text:'Ocurrio un error mientras se reasignaba el ticket',
                        type:'error',
                    });
                }
            }

        });
    });




});