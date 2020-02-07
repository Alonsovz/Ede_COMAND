$(document).ready(function(){

    //variables globales
    arrayBodega = new Array();

    $('.js-example-basic-multiple').select2();



    var contador = 1;

    //obtener todos los insumos del centro de costos seleccinado
    $('#btn_verexistenciasbodegas').click(function(){

        $('#barraprogreso').removeClass('hidden');
        //almacenamos en un array los centros de costos seleccionados
        arrayBodega = $('.js-example-basic-multiple').val();
        $('#divselect').addClass('hidden');
        $('#nuevabusqueda').removeClass('hidden');
        $('#btn_verexistenciasbodegas').addClass('hidden');

        //recorremos el arreglo de cc seleccionados
        for(var i=0; i<=arrayBodega.length-1; i++)
        {
            //invocamos una funcion ajax para cada cc seleccionado para listar las tablas necesarias
            $.ajax({
                url:'getinsumosbodegas',
                type:'post',
                datatype:'json',
                data:{bodega:arrayBodega[i]},
                success:function(data)
                {


                    if(contador===1)
                    {
                        $.getScript('../js/funciones/lenguajeDataTable.js');
                        $.getScript('../js/plugins/dataTables/datatables.min.js');
                    }

                    //agregamos al contenedor los centros de costos generados
                    $('#divpaneles').append(data);
                    setTimeout(function(){$('#barraprogreso').addClass('hidden')},3000);
                    contador++;

                }
            });
        }


    });






});