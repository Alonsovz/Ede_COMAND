$(document).ready(function(){
    $("#btnSoliProceso").removeClass("btn btn-outline");
    $("#btnSoliSolucionados").removeClass("btn btn-outline");
    $("#btnSoliRechazados").removeClass("btn btn-outline");
    
    $('#btnProcesos').removeClass('btn btn-outline');
    $('#btnPausa').removeClass('btn btn-outline');

    //variables globales
    var usuarios = new Array();

    $(function () {
        $('#datetimepicker1').datetimepicker();
        $('#datetimepicker2').datetimepicker();
        $('#datetimepicker3').datetimepicker();
    });




    //$('.navbar-minimalize').click();



    /*---------------------------------------------------------------------------
        eventos de click para los botones de tickets
    * ---------------------------------------------------------------------------*/
    $('#btn_ticketexpress').click(function(){
        $('#ticketexpress').removeClass('hidden');
        $('#ticketpersonalizado').addClass('hidden');
        $('#ticketextraordinario').addClass('hidden');
        $('#ticketquick').addClass('hidden');

    });

    $('#btn_ticketpersonalizado').click(function(){
        $('#ticketexpress').addClass('hidden');
        $('#ticketpersonalizado').removeClass('hidden');

    });

    //-----------------------------------------------------------------------------






    /*------------------------------------------------------------------------------
    * Evento para poder listar los modulos segun el sistema que se seleccione
    * -----------------------------------------------------------------------------*/

    $('#sistemaspersonalizado').change(function(){

         var idmodulo = $('#sistemaspersonalizado option:selected').val();
         $('#modulos').html('');

         //evento ajax para obtener los modulos
        $.getJSON('getmodulos',{idmodulo:idmodulo},function(data){

            var fila = '';

            //recorremos el json resultante
            $.each(data,function(index){
                fila+="<option value="+data[index].id+">"+data[index].nombre+"</option>";
            });

            console.log(fila);

            //rellenamos el select de los modulos
            $('#divmodulos').removeClass('hidden');
            $('#modulos').append(fila);

        });
    });

    $('#sistemasquick').change(function(){

        var idmodulo = $('#sistemasquick option:selected').val();
        $('#modquick').html('');

        //evento ajax para obtener los modulos
        $.getJSON('getmodulos',{idmodulo:idmodulo},function(data){

            var fila = '';

            //recorremos el json resultante
            $.each(data,function(index){
                fila+="<option value="+data[index].id+">"+data[index].nombre+"</option>";
            });

            $('#modquick').append(fila);

            console.log(fila);

            //rellenamos el select de los modulos
            $('#divmoduloquick').removeClass('hidden');
            $('#moduloquick').append(fila);

        });
    });


    //------------------------------------------------------------------------------






    /*-------------------------------------------------------------------------------
    * Evento para guardar un TICKET de tipo GENERAL
    * ------------------------------------------------------------------------------*/

    $('#btn_guardarexpress').click(function(){

      $('#btn_guardarexpress').addClass('hidden');

        //validamos que los campos de usuario asignado y descripcion no se encuentren vacios
        if($('#descripcionexpress').val()=="" || $("#usuarioexpress option:selected").val()=="")
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
                url:'saveticket',
                datatype:'json',
                type:'post',
                data:{opcion:1,titulo:$('#tituloexpress').val(),descripcion:$('#descripcionexpress').val(),
                    usuarioasignado:$('#usuarioexpress').val(),fechasolucionaprox:moment($('#fechasolaproxexpress').val()).format('YYYYMMD h:mm')},
                success:function(data)
                {
                    if(data=="success")
                    {
                        new PNotify({
                            title: 'muy bien!',
                            text: 'Ticket ingresado con exito',
                            type: 'success'
                        });

                        document.getElementById("frm_express").reset();

                        $('#btn_guardarexpress').removeClass('hidden');
                        $("#ticketgeneral").modal("toggle");
                        
                    }
                    else
                    {
                        new PNotify({
                            title: 'Error!',
                            text: 'Ocurrio un error!',
                            type: 'error'
                        });

                        $('#btn_guardarexpress').addClass('hidden');
                    }
                }
            });
        }




    });
    //--------------------------------------------------------------------------------






    /*---------------------------------------------------------------------------------
    * Evento para poder ingresar un TICKET PERSONALIZADO
    * --------------------------------------------------------------------------------*/
    $("#btn_guardarpersonalizado").click(function(data){
       if($("#descripcionpersonalizado").val()=="" || $("#usuariopersonalizado option:selected").val()=="" ||
           $("#sistemaspersonalizado option:selected").val()=="")
       {
           new PNotify({
               title:"Verificar",
               text:"No se permiten campos vacios",
               type:"warning"
           });
       }
       else
       {
           $.ajax({
               url:"saveticket",
               datatype:"json",
               type:"post",
               data:{descripcion:$("#descpersonalizado").val(),opcion:2,usuarioasignado:$("#usuariopersonalizado option:selected").val(),sistema:$("#sistemaspersonalizado option:selected").val(),
               modulo:$("#modulos option:selected").val(),titulo:$("#titulopersonalizado").val()},
               success:function(data)
               {
                   if(data=="success")
                   {
                       new PNotify({
                           title: 'muy bien!',
                           text: 'Ticket registrado con exito',
                           type: 'success'
                       });

                       document.getElementById("frm_personalizado").reset();
                       $('#modulos').val(" ");
                       $('#divmodulos').addClass("hidden");
                   }
                   else
                   {
                       new PNotify({
                           title: 'Error!',
                           text: 'Ocurrio un error!',
                           type: 'error'
                       });
                   }
               }
           });
       }
    });

    //---------------------------------------------------------------------------------



    //evento para mostrar info del ticket para aceptar o denegar
    $('.tck_infoticket').click(function(){
       $.ajax({
           url:'tck_infoticket',
           datatype:'json',
           data:{id:this.id},
           success:function(data)
           {
                $('#vistaTickets').slideUp('slow');
                $('#divinfoticket').removeClass('hidden').slideDown('slow').append(data);

           }
       });
    });

    //evento para supervisar el ticket seleccionado por jefatura
    $('#tablatickets').on('click','.detallessupervision',function(){
        $.ajax({
            url:'tck_supervisarticket',
            datatype:'json',
            data:{id:this.id},
            success:function(data)
            {
                $('#tablatickets').slideUp('slow');
                $('#divsupervticket').removeClass('hidden').slideDown('slow').append(data);

            }
        });
    });


    /*----------------------------------------------------------------------------------
    * eventos para los formularios de creacion de tickets de usuario STAFF
    * ----------------------------------------------------------------------------------*/

    $('#btn_ticketextraordinario').click(function(){
        $('#ticketexpress').addClass('hidden');
        $('#ticketquick').addClass('hidden');
        $('#ticketextraordinario').removeClass('hidden');
    });

    $('#btn_ticketquick').click(function(){
        $('#ticketexpress').addClass('hidden');
        $('#ticketquick').removeClass('hidden');
        $('#ticketextraordinario').addClass('hidden');
    });

    //-------------------------------------------------------------------------------------






    /*----------------------------------------------------------------------------------
     * eventos para ingresar un ticket INFORMATICA
     * ----------------------------------------------------------------------------------*/

    $('#btn_guardarextraordinario').click(function(){

      $('#btn_guardarextraordinario').addClass('hidden');

        if($('#usuarioextraordinario').val()=='' || $('#descextraordinario').val()=='')
        {
            new PNotify({
                title:'Verifique sus datos',
                text:'No se aceptan campos vacios',
                type:'warning'
            });
        }
        else
        {
            $.ajax({

                url:'saveticket',
                type:'post',
                datatype:'json',
                data:{descripcion:$("#descextraordinario").val(),opcion:2,usuarioasignado:$("#usuarioextraordinario").val(),
                    sistema:$("#sistemaspersonalizado option:selected").val(),fechasolucionaprox:moment($('#fechasolaproxextraordinario').val()).format('YYYYMMD h:mm'),
                    modulo:$("#modulos option:selected").val(),titulo:$("#tituloextraordinario").val()},
                success:function(data)
                {
                    if(data=='success')
                    {
                        new PNotify({
                            title:'Muy bien!',
                            text:'Ticket ingresado con exito',
                            type:'success'
                        });


                        document.getElementById('frm_extraordinario').reset();
                        $('#modulos').val(" ");
                        $('#divmodulos').addClass("hidden");
                        $('#btn_guardarextraordinario').removeClass('hidden');
                        $("#ticketinformatica").modal("toggle");
                       
                    }
                    else
                    {
                        new PNotify({
                            title:'Lo sentimos!',
                            text:'Ocurrio un error mientras se guardaba el ticket',
                            type:'error'
                        });

                        $('#btn_guardarextraordinario').addClass('hidden');

                    }
                }

            });
        }

    });



    //-------------------------------------------------------------------------------------






    //TICKET DE INFORMATICA CON PERFIL DE INFORMATICA (DANIEL OSCAR RICARDO MILAGRO)
    $('#btn_guardarextraordinario1').click(function(){


      $('#btn_guardarextraordinario1').addClass('hidden');

        if($('#usuarioextraordinario').val()=='' || $('#descextraordinario').val()=='' || $('#tituloextraordinario').val()=='')
        {
            new PNotify({
                title:'Verifique sus datos',
                text:'No se aceptan campos vacios',
                type:'warning'
            });
        }
        else
        {
            $.ajax({

                url:'saveticket',
                type:'post',
                datatype:'json',
                data:{descripcion:$("#descextraordinario").val(),opcion:911,usuarioasignado:$("#usuarioextraordinario").val(),solicitante:$('#usersolicitante').val(),
                    sistema:$("#sistemaspersonalizado option:selected").val(),fechasolucionaprox:moment($('#fechasolaproxextraordinario').val()).format('YYYYMMD h:mm'),
                    modulo:$("#modulos option:selected").val(),titulo:$("#tituloextraordinario").val()},
                success:function(data)
                {
                    if(data=='success')
                    {
                        new PNotify({
                            title:'Muy bien!',
                            text:'Ticket ingresado con exito',
                            type:'success'
                        });


                        document.getElementById('frm_extraordinario').reset();
                        $('#modulos').val(" ");
                        $('#divmodulos').addClass("hidden");
                        $('#btn_guardarextraordinario1').removeClass('hidden');
                    }
                    else
                    {
                        new PNotify({
                            title:'Lo sentimos!',
                            text:'Ocurrio un error mientras se guardaba el ticket',
                            type:'error'
                        });

                        $('#btn_guardarextraordinario1').addClass('hidden');
                    }
                }

            });
        }

    });



    //evento para mostrar la tabla de los tickets completados
    $('#completadostck').click(function(){
       $('#completados').removeClass('hidden');
       $('#btn_recibidos').removeClass('hidden');
       $('#completadostck').addClass('hidden');
       $('#recibidostck').addClass('hidden');
       $('#cerrados').addClass('hidden');
       $('#btnCerrados').removeClass('hidden');
       $('#btnNav').addClass('hidden');
       $('#dtProcesos').addClass('hidden');
       $('#dtPausas').addClass('hidden');
       $('#btnNavS').removeClass('hidden');
    });

        $('#btn_recibidos').click(function(){
        $('#completados').addClass('hidden');
        $('#btn_recibidos').addClass('hidden');
        $('#completadostck').removeClass('hidden');
        $('#recibidostck').removeClass('hidden');
        $('#cerrados').addClass('hidden');
        $('#btnCerrados').removeClass('hidden');
        $('#btnNav').removeClass('hidden');
        $('#dtProcesos').addClass('hidden');
        $('#dtPausas').addClass('hidden');

        $('#btnNavS').addClass('hidden');

        $('#btnProcesos').removeClass('btn btn-outline');
        $('#btnPausa').removeClass('btn btn-outline');
        $('#btnRecibidosP').addClass('btn btn-outline');
    });


    $('#btnCerrados').click(function(){
        $('#cerrados').removeClass('hidden');
        $('#recibidostck').addClass('hidden');
        $('#completados').addClass('hidden');
        $('#btn_recibidos').removeClass('hidden');
        $('#completadostck').removeClass('hidden');
        $('#btnNav').addClass('hidden');
        $('#dtProcesos').addClass('hidden');
        $('#dtPausas').addClass('hidden');
        $('#btnNavS').addClass('hidden');
     });


     $('#btnProcesos').click(function(){
        $('#recibidostck').addClass('hidden');
        $('#dtProcesos').removeClass('hidden');
        $('#dtPausas').addClass('hidden');



        $('#btnRecibidosP').removeClass('btn btn-outline');
        $('#btnProcesos').addClass('btn btn-outline');
        $('#btnPausa').removeClass('btn btn-outline');
        $('#btnNavS').addClass('hidden');
     });


     $('#btnPausa').click(function(){
        $('#recibidostck').addClass('hidden');
        $('#dtProcesos').addClass('hidden');
        $('#dtPausas').removeClass('hidden');

        $('#btnRecibidosP').removeClass('btn btn-outline');
        $('#btnProcesos').removeClass('btn btn-outline');
        $('#btnPausa').addClass('btn btn-outline');
        $('#btnNavS').addClass('hidden');
     });

     $('#btnRecibidosP').click(function(){
        $('#recibidostck').removeClass('hidden');
        $('#dtProcesos').addClass('hidden');
        $('#dtPausas').addClass('hidden');

        $('#btnRecibidosP').addClass('btn btn-outline');
        $('#btnProcesos').removeClass('btn btn-outline');
        $('#btnPausa').removeClass('btn btn-outline');
        $('#btnNavS').addClass('hidden');
     });


     $('#btnSolucionados').click(function(){
        $('#dtSolucionados').removeClass('hidden');
        $('#dtRechazados').addClass('hidden'); 
        $('#btnSolucionados').addClass('hidden'); 
        $('#btnRechazados').removeClass('hidden');
     });


     $('#btnRechazados').click(function(){
        $('#dtSolucionados').addClass('hidden');
        $('#dtRechazados').removeClass('hidden'); 
        $('#btnSolucionados').removeClass('hidden'); 
        $('#btnRechazados').addClass('hidden');
     });


     $('#btnSoliProceso').click(function(){
         $("#btnSoliRecibidos").removeClass("btn btn-outline");
        $("#btnSoliSolucionados").removeClass("btn btn-outline");
        $("#btnSoliRechazados").removeClass("btn btn-outline");
        $('#btnSoliProceso').addClass("btn btn-outline");

        $("#soliRechazados").addClass("hidden");
        $("#soliSolucionados").addClass("hidden");
        $("#soliRecibidos").addClass("hidden");
        $("#soliProceso").removeClass("hidden");
        
     });

     $('#btnSoliRecibidos').click(function(){
        $("#btnSoliProceso").removeClass("btn btn-outline");
       $("#btnSoliSolucionados").removeClass("btn btn-outline");
       $("#btnSoliRechazados").removeClass("btn btn-outline");
       $('#btnSoliRecibidos').addClass("btn btn-outline");

       $("#soliRechazados").addClass("hidden");
        $("#soliSolucionados").addClass("hidden");
        $("#soliRecibidos").removeClass("hidden");
        $("#soliProceso").addClass("hidden");

    });

    $('#btnSoliSolucionados').click(function(){
        $("#btnSoliRecibidos").removeClass("btn btn-outline");
       $("#btnSoliProceso").removeClass("btn btn-outline");
       $("#btnSoliRechazados").removeClass("btn btn-outline");
       $('#btnSoliSolucionados').addClass("btn btn-outline");

       $("#soliRechazados").addClass("hidden");
        $("#soliSolucionados").removeClass("hidden");
        $("#soliRecibidos").addClass("hidden");
        $("#soliProceso").addClass("hidden");
    });

    $('#btnSoliRechazados').click(function(){
        $("#btnSoliRecibidos").removeClass("btn btn-outline");
       $("#btnSoliSolucionados").removeClass("btn btn-outline");
       $("#btnSoliProceso").removeClass("btn btn-outline");
       $('#btnSoliRechazados').addClass("btn btn-outline");

       $("#soliRechazados").removeClass("hidden");
        $("#soliSolucionados").addClass("hidden");
        $("#soliRecibidos").addClass("hidden");
        $("#soliProceso").addClass("hidden");
    });


 /*----------------------------------------------------------------------------------
     * eventos para mostrar tickets cerrados en solicitados
     * ----------------------------------------------------------------------------------*/

    $('#btnCerrados').click(function(){
        $('#tablaGeneral').addClass('hidden');
        $('#cerradosSolicitados').removeClass('hidden');
        $('#btnSolicitados').removeClass('hidden');
        $('#btnCerrados').addClass('hidden');
    });


    $('#btnSolicitados').click(function(){
        $('#tablaGeneral').removeClass('hidden');
        $('#cerradosSolicitados').addClass('hidden');
        $('#btnSolicitados').addClass('hidden');
        $('#btnCerrados').removeClass('hidden');
     });


    /*----------------------------------------------------------------------------------
     * eventos para ingresar un ticket extraordinario
     * ----------------------------------------------------------------------------------*/

    $('#btn_guardarquick').click(function(){

        if($('#usuarioquick').val()=='' || $('#descripcionquick').val()=='' ||
            $('#solucionquick').val()=='' || $('#tiempodedicado').val()=='' || $('#categoriaquick option:selected').val()=='')
        {
            new PNotify({
                title:'Verifique sus datos',
                text:'No se aceptan campos vacios',
                type:'warning'
            });
        }
        else
        {
            $.ajax({
                url:'saveticket',
                type:'post',
                datatype:'json',
                data:{fechasolucion:$('.fsolucion').val(),descripcion:$("#descripcionquick").val(),opcion:4,usuariosolicitante:$("#usuarioquick").val(),
                    sistema:$("#sistemasquick option:selected").val(),fechasol:moment($('#fechasolautoticket').val()).format('YYYYMMD h:mm'),
                    modulo:$("#modquick option:selected").val(),titulo:$("#tituloquick").val(),
                    categoria:$('#categoriaquick option:selected').val(),
                    solucion:$('#solucionquick').val(),tiempodedicado:$('#tiempodedicado').val()},
                success:function(data)
                {
                    if(data===true)
                    {
                        new PNotify({
                            title:'Muy bien!',
                            text:'Ticket ingresado con exito',
                            type:'success'
                        });


                        document.getElementById('frm_quick').reset();
                        $('#modulos').val(" ");
                        $('#divmodulos').addClass("hidden");
                        $('#autoticket').modal("toggle");
                        
                    }
                    else
                    {
                        new PNotify({
                            title:'Lo sentimos!',
                            text:'Ocurrio un error mientras se guardaba el ticket',
                            type:'error'
                        })
                    }
                }

            });
        }

    });


    //-------------------------------------------------------------------------------------



    //evento para titulo de autoticket en el que el titulo pasara automaticamente al apartado de descripcion
    $('#tituloquick').change(function(){
       $('#descripcionquick').val(this.value);
    });




    /*---------------------------------------------------------------------------------
     evento para detalles de ticket recibido
     ----------------------------------------------------------------------------------*/



      $('.btn_ticketrecibido').click(function(){
          $("#btn_regresarbandeja").removeClass('hidden');
          $('#boardtickets').fadeOut(200,function(){
              $('#boardtickets').addClass('hidden');
          });

          $('#detalllesticketrecibido').html(" ");
          var id = this.id;
          $.ajax({

              url:'findticketbyid',
              type:'post',
              datatype:'json',
              data:{id:id},
              success:function(data)
              {
                $('#detalllesticketrecibido').removeClass('hidden');
                $('#detalllesticketrecibido').append(data);
              }

          });
      });



    //-----------------------------------------------------------------------------------





    /*---------------------------------------------------------------------------------
     evento para detalles de ticket recibido
     ----------------------------------------------------------------------------------*/



    // $('.btn_administrarticket').click(function(){
    //
    //
    //
    //     var id = this.id;
    //
    //     $.ajax({
    //
    //         url:'administrarticket',
    //         type:'post',
    //         datatype:'json',
    //         data:{id:id},
    //         success:function(data)
    //         {
    //
    //
    //         }
    //
    //     });
    // });



    //-----------------------------------------------------------------------------------



    //evento para poder adminstrar la bitacora del ticket
    $('.administrarbitacora').click(function(){
        var id = this.id;
        $('#nuevabitacora').html(" ");
        $('#boardtickets').slideUp('fast',function(){
            $.ajax({
                url:'administracionbitacoras',
                datatype:'json',
                data:{id:id},
                type:'post',
                success:function(data)
                {
                    $('#nuevabitacora').removeClass('hidden');
                    $('#nuevabitacora').append(data);
                }
            });
        });

    });



    //evento para nuevo mensaje
    $('#btn_nuevomensaje').click(function(){
       $('.ibox-content').removeClass('hidden');
       $('.ibox-content').slideDown('slow');
    });



    //evento para denegar solucion
    $('.btn_denegarsolucion').click(function(){
       $('#bodymodal').slideDown('slow');
       $('#bodymodal').removeClass('hidden');
    });


    //evento para poder aceptar una resolucion
    $('.btn_aceptarsolucion').click(function(){
        var id = this.id;
        $.ajax({
            url:'updateticket',
            datatype: 'json',
            type:'post',
            data:{opcion:4,id:id,estado:'aceptado'},
            success:function(data)
            {
                if(data=="success")
                {
                    $('#cerrarresolucion').click();

                    new PNotify({
                        title:'Muy bien!',
                        text:'Estado de ticket actualizado con exito!',
                        type:'success'
                    });

                    location.href = 'dashboard';
                }
                else
                {
                    new PNotify({
                        title:'Error!',
                        text:'Ocurrio un error mientras se actualizaba el ticket',
                        type:'error'
                    });
                }
            }
        });
    });


    //evento para poder denegar una resolucion
    $('.btn_enviardenegacion').click(function(){
        var id = this.id;
        if($('#comentario').val()==' ')
        {
            new PNotify({
                title:'verificar',
                text:'Favor rellenar el campo de comentario para una mejor resolucion',
                type:'warning'
            });
        }
        else {
            $.ajax({
                url:'updateticket',
                datatype: 'json',
                type:'post',
                data:{opcion:4,id:id,estado:'denegado',comentario:$('#comentario').val()},
                success:function(data)
                {
                    if(data=="success")
                    {
                        $('#cerrarresolucion').click();
                        new PNotify({
                            title:'Muy bien!',
                            text:'Estado de ticket actualizado con exito!',
                            type:'success'
                        });

                        location.href = 'dashboard';
                    }
                    else
                    {
                        new PNotify({
                            title:'Error!',
                            text:'Ocurrio un error mientras se actualizaba el ticket',
                            type:'error'
                        });
                    }
                }
            });
        }
    });







    /*---------------------------------------------------------------------------------
    autocomplete de usuarios en el formulario de usuarios no staff
    ----------------------------------------------------------------------------------*/
    //obtenemos los usuarios nostaff de la base de datos
    $.getJSON('getusuariosall', function(data) {

        for(var i in data)
        {
            //llenamos el arreglo usuarios con el nombre y apellido de cada uno
            usuarios[i] = data[i].nombre+" "+data[i].apellido;
        }

    });






    /*--------------------------------------------------------------------------------
     evento para poder listar
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







    $('#the-basics .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'usuarios',
            source: substringMatcher(usuarios)
        });

    //---------------------------------------------------------------------------------

});//fin de ready


