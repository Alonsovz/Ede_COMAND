$(document).ready(function(){

    //variables globales
    var h1,h2 = '';
    var reserva = '';
    var desde,hasta ='';




   // $('.navbar-minimalize').click();


    $(function() {
        $('input[name="fecha1"]').daterangepicker();
        $('input[name="fecha2"]').daterangepicker();

    });


    //variables globales
    var usuarios = new Array();

    $('.km').mask('000000000000000000');

    //mostrar el formulario de nuevo kilometraje
    $('#btn_nuevokilometraje').click(function(){
        $('#btn_nuevokilometraje').addClass('hidden');
      $('#divkilometraje').removeClass('hidden');
   });


    $('#datetimepicker1').datetimepicker();
    $('#datetimepicker2').datetimepicker();


    //obtener los empleados por medio de la tabla users del comanda
    $.getJSON('getusuariosall',{},function(data){
        var i = 0;
       $.each(data,function(index){
            usuarios[i] = data[index].nombre+' '+data[index].apellido;
            i++;
       });

       console.log(usuarios);
    });


    //evento para listar los empleados que se encuentran en la base de comanda
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


    //Validacion de km's
    $('#kmfinal').change(function(){

        var kmini = $('#kminicio').val();
        var kmfin = $('#kmfinal').val();

       if(parseInt(kmini)>parseInt(kmfin))
       {
           swal({
               type: 'warning',
               title: 'Verificar!',
               text: 'El kilometraje inicial no puede ser mayor que el final',
               footer: ''
           });

           $('#btn_guardarkilometraje').addClass('hidden');
       }
       else
       {
           $('#btn_guardarkilometraje').removeClass('hidden');
       }
    });

    //validacion de costos
    $('#costocargado').change(function(){
       var galones_cargados = $('#galones').val();
       var costo            = $('#costocargado').val();


       if(galones_cargados==='' || galones_cargados===0)
       {
           swal({
               type: 'warning',
               title: 'Verificar!',
               text: 'Campo de galones vacio, favor rellenar',
               footer: ''
           });
       }
       else
       {
           if((costo/galones_cargados)>5 || (costo/galones_cargados)<3)
           {
               swal({
                   type: 'warning',
                   title: 'Verificar!',
                   text: 'Valores no validos entre costo y galones cargados',
                   footer: ''
               });
           }
       }

    });


    /*$('.hor1').change(function(){


    });*/




    //evento para guardar un nuevo registro de kilometraje
    $('#btn_guardarkilometraje').click(function(){

        var horario1 = moment($('#horario1').val(),'d/m/Y H:mm');
        var horario2 = moment($('#horario2').val(),'d/m/Y H:mm');

        var galones_cargados = $('#galones').val();
        var costo            = $('#costocargado').val();


        var diferencia = horario2.diff(horario1,'days');

        console.log(diferencia);


            $.ajax({
                url:'savekilometraje',
                datatype:'json',
                type:'post',
                data:{
                    empleado:$('#empleado').val(),
                    kminicial:$('#kminicio').val(),
                    kmfinal:$('#kmfinal').val(),
                    galones:parseFloat($('#galones').val()),
                    costo:$('#costo_cargado').val(),
                    recibo:$('#recibo').val(),
                    vehiculo:$('#vehiculo option:selected').val(),
                    horarioinicio:$('#horario1').val(),
                    horariofinal:$('#horario2').val(),
                    trabajo:$('#trabajorealizado').val(),
                    reserva:$('#txt_reseva').val(),
                    recorrido:$('#recorrido').val()
                },
                success:function(data)
                {

                        swal({
                            type: 'success',
                            title: 'Muy bien!',
                            text: 'Kilometraje ingresado con exito',
                            footer: ''
                        });

                        //limpiamos el formulario
                        document.getElementById('frm_kilometraje').reset();



                },error:function()
                {
                    swal({
                        type: 'error',
                        title: 'Verificar!',
                        text: 'Ocurrio un error mientras se intentaba guardar los cambios',
                        footer: ''
                    });
                }
            });


    });



    //evento para poder visualizar las reservas
    $('#btn_verreservas').click(function(){

        var fecha = moment($('#horario1').val(),'DD/MM/YYYY H:mm');



        if(fecha=='' || $('#vehiculo option:selected').val()=='')
        {
            swal({
                type: 'warning',
                title: 'Verificar!',
                text: 'Seleccione una fecha valida y vehiculo valido',
                footer: ''
            });
        }
        else
        {
            $('#divreservas').empty();

            $.ajax({
                url:'reservasbykilometraje',
                datatype:'json',
                type:'post',
                data:{horarioinicio:moment(fecha).format('YYYYMMDD'),vehiculo:$('#vehiculo option:selected').val()},
                success:function(data)
                {
                    $('#divreservas').append(data);
                }
            });
        }




    });

    //seleccionar reserva
    $('.btn_adjuntarreserva').click(function(){

        $('#divreservas').empty();
        $('#divreservas').addClass('hidden');
        reserva = this.id;
    });



    //actualizar kilometraje
    $('.btn_actualizarkilometraje').click(function(){
        var horario1 = moment($('#horario1').val(),'d/m/Y H:mm');
        var horario2 = moment($('#horario2').val(),'d/m/Y H:mm');


        var diferencia = horario2.diff(horario1,'days');

        console.log(diferencia);


         $.ajax({
                url:'actualizarkilometraje',
                datatype:'json',
                type:'post',
                data:{
                    id:this.id,
                    empleado:$('#empleado').val(),
                    kminicial:$('#kminicio').val(),
                    kmfinal:$('#kmfinal').val(),
                    galones:$('#galones').val(),
                    costo:$('#costocargado_edit').val(),
                    recibo:$('#recibo').val(),
                    vehiculo:$('#vehiculo option:selected').val(),
                    horarioinicio:$('#horario1').val(),
                    horariofinal:$('#horario2').val(),
                    trabajo:$('#trabajorealizado').val(),
                    reserva:$('#txt_reseva').val()
                },
                success:function(data)
                {
                    if(data===true)
                    {
                        swal({
                            type: 'success',
                            title: 'Muy bien!',
                            text: 'Kilometraje actualizado con exito',
                            footer: ''
                        });

                        //limpiamos el formulario
                        $('#divkilometraje').fadeOut('slow');
                        $('#btn_regresar').removeClass('hidden');

                    }
                }
            });


    });


    //evento change para vehiculos y saber su ultimo kilometraje
    $('#vehiculo').change(function(){
       $.getJSON('ultimokilometraje',{vehiculo:$('#vehiculo option:selected').val()},function(data){
           if(data)
           {
               $('#ultimokm').removeClass('hidden');
               $('#divultimouso').removeClass('hidden');
               for(var key in data)
               {
                   $('#txt_ultimokm').val(data['km_final']);
                   $('#txt_ultimouso').val(moment(data['horario_fin']).format('DD/MM/YYYY H:mm'));
               }

           }
           else
           {

               $('#txt_ultimokm').val('');
               $('#txt_ultimouso').val('');
           }
       });
    });

    //validacion para que el km inicial no sea menor que el que listamos en el ultimo kilometraje
    $('#kminicio').change(function(){
       if($('#kminicio').val()!==$('#txt_ultimokm').val())
       {
           console.log('diferentes');
           swal({
               type: 'warning',
               title: 'Verificar!',
               text: 'El kilometraje inicial no coincide con el ultimo kilometraje registrado en la Base de datos',
               footer: ''
           });
       }
    });


    //evento para obtener el query del resumen por vehiculo
    $('#btn_resumenporvehiculo').click(function(){
        var fecha = $('#fecha1').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);

        $.ajax({
            url:'query_resumenxvehiculo',
            datatype:'json',
            type:'post',
            data:{desde:moment(d).format('YYYYMMDD'),hasta:moment(h).format('YYYYMMDD')},
            success:function(data)
            {
                $('#renderresumenvh').removeClass('hidden');
                $('#renderresumenvh').append(data);
                $('#menureportes').addClass('hidden');
                $('#nuevoreporte').removeClass('hidden')
            }
        });
    });


    //render para el resumen por empleados
    $('#btn_generarresumenempleados').click(function(){
        var fecha = $('#fecha2').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);

        $.ajax({
            url:'query_resumenempleados',
            datatype:'json',
            type:'post',
            data:{desde:moment(d).format('YYYYMMDD'),hasta:moment(h).format('YYYYMMDD')},
            success:function(data)
            {
                $('#renderresumenempleados').removeClass('hidden');
                $('#renderresumenempleados').append(data);
                $('#menureportes').addClass('hidden');
                $('#nuevoreporte').removeClass('hidden')
            }
        });
    });



    //evento para generar el excel de resumen por vehiculo
    $('#resumenxvehiculoexcel').click(function(){
        var fecha = $('#fecha1').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);

        location.href='resumenxvehiculoExcel?desde='+moment(d).format('YYYYMMDD')+'&hasta='+moment(h).format('YYYYMMDD');
    });


    //evento para generar el excel de resumen por empleados
    $('#empleadosexcel').click(function(){
        var fecha = $('#fecha2').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);

        location.href='resumenxempleadosExcel?desde='+moment(d).format('YYYYMMDD')+'&hasta='+moment(h).format('YYYYMMDD');


    });

    //evento para generar el pdf de resumen por vehiculo
    $('#resumenxvehiculopdf').click(function(){
        var fecha = $('#fecha1').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);

        location.href='resumenxvehiculoPDF?desde='+moment(d).format('YYYYMMDD')+'&hasta='+moment(h).format('YYYYMMDD');
    });


    //evento change del total de recorrido con el km final digitado
    $('#kmfinal').change(function(){
        $('#divrecoridos').removeClass('hidden');
        $('#recorrido').val($('#kmfinal').val()-$('#kminicio').val()+' Km recorridos');
    });


    //evento para radio buttons de los indicadores de los kilometrajes
    $('input[type=radio][name=filtros]').change(function(){
       if(this.value==='f1')
       {
           $('#kilometraje1').addClass('hidden');
           $('#kilometraje2').removeClass('hidden');
       }
       else if(this.value==='all')
       {
           $('#kilometraje1').removeClass('hidden');
           $('#kilometraje2').addClass('hidden');
       }
    });

    
    //evento para poder ver los registros ingresados de km
    $('#btn_verregistroskm').click(function ()
    {
        $('#btn_nuevoreporte').removeClass('hidden');
        $('#kmporvh').addClass('hidden');
        $('#kmingresado').addClass('hidden');

        var fecha = $('#fecha1').val();

        var d = fecha.substr(0,11);
        var h = fecha.substr(13,20);

        desde = d;
        hasta = h;

        $('#barra_progreso').removeClass('hidden');



       $.ajax({
           url:'kmingresadosbyfecha',
           datatype:'json',
           type:'post',
           data:{desde:d,hasta:h},
           success:function(data)
           {
               if(data)
               {
                   $('#filtrovh').removeClass('hidden');
                   $('#barra_progreso').fadeOut('slow');
                   $('#renderkmingresados').removeClass('hidden').append(data);
                   $('#btn_genearexcelkmingresados').removeClass('hidden');
               }
           }
       });
    });



    //evento excel para los km ingresados por fecha
    $('#btn_genearexcelkmingresados').click(function(){
       location.href = 'excel_kmingresadosbyfecha?desde='+desde+'&hasta='+hasta;
    });



    //evento para render de los km por vehiculo
    $('#btn_generarkmporvehiculo').click(function(){

        $('#btn_nuevoreporte').removeClass('hidden');
        $('#kmporvh').addClass('hidden');
        $('#kmingresado').addClass('hidden');

        var fecha = $('#fecha2').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(13,20);

        desde = d;
        hasta = h;

        $.ajax({
            url:'kilometrajevhdueños',
            datatype:'json',
            type:'post',
            data:{desde:d,hasta:h},
            success:function(data)
            {
                $('#filtrovh').removeClass('hidden');
                $('#barra_progreso').fadeOut('slow');
                $('#renderkmingresadosporvh').removeClass('hidden').append(data);
                $('#btn_generarexcelkmporvh').removeClass('hidden');
            }
        });
    });



    //evento para poder generar el excel de los km recorridos por vh
    $('#btn_generarexcelkmporvh').click(function(){
        location.href = 'excel_kmrecorridosporvh?desde='+desde+'&hasta='+hasta;
    });

});