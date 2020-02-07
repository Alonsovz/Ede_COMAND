function totalizar()
{
    var cant = new Array();
    var indice_cant = 0;
    var pre = new Array();

    var indice_pre = 0;
    var totalcantidades = 0;
    var subtotal = 0;
    var total =0;
    var iva = 0;

    indcantidades = 0;
    indpreciouni = 0;


    //evento para actualizar pagina
    $('#actualizarpagina').click(function(){
       location.reload();
    });



    $('.preciocompra').each(function(){
        pre[indice_pre] = $(this).val();
        indice_pre++;
    });

    $('.cantidad').each(function(){
        cant[indice_cant] = $(this).val();
        indice_cant++;
    });

    console.log(cant);
    console.log(pre);

    for(var i=0; i<=cant.length-1; i++)
    {
        subtotal = subtotal + (parseFloat(cant[i]) * parseFloat(pre[i]));

    }


    iva = subtotal*0.13;
    total = subtotal+iva;


    $('#iva').html("$ "+Math.round(iva*100)/100);
    $('#subtotal').html("$ "+Math.round(subtotal*100)/100);
    $('#total').html("$ "+Math.round(total*100)/100);
}
totalizar();


$(document).ready(function(){

    $('#datetimepicker1').datetimepicker();

    //variables globales
    codigosinsumos = new Array();
    marcas = new Array();
    modelos = new Array();
    series = new Array()
    indice_marcas = 0;
    indice_modelos = 0;
    indice_series = 0;
    cantidades = new Array();
    var precioscompra = new Array();
    indpreciocompra = 0;
    indice_codigos=0;
    indice_cantidades = 0;



    //si la cantidad cambiar llamamos a la funcion totalizar
    $('.cantidad').change(function(){
       totalizar();
    });

    $('.precio').change(function(){
        totalizar();
    });

    $('.preciocompra').change(function(){
        totalizar();
    });

    //evento ajax para poder mover insumos a centros de costos
    $('#btn_descargacc').click(function(){

        //capturamos los insumos  y sus cantidades a mover
        //almacenamos los codigos de productos
        $('.codinsumo').each(function(){
            codigosinsumos[indice_codigos] = $(this).val();
            indice_codigos++;

        });


        //capturar los precios de compra
        $('.preciocompra').each(function(){
            precioscompra[indpreciocompra] = $(this).val();
            indpreciocompra++;
        });

        //almacenar las cantidades en un array
        $('.cantidad').each(function(){
            cantidades[indice_cantidades] = $(this).val();
            indice_cantidades++;
        });


        //almacenamos las marcas
        $('.marca').each(function(){
            marcas[indice_marcas] = $(this).val();
            indice_marcas++;

        });

        //almacenamos los modelos
        $('.modelo').each(function(){
            modelos[indice_modelos] = $(this).val();
            indice_modelos++;

        });

        //almacenamos las series
        $('.serie').each(function(){
            series[indice_series] = $(this).val();
            indice_series++;

        });

        if(series.length===0 || modelos.length ===0 || marcas.length===0 || $('#ccf').val()==='' || $('#proveedor option:selected').val()==='' || $('#fechacompra').val()==='')
        {
            new PNotify({
                title:'Verificar!',
                text:'No se permite la descarga con campos vacios',
                type:'warning'
            });
        }else
        {
            $('#barra_progreso').removeClass('hidden');
            $('#btn_descargacc').addClass('hidden');
            $.ajax({
                url:'moverinsumoscc',
                type:'post',
                datatype:'json',
                data:
                    {
                        ordencompra:$('#ordencompra').val(),
                        cantidades:cantidades,
                        insumos:codigosinsumos,
                        centrocostos:$('#centrocostos').val(),
                        precioscompra:precioscompra,
                        modelos:modelos,
                        series:series,
                        marcas:marcas,
                        ccf:$('#ccf').val(),
                        fechacompra:moment($('#fechacompra').val()).format('YYYYMMDD'),
                        proveedorfinal:$('#proveedor option:selected').val()
                    },
                success:function(data)
                {

                        new PNotify({
                            title:'muy bien!',
                            text:'Descarga de insumos exitosa',
                            type:'success'
                        });

                        location.href = 'ord_bandejaadmin';

                        //location.href = 'getcentroscostos';
                        console.log(cantidades);
                        console.log(codigosinsumos);


                },error:function()
                {
                    $('#barra_progreso').addClass('hidden');
                    $('#btn_descargacc').removeClass('hidden');
                    new PNotify({
                        title:'error!',
                        text:'Error en la descarga de insumos',
                        type:'error'
                    });
                }

            });
        }
    });

    //totalizar
    $('#btn_totalizar').click(function(){
        var cant = new Array();
        var indice_cant = 0;
        var pre = new Array();
        var indice_pre = 0;
        var totalcantidades = 0;
        var subtotal = 0;
        var total =0;
        var iva = 0;

        indcantidades = 0;
        indpreciouni = 0;


        $('.precio').each(function(){
            pre[indice_pre] = $(this).val();
            indice_pre++;
        });

        $('.cantidad').each(function(){
            cant[indice_cant] = $(this).val();
            indice_cant++;
        });

        console.log(cant);
        console.log(pre);

        for(var i=0; i<=cant.length-1; i++)
        {
            subtotal = subtotal + (parseFloat(cant[i]) * parseFloat(pre[i]));

        }


        iva = subtotal*0.13;
        total = subtotal+iva;


        $('#iva').html("$ "+Math.round(iva*100)/100);
        $('#subtotal').html("$ "+Math.round(subtotal*100)/100);
        $('#total').html("$ "+Math.round(total*100)/100);

    });


    //evento para hoja de activo par amostrar el formulario
    $('#btn_formularioha').click(function(){
        $('#divhojaactivo').removeClass('hidden');
        $('#divdetallesorden').addClass('hidden');
        $('#btn_moveracc').addClass('hidden');
    });



    //evento para generar la hoja de activo
    $('#btn_guardarhojaactivo').click(function(){
        $('.codinsumo').each(function(){
            codigosinsumos[indice_codigos] = $(this).val();
            indice_codigos++;

        });


        //capturar los precios de compra
        $('.preciocompra').each(function(){
            precioscompra[indpreciocompra] = $(this).val();
            indpreciocompra++;
        });

        //almacenar las cantidades en un array
        $('.cantidad').each(function(){
            cantidades[indice_cantidades] = $(this).val();
            indice_cantidades++;
        });

        $.ajax({
            url:'savehojaactivo',
            type:'post',
            datatype:'json',
            data:{
                electricista:$('#electricista option:selected').val(),
                centrocostos:$('#ccostos option:selected').val(),
                agencia:$('#agencia option:selected').val(),
                departamento:$('#departamento option:selected').val(),
                municipio:$('#municipio option:selected').val(),
                bodega:$('#bodega option:selected').val(),
                justificacion:$('#justificacion').val(),
                oc:$('#ordencompra').val(),
                cantidades:cantidades,
                estadoinsumo:$('#estadoinsumo option:selected').val(),
                insumos:codigosinsumos,
                precioscompra:precioscompra},
            success:function(data)
            {
                if(data===true)
                {
                    new PNotify({
                        title:'muy bien!',
                        text:'Descarga de insumos exitosa',
                        type:'success'
                    });
                    document.getElementById('frm_adqactivo').reset();
                    $('#btn_guardarhojaactivo').addClass('hidden');
                    $('#btn_imprimirhoja').removeClass('hidden');
                }
            }
        });
    });



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



    //evento para descargar las herramientas en la bodega respectiva
    $('#btn_descargabodega').click(function(){

        //capturamos los insumos  y sus cantidades a mover
        //almacenamos los codigos de productos
        $('.codinsumo').each(function(){
            codigosinsumos[indice_codigos] = $(this).val();
            indice_codigos++;

        });

        //almacenamos las marcas
        $('.marca').each(function(){
            marcas[indice_marcas] = $(this).val();
            indice_marcas++;

        });

        //almacenamos los modelos
        $('.modelo').each(function(){
            modelos[indice_modelos] = $(this).val();
            indice_modelos++;

        });

        //almacenamos las series
        $('.serie').each(function(){
            series[indice_series] = $(this).val();
            indice_series++;

        });





        //capturar los precios de compra
        $('.preciocompra').each(function(){
            precioscompra[indpreciocompra] = $(this).val();
            indpreciocompra++;
        });

        //almacenar las cantidades en un array
        $('.cantidad').each(function(){
            cantidades[indice_cantidades] = $(this).val();
            indice_cantidades++;
        });

        if(series==='' || modelos ==='' || marcas==='' || $('#ccf').val()==='' || $('#proveedor option:selected').val() ==='' || $('#fechacompra').val()==='')
        {
            new PNotify({
                title:'Verificar!',
                text:'No se permite la descarga con campos vacios',
                type:'warning'
            });
        }else
        {
            $('#barra_progreso').removeClass('hidden');
            $('#btn_descargabodega').addClass('hidden');
            $.ajax({
                url:'moverinsumosbodega',
                type:'post',
                datatype:'json',
                data:
                    {
                        ordencompra:$('#ordencompra').val(),
                        cantidades:cantidades,
                        insumos:codigosinsumos,
                        marcas:marcas,
                        modelos:modelos,
                        series:series,
                        centrocostos:$('#centrocostos').val(),
                        precioscompra:precioscompra,
                        fechacompra:$('#fechacompra').val(),
                        proveedorfinal:$('#proveedor option:selected').val()
                    },
                success:function(data)
                {
                    if(data===true)
                    {

                        new PNotify({
                            title:'muy bien!',
                            text:'Descarga de insumos exitosa',
                            type:'success'
                        });

                        location.href = 'ord_bandejaadmin';

                        //location.href = 'getcentroscostos';
                        console.log(cantidades);
                        console.log(codigosinsumos);
                    }
                    else
                    {
                        $('#barra_progreso').addClass('hidden');
                        $('#btn_descargacc').removeClass('hidden');
                        new PNotify({
                            title:'oh no!',
                            text:'Error en la descarga de insumos',
                            type:'error'
                        });
                    }
                }

            });
        }


    });





    //evento para el auxiliar de proveedores esto es por si no hay un proveedor al momento de querer ingresar la orden
    //de compra
    $('#btn_guardarnuevoproveedor').click(function(){
        if($('#entidad').val()=="" || $('#razonsocial').val()=="")
        {
            new PNotify({
                title:'Verificar',
                text:'Digite la entidad y razon social del proveedor',
                type:'warning'
            });
        }
        else
        {
            $.ajax({
                url:'ingresarproveedoraux',
                datatype:'json',
                type:'post',
                data:{entidad:$('#entidad').val(),razonsocial:$('#razonsocial').val(),contacto:$('#contacto').val(),
                    direccion:$('#direccion').val(),correoelectronico:$('#correo').val(),telefono:$('#telefono').val()},
                success:function(data){
                    new PNotify({
                        title:'muy bien!',
                        text:'Proveedor ingresado con exito',
                        type:'success'
                    });
                    $('#proveedor').append("<option value="+data+">"+$("#razonsocial").val()+"</option>");
                }
            });
        }
    });


});