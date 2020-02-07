function convertirTiempoDedicado()
{
    var conversion = $('#tiempo').val()*60;

    return conversion;
}


$(document).ready(function(){

    //inicializamos el datepicker para la fecha de solucion

    $(function () {
        $('#datetimepicker1').datetimepicker();
        $('#datetimepicker2').datetimepicker();
        $('#datetimepicker3').datetimepicker();
        $('#datetimepicker4').datetimepicker();

    });



    //regresar a tablero de tickets
    $('#btn_regresarbandeja').click(function(){

        $('#boardtickets').fadeIn(200,function(){
            $('#detalllesticketrecibido').addClass('hidden');
            $('#boardtickets').removeClass('hidden');
        });


        $('#btn_regresarbandeja').addClass('hidden');
    });


    //evento para poder seleccionar un sistema y modulo si es de informatica el ticket
    $('#establecersistema').click(function(){
       $('#sistemamodulo').removeClass('hidden');
    });


    //evento para listar modulos segun sistema seleccionado
    $('#sistemas').change(function(){

        var idmodulo = $('#sistemas option:selected').val();
        $('#modulo').html('');

        //evento ajax para obtener los modulos
        $.getJSON('getmodulos',{idmodulo:idmodulo},function(data){

            var fila = '';

            //recorremos el json resultante
            $.each(data,function(index){
                fila+="<option value="+data[index].id+">"+data[index].nombre+"</option>";
            });

            $('#modulo').append(fila);

            console.log(fila);



        });
    });


    //evento para poder lanzar una solucion cuando el estado cambia
    $('#estado').change(function(){
       if($('#estado option:selected').val()==6)
       {
           $('#soluciondiv').removeClass();
       }
    });


    //evento cuando cambia la resolucion
    $('#criterioaceptacion').change(function(){
       if($('#criterioaceptacion option:selected').val()==10)
       {
           $('#comentariodenegacion').removeClass('hidden');
       }
    });


    //evento para poder validar la resolucion
    $('.btn_validarresolucion').click(function(){


           $.ajax({
               url:'resolucionticket',
               datatype:'json',
               type:'post',
               data:{comentario:$('#denegacioncomentario').val(),id:this.id,resolucion:$('#criterioaceptacion option:selected').val()},
               success:function(data){
                   if(data===true)
                   {
                       new PNotify({
                           title:'Muy bien!',
                           text:'Resolucion guardada con exito!',
                           type:'success'
                       });

                       location.href = 'tck_solicitadosedesal';
                   }
                   else
                   {
                       new PNotify({
                           title:'Error!',
                           text:'Ocurrio un error mientras se guardaba la resolucion',
                           type:'error'
                       });
                   }
               }
           });

    });



    /*----------------------------------------------------------------------------------
     evento para administrar un ticket
     ----------------------------------------------------------------------------------*/

    $('.btn_guardarcambios').click(function(){

        //si el estado es solucionado pero no se ha establecido una solucion lanzamos un error
        if(($('#estado option:selected').val()==6 && $('#solucionticket').val()=='') || ($('#solucionticket').val()!='' && $('#estado option:selected').val()!=6) )
        {
            new PNotify({
                title:'Verificar!',
                text:'se ha establecido un estado no valido o el campo de solucion se encuentra vacio',
                type:'warning'
            });
        }
        else
        {
            var id = this.id;
            $.ajax({
                url:'updateticket',
                datatype:'json',
                type:'post',
                data:{id:id,opcion:3,categoria:$('#categoria option:selected').val(),estado:$('#estado option:selected').val(),
                    sistema:$('#sistemas option:selected').val(),modulo:$('#modulo option:selected').val(),solucion:$('#solucionticket').val()},
                success:function(data)
                {
                    if(data==true)
                    {
                        new PNotify({
                            title:'Muy bien!',
                            text:'Administracion exitosa!',
                            type:'success'
                        });

                        //location.href= 'tck_edesalshow';

                    }
                    else
                    {
                        new PNotify({
                            title:'Error!',
                            text:'ocurrio un error en la administracion del ticket!',
                            type:'error'
                        });
                    }
                }
            });
        }




    });


    //-----------------------------------------------------------------------------------




    //EVENTO PARA ENVIAR NUEVO MENSAJE
    $('.btn_enviarmensaje').click(function(){
        $.ajax({
            url:'savemensaje',
            datatype:'json',
            type:'post',
            data:{idticket:this.id,mensaje:$('#mensaje').val()},
            success:function(data)
            {
                if(data===true)
                {
                    new PNotify({
                        title:'Muy bien!',
                        text:'Mensaje enviado con exito!',
                        type:'success'
                    });

                    location.reload();
                }
            }

        });
    });


    //evento para nuevo msj
    $('#btn_nuevomensaje').click(function(){
       $('#nuevomensaje').removeClass('hidden');
    });


    //evento para nueva bitacora
    $('#btn_registrarbitacora').click(function(){
        var opcion = '';
        if($('#solucioncheck').is(':checked'))
        {

            opcion = 2;
        }
        else
        {
            opcion = 1;
        }
        $.ajax({
            url:'savebitacora',
            datatype:'json',
            type:'post',
            data:{opcion:opcion,ticket:$('#ticket').val(),tiempodedicado:$('#tiempo').val(),descripcion:$('#descripcion').val(),
                fechabitacora:moment($('#fechabitacora').val()).format('YYYYMMDD H:mm')},
            success:function(data)
            {
                if(data===true)
                {
                    new PNotify({
                        title:'Muy bien!',
                        text:'Bitacora ingresada con exito',
                        type:'success'
                    });

                    document.getElementById('frm_nuevabitacora').reset();

                    location.reload();

                }
                else
                {
                    new PNotify({
                        title:'Error!',
                        text:'Ocurrio un error al intentar registrar la bitacora',
                        type:'error'
                    });
                }
            }
        });
    });


    //evento para conversion de tiempo dedicado
    $('#tiempo').change(function(){
        $('#conversiontiempo').removeClass('hidden').html('El tiempo seleccionado equivale a: '+convertirTiempoDedicado()+' minutos');
    });



    //evento para generar un cambio con la solucion y tiempo dedicado establecido
    $('.btn_guardar').click(function(){

        var id = this.id;
        $.ajax({
            url:'updateticket',
            datatype:'json',
            type:'post',
            data:{id:id,opcion:3,categoria:$('#categoria option:selected').val(),estado:$('#estado option:selected').val(),
                sistema:$('#sistemas option:selected').val(),modulo:$('#modulo option:selected').val(),solucion:$('#solucion').val()
                    ,tiempodedicado:$('#tiempodedicado').val(),fechasolucion:$('#fsolucion').val()},
            success:function(data)
            {
                if(data=='success')
                {
                    new PNotify({
                        title:'Muy bien!',
                        text:'Administracion exitosa!',
                        type:'success'
                    });

                    location.reload();

                }
                else
                {
                    new PNotify({
                        title:'Error!',
                        text:'ocurrio un error en la administracion del ticket!',
                        type:'error'
                    });
                }
            }
        });
    });


});