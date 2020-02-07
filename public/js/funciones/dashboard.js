$(document).ready(function(){
  $('#centrocostos').select2();
    $('#tipotarifario').select2();
    $('#tipoactividad').select2();
    $('#tipogasto').select2();

   


   $('#tipoactividad').change(function(){
       var fila = '';
       $('#tipotarifario').empty();
       $.ajax({
           url:'listartipogasto',
           datatype:'json',
           type:'post',
           data:{tipoactividad:$('#tipoactividad option:selected').val()},
           success:function(data)
           {
            fila+="<option value='Selecciona' set selected>Selecciona un tipo de gasto</option>";
               for(var i=0; i<data.length; i++)
               {
                    fila+="<option value="+data[i].estructura21_id+">"+data[i].estructura21_id+". "+data[i].estructura21_nombre+"</option>";
               }

               $('#gastos').removeClass('hidden');
               $('#tipotarifario').append(fila);

           }
       });
   });


   //si cambia el tipo de gasto activar el boton de generar sello
    $('#tipotarifario').change(function(){
        $('#gastosgg').removeClass('hidden');
        
    });


    $('#tipogasto').change(function(){
        $('#btn_generarsello').removeClass('hidden');
    });


    $('#btn_generarsello').click(function(){

        $('#btn_nuevosello').removeClass('hidden');
        $('#btn_generarsello').addClass('hidden');

        if($('#centrocostos option:selected').val()==='' || $('#tipotarifario').val()==='' || $('#tipoactividad').val()==='')
        {
            $('#alertasello').removeClass('hidden');
            $('#btn_nuevosello').addClass('hidden');
            $('#btn_generarsello').removeClass('hidden');
        }
        else
        {
            $('#alertasello').addClass('hidden');
            $('#tablasello').removeClass('hidden');
            $('#tbl_cc').append($('#centrocostos').val());
            $('#tbl_tg').append($('#tipotarifario').val());
            $('#tbl_tt').append($('#tipoactividad').val());
            $('#tbl_gg').append($('#tipogasto').val());

            $('#centrocostos').attr('disabled', 'disabled');
            $('#tipotarifario').attr('disabled', 'disabled');
            $('#tipoactividad').attr('disabled', 'disabled');
            $('#tipogasto').attr('disabled', 'disabled');

        }




    });


});

$("#btn_nuevosello").click(function(){
    window.location.replace('procesoerogaciones');
});

$(document).ready(function() {
  
});