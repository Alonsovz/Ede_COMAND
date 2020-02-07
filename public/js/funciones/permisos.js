$(document).ready(function(){

    /*-----------------------------------
            VARIABLES GLOBALES
    ------------------------------------*/

    //arreglo para los nombres y apellidos
    var usuarios = new Array();
    $('#datetimepicker1').datetimepicker();
    $('#datetimepicker2').datetimepicker();



    /*-------------------------------------
    ---------------------------------------*/

    //evento para nuevo horario de la sol
    $('#btn-nuevasfechas').click(function(){
       $('#oldhorario').addClass('hidden');
       $('#nuevohorario').removeClass('hidden');
       $('#btn-nuevasfechas').addClass('hidden');

       //ponemos en blanco las fechas de inicio originales
        $('#fechainicio1').val("");
        $('#fechafin1').val("");
    });
    

    //al cargar la vista del index de permiso el formulario aparecera oculto
    $("#frm_nuevopermiso").addClass('hidden');


    //evento click para mostrar formulario de nuevo permiso
    $("#btn_mostrarformulario").click(function(event) {
        $("#frm_nuevopermiso").removeClass('hidden');
    });




    //evento para guardar un permiso
    $('#btn_guardarpermiso').click(function(){



        var fecha1  = moment($('#fechainicio').val(),'MM/DD/YYYY');
        var fecha2  = moment($('#fechafin').val(),'MM/DD/YYYY');

        var diferencia = fecha2.diff(fecha1,'days');

        console.log(diferencia);

        if(diferencia<0)
        {
            new PNotify({
                title:'verificar!',
                text:'La fecha final no puede ser mayor que la inicial...',
                type:'warning'
            });
        }
        else
        {
            $('#barra_progreso').removeClass('hidden');
            $('#btn_guardarpermiso').addClass('hidden');

            $.ajax({
                url:'savepermiso',
                type:'post',
                datatype:'json',
                data:{empleado:$("#nombrecompleto").val(),jefeinmediato:$('#jefe').val(),
                    departamento:$('#departamento').val(),tipopermiso:$('#tipopermiso').val(),fechainicio:moment($('#fechainicio').val()).format('YYYYMMD h:mm'),
                    fechafin:moment($('#fechafin').val()).format('YYYYMMD h:mm'),
                    motivopermiso:$('#motivo').val()},
                success:function(data)
                {

                        new PNotify({
                            title: 'muy bien!',
                            text: 'solicitud de permiso ingresada',
                            type: 'success'
                        });

                        location.reload();


                },error:function()
                {
                    $('#barra_progreso').addClass('hidden');

                    new PNotify({
                        title: 'error!',
                        text: 'Ocurrio un error mientras se guardaba el permiso',
                        type: 'error'
                    });
                    $('#btn_guardarpermiso').removeClass('hidden');
                }

            });


        }


    });



    //evento para guardar una actualizacion de permiso
    $('.btn_actualizarpermiso').click(function(){




        var fechainicio =$('#fechainicio1').val();
        var fechafin = $('#fechafin1').val();

        //establecemos las fechas
        if($('#fechainicio1').val()==="" && $('#fechafin1').val()==="")
        {
            fechainicio = moment($('#fechainicio2').val()).format('DD/MM/YYYY H:mm');
            fechafin = moment($('#fechafin2').val()).format('DD/MM/YYYY H:mm');
        }






        var id = this.id;
        $.getJSON('actualizarpermiso', {opcion:'actualizar_em',id:id,empleado:$("#nombrecompleto").val(),jefeinmediato:$('#jefe').val(),
            departamento:$('#departamento').val(),tipopermiso:$('#tipopermiso').val(),fechainicio:fechainicio,
            fechafin:fechafin,
            motivopermiso:$('#motivo').val()}, function(data) {


            if (data=="success")
            {
                new PNotify({
                    title: 'muy bien!',
                    text: 'Actualizacion exitosa',
                    type: 'success'
                });

                location.href='dashboard';
            }
        });
    });










    /*-----------------------------------------------------------------------------
    JS para formulario de nuevo permiso
    -------------------------------------------------------------------------------*/
            $("#wizard").steps();
            $("#form").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }

                    var form = $(this);

                    // Clean up if user went backward before
                    if (currentIndex < newIndex)
                    {
                        // To remove error styles
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Disable validation on fields that are disabled or hidden.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Start validation; Prevent going forward if false
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                    // Submit form input
                    form.submit();
                }
            }).validate({
                        errorPlacement: function (error, element)
                        {
                            element.before(error);
                        },
                        rules: {
                            confirm: {
                                equalTo: "#password"
                            }
                        }
                    });

            //---------------------------------------------------------------------




            /*-----------------------------------------------------------------------------
            Validaciones  para los rangos de fechas y horarios de permisos
            -------------------------------------------------------------------------------*/

            //si el usuario selecciona tipo de permiso vacaciones las horas de de inicio y fin se ocultan
            $('#tipopermiso').change(function(event) {
                if ($('#tipopermiso option:selected').val()==7) 
                {
                    $('#horarios1').addClass('hidden');
                    $("#horarios2").addClass('hidden');
                }
                else
                {
                    $('#horarios1').removeClass('hidden');
                }
              
            });

            //-----------------------------------------------------------------------------

            

            /* ----------------------------------------------------------------------------------------
            si el permiso es diferente de vacaciones y las fechas son iguales lo que equivale a un permiso de un dia existira
            una hora de inicio y una hora de finalizacion del permiso del dia
            ---------------------------------------------------------------------------------------------*/
           $("#fechafin").change(function(event) {

               if ($("#fechainicio").val()==$("#fechafin").val() && $('#tipopermiso option:selected').val()!=7 ) 
               {
                    $("#horarios1").removeClass('hidden');
                    //$("#horarios2").addClass('hidden');
               }
               else
               {
                    //$("#horarios2").removeClass('hidden');
                    //$("#horarios1").addClass('hidden');
               }
           });



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

              

              $('#the-basics .typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
              },
              {
                name: 'usuarios',
                source: substringMatcher(usuarios)
              });

              /*-------------------------------------------------------------------
              ---------------------------------------------------------------------*/



    });
