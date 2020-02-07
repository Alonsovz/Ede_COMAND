




$(document).ready(function(){
    var usuarios = new Array();
    var insumoha = '';

    var desde,hasta = '';

    var activo = '';






    //evento para actualizar pagina
    $('#actualizarpagina').click(function(){
       location.reload();
    });


    //generar reporte de disponibilidad
    $('.rpt_dispoherram').click(function(){
        location.href = "rptdispoherramientas?bodega="+this.id;
    });


    //evento para cargar los insumos
    $.getJSON('getusuariosall',{},function(data){
        for(var i=0;i<=data.length;i++)
        {
            usuarios[i] = data[i].nombre+" "+data[i].apellido;
        }

    });


    $('.tablamovimientos').on('click','.btn_formulariosalida',function(){

        $('#divformsalida').removeClass('hidden').slideDown('slow');
        $('#divhojaactivo').addClass('hidden').slideDown('slow');
        var insumo = this.id;
        $('#insumosalida').val(insumo);
    });




    //evento para generar salidas
    $('#btn_generarsalida').click(function(){

       if($('#insumosalida').val()==="" || $('#cantidadsalida').val()==="")
       {

           new PNotify({
               title:'Verificar',
               text:'No se permiten campos vacios para generar una salida de insumo',
               type:'warning'
           });


       }
       else
       {
            $.ajax({
                url:'savemovimientos',
                type:'post',
                datatype:'json',
                data:{descripcion:$('#descripcion').val(),insumo:$('#insumosalida').val(),cantidad:$('#cantidadsalida').val(),usuarioasignado:$('#usuarioasignado').val()},
                success:function(data)
                {
                    if(data===true)
                    {
                        new PNotify({
                            title:'Muy bien!',
                            text:'Salida de insumos exitosa!',
                            type:'success'
                        });

                        location.href = 'index_mov_superv';
                    }
                    else if(data==='movimiento erroneo')
                    {
                        new PNotify({
                            title:'Atencion!',
                            text:'La cantidad de salida es mayor que la existencia del insumo',
                            type:'warning'
                        });
                    }
                }
            });
       }
    });

    //obtener insumos
    //evento para listar los insumos en el input del formulario




    //evento para departamentos para que listen los municipios segun seleccion
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






    //evento para div de detalles de asignaciones
    $('#detallesdiv').click(function(){
       $('#detallesbodega').removeClass('hidden');
       $('#registrosalida').addClass('hidden');
    });



    //evento para la tabla de detalles del activo
    $('#tabladetalles').on('click','.btn_editaractivo',function(){
        $('#divedicionactivo').removeClass('hidden');
        var insumo = this.id;
        $('#insumo1').val(insumo);
    });


    //evento para actualizar un estado de activo
    $('.btn_guardaredicion').click(function(){
       $.ajax({
           url:'edicionactivo',
           type:'post',
           datatype:'json',
           data:{insumo:$('#insumo1').val(),estado:$('#estados option:selected').val()},
           success:function(data)
           {
               if(data===true)
               {
                   new PNotify({
                       title:'muy bien!',
                       text:'Actualizacion exitosa',
                       type:'success'
                   });

                   location.reload();

               }
               else
               {
                   new PNotify({
                       title:'error!',
                       text:'Ocurrio un error',
                       type:'error'
                   });
               }
           }
       })
    });



    //evento para baja de activo
    $('#tabladetalles').on('click','.iniciarbaja',function(){
        $('#activo').val(this.id);
    });






    //evento para listar la tabla de limpieza
    $('#limpieza').click(function(){
       $('.tbl_limpieza').removeClass('hidden');
       $('.tbl_papeleria').addClass('hidden');
       $('.tbl_oficina').addClass('hidden');
       $('.detallesHA').addClass('hidden');
    });

    //evento para listar la tabla de papeleria
    $('#papeleria').click(function(){
        $('.tbl_papeleria').removeClass('hidden');
        $('.tbl_limpieza').addClass('hidden');
        $('.tbl_oficina').addClass('hidden');
        $('.detallesHA').addClass('hidden');
    });

    //evento para listar la tabla de limpieza
    $('#oficina').click(function(){
        $('.tbl_oficina').removeClass('hidden');
        $('.tbl_papeleria').addClass('hidden');
        $('.tbl_limpieza').addClass('hidden');
        $('.detallesHA').addClass('hidden');
    });


    //evento para poder mostrar el formulario para la hoja de activo
    $('.tablamovimientos').on('click','.hojaactivo',function(){
        $('#divformsalida').addClass('hidden').slideDown('slow');
        $('#divhojaactivo').removeClass('hidden');

        activo = this.id;

        //buscamos la informacion del activo que ya se comenzo a llenar por parte del administrador
        $.getJSON('findactivobyid',{id:activo},function(data)
        {
            $.each(data,function(index)
            {
               $('#insumo').val(data['id']+'-'+data['tipo_activo']);
               $('#marca').val(data['marca']);
               $('#marca').val(data['modelo']);
               $('#marca').val(data['valor']);
               $('#modelo').val(data['modelo']);
               $('#precio').val(data['valor']);
               $('#color').val(data['color']);
               $('#proveedor').val(data['proveedor']);
               $('#ccf').val(data['ccf']);
               $('#fechacompra').val(moment(data['fecha_compra']).format('DD/MM/YYYY'));
            });
        });

    });



    //evento para finalizar baja por parte de contabilidad
    $('.tablabajas').on('click','.finbaja',function(){
        $.getJSON('finalizarbajaactivo',{id:this.id},function(data){
            if(data===true)
            {
                new PNotify({
                    title:'Muy bien!',
                    text:'Baja de activo exitosa!',
                    type:'success'
                });

                location.reload();
            }
        });
    });


    //Evento para ver div de las hojas de activos para centros de costos
    $('#btn_verha').click(function(){
        $('.detallesHA').removeClass('hidden');
        $('.tbl_papeleria').addClass('hidden');
        $('.tbl_limpieza').addClass('hidden');
        $('.tbl_oficina').addClass('hidden');
    });



    //inicializamos los input que contienen los daterangepicker
    $(function() {
        $('input[name="fecha1"]').daterangepicker();
    });

    //evento para listar detalles
    $('.tablamovimientos').on('click','.detallesinsumo',function(){
        $('#insumodetalles').val(this.id);
        $('#div_tabla_detalles').addClass('hidden');
        $('#btn_verconsumos').removeClass('hidden');
        $('#btn_generarpdfconsumos').addClass('hidden');
        $('#div_tabla_detalles').empty();

    });



    //evento para ver consumos
    $('#btn_verconsumos').click(function(){

        var fecha = $('#fecha1').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);
        var fila ='';

        desde = d;
        hasta = h;

       $.ajax({
           url:'verconsumos_historico',
           datatype:'json',
           type:'post',
           data:{insumo:$('#insumodetalles').val(),desde:moment(d).format('YYYYMMDD'),hasta:moment(h).format('YYYYMMDD')},
           success:function(data)
           {
               $('#div_tabla_detalles').removeClass('hidden');
               $('#div_tabla_detalles').append(data);
               $('#btn_verconsumos').addClass('hidden');
               $('#btn_generarpdfconsumos').removeClass('hidden');
               $('#btn_generarpdfconsumos').removeClass('hidden');

           }
       }) ;
    });



    //generamos el PDF de los consumos segun rango de fechas
    $('#btn_generarpdfconsumos').click(function(){
        var insumo = $('#insumodetalles').val();

        //redireccionamos el navegador para que muestre el pdf
        location.href = 'rpt_consumos?desde='+moment(desde).format('YYYYMMDD')+'&hasta='+moment(hasta).format('YYYYMMDD')+'&insumo='+insumo;

    });


    //finalizar baja
    $('#tabladetalles').on('click','.finbaja',function(){
       $('.idha').val(this.id);
    });


    //generar hoja de ba
    $('.generarhojaba').click(function(){
        if($('#justificacionbaja').val()=='')
        {
            new PNotify({
                title:'Verificar!',
                text:'Favor digitar un motivo para la baja de activo',
                type:'warning'
            });
        }
        else
        {
            location.href ='generarbajaactivo?ha='+$('.idha').val()+'&motivoba='+$('#justificacionbaja').val()+'&&motivo='+$('#motivobaja option:selected').val();
        }

    });



    //VALIDACION DEL FORMULARIO DE LA HOJA DE ACTIVO
    $('#frm_updateactivo').validate({
        rules:{
            insumo:{
                required : true
            },
            empleado:{
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
            responsable:{
                required:true
            }

        }
    });


    //Verificar la validacion del formulario para una nueva hoja de activo
    $('#frm_updateactivo').on('submit',function(e){
        var isvalid = $("#frm_updateactivo").valid();

        //serializar el formulario
        var datos = $('#frm_updateactivo').serialize();

        if(isvalid)
        {
            e.preventDefault();
            $.ajax({
                url:'updateactivo',
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




    //cambiar vida util de la herramienta
    $('.tablamovimientos').on('click','.cambiarvidautil',function(){
       $('#herramienta').val(this.id);
    });


    //evento para cambiar el estado de la herramienta
    $('.btn_guardarcambiovidautil').click(function(){
        $.ajax({
            url:'actualizarvidautil',
            datatype:'json',
            type:'post',
            data:{herramienta:$('#herramienta').val(),estado:$('#vidautil option:selected').val()},
            success:function()
            {
                new PNotify({
                    title:'muy bien!',
                    text:'Cambio de estado exitoso!',
                    type:'success'
                });

                location.href = 'mibodega';

            },
            error:function()
            {
                new PNotify({
                    title:'Error!',
                    text:'Ocurrio un error al momento de actualizar el estado',
                    type:'error'

                });

            }
        });
    });


});


