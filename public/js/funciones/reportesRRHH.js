$(document).ready(function(){

    var usuarios = new Array();
    var desdeglobal,hastaglobal;

//inicializamos
    $(function() {
        $('input[name="parametros1"]').daterangepicker();

    });




    //mostrar parametros para reporte 1
    $('#rpt_cantidadpermisosempleado').click(function(){

        $('#frm_reporte1').removeClass('hidden');

    });

    //cancelar parametrizacion
    $('.cancelarparametrizacion').click(function(){
       $('.ocultar').addClass('hidden');
    });


    //obtenemos los usuarios de jefatura de la base de datos
    $.getJSON('getusuariosall', function(data) {

        for(var i in data)
        {
            //llenamos el arreglo usuarios con el nombre y apellido de cada uno
            usuarios[i] = data[i].nombre+" "+data[i].apellido;
        }

        console.log(usuarios);

    });


    //generar el grafico de cantidad de permisos por empleado segun categorias
    $('#btn_generarreporteporempleado').click(function(){
        var fecha = $('#parametros1').val();

        var desde = fecha.substr(0,11);
        var hasta = fecha.substr(13,20);

        var D = moment(desde).format('YYYYMMDD');
        var H = moment(hasta).format('YYYYMMDD');

        console.log(D+' '+H);

        desdeglobal = D;
        hastaglobal = H;

        location.href='rpt_detallepermisos?empleado='+$('#empleado').val()+'&&desde='+D+'&&hasta='+H;
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


});