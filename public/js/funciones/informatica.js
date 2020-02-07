$(document).ready(function(){

    //variable global
    var idusuario = '';
    var rol = '';
    var desdeglobal = '';
    var hastaglobal = '';

    $(function() {
        $('input[name="fecha"]').daterangepicker();
        $('input[name="hr_fecha"]').daterangepicker();
        $('input[name="sistema_fecha"]').daterangepicker();
        $('input[name="tickets_fecha"]').daterangepicker();
        $('input[name="recibidosXsistema"]').daterangepicker();
        $('input[name="autoasignados_fecha"]').daterangepicker();
    });


    //evento click para mostrar el footer donde veremos la informacion del usuario
    $('#tablausuarios').on('click','.btn_mostrarfooter',function(){

        $('.ibox-content').slideUp('slow');
        $('#footeribox').removeClass('hidden');
        $('#footeribox').slideDown('slow');


        //realizamos llamada ajax para listar la informacion del usuario
        $.getJSON('getinfousuario',{id:this.id},function(data){
            for(var i=0; i<=data.length; i++)
            {
                $('#nombre').val(data[i].nombre);
                $('#apellido').val(data[i].apellido);
                $('#alias').val(data[i].alias);
                $('#correo').val(data[i].correo);
                $('#departamento').append("<option selected='selected' value="+data[i].departamentoid+">"+data[i].departamento+"</option>");
                $('#jefeinmediato').append("<option selected='selected' value="+data[i].jefe_inmediato+">"+data[i].nombrejefe+' '+data[i].apellidojefe+"</option>");

                idusuario = data[i].id;
            }
        });
    });


    //habilitar tabla de roles
    $('#btn_verroles').click(function(){

        $('#cuerpotabla').html('');

       $('#tablaroles').removeClass('hidden');
       $('#btn_verroles').addClass('hidden');

       $.getJSON('getroles',{id:idusuario},function(data){
            for(var i=0; i<=data.length; i++)
            {
                $('#cuerpotabla').append("<tr><td><b>"+data[i].rol+"</b></td><td>"+data[i].descripcion+"</td><td><button class='btn btn-danger btn-xs btn_eliminarrol' type='button' id="+data[i].id+"><i class='fa fa-minus-circle'></i> Eliminar</button></td></tr>");
            }
       });
    });

    $('#btn_cancelar').click(function(){
        $('#tablaroles').addClass('hidden');
        $('#btn_verroles').removeClass('hidden');
        $('#footeribox').slideUp('slow');
        $('.ibox-content').slideDown('slow');

    });

    //evento para dueño de vehiculo



    //evento para asignar un rol
    $('.asignar_rol').click(function(){

        $('#tablaroles').addClass('hidden');
        $('#btn_verroles').removeClass('hidden');
        //sobreeescribimos la variable global de rol
        rol = this.id;

        $.ajax({
            url:'asignarrol',
            data:{rol:this.id,usuario:idusuario},
            datatype:'json',
            type:'post',
            success:function(data)
            {
                if(data===true)
                {
                    new PNotify({
                        title:'Muy bien',
                        text:'Rol asignado con exito!',
                        type:'success'
                    });
                }
                else
                {
                    new PNotify({
                        title:'Error',
                        text:'Ocurrio un error al asignar rol!',
                        type:'error'
                    });
                }
            }
        });
    });


    //asignar un vehiculo y guardar el rol para los dueños de vehiculos nuevos
    $('#btn_guardarinfo_vh').click(function(){

        $.ajax({
            url:'asignarvehiculo',
            data:{vehiculo:$('#vehiculo option:selected').val(),usuario:idusuario},
            datatype:'json',
            type:'post',
            success:function(data)
            {
                if(data===true)
                {
                    new PNotify({
                        title:'Muy bien',
                        text:'Vehiculo asignado con exito!',
                        type:'success'
                    });

                    location.reload();
                }
                else
                {
                    new PNotify({
                        title:'Error',
                        text:'Ocurrio un error al asignar Vehiculo!',
                        type:'error'
                    });
                }
            }
        });
    });




    //EVENTO PARA GUARDAR LA INFORMACION DEL CC Y BODEGA ASIGNADA AL USUARIO
    $('#btn_guardarinfo_insum').click(function(){
        $.ajax({
            url:'asignarccbodega',
            data:{bodega:$('#bodega').val(),usuario:idusuario,cc:$('#centrocosto').val()},
            datatype:'json',
            type:'post',
            success:function(data)
            {
                if(data===true)
                {
                    new PNotify({
                        title:'Muy bien',
                        text:'asignaciones realizadas con exito!',
                        type:'success'
                    });

                    location.reload();
                }
                else
                {
                    new PNotify({
                        title:'Error',
                        text:'Ocurrio un error en la asignación!',
                        type:'error'
                    });
                }
            }
        });
    });



    //evento para guardar informacion general
    $('#btn_guardarinfogeneral').click(function(){
       $.ajax({
           url:'editarinfousuario',
           datatype:'json',
           type:'post',
           data:{usuario:idusuario,nombre:$('#nombre').val(),apellido:$('#apellido').val(),alias:$('#alias').val(),correo:$('#correo').val(),
                departamento:$('#departamento option:selected').val(),jefatura:$('#jefeinmediato option:selected').val()},
           success:function(data)
           {
               if(data===true)
               {
                   new PNotify({
                       title:'Muy bien',
                       text:'Edición de información con exito!',
                       type:'success'
                   });

                   location.reload();

               }
               else
               {
                   new PNotify({
                       title:'Error',
                       text:'Error en la edición!',
                       type:'error'
                   });

               }
           }
       });
    });


    //evento para poder eliminar un rol
    $('#tabla_roles').on('click','.btn_eliminarrol',function()
    {
       $.ajax({
           url:'eliminarrolforuser',
           datatype:'json',
           type:'post',
           data:{usuario:idusuario,rol:this.id},
           success:function(data)
           {
               if(data===1)
               {
                   new PNotify({
                       title:'Muy bien',
                       text:'Eliminacion exitosa!',
                       type:'success'
                   });

                   location.reload();
               }
               else
               {
                   new PNotify({
                       title:'Error',
                       text:'Error al intentar eliminar!',
                       type:'error'
                   });
               }
           }

       });
    });


    //evento para guardar usuario
    $('#btn_guardarusuario').click(function(data){
       $.ajax({
           url:'nuevousuario',
           type:'post',
           datatype:'json',
           data:{nombre:$('#nombre1').val(),apellido:$('#apellido1').val(),alias:$('#alias1').val(),correo:$('#correo1').val(),departamento:$('#departamento1').val(),jefatura:$('#jefeinmediato1').val()},
           success:function(data)
           {
               if(data===true)
               {
                   new PNotify({
                       title:'Muy bien',
                       text:'Nuevo usuario registrado!',
                       type:'success'
                   });

                   location.reload();
               }
               else
               {
                   new PNotify({
                       title:'Muy bien',
                       text:'Nuevo usuario registrado!',
                       type:'success'
                   });
               }
           }
       });
    });



    //evento para generar el reporte del detalle de los tickets de informatica  por mes
    $('#btn_generardetalletickets').click(function(){
        var fecha = $('#fecha').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(13,20);

        var desde = moment(d).format('YYYYMMDD');
        var hasta = moment(h).format('YYYYMMDD');

        desdeglobal = desde;
        hastaglobal = hasta;

        console.log(desde);
        console.log(hasta);

        //evento ajax para traer la partial view y mostrarla
        $.ajax({
            url:'rpt_detalleticketsinformatica',
            datetype:'json',
            type:'post',
            data:{desde:desde,hasta:hasta},
            success:function(data)
            {
                $('#tablatickets').slideUp();
                $('#divsupervticket1').removeClass('hidden').append(data);
                $('#detallesticket').removeClass('hidden');
            }
        });
    });


    //evento para exportar a excel
    $('#generarexcel').click(function(){
       location.href='xls_generarexceldetalletickets?desde='+desdeglobal+'&&hasta='+hastaglobal;
    });


    //evento para generar reporte de las horas trabajadas por empleado
    $('#btn_generardetallehoras').click(function(){
       var fecha = $('#hr_fecha').val();

       var desde = fecha.substr(0,11);
       var hasta = fecha.substr(13,20);

        var D = moment(desde).format('YYYYMMDD');
        var H = moment(hasta).format('YYYYMMDD');

        desdeglobal = D;
        hastaglobal = H;

       //funcion ajax para generar el detalle de las horas
        $.ajax({
            url:'rpt_detallehorastrabajadas',
            type:'post',
            datatype:'json',
            data:{desde:D,hasta:H},
            success:function(data)
            {
                $('#tablatickets').slideUp();
                $('#divsupervticket').removeClass('hidden').append(data);
                $('#div_horastrabajadas').removeClass('hidden');

            },error:function()
            {
                new PNotify({
                    title:'Error',
                    text:'Error al generar reporte!',
                    type:'error'
                });
            }
        });
    });

    //excel para detalle de horas
    $('#excel_hrstrabajadas').click(function(){
       location.href = 'excel_detallehorastrabajadas?desde='+desdeglobal+'&&hasta='+hastaglobal;
    });



    //generar rpt de horas registradas por sistema
    $('#btn_generarreportesistemas').click(function(){
        var fecha = $('#sistema_fecha').val();

        var desde = fecha.substr(0,11);
        var hasta = fecha.substr(13,20);

        var D = moment(desde).format('YYYYMMDD');
        var H = moment(hasta).format('YYYYMMDD');

        console.log(D+' '+H);

        desdeglobal = D;
        hastaglobal = H;

        $.ajax({
            url:'rpt_hrsxsistema',
            datatype:'json',
            type:'post',
            data:{desde:D,hasta:H},
            success:function(data)
            {
                $('#tablatickets').slideUp();
                $('#divsupervticket2').removeClass('hidden').append(data);
                $('#div_horastrabajadasxsistema').removeClass('hidden');

            },error:function()
            {
                new PNotify({
                    title:'Error',
                    text:'Error al generar reporte!',
                    type:'error'
                });
            }
        });

    });



    //generar excel de las horas registradas por sistema
    $('#excelhorasxsistema').click(function(){
        location.href = 'excel_detallehorastrabajadassistema?desde='+desdeglobal+'&&hasta='+hastaglobal;
    });




    //generar rpt de los ticket recibidos por empleado
    $('#btn_generarptticketsrecibidos').click(function(){
        var fecha = $('#tickets_fecha').val();

        var desde = fecha.substr(0,11);
        var hasta = fecha.substr(13,20);

        var D = moment(desde).format('YYYYMMDD');
        var H = moment(hasta).format('YYYYMMDD');

        console.log(D+' '+H);

        desdeglobal = D;
        hastaglobal = H;

        $.ajax({
            url:'rpt_ticketsrecibidos',
            datatype:'json',
            type:'post',
            data:{desde:D,hasta:H},
            success:function(data)
            {
                $('#tablatickets').slideUp();
                $('#divsupervticket3').removeClass('hidden').append(data);
                $('#div_ticketsrecibidos').removeClass('hidden');

            },error:function()
            {
                new PNotify({
                    title:'Error',
                    text:'Error al generar reporte!',
                    type:'error'
                });
            }
        });
    });


    //generar excel de los tickets recibidos
    $('#excelticketsrecibidos').click(function(){
        location.href = 'excel_ticketsrecibidos?desde='+desdeglobal+'&&hasta='+hastaglobal;
    });


    //generar reporte de los tickets recibidos por sistema
    $('#btn_generarticketrecibidosxsistema').click(function(){
        var fecha = $('#recibidosXsistema').val();

        var desde = fecha.substr(0,11);
        var hasta = fecha.substr(13,20);

        var D = moment(desde).format('YYYYMMDD');
        var H = moment(hasta).format('YYYYMMDD');

        console.log(D+' '+H);

        desdeglobal = D;
        hastaglobal = H;

        $.ajax({
            url:'rpt_ticketsxsistemaconteo',
            datatype:'json',
            type:'post',
            data:{desde:D,hasta:H},
            success:function(data)
            {
                $('#tablatickets').slideUp();
                $('#divsupervticket4').removeClass('hidden').append(data);
                $('#div_ticketsistemasrecibidos').removeClass('hidden');

            },error:function()
            {
                new PNotify({
                    title:'Error',
                    text:'Error al generar reporte!',
                    type:'error'
                });
            }
        });
    });


    //generar excel para los tickets recibidos por sistema
    $('#excelticketsxsistema').click(function(){
       location.href='ticketsrecibidosxsistema?desde='+desdeglobal+'&&hasta='+hastaglobal;
    });


    //generar reporte para los tickets autoasignados
    $('#btn_generarautoasignados').click(function(){
        var fecha = $('#autoasignados_fecha').val();

        var desde = fecha.substr(0,11);
        var hasta = fecha.substr(13,20);

        var D = moment(desde).format('YYYYMMDD');
        var H = moment(hasta).format('YYYYMMDD');

        console.log(D+' '+H);

        desdeglobal = D;
        hastaglobal = H;

        $.ajax({
            url:'rpt_autoasignadostickets',
            datatype:'json',
            type:'post',
            data:{desde:D,hasta:H},
            success:function(data)
            {
                $('#tablatickets').slideUp();
                $('#divsupervticket5').removeClass('hidden').append(data);
                $('#div_ticketautoasignados').removeClass('hidden');

            },error:function()
            {
                new PNotify({
                    title:'Error',
                    text:'Error al generar reporte!',
                    type:'error'
                });
            }
        });
    });


    //generar excel para los tickets auto-asignados
    $('#excelautoasignados').click(function(){
        location.href='excel_ticketsautoasignados?desde='+desdeglobal+'&&hasta='+hastaglobal;
    });


});