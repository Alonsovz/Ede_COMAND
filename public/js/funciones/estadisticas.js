$(document).ready(function($){
    //variables gloabales
    var fecha               = '';
    var usuarios            = [];
    var empleado            = '';
    var departamentos       = [];
    var dep                 = '';
    var empleadoglobal      = "";
    var departamentoglobal  = "";
    var desdeglobal, hastaglobal = '';
    var empleadoglobal = '';


    //inicializamos la tabla
    $('.dataTables-example1').DataTable({


        "language": {
            "lengthMenu": " _MENU_ Solicitudes por pagina",
            "search":         "Buscar:",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando resultados _PAGE_ de _PAGES_",
            "infoEmpty": "No se encontraron resultados",
            "infoFiltered": "(Filtrados de un total de _MAX_  Solicitudes)",
            "paginate": {
                "first":      "Primero",
                "last":       "Ulitmo",
                "next":       ">",
                "previous":   "<"
            },

        }
    });

    //inicializamos
    $(function() {
        $('input[name="fecha"]').daterangepicker();
        $('input[name="fecha1"]').daterangepicker();
        $('input[name="fecha_detalle"]').daterangepicker();
        $('input[name="fecha_rptporempleado"]').daterangepicker();
        $('input[name="fecha_conteo_categoria"]').daterangepicker();
    });



    //evento para capturar las fechas
    $('#btn_generar1').click(function(){

        //capturamos el valor del input
        fecha = $('#fecha').val();

        console.log(fecha);

        ListaPubli();

    });



    //evento para capturar las fechas
    $('#btn_generar2').click(function(){

        //capturamos el valor del input
        empleado = $('#empleado').val();

        console.log(fecha);

        datosgraficobarra1();

    });


    //evento para capturar las fechas
    $('#btn_generar3').click(function(){

        //capturamos el valor del input
        departamento = $('#departamento').val();
        departamentoglobal = $('#departamento').val();

        dep = departamento;

        console.log(fecha);

        datosgraficobarra2();

    });












    /*---------------------------------------------------------------------------------------
     //contruimos el GRAFICO de pastel para los permisos solicitados por area
    -----------------------------------------------------------------------------------------*/


    //funcion para obtener datos y llenar el arreglo que necesita el grafico para ser dibujado
    function ListaPubli()
    {
        var desde = fecha.substr(0,11);
        var hasta = fecha.substr(13,20);

        console.log(desde+' '+hasta);


        $.getJSON('graficopastelareas', {desde:moment(desde).format('YYYYMMDD'),hasta:moment(hasta).format('YYYYMMDD')}, function(datos) {

            var data = [];

            $.each(datos, function(index) {
                var serie = [datos[index].name, parseInt(datos[index].conteo)];
                data.push(serie);
            });


            $('#cerrar1').click();

            //dibujamos la grafica
            DibujaGrafico(data);

        });


    }





    //funcion para dibujar grafico
    function DibujaGrafico(series) {
        $('#container').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 1,//null,
                plotShadow: false,
                width:700,
                height:700,

                // Explicitly tell the width and height of a chart
                width: null,
                height: null
            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Grafico estadistico de permisos solicitados por departamento'
            },
            subtitle: {
                text: 'Desde: '+' '+'Hasta: ',
            },
            tooltip: {

            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format:'<b>{point.name}</b>: {point.y}',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Permisos',
                data: series
            }]
        });
    }

    /*--------------------------------------------------------------------------------------------------------
    ----------------------------------------------------------------------------------------------------------*/










    /*---------------------------------------------------------------------------------------
     //contruimos el GRAFICO de barra para los permisos de empleado historico 6 meses
     -----------------------------------------------------------------------------------------*/


    //funcion para obtener datos y llenar el arreglo que necesita el grafico para ser dibujado
    function datosgraficobarra1()
    {
        empleadoglobal = $('#empleado').val();

        $.getJSON('graficobarraempleado', {empleado:$('#empleado').val()}, function(datos) {

            $('#cerrar2').click();

            //dibujamos la grafica
            DibujaGrafico1(datos);

        });


    }




    //generar el grafico para el conteo de los permisos por categoria solicitados por el empleado en un rango de fechas
    $('#btn_generar_conteo_categoria').click(function(){

        var fecha = $('#fecha_conteo_categoria').val();

        var desde = fecha.substr(0,11);
        var hasta = fecha.substr(13,20);

        console.log(desde+' '+hasta);


        //get json
        $.getJSON('graph_conteoXcategoria',{desde:moment(desde).format('YYYYMMDD'),hasta:moment(hasta).format('YYYYMMDD'),empleado:$('#empleado_conteo_categoria').val()},function(datos){

            DibujarGraficaConteoXCategoria(datos);
            $('#cerrar1').click();
        });
    });


    //funcion para graficar el conteo de permisos por categoria
    function DibujarGraficaConteoXCategoria(datos)
    {
        var categorias = [];
        var conteo = [];

        $.each(datos,function(index){

            categorias.push(datos[index].name);
            conteo.push(parseInt(datos[index].conteo));

        });

        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Conteo de permisos por categoria '
            },
            credits: {
                enabled: false
            },
            subtitle: {
                text: 'Año: 2018'
            },
            xAxis: {
                categories: categorias,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Conteo (permisos)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{point.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.4,
                    borderWidth: 0
                }
            },
            series: [{
                "colorByPoint": true,
                name: 'Permisos',
                data:  conteo



            }]
        });
    }


    //funcion para dibujar grafico
    function DibujaGrafico1(datos) {


        //variable para almacenar los meses de la consulta
        var meses  = [];
        var conteo = [];
        var empleado = "";

        $.each(datos,function(index){

            meses.push(datos[index].name);
            conteo.push(parseInt(datos[index].conteo));
            empleado = datos[index].nombre+" "+datos[index].apellido;
        });

        console.log(conteo);
        console.log(meses);

        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafico historico de permisos solicitados por '+empleadoglobal
            },
            credits: {
                enabled: false
            },
            subtitle: {
                text: 'Año: 2018'
            },
            xAxis: {
                categories: meses,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Conteo (permisos)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.4,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Permisos',
                data:  conteo



            }]
        });
    }

    /*--------------------------------------------------------------------------------------------------------
     ----------------------------------------------------------------------------------------------------------*/







    /*---------------------------------------------------------------------------------------
     //contruimos el GRAFICO de barra para los permisos por area
     -----------------------------------------------------------------------------------------*/


    //funcion para obtener datos y llenar el arreglo que necesita el grafico para ser dibujado
    function datosgraficobarra2()
    {

        $.getJSON('graficotipospermisos', {departamento:$('#departamento').val()}, function(datos) {

            $('#cerrar3').click();

            //dibujamos la grafica
            DibujaGrafico2(datos);

        });


    }





    //funcion para dibujar grafico
    function DibujaGrafico2(datos) {


        //variable para almacenar los meses de la consulta
        var meses  = [];
        var conteo = [];

        $.each(datos,function(index){

            meses.push(datos[index].name);
            conteo.push(parseInt(datos[index].conteo));
        });

        console.log(conteo);
        console.log(meses);

        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafico historico de permisos solicitados en el presente año'
            },
            credits: {
                enabled: false
            },
            subtitle: {
                text: 'Año: 2018 - Area: '+dep
            },
            xAxis: {
                categories: meses,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Conteo (permisos)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.4,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Permisos',
                data:  conteo



            }]
        });
    }

    /*--------------------------------------------------------------------------------------------------------
     ----------------------------------------------------------------------------------------------------------*/





    //generar reporte de detalle de los permisos solicitados
    $('#btn_generardetalle').click(function(){
        $('#detalles').empty();
        var fecha = $('#fecha_detalle').val();
        var desde = fecha.substr(0,11);
        var hasta = fecha.substr(13,20);

        hastaglobal = hasta;
        desdeglobal = desde;

        console.log(desde+' '+hasta);
        $.ajax({
            url:'rpt_detallepermisos',
            data:{desde:moment(desde).format('YYYYMMDD'),hasta:moment(hasta).format('YYYYMMDD')},
            datatype:'json',
            type:'post',
            success:function(data)
            {
                $('#iboxdetalles').removeClass('hidden');
                $('#detalles').append(data);
                $('#btn_generarpdfdetalle').addClass('hidden');
                $('#btn_generarexceldetalle').removeClass('hidden');

            },error:function()
            {
                var alerta = '<div class="alert alert-danger">Error al generar reporte</div>'

                $('#detalles').append(alerta);
            }
        });
    });


    //evento para generar el PDF del detalle de los permisos solicitados por empleado
    $('#btn_generarpdfdetalle').click(function(){
        location.href = 'pdf_detalleporempleado?desde='+moment(desdeglobal).format('YYYYMMDD')+'&&hasta='+moment(hastaglobal).format('YYYYMMDD')+'&&empleado='+empleadoglobal;

    });



    //generar excel del detalle de los permisos solicitados
    $('#btn_generarexceldetalle').click(function(){
        location.href = 'excel_detallepermisos?desde='+moment(desdeglobal).format('YYYYMMDD')+'&&hasta='+moment(hastaglobal).format('YYYYMMDD');

    });



    //generar el reporte para el detalle de los permisos solicitados por empleado
    $('#btn_generarreporteporempleado').click(function(){

        var fecha = $('#fecha_rptporempleado').val();
        var desde = fecha.substr(0,11);
        var hasta = fecha.substr(13,20);

        desdeglobal = desde;
        hastaglobal = hasta;

        empleadoglobal = $('#empleadorpt').val();


       $.ajax({
           url:'rpt_permisosdetalleporempleado',
           datatype:'json',
           type:'post',
           data:{desde:moment(desde).format('YYYYMMDD'),hasta:moment(hasta).format('YYYYMMDD'),empleado:$('#empleadorpt').val()},
           success:function(data)
           {
               $('#iboxdetalles').removeClass('hidden');
               $('#detalles').append(data);
               $('#btn_generarexceldetalle').addClass('hidden');
               $('#btn_generarpdfdetalle').removeClass('hidden');
           },
           error:function()
           {
               var alerta = '<div class="alert alert-danger">Error al generar reporte</div>'

               $('#detalles').append(alerta);
           }
       });
    });


    /*-----------------------------------------------------------------
    AUTOCOMPLETE DE LOS USUARIOS
    -----------------------------------------------------------------*/

    //obtenemos los usuarios de jefatura de la base de datos
    $.getJSON('getusuariosall', function(data) {

        for(var i in data)
        {
            //llenamos el arreglo usuarios con el nombre y apellido de cada uno
            usuarios[i] = data[i].nombre+" "+data[i].apellido;
        }

        console.log(usuarios);

    });

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





    /*-----------------------------------------------------------------
     AUTOCOMPLETE DE LOS DEPARTAMENTOS
     -----------------------------------------------------------------*/

    //obtenemos los usuarios de jefatura de la base de datos
    $.getJSON('departamentos', function(data) {

        for(var i in data)
        {
            //llenamos el arreglo
            departamentos[i] = data[i].nombre;
        }

        console.log(usuarios);

    });

    var substringMatcher1 = function(strs) {
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



    $('#the-basics1 .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'departamentos',
            source: substringMatcher1(departamentos)
        });


});//fin de ready