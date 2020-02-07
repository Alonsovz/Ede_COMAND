<!DOCTYPE html>
<html>
<style>
    #loaderLogin{
    -webkit-animation: 2s rotate linear infinite;
    animation: 2s rotate1 linear infinite;
    -webkit-transform-origin: 50% 50%;
    transform-origin: 50% 50%;
    }

    @keyframes rotate1 {
    0% {
        transform: rotate(0);
        animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
      }
      50% {
        transform: rotate(90deg);
        animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
      }
      100% {
        transform: rotate(180deg);
      }
    }
</style>
<head>



    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EDESAL | COMANDA</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/notie/dist/notie.min.css">
    <link rel="shortcut icon" href="../images/ticket.ico">
    <link rel="stylesheet" type="text/css" href="css/pnotify.custom.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.10.0/sweetalert2.css">


    <link rel="stylesheet" type="text/css" href="logincss/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="logincss/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="logincss/css/util.css">
	<link rel="stylesheet" type="text/css" href="logincss/css/main.css">
</head>

<body  style="
 background:url('../images/fondoApp.jpg') center center no-repeat;
    background-size:100% 100%;
">


<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form">
					<span class="login100-form-title p-b-0">
                    <img src="../images/miniLogo.png" alt=""  width="70px">
                    <h2 style="margin-top:0px;color:#03954B;"><b >COMANDA</b></h2>
					</span>
                    <hr><hr><br>
					<div class="wrap-input100 validate-input" data-validate = "Correo válido es : ejemplo@edesal.com">
						<input class="input100"type="email" id="correo">
						<span class="focus-input100" data-placeholder="Correo Electrónico"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Ingrese contraseña">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password"  id="password">
						<span class="focus-input100" data-placeholder="Contraseña"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
                            <a class="login100-form-btn" id="btn_ingresar" style="color: #fff;
                            cursor:pointer;"> 
                            Iniciar sesion
							</a>
						</div>
					</div>

					<div class="text-center p-t-40">
                    <a href="#" data-toggle="modal" data-target="#nuevacontraseña" >
                        <i class="fa fa-info-circle"></i><strong> ¿Olvidaste tu contraseña?</strong>
                    </a>
					</div>
				</form>
			</div>
		</div>
	</div>
	



    {{--MODAL PARA CAMBIO DE CONTRASEÑA--}}
<div class="modal inmodal fade" id="nuevacontraseña" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h5 class="modal-title">Restablecer contraseña</h5>
                <h2><i class="fa fa-users"></i></h2>

            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frm_insumos">
                    <div class="form-group"><label class="col-lg-2 control-label">Correo</label>
                        <div class="col-lg-9" id="the-basics">
                            <input id="correo_n" required title="Campo obligatorio" type="text" placeholder="Digite su correo" class="form-control typeahead">
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Nueva contraseña</label>
                        <div class="col-lg-9" id="the-basics">
                            <input id="password_n" required title="Campo obligatorio" type="password" placeholder="Nueva contraseña" class="form-control typeahead">
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Confirmar contraseña</label>
                        <div class="col-lg-9" id="the-basics">
                            <input id="password2_n" required title="Campo obligatorio" type="password" placeholder="Confirmar contraseña" class="form-control typeahead">
                        </div>
                    </div>

                    <div class="form-group" >
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-sm btn-primary" id="btn_guardarnuevacontraseña" type="button"><i class="fa fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" id="" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


</body>

</html>
	
<!--===============================================================================================-->
<script src="logincss/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->

	<script src="logincss/vendor/bootstrap/js/popper.js"></script>
	<script src="logincss/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="logincss/js/main.js"></script>
    <script src="js/bootjs.js"></script>
    <script src='js/funciones/login.js'></script>
    <script type="text/javascript" src='js/pnotify.custom.min.js'></script>
    <script src="https://unpkg.com/notie"></script> 
<script>
    $(document).ready(function () {
            $("form :input").attr("autocomplete", "off");

             $("#correo").focus();          
    });


    
   
    
</script>