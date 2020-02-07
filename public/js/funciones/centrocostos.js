$(document).ready(function(){

    //bloquear alertas para datatables


    //variables globales
    arrayCC = new Array();

    $('.js-example-basic-multiple').select2();




    var contador = 1;
    //obtener todos los insumos del centro de costos seleccinado
    $('#btn_verexistencias').click(function(){


        $('#barraprogreso').removeClass('hidden');
        //almacenamos en un array los centros de costos seleccionados
        arrayCC = $('.js-example-basic-multiple').val();
        $('.js-example-basic-multiple').val("");
        $('#divselect').addClass('hidden');
        $('#nuevabusqueda').removeClass('hidden');
        $('#btn_verexistencias').addClass('hidden');


        //recorremos el arreglo de cc seleccionados
        for(var i=0; i<=arrayCC.length-1; i++)
        {
            //invocamos una funcion ajax para cada cc seleccionado para listar las tablas necesarias
            $.ajax({
                url:'getinsumoscc',
                cache:false,
                type:'post',
                datatype:'json',
                data:{centrocosto:arrayCC[i]},
                success:function(data)
                {

                    if(contador===1)
                    {
                        $.getScript('../js/funciones/lenguajeDataTable.js');
                        $.getScript('../js/plugins/dataTables/datatables.min.js');
                    }


                    //agregamos al contenedor los centros de costos generados
                    $('#divpaneles').append(data);
                    setTimeout(function(){$('#barraprogreso').addClass('hidden');},3000);
                    contador++;
                }
            });
        }

    });




});