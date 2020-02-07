

function reservasDias(dia1,dia2)
{
    //verificamos que la reserva no sea de mas de dos dias

    var desde   = dia1.substring(0,2);


    var hasta   = dia2.substring(0,2);


    var diferencia   = parseInt(hasta)- parseInt(desde);

    return diferencia;
}

//variable global de dias reservados
var diasreservados = '';

//variable global de estado reservado
var estadofecha,estadofecha2 = '';
var estadohora,estadohora2 = '';


$(document).ready(function($){

     var reservas = '';
     var usuarios = new Array();
     var empleados = new Array();



     //obtener las reservas para full calendar
     $.getJSON('getreservas',{},function(data){
         reservas = data;
     });








    /* inicializar el calendario
     -----------------------------------------------------------------*/
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();



    $('#calendar').fullCalendar({
        lang:'es',
        displayEventTime: false,
        header: {

            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        drop: function() {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        events:'getreservas',
        timeFormat: 'h(:mm)t',

        eventClick:  function(event, jsEvent, view) {

            $.getJSON('getreservabyid',{id:event.id},function(data){
                $('#modalevento').click();

                $.each(data, function(index){

                    var fechain = data[index].fechainicio;
                    var fechafi = data[index].fechafin;

                    //rellenamos los datos de la modal
                    $('#empleado1').val(data[index].empleado);
                    $('#motivo1').val(data[index].motivo);
                    $('#fechainicio1').val(moment(fechain).format('DD/MM/YYYY H:mm'));
                    $('#fechafin1').val(moment(fechafi).format('DD/MM/YYYY H:mm'));
                    $('#horainicio1').val(data[index].horainicio);
                    $('#horafin1').val(data[index].horafin);
                    $('#vhreservado').val(data[index].vehiculo)
                });

            });


        }
    });


    /*---------------------------------------------------------------------------------
     Evento para ingresar la reserva por medio de una llamada AJAX
     -------------------------------------------------------------------------------*/
        $('#btn_ingresarreserva').click(function(){


            if($('#fechainicio').val()!=$('#fechafin').val())
            {
                //hacemos comprobaciones a nivel de vista para que al servidor solo lleguen los datos correctos y se genere la reserva
                if(diasreservados<=3 && estadofecha=='disponible' && estadofecha2 == 'disponible' )
                {
                    $.ajax({
                        url:'ingresarreserva',
                        datatype:'json',
                        type:'post',
                        data:{opcion:2,nombrecompleto:$('#nombrecompleto').val(),jefe:$('#jefe').val(),
                            departamento:$("#departamento option:selected").val(),vehiculo:$('#vehiculo option:selected').val(),
                            fechainicio:$('#fechainicio').val(),fechafin:$('#fechafin').val(),horainicio:$('#horainicio').val()
                            ,horafin:$('#horafin').val(),motivo:$('#motivo').val()},
                        success:function(data)
                        {
                            if(data=="success")
                            {
                                new PNotify({
                                    title: 'muy bien!',
                                    text: 'Reserva ingresada con exito',
                                    type: 'success'
                                });
                                $('#btn_cerrarmodal').click();
                                location.reload();
                            }
                            else

                            {
                                new PNotify({
                                    title: 'Error!',
                                    text: 'Ocurrio un error mientras se ingresaba la reserva',
                                    type: 'error'
                                });


                            }
                        }
                    });
                }
                else
                {
                    new PNotify({
                        title: 'Error!',
                        text: 'Revise los datos de su reserva',
                        type: 'error'
                    });

                    //establecemos en blanco los horarios para que el usuario los cambie
                    $('#horainicio').val(' ');
                    $('#horafin').val(' ');
                }
            }
            else if($('#fechainicio').val()==$('#fechafin').val())
            {
                //hacemos comprobaciones a nivel de vista para que al servidor solo lleguen los datos correctos y se genere la reserva
                if(diasreservados<=3 && estadofecha=='disponible' && estadofecha2 == 'disponible' && estadohora == 'disponible' )
                {
                    $.ajax({
                        url:'ingresarreserva',
                        datatype:'json',
                        type:'post',
                        data:{opcion:1,nombrecompleto:$('#nombrecompleto').val(),jefe:$('#jefe').val(),
                            departamento:$("#departamento option:selected").val(),vehiculo:$('#vehiculo option:selected').val(),
                            fechainicio:$('#fechainicio').val(),fechafin:$('#fechafin').val(),horainicio:$('#horainicio').val()
                            ,horafin:$('#horafin').val(),motivo:$('#motivo').val()},
                        success:function(data)
                        {
                            if(data=="success")
                            {
                                new PNotify({
                                    title: 'muy bien!',
                                    text: 'Reserva ingresada con exito',
                                    type: 'success'
                                });
                                $('#btn_cerrarmodal').click();
                                location.reload();
                            }
                            else
                            {
                                new PNotify({
                                    title: 'Error!',
                                    text: 'Ocurrio un error mientras se ingresaba la reserva',
                                    type: 'error'
                                });


                            }
                        }
                    });
                }
                else
                {
                    new PNotify({
                        title: 'Error!',
                        text: 'Revise los datos de su reserva',
                        type: 'error'
                    });

                    //establecemos en blanco los horarios para que el usuario los cambie
                    $('#horainicio').val(' ');
                    $('#horafin').val(' ');
                }
            }




        });




    /*------------------------------------------------------------------------------------*/




    /*--------------------------------------------------------------------------------
     evento para remover los atributos readonly de las fechas lo cual condiciona siempre
     ingresar primero un vehiculo
     ----------------------------------------------------------------------------------*/

        $("#vehiculo").change(function(){
            $('#fechas').removeClass('hidden');
            $('#horarios').removeClass('hidden');


        });
    /*-------------------------------------------------------------------------------------*/



    /*--------------------------------------------------------------------------------
     evento para comprobar que los dias esten disponibles
     ----------------------------------------------------------------------------------*/

    $('#fechainicio').change(function(){
        $.ajax({
            url:'fechainicio',
            datatype:'json',
            type:'post',
            data:{fecha:$('#fechainicio').val(),vehiculo:$('#vehiculo option:selected').val()},
            success:function(data)
            {
                if(data=="dia reservado")
                {
                    swal(
                        'Atencion!',
                        'El vehiculo seleccionado tiene todo el dia reservado!',
                        'info'
                    )

                    //sobreescribimos la variable de estado de la reserva
                    estadofecha = 'reservado';


                }
                else
                {
                    //sobreescribimos la variable de estado de la reserva
                    estadofecha = 'disponible';
                }
            }
        })

    });





    $('#fechafin').change(function(){
        $('#fechasselect').val('');
        $('#table_horarios').addClass('hidden');
        $('#cuerpotable').html('');

        //comprobamos que para el dia seleccionado no hay reservas de dias completo
        $.ajax({
            url:'fechafin',
            datatype:'json',
            type:'post',
            data:{fecha:$('#fechafin').val(),vehiculo:$('#vehiculo option:selected').val()},
            success:function(data)
            {
                if(data=="dia reservado")
                {
                    swal(
                        'Atencion!',
                        'El vehiculo seleccionado tiene todo el dia reservado!',
                        'info'
                    )

                    estadofecha2 = 'reservado';
                }
                else if(data=="dia disponible")
                {
                    //mostramos las fechas que selecciono el empleado
                    $('#fechasselect').val($('#fechainicio').val()+' - '+$('#fechafin').val());

                    estadofecha2 = 'disponible';

                }
            }
        });


        //sobreescribimos la variable reserva de dias
        diasreservados = reservasDias($('#fechainicio').val(),$('#fechafin').val());

        if(diasreservados>3)
        {
            swal(
                'Atencion!',
                'No se pueden realizar reservas de mas de 3 dias',
                'info'
            )

        }




    });



    /*-----------------------------------------------------------------------------------*/






    /*-----------------------------------------------------------------------------
    ver las reservas segun la fecha digitada
     -------------------------------------------------------------------------------*/

    $('#btn_verreserva').click(function(data){
        $.ajax({
            url:'horariosByFecha',
            type:'post',
            datatype:'json',
            data:{fecha:$("#fechainicio").val(),vehiculo:$('#vehiculo option:selected').val()},
            success:function(data)
            {
                $('#table_horarios').removeClass('hidden');
                $.each(data, function(index){
                   $('#cuerpotable').append('<tr><td>'+data[index].horainicio+'</td><td>'+data[index].horafin+'</td></tr>');
                });
            }
        });
    });



    /*-------------------------------------------------------------------------------*/




    /*--------------------------------------------------------------------------------------
     al momento que el empleado dijite la hora verificamos si esa hora esta reservada
     ----------------------------------------------------------------------------------------*/

    /*$('#horainicio').change(function(){

        if($('#fechainicio').val()==$('#fechafin').val())
        {
            $.ajax({
                url:'comprobardisponibilidad3',
                type:'post',
                datatype:'json',
                data:{fechainicio:$("#fechainicio").val(),horainicio:$('#horainicio').val(),horafin:$('#horafin').val(),
                    vehiculo:$('#vehiculo option:selected').val()},
                success:function(data)
                {
                    if(data=='reservado')
                    {
                        swal(
                            'Atencion!',
                            'La hora seleccionada no es valida, ya existe una reserva ingresada',
                            'info'
                        )
                        estadohora = 'reservado';
                    }
                    else
                    {
                        estadohora = 'disponible';
                    }



                }

            });
        }
    });*/




    /*-------------------------------------------------------------------------------------------*/



    /*--------------------------------------------------------------------------------------
     al momento que el empleado dijite las horas verificamos que la reserva este disponible
     ----------------------------------------------------------------------------------------*/

    $('#horafin').change(function(){

        //realizamos la comprobacion que la hora digitada no este entre las reservas



        //verificamos que las fechas sean iguales para el analisis de lo contrario el analisis se hara en base a reservas de mas de un dia
        if($('#fechainicio').val()==$('#fechafin').val())
        {
            $.ajax({
                url:'comprobardisponibilidad1',
                type:'post',
                datatype:'json',
                data:{fechainicio:$("#fechainicio").val(),horainicio:$('#horainicio').val(),horafin:$('#horafin').val(),
                    vehiculo:$('#vehiculo option:selected').val()},
                success:function(data)
                {
                    if(data=='reservado')
                    {
                        swal(
                            'Atencion!',
                            'Ya existe una reserva ingresada en el sistema con estos parametros!',
                            'info'
                            )
                        estadohora = 'reservado';
                    }
                    else
                    {
                        estadohora = 'disponible';
                    }



                }

            });
        }
        else if($('#fechainicio').val()!=$('#fechafin').val())
        {


                $.ajax({
                    url:'comprobardisponibilidad2',
                    type:'post',
                    datatype:'json',
                    data:{fechainicio:$("#fechainicio").val(),fechafin:$('#fechafin').val(),horainicio:$('#horainicio').val(),
                        horafin:$('#horafin').val(),vehiculo:$('#vehiculo option:selected').val()},
                    success:function(data)
                    {
                        if(data=='reservado')
                        {
                            swal(
                                'Atencion!',
                                'Ya existe una reserva ingresada en el sistema con estos parametros!',
                                'info'
                            )
                            estadohora = 'reservado';
                        }
                        else
                        {
                            estadohora = 'disponible';
                        }

                    }
                });

        }
    });




    /*-------------------------------------------------------------------------------------------*/







    /*-------------------------------------------------------------------------------------------
     Obtener las jefaturas para poder realizar el autocomplete en el formulario de nuevo permiso
     ------------------------------------------------------------------------------------------*/



    /*--------------------------------------------------------------------------------------*/





    /*-----------------------------------------------------------------------------
     Obtener las jefaturas para poder realizar el autocomplete en el formulario de nuevo permiso
     -------------------------------------------------------------------------------*/




    //obtenemos los usuarios de jefatura de la base de datos
    $.getJSON('getjefaturas', function(data) {

        for(var i in data)
        {
            //llenamos el arreglo usuarios con el nombre y apellido de cada uno
            usuarios[i] = data[i].nombre+" "+data[i].apellido;
        }

        console.log(usuarios);

    });


    //obtener todos los usuarios
    $.getJSON('getusuariosall', function(data) {

        for(var i in data)
        {
            //llenamos el arreglo usuarios con el nombre y apellido de cada uno
            empleados[i] = data[i].nombre+" "+data[i].apellido;
        }

        console.log(empleados);

    });




    /*--------------------------------------------------------------------------------
     evento para poder listar los jefes inmediatos en el input de tipo text
     ----------------------------------------------------------------------------------*/

    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });

            cb(matches);
        };
    };


    var substringMatcher1 = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });

            cb(matches);
        };
    };




    $('#the-basics .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'usuarios',
            source: substringMatcher(usuarios)
        });


    //GET EMPLEADOS
    $('#the-basics1 .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'empleados',
            source: substringMatcher1(empleados)
        });
    /*-------------------------------------------------------------------
     ---------------------------------------------------------------------*/









});