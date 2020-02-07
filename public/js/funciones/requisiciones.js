


$(document).ready(function(){



    //variables globales
    var insumos = new Array();
    var insumosingresados = new Array();
    var cantidades = new Array();
    var codigosinsumos = new Array();
    var indice_insumos = 0;
    var indice_cantidades = 0;
    var indice_codigos = 0;
    var descripciones = new Array();
    var indice_descripciones = 0;

    var precios = new Array();
    var indice_precios = 0;



    //evento para actualizar
    $('#actualizarpagina').click(function(){
       location.reload();
    });



    //evento para poder mostrar el formulario de nueva requisicion
    $('#btn_seleccionartipo').click(function(){

       if($('#tiporequisicion option:selected').val()==0)
       {
           new PNotify({
               title:'Atencion',
               text:'Por favor seleccionar un tipo de requisicion',
               type:'warning'
           });
       }
       //papeleria
       else if($('#tiporequisicion option:selected').val()==1)
       {
           $('#divrequisicion').slideDown('fast').removeClass('hidden');
           $('#btn_ingresarinsumos').addClass('hidden');
           $('#btn_enviarrequisicionpape').removeClass('hidden');
           //evento para cargar los insumos
           $.getJSON('obtenerinsumos',{tiporeq:1},function(data){
               for(var i=0;i<=data.length;i++)
               {
                   insumos[i] = data[i].nombre;
               }

           });

           $('#btn_cerrarmodaltiporeq').click();

       }
       //herramientas
       else if($('#tiporequisicion option:selected').val()==2)
       {

           $('#divrequisicion').slideDown('fast').removeClass('hidden');
           $('#btn_enviarrequisicionherram').removeClass('hidden');
           $('#btn_enviarrequisicionpape').addClass('hidden');

           //evento para cargar los insumos
           $.getJSON('obtenerinsumos',{tiporeq:2},function(data){
               for(var i=0;i<=data.length;i++)
               {
                   insumos[i] = data[i].nombre;
               }

           });

           $('#btn_cerrarmodaltiporeq').click();

       }
       else if($('#tiporequisicion option:selected').val()==3)
       {

           $('#divrequisicion').slideDown('fast').removeClass('hidden');
           $('#btn_enviarrequisicionherram').addClass('hidden');
           $('#btn_enviarrequisicionpape').addClass('hidden');
           $('#btn_enviarrequisicionlimp').removeClass('hidden');

           //evento para cargar los insumos
           $.getJSON('obtenerinsumos',{tiporeq:3},function(data){
               for(var i=0;i<=data.length;i++)
               {
                   insumos[i] = data[i].nombre;
               }

           });

           $('#btn_cerrarmodaltiporeq').click();

       }
       else if($('#tiporequisicion option:selected').val()==4)
       {
           $('#divrequisicion').slideDown('fast').removeClass('hidden');
           $('#btn_enviarrequisicionherram').addClass('hidden');
           $('#btn_enviarrequisicionpape').addClass('hidden');
           $('#btn_enviarrequisicionlimp').addClass('hidden');
           $('#btn_enviarrequisicionoficina').removeClass('hidden');



           //evento para cargar los insumos
           $.getJSON('obtenerinsumos',{tiporeq:4},function(data){
               for(var i=0;i<=data.length;i++)
               {
                   insumos[i] = data[i].nombre;
               }

           });

           $('#btn_cerrarmodaltiporeq').click();
       }
    });



    $('#btn_ingresarinsumos').click(function(){
       $('.ibox-footer').removeClass('hidden').slideDown('slow');
       $('#btn_ingresarinsumos').addClass('hidden');
    });





    //evento para poder detectar si el insumo que se quiere comprar existe con un estado en buena condicion
    /*$('#insumo').change(function(){
        $('#alertaestado').html("");

       $.ajax({
           url:'estadosinsumos',
           datatype:'json',
           data:{insumo:$('#insumo').val()},
           success:function(data){
               if(data)
               {

                   $('#btn_insertarfila').addClass('hidden');
                   $('#alertaestado').removeClass('hidden').append(data);

               }
               else
               {
                   $('#alertaestado').addClass('hidden');
                   $('#btn_insertarfila').removeClass('hidden');

               }
           }
       });
    });*/










    //insertar la fila
    $('#btn_insertarfila').click(function(){



        //obtenemos el codigo del insumo con el nombre del insumo
        $.getJSON('obteneridinsumo',{insumo:$('#insumo').val()},function(data){

            var fila = '';

            if($('#insumo').val()==="" || $('#cantidad').val()==="")
            {
                new PNotify({
                    title:'Atencion!',
                    text: 'No se permiten campos vacios para la insercion de un insumo',
                    type:'warning'
                });
            }
            else
            {
                fila = "<tr id="+data+"><td class='vacia'></td><td class='codinsumo'>"+data+"</td><td class='insumo'>"+$('#insumo').val()+"</td>" +
                    "<td class='desc'>"+$('#descins').val()+"<td><input class='form-control input cantidad' type='text' readonly='true' value="+$('#cantidad').val()+"></td>" +
                    "<td><input class='form-control input precio' type='text' readonly='true' value="+$('#precioini').val()+"></td>" +
                    "<td class='accion'>" +
                    "<button type='button' class='btn btn-xs btn-danger eliminarfila' id="+data+"><i class='fa fa-trash'></i></button></td></tr>";
                $('#tablainsumos tr:last').after(fila);
                document.getElementById('frm_insumos').reset();
            }


            //evento para eliminar una fila al tener ingresado insumos
            $('.eliminarfila').click(function()
            {
                var id = this.id;
                $("#"+id+"").remove();
            });

            //evento para editar un insumo seleccionado
            $('#btn_edicion').click(function(){
                $('.input').removeAttr('readonly');
            });
        });




    });




    //almacenamos los insumos digitados y las cantidades en sus respectivos array
    $('#btn_cerrarmodalinsumos').click(function(){



    });



    //evento para generar una requisicion de tipo herramientas
    $('#btn_enviarrequisicionherram').click(function(){

        $('#barra_progreso').removeClass('hidden');
        $('#btn_enviarrequisicionherram').addClass('hidden');

        //capturamos los datos que se enviararn en la requisicion
        //almacenamos los codigos de productos
        $('.codinsumo').each(function(){
            codigosinsumos[indice_codigos] = $(this).text();
            indice_codigos++;

        });

        //almacenar las cantidades en un array
        $('.cantidad').each(function(){
            cantidades[indice_cantidades] = $(this).val();
            indice_cantidades++;
        });

        //descripciones
        $('.desc').each(function(){
            descripciones[indice_descripciones] = $(this).text();
            indice_descripciones++;
        });

        console.log(codigosinsumos);
        console.log(cantidades);

        if(codigosinsumos.length===0 || cantidades.length===0)
        {
            new PNotify({
                title:'Atencion',
                text:'no se puede ingresar una requisicon vacia',
                type:'warning'
            });
        }
        else
        {
            //por medio de la llamada ajax vamos a guardar la requisicion para luego almacenar sus detalles de insumos
            $.getJSON('saverequisicion',{descripciones:descripciones,requisicion:2,insumos:codigosinsumos,cantidades:cantidades,solicitante:$('#solicitante').val(),
                justificacion:$('#justificacion').val()}
                ,function(data){

                if(data===true)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Requisicion ingresada con exito!',
                        type:'success'
                    });

                    location.href = 'nuevarequisicion';



                    //borramos datos de la tabla ingresados
                    $('.insumo').remove();
                    $('.cantidad').remove();
                    $('.vacia').remove();
                    $('.codinsumo').remove();
                    $('.accion').remove();
                    $('.descripcion').remove();
                    indice_insumos = 0;
                    indice_cantidades= 0;
                    $('#justificacion').val("");

                    //establecemos los arreglos vacios
                    codigosinsumos.length = 0;
                    insumosingresados.length = 0;
                    cantidades.length = 0;
                    console.log(insumosingresados);
                    console.log(cantidades);
                }
                else
                {
                    new PNotify({
                        title:'Error!',
                        text:'Ocurrio un error en el ingreso de la requisicion',
                        type:'error'
                    });

                    $('#btn_enviarrequisicionherram').removeClass('hidden');
                    $('#barra_progreso').addClass('hidden');
                }
            });
        }




    });





    //evento para enviar requisicion de papeleria
    $('#btn_enviarrequisicionpape').click(function(){

        $('#barra_progreso').removeClass('hidden');
        $('#btn_enviarrequisicionpape').addClass('hidden');

        //capturamos los datos que se enviararn en la requisicion
        //almacenamos los codigos de productos
        $('.codinsumo').each(function(){
            codigosinsumos[indice_codigos] = $(this).text();
            indice_codigos++;

        });

        $('.precio').each(function(){
                    precios[indice_precios] = $(this).val();
                    indice_precios++;

                });

        //almacenar las cantidades en un array
        $('.cantidad').each(function(){
            cantidades[indice_cantidades] = $(this).val();
            indice_cantidades++;
        });

        console.log(codigosinsumos);
        console.log(cantidades);

        if(codigosinsumos.length===0 || cantidades.length===0)
        {
            new PNotify({
                title:'Atencion',
                text:'no se puede ingresar una requisicon vacia',
                type:'warning'
            });
        }
        else
        {
            //por medio de la llamada ajax vamos a guardar la requisicion para luego almacenar sus detalles de insumos
            $.getJSON('saverequisicion',{precios:precios,requisicion:1,insumos:codigosinsumos,cantidades:cantidades,solicitante:$('#solicitante').val(),
                    justificacion:$('#justificacion').val()}
                ,function(data){

                    if(data===true)
                    {
                        new PNotify({
                            title:'muy bien!',
                            text:'Requisicion ingresada con exito!',
                            type:'success'
                        });

                        location.href = 'nuevarequisicion';
                        $('#btn_enviarrequisicion').addClass('hidden');
                        $('#imprimirhojactivo').removeClass('hidden');


                        //borramos datos de la tabla ingresados
                        $('.insumo').remove();
                        $('.cantidad').remove();
                        $('.vacia').remove();
                        $('.codinsumo').remove();
                        $('.accion').remove();
                        indice_insumos = 0;
                        indice_cantidades= 0;
                        $('#justificacion').val("");

                        //establecemos los arreglos vacios
                        codigosinsumos.length = 0;
                        insumosingresados.length = 0;
                        cantidades.length = 0;
                        console.log(insumosingresados);
                        console.log(cantidades);
                    }
                    else
                    {
                        $('#barra_progreso').addClass('hidden');
                        $('#btn_enviarrequisicionpape').removeClass('hidden');

                        new PNotify({
                            title:'Error!',
                            text:'Ocurrio un error en el ingreso de la requisicion',
                            type:'error'
                        });
                    }
                });
        }




    });




    //enviar una requisicion de limpieza
    //evento para generar una requisicion de tipo herramientas
    $('#btn_enviarrequisicionlimp').click(function(){

        $('#barra_progreso').removeClass('hidden');
        $('#btn_enviarrequisicionlimp').addClass('hidden');

        //capturamos los datos que se enviararn en la requisicion
        //almacenamos los codigos de productos
        $('.codinsumo').each(function(){
            codigosinsumos[indice_codigos] = $(this).text();
            indice_codigos++;

        });

        $('.precio').each(function(){
            precios[indice_precios] = $(this).val();
            indice_precios++;

        });

        //almacenar las cantidades en un array
        $('.cantidad').each(function(){
            cantidades[indice_cantidades] = $(this).val();
            indice_cantidades++;
        });

        console.log(codigosinsumos);
        console.log(cantidades);

        if(codigosinsumos.length===0 || cantidades.length===0)
        {
            new PNotify({
                title:'Atencion',
                text:'no se puede ingresar una requisicon vacia',
                type:'warning'
            });
        }
        else
        {
            //por medio de la llamada ajax vamos a guardar la requisicion para luego almacenar sus detalles de insumos
            $.getJSON('saverequisicion',{precios:precios,requisicion:3,insumos:codigosinsumos,cantidades:cantidades,solicitante:$('#solicitante').val(),
                    justificacion:$('#justificacion').val()}
                ,function(data){

                    if(data===true)
                    {
                        new PNotify({
                            title:'muy bien!',
                            text:'Requisicion ingresada con exito!',
                            type:'success'
                        });

                        location.href = 'nuevarequisicion';



                        //borramos datos de la tabla ingresados
                        $('.insumo').remove();
                        $('.cantidad').remove();
                        $('.vacia').remove();
                        $('.codinsumo').remove();
                        $('.accion').remove();
                        indice_insumos = 0;
                        indice_cantidades= 0;
                        $('#justificacion').val("");

                        //establecemos los arreglos vacios
                        codigosinsumos.length = 0;
                        insumosingresados.length = 0;
                        cantidades.length = 0;
                        console.log(insumosingresados);
                        console.log(cantidades);
                    }
                    else
                    {
                        $('#barra_progreso').addClass('hidden');
                        $('#btn_enviarrequisicionlimp').removeClass('hidden');

                        new PNotify({
                            title:'Error!',
                            text:'Ocurrio un error en el ingreso de la requisicion',
                            type:'error'
                        });
                    }
                });
        }




    });





    //evento para requisicion de oficina
    $('#btn_enviarrequisicionoficina').click(function(){

        $('#barra_progreso').removeClass('hidden');
        $('#btn_enviarrequisicionoficina').addClass('hidden');

        //capturamos los datos que se enviararn en la requisicion
        //almacenamos los codigos de productos
        $('.codinsumo').each(function(){
            codigosinsumos[indice_codigos] = $(this).text();
            indice_codigos++;

        });

        //almacenar las cantidades en un array
        $('.cantidad').each(function(){
            cantidades[indice_cantidades] = $(this).val();
            indice_cantidades++;
        });

        console.log(codigosinsumos);
        console.log(cantidades);

        if(codigosinsumos.length===0 || cantidades.length===0)
        {
            new PNotify({
                title:'Atencion',
                text:'no se puede ingresar una requisicon vacia',
                type:'warning'
            });
        }
        else
        {
            //por medio de la llamada ajax vamos a guardar la requisicion para luego almacenar sus detalles de insumos
            $.getJSON('saverequisicion',{requisicion:4,insumos:codigosinsumos,cantidades:cantidades,solicitante:$('#solicitante').val(),
                    justificacion:$('#justificacion').val()}
                ,function(data){

                    if(data===true)
                    {
                        new PNotify({
                            title:'muy bien!',
                            text:'Requisicion ingresada con exito!',
                            type:'success'
                        });

                        location.href = 'nuevarequisicion';
                        $('#btn_enviarrequisicion').addClass('hidden');
                        $('#imprimirhojactivo').removeClass('hidden');


                        //borramos datos de la tabla ingresados
                        $('.insumo').remove();
                        $('.cantidad').remove();
                        $('.vacia').remove();
                        $('.codinsumo').remove();
                        $('.accion').remove();
                        indice_insumos = 0;
                        indice_cantidades= 0;
                        $('#justificacion').val("");

                        //establecemos los arreglos vacios
                        codigosinsumos.length = 0;
                        insumosingresados.length = 0;
                        cantidades.length = 0;
                        console.log(insumosingresados);
                        console.log(cantidades);
                    }
                    else
                    {
                        $('#barra_progreso').addClass('hidden');
                        $('#btn_enviarrequisicionoficina').removeClass('hidden');

                        new PNotify({
                            title:'Error!',
                            text:'Ocurrio un error en el ingreso de la requisicion',
                            type:'error'
                        });
                    }
                });
        }




    });






    //evento para los detalles de las requisiciones
    $('.btn_detallesrequisicion').click(function(){
        var id = this.id;
       $.ajax({
           url:'verdetallesrequisicion',
           datatype:'html',
           type:'post',
           data:{idrequisicion:id},
           success:function(data)
           {
               $('#divbandeja').slideUp('fast');

               $('#divdetalles').append(data).removeClass('hidden');
           }
       });
    });




    //evento para eliminar un insumo de la tabla de la orden de compra
    $('.btn_eliminarinsumo').click(function(){
        var id = this.id;
        $("#"+id+"").remove();
    });





    //evento para refrescar la pagina cuando se haya generado el PDF de la hoja de activo
    $('#imprimirhojactivo').click(function ()
    {
       setTimeout(function(){location.href = 'dashboard';},3000);
    });



    //evento para listar la unidad de medida

    $('#insumo').change(function(){
        $.getJSON('obtenerinsumo',{insumo:$('#insumo').val()},function(data) {

            $.each(data,function(index){
                $('#unidad').val(data[index].um);

            });

        });
    });



    //evento para guardar un insumo nuevo
    $('#btn_guardarinsumo').click(function(){
        $.ajax({
            url:'guardarinsumo',
            datatype:'json',
            type:'post',
            data:{insumo:$('#nombreinsumo').val(),descripcion:$('#descripcioninsumo').val(),precio:$('#precioinsumo').val(),
            categoria:$('#categoriainsumo option:selected').val()},
            success:function(data)
            {
                if(data===true)
                {
                    new PNotify({
                        title:'muy bien',
                        text:'Insumo guardado con exito!',
                        type:'success'
                    });

                    //establecemos el insumo nuevo ingresado en el campo del insumo a insertar
                    $('#insumo').val($('#nombreinsumo').val());
                }
                else
                {
                    new PNotify({
                        title:'oh no',
                        text:'Ocurrio un error mientras se guardaba la informacion del insumo!',
                        type:'error'
                    });
                }
            }
        });
    });



    //evento para cancelar una requisicion
    $('.btn_eliminarrequisicion').click(function(){
       var id = this.id;

       $.getJSON('eliminarrequisicion',{id:id},function(data){
          if(data>=1)
          {
              new PNotify({
                  title:'muy bien',
                  text:'Requisicion cancelada',
                  type:'success'
              });

              location.href= 'rq_bandejasuperv';
          }
       });
    });




    //evento para listar los insumos en el input del formulario
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


    //evento para nuevo insumo borra los insumos del array para sobreescribirlos si se quiere agregar mas
    $('#btn_nuevoinsumo').click(function(){

        cantidades.length = 0;
        codigosinsumos.length = 0;
        insumosingresados.length = 0;
        indice_insumos = 0;
        indice_cantidades = 0;
        indice_codigos = 0;

    });




    $('#the-basics .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'insumos',
            source: substringMatcher(insumos)
        });




});

