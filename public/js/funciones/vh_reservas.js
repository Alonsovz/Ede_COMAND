

$(document).ready(function(){

    $('.vh').click();







    //eventos para bandejas
    $('#btn_enviadas').click(function(){
        $('#p_recibidas').removeClass('hidden');
        $('#p_aprobadas').addClass('hidden');
        $('#p_denegadas').addClass('hidden');
    });

    $('#btn_aprobadas').click(function(){
        $('#p_recibidas').addClass('hidden');
        $('#p_aprobadas').removeClass('hidden');
        $('#p_denegadas').addClass('hidden');
    });

    $('#btn_denegadas').click(function(){
        $('#p_recibidas').addClass('hidden');
        $('#p_aprobadas').addClass('hidden');
        $('#p_denegadas').removeClass('hidden');
    });





    //horarios
    $('#datetimepicker1').datetimepicker();
    $('#datetimepicker2').datetimepicker();

    //formulario nueva reserva
    $('#nuevareserva').click(function(){
       $('#formularioreserva').removeClass('hidden');
       $('#calendario').addClass('hidden');
    });

    //evento para remover clase del div que oculta formulario de edicion
    $('#btn_editarreserva').click(function(){
        $('#formularioedicion').removeClass('hidden');
        $('#calendariodiv').addClass('hidden');
    });


    //evento para bloquear el boton de guardar cuando la fecha de horario 2 cambie
    $('#horario2').change(function(){
       $('#btn_guardarreserva').addClass('hidden');
    });

    //evento para comprobar disponibilidad de los horarios seleccionados en una nueva reserva
    $('#disponibilidad').click(function(){

        var fecha1 = moment($('#horario1').val(),'d/m/Y H:mm');
        var fecha2 = moment($('#horario2').val(),'d/m/Y H:mm');





        var diferencia = fecha2.diff(fecha1,'days');



        var duracion = moment.duration(fecha2.diff(fecha1));

        var horas   = duracion.hours();
        var minutos = duracion.minutes();
        var dias    = duracion.days();

        console.log(duracion);


        //verificamos que el tiempo de reserva no sea menor a 30minutos
        if(minutos<30 && dias<=0 && horas<=0)
        {
            swal({
                type: 'error',
                title: 'verificar...',
                text: 'Su tiempo de reserva no puede ser menor a 30 minutos!',
                footer: ''
            });

            $('#btn_guardarreserva').addClass('hidden');
        }
        else
        {

            if(dias>0 && dias<=3)
            {
                swal({
                    type: 'success',
                    title: 'Tiempo de reserva',
                    text: dias+' dia(s)',
                    footer: ''
                });
            }
            else if(dias===0)
            {
                swal({
                    type: 'success',
                    title: 'Tiempo de reserva',
                    text: horas+' hora(s) '+minutos+' minuto(s)',
                    footer: ''
                });
            }
            else if(dias>3 && $('#tipo option:selected').val()==1)
            {
                swal({
                    type: 'warning',
                    title: 'Verificar',
                    text: 'El tiempo de reserva excede el permitido por la administración',
                    footer: ''
                });

                $('#btn_guardarreserva').addClass('hidden');
            }

            var vehiculos = document.getElementsByName('vehiculos');
            var vh ='';

            for(var i = 0; i < vehiculos.length; i++)
            {
                if(vehiculos[i].checked)
                {
                    vh = vehiculos[i].value;
                }
            }

            if(vh==='')
            {
                new PNotify({
                    title:'verificar',
                    text: 'Debe seleccionar un vehiculo para comprobar la disponibilidad de la reserva',
                    type: 'warning'
                });
            }
            else
            {
                $.getJSON('vh_comprobardisponibilidad',{vehiculo:vh,inicio:$('#horario1').val(),fin:$('#horario2').val()},function(data){
                    if(data==='reservado')
                    {
                        new PNotify({
                            title:'Verificar',
                            text:'Ya existe una reserva con estos horarios seleccionados',
                            type:'warning'
                        });
                        $('#btn_guardarreserva').addClass('hidden');
                    }
                    else if(data==='vehiculo no disponible')
                    {
                        new PNotify({
                            title:'Verificar',
                            text:'El vehiculo no se encuentra disponible para reservas',
                            type:'warning'
                        });
                    }
                    else if(data==='disponible' && diferencia<=3 && $('#tipo option:selected').val()==1)
                    {
                        new PNotify({
                            title:'Verificar',
                            text:'Los horarios seleccionados estan disponibles',
                            type:'info'
                        });
                        $('#btn_guardarreserva').removeClass('hidden');
                    }
                    else if(data==='disponible' && diferencia<=3 && $('#tipo option:selected').val()==2)
                    {
                        new PNotify({
                            title:'Verificar',
                            text:'Los horarios seleccionados estan disponibles',
                            type:'info'
                        });
                        $('#btn_guardarreserva').removeClass('hidden');
                    }

                });
            }
        }







    });






    //evento para comprobar la disponibilidad en la EDICION de una reserva
    $('#disponibilidad1').click(function(){
        var vehiculo = $('input[name=vehiculos]:checked').val();
        if(vehiculo=='')
        {
            new PNotify({
                title:'verificar',
                text: 'Seleccionar un vehiculo',
                type: 'warning'
            });
        }
        else
        {
            $.getJSON('vh_comprobardisponibilidad_edit',{vehiculo:$('#vehiculo option:selected').text(),inicio:moment($('#horario1').val(),
                'DD/MM/YYYY H:mm').format('YYYYMMDD H:mm'),fin:moment($('#horario2').val(),'DD/MM/YYYY H:mm').format('YYYYMMDD H:mm')
            ,reserva:$('#idreserva').val()},function(data){
                if(data==='reservado')
                {
                    new PNotify({
                        title:'Verificar',
                        text:'Ya existe una reserva con estos horarios seleccionados',
                        type:'warning'
                    });
                    $('#btn_guardarreserva').addClass('hidden');
                }
                else if(data==='vehiculo no disponible')
                {
                    new PNotify({
                        title:'Verificar',
                        text:'El vehiculo no se encuentra disponible para reservas',
                        type:'warning'
                    });
                }
                else if(data==='disponible')
                {
                    new PNotify({
                        title:'Muy bien',
                        text:'Los horarios seleccionados estan disponibles',
                        type:'info'
                    });
                    $('.btn_actualizarreserva').removeClass('hidden');
                }
            });
        }

    });


    //guardar reserva
    $('#btn_guardarreserva').click(function(){




        if($('#destino').val()=='' || $('#conductor').val()=='')
        {
            swal({
                type: 'warning',
                title: 'verificar...',
                text: 'Se encontraron campos vacios, favor rellenarlos'

            });
        }
        else
        {
            $('#barra_progreso').removeClass('hidden');
            $('#btn_guardarreserva').addClass('hidden');
            var vehiculo = $('input[name=vehiculos]:checked').val();
            $.ajax({
                url:'ingresarreserva',
                datatype:'json',
                type:'post',
                data:{conductor:$('#conductor option:selected').val(),nombrecompleto:$('#nombrecompleto').val(),jefe:$('#jefe').val(),destino:$('#destino').val(),
                    departamento:$("#departamento option:selected").val(),vehiculo:vehiculo,
                    inicio:$('#horario1').val(),fin:$('#horario2').val(),motivo:$('#motivo').val(),tipo:$('#tipo option:selected').val()},
                success:function(data)
                {

                        new PNotify({
                            title:'Muy bien',
                            text:'Reserva ingresada exitosamente',
                            type:'success'
                        });

                        location.href = 'vh_index';
                        $('#barra_progreso').remove();



                },
                error:function()
                {
                    $('#barra_progreso').addClass('hidden');
                    $("#btn_guardarreserva").removeClass('hidden');

                    new PNotify({
                        title:'Error',
                        text:'Error al ingresar reserva',
                        type:'error'
                    });
                }
            });
        }





    });


    //cancelar reserva
    $('#btn_cancelarreserva').click(function(){
        $('#formularioreserva').addClass('hidden');
        $('#calendario').removeClass('hidden');
        document.getElementById('formularioreserva').reset();
    });




    //evento para actualizar reserva
    $('.btn_actualizarreserva').click(function(){
        //evento para actualizar una reserva
        $.ajax({
            url:'actualizarreserva',
            datatype:'json',
            type:'post',
            data:{id:this.id,nombrecompleto:$('#nombrecompleto').val(),jefe:$('#jefe').val(),
                departamento:$("#departamento option:selected").val(),vehiculo:$('#vehiculo option:selected').val(),
                inicio:moment($('#horario1').val(),'DD/MM/YYYY H:mm').format('YYYYMMDD H:mm'),fin:moment($('#horario2').val(),'DD/MM/YYYY H:mm').format('YYYYMMDD H:mm'),motivo:$('#motivo').val()},
            success:function()
            {
                new PNotify({
                    title:'Muy bien',
                    text:'Reserva actualizada exitosamente',
                    type:'success'
                });

                location.href='misreservas';
            }
        });
    });



    //aprobar una reserva por parte de jefatura
    $('.btn_aprobarreserva').click(function(){
        $.getJSON('aprobarreservavh',{id:this.id},function(data){
            if(data===true)
            {
                new PNotify({
                    title:'Muy bien',
                    text:'Reserva aprobada exitosamente',
                    type:'success'
                });

                location.href='reservasjefatura';
            }
        });
    });



    //denegar resolucion evento
    $('#btn_denegarreserva').click(function(){
       $('#formularioresolucion').removeClass('hidden');
       $('#calendariodiv').addClass('hidden');
    });

    //evento para denegar la reserva del empleado
    $('.btn_guardarresolucion').click(function(){
        $.getJSON('denegarreserva',{id:this.id,resolucion:$('#resolucion').val()},function(data){
            if(data===true)
            {
                new PNotify({
                    title:'Muy bien',
                    text:'Reserva denegada exitosamente',
                    type:'success'
                });

                location.href='reservasjefatura';
            }
        });
    });


    //evento para autorizar un vehiculo
    $('.btn_autorizarvehiculo').click(function(){
        $.getJSON('autorizarvehiculo',{id:this.id},function(data){
            if(data===true)
            {
                new PNotify({
                    title:'Muy bien',
                    text:'Vehiculo autorizado exitosamente',
                    type:'success'
                });

                location.href='autorizacionvehiculos';
            }
        });
    });





    //proceso para finalizar una reserva por parte del empleado
    $('.finalizarreserva').click(function(){
       $.getJSON('finalizarreservabyempleado',{reserva:this.id},function(data){

           if(data===true)
           {
               new PNotify({
                   title:'Muy bien',
                   text:'Reserva finalizada con exito',
                   type:'success'
               });

               location.href='misreservas';


           }
       });
    });


    //evento para autorizar un vehiculo
    $('.btn_autorizarvehiculodh').click(function(){
        $.getJSON('autorizarvehiculodj',{id:this.id},function(data){
            if(data===true)
            {
                new PNotify({
                    title:'Muy bien',
                    text:'Vehiculo autorizado exitosamente',
                    type:'success'
                });

                location.href='autorizacionvehiculos';
            }
        });
    });


    //evento para denegar el vehiculo
    $('.btn_guardardenegacion').click(function(){
        $.getJSON('denegarvehiculo',{id:this.id,resolucion:$('#resolucion').val()},function(data){
            if(data===true)
            {
                new PNotify({
                    title:'Muy bien',
                    text:'Vehiculo denegado exitosamente',
                    type:'success'
                });

                location.href='autorizacionvehiculos';
            }
        });
    });



    //evento para cancelar una reserva
    $('.cancelarreserva').click(function(){
        var id = this.id;
        $.ajax({
            url: "vh_cancelarreserva",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function (data) {
               new PNotify({
                   title:'Muy bien',
                   text:'Reserva cancelada exitosamente!',
                   type:'success'
               });

               location.href = 'dashboard';
            }

        });
    });



});