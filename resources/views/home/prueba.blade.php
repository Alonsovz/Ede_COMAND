<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>COMANDA</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/ticket.ico">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <style>
        body{
            color:black;
        }
    </style>


    @yield('css')

</head>

<body class="">

<div id="wrapper">


    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">



            <ul class="nav metismenu" id="side-menu">

                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span>
                            @if(Session::get('avatar')=='')
                                <img alt="image" class="img-circle" src="../images/avatar.png" height="80" width="80" />
                            @else
                                <img alt="image" class="img-circle" src="../{{Session::get('avatar')}}" height="80" width="80" />
                            @endif

                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{Session::get('nombreusuario')}}</strong>
                             </span> <span class="text-muted text-xs block">comanda <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="">Mi perfil</a></li>
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
                @foreach($roles as $rol)
                    @if($rol->nombre=="staff")
                        <li>
                            <a href="i"><i class="fa fa-tachometer"></i> <span class="nav-label">Administracion</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="miperfil">Mi perfil </a></li>
                                <li><a href="usuarios"> Usuarios</a></li>
                                <li><a href="sistemas">Sistemas</a></li>
                                <li><a href="modulos">Modulos</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="fa fa-dropbox"></i> <span class="nav-label">Activos</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="indexactivos">Mis activos </a></li>
                                <li><a href="indextraslados">Traslados </a></li>
                            </ul>

                        </li>
                        <li>
                            <a href="#"><i class="fa fa-ticket"></i> <span class="nav-label">Tickets</span>  <span class="pull-right label label-primary">{{Session::get('conteostaff')}}</span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="tck_edesalindex">Nuevo ticket</a></li>
                                <li><a href="tck_edesalshow">Recibidos</a></li>
                                <li><a href="tck_solicitadosedesal">Solicitados</a></li>

                            </ul>
                        </li>


                        <li>
                            <a href="mailbox.html"><i class="fa fa-file-text-o"></i> <span class="nav-label">Bitacoras</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="mibitacora">Mi bitacora</a></li>

                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="ion-heart"></i> <span class="nav-label"> Permisos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="permisosempleados">1. Mis permisos</a></li>
                                <li><a href="indexpermisos">2. Nuevo permiso</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-car"></i> <span class="nav-label">Reserva de Vehiculos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="misreservas">1. Mis reservas</a></li>
                                <li><a href="vh_index">2. Nueva reserva</a></li>
                                <li style="list-style: none"><a style="color:white" href="solicitudesmto">3. Solicitudes de mantenimiento</a></li>
                            </ul>
                        </li>



                        <li>
                            <a href=""><i class="fa fa-bar-chart"></i> <span class="nav-label">Estadisticas</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="">Generar estadisticas</a></li>

                            </ul>
                        </li>



                    @elseif($rol->nombre=='jefatura' )
                        <li>
                            <a href=""><i class="fa fa-university"></i> <span class="nav-label">Jefatura</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="permisosjefatura">1. Ausencia Laboral</a></li>
                                <li><a href="supervisiontickets">2. Supervision de tickets</a></li>
                                <li><a href="reservasjefatura">3. Reservas de Vehiculos</a></li>
                                <li><a href="supervisiontickets">4. Supervision de tickets</a></li>
                                <li><a href="indexactivosjefe">5. Activos</a></li>
                            </ul>
                        </li>

                    @elseif($rol->nombre=='contabilidad' )
                        <li>
                            <a href=""><i class="fa fa-dollar"></i> <span class="nav-label">Contabilidad</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="mantenimiento_ins">1. Insumos</a></li>
                                <li><a href="conta_bajas">Bajas de Oficina</a></li>

                            </ul>
                        </li>

                    @elseif($rol->nombre=='super_activos' )
                        <li>
                            <a href=""><i class="fa fa-user-secret"></i> <span class="nav-label">Supervisor de Activos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="indexsuperactivos">1. Activos</a></li>
                                <li><a href="validacionactitovs">2. Validaciones</a></li>
                                <li class="">
                                    <a href="#">3. Kilometraje <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level collapse" style="height: 0px;">

                                        <li>
                                            <a href="km_indexreportes">Reportes</a>
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </li>

                    @elseif($rol->nombre=='vh_dueño' )
                        <li>
                            <a href=""><i class="fa fa-automobile"></i> <span class="nav-label">Vehiculos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="autorizacionvehiculos">1. Mis vehiculos</a></li>
                                <li>
                                    <a href="dueñokilometraje">2. Kilometraje</a>
                                </li>
                            </ul>
                        </li>





                    @elseif($rol->nombre=='nostaff')
                        <li>
                            <a href=""><i class="fa fa-tachometer"></i> <span class="nav-label">Administracion</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="miperfil">Mi perfil </a></li>
                                <li><a href=""></a></li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="fa fa-dropbox"></i> <span class="nav-label">Activos</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="indexactivos">Mis activos </a></li>
                                <li><a href="indextraslados">Traslados </a></li>
                            </ul>

                        </li>
                        <li>
                            <a href="#"><i class="fa fa-ticket"></i> <span class="nav-label">Tickets</span>  <span class="pull-right label label-primary"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="tck_edesalindex">1. Nuevo ticket</a></li>
                                <li><a href="tck_solicitadosedesal">2. Solicitados</a></li>
                                <li><a href="tck_edesalshow">3. Recibidos</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href=""><i class="ion-heart"></i> <span class="nav-label"> Permisos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="permisosempleados">1. Mis permisos</a></li>
                                <li><a href="indexpermisos">2. Nuevo permiso</a></li>
                                @if($rol->nombre=="jefatura")
                                    <li><a href="">3. Solicitudes</a></li>
                                @endif

                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Reserva de Vehiculos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="misreservas">1. Mis reservas</a></li>
                                <li><a href="vh_index">2. Nueva reserva</a></li>
                                <li style="list-style: none"><a style="color:white" href="solicitudesmto">3. Solicitudes de mantenimiento</a></li>


                            </ul>
                        </li>

                    @elseif($rol->nombre=='superv_postes')
                        <li>
                            <a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Actualizaciones</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="posteindex">1. Postes</a></li>
                                <li><a href="">2. Arrendados</a></li>
                                <li><a href="">3. Luminarias</a></li>


                            </ul>
                        </li>

                    @elseif($rol->nombre=='vh_supervisor')
                        <li>
                            <a href=""><i class="fa fa-child"></i><span class="nav-label">Supervisor de vehiculos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="vhadminreservas">1. Solicitudes</a></li>
                                <li><a href="estadisticasvh">2. Estadisticas</a></li>
                                <li class="">
                                    <a href="#">3. Kilometraje <span class="fa arrow"></span></a>
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

                    @elseif($rol->nombre=='rrhh')
                        <li>
                            <a href=""><i class="fa fa-university"></i><span class="nav-label">RRHH</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="permisosrrhh">1. Solicitudes </a></li>
                                <li><a href="estadisticas">2. Estadisticas</a></li>

                            </ul>
                        </li>


                    @elseif($rol->nombre=='supervisor_ins' || $rol->nombre=='admin_ins')
                        <li>
                            <a href=""><i class="fa fa-archive"></i> <span class="nav-label">Insumos</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if($rol->nombre=='supervisor_ins')

                                    <li><a href="nuevarequisicion">1. Nueva requisicion </a></li>
                                    <li><a href="rq_bandejasuperv">2. Mis requisiciones</a></li>
                                    <li><a href="index_mov_superv">3. Centros de costos</a></li>
                                    <li><a href="mibodega">4. Bodegas</a></li>
                                    <li><a href="inventarioinicial">5. Inventario inicial</a></li>
                                @endif

                                @if($rol->nombre=='admin_ins')
                                    <li><a href="nuevarequisicion">1. Nueva requisicion </a></li>
                                    <li><a href="rq_bandejasuperv">2. Mis requisiciones</a></li>
                                    <li><a href="rq_bandejaadmin">3. Requisiciones</a></li>
                                    <li><a href="ord_bandejaadmin">4. Ordenes de compras</a></li>
                                    <li><a href="getcentroscostos">5. Centros de costos</a></li>
                                    <li><a href="getviewbodegas">6. Bodegas</a></li>
                                    <li><a href="mantenimiento_ins">7. Mantenimientos</a></li>
                                    <li><a href="indexreportes">8. Reportes</a></li>
                                @endif

                            </ul>
                        </li>
                    @endif




                @endforeach

            </ul>

        </div>
    </nav>


    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0; height: 100px; background-image:  url('images/headerdash6.jpg'); background-size: 100%   ">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" action="search_results.html">

                    </form>
                </div>

                <ul class="nav navbar-top-links navbar-right">

                </ul>



            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>@yield('modulo')</h2>
                <ol class="breadcrumb">
                    <li>
                        COMANDA
                    </li>
                    <li>
                        <a href="index.html">@yield('modulo')</a>
                    </li>
                    <li>
                        <a href="">@yield('submodulo')</a>
                    </li>


                </ol>

            </div>

            <div class="col-sm-8 " style="padding-top: 10px">
                <button type="button" onclick="location.reload()" style="margin-left: 5px" class="pull-right btn btn-sm btn-info"><i class="fa fa-refresh" ></i> Actualizar</button>
                <button onclick="location.href='cerrarsesion'" type="button" class="pull-right btn btn-danger btn-sm"><i class="fa fa-sign-out"></i> Cerrar Sesion</button>
            </div>

        </div>

        <div class="wrapper wrapper-content" >
            @yield('contenido')
            <div class="row">
                <div class="jumbotron" >
                    <div class="container" >

                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title" style="background-color: deepskyblue;">
                                    <h2><i class="fa fa-ticket"></i> Servicios y Req. / En proceso de TI</h2>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        @foreach($ticketsproceso as $t)
                                            <div class="col-md-3">
                                                <div class="ibox" style="border: solid 1px lightgrey">
                                                    <div class="ibox-title" style="background-color: white">
                                                        <h3 style="color:black" class="text-left"><i class="fa fa-user"></i> <strong>{{$t->empleado}}</strong></h3>
                                                        <div class="ibox-tools">
                                                        </div>
                                                    </div>
                                                    <div class="ibox-content" style="height: 100px;">

                                                        <strong>{{$t->conteo}}</strong> tickets en proceso...<br><br>
                                                        <button style="border:solid black 1px;" id="{{$t->idusuario}}" class=" ticketdetalle btn btn-xs  btn-default"><i class="fa fa-ticket"></i> <strong>  tickets</strong></button>
                                                        <button style="border:solid black 1px;" id="{{$t->idusuario}}" class=" pull-right btn btn-xs bitacoradetalle  btn-default"><i class="fa fa-file-text"></i> <strong>  bitacoras</strong></button>
                                                    </div>


                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <button class="hidden btn btn-default btn-outline btn-lg" id="ocultar"><i class="fa fa-angle-up"></i> Ocultar</button>
                                        </div>
                                    </div>
                                </div>

                                <div style="height: 400px; overflow: scroll; overflow-x: hidden" class="ibox-footer hidden " id="footer">

                                    <br><br>
                                </div>
                            </div>
                        </div>
                        <br> <br><br>
                        <img src="../images/finance3.png" alt="" >



            <div class="row">
                <div class="col-lg-4" >
                    <div class="widget-head-color-box navy-bg p-lg text-center" style="border: lightgrey solid 1px;" >
                        <div class="m-b-md">
                            <h2 class="font-bold no-margins">
                                {{Session::get('nombreusuario')}}
                            </h2>
                            <small>EDESAL</small>
                        </div>
                        @if(Session::get('avatar')=='')
                            <i class="fa fa-5x fa-user"></i>
                            <i class=""></i>

                        @else
                            <img alt="image" class="img-circle" src="../{{Session::get('avatar')}}" height="80" width="80" />
                        @endif

                        <div>
                            @foreach($roles as $rol)
                                <span>{{$rol->nombre}}</span> |
                            @endforeach
                        </div>
                    </div>
                    <div class="widget-text-box" style="border: lightgrey solid 1px;">
                        <h4 class="media-heading"></h4>
                        <p></p>
                        <div class="text-right">
                            <a href="miperfil" class="btn btn-md btn-info"><i class="fa fa-user"></i> Mi perfil </a>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1 yellow-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> <b>TICKETS</b> </span><br>
                                <ul style="margin-top: 5px; ">
                                    <li style="list-style: none"><a  style="color: white; " href="tck_edesalindex">Nuevo ticket</a></li>
                                    <li style="list-style: none"><a style="color:white; " href="tck_edesalshow">Recibidos</a></li>
                                    <li style="list-style: none"><a style="color:white; " href="tck_solicitadosedesal">Solicitados</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1" style="background-color: #f7ff94; color: black ">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-heart-o fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> <b>PERMISOS</b> </span><br>
                                <ul style="margin-top: 5px; ">
                                    <li style="list-style: none"><a style="color: black" href="indexpermisos">Nuevo permiso</a></li>
                                    <li style="list-style: none"><a style="color:black" href="permisosempleados">Mis permisos</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1 blue-bg ">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-car fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> <b>RESERVAS DE VEHICULOS</b> </span><br>
                                <ul style="margin-top: 5px; ">
                                    <li style="list-style: none"><a style="color: white" href="vh_index">Nueva reserva</a></li>
                                    <li style="list-style: none"><a style="color:white" href="misreservas">Mis reservas</a></li>
                                    <li style="list-style: none"><a style="color:white" href="solicitudesmto">Solicitudes de mantenimiento</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5><i class="fa fa-dollar"></i> Centro de costos </h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>


                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">

                                <div class="table-responsive">
                                    <table class="table table-striped  dataTables-example1 table-hover dataTables-example" >
                                        <thead>
                                        <tr>
                                            <th>CC</th>
                                            <th>Nombre</th>
                                            <th class="hidden">Platform(s)</th>
                                            <th class="hidden">Engine version</th>
                                            <th class="hidden">CSS grade</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($centrocostos as $cc)
                                            <tr>
                                                <td>{{$cc->id}}</td>
                                                <td>{{$cc->nombre}}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot class="hidden">
                                        <tr>
                                            <th>Rendering engine</th>
                                            <th>Browser</th>
                                            <th>Platform(s)</th>
                                            <th>Engine version</th>
                                            <th>CSS grade</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5><i class="fa fa-phone"></i>  Extensiones</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>

                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">

                                <div class="table-responsive">
                                    <table class="table table-striped  dataTables-example1 table-hover dataTables-example" >
                                        <thead>
                                        <tr>
                                            <th>Extension</th>
                                            <th>Directo</th>
                                            <th>Usuario(s)</th>
                                            <th class="hidden">Engine version</th>
                                            <th class="hidden">CSS grade</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($extensiones as $ex)
                                            <tr>
                                                <td>{{$ex->extension}}</td>
                                                <td>{{$ex->directo}}</td>
                                                <td>{{$ex->usuario}}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot class="hidden">
                                        <tr>
                                            <th>Rendering engine</th>
                                            <th>Browser</th>
                                            <th>Platform(s)</th>
                                            <th>Engine version</th>
                                            <th>CSS grade</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row hidden" style="margin-top: 10px">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h2><i class="fa fa-ticket"></i> Ultimos tickets solicitados</h2>
                        </div>

                        <div class="ibox-content">

                            <div>
                                <div class="chat-activity-list">

                                    <div class="chat-element">
                                        <a href="#" class="pull-left">
                                            <img alt="image" class="img-circle" src="img/a2.jpg">
                                        </a>
                                        <div class="media-body ">
                                            <small class="pull-right text-navy">1m ago</small>
                                            <strong>Mike Smith</strong>
                                            <p class="m-b-xs">
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                                            </p>
                                            <small class="text-muted">Today 4:21 pm - 12.06.2014</small>
                                        </div>
                                    </div>


                                    <div class="chat-element right">
                                        <a href="#" class="pull-right">
                                            <img alt="image" class="img-circle" src="img/a4.jpg">
                                        </a>
                                        <div class="media-body text-right ">
                                            <small class="pull-left">5m ago</small>
                                            <strong>John Smith</strong>
                                            <p class="m-b-xs">
                                                Lorem Ipsum is simply dummy text of the printing.
                                            </p>
                                            <small class="text-muted">Today 4:21 pm - 12.06.2014</small>
                                        </div>
                                    </div>

                                    <div class="chat-element ">
                                        <a href="#" class="pull-left">
                                            <img alt="image" class="img-circle" src="img/a2.jpg">
                                        </a>
                                        <div class="media-body ">
                                            <small class="pull-right">2h ago</small>
                                            <strong>Mike Smith</strong>
                                            <p class="m-b-xs">
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                                            </p>
                                            <small class="text-muted">Today 4:21 pm - 12.06.2014</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-form">
                                <form role="form">
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Message"></textarea>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-sm btn-primary m-t-n-xs"><strong>Send message</strong></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>

{{--MODAL PARA NUEVO SELLO DE EROGACIONES--}}
<div class="modal inmodal fade" id="nuevosello" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h5 class="modal-title">Nuevo sello de erogacion</h5>
                <h2><i class="fa fa-money"></i></h2>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frm_insumos">

                    <div class="form-group"><label class="col-lg-2 control-label">Centro de costos</label>

                        <div class="col-lg-8" id="the-basics">

                        </div>
                    </div>



                    <div class="form-group" >

                    </div>
                </form>
            </div>

            <div class="modal-footer">

                <button class="btn btn-sm btn-success" id="btn_guardaredicion" type="button">Guardar</button>
                <button type="button" class="btn btn-danger btn-sm" id="btn_cancelaredicion" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal fade" id="editarinsumo" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h5 class="modal-title">Editar Seleccion</h5>
                <h2><i class="fa fa-edit"></i></h2>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frm_insumos">

                    <div class="form-group"><label class="col-lg-2 control-label">Insumo</label>

                        <div class="col-lg-8" id="the-basics">
                            <input id="insumo_edit" required title="Campo obligatorio" type="text" placeholder="Digite el insumo" class="form-control typeahead">
                            {{--<button style="margin-top: 5px" data-target="#modalnuevoinsumo" data-toggle="modal" type="button" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Nuevo insumo</button>--}}
                        </div>
                    </div>
                    <div id="divcodinsumo" class="form-group hidden"><label class="col-lg-2 control-label">Codigo</label>

                        <div class="col-lg-3" id="">
                            <input autocomplete="off" id="codinsumo_edit" required title="Campo obligatorio" type="text" readonly="readonly" placeholder="" class=" form-control ">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-lg-2 control-label">Cantidad</label>

                        <div class="col-lg-3" id="">
                            <input autocomplete="off" id="cantidad_edit" min="0" required title="Campo obligatorio" type="number" placeholder="" class="form-control ">
                        </div>
                    </div>


                    <div class="form-group" >

                    </div>
                </form>
            </div>

            <div class="modal-footer">

                <button class="btn btn-sm btn-success" id="btn_guardaredicion" type="button">Guardar</button>
                <button type="button" class="btn btn-danger btn-sm" id="btn_cancelaredicion" data-dismiss="modal">Cancelar</button>
            </div>
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
<script src="js/plugins/dataTables/datatables.min.js"></script>

<!--funciones para el lenguaje de las datatables-->
<script type="text/javascript" src="js/funciones/lenguajeDataTable.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<script src="js/funciones/dashboard.js"></script>

<script>
    $(document).ready(function(){

        $('.ticketdetalle').click(function(){

            $('#footer').empty();
            $('#ocultar').removeClass('hidden');
            $.ajax({
                url:'userticketdetalle',
                data:{usuario:this.id},
                type:'post',
                datatype:'json',
                success:function(data)
                {
                    $('#footer').slideDown().removeClass('hidden').append(data);
                }
            });
        });

        $('#ocultar').click(function(){
            $('#footer').slideUp('slow');
            $('#ocultar').addClass('hidden');
        });


        //evento para poder mostrar la bitacora de los ticket
        $('.bitacoradetalle').click(function(){
            $('#footer').empty();
            $('#ocultar').removeClass('hidden');
            $.ajax({
                url:'bitacoradetalles',
                datatype:'json',
                type:'post',
                data:{usuario:this.id},
                success:function(data)
                {
                    $('#footer').slideDown().removeClass('hidden').append(data);
                }

            });
        });

    });
</script>

@yield('scripts')

</body>

</html>
