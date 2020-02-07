$(document).ready(function(){


    $(function () {
        $('#fecharegularizacion').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        $('#datetimepicker1').datetimepicker({
           format:'DD/MM/YYYY'
        });

        $('#datetimepicker2').datetimepicker({
            format:'DD/MM/YYYY'
        });

        $('#datetimepicker3').datetimepicker({
            format:'DD/MM/YYYY'
        });

        $('#datetimepicker4').datetimepicker({
            format:'DD/MM/YYYY'
        });

        $('#datetimepicker5').datetimepicker({
            format:'DD/MM/YYYY'
        });



    });

    $('#btn_buscarnis').click(function(){

        //buscamos lectuas del NIS
        $.ajax({
            url:'buscarlecturasbynis',
            datatype:'json',
            type:'GET',
            data:{NIS:$('#txt_nis').val()},
            success:function(response)
            {
                var fila = "";
                for(var i in response)
                {
                    fila+="<tr><td class='text-center'>"+response[i].periodo+"</td><td class='text-center'>"+response[i].numero_medidor+"</td><td class='text-center'>"+moment(response[i].fecha_lectura_ant).format("DD/MM/YYYY")+"</td><td class='text-center'>"+moment(response[i].fecha_lectura).format("DD/MM/YYYY")+"</td><td class='text-center'>"+Math.round(response[i].consumo*100)/100+" Kwh</td></tr>"
                }
                $('#bodylecturas').append(fila);
            },
            error:function(response)
            {

            }
        });

        //buscamos el historico de medidores
        $.ajax({
            url:'buscarhistoricomedidores',
            type:'get',
            datatype:'json',
            data:{NIS:$('#txt_nis').val()},
            success:function(response){

                for(var i=0; i<response.length; i++)
                {
                    if(response[i].bandera_activo==0)
                    {
                        $('#medidor').val(response[i].numero_medidor);
                    }
                    else if(response[i].bandera_activo==1)
                    {
                        $('#medidorinstalado').val(response[i].numero_medidor);
                        //$('#fecharegularizacion').val(moment(response[i].fecha_instalacion).format('DD/MM/YYYY'));

                        $('#regularizacion').val(moment(response[i].fecha_instalacion).format('DD/MM/YYYY'));
                    }


                }

            },error:function(){

            }

        });



        //buscamos detalles del NIS y del cliente
       $.ajax({
           url:'buscarinfonis',
           method:'GET',
           data:{NIS:$('#txt_nis').val()},
           success:function(datos)
           {



                for(var i in datos)
                {
                   $('#usuario').val(datos[i].nombres+" "+datos[i].apellidos);
                   $('#tarifa').val(datos[i].tarifa);
                }
                $('.divcalculoenr').removeClass('hidden');

                 $('#hastaretroactivo').val($('#regularizacion').val());




           },error:function(data){

           }
       });
    });



    //evento para periodo historico de consumos
    $('#datetimepicker2').on('dp.change',function(){


        if($('#tipocalculo option:selected').val()==='Anterior')
        {
            var fecha = $('#desdehistorico').val();
            $('#hastahistorico').val(moment(fecha,'DD/MM/YYYY').subtract(parseInt($('#diashistoricos option:selected').val()),'days').format('DD/MM/YYYY'));


        }
        else
        {
            var fecha = $('#desdehistorico').val();
            $('#hastahistorico ').val(moment(fecha,'DD/MM/YYYY').add(parseInt($('#diashistoricos option:selected').val()),'days').format('DD/MM/YYYY'));


        }







    });


    $('#sumatoria').click(function(){
        //sumatoria de las nuevas lecturas
        $('#promediosuma').removeClass('hidden');



        $.ajax({
            url:'sumatorianuevaslect',
            datatype:'json',
            type:'get',
            data:{codigoconsumo:'CO011',NIS:$('#txt_nis').val(),desde:moment($('#desdehistorico').val(),'DD/MM/YYYY').format('YYYYMMDD'),hasta:moment($('#hastahistorico').val(),'DD/MM/YYYY').format('YYYYMMDD')},
            success:function(response)
            {
                var lect = response;

                $('#sumalecturas').val(Math.round(response*100)/100);
                var promedio = $('#sumalecturas').val()/$('#diashistoricos').val();
                $('#promedioconsumo').val(promedio.toFixed(2));
            },
            error:function()
            {

            }
        });
    });




    //evento para dias retroactivos
    $('#diasretroactivo').change(function(){
        var consumoestimado = $('#diasretroactivo').val()*$('#promedioconsumo').val();
        $('#consumoestimado').val(consumoestimado.toFixed(2));


        var hasta = $('#hastaretroactivo').val();

        $('#desderetroactivo').val(moment(hasta,'DD/MM/YYYY').subtract(parseInt($('#diasretroactivo').val()),'days').format('DD/MM/YYYY'));

    });


    //evento para consumo registrado
    $('#consumoregistrado').change(function(){
        var op = parseFloat($('#consumoestimado').val()) - parseFloat($('#consumoregistrado').val());
        $('#montokwhenr').val(op);

    });













});