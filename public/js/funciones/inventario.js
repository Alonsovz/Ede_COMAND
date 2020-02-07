$(document).ready(function(){

    //variables globales
    insumospapeleria = new Array();
    estados = new Array();
    insumoherramienta = new Array();
    insumoslimpieza = new Array();
    insumosoficina = new Array();

    codigosinsumos = new Array();
    bodegas = new Array();
    cantidades = new Array();
    centrocosto = new Array();

    var indice_estados = 0;
    var indice_cantidades = 0;
    var indice_bodegas = 0;
    var indice_codigos = 0;
    var indice_centrocosto = 0;



    //evento para mostrar el div correspondiente al inventario inicial
    $('#herramientas').click(function(){
       $('#divherramientas').removeClass('hidden');
       $('#divpapeleria').addClass('hidden');
       $('#divestados').removeClass('hidden');
        $('#divlimpieza').addClass('hidden');
        $('#divoficina').addClass('hidden');
    });


    //evento para mostrar el div correspondiente de herramientas de oficina
    $('#oficina').click(function(){
        $('#divherramientas').addClass('hidden');
        $('#divpapeleria').addClass('hidden');
        $('#divestados').removeClass('hidden');
        $('#divlimpieza').addClass('hidden');
        $('#divoficina').removeClass('hidden');
    });



    $('#papeleria').click(function(){
        $('#divherramientas').addClass('hidden');
        $('#divpapeleria').removeClass('hidden');
        $('#divlimpieza').addClass('hidden');
        $('#divoficina').addClass('hidden');
    });

    $('#limpieza').click(function(){
        $('#divlimpieza').removeClass('hidden');
        $('#divherramientas').addClass('hidden');
        $('#divpapeleria').addClass('hidden');
        $('#divoficina').addClass('hidden');
    });







    //evento para poder insertar una fila a la tabla de papeleria
    $('#btn_insertarfilapapeleria').click(function(){


        //obtenemos el codigo del insumo con el nombre del insumo
        $.getJSON('obteneridinsumo',{insumo:$('#insumo1').val()},function(data){
            $('#codinsumo1').val(data);

            fila = "<tr id="+$('#codinsumo1').val()+"><td class='vacia'></td><td class='codinsumo1'>"+$('#codinsumo1').val()+"</td><td class='insumo1'>"+$('#insumo1').val()+"</td>" +
                "<td class='vacia'></td><td class=''><input type='text' class='form-control cantidad1' value="+$('#cantidad1').val()+"></td>" +
                "<td><button  class='btn btn-danger btn-sm eliminarfila' id="+$('#codinsumo1').val()+"><i class='fa fa-trash' ></i></button></td></tr>";
            $('#tablainsumospapeleria tr:last').after(fila);
            document.getElementById('frm_insumospapeleria').reset();

            //evento para eliminar una fila al tener ingresado insumos
            $('.eliminarfila').click(function()
            {
                //establecemos a cero los contadores
                codigosinsumos.length = 0;
                cantidades.length = 0;
                indice_cantidades = 0;
                indice_codigos = 0;

                var id = this.id;
                $("#"+id+"").remove();
            });
        });


    });

    //evento para poder insertar una fila a la tabla de herramientas
    $('#btn_insertarfilaherramienta').click(function(){
        //obtenemos el codigo del insumo con el nombre del insumo
        $.getJSON('obteneridinsumo',{insumo:$('#insumo2').val()},function(data){
            $('#codinsumo').val(data);

            fila = "<tr id="+$('#codinsumo').val()+"><td class='estado'>"+$('#estadoherram option:selected').val()+"</td><td class='codinsumo'>"+$('#codinsumo').val()+"</td>" +
                "<td class='insumo'>"+$('#insumo2').val()+"</td><td class='bodega'>"+$('#bodega option:selected').text()+"</td>" +
                "<td class=''><input type='text' class='cantidad form-control' value="+$('#cantidad').val()+" ></td>" +
                "<td><button  class='btn btn-danger btn-sm eliminarfila' id="+$('#codinsumo').val()+"><i class='fa fa-trash' ></i></button></td></tr>";
            $('#tablainsumos tr:last').after(fila);
            document.getElementById('frm_insumosherramientas').reset();

            //evento para eliminar una fila al tener ingresado insumos
            $('.eliminarfila').click(function()
            {
                //establecemos a cero los contadores
                codigosinsumos.length = 0;
                cantidades.length = 0;
                indice_cantidades = 0;
                indice_codigos = 0;
                bodegas.length = 0;
                estados.length = 0;
                indice_bodegas = 0;
                indice_estados = 0;

                var id = this.id;
                $("#"+id+"").remove();
            });
        });


    });



    //insertar fila oficina
    $('#btn_insertarfilaoficina').click(function(){
        //obtenemos el codigo del insumo con el nombre del insumo
        $.getJSON('obteneridinsumo',{insumo:$('#insumo4').val()},function(data){
            $('#codinsumoof').val(data);

            fila = "<tr id="+$('#codinsumoof').val()+"><td class='estadoof'>"+$('#estadoherramof option:selected').val()+"</td><td class='codinsumoof'>"+$('#codinsumoof').val()+"</td>" +
                "<td class='insumoof'>"+$('#insumo4').val()+"</td><td class='centrocosto'>"+$('#centrocosto option:selected').text()+"</td>" +
                "<td class=''><input type='text' class='cantidadof form-control' value="+$('#cantidadof').val()+" ></td>" +
                "<td><button  class='btn btn-danger btn-sm eliminarfila' id="+$('#codinsumoof').val()+"><i class='fa fa-trash' ></i></button></td></tr>";
            $('#tablainsumosoficina tr:last').after(fila);
            document.getElementById('frm_oficina').reset();

            //evento para eliminar una fila al tener ingresado insumos
            $('.eliminarfila').click(function()
            {
                //establecemos a cero los contadores
                codigosinsumos.length = 0;
                cantidades.length = 0;
                indice_cantidades = 0;
                indice_codigos = 0;
                centrocosto.length = 0;
                estados.length = 0;
                indice_bodegas = 0;
                indice_estados = 0;

                var id = this.id;
                $("#"+id+"").remove();
            });
        });


    });


    //evento para poder insertar una fila a la tabla de herramientas
    $('#btn_insertarfilalimpieza').click(function(){

        $.getJSON('obteneridinsumo',{insumo:$('#insumo3').val()},function(data){

            $('#codinsumo3').val(data);

            //creamos una variable para crear la nueva fila
            fila = "<tr id="+$('#codinsumo3').val()+"><td class='codinsumo3'>"+$('#codinsumo3').val()+"</td><td class='insumo3'>"+$('#insumo3').val()+"</td>" +
                "<td class='vacia'></td><td class=''><input type='text' class='form-control cantidad3' value="+$('#cantidad3').val()+"></td>" +
                "<td><button  class='btn btn-danger btn-sm eliminarfila' id="+$('#codinsumo3').val()+"><i class='fa fa-trash' ></i></button></td></tr>";
            $('#tablainsumoslimpieza tr:last').after(fila);

            //reset al frm de ingreso de insumos
            document.getElementById('frm_insumoslimpieza').reset();

            //evento para eliminar una fila al tener ingresado insumos
            $('.eliminarfila').click(function()
            {

                //establecemos a cero los contadores
                codigosinsumos.length = 0;
                cantidades.length = 0;
                indice_cantidades = 0;
                indice_codigos = 0;


                var id = this.id;
                $("#"+id+"").remove();
            });
        });


    });



    //evento para poder guardar el inventario inicial de papeleria
    $('#btn_guardarinventariopapeleria').click(function(){

        //almacenamos los codigos de productos
        $('.codinsumo1').each(function(){
            codigosinsumos[indice_codigos] = $(this).text();
            indice_codigos++;

        });

        //almacenar las cantidades en un array
        $('.cantidad1').each(function(){
            cantidades[indice_cantidades] = $(this).val();
            indice_cantidades++;
        });

        console.log(codigosinsumos);
        console.log(cantidades);

       $.ajax({
           url:'inv_inicial_pape',
           datatype:'json',
           type:'post',
           data:{cantidades:cantidades,insumos:codigosinsumos},
           success:function(data)
           {
                if(data===true)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Levantamiento de inventario exitosa!',
                        type:'success'
                    });
                    location.href = 'inventarioinicial'
                }
           }
       });
    });


    //evento para poder guardar el inventario inicial de papeleria
    $('#btn_guardarinventarioherram').click(function(){
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

        //almacenar estados de las herramientas
        $('.estado').each(function(){
           estados[indice_estados] = $(this).text();
           indice_estados++;
        });


        //almacenamos las bodegas
        $('.bodega').each(function(){
           bodegas[indice_bodegas] = $(this).text();
           indice_bodegas++;
        });





        $.ajax({
            url:'inv_inicial_herram',
            datatype:'json',
            type:'post',
            data:{estados:estados,cantidades:cantidades,insumos:codigosinsumos,bodegas:bodegas},
            success:function(data)
            {
                if(data===true)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Levantamiento de inventario exitosa!',
                        type:'success'
                    });
                    location.href = 'inventarioinicial'
                }
            }
        });
    });



    //evento para guardar los insumos de limpieza
    $('#btn_guardarlimpieza').click(function(){
        $('.codinsumo3').each(function(){
            codigosinsumos[indice_codigos] = $(this).text();
            indice_codigos++;

        });

        //almacenar las cantidades en un array
        $('.cantidad3').each(function(){
            cantidades[indice_cantidades] = $(this).val();
            indice_cantidades++;
        });

        $.ajax({
            url:'inv_inicial_pape',
            datatype:'json',
            type:'post',
            data:{cantidades:cantidades,insumos:codigosinsumos},
            success:function(data)
            {
                if(data===true)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Levantamiento de inventario exitosa!',
                        type:'success'
                    });
                    location.href = 'inventarioinicial'
                }
            }
        });
    });







    //evento para poder guardar el inventario inicial de oficina
    $('#btn_guardarinvoficina').click(function(){
        //almacenamos los codigos de productos
        $('.codinsumoof').each(function(){
            codigosinsumos[indice_codigos] = $(this).text();
            indice_codigos++;

        });

        //almacenar las cantidades en un array
        $('.cantidadof').each(function(){
            cantidades[indice_cantidades] = $(this).val();
            indice_cantidades++;
        });

        //almacenar estados de las herramientas
        $('.estadoof').each(function(){
            estados[indice_estados] = $(this).text();
            indice_estados++;
        });


        //almacenamos las bodegas
        $('.centrocosto').each(function(){
            centrocosto[indice_centrocosto] = $(this).text();
            indice_centrocosto++;
        });





        $.ajax({
            url:'inv_inicial_oficina',
            datatype:'json',
            type:'post',
            data:{estados:estados,cantidades:cantidades,insumos:codigosinsumos,cc:centrocosto},
            success:function(data)
            {
                if(data===true)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Levantamiento de inventario exitosa!',
                        type:'success'
                    });
                    location.href = 'inventarioinicial'
                }
            }
        });
    });




    //insumos de tipo papeleria
    $.getJSON('obtenerinsumos',{tiporeq:1},function(data){
        for(var i=0;i<=data.length;i++)
        {
            insumospapeleria[i] = data[i].nombre;
        }
    });



    //insumos de tipo herramienta
    $.getJSON('obtenerinsumos',{tiporeq:2},function(data){
        for(var i=0;i<=data.length;i++)
        {
            insumoherramienta[i] = data[i].nombre;
        }

    });


    //insumos de tipo herramienta
    $.getJSON('obtenerinsumos',{tiporeq:3},function(data){
        for(var i=0;i<=data.length;i++)
        {
            insumoslimpieza[i] = data[i].nombre;
        }

    });

    //insumos de tipo oficina
    $.getJSON('obtenerinsumos',{tiporeq:4},function(data){
        for(var i=0;i<=data.length;i++)
        {
            insumosoficina[i] = data[i].nombre;
        }

    });




    //evento para guardar un insumo nuevo
    $('#btn_guardarinsumo1').click(function(){
        $.ajax({
            url:'guardarinsumo',
            datatype:'json',
            type:'post',
            data:{insumo:$('#nombreinsumo').val(),descripcion:$('#descripcioninsumo').val(),
                precio:$('#precioinsumo').val(),
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
                    $('#insumo3').val($('#nombreinsumo').val());
                    $('#insumo1').val($('#nombreinsumo').val());
                    $('#insumo2').val($('#nombreinsumo').val());

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



    $('#the-basicsherramientas .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'insumoherramienta',
            source: substringMatcher(insumoherramienta)
        });






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



    $('#the-basicspapeleria .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'insumospapeleria',
            source: substringMatcher1(insumospapeleria)
        });



    var substringMatcher3 = function(strs) {
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



    $('#the-basicslimpieza .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'insumoslimpieza',
            source: substringMatcher3(insumoslimpieza)
        });










    var substringMatcher4 = function(strs) {
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



    $('#the-basicsoficina .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'insumosoficina',
            source: substringMatcher4(insumosoficina)
        });



});


//evento para insumo de papeleria
$('#insumo1').change(function(){
    $.getJSON('obtenerinsumo',{insumo:$('#insumo1').val()},function(data) {

        $.each(data,function(index){
           $('#unidadpape').val(data[index].um);

        });

    });
});

//evento para insumo de limpieza UM
$('#insumo3').change(function(){
    $.getJSON('obtenerinsumo',{insumo:$('#insumo3').val()},function(data) {

        $.each(data,function(index){
            $('#unidadlimpieza').val(data[index].um);

        });

    });
});

//evento para insumo de elect UM
$('#insumo2').change(function(){
    $.getJSON('obtenerinsumo',{insumo:$('#insumo2').val()},function(data) {

        $.each(data,function(index){
            $('#unidadelec').val(data[index].um);

        });

    });
});