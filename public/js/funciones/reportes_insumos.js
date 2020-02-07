$(document).ready(function(){

    var insumos = new Array();
    var desdeglobal,hastaglobal='';
    var bodegaglobal = '';

    $('.dropdown-submenu a.test').on("click", function(e){
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });

   // $('.navbar-minimalize').click();

    //inicializamos los input que contienen los daterangepicker
    $(function() {
        $('input[name="fecha"]').daterangepicker();
        $('input[name="fech1"]').daterangepicker();
        $('input[name="fech2"]').daterangepicker();
        $('input[name="fechaconsumos"]').daterangepicker();
        $('input[name="fecha_Estados"]').daterangepicker();
        $('input[name="fechaconsumoscc"]').daterangepicker();

    });



    //evento para generar el excel de la disponibilidad de los insumos
    $('#btn_generar1_excel').click(function(){

        var fecha = $('#fecha').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);
        location.href = 'qry_disponibilidad_pape_excel?desde='+moment(d).format('YYYYMMDD')+'&hasta='+moment(h).format('YYYYMMDD')+'&cc='+$('#centrocosto option:selected').val();

    });


    //evento para generar el reporte de disponibilidad de insumos por centro de costos
    $('#btn_generarpdfmovpape').click(function(){
        var fecha = $('#fecha').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);

        location.href = 'rpt_movimientopapeleria?desde='+moment(d,'MM/DD/YYYY').format('YYYYMMDD')+'&hasta='+moment(h,'MM/DD/YYYY').format('YYYYMMDD')+'&cc='+$('#centrocosto option:selected').val();
    });

    //evento para generar el reporte de disponibilidad de insumos de limpieza por centro de costos
    $('#btn_generarpdfmovlimpieza').click(function(){
        var fecha = $('#fecha1').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);

        location.href = 'rpt_movimientolimpieza?desde='+moment(d).format('YYYYMMDD')+'&hasta='+moment(h).format('YYYYMMDD')+'&cc='+$('#centrocostolimpieza option:selected').val();
    });



    //generar pdf de disponibilidad de herramientas
    $('#btn_generarpdfdispoherram').click(function(){
        location.href = "rptdispoherramientas?bodega="+$("#bodega").val();
    });


    //evento para generar pdf de costos de limpieza
    $('#btn_generarpdfmovlimpiezacostos').click(function(){
        var fecha = $('#fecha2').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);

        location.href = 'rpt_costoslimpieza?desde='+moment(d).format('YYYYMMDD')+'&hasta='+moment(h).format('YYYYMMDD')+'&cc='+$('#centrocostolimpieza1 option:selected').val();
    });

    //evento para poder generar el reporte de disponibilidad de papeleria
    $('#btn_movimientoPapeleria').click(function(){

        $('.dtl').remove();
        $('#div_tabla_detalles').empty();

        var fecha = $('#fecha').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(13,20);



        $.ajax({
            url:'qry_movimiento_pape',
            type:'post',
            datatype:'json',
            data:{desde:moment(d,'MM/DD/YYYY').format('YYYYMMDD'),hasta:moment(h,'MM/DD/YYYY').format('YYYYMMDD'),cc:$('#centrocosto option:selected').val()},
            success:function(data)
            {

                $('#renderdispopape').removeClass('hidden');
                $('#rendertable1').append(data);
                $('#reportesinsumos').addClass('hidden');
                $('#btn_nuevoreporte').removeClass('hidden');
            }
        });

        //location.href = 'rpt_dispo_papeleria?desde='+moment(d).format('YYYYMMDD')+'&hasta='+moment(h).format('YYYYMMDD')+'&cc='+$('#centrocosto option:selected').val();

    });



    //evento para poder genera el reporte de movimientos de limpieza por cc
    $('#btn_movimientoLimpieza').click(function(){

        var fecha = $('#fecha1').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);

        $.ajax({
            url:'qry_movimiento_limpieza',
            type:'post',
            datatype:'json',
            data:{desde:moment(d).format('YYYYMMDD'),hasta:moment(h).format('YYYYMMDD'),cc:$('#centrocostolimpieza option:selected').val()},
            success:function(data)
            {

                if(data==='no insumos')
                {
                    $('#renderdispolimpieza').removeClass('hidden');
                    $('#rendertable2').html('<div class="alert alert-dismissible alert-info">' +
                        '<h3 class="text-primary">El centro de costos seleccionado no cuenta con insumos de limpieza</h3></div>');
                    $('#reportesinsumos').addClass('hidden');
                    $('#btn_nuevoreporte').removeClass('hidden');
                }
                else
                {
                    $('#renderdispolimpieza').removeClass('hidden');
                    $('#rendertable2').append(data);
                    $('#reportesinsumos').addClass('hidden');
                    $('#btn_nuevoreporte').removeClass('hidden');
                }
            }
        });

        //location.href = 'rpt_dispo_papeleria?desde='+moment(d).format('YYYYMMDD')+'&hasta='+moment(h).format('YYYYMMDD')+'&cc='+$('#centrocosto option:selected').val();

    });



    //costos por cc de los insumos de limpieza
    $("#btn_costoslimpieza").click(function(){
        var fecha = $('#fecha2').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);

        $.ajax({
            url:'qry_costoslimpieza',
            type:'post',
            datatype:'json',
            data:{desde:moment(d).format('YYYYMMDD'),hasta:moment(h).format('YYYYMMDD'),cc:$('#centrocostolimpieza1 option:selected').val()},
            success:function(data)
            {

                if(data==='no insumos')
                {
                    $('#renderdispolimpiezacostos').removeClass('hidden');
                    $('#rendertable3').html('<div class="alert alert-dismissible alert-info">' +
                        '<h3 class="text-primary">El centro de costos seleccionado no cuenta con insumos de limpieza</h3></div>');
                    $('#reportesinsumos').addClass('hidden');
                    $('#btn_nuevoreporte').removeClass('hidden');
                }
                else
                {
                    $('#renderdispolimpiezacostos').removeClass('hidden');
                    $('#rendertable4').append(data);
                    $('#reportesinsumos').addClass('hidden');
                    $('#btn_nuevoreporte').removeClass('hidden');
                }
            }
        });
    });



    //evento para div de dispo de herram
    $('#btn_dispoherram').click(function(){
        $.ajax({
            url:'qry_dispoherram',
            type:'post',
            datatype:'json',
            data:{bodega:$('#bodega option:selected').val()},
            success:function(data)
            {
                $('#renderdispoherram').removeClass('hidden');
                $('#renderdispoherram').append(data);
                $('#reportesinsumos').addClass('hidden');
                $('#btn_nuevoreporte').removeClass('hidden');
            }
        });
    });



    //evento para reporte de bajas de activo
    $('#bajasactivo').click(function(){
       $.ajax({
           url:'sv_bajaactivo',
           datatype:'json',
           type:'post',
           data:{bodega:$('#bodegaBA option:selected').val()},
           success:function(data)
           {
            $('#renderbajas').removeClass('hidden');
            $('#rendertablabajas').append(data);
               $('#reportesinsumos').addClass('hidden');
               $('#btn_nuevoreporte').removeClass('hidden');
           }
       });
    });



    //ver consumos
    //evento para ver consumos
    $('#btn_verconsumos').click(function(){

        var fecha = $('#fechaconsumos').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);
        var fila ='';

        desde = d;
        hasta = h;

        $.ajax({
            url:'verconsumos_historico_admin',
            datatype:'json',
            type:'post',
            data:{cc:$('#ccconsumo').val(),insumo:$('#insumoconsumo').val(),desde:moment(d).format('YYYYMMDD'),hasta:moment(h).format('YYYYMMDD')},
            success:function(data)
            {
                $('#renderdivconsumos').removeClass('hidden');

                $('#div_tabla_detalles').append(data);
            }
        }) ;
    });


    //evento para mostrar el reporte de los insumos
    $('#btn_verconsumoswithcc').click(function(){
        var fecha = $('#fechaconsumoscc').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);
        var fila ='';

        desde = d;
        hasta = h;

        desdeglobal = d;
        hastaglobal = h;


        $.ajax({
            url:'verconsumos_papeleria_all',
            datatype:'json',
            type:'post',
            data:{desde:moment(d).format('YYYYMMDD'),hasta:moment(h).format('YYYYMMDD')},
            success:function(data)
            {
                $('#renderdivconsumoscc').removeClass('hidden');

                $('#div_tabla_detallescc').append(data);
            }
        }) ;

    });


    //generar el excel de los consumos historicos de papeleria
    $('#btn_generarexcelconsumoshistoricos').click(function(){
        location.href = 'excelconsumoshistoricos?desde='+moment(desdeglobal).format('YYYYMMDD')+'&hasta='+moment(hastaglobal).format('YYYYMMDD');
    });



    //evento para cargar los insumos
    $.getJSON('obtenerinsumosall',{},function(data){
        for(var i=0;i<=data.length;i++)
        {
            insumos[i] = data[i].nombre;
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




    //generar excel
    $('#btn_generarexcelmovpape').click(function(){
        var fecha = $('#fecha').val();
        var d = fecha.substr(0,11);
        var h = fecha.substr(14,20);
       location.href = 'qry_movimiento_pape_excel?desde='+moment(d).format('YYYYMMDD')+'&hasta='+moment(h).format('YYYYMMDD')+'&cc='+$('#centrocosto option:selected').val();
    });


    //evento para generar la vista de los cambios de estados de las herramientas
    $('#estadosherramientas').click(function(){
       if($('#fecha_Estados').val()==='' || $('#bodegaEstados option:selected').val()==='')
       {
           new PNotify({
               title:'verificar',
               text:'no se aceptan campos vacios',
               type:'warning'
           });
       }
       else
       {
           var fecha = $('#fecha_Estados').val();
           var d = fecha.substr(0,11);
           var h = fecha.substr(13,20);

           console.log(moment(d).format('YYYYMMDD'));
           console.log(moment(h).format('YYYYMMDD'));

           desdeglobal = moment(d).format('YYYYMMDD');
           hastaglobal = moment(h).format('YYYYMMDD');
           bodegaglobal = $('#bodegaEstados option:selected').val();

           //evento ajax para poder mandar los parametros de busqueda
           $.ajax({
               url:'rpt_cambiosdeestadosherram',
               type:'post',
               datatype:'json',
               data:{desde:moment(d).format('YYYYMMDD'),hasta:moment(h).format('YYYYMMDD'),bodega:$('#bodegaEstados option:selected').val()},
               success:function(data)
               {
                    $('#renderestadosherram').removeClass('hidden');
                    $('#viewestadosherram').removeClass('hidden').append(data);
               }
           });

       }
    });

    //evento para poder generar el excel de los cambios de estados en las herramientas
    $('#btn_generarexcelestadosherram').click(function(){
       location.href = 'excel_cambiosestadosherram?desde='+desdeglobal+'&&hasta='+hastaglobal+'&&bodega='+bodegaglobal;
    });











});