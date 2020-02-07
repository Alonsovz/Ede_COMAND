<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>COMANDA</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/ticket.ico">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <style>
        body{
            color: black;
        }
    </style>

    
    @yield('css')


    <script src="js/angular/angular.js"></script>
    <script src="js/funciones/app.js"></script>
    <script src="js/funciones/ng.js"></script>



</head>

<body class="" ng-app="comanda">

<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation"
    style="position: fixed;                         
                                max-height: 100%;
                                overflow-x: auto;">
        <div class="sidebar-collapse">
                 <ul class="nav metismenu" id="side-menu" >
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                                <span>
                                   @if(Session::get('avatar')=='')
                                        <img alt="image" class="img-circle" src="../images/avatar.png" height="80" width="80" />       
                                    @else
                                        <img alt="image" class="img-circle" src="{{Session::get('avatar')}}" height="80" width="80" />
                                    @endif
                                 </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{Session::get('nombreusuario')}}</strong>
                                 </span> <span class="text-muted text-xs block">comanda <b class="caret"></b></span> </span> </a>
                            <ul ng-controller="ngController" class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="miperfil">Mi perfil </a></li> 
                                <li><a href="">Tickets</a></li>
                                <li><a href="">Permisos</a></li>
                                <li class="divider"></li>
                                <li><a href="cerrarsesion">Cerrar Sesion</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            <img src="../images/atom.png" width="60" height="60">
                        </div>
                    </li>
                   

                   @foreach(Session::get('roles') as $rol)
                 @if($rol->nombre=="staff")
                        <li>
                            <a href=""><i class="fa fa-tachometer"></i> <span class="nav-label">Administracion</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="miperfil">Mi perfil </a></li>
                                <li><a href="usuarios"> Usuarios</a></li>
                                <li><a href="sistemas">Sistemas</a></li>
                                <li><a href="modulos">Modulos</a></li>
                            </ul>   
                        </li>
                        <li>
                            <a href="procesoerogaciones"><i class="fa fa-money"></i> <span class="nav-label">Erogaciones</span></a>
                          
                        </li>

                        <li>
                            <a href="telefonos"><i class="fa fa-phone"></i> <span class="nav-label">Telefonos</span></a>
                            
                        </li>
                        <li>
                            <a href=""><i class="fa fa-dropbox"></i> <span class="nav-label">Activos</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" >
                                <li><a href="indexactivos">Mis activos </a></li>
                                <li><a href="indextraslados">Traslados </a></li>
                            </ul>
                        </li>
                <li>
                    <a href="tck_edesalshow"><i class="fa fa-ticket"></i> <span class="nav-label">Tickets</span>  <span class="pull-right label label-primary">{{Session::get('conteostaff')}}</span></a>
                  
                </li>

                <li>
                    <a href="mibitacora"><i class="fa fa-file-text-o"></i><span class="nav-label">Bitacoras</span><span class="label label-warning pull-right"></span></a>
                    
                </li>

                <li>
                    <a href="#"><i class="ion-heart"></i> <span class="nav-label"> Permisos</span><span class="label label-warning pull-right"></span></a>
                        <ul class="nav nav-second-level collapse">
                        <li><a href="permisosempleados">Mis permisos</a></li>
                        <li><a href="indexpermisos">Nuevo permiso</a></li>
                        
                        
                    </ul>
                </li>


                <li>
                    <a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Reserva de Vehiculos</span><span class="label label-warning pull-right"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="misreservas">Mis reservas</a></li>
                        <li><a href="vh_index">Nueva reserva</a></li>
                       

                    </ul>
                </li>


                <li>
                    <a href=""><i class="fa fa-bar-chart"></i> <span class="nav-label">Estadisticas</span><span class="label label-warning pull-right"></span></a>
                    <ul class="nav nav-second-level collapse" >
                        <li><a href="">Generar estadisticas</a></li>
                      
                    </ul>
                </li>
                
                <li>
                    <a href=""><i class="fa fa-file-text"></i> <span class="nav-label">
                        Procedimientos y Políticas
                    </span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="politicas">Consulta</a></li>
                        <li><a href="tablaControl">Gestión</a></li>
                    </ul>
                </li>
                

                @elseif($rol->nombre=='jefatura')
                <li>
                    <a href=""><i class="fa fa-university"></i> <span class="nav-label">Jefatura</span><span class="label label-warning pull-right"></span></a>
                    <ul class="nav nav-second-level collapse" >
                        <li><a href="permisosjefatura">Ausencia Laboral</a></li>
                        <li><a href="reservasjefatura">Reservas de Vehiculos</a></li>
                        <li><a href="supervisiontickets">Supervision de tickets</a></li>
                        <li><a href="indexactivosjefe">Activos</a></li>

                    </ul>
                </li>


                    @elseif($rol->nombre=='contabilidad' )
                        <li>
                            <a href=""><i class="fa fa-dollar"></i> <span class="nav-label">Contabilidad</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse" >
                                <li><a href="mantenimiento_ins">Insumos</a></li>
                                <li><a href="conta_bajas">Bajas</a></li>



                            </ul>
                        </li>

                    @elseif($rol->nombre=='super_activos' )
                        <li>
                            <a href=""><i class="fa fa-university"></i> <span class="nav-label">Supervisor de Activos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse" >
                                <li><a href="indexsuperactivos">Activos</a></li>
                                <li><a href="validacionactitovs">Validaciones</a></li>
                                <li class="">
                                    <a href="#">Kilometraje <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level collapse" style="height: 0px;">

                                        <li>
                                            <a href="km_indexreportes">Reportes</a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>

               @elseif($rol->nombre=='rrhh')
                <li>
                    <a href=""><i class="fa fa-university"></i><span class="nav-label">RRHH</span><span class="label label-warning pull-right"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="permisosrrhh">Solicitudes </a></li>
                        <li><a href="estadisticas">Estadisticas</a></li>
                    </ul>
                </li>

                        <li>
                            <a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Reserva de Vehiculos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse" >
                                <li><a href="misreservas">Mis reservas</a></li>
                                <li><a href="vh_index">Nueva reserva</a></li>
                               
                            </ul>
                        </li>

                    @elseif($rol->nombre=='vh_dueño' )
                        <li>
                            <a href=""><i class="fa fa-automobile"></i> <span class="nav-label">Vehiculos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="autorizacionvehiculos">Mis vehiculos</a></li>

                                    <li>
                                        <a href="dueñokilometraje">Kilometraje</a>
                                    </li>


                            </ul>
                        </li>

                @elseif($rol->nombre=='nostaff')
                <li>
                    <a href=""><i class="fa fa-tachometer"></i> <span class="nav-label">Administracion</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" >
                        <li><a href="miperfil">Mi perfil </a></li>

                    </ul>

                </li>

                        <li>
                        <a href="procesoerogaciones"><i class="fa fa-money"></i> <span class="nav-label">Erogaciones</span></a>
                        </li>
                        <li>
                            <a href=""><i class="fa fa-users"></i> <span class="nav-label">Informatica</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="procesosinformatica"> Ver</a></li>
                                <li><a href=""></a></li>
                            </ul>
                        </li>

                        <li>
                        <a href="telefonos"><i class="fa fa-phone"></i> <span class="nav-label">Telefonos</span></a>
                        </li>

                        <li>
                    <a href=""><i class="fa fa-dropbox"></i> <span class="nav-label">Activos</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" >
                        <li><a href="indexactivos">Mis activos </a></li>
                        <li><a href="indextraslados">Traslados </a></li>
                    </ul>

                </li>
                <li>
                <a href="tck_edesalshow"><i class="fa fa-ticket"></i> <span class="nav-label">Tickets</span>  </a>
                </li>
                <li>
                    <a href=""><i class="ion-heart"></i> <span class="nav-label"> Permisos</span><span class="label label-warning pull-right"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="permisosempleados">Mis permisos</a></li>
                        <li><a href="indexpermisos">Nuevo permiso</a></li>
                        @if($rol->nombre=="jefatura")
                            <li><a href="">Solicitudes</a></li>
                        @endif
                    </ul>
                </li>

                        <li>
                            <a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Reserva de Vehiculos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="misreservas">Mis reservas</a></li>
                                <li><a href="vh_index">Nueva reserva</a></li>
                               


                            </ul>
                        </li>

                    @elseif($rol->nombre=='super_enr')
                        <li>
                            <a href="#"><i class="fa fa-money"></i> <span class="nav-label"> ENR</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="indexenr">1. Nuevo calculo</a></li>
                                <li><a href="">2. Historico</a></li>
                            </ul>
                        </li>

                    @elseif($rol->nombre=='mantenimiento_vh')
                        <li>
                            <a href="#"><i class="fa fa-car"></i> <span class="nav-label"> Mantenimientos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="fichamantenimiento">1. Nuevo mtto</a></li>
                                <li><a href="">2. Administración</a></li>
                            </ul>
                        </li>


                    @elseif($rol->nombre=='vh_supervisor')
                        <li>
                            <a href=""><i class="fa fa-child"></i><span class="nav-label">Supervisor de vehiculos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="vhadminreservas">Solicitudes</a></li>
                                <li><a href="estadisticasvh">Estadisticas</a></li>
                                <li class="">
                                    <a href="#">Kilometraje <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level collapse" style="height: 0px;">
                                        <li>
                                            <a href="indexkilometraje">Nuevo</a>
                                        </li>
                                        <li>
                                            <a href="showkilometraje">Edición</a>
                                        </li>
                                        <li>
                                            <a href="km_indexreportes">Reportes</a>
                                        </li>

                                    </ul>
                                </li>



                            </ul>
                        </li>

                        {{--MENU PARA LA ADMINISTRACION DE LAS OFERTAS PRESENTADAS A CLIENTES--}}
                    @elseif($rol->nombre=='admin_ofertas')
                        <li>
                            <a href=""><i class="fa fa-money"></i> <span class="nav-label">Control de ofertas</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="nuevaoferta">Nueva oferta</a></li>
                                <li><a href="verofertas">Ver ofertas</a></li>
                            </ul>
                        </li>

                    @elseif($rol->nombre=='supervisor_ins' || $rol->nombre=='admin_ins')
                        <li>
                            <a href=""><i class="fa fa-archive"></i> <span class="nav-label">Insumos</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if($rol->nombre=='supervisor_ins')
                                    <li><a href="nuevarequisicion">Nueva requisicion </a></li>
                                    <li><a href="rq_bandejasuperv">Mis requisiciones</a></li>
                                    <li><a href="index_mov_superv">Centros de costos</a></li>
                                    <li><a href="mibodega">Bodegas</a></li>
                                    <li><a href="inventarioinicial">Inventario inicial</a></li>
                                @endif

                                @if($rol->nombre=='admin_ins')
                                        <li><a href="nuevarequisicion">Nueva requisicion </a></li>
                                        <li><a href="rq_bandejasuperv">Mis requisiciones</a></li>
                                    <li><a href="rq_bandejaadmin">Requisiciones</a></li>
                                    <li><a href="ord_bandejaadmin">Ordenes de compra</a></li>
                                    <li><a href="getcentroscostos">Centros de costos</a></li>
                                    <li><a href="getviewbodegas">Bodegas</a></li>
                                        <li><a href="mantenimiento_ins">Mantenimientos</a></li>

                                    <li><a href="indexreportes">Reportes</a></li>
                                    @endif

                            </ul>
                        </li>

                    @elseif($rol->nombre=='gerencia')
                        <li>
                            <a href=""><i class="fa fa-file-text"></i> <span class="nav-label">Gerencia</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="indexreportes">Reportes insumos</a></li>
                                <li><a href="km_indexreportes">Kilometrajes</a></li>
                            </ul>
                        </li>


                @elseif($rol->nombre=='gestion_docs')
                <li>
                    <a href=""><i class="fa fa-file-text"></i> <span class="nav-label">
                    Procedimientos y Políticas
                    </span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="politicas">Consulta</a></li>
                        <li><a href="tablaControl">Gestión</a></li>
                    </ul>
                </li>

                @else
                <li>
                    <a href=""><i class="fa fa-file-text"></i> <span class="nav-label">
                    Procedimientos y Políticas
                    </span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="politicas">Consulta</a></li>
                    </ul>
                </li>
                @endif

                

                

              @endforeach
              
              

                
            </ul>

        </div>
    </nav>
    

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0; height: 100px; background-image:  url('images/headerdash4.jpg'); background-size: 100%   ">        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-warning "
            style="background-color: #FA491E; color:white;" href="#"><i class="fa fa-bars"></i> MENÚ </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">
                
            </form>
        </div>
    
            <ul class="nav navbar-top-links navbar-right ">


                <li class="dropdown hidden">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages hidden">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">

                                </a>
                                <div class="media-body">
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">

                                </a>
                                <div class="media-body ">
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">

                                </a>
                                <div class="media-body ">
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown hidden">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-ticket"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>

                <li>

                </li>
            </ul>

            

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>@yield('enunciado')</h2>
                    <ol class="breadcrumb">
                        <li>
                            COMANDA 
                        </li>
                        <li>
                            <a href="">@yield('modulo')</a>
                        </li>
                        <li>
                            <a href="">@yield('submodulo')</a>
                        </li>
                        
                    </ol>
                </div>

                <div class="col-sm-8 " style="padding-top: 40px">
                    <button type="button" onclick="location.href='dashboard'" style="margin-left: 5px" class="pull-right btn btn-sm btn-default"><i class="fa fa-home" ></i> Inicio</button>
                    <button type="button" onclick="location.reload()" style="margin-left: 5px" class="pull-right btn btn-sm btn-default"><i class="fa fa-refresh" ></i> Actualizar</button>
                    <button onclick="location.href='cerrarsesion'" type="button" class="pull-right btn btn-default btn-sm"><i class="fa fa-sign-out"></i> Cerrar Sesion</button>
                </div>
               
            </div>

            <div class="wrapper wrapper-content">
                @yield('contenido')
                
            </div>
            <div class="footer" style="background-color: transparent;">
                

                

            </div>

        </div>
        </div>












    <!-- Mainly scripts -->

    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    
    <script src="js/plugins/pace/pace.min.js"></script>

    <script src="js/plugins/fullcalendar/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>



    <!--funciones para el lenguaje de las datatables-->

    @yield('scripts')


</body>

</html>
