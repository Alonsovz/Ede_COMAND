
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

    var cantidades = new Array();

    var codigosinsumos = new Array();
    var indice_cantidades = 0;
    var indice_codigos = 0;


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
}


$(document).ready(function(){

    //variables globales

    setInterval(function(){ totalizar(); }, 3000);

    var cantidades = new Array();
    var insumos = new Array();
    var codigosinsumos = new Array();
    var precios = new Array();
    var ins_descripciones = new Array();
    var indice_ins_desc =0;

    var indice_cantidades = 0;
    var indice_codigos = 0;
    var indice_precios = 0;


    totalizar();


    $('.precio').change(function(){
        totalizar();
    });

    $('.cantidad').change(function(){
        totalizar();
    });






    //eliminar una fila de la orden de compra
    $('.btn_eliminarinsumo').click(function(){
        var id = this.id;
        $("#"+id+"").remove();
    });



    //capturamos los insumos introducidos y sus cantidades para generar la orden compra
    $('#btn_prepararorden').click(function(){
        //reseteamos los valores de los array e indices si hay alguna llamada extra a este evento
        cantidades.length = 0;
        precios.length = 0;
        ins_descripciones.length =0;
        indice_precios = 0;
        codigosinsumos.length = 0;
        indice_codigos = 0;
        indice_cantidades = 0;
        indice_ins_desc=0;

        //almacenamos los codigos de productos
        $('.codinsumo').each(function(){
            codigosinsumos[indice_codigos] = $(this).val();
            indice_codigos++;

        });

        //almacenar las cantidades en un array
        $('.cantidad').each(function(){
            cantidades[indice_cantidades] = $(this).val();
            indice_cantidades++;
        });

        $('.precio').each(function(){
            precios[indice_precios] = parseFloat($(this).val());
            indice_precios++;
        });

        $('.ins_descripcion').each(function(){
            ins_descripciones[indice_ins_desc] = $(this).val();
            indice_ins_desc++;
        });

        console.log(codigosinsumos);
        console.log(cantidades);
        console.log(precios);
    });


    //guardar una orden de compra
    $('#btn_guardarorden').click(function(){

        if($('#proveedor option:selected').val()=="" || $('#fechaentrega').val()=="")
        {
            new PNotify({
                title:'Verificar',
                text:'No se puede generar una orden con campos vacios',
                type:'warning'
            });
        }
        else
        {
            $.ajax({
                url:'saveorden',
                type:'post',
                datatype:'application/pdf',
                data:
                    {
                        requisicion:    $('#requisicion').val(),
                        proveedor:      $("#proveedor option:selected").val(),
                        fechaentrega:   $('#fechaentrega').val(),
                        codinsumos:     codigosinsumos,
                        cantidades:     cantidades,
                        ins_desc:       ins_descripciones,
                        precios:        precios,
                        terminopago:    $('#terminopago option:selected').val()
                    },
                success:function(data)
                {
                    if(data===true)
                    {
                        new PNotify({
                            title:'muy bien!',
                            text:'Orden generada exitosamente',
                            type:'success'
                        });

                        $('#btn_prepararorden').addClass('hidden');
                        $('#btn_totalizar').addClass('hidden');
                        $('#btn_cerrarmodalorden').click();
                        //location.href='rq_bandejaadmin';
                        $('#btn_imprimirorden').removeClass('hidden');

                    }
                    else
                    {
                        new PNotify({
                            title:'oh no!',
                            text:'Error en la generacion de la orden de compra',
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



    //evento para iniciar la edicion de la req
    $('#btn_editarrequisicion').click(function(){
        $('.btn_agregarinsumo').removeClass('hidden');

        //recorremos los input para remover el atributo de readonly
        $('.cantidad').removeAttr('readonly');

        //habilitamos el boton de eliminar insumo
        $('.btn_eliminarinsumo').removeClass('hidden');

        //habilitamos el boton guardar edicion
        $('.btn_guardaredicion').removeClass('hidden');
    });


    //evento para eliminar un insumo
    $('.btn_eliminarinsumo').click(function(){

        cantidades.length = 0;
        codigosinsumos.length = 0;
        indice_cantidades = 0;
        indice_codigos = 0;

        var id = this.id;
        $("#"+id+"").remove();

        //llamamos a la funcion totalizar
        totalizar();
    });


    //evento para iniciar el proceso de agregar un insumo
    $('.btn_agregarinsumo').click(function(){

        var req = this.id;

        //llenamos el array de insumos segun la opcion del tipo de requisicion a la que pertencen los detalles
        if(req=='Papeleria')
        {
            //evento para cargar los insumos
            $.getJSON('obtenerinsumos',{tiporeq:1},function(data){
                for(var i=0;i<=data.length;i++)
                {
                    insumos[i] = data[i].nombre;
                }

            });
        }
        else if(req=='Herramientas')
        {
            //evento para cargar los insumos
            $.getJSON('obtenerinsumos',{tiporeq:2},function(data){
                for(var i=0;i<=data.length;i++)
                {
                    insumos[i] = data[i].nombre;
                }

            });
        }
        else if(req=='Limpieza')
        {
            //evento para cargar los insumos
            $.getJSON('obtenerinsumos',{tiporeq:3},function(data){
                for(var i=0;i<=data.length;i++)
                {
                    insumos[i] = data[i].nombre;
                }

            });
        }

    });



    //evento para insertar una nueva fila a la edicion
    //insertar la fila
    $('#btn_insertarfila').click(function(){

        //reseteamos los arreglos de cantidades y codigos
        cantidades.length = 0;
        codigosinsumos.length = 0;
        indice_cantidades = 0;
        indice_codigos = 0;




        //obtenemos el codigo del insumo con el nombre del insumo
        $.getJSON('obteneridinsumo',{insumo:$('#insumo').val()},function(data){

            var fila = '';

            if($('#insumo').val()==="" || $('#cantidad').val()==="")
            {
                new PNotify({
                    title:'Atencion!',
                    text: 'No se permiten campos vacios para la insercion de un insumo',
                    type:'warning'
                });
            }
            else
            {
                fila = "<tr style='background-color: lightgreen' id="+data+"><td class='vacia'></td>" +
                    "<td  class=''><input type='text' readonly='true' class='codinsumo form-control' value="+data+"></td>" +
                    "<td  class=''><input type='text' class='insumo form-control' readonly='true' value="+$('#insumo').val()+" ></td>" +
                    "<td ><input class='form-control cantidad' type='text'  value="+$('#cantidad').val()+"></td>" +
                    "<td  class=''><input type='text'  class='precio form-control'></td>"+
                    "<td  class='accion text-center'>" +
                    "<button type='button' class='btn btn-sm btn-danger eliminarfila' id="+data+"><i class='fa fa-trash'></i></button></td></tr>";
                $('#tablainsumos tbody tr:last').after(fila);
                document.getElementById('frm_insumos').reset();
            }
            //evento para eliminar una fila al tener ingresado insumos
            $('.eliminarfila').click(function()
            {
                var id = this.id;
                $("#"+id+"").remove();
            });

            //evento para editar un insumo seleccionado
            $('#btn_edicion').click(function(){
                $('.input').removeAttr('readonly');
            });
        });




    });



    //evento para guardar una requisicion editada
    $('.btn_guardaredicion').click(function(){
        //capturamos los datos que se enviararn en la requisicion
        //almacenamos los codigos de productos
        $('.codinsumo').each(function(){
            codigosinsumos[indice_codigos] = $(this).val();
            indice_codigos++;

        });

        //almacenar las cantidades en un array
        $('.cantidad').each(function(){
            cantidades[indice_cantidades] = $(this).val();
            indice_cantidades++;
        });

        $.getJSON('actualizarrequisicion',{cantidades:cantidades,insumos:codigosinsumos,id:this.id},function(data){
            if(data===true)
            {
                new PNotify({
                    title:'muy bien',
                    text:'Actualizacion exitosa!',
                    type:'success'
                });

                location.href = 'rq_bandejasuperv';
            }
        });
    });




    //evento para guardar un insumo nuevo
    $('#btn_guardarinsumo').click(function(){
        if($('#categoriainsumo option:selected').val()=='')
        {
            new PNotify({
                title:'verificar',
                text:'Seleccione una categoria para el nuevo insumo',
                type:'warning'
            });
        }
        else
        {
            $.ajax({
                url:'guardarinsumo',
                datatype:'json',
                type:'post',
                data:{insumo:$('#nombreinsumo').val(),descripcion:$('#descripcioninsumo').val(),precio:$('#precioinsumo').val(),
                    categoria:$('#categoriainsumo option:selected').val()},
                success:function(data)
                {
                    if(data===true)
                    {
                        new PNotify({
                            title:'muy bien',
                            text:'Insumo guardado con exito!',
                            type:'success'
                        });

                        //establecemos el insumo nuevo ingresado en el campo del insumo a insertar
                        $('#insumo').val($('#nombreinsumo').val());
                    }
                    else
                    {
                        new PNotify({
                            title:'oh no',
                            text:'Ocurrio un error mientras se guardaba la informacion del insumo!',
                            type:'error'
                        });
                    }
                }
            });
        }

    });



    //evento para listar los insumos en el input del formulario
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
            name: 'insumos',
            source: substringMatcher(insumos)
        });



});