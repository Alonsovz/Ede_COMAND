$(document).ready(function(){



    $("#frm_postes" ).validate({
        rules: {
            cantidadpostes: {
                required: true
            },
            departamento: {
                required: true
            },
            municipio:{
                required:true
            },
            codigoproyecto:{
                required:true
            },
            descripcion:{
                required:true
            }


        }
    });


    //evento para mostrar el formulario de nueva sol de postes
    $('#btn_nuevasolpostes').click(function (){
        $('#formularioposte').removeClass('hidden');
    });



    //obtener los municipios segun el dpto seleccionado
    $('#departamento').change(function(){
       $.getJSON('getmunicipiosbydpto',{departamento:$('#departamento option:selected').val()},function(data)
       {
            var lista = '';
            for(var key in data)
            {
                lista+="<option value="+data[key].ID+">"+data[key].MunName+"</option>"
            }

            $('#municipio').append(lista);
            $('#divmunicipio').removeClass('hidden');

       });
    });




    //guardamos la solicitud
    $("#frm_postes").on('submit', function(e) {
        var isvalid = $("#frm_postes").valid();
        if (isvalid){
            e.preventDefault();




            //llamada ajax para guardar el formulario
            $.ajax({
                url:'savesolicitudposte',
                datatype:'json',
                type:'post',
                data:$('#frm_postes').serialize(),
                success:function(data)
                {
                    if(data===true)
                    {
                        swal({
                            title:'Muy bien!',
                            text:'Solicitud enviada con exito',
                            type:'success'
                        });

                        document.getElementById('frm_postes').reset();
                    }
                    else
                    {
                        swal({
                            title:'Verificar!',
                            text:'Ocurrio un error en el envio de la solicitud',
                            type:'error'
                        });
                    }
                }
            });
        }
    });














});