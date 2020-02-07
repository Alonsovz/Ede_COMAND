<!DOCTYPE html>
<html>
<script>
      window.location.replace('tck_edesalshow');
</script>
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

    <script src="js/angular/angular.js"></script>
    <script src="js/funciones/app.js"></script>
    <script src="js/funciones/ng.js"></script>

</head>

<body class="" ng-app="comanda">

    <div id="wrapper">

    
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse" style="position: fixed;                         
                                max-height: 100%;
                                overflow-x: auto;">
                <ul class="nav metismenu" id="side-menu">
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
                        <ul ng-controller="ngController" class="dropdown-menu animated fadeInRight m-t-xs"
                        >
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
                    <ul class="nav nav-second-level collapse" >
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
                    <a href="tck_edesalshow"><i class="fa fa    -ticket"></i> <span class="nav-label">Tickets</span>  <span class="pull-right label label-primary">{{Session::get('conteostaff')}}</span></a>
                  
                </li>

                <li>
                    <a href="mibitacora"><i class="fa fa-file-text-o"></i><span class="nav-label">Bitacoras</span><span class="label label-warning pull-right"></span></a>
                    
                </li>

                <li>
                    <a href="#"><i class="ion-heart"></i> <span class="nav-label"> Permisos</span><span class="label label-warning pull-right"></span></a>
                    <ul class="nav nav-second-level collapse" >
                        <li><a href="permisosempleados">Mis permisos</a></li>
                        <li><a href="indexpermisos">Nuevo permiso</a></li>
                        
                        
                    </ul>
                </li>


                        <li>
                            <a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Reserva de Vehiculos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse" >
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
                    <ul class="nav nav-second-level collapse" >
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
                            <ul class="nav nav-second-level collapse" >
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
                            <ul class="nav nav-second-level collapse" >
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
                    <ul class="nav nav-second-level collapse" >
                        <li><a href="permisosempleados">Mis permisos</a></li>
                        <li><a href="indexpermisos">Nuevo permiso</a></li>
                        @if($rol->nombre=="jefatura")
                            <li><a href="">Solicitudes</a></li>
                        @endif
                    </ul>
                </li>

                        <li>
                            <a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Reserva de Vehiculos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse" >
                                <li><a href="misreservas">Mis reservas</a></li>
                                <li><a href="vh_index">Nueva reserva</a></li>
                                


                            </ul>
                        </li>

                    @elseif($rol->nombre=='super_enr')
                        <li>
                            <a href="#"><i class="fa fa-money"></i> <span class="nav-label"> ENR</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse" >
                                <li><a href="indexenr">1. Nuevo calculo</a></li>
                                <li><a href="">2. Historico</a></li>
                            </ul>
                        </li>

                    @elseif($rol->nombre=='mantenimiento_vh')
                        <li>
                            <a href="#"><i class="fa fa-car"></i> <span class="nav-label"> Mantenimientos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse" >
                                <li><a href="fichamantenimiento">1. Nuevo mtto</a></li>
                                <li><a href="">2. Administración</a></li>
                            </ul>
                        </li>


                    @elseif($rol->nombre=='vh_supervisor')
                        <li>
                            <a href=""><i class="fa fa-child"></i><span class="nav-label">Supervisor de vehiculos</span><span class="label label-warning pull-right"></span></a>
                            <ul class="nav nav-second-level collapse" >
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
                            <ul class="nav nav-second-level collapse" >
                                <li><a href="nuevaoferta">Nueva oferta</a></li>
                                <li><a href="verofertas">Ver ofertas</a></li>
                            </ul>
                        </li>

                    @elseif($rol->nombre=='supervisor_ins' || $rol->nombre=='admin_ins')
                        <li>
                            <a href=""><i class="fa fa-archive"></i> <span class="nav-label">Insumos</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" >
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
                            <ul class="nav nav-second-level collapse" >
                                <li><a href="indexreportes">Reportes insumos</a></li>
                                <li><a href="km_indexreportes">Kilometrajes</a></li>
                            </ul>
                        </li>

                @endif



                


              @endforeach
              
               <li>
                    <a href=""><i class="fa fa-file-text"></i> <span class="nav-label">Documentos</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="politicas">Consulta</a></li>
                        <li><a href="subirDocumentos">Gestión</a></li>
                    </ul>
                </li>
                
            </ul>

        </div>
    </nav>
   

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0; height: 200px; background-image:  url('images/medidores.jpg'); background-size: 100%   ">
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
                            <h2><b>COMANDA</b></h2>
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

                </div>
                <div class="row">
                    <div class="clients-list">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href=".tab21"><i class="fa fa-ticket"></i> Tickets recibidos</a></li>
                            <li class=""><a data-toggle="tab" href=".tab22"><i class="fa fa-ticket"></i> Tickets enviados</a></li>
                            <li class=""><a id="" data-toggle="tab" href=".tab23"><i class="fa fa-ticket"></i> Tickets completados</a></li>
                            <li class=""><a id="" data-toggle="tab" href=".tab24"><i class="fa fa-ticket"></i> Tickets compartidos conmigo</a></li>

                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active tab21">
                                <div class="row" id="tablatickets">
                                    <div class="col-lg-12">
                                        <div class="ibox" style="border: lightgrey solid 1px">

                                            <div class="ibox-title" style="padding: 15px; height: 50px">
                                                <ul class="category-list pull-left." style="padding: 0">
                                                    <li><a href="#" class="col-lg-2" style="background-color: #B1FDC0; color: black"> <i class="" ></i> <b>En proceso</b></a></li>
                                                    <li><a href="#" class="col-lg-2" style="background-color: #CFEAFD; color: black;"> <i class="" ></i> <b>Recibido</b></a></li>
                                                    <li><a href="#" class="col-lg-2" style="background-color: #F9F3A5; color: black"> <i class="" ></i> <b>En pausa</b></a></li>
                                                </ul>

                                            </div>

                                            <div class="ibox-content" id="recibidostck">
                                                <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example"
                                                       style="color: black;margin-top: 20px" >
                                                    <thead id="header" class="">
                                                    <tr style="background-color: lightgrey">
                                                        <th class="text-center" style="border: solid 1px grey;">N° de ticket</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Cliente (si aplica CRM)</th>
                                                        <th class="text-center" style="border: solid 1px grey;" class="text-center"><i class="fa fa-clock-o"></i></th>
                                                        <th class="text-center" style="border: solid 1px grey;">Titulo</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Solicitante</th>
                                                        <th class="text-center" style="border: solid 1px grey;" class="text-center">Fecha de Solicitud</th>
                                                        <th class="text-center" style="border: solid 1px grey;" class="text-center">Fecha de entrega acordada</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Reasignado</th>
                                                        <th class="text-center" style="border: solid 1px grey;"></th>



                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($tickets as $ticket)
                                                        @if($ticket->estado=='Recibido')
                                                            <tr style="background-color: #CFEAFD">

                                                                <td class="text-center" style="border: solid 1px grey; "><b>{{$ticket->id}}</b></td>
                                                                <td class="text-center" style="border: solid 1px grey; "><b>{{$ticket->cliente}}</b></td>
                                                                <td style="border: solid 1px grey; width: 100px">
                                                                    @if($ticket->estado=='En proceso')
                                                                        <strong class="pull-left"><?php
                                                                            $datetime1 = new DateTime("now");
                                                                            $datetime2 = new DateTime($ticket->fechaentregareal);
                                                                            $interval = date_diff($datetime1, $datetime2);
                                                                            echo $interval->format('%R%a dias');
                                                                            ?> restantes</strong><br>
                                                                        <div class="progress" style="height: 10px;">
                                                                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
                                                                <td style="border: solid 1px grey;" class="text-center">
                                                                    <small>
                                                                        <?php
                                                                        $date=date_create($ticket->fechasolicitud);
                                                                        echo date_format($date,"d/m/Y");
                                                                        ?>
                                                                    </small>
                                                                </td>
                                                                <td style="border: solid 1px grey;" class="text-center">
                                                                    <small>
                                                                        @if($ticket->estado=='En proceso')
                                                                            <?php
                                                                            $date=date_create($ticket->fechaentregareal);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        @elseif($ticket->estado=='Recibido')
                                                                            <?php
                                                                            $date=date_create($ticket->fechasolaprox);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        @endif
                                                                    </small>
                                                                </td>
                                                                <td class="text-center" style="border:solid 1px black">@if($ticket->reasignado==1) Si @else No @endif</td>
                                                                <td style="border: solid 1px grey;">
                                                                    @if($ticket->estado=='Recibido')
                                                                        <button id="{{$ticket->id}}" type="button" style="border:solid 1px black" class="btn btn-md btn-default tck_infoticket" style="color:black">
                                                                            <i class="fa fa-eye"></i> Ver
                                                                        </button>
                                                                    @endif
                                                                    @if($ticket->estado=='En proceso')
                                                                        <a href="administrarticket?id={{$ticket->id}}" style="border:solid 1px black" type="button" class="btn btn-md btn-default  btn_administrarticket" id="{{$ticket->id}}" >
                                                                            <i class="fa fa-cog"></i> Administrar</a>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        @elseif($ticket->estado=='En pausa')
                                                            <tr style="background-color: #F9F3A5">

                                                                <td style="border: solid 1px grey;"><b>{{$ticket->id}}</b></td>
                                                                <td class="text-center" style="border: solid 1px grey; "><b>{{$ticket->cliente}}</b></td>
                                                                <td style="border: solid 1px grey; width: 100px">
                                                                    @if($ticket->estado=='En proceso')
                                                                        <strong class="pull-left"><?php
                                                                            $datetime1 = new DateTime("now");
                                                                            $datetime2 = new DateTime($ticket->fechaentregareal);
                                                                            $interval = date_diff($datetime1, $datetime2);
                                                                            echo $interval->format('%R%a dias');
                                                                            ?> restantes</strong><br>
                                                                        <div class="progress" style="height: 10px;">
                                                                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
                                                                <td style="border: solid 1px grey;" class="text-center">
                                                                    <small>
                                                                        <?php
                                                                        $date=date_create($ticket->fechasolicitud);
                                                                        echo date_format($date,"d/m/Y");
                                                                        ?>
                                                                    </small>
                                                                </td>
                                                                <td style="border: solid 1px grey;" class="text-center">
                                                                    <small>
                                                                        @if($ticket->estado=='En proceso')
                                                                            <?php
                                                                            $date=date_create($ticket->fechaentregareal);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        @elseif($ticket->estado=='Recibido')
                                                                            <?php
                                                                            $date=date_create($ticket->fechasolaprox);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        @endif
                                                                    </small>
                                                                </td>
                                                                <td class="text-center" style="border:solid 1px black">@if($ticket->reasignado==1) Si @else No @endif</td>
                                                                <td style="border: solid 1px grey;">
                                                                    @if($ticket->estado=='Recibido')
                                                                        <button id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
                                                                            <i class="fa fa-eye"></i> Ver
                                                                        </button>
                                                                    @endif
                                                                    @if($ticket->estado=='En proceso' || $ticket->estado=='En pausa')
                                                                        <a href="administrarticket?id={{$ticket->id}}" type="button" style="border:solid 1px black" class="btn btn-md btn-default btn_administrarticket" id="{{$ticket->id}}" >
                                                                            <i class="fa fa-cog"></i> Administrar</a>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        @elseif($ticket->estado=='En proceso')
                                                            <tr style="background-color: #B1FDC0">

                                                                <td style="border: solid 1px grey;"><b>{{$ticket->id}}</b></td>
                                                                <td class="text-center" style="border: solid 1px grey; "><b>{{$ticket->cliente}}</b></td>
                                                                <td style="border: solid 1px grey; width: 100px">
                                                                    @if($ticket->estado=='En proceso')
                                                                        <strong class="pull-left"><?php
                                                                            $datetime1 = new DateTime("now");
                                                                            $datetime2 = new DateTime($ticket->fechaentregareal);
                                                                            $interval = date_diff($datetime1, $datetime2);
                                                                            echo $interval->format('%R%a dias');
                                                                            ?> restantes</strong><br>
                                                                        <div class="progress" style="height: 10px;">
                                                                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
                                                                <td style="border: solid 1px grey;" class="text-center">
                                                                    <small>
                                                                        <?php
                                                                        $date=date_create($ticket->fechasolicitud);
                                                                        echo date_format($date,"d/m/Y");
                                                                        ?>
                                                                    </small>
                                                                </td>
                                                                <td style="border: solid 1px grey;" class="text-center">
                                                                    <small>
                                                                        @if($ticket->estado=='En proceso')
                                                                            <?php
                                                                            $date=date_create($ticket->fechaentregareal);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        @elseif($ticket->estado=='Recibido')
                                                                            <?php
                                                                            $date=date_create($ticket->fechasolaprox);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        @endif
                                                                    </small>
                                                                </td>
                                                                <td class="text-center" style="border:solid 1px black">@if($ticket->reasignado==1) Si @else No @endif</td>
                                                                <td style="border: solid 1px grey;">
                                                                    @if($ticket->estado=='Recibido')
                                                                        <button id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
                                                                            <i class="fa fa-eye"></i> Ver
                                                                        </button>
                                                                    @endif
                                                                    @if($ticket->estado=='En proceso')
                                                                        <a href="administrarticket?id={{$ticket->id}}" type="button" style="border:solid 1px black" class="btn btn-md btn-default btn_administrarticket" id="{{$ticket->id}}" >
                                                                            <i class="fa fa-cog"></i> Administrar</a>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                    <tfoot id="footer" class="hidden">
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

                                <div class="row hidden" id="divinfoticket">

                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane tab22">
                                <div class="ibox">
                                    <div class="ibox-title" style="padding: 15px; height: 50px">
                                        <ul class="category-list pull-left." style="padding: 0">
                                            <li><a href="#" class="col-lg-2" style="background-color: lightcyan; color: black"> <i class="" ></i> <b>En proceso</b></a></li>
                                            <li><a href="#" class="col-lg-2" style="background-color: darkblue; color: white;"> <i class="" ></i> <b>Recibido</b></a></li>
                                            <li><a href="#" class="col-lg-2" style="background-color: red; color: white"> <i class="" ></i> <b>Cerrado</b></a></li>
                                            <li><a href="#" class="col-lg-2" style="background-color: lightgreen; color: black"> <i class="" ></i> <b>Solucionado</b></a></li>
                                        </ul>

                                    </div>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                                                    <thead id="header" class="">
                                                    <tr style="background-color: lightgrey">
                                                        <th class="text-center" style="border: solid 1px grey;">N° de ticket</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Estado</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Titulo</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Usuario Asignado</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Fecha de Solicitud</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Fecha de entrega acordada</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Fecha de solucion</th>
                                                        <th class="text-center" style="border: solid 1px grey;"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($ticketssolicitados as $ticket)

                                                        <tr>
                                                            <td class="text-center" style="border: solid 1px grey; background-color: lightblue"><b>{{$ticket->id}}</b></td>
                                                            @if($ticket->estado=='Recibido')
                                                                <td style="border: solid 1px grey;"><span class="label label-success">{{$ticket->estado}}</span></td>
                                                            @elseif($ticket->estado=='En proceso')
                                                                <td style="border: solid 1px grey;"><span class="label label-warning">{{$ticket->estado}}</span></td>
                                                            @elseif($ticket->estado=='Solucionado')
                                                                <td style="border: solid 1px grey;"><span class="label label-primary">{{$ticket->estado}}</span></td>
                                                            @elseif($ticket->estado=='Cerrado')
                                                                <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                                            @elseif($ticket->estado=='Rechazado')
                                                                <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                                            @elseif($ticket->estado=='En pausa')
                                                                <td style="border: solid 1px grey;"><span class="label label-info">{{$ticket->estado}}</span></td>
                                                            @elseif($ticket->estado=='Cancelado')
                                                                <td style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                                            @endif
                                                            <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                            <td style="border: solid 1px grey;"><small><b>{{$ticket->nombreasignado}} {{$ticket->apellidoasignado}}</b></small></td>
                                                            <td style="border: solid 1px grey;">
                                                                <small>
                                                                    <?php
                                                                    $date=date_create($ticket->fechasolicitud);
                                                                    echo date_format($date,"d/m/Y");
                                                                    ?>
                                                                </small>
                                                            </td>
                                                            <td style="border: solid 1px grey;">
                                                                <small>
                                                                    <?php
                                                                    $date=date_create($ticket->fechasolaprox);
                                                                    echo date_format($date,"d/m/Y");
                                                                    ?>
                                                                </small>
                                                            </td>
                                                            <td style="border: solid 1px black;" class="text-center">
                                                                <small>
                                                                    <?php
                                                                    $date=date_create($ticket->fechasolucion);
                                                                    echo date_format($date,"d/m/Y");
                                                                    ?>
                                                                </small>
                                                            </td>
                                                            <td style="border: solid 1px grey;">

                                                                <a href="verticketsolicitado?id={{$ticket->id}}" id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
                                                                    <i class="fa fa-eye"></i> Ver
                                                                </a>


                                                            </td>

                                                        </tr>

                                                    @endforeach
                                                    </tbody>
                                                    <tfoot id="footer" class="hidden">
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
                            <div id="tab-2" class="tab-pane tab23">
                                <div class="ibox">
                                    <div class="ibox-title" style="padding: 15px; height: 50px">
                                        <ul class="category-list pull-left." style="padding: 0">
                                            <li><a href="#" class="col-lg-2" style="background-color: red; color: white"> <i class="" ></i> <b>Cerrado</b></a></li>
                                            <li><a href="#" class="col-lg-2" style="background-color: lightgreen; color: black"> <i class="" ></i> <b>Solucionado</b></a></li>
                                            <li><i class="" ></i> </li>
                                        </ul>

                                    </div>
                                    <div class="ibox-content">
                                        <table id="" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example" style="color: black;margin-top: 20px" >
                                            <thead id="header" class="">
                                            <tr style="background-color: lightgrey">
                                                <th class="text-center" style="border: solid 1px grey;">N° de ticket</th>
                                                <th class="text-center" style="border: solid 1px grey;">Estado</th>
                                                <th class="text-center" style="border: solid 1px grey;">Titulo</th>
                                                <th class="text-center" style="border: solid 1px grey;">Solicitante</th>
                                                <th class="text-center" style="border: solid 1px grey;">Fecha de solicitud</th>
                                                <th class="text-center" style="border: solid 1px grey;">Fecha de entrega acordada</th>
                                                <th class="text-center" style="border: solid 1px grey;">Fecha de solucion</th>
                                                <th class="text-center" style="border: solid 1px grey;"></th>



                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tickets as $ticket)
                                                @if($ticket->estado=='Rechazado' || $ticket->estado=='Cerrado' || $ticket->estado=='Solucionado')
                                                    <tr>
                                                        <td class="text-center" style="border: solid 1px grey; background-color: lightblue"><b>{{$ticket->id}}</b></td>
                                                        @if($ticket->estado=='Recibido')
                                                            <td class="text-center" style="border: solid 1px grey;"><span class="label label-success">{{$ticket->estado}}</span></td>
                                                        @elseif($ticket->estado=='En proceso')
                                                            <td class="text-center" style="border: solid 1px grey;"><span class="label label-warning">{{$ticket->estado}}</span></td>
                                                        @elseif($ticket->estado=='Solucionado')
                                                            <td class="text-center" style="border: solid 1px grey;"><span class="label label-primary">{{$ticket->estado}}</span></td>
                                                        @elseif($ticket->estado=='Cerrado')
                                                            <td class="text-center" style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                                        @elseif($ticket->estado=='Rechazado')
                                                            <td class="text-center" style="border: solid 1px grey;"><span class="label label-danger">{{$ticket->estado}}</span></td>
                                                        @endif
                                                        <td class="" style="border: solid 1px grey;">{{$ticket->descripcion}}</td>
                                                        <td class="text-center" style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
                                                        <td class="text-center" style="border: solid 1px grey;">
                                                            <small>
                                                                <?php
                                                                $date=date_create($ticket->fechasolicitud);
                                                                echo date_format($date,"d/m/Y");
                                                                ?>
                                                            </small>
                                                        </td>
                                                        <td class="text-center" style="border: solid 1px grey;">
                                                            <small>
                                                                @if($ticket->estado==='En proceso' )
                                                                    <?php
                                                                    $date=date_create($ticket->fechaentregareal);
                                                                    echo date_format($date,"d/m/Y");
                                                                    ?>
                                                                @elseif($ticket->estado==='Solucionado' || $ticket->estado==='Cerrado')
                                                                    <?php
                                                                    $date=date_create($ticket->fechasolucion);
                                                                    echo date_format($date,"d/m/Y");
                                                                    ?>
                                                                @elseif($ticket->estado=='Recibido')
                                                                    <?php
                                                                    $date=date_create($ticket->fechasolaprox);
                                                                    echo date_format($date,"d/m/Y");
                                                                    ?>
                                                                @endif
                                                            </small>
                                                        </td>
                                                        <td class="text-center" style="border: solid 1px black;"><?php
                                                            $date=date_create($ticket->fechasolucion);
                                                            echo date_format($date,"d/m/Y");
                                                            ?></td>
                                                        <td style="border: solid 1px grey;">
                                                            <a href="administrarticket?id={{$ticket->id}}" id="{{$ticket->id}}" type="button" style="border:solid 1px black" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
                                                                <i class="fa fa-eye"></i> Ver
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                            <tfoot id="footer" class="hidden">
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
                            <div id="tab-4" class="tab-pane tab24">
                                <div class="row" id="tablatickets">
                                    <div class="col-lg-12">
                                        <div class="ibox" style="border: lightgrey solid 1px">

                                            <div class="ibox-title" style="padding: 15px; height: 50px">
                                                <ul class="category-list pull-left." style="padding: 0">
                                                    <li><a href="#" class="col-lg-2" style="background-color: lightcyan; color: black"> <i class="" ></i> <b>En proceso</b></a></li>
                                                    <li><a href="#" class="col-lg-2" style="background-color: deepskyblue; color: black;"> <i class="" ></i> <b>Recibido</b></a></li>
                                                    <li><a href="#" class="col-lg-2" style="background-color: yellow; color: black"> <i class="" ></i> <b>En pausa</b></a></li>
                                                </ul>

                                            </div>

                                            <div class="ibox-content" id="recibidostck">
                                                <table id="reservasdenegadas" class="dataTables-example1 table table-hover table-responsive table-striped  table-mail dataTables-example"
                                                       style="color: black;margin-top: 20px" >
                                                    <thead id="header" class="">
                                                    <tr style="background-color: lightgrey">
                                                        <th class="text-center" style="border: solid 1px grey;">N° de ticket</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Cliente (si aplica CRM)</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Titulo</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Solicitante</th>
                                                        <th class="text-center" style="border: solid 1px grey;">Asignado a</th>
                                                        <th class="text-center" style="border: solid 1px grey;" class="text-center">Fecha de Solicitud</th>
                                                        <th class="text-center" style="border: solid 1px grey;" class="text-center">Fecha de entrega acordada</th>

                                                        <th class="text-center" style="border: solid 1px grey;"></th>



                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($ticketscompartidos as $ticket)
                                                        @if($ticket->estado=='Recibido')
                                                            <tr style="background-color: deepskyblue">

                                                                <td class="text-center" style="border: solid 1px grey; "><b>{{$ticket->id}}</b></td>
                                                                <td class="text-center" style="border: solid 1px grey; "><b>{{$ticket->cliente}}</b></td>
                                                                <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
                                                                <td style="border: solid 1px grey;"><small><b>{{$ticket->nombreasignado}} {{$ticket->apellidoasignado}}</b></small></td>
                                                                <td style="border: solid 1px grey;" class="text-center">
                                                                    <small>
                                                                        <?php
                                                                        $date=date_create($ticket->fechasolicitud);
                                                                        echo date_format($date,"d/m/Y");
                                                                        ?>
                                                                    </small>
                                                                </td>
                                                                <td style="border: solid 1px grey;" class="text-center">
                                                                    <small>
                                                                        @if($ticket->estado=='En proceso')
                                                                            <?php
                                                                            $date=date_create($ticket->fechaentregareal);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        @elseif($ticket->estado=='Recibido')
                                                                            <?php
                                                                            $date=date_create($ticket->fechasolaprox);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        @endif
                                                                    </small>
                                                                </td>
                                                                <td style="border: solid 1px grey;">
                                                                    @if($ticket->estado=='En proceso')
                                                                        <a href="administrarticket?id={{$ticket->id}}" style="border:solid 1px black" type="button" class="btn btn-md btn-default  btn_administrarticket" id="{{$ticket->id}}" >
                                                                            <i class="fa fa-cog"></i> Administrar</a>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        @elseif($ticket->estado=='En pausa')
                                                            <tr style="background-color: yellow">

                                                                <td style="border: solid 1px grey;"><b>{{$ticket->id}}</b></td>
                                                                <td class="text-center" style="border: solid 1px grey; "><b>{{$ticket->cliente}}</b></td>
                                                                <td style="border: solid 1px grey; width: 100px">
                                                                    @if($ticket->estado=='En proceso')
                                                                        <strong class="pull-left"><?php
                                                                            $datetime1 = new DateTime("now");
                                                                            $datetime2 = new DateTime($ticket->fechaentregareal);
                                                                            $interval = date_diff($datetime1, $datetime2);
                                                                            echo $interval->format('%R%a dias');
                                                                            ?> restantes</strong><br>
                                                                        <div class="progress" style="height: 10px;">
                                                                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
                                                                <td style="border: solid 1px grey;" class="text-center">
                                                                    <small>
                                                                        <?php
                                                                        $date=date_create($ticket->fechasolicitud);
                                                                        echo date_format($date,"d/m/Y");
                                                                        ?>
                                                                    </small>
                                                                </td>
                                                                <td style="border: solid 1px grey;" class="text-center">
                                                                    <small>
                                                                        @if($ticket->estado=='En proceso')
                                                                            <?php
                                                                            $date=date_create($ticket->fechaentregareal);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        @elseif($ticket->estado=='Recibido')
                                                                            <?php
                                                                            $date=date_create($ticket->fechasolaprox);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        @endif
                                                                    </small>
                                                                </td>

                                                                <td style="border: solid 1px grey;">
                                                                    @if($ticket->estado=='Recibido')
                                                                        <button id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
                                                                            <i class="fa fa-eye"></i> Ver
                                                                        </button>
                                                                    @endif
                                                                    @if($ticket->estado=='En proceso' || $ticket->estado=='En pausa')
                                                                        <a href="administrarticket?id={{$ticket->id}}" type="button" style="border:solid 1px black" class="btn btn-md btn-default btn_administrarticket" id="{{$ticket->id}}" >
                                                                            <i class="fa fa-cog"></i> Administrar</a>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        @elseif($ticket->estado=='En proceso')
                                                            <tr style="background-color: lightcyan">

                                                                <td style="border: solid 1px grey;"><b>{{$ticket->id}}</b></td>
                                                                <td class="text-center" style="border: solid 1px grey; "><b>{{$ticket->cliente}}</b></td>
                                                                <td style="border: solid 1px grey; width: 100px">
                                                                    @if($ticket->estado=='En proceso')
                                                                        <strong class="pull-left"><?php
                                                                            $datetime1 = new DateTime("now");
                                                                            $datetime2 = new DateTime($ticket->fechaentregareal);
                                                                            $interval = date_diff($datetime1, $datetime2);
                                                                            echo $interval->format('%R%a dias');
                                                                            ?> restantes</strong><br>
                                                                        <div class="progress" style="height: 10px;">
                                                                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td style="border: solid 1px grey;">{{$ticket->titulo}}</td>
                                                                <td style="border: solid 1px grey;"><small><b>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</b></small></td>
                                                                <td style="border: solid 1px grey;" class="text-center">
                                                                    <small>
                                                                        <?php
                                                                        $date=date_create($ticket->fechasolicitud);
                                                                        echo date_format($date,"d/m/Y");
                                                                        ?>
                                                                    </small>
                                                                </td>
                                                                <td style="border: solid 1px grey;" class="text-center">
                                                                    <small>
                                                                        @if($ticket->estado=='En proceso')
                                                                            <?php
                                                                            $date=date_create($ticket->fechaentregareal);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        @elseif($ticket->estado=='Recibido')
                                                                            <?php
                                                                            $date=date_create($ticket->fechasolaprox);
                                                                            echo date_format($date,"d/m/Y");
                                                                            ?>
                                                                        @endif
                                                                    </small>
                                                                </td>

                                                                <td style="border: solid 1px grey;">
                                                                    @if($ticket->estado=='Recibido')
                                                                        <button id="{{$ticket->id}}" type="button" class="btn btn-md btn-default btn-outline tck_infoticket" style="color:black">
                                                                            <i class="fa fa-eye"></i> Ver
                                                                        </button>
                                                                    @endif
                                                                    @if($ticket->estado=='En proceso')
                                                                        <a href="administrarticket?id={{$ticket->id}}" type="button" style="border:solid 1px black" class="btn btn-md btn-default btn_administrarticket" id="{{$ticket->id}}" >
                                                                            <i class="fa fa-cog"></i> Administrar</a>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                    <tfoot id="footer" class="hidden">
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


    <script src="../js/plugins/fullcalendar/moment.min.js"></script>

    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="js/funciones/lenguajeDataTable.js"></script>
    <script src='../js/plugins/typeahead.js/typeahead.jquery.js'></script>
    <script src='../js/plugins/typeahead.js/bloodhound.js'></script>
    <script src='../js/plugins/typeahead.js/typeahead.bundle.js'></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/funciones/dashboard.js"></script>
    <script src="../js/funciones/tickets.js"></script>



    <script>
         
 
       
   
   

       $(document).ready(function(){
            
      

           $(function () {
               $('#datetimepicker1').datetimepicker();
           });

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
