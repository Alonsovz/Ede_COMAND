$(document).ready(function(){


    //evento para reasignar ticket
    $('.btn_reasignarticket').click(function(){
       $.ajax({
            url:'updateticket',
            datatype:'json',
            data:{opcion:2,usuario:$('#usuario option:selected').val(),ticket:this.id,motivo:$('#motivoreasignacion').val()},
            success:function(data)
            {
                if(data==='success')
                {
                    new PNotify({
                        title:'Muy bien!',
                        text:'Ticket reasignado!',
                        type:'success'
                    });

                    location.href = 'tck_edesalshow';
                }
            }
       });
    });

    //evento para aceptar ticket
    $('.btn_aceptartck').click(function(){

        var fechanueva='';



        if($('#fechasol').val())

        {

            fechanueva = moment($('#fechasol').val()).format('DD/MM/YYYY H:mm');
        }
       else
        {
            fechanueva = $('#fechavieja').val();

        }
       $.ajax({
           url:'aceptartck',
           data:{id:this.id,fechasolaprox:fechanueva},
           datatype:'json',
           type:'post',
           success:function(data)
           {
               if(data==='success')
               {
                   new PNotify({
                       title:'Muy bien!',
                       text:'Ticket aceptado!',
                       type:'success'
                   });

                   location.reload();
               }
               else
               {
                   new PNotify({
                       title:'Error!',
                       text:'Ocurrio un error mientras se actualizaba el estado',
                       type:'error'
                   });
               }
           }
       });
    });



    // EVENTO PARA PODER RECHAZAR UN TICKET
    $('.btn_rechazartck').click(function(){
        var id =this.id;
        var comentario = $('#comentariorechazo').val();

        $.ajax({
           url:'rechazarticket',
            data:{id:id,comentario:comentario},
            datatype:'json',
            type:'post',
            success:function(data)
            {
                if(data==='success')
                {
                    new PNotify({
                        title:'Muy bien!',
                        text:'Ticket rechazado con exito!',
                        type:'success'
                    });

                    location.reload();
                }
                else
                {
                    new PNotify({
                        title:'Error!',
                        text:'Ocurrio un error mientras se actualizaba el estado',
                        type:'error'
                    });
                }
            }
        });
    });

});