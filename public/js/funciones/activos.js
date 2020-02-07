$(document).ready(function(){

    var listadoactivos = new Array();

   // $('.navbar-minimalize').click();

    //variable global de empleados
    var empleados = new Array();

    //validacion con mascara para el campo de edicion de la fecha
    $('#fecha').mask('00/00/0000');
    $('#n_fecha').mask('00/00/0000');

    //enviar SI a la validacion de los activos asignados
    $('#btn_enviarvalidacion').click(function(){
        $('#btn_enviarvalidacion').addClass('hidden');
        $.getJSON('validacionactivo_positiva',{},function(data){
          if(data===true)
          {
              new PNotify({
                  title:'muy bien!',
                  text:'Validacion enviada exitosamente',
                  type:'success'
              });

              location.reload();
          }
       });
    });


    //enviar validacion NEGATIVA de los activos asignados

    $('#btn_enviarnovalidacion').click(function(){
        if($('#comentario').val()=='')
        {
            new PNotify({
                title:'Verificar!',
                text:'No se permiten campos vacios, favor rellenarlos',
                type:'warning'
            });
        }
        else
        {
            $('#btn_enviarnovalidacion').addClass('hidden');
            $.getJSON('validacionactivo_negativa',{comentario:$('#comentario').val()},function(data){
                if(data===true)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Validacion enviada exitosamente',
                        type:'success'
                    });

                    location.reload();
                }
            });
        }

    });



    //evento para listar los activos a elminar de un empleado
    $('#btn_eliminaractivos').click(function(){
        var array = new Array();
        var i = 0;
        $('input:checkbox:checked').each(function(){
            array[i] = $(this).val();
            i++;
        });
        console.log(array);
        $.ajax({
            url:'eliminaractivos_emp',
            datatype:'json',
            type:'post',
            data:{activos:array},
            success:function(data)
            {
                if(data===true)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Activos eliminados con exito',
                        type:'success'
                    });

                    location.reload();
                }
                else
                {
                    new PNotify({
                        title:'Error!',
                        text:'Ocurrio un error en el proceso de eliminacion',
                        type:'error'
                    });
                }
            }
        });
    });


    //evento para editar un activo
    $('#tbl_activosemp').on('click','.edicion',function(){
       var id = this.id;
       $.getJSON('findactivobyid',{id:id},function(data){


                if(data['nombre'])
                {
                    $('#empleado').val(data['nombre']+' '+data['apellido']);
                }else
                {
                    $('#empleado').val("Activo asignado a vehiculo").attr('readonly');
                }

                $('#activo').val(data['tipo_activo']);
                $('#marca').val(data['marca']);
                $('#modelo').val(data['modelo']);
                $('#color').val(data['color']);
                $('#id').val(data['id']);
                if(data['fecha_compra'])
                {
                    $('#fecha').val(moment(data['fecha_compra']).format('DD/MM/YYYY'));
                }
                else
                {
                    $('#fecha').val('');
                }
                $('#ccf').val(data['ccf']);
                $('#proveedor').val(data['proveedor']);
                $('#valor').val(data['valor']);
                $('#areainversion').val(data['area_inversion']);
                if(data['ubicacion'])
                {
                    $('#ubicacion').val(data['ubicacion']);
                }
                else
                {
                    $('#ubicacion').val('Oficina');
                }

                if(data['bodega_id'])
                {
                    var opcion = "<option selected='selected' value="+data['bodega_id']+">"+data['bodega']+"</option>";
                    $("#bodega").append(opcion);
                }

               if(data['finalidad'])
               {
                   var finalidad = "<option selected='selected' value="+data['finalidad']+">"+data['finalidad']+"</option>";
                   $("#finalidad").append(finalidad);
               }






       });
    });


    //ver informacion de un activo para generar la hoja de activo desde las bodegas
    $('.tablamovimientos').on('click','.verinfoactivo',function(){
        $.getJSON('findactivobyid',{id:this.id},function(data){


            if(data['nombre'])
            {
                $('#empleado').val(data['nombre']+' '+data['apellido']);
            }else
            {
                $('#empleado').val("Activo asignado a vehiculo").attr('readonly');
            }

            $('#activo1').val(data['tipo_activo']);

            $('#marca1').val(data['marca']);
            $('#modelo1').val(data['modelo']);
            $('#color1').val(data['color']);
            $('#id').val(data['id']);
            if(data['fecha_compra'])
            {
                $('#fechacompra1').val(moment(data['fecha_compra']).format('DD/MM/YYYY'));
            }
            else
            {
                $('#fechacompra1').val('');
            }
            $('#ccf1').val(data['ccf']);
            $('#proveedor1').val(data['proveedor']);
            $('#precio1').val(data['valor']);
            $('#areainversion1').val(data['area_inversion']);
            if(data['ubicacion'])
            {
                $('#ubicacion1').val(data['ubicacion']);
            }
            else
            {
                $('#ubicacion1').val('Oficina');
            }

            if(data['bodega_id'])
            {
                var opcion = "<option selected='selected' value="+data['bodega_id']+">"+data['bodega']+"</option>";
                $("#bodega1").append(opcion);
            }

            if(data['finalidad'])
            {
                var finalidad = "<option selected='selected' value="+data['finalidad']+">"+data['finalidad']+"</option>";
                $("#finalidad1").append(finalidad);
            }

            var fila = "<option selected='selected' value="+data['centro_costo']+">"+data['centrocosto']+"</option>";
            $("#ccostos").append(fila);





        });
    });

    //evento para guardar la informacion
    $('#btn_guardaredicion').click(function(){
        var datos = $('#frm_edicionactivo').serialize();
       $.ajax({
           url:'guardaredicionactivo',
           datatype:'json',
           type:'post',
           data:datos,
           success:function(data)
           {
                if(data===true)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Activos editado con exito',
                        type:'success'
                    });

                    document.getElementById('frm_edicionactivo').reset();
                    location.href = 'indexsuperactivos';
                }
                else
                {
                    new PNotify({
                        title:'Error!',
                        text:'Ocurrio un error al editar el activo',
                        type:'error'
                    });
                }
           }
       }) ;
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


    //GET EMPLEADOS
    $('#the-basics .typeahead').typeahead({
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


    //evento para guardar un nuevo activo para un empleado
    $('#btn_guardaractivo').click(function(){
        var datos = $('#frm_nuevoactivo').serialize();
       $.ajax({
           url:'guardarnuevoactivo',
           datatype:'json',
           type:'post',
           data:datos,
           success:function(data)
           {
                if(data===true)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Nuevo activo asignado con exito',
                        type:'success'
                    });

                    document.getElementById('frm_nuevoactivo').reset();
                    location.reload();
                }

           },error: function()
           {
               new PNotify({
                   title:'Error!',
                   text:'Ocurrio un error en la creacion',
                   type:'error'
               });
           }
       }) ;
    });

    //evento para generar un reporte de activos por empleado
    $('#btn_generarActXEmple').click(function(){
        var formato = $('input:radio[name=formatoactxempleado]:checked').val();
       location.href='rpt_activoxempleado?empleado='+$('#rpt_empleado').val()+'&&formato='+formato;
    });



    //generar sabana de activos en general
    $('#btn_generarsabana').click(function(){
        var formato = $('input:radio[name=formatoactxempleado]:checked').val();
        location.href='rpt_sabanaactivos?formato='+formato;
    });


    //buscar los insumos en la tabla emp_activos para  listarle al usuario un autocomplete
    $.getJSON('obtenerinsumosall',{},function(data){
        for(var i=0; i<=data.length-1; i++)
        {
            listadoactivos[i] = data[i].nombre;
        }

        console.log(listadoactivos);
    });



    var substringMatcher2 = function(strs) {
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

    $('#the-basics1 .typeahead1').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'listadoactivos',
            source: substringMatcher2(listadoactivos)
        });




    //VALIDACION DEL FORMULARIO DE LA HOJA DE ACTIVO
    $('#frm_adqactivo').validate({
        rules:{
            insumo:{
                required : true
            },
            categoria:{
                required:true
            },
            bodega:{
                required:true
            },
            empleado:{
                required:true
            },
            deptoedesal:{
                required:true
            },
            estado:{
                required:true
            },
            cantidad:{
                required:true
            },

            cc:{
                required:true
            },
            agencia:{
                required:true
            },

            departamento:{
                required:true
            },
            municipio:{
                required:true
            },
            justificacion:{
                required:true,
                minlength:50
            },
            estadoinsumo:{
                required:true
            },
            proveedor:{
                required:true
            },
            ccf:{
                required:true
            },
            fechacompra:{
                required:true
            },
            finalidad:{
                required:true
            }

        }
    });

    $('#frm_adqactivo1').validate({
        rules:{
            insumo1:{
                required : true
            },
            empleado1:{
                required:true
            },
            cantidad1:{
                required:true
            },

            cc1:{
                required:true
            },
            agencia1:{
                required:true
            },

            departamento1:{
                required:true
            },
            municipio1:{
                required:true
            },
            justificacion1:{
                required:true,
                minlength:50
            },
            estadoinsumo1:{
                required:true
            },
            proveedor1:{
                required:true
            },
            ccf1:{
                required:true
            },
            fechacompra1:{
                required:true
            }

        }
    });


    //validacion para hoja de activo de area tecnica
    $('#frm_adqactivo2').validate({
        rules:{
            insumo2:{
                required : true
            },
            empleado2:{
                required:true
            },
            cantidad2:{
                required:true
            },

            cc2:{
                required:true
            },
            agencia2:{
                required:true
            },

            departamento2:{
                required:true
            },
            municipio2:{
                required:true
            },
            justificacion2:{
                required:true,
                minlength:25
            },
            estadoinsumo2:{
                required:true
            },
            proveedor2:{
                required:true
            },
            ccf2:{
                required:true
            },
            fechacompra2:{
                required:true
            }

        }
    });



    //Verificar la validacion del formulario para una nueva hoja de activo
    $('#frm_adqactivo').on('submit',function(e){
        var isvalid = $("#frm_adqactivo").valid();

        //serializar el formulario
        var datos = $('#frm_adqactivo').serialize();

        if(isvalid)
        {
            $('.btn_generarhojaactivo').addClass('hidden');
            e.preventDefault();
            $.ajax({
                url:'saveactivowithhoja',
                datatype:'json',
                type:'post',
                data: datos,
                success:function(data)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Nuevo activo generado con exito',
                        type:'success'

                    });

                    location.href = 'generarHojaActivo?id='+data;

                },error:function()
                {
                    $('.btn_generarhojaactivo').removeClass('hidden');
                    new PNotify({
                       title:'error',
                        text:'Error al intentar adicionar un nuevo activo',
                        type:'error'
                    });
                }
            });

        }
        else
        {

        }
    });


    $('#frm_adqactivo1').on('submit',function(e){
        var isvalid = $("#frm_adqactivo1").valid();

        //serializar el formulario
        var datos = $('#frm_adqactivo1').serialize();

        if(isvalid)
        {
            //$('.btn_generarhojaactivo1').addClass('hidden');
            e.preventDefault();
            $.ajax({
                url:'saveactivowithhojabodega',
                datatype:'json',
                type:'post',
                data: datos,
                success:function(data)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Nuevo activo generado con exito',
                        type:'success'

                    });

                    location.href = 'generarHojaActivo?id='+data;

                },error:function()
                {
                    $('.btn_generarhojaactivo').removeClass('hidden');
                    new PNotify({
                        title:'error',
                        text:'Error al intentar adicionar un nuevo activo',
                        type:'error'
                    });
                }
            });

        }
        else
        {

        }
    });


    //generar hoja de activo para area tecnica
    $('#frm_adqactivo2').on('submit',function(e){
        var isvalid = $("#frm_adqactivo2").valid();

        //serializar el formulario
        var datos = $('#frm_adqactivo2').serialize();

        if(isvalid)
        {
            $('.btn_generarhojaactivo2').addClass('hidden');
            e.preventDefault();
            $.ajax({
                url:'hojaactivoareatecnica',
                datatype:'json',
                type:'post',
                data: datos,
                success:function(data)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Nuevo activo generado con exito',
                        type:'success'

                    });

                    location.href = 'generarHojaActivo?id='+data;

                },error:function()
                {
                    $('.btn_generarhojaactivo').removeClass('hidden');
                    new PNotify({
                        title:'error',
                        text:'Error al intentar adicionar un nuevo activo',
                        type:'error'
                    });
                }
            });

        }
        else
        {

        }
    });

    //rellenar el select de los municipios segun
    $('#departamento').change(function(){

        $.getJSON('getmunicipiosbydpto',{departamento:$('#departamento option:selected').val()},function(data){

            $('#municipio').html("");


            //recorremos los municipios para almacenarlos en un arreglo y pasarlos al select de municipios
            var fila = '';
            $.each(data,function(index){
                fila +="<option value="+data[index].ID+" >"+data[index].MunName+"</option>"
            });

            $('#municipio').append(fila);

        });

    });


    //departamento nuevo
    $('#departamento1').change(function(){

        $.getJSON('getmunicipiosbydpto',{departamento:$('#departamento1 option:selected').val()},function(data){

            $('#municipio1').html("");


            //recorremos los municipios para almacenarlos en un arreglo y pasarlos al select de municipios
            var fila = '';
            $.each(data,function(index){
                fila +="<option value="+data[index].ID+" >"+data[index].MunName+"</option>"
            });

            $('#municipio1').append(fila);

        });

    });

    $('#departamento2').change(function(){

        $.getJSON('getmunicipiosbydpto',{departamento:$('#departamento2 option:selected').val()},function(data){

            $('#municipio2').html("");


            //recorremos los municipios para almacenarlos en un arreglo y pasarlos al select de municipios
            var fila = '';
            $.each(data,function(index){
                fila +="<option value="+data[index].ID+" >"+data[index].MunName+"</option>"
            });

            $('#municipio2').append(fila);

        });

    });


    $('#departamento_tr').change(function(){

        $.getJSON('getmunicipiosbydpto',{departamento:$('#departamento_tr option:selected').val()},function(data){


            $('#municipio_tr').html("");

            //recorremos los municipios para almacenarlos en un arreglo y pasarlos al select de municipios
            var fila = '';
            $.each(data,function(index){
                fila +="<option value="+data[index].ID+" >"+data[index].MunName+"</option>"
            });


            $('#municipio_tr').append(fila);
        });

    });



    //evento para traslado
    var activoglobal = "";
    $('#tbl_activos').on('click','.traslado',function()
    {
        activoglobal = this.id;
        console.log(activoglobal);

        //evento ajax para consultar el id seleccionado
        $.getJSON('findactivobyid',{id:activoglobal},function(data){
            for(var i in data)
            {
                $('#insumo_tr').val(data['id']+'-'+data['tipo_activo']);
                $('#marca_tr').val(data['marca']);
                $('#modelo_tr').val(data['modelo']);
                $('#color_tr').val(data['color']);
            }
        });
    });

    //evento para traslado desde las bodegas de los supervisores
    $('.tablamovimientos').on('click','.traslado',function()
    {
        activoglobal = this.id;
        console.log(activoglobal);

        //evento ajax para consultar el id seleccionado
        $.getJSON('findactivobyid',{id:activoglobal},function(data){
            for(var i in data)
            {
                $('#insumo_tr').val(data['id']+'-'+data['tipo_activo']);
                $('#marca_tr').val(data['marca']);
                $('#modelo_tr').val(data['modelo']);
                $('#color_tr').val(data['color']);
            }
        });
    });


    //evento change para la categoria de activo
    $('#categoria').change(function(){
       if($('#categoria option:selected').val()==2)
       {
           $('#divcategoria').removeClass('hidden');
       }
    });


    //VALIDACION DEL FORMULARIO DE TRASLADO
    $('#frm_traslado').validate({
        rules:{

            tipotraslado:{
              required:true
            },



            empleado_tr:{
                required:true
            },

            cc_tr:{
                required:true
            },
            agencia_tr:{
                required:true
            },

            departamento_tr:{
                required:true
            },
            municipio_tr:{
                required:true
            },
            observaciones_tr:{
                required:true,
                minlength:50
            }

        }
    });


    $('#frm_traslado').on('submit',function(e){
        var isvalid = $('#frm_traslado').valid();

        if(isvalid)
        {
            $('#btn_generartraslado').addClass('hidden');
            e.preventDefault();
            console.log('validado');

            //datos
            var datos = $('#frm_traslado').serialize();

            //guardar el traslado en la db
            $.ajax({
                url:'generartraslado',
                datatype:'json',
                type:'post',
                data: datos,
                success:function(data)
                {
                    new PNotify({
                        title:'muy bien',
                        text:'Traslado realizado con exito',
                        type:'success'
                    });
                    location.reload();
                },error:function()
                {
                    $('#btn_generartraslado').removeClass('hidden');
                    new PNotify({
                        title:'muy bien',
                        text:'Traslado realizado con exito',
                        type:'success'
                    })
                }
            });
        }


    });




    //aceptar traslado de activo
    $('.aceptartraslado').click(function(){
        $.ajax({
            url:'aceptartrasladoactivo',
            datatype:'json',
            type:'post',
            data:{id:this.id},
            success:function(data)
            {
                new PNotify({
                    title:'muy bien',
                    text:'Traslado aceptado con exito',
                    type:'success'
                });

                location.reload();
            },error:function()
            {
                new PNotify({
                    title:'error',
                    text:'Ocurrio un error en el proceso',
                    type:'error'
                });
            }

        });
    });


    //iniciamos el proceso de baja
    $('#tbl_activos').on('click','.iniciarbaja',function(){
        $('#activo').val(this.id);
    });

    $('.tablamovimientos').on('click','.iniciarbaja',function(){
        $('#activo').val(this.id);
    });


    //al dar click sobre el boton iniciaremos el proceso de baja imprimiendo la hoja respectiva para solicitar las firmas e ir a contabilidad a finalizar el proceso
    $('.btn_bajaactivo').click(function(){
        $('.btn_bajaactivo').addClass('hidden');
        $.ajax({
           url:'INITprocesobaja',
           datatype:'json',
           data:{activo:$('#activo').val(),motivo:$('#motivoba_modal option:selected').val(),justificacion:$('#justificacionbaja').val()},
           success:function(data)
           {

               location.href = 'pdf_activobaja?activo='+data;

           },error:function()
           {
               $('.btn_bajaactivo').removeClass('hidden');
               new PNotify({
                   title:'error',
                   text:'Ocurrio un error en el proceso',
                   type:'error'
               });
           }
       });
    });



});