jQuery(document).ready(function($) {

	//ID GLOBAL PERMISO
    var idpermiso = '';




    //eventos para bandejas
    $('#btn_aprobadas').click(function(){
        $('#p_aprobados').removeClass('hidden');
        $('#p_denegados').addClass('hidden');
        $('#p_recibidas').addClass('hidden');

        $('#btn_revisionsolicitud').removeAttr('disabled');
        $('#constancia').removeAttr('readonly');
        $('#comentario').removeAttr('readonly');

        $('#jefatura').addClass('hidden');



    });

    $('#btn_denegadas').click(function(){
        $('#p_aprobados').addClass('hidden');
        $('#p_denegados').removeClass('hidden');
        $('#p_recibidas').addClass('hidden');

        $('#btn_revisionsolicitud').attr('disabled');
        $('#constancia').attr('readonly','true');
        $('#comentario').attr('readonly','true');

        $('#jefatura').addClass('hidden');

    });

    $('#btn_enviadas').click(function(){
        $('#p_aprobados').addClass('hidden');
        $('#p_denegados').addClass('hidden');
        $('#p_recibidas').removeClass('hidden');

        $('#btn_revisionsolicitud').attr('disabled');
        $('#constancia').attr('readonly','true');
        $('#comentario').attr('readonly','true');

        $('#jefatura').removeClass('hidden');

    });
    

     //evento cuando se presiona el boton de detalles del permiso
    $('.table-mail').on('click', '.btn_verdetallepermiso', function(event) {
        
       var id = this.id;

        idpermiso = id;

        //evento json para poder realizar la busqueda del detalle del permiso seleccionado
        $.getJSON('detallespermiso', {idpermiso: id}, function(data) {
            console.log(data);

            //llenamos los campos de la modal para los detalles del permiso 
            $.each(data, function(index) {

                var anio1       = data[index].fechainicio.substr(0,4);
                var mes1        = data[index].fechainicio.substring(5,7);
                var dia1        = data[index].fechainicio.substring(8,10);

                var anio2       = data[index].fechafin.substr(0,4);
                var mes2        = data[index].fechafin.substring(5,7);
                var dia2        = data[index].fechafin.substring(8,10);

                //var fechainicio = dia1+'/'+mes1+'/'+anio1;
                var fechafin    = dia2+'/'+mes2+'/'+anio2;
                
                $('#nombrecompleto').val(data[index].empleado);
                $('#jefe').val(data[index].nombrejefe+' '+data[index].apellidojefe);
                $('#departamento').val(data[index].departamento);
                $('#tipopermiso').val(data[index].tipopermiso);
                $('#fechainicio').val(moment(data[index].fechainicio).format('DD/MM/YYYY H:mm'));
                $('#fechafin').val(moment(data[index].fechafin).format('DD/MM/YYYY H:mm'));

                $('#motivopermiso').val(data[index].motivopermiso);
                $('#motivodenegacion').val(data[index].comentariodenegacion);



                $('#nombrecompleto1').val(data[index].empleado);
                $('#jefe1').val(data[index].nombrejefe+' '+data[index].apellidojefe);
                $('#departamento1').val(data[index].departamento);
                $('#tipopermiso1').val(data[index].tipopermiso);
                $('#fechainicio1').val(moment(data[index].fechainicio).format('DD/MM/YYYY H:mm'));
                $('#fechafin1').val(moment(data[index].fechafin).format('DD/MM/YYYY H:mm'));

                $('#motivopermiso1').val(data[index].motivopermiso);


                if(data[index].gocesueldo==1)
                {
                    $('#gocesueldo').val('Aprobado con goce de sueldo');
                    $('#gocesueldo1').val('Aprobado con goce de sueldo');


                }
                else
                {
                    $('#gocesueldo').val('Aprobado sin goce de sueldo');
                    $('#gocesueldo1').val('Aprobado sin goce de sueldo');
                }

                if (data[index].rh_estados_id==1  || data[index].rh_estados_id==2) 
                {
                    $('#alertaautorizacion').removeClass('hidden');
                }
                else
                {
                    $('#alertaautorizacion').addClass('hidden');
                }

                if (data[index].rh_estados_id==4) 
                {
                    $('#recursoshumanos').addClass('hidden');
                    $('#divimpresion').removeClass('hidden');
                }
                else
                {
                    $('#recursoshumanos').removeClass('hidden');
                }
                


                
                });
            });

    });



    //evento para actualizar un permiso JEFATURA - RRHH
    $('#btn_aprobarsolicitud').click(function() {

        if($('#sueldogoce option:selected').val()==='')
        {
            swal({
                title: "Verificar!",
                text: "Falta establecer si el permiso gozará de sueldo",
                type: "warning"
            });
        }
        else
        {
            $.ajax({

                url:'actualizarpermiso',
                datatype:'json',
                type:'post',
                data:{gocesueldo:$('#sueldogoce option:selected').val(),idpermiso:idpermiso,opcion:'aprobar'},
                success:function(data)
                {
                    if (data===true)
                    {
                        new PNotify({
                            title: 'muy bien!',
                            text: 'solicitud aprobada con exito',
                            type: 'success'
                        });

                        $('#btn_cerrarupdatepermisos').click();

                        location.reload();
                    }
                },error:function()
                {
                    new PNotify({
                        title: 'error!',
                        text: 'error en el proceso de aprobacion',
                        type: 'error'
                    });
                }
            });
        }


        
        
    });


    //evento para poder denegar un permiso para mostrar la alerta de comentario
    $('#denegar').click(function(event) {
        $('.denegacion').removeClass('hidden');
        $('#denegar').addClass('hidden');
        $('#btn_denegarsolicitud').removeClass('hidden');
        $('#btn_aprobarsolicitud').addClass('hidden');
        $('#recordatorio').addClass('hidden');
        $('#sueldo').addClass('hidden');
        $('#cancelar').removeClass('hidden');
    });

    //evento para cancelar denegacion 
    $('#cancelar').click(function(event) {
        $('.denegacion').addClass('hidden');
        $('#cancelar').addClass('hidden');
        $('#denegar').removeClass('hidden');
        $('#btn_denegarsolicitud').addClass('hidden');
        $('#btn_aprobarsolicitud').removeClass('hidden');
        $('#recordatorio').removeClass('hidden');
        $('#sueldo').removeClass('hidden');
    });



    //evento para rechazar un permiso 
    $('#btn_denegarsolicitud').click(function(event) {
        $.ajax({

            url:'actualizarpermiso',
            datatype:'json',
            type:'post',
            data:{opcion:'denegar',idpermiso:idpermiso,comentariodenegacion:$('#comentariodenegacion').val()},
            success:function(data)
            {
                if (data=='success') 
                {
                    new PNotify({
                            title: '',
                            text: 'solicitud denegada...',
                            type: 'warning'
                        });

                    $('#btn_cerrarupdatepermisos').click();

                    location.reload();
                }
            }
        });
    });








    //evento para poder realizar la revision por parte de RRRHH
    $('#btn_revisionsolicitud').click(function(event) {

        $.ajax({

            url:'actualizarpermiso',
            datatype:'json',
            type:'post',
            data:{opcion:'revision',idpermiso:idpermiso,constancia:$('#constancia option:selected').val(),comentario:$('#comentario').val()},
            success:function(data)
            {


                    new PNotify({
                            title: 'Muy bien!',
                            text: 'proceso finalizado...',
                            type: 'success'
                        });



                    location.reload();

            }
        });
    });



    //evento para poder editar un permiso
    $('.table-mail').on('click', '.btn_vieweditar', function(event) {
        
        var id = this.id;

        idpermiso = id;

       //evento json para poder realizar la busqueda del detalle del permiso seleccionado
        $.getJSON('detallespermiso', {idpermiso: id}, function(data) {
            console.log(data);

            //llenamos los campos de la modal para los detalles del permiso 
            $.each(data, function(index) {

                var anio1       = data[index].fechainicio.substr(0,4);
                var mes1        = data[index].fechainicio.substring(5,7);
                var dia1        = data[index].fechainicio.substring(8,10);

                var anio2       = data[index].fechafin.substr(0,4);
                var mes2        = data[index].fechafin.substring(5,7);
                var dia2        = data[index].fechafin.substring(8,10);

                var fechainicio = dia1+'/'+mes1+'/'+anio1;
                var fechafin    = dia2+'/'+mes2+'/'+anio2;
                
                $('#nombrecompleto1').val(data[index].empleado);
                $('#jefe1').val(data[index].nombrejefe+' '+data[index].apellidojefe);
                $('#departamento1').append("<option value"+data[index].departamento_id+">"+data[index].departamento+"</option>");
                $('#tipopermiso1').append("<option value="+data[index].tipo_permiso_id+">"+data[index].tipopermiso+"</option>");
                $('#fechainicio1').val(fechainicio);
                $('#fechafin1').val(fechafin);
                $('#horainicio1').val(data[index].horainicio);
                $('#horafin1').val(data[index].horafin);
                $('#motivopermiso1').val(data[index].motivopermiso);

                

                
                


                
                });
            });
    });



    





    //evento para poder guardar la edicion
    $('#btn_guardaredicion').click(function(event) {
        $.ajax({

            url:'saveedicion',
            datatype:'json',
            type:'post',
            data:{idpermiso:idpermiso,empleado:$("#nombrecompleto1").val(),jefeinmediato:$('#jefe1').val(),
                departamento:$('#departamento1').val(),tipopermiso:$('#tipopermiso1').val(),fechainicio:$('#fechainicio1').val(),
                fechafin:$('#fechafin1').val(),horainicio:$('#horainicio1').val(),horafin:$('#horafin1').val(),horaentrada:$('#horaentrada1').val(),horasalida:$('#horasalida1').val(),
                motivopermiso:$('#motivopermiso1').val()},
            success:function(data)
            {
                if (data=='success') 
                {
                    new PNotify({
                            title: 'Muy bien!',
                            text: 'Actualizacion realizada...',
                            type: 'success'
                        });

                    location.href = 'permisosempleados';

                }
                else
                {
                    new PNotify({
                            title: 'Lo sentimos!',
                            text: 'ocurrio un error...',
                            type: 'error'
                        });
                }
            }

        });
    });



    //evento para poder descargar el PDF
    $('.btn_descargarpdf').click(function event(){

        var id = this.id;



        $.ajax({
            url:'descargarpdf',
            datatype:'json',
            type:'post',
            data:{idpermiso:id},
            success:function(data)
            {

            }
        });
    });






});

    
   


    
