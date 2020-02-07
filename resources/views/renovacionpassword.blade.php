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
                    Por motivos de mayor seguridad COMANDA se actualizo con un nuevo estandar de encriptación de contraseñas, para lo cual necesitamos
                    puedas crear una nueva contraseña para tu usuario por medio del siguiente formulario.
                </p>

                <div class="row">

                    <div class="col-lg-12">
                        <form class="m-t" role="form" action="index.html">
                            <label for="">Contraseña nueva:</label>
                            <div class="form-group">
                                <input type="text" id="password" class="form-control">
                            </div>

                            <label for="">Repetir contraseña:</label>
                            <div class="form-group">
                                <input type="text" id="password2" class="form-control">
                            </div>

                            <button type="button" id="btn_guardarconfiguracion" class="btn btn-primary block full-width m-b guardarinfo">Guardar contraseña</button>

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

//evento para guardar contraseñas
    $('#btn_guardarconfiguracion').click(function(){
       if($('#password').val()!=$('#password2').val())
       {
           new PNotify({
               title:'verificar',
               text:'Las contraseñas digitadas no coinciden',
               type:'warning'
           });
       }
       else
       {
           $.ajax({
              url:'contrasenamd5',
               type:'post',
               datatype:'json',
               data:{password:$('#password').val()},
               success:function(data)
               {
                  if(data=='success')
                  {
                      location.href='/';
                  }
               }
           });
       }
    });

</script>

</html>
