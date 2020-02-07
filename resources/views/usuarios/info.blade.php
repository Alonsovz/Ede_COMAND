<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>COMANDA</title>
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/typeahead.css">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="passwordBox animated fadeInLeftBig">
    <div class="row">

        <div class="col-md-12">
            <div class="ibox-content">

                <h2 class="font-bold"><strong>COMANDA - EDESAL</strong></h2>

                <p>
                    Antes de continuar nos gustaria saber un poco mas de informacion acerca de tu usuario para lo cual
                    necesitamos rellenes los siguientes campos.
                </p>

                <div class="row">

                    <div class="col-lg-12">
                        <form class="m-t" role="form" action="index.html">
                            <label for="">Departamento</label>
                            <div class="form-group">
                                <select class="form-control" name="" id="departamento">
                                    <option value="">seleccione un departamento</option>
                                    @foreach($departamentos as $d)
                                        <option value="{{$d->id}}">{{$d->nombre}}</option>
                                        @endforeach
                                </select>
                            </div>

                            <label for="">Jefe inmediato</label>
                            <div class="form-group" id="the-basics">
                                <input type="" id="jefeinmediato" class="form-control typeahead" placeholder="Digite su jefe inmediato" required="">
                            </div>

                            <button type="button" id="{{$idusuario}}" class="btn btn-primary block full-width m-b guardarinfo">Guardar informacion</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">

    </div>
</div>

</body>

<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
<!--funcion typeahead para el autocomplete de los jefes inmediatos-->
<script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
<script src='../js/plugins/typeahead.js/bloodhound.js'></script>
<script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>

<script>
    var usuarios = new Array();


    //evento para guardar informacion
    $('.guardarinfo').click(function(){

        if($('#departamento option:selected').val()==='' || $('#jefeinmediato').val()==='')
        {
            new PNotify({
                title:'verificar',
                text:'No se permiten campos vacios',
                type:'warning'
            });
        }
        else
        {
            var id =this.id;
            $.getJSON('editarinformacionuser',{usuario:id,jefeinmediato:$('#jefeinmediato').val(),
                departamento:$('#departamento option:selected').val()}, function(data) {

                if(data===true)
                {
                    new PNotify({
                        title:'muy bien',
                        text:'Informacion actualizada con exito',
                        type:'success'
                    });

                    location.href='dashboard';

                }
                else
                {
                    new PNotify({
                        title:'error',
                        text:'Ocurrio un error mientras se actualizaba la informacion',
                        type:'error'
                    });
                }
            });
        }

    });




    //obtenemos los usuarios nostaff de la base de datos
    $.getJSON('getusuariosall', function(data) {

        for(var i in data)
        {
            //llenamos el arreglo usuarios con el nombre y apellido de cada uno
            usuarios[i] = data[i].nombre+" "+data[i].apellido;
        }


    });






    /*--------------------------------------------------------------------------------
     evento para poder listar
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
</script>

</html>
