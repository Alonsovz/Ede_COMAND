<?php

use JasperPHP\JasperPHP as JasperPHP;

use Illuminate\Support\Facades\Mail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/api/animals", function() {
    return response()->json([['name' => 'dog'], ['name' => 'cat'], ['name' => 'elephant'], ['name' => 'elk'], ['name' => 'spider']]);
});

Route::any('pruebacorreo',function(){

    $data='hola';
    $email= 'mail';

    Mail::send('email.nuevoticket', ['ticketlast' => $data], function ($m) use ($data) {
        $correo = 'dhernandez@edesal.com';
        $m->from($correo, 'COMANDA');
        $m->to('dhernandez@edesal.com', '')->subject('Nueva solicitud!');
    });
});


//rutas para telefonos
Route::any('telefonos','UserController@getExtensiones');


Route::any('hora',function(){


    echo(date("Y-m-d H:i:s"))."<br>";
});

/*
|--------------------------------------------------------------------------
| Rutas Alternativas
|--------------------------------------------------------------------------*/

Route::any('template',function(){

    return view('layouts.template');

});


Route::any('reportemargarita',function(){


});

Route::get('/', function () {
    return view('welcome');
});

Route::any('/',function(){

    return view('login');

});

Route::any('indexreportes','Rpt_InsumosController@index');



//excel para movimientos de papeleria
Route::any('qry_movimiento_pape_excel','InsumoController@generarExcelMovPape');




/*--------------------------------------------------------------------------



/*
|--------------------------------------------------------------------------
| Rutas Tickets
|--------------------------------------------------------------------------*/

//ruta para guardar un ticket
Route::any('saveticket','TicketController@store');

//ver vista de los procesos activos de TI
Route::any('procesosinformatica','TicketController@verProcesosInformatica');

Route::any('indexnostaff','TicketController@indexNoStaff');

//ruta para tracking de tickets no staff
Route::any('ticketsnostaff','TicketController@showNostaff');

//ruta para la vista de edicion de un ticket
Route::any('editticketns','TicketController@edit');


//ruta para la vista de la creacion de ticket por parte de STAFF
Route::any('indexstaff','TicketController@indexStaff');


//ruta para la vista de los tickets recibidos para staff
Route::any('recibidosstaff','TicketController@ticketsRecibidosStaff');


//ruta para busqueda de ticket por id
Route::any('findticketbyid','TicketController@getTicketById');


//ruta para actualizar el ticket
Route::any('updateticket','TicketController@update');


//ruta para administrar un ticket
Route::any('administrarticket','TicketController@administrarTicket');

//generar reporte de detalles de ticket
Route::any('rpt_ticketdetalles','TicketController@generarReporteDetalles');

//ruta para Ticket solicitados EDESAL
Route::any('tck_solicitadosedesal','TicketController@Solicitados');


//ruta para los tickets completos
Route::any('getticketscompletos','TicketController@obtenerTicketsCompletos');


//ruta para tickets completados sin la subview
Route::any('ticketscompletados','TicketController@ticketsCompletados');


//ruta para lanzar la subvista de resoluciones de staff
Route::any('resolucionstaff','TicketController@ticketsResoluciones');


//ruta para aceptar o denegar la resolucion del ticket administrado
Route::any('resolucionticket','TicketController@resolucionTicket');


Route::any('tck_edesalindex','TicketController@indexEdesal');

//ruta para ticket solicitados
Route::any('tck_edesalshow','TicketController@showEdesal');

//ruta para ver ticket solicitado
Route::any('verticketsolicitado','TicketController@verTicketSolicitado');


//ruta para listar los detalles del ticket
Route::any('tck_infoticket','TicketController@infoTicketEdesal');


//ruta para acetpar un ticket EDESAL
Route::any('aceptartck','TicketController@aceptarTicket');

//ruta para rechazar un ticket
Route::any('rechazarticket','TicketController@rechazarTicketEdesal');



//Ruta para tickets completados
Route::any('ticketscompletados','TicketController@ticketsCompletados');


Route::any('supervisiontickets','TicketController@view_supervisionTickets');

Route::any('tck_supervisarticket','TicketController@view_DetalleSupervision');



//listar los ticket de un usuario de staff
Route::any('userticketdetalle','TicketController@staffDetalleTickets');


//Listar el deltalle de los tickets de informatica
Route::any('rpt_detalleticketsinformatica','TicketController@rptDetalleTicketInformatica');


//exportar a excel el detalle de los ticket
Route::any('xls_generarexceldetalletickets','TicketController@xls_GenerarDetalleTickets');


//rpt de horas trabajadas
Route::any('rpt_detallehorastrabajadas','TicketController@rpt_HorasTrabajadas');


//excel para horas trabajadas
Route::any('excel_detallehorastrabajadas','TicketController@excelHorasTrabajadas');

//rpt para las horas registradas por sistema
Route::any('rpt_hrsxsistema','TicketController@rpt_HorasXSistema');

//excel para horas trabajadas por sistema
Route::any('excel_detallehorastrabajadassistema','TicketController@excelHorasTrabajadasXSistema');


//reporte de tickets recibidos por empleado
Route::any('rpt_ticketsrecibidos','TicketController@rpt_ticketsrecibidos');


//generar excel para los tickets recibidos
Route::any('excel_ticketsrecibidos','TicketController@excel_ticketsRecibidos');


//generar reporte para los tickets recibidos por sistema
Route::any('rpt_ticketsxsistemaconteo','TicketController@rpt_TicketXSistemaRecibidos');



//generar excel para los tickets recibidos pero por sistema
Route::any('ticketsrecibidosxsistema','TicketController@excel_ticketsRecibidosXXSistema');


//ruta para generar el reporte de los tickets autoasignados
Route::any('rpt_autoasignadostickets','TicketController@rpt_ticketsAutoAsignados');


//excel para tickets autoasignados
Route::any('excel_ticketsautoasignados','TicketController@excel_ticketsAutoasignados');



/*----------------------------------------------------------------------------*/


//RUTAS PARA TICKETSMESSENGER
Route::any('savemensaje','TicketMessengerController@store');

/*
|--------------------------------------------------------------------------
| Rutas BITACORAS
|--------------------------------------------------------------------------*/

//index bitacoras
Route::any('mibitacora','BitacoraController@index');

//nueva bitacora
Route::any('nuevabitacora','BitacoraController@create');

//guardar un registro de bitacora
Route::any('savebitacora','BitacoraController@store');


//administracion de bitacoras para la vsta de tickets
Route::any('administracionbitacoras','BitacoraController@adminBitacoraByTickets');


//obtener lineas por id de ticket
Route::any('getlineasbitacora','BitacoraController@getLineasDeTicket');


//OBTENER EL DETALLE DE LAS BITACORAS DE LOS USUARIOS DE INFORMATICA
Route::any('bitacoradetalles','BitacoraController@detallesByUser');



//---------------------------------------------------------------------------



/*
|--------------------------------------------------------------------------
| Rutas Usuario
|--------------------------------------------------------------------------*/

//renovacion de contraseña por MD5
Route::any('renovacioncontraseña',function(){
   return view('renovacionpassword');
});


//proceso de erogaciones
Route::any('procesoerogaciones','UserController@verErogaciones');

//ruta para cambiar a md5
Route::any('contrasenamd5','UserController@contraseñaMD5');

//editar informacion extra
Route::any('editarinformacionuser','UserController@editarInformacionExtra');

//validar credenciales del usuario al ingresar a COMANDA
Route::any('login','UserController@validacionCredenciales');

//ruta para destruir sesiones activas al dar click sobre cerrar sesion
Route::any('cerrarsesion','UserController@cerrarSesion');

//vista principal
Route::any('dashboard','UserController@index');

//obtener jefaturas
Route::any('getjefaturas','UserController@obtenerJefaturas');

//obtener los usuarios
Route::any('getusuariosall','UserController@UsuariosAll');

//ruta para la edicion de perfil
Route::any('miperfil','UserController@miPerfil');


//ruta para editar perfil
Route::any('editperfil','UserController@editPerfil');


//ruta para mostrar la vista de los usuarios registrados dentro del COMANDA
Route::any('usuarios','UserController@show');

//obtener la informacion del usuario
Route::any('getinfousuario','UserController@getInfoUsuarioById');


//obtener roles de un usuario
Route::any('getroles','UserController@getRoles');


//asignar un rol
Route::any('asignarrol','UserController@asignarRol');

//Asignar vehiculo a un usuario
Route::any('asignarvehiculo','UserController@asignarVehiculo');


//ruta para asignar cc y bodega
Route::any('asignarccbodega','UserController@asignarBodegaCC');


//editar la informacion general de un usuario de parte de informatica
Route::any('editarinfousuario','UserController@editInfoUserByInformatica');


//eliminar un rol para un usuario
Route::any('eliminarrolforuser','UserController@elminarRolForUser');


//ruta para nuevo usuario
Route::any('nuevousuario','UserController@store');


//ruta para confirmar correo
Route::any('confirmarcorreo','UserController@confirmarCorreo');

//ruta para guardar nueva contraseña
Route::any('savenuevacontraseña','UserController@reestablecerContraseña');


//ruta para listar las erogaciones
Route::any('listartipogasto','UserController@listarTiposGastos');


/*--------------------------------------------------------------------------*/






/*
|--------------------------------------------------------------------------
| Rutas para modulo de actualizaciones de postes arrendados y luminarias
|--------------------------------------------------------------------------*/

//Obtener la vista del formulario de inicio para nueva actualizacion de postes
Route::any('posteindex','PosteController@index');

//Ruta para funcion de save de la solicitud de postes
Route::any('savesolicitudposte','PosteController@store');












/*------------------------------------------------------------------------------*/










/*
|--------------------------------------------------------------------------
| Rutas Permisos
|--------------------------------------------------------------------------*/

//redireccionar vista de index de permiso
Route::any('indexpermisos','PermisoController@index');

//editar el permiso por parte del empleado
Route::any('editarpermiso_emp','PermisoController@editPermisoEmpleado');

//evento para poder guardar un permiso
Route::any('savepermiso','PermisoController@store');

//ruta para mostrar la bandeja de recursos humanos
Route::any('permisosrrhh','PermisoController@indexRRHH');

//ruta para mostrar la bandeja de jefatura
Route::any('permisosjefatura','PermisoController@indexJefatura');

//listar detalles de permisos
Route::any('detallespermiso','PermisoController@edit');

//ruta para actualizar un permiso 
Route::any('actualizarpermiso','PermisoController@update');

//ruta para generar las estadisticas necesarias de rrhh
Route::any('rrhhestadisticas','PermisoController@estadisticas');


//ruta para mostrar vista de los permisos aprobados de jefatura
Route::any('aprobadosjefatura','PermisoController@viewAprobadosJefatura');

//ruta para mostrar la vista de los permisos aprobados y revisados por rrhh
Route::any('aprobadosrrhh','PermisoController@viewAprobadosByRRHH');

//ruta para mostra la vista de los permisos de los empleado
Route::any('permisosempleados','PermisoController@indexEmpleado');

//ruta para evento de imprimir el permiso
Route::any('imprimirpermiso','PermisoController@imprimirPermiso');

//ruta para mostrar la vista de los permisos rechazados de jefatura
Route::any('rechazadosjefatura','PermisoController@viewRechazadosJefatura');

//ruta para mostrar la vista de los permisos rechazados para recursos humanos
Route::any('rechazadosrrhh','PermisoController@viewRechazadosByRRHH');


//ruta para vista de aprobados empleado
Route::any('aprobadosempleados','PermisoController@viewAprobadosEmpleado');

//ruta para mostrar la vista de edicion de un permiso
Route::any('editpermiso', 'PermisoController@viewEdit');

//ruta para generar el pdf de la solicitud de permiso
Route::any('permisopdf','PermisoController@generarPermisoPDF');


//ruta para editar un permiso
Route::any('saveedicion','PermisoController@saveEdicion');


//descargar pdf
Route::any('descargarpdf','PermisoController@descargarPDF');

//vista de graficos
Route::any('estadisticas','PermisoController@viewEstadisticas');

//ruta para generar el grafico de pastel por areas segun rango de fechas
Route::any('graficopastelareas','PermisoController@graficoPastelByAreas');

//ruta para generar el grafico de barra por
Route::any('graficobarraempleado','PermisoController@graficoBarraEmpleado');


//ruta para generar el grafico de barra de los permisos solicitados por area
Route::any('graficotipospermisos','PermisoController@graficoTipoPermisosByArea');

//ruta para generar la vista de los permisos rechazados de los empleado
Route::any('rechazadosempleados','PermisoController@rechazadosByEmpleados');


//ruta para detalles de permisos
Route::any('rpt_detallepermisos','PermisoController@rpt_DetallePermisos');


//ruta para generar los detalles de los permisos en formato excel
Route::any('excel_detallepermisos','PermisoController@excel_DetallePermisos');


//ruta para generar la vista para el detalle de los permisos solicitados por empleado
Route::any('rpt_permisosdetalleporempleado','PermisoController@rpt_DetallePorEmpleado');


//ruta para generar el PDF para el detalle de los permisos solicitados por empleado
Route::any('pdf_detalleporempleado','PermisoController@pdf_DetallePorEmpleado');

//generar un grafico para el conteo de permisos por categoria
Route::any('graph_conteoXcategoria','PermisoController@getConteoXCategoria');




/*--------------------------------------------------------------------------*/




/*---------------------------------------------------------------------------
 RUTAS PARA DEPARTAMENTOS
 ---------------------------------------------------------------------------*/
Route::any('departamentos','DepartamentosController@departamentosAll');

/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/



/*---------------------------------------------------------------------------
 RUTAS PARA ACTIVOS
 ---------------------------------------------------------------------------*/
Route::any('indexactivos','EmpActivoController@index');

//listar los activos de edesal para el supervisor de activos
Route::any('indexsuperactivos','EmpActivoController@indexSuperv');

//VALIDACION POSITIVA DE LOS ACTIVOS
Route::any('validacionactivo_positiva','EmpActivoController@validacionPositiva');


Route::any('validacionactivo_negativa','EmpActivoController@validacionNegativa');

//ruta para mostrar la vista de las validaciones realizadas por los usuarios
Route::any('validacionactitovs','EmpActivoController@showSuperv');


//RUTA PARA VER LOS ACTIVOS DE LOS EMPLEADOS SEGUN JEFATURA
Route::any('indexactivosjefe','EmpActivoController@showJefaturaAct');

//ruta para imprimir mis activos
Route::any('imprimirmisactivos','EmpActivoController@imprimirMisActivos');


//ruta para quitar activos asignados a un empleado
Route::any('eliminaractivos_emp','EmpActivoController@destroy');


//ruta para buscar un activo por su id
Route::any('findactivobyid','EmpActivoController@finActivoById');


Route::any('guardaredicionactivo','EmpActivoController@update');


//ruta para guardar un nuevo activo de un empleado
Route::any('guardarnuevoactivo','EmpActivoController@store');


//generar reporte de activos por empleado
Route::any('rpt_activoxempleado','EmpActivoController@rpt_ActivosXEmpleado');


//generar sabana de activos de edesal
Route::any('rpt_sabanaactivos','EmpActivoController@rpt_SabanaGeneral');


//listar los activos ingresados en la base de datos
Route::any('emp_activos_listado','EmpActivoController@getActivosAll');



//guardar un activo y generar la hoja respectiva
Route::any('saveactivowithhojabodega','EmpActivoController@saveWithHojaBodega');


Route::any('saveactivowithhoja','EmpActivoController@saveWithHoja');



//ruta para generar la hoja de activo
Route::any('generarHojaActivo','EmpActivoController@generarHojaActivo');



//ruta para buscar un activo seleccionado
Route::any('findactivobyid','EmpActivoController@findActivo');



//ruta para generar traslado
Route::any('generartraslado','EmpActivoController@generarTraslado');


//ruta para generar el pdf del traslado
Route::any('pdf_activotraslado','EmpActivoController@generarPDFTraslado');


//ruta para lanzar la vista de los traslados entre empleados
Route::any('indextraslados','EmpActivoController@getTraslados');


//aceptar traslado de activo
Route::any('aceptartrasladoactivo','EmpActivoController@aceptarTraslado');


//Ruta para actualizar un activo desde el centro de costos correspondiente
Route::any('updateactivo','EmpActivoController@updateActivoFromCC');


//Ruta para iniciar el proceso de baja por parte del empleado
Route::any('INITprocesobaja','EmpActivoController@iniciarProcesoBaja');


//generar el pdf de la baja
Route::any('pdf_activobaja','EmpActivoController@generarPDFBaja');



//ruta para finalizar el proceso de baja de activo
Route::any('finalizarbajaactivo','EmpActivoController@finalizarProcesoBaja');
/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/





/*---------------------------------------------------------------------------
 RUTAS PARA RESERVAS DE VEHICULOS
 ---------------------------------------------------------------------------*/
Route::any('vh_index','VH_ReservaController@index');

//finalizar una reserva
Route::any('finalizarreservabyempleado','VH_ReservaController@finalizarReservaByEmpleado');

//ruta para finalizar una reserva
Route::any('reservafinalizada','VH_ReservaController@finalizarReserva');
//ruta para actualizar una reserva
Route::any('actualizarreserva','VH_ReservaController@update');

//ruta para la vista de las reservas de los empleado
Route::any('misreservas','VH_ReservaController@view_reservasEmpleados');
//ruta para la vista de la edicion de las reservas
Route::get('reservaedicion','VH_ReservaController@edit');
//ruta para obtener reservas
Route::any('getreservas','VH_ReservaController@getReservasForCalendario');
//ruta para obtener una reserva por medio de su id M-GET
Route::any('getreservabyid','VH_ReservaController@getReservaByID');
//ruta para ingresar una nueva reserva
Route::any('ingresarreserva','VH_ReservaController@store');
//ruta para verificar el estado de las reservas de los empleados - vista para el supervisor del area
Route::any('vhadminreservas','VH_ReservaController@viewSolicitudesEmpleadosByAdmin');

//generar hoja de control
Route::any('vhgenerarhojacontrol','VH_ReservaController@generarHojaControl');

//comprobar disponibilidad de horarios
Route::any('vh_comprobardisponibilidad','VH_ReservaController@comprobarDisponibilidad');

//comprobar disponibilidad de reserva para la edicion
Route::any('vh_comprobardisponibilidad_edit','VH_ReservaController@comprobarDisponibilidadEdicion');

//ruta para las reservas de las jefaturas para que puedan aprobar o denegar las reservas
Route::any('reservasjefatura','VH_ReservaController@viewReservasByJefatura');

//edicion de la resolucion de la reserva para jefatura
Route::any('resolucionjefaturavh_reserva','VH_ReservaController@viewResolucion');

//aprobar una reserva por parte de jefatura
Route::any('aprobarreservavh','VH_ReservaController@aprobarReserva');

//denegar reserva
Route::any('denegarreserva','VH_ReservaController@denegarReserva');

//ruta para imprimir hoja de uso de vehiculo
Route::any('vh_imprimirhoja','VH_ReservaController@imprimirHoja');

//ruta para mostrar la vista de la autorizacion de los vehiculos para los dueños
Route::any('autorizacionvehiculos','VH_ReservaController@viewAutorizacionVH');

//ruta para mostrar la vista de autorizacion del vehiculo solicitado
Route::any('vh_autorizacion','VH_ReservaController@viewEditAutorizacion');


//ruta para el evento de autorizar el vehiculo seleccionado
Route::any('autorizarvehiculo','VH_ReservaController@autorizarVehiculo');

//aurotizar el vehiculo como dueño y jefe
Route::any('autorizarvehiculodj','VH_ReservaController@autorizarVehiculoByDuenoJefe');


//ruta para denegar un vehiculo
//ruta para el evento de autorizar el vehiculo seleccionado
Route::any('denegarvehiculo','VH_ReservaController@denegarVehiculo');

//edicion de reservas por parte de supervisor
Route::any('edicionreservaadmin','VH_ReservaController@editAdminView');

//cancelar reserva
Route::any('vh_cancelarreserva','VH_ReservaController@cancelarReserva');


//ruta para el index del kilometraje
Route::any('indexkilometraje','Ctr_KilometrajeController@index');

//lanzar la vista de la ficha de mantenimiento para el supervisor de dichos mttos
Route::any('fichamantenimiento','Ctr_KilometrajeController@fichaMtto');


//ruta para guardar un registro de kilometraje
Route::any('savekilometraje','Ctr_KilometrajeController@save');


//mostrar el listado de los kilometrajes ingresados
Route::any('showkilometraje','Ctr_kilometrajeController@show');

//listar las reservas para un kilometraje segun horarios seleccionados y vehiculo
Route::any('reservasbykilometraje','VH_ReservaController@reservasForKilometraje');


//editar un kilometraje
Route::any('edit_kilometraje','Ctr_KilometrajeController@edit');


//actualizar kilometraje
Route::any('actualizarkilometraje','Ctr_KilometrajeController@update');


//ruta para listar el ultimo km de un vehiculo
Route::any('ultimokilometraje','Ctr_KilometrajeController@getUltimoKm');


//index para reportes de kilometraje
Route::any('km_indexreportes','Ctr_KilometrajeController@indexReportes');



//listar el query del resumen por vehiculuo
Route::any('query_resumenxvehiculo','Ctr_KilometrajeController@queryResumenXVehiculo');


//listar el query del resumen por empleados
Route::any('query_resumenempleados','Ctr_KilometrajeController@queryResumenXEmpleado');


//generar excel para el reporte de resumen por empleados
Route::any('resumenxempleadosExcel','Ctr_KilometrajeController@generarExcelResumenEmpleados');


//Generar excel para el resumen por vehiculo
Route::any('resumenxvehiculoExcel','Ctr_KilometrajeController@resumenXVehiculoExcel');

//generar el pdf del resuemn por vehiculos
Route::any('resumenxvehiculoPDF','Ctr_KilometrajeController@resumenXVehiculoPDF');


//mostrar la vista para los dueños del kilometraje de sus carros
Route::any('dueñokilometraje','Ctr_KilometrajeController@showDueñoKM');


//listar los km ingresados por fecha establecida
Route::any('kmingresadosbyfecha','Ctr_KilometrajeController@kmIngresadosByFecha');



//generar excel para los km ingresados por fecha
Route::any('excel_kmingresadosbyfecha','Ctr_KilometrajeController@excelKmIngresadosByFecha');


//listar los km recorridos costos y galones cargados de los vehiculos de los dueños
Route::any('kilometrajevhdueños','Ctr_KilometrajeController@kmRecordidosDuenoVehiculo');


///generar el excel de los km recorridos por vehiculo
Route::any('excel_kmrecorridosporvh','Ctr_KilometrajeController@excelKmRecorridosVH');

/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/




/*----------------------------------------------------------------------------
RUTAS PARA MODULO
 ----------------------------------------------------------------------------*/

Route::any('getmodulos','ModuloController@getModulosById');
Route::any('modulos','ModuloController@index');
Route::any('savemodulo','ModuloController@store');




/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/




/*----------------------------------------------------------------------------
RUTAS PARA SISTEMAS
 ----------------------------------------------------------------------------*/

Route::any('sistemas','SistemaController@index');
Route::any('savesistema','SistemaController@store');
Route::any('editsistema','SistemaController@edit');
Route::any('updatesistema','SistemaController@update');






/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/



/*----------------------------------------------------------------------------
RUTAS PARA REQUISICIONES
 ----------------------------------------------------------------------------*/
 Route::any('nuevarequisicion','RequisicionController@create');
 Route::any('saverequisicion','RequisicionController@store');
 Route::any('nuevafila','RequisicionController@nuevaFila');
 Route::any('countrequisicion','RequisicionController@getCountRequisiciones');
 Route::any('rq_bandejaadmin','RequisicionController@bandejaAdmin');
 Route::any('verdetallesrequisicion','RequisicionController@show');
 Route::any('verdetallesrequisicionsuperv','RequisicionController@showSuperv');
 Route::any('rq_aprobadas','RequisicionController@adminAprobadasReq');
 Route::any('rq_bandejasuperv','RequisicionController@bandejaRequisicionSuperv');
 Route::any('imprimirhojaactivo','OrdenCompraController@imprimirHojaActivo');
 Route::any('actualizarrequisicion','RequisicionController@update');
 Route::any('eliminarrequisicion','RequisicionController@destroy');

 //ruta para guardar una hoja de activo
 Route::any('savehojaactivo','OrdenCompraController@saveHojaActivo');
 Route::any('estadosinsumos','BodegaController@getEstadosInsumos');
 //ruta para poder cambiar el estado de la hoja de activo para su baja
 Route::any('procesobac','HojaActivosController@iniciarProcesoBA');







/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/



/*----------------------------------------------------------------------------
RUTAS PARA CONTROL DE OFERTAS
 ----------------------------------------------------------------------------*/
Route::any('nuevaoferta','ControlOfertasController@index');




/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/





/*----------------------------------------------------------------------------
RUTAS PARA INSUMOS
 ----------------------------------------------------------------------------*/
Route::any('obtenerinsumos','InsumoController@obtenerInsumos');

Route::any('obteneridinsumo','InsumoController@obtenerInsumoXNombre');
Route::any('guardarinsumo','InsumoController@store');
Route::any('rpt_movimientopapeleria','InsumoController@rpt_movimientoPapeleria');
Route::any('qry_movimiento_pape','InsumoController@getQueryRptMovPape');
Route::any('qry_disponibilidad_pape_excel','InsumoController@generarExcelDispoPape');
Route::any('movimientopapeleria',function(){
   return view('insumos.admin.reportes.movimientopapeleria');
});
Route::any('qry_movimiento_limpieza','InsumoController@getQueryRptMovLimpieza');
Route::any('rpt_movimientolimpieza','InsumoController@rpt_movimientoLimpieza');
Route::any('qry_costoslimpieza','InsumoController@getQueryRptCostosLimpieza');
Route::any('rpt_costoslimpieza','InsumoController@rpt_CostosLimpieza');

//ruta para reporte de disponibilidad de herramientas
Route::any('rptdispoherramientas','InsumoController@rpt_DispoHerramientas');

//ruta para query de dispo de papeleria
Route::any('qry_dispoherram','InsumoController@getQueryRptDispoHerram');

//vista para lanzar vista de nuevo insumo
Route::any('insumos','InsumoController@create');


//ruta para buscar un insumo por id
Route::any('buscarinsumo','InsumoController@findInsumo');

//obtener insumo por nombre
Route::any('obtenerinsumo','InsumoController@findInsumoByNAME');

//ruta para guardar un insumo
Route::any('editarinsumo','InsumoController@update');


//eliminar un insumo
Route::any('deleteinsumo','InsumoController@destroy');


//ruta para obtener los insumos
Route::any('obtenerinsumosall','InsumoController@obtenerInsumosAll');





//ruta para mantenimiento de insumos
Route::any('mantenimiento_ins','InsumoController@mantenimiento_index');


//ruta para listar los detalles de movimientos sobre un insumo
Route::any('gethistoricoinsumosdetalles','InsumoController@getHistoricoInsumoMov');

//subvista para reporte de bajas de activo
Route::any('sv_bajaactivo','InsumoController@getBajasActivoByBodega');





//ruta para listar los consumos de un insumo en historico
Route::any('verconsumos_historico','InsumoController@getConsumosInsumo');


//ruta para generar el PDF de los consumos
Route::any('rpt_consumos','InsumoController@rptConsumos');


//ruta para administrador y poder ver los consumos de los centros de costos
Route::any('verconsumos_historico_admin','InsumoController@getConsumosByAdmin');


//ruta para ver el reporte de los consumos historicos de papeleria listado por todos los cc e insumos
Route::any('verconsumos_papeleria_all','InsumoController@getHistoricoConsumosPapeleria');


//ruta para generar el excel de los consumos historicos listados por cc
Route::any('excelconsumoshistoricos','InsumoController@generarExcelConsumosHistoricosPapeleria');

/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/


/*----------------------------------------------------------------------------
RUTAS PARA ORDENES
 ----------------------------------------------------------------------------*/
Route::any('saveorden','OrdenCompraController@store');
Route::any('ord_bandejaadmin','OrdenCompraController@show');
Route::any('ord_admin','OrdenCompraController@edit');
Route::any('moverinsumoscc','OrdenCompraController@moverInsumosToCC');
Route::any('ocPDF','OrdenCompraController@generarPDF');

//mover insumos a una bodega
Route::any('moverinsumosbodega','OrdenCompraController@moverInsumosToBodega');




/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/

/*----------------------------------------------------------------------------
RUTAS PARA CENTRO DE COSTOS y BODEGAS
 ----------------------------------------------------------------------------*/
Route::any('getcentroscostos','CentroCostosController@show');

Route::any('getinsumoscc','CentroCostosController@getInsumosCC');
Route::any('index_mov_superv','CentroCostosController@indexSupervisor');
Route::any('getviewbodegas','CentroCostosController@viewBodegas');
Route::any('getinsumosbodegas','BodegaController@getActivosBodega');

//vista para bodegas para los supervisores
Route::any('mibodega','BodegaController@viewInsumosByBodega');


//editar estado de activo
Route::any('edicionactivo','BodegaController@editarActivo');


//Obtener el precio de un insumo
Route::any('getpriceinsumo','CentroCostosController@getPriceInsumo');



//lanzar vista para las bajas de activos para que las realize contabilidad
Route::any('conta_bajas','EmpActivoController@indexContabilidadBajas');


//guardar hoja de activo para el area tecnica
Route::any('hojaactivoareatecnica','EmpActivoController@saveHojaActivoAreaTecnica');


//ruta para mostrar la vista de los cambios de estados de las herramientas
Route::any('rpt_cambiosdeestadosherram','BodegaController@rpt_cambiosEstadosHerram');


//ruta para para generar el excel de los cambios de estados de las herramientas
Route::any('excel_cambiosestadosherram','BodegaController@excel_CambiosEstadosHerram');


//ruta para mostrar activos de tipo herramientas para las bodegas virtuales
Route::any('indexbodegavirtual','EmpActivoController@indexBodegaVirtual');


//actualizar el estado de la herramienta de empleado
Route::any('actualizarvidautil','EmpActivoController@actualizarVidaUtil');




/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/


/*----------------------------------------------------------------------------
RUTAS PARA MOVIMIENTOS
 ----------------------------------------------------------------------------*/
Route::any('savemovimientos','MovimientoInsumoController@salida');
Route::any('inventarioinicial','MovimientoInsumoController@inventarioInicial');
Route::any('inv_inicial_pape','MovimientoInsumoController@invInicialPapeleria');
Route::any('inv_inicial_herram','MovimientoInsumoController@invInicialHerramienta');
Route::any('inv_inicial_oficina','MovimientoInsumoController@invInicialOficina');

/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/






/*----------------------------------------------------------------------------
RUTAS PARA ENR
 ----------------------------------------------------------------------------*/

Route::any('indexenr','ENRController@create');

//buscar mostrar detalle del nis y su cliente
Route::any('buscarinfonis','ENRController@detallesNIS');

//ruta para mostrar las lecturas del NIS
Route::any('buscarlecturasbynis','ENRController@getLecturas');

//ruta para mostrar los medidores historicos del NIS seleccionado
Route::any('buscarhistoricomedidores','ENRController@getMedidoresHistorico');


//sumatoria de lecturas nuevas para calculo de ENR
Route::any('sumatorianuevaslect','ENRController@sumatoriaLecturasNuevas');


//----------------------------------------------------------------------------



/*----------------------------------------------------------------------------
RUTAS PARA PROVEEDORES
 ----------------------------------------------------------------------------*/
Route::any('proveedoresindex','ProveedoresController@index');
Route::any('guardarproveedor','ProveedoresController@store');
Route::any('getproveedorbyid','ProveedoresController@show');
Route::any('actualizarproveedor','ProveedoresController@update');
Route::any('ingresarproveedoraux','ProveedoresController@saveProveedorAux');

/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/


/*----------------------------------------------------------------------------
RUTAS PARA Departamentos y municipios
 ----------------------------------------------------------------------------*/
Route::any('getmunicipiosbydpto','MunicipioController@getMunByDpto');



/*----------------------------------------------------------------------------
 ----------------------------------------------------------------------------*/



/*
|--------------------------------------------------------------------------
| Rutas Para VNR
|--------------------------------------------------------------------------*/

Route::any('ingresosvnr','VNRController@ingresos');



/*
|--------------------------------------------------------------------------
| Rutas Politicas
|--------------------------------------------------------------------------*/

//index de politicas

Route::any('politicas','PoliticasController@index');
Route::any('buscador','PoliticasController@buscadorDocs');
Route::any('detalleDocumento','PoliticasController@detalleDocumentos');
Route::any('getIniciales','PoliticasController@getInicial');
Route::any('tablaControl','PoliticasController@tablaControlVista');
Route::any('getLastDoc','PoliticasController@getLastDocu');
Route::any('eliminarDocumento','PoliticasController@eliminarDocumentos');
//index de vinculacion de documentos

Route::any('vinculacion','PoliticasController@vinculacionDocs');
//index de subir politicas

Route::any('subirDocumentos','PoliticasController@subirDocumentosView');

Route::any('editarDocumentos','PoliticasController@editarDocumento');

//ruta para eliminado de areas, tipos de documentos, gerencias

Route::any('deleteTDocs','PoliticasController@deleteTipoDoc');
Route::any('deleteAreas','PoliticasController@deleteArea');
Route::any('deleteGerencias','PoliticasController@deleteGerencia');


//ruta para modificado de areas, tipos de documentos, gerencias
Route::any('updateGerencias','PoliticasController@updateGerencia');
Route::any('updateAreas','PoliticasController@updateArea');
Route::any('updateTipoDocs','PoliticasController@updateTipoDoc');

// ruta para insertado de areas, tipos de documentos, gerencias
Route::any('insertTipoDocs','PoliticasController@insertTipoDoc');
Route::any('insertAreas','PoliticasController@insertArea');
Route::any('insertGerencias','PoliticasController@insertGerencia'); 


Route::any('guardarDocumentos','PoliticasController@guardarDocumento'); 


Route::any('listadoDocumentosAsociados','PoliticasController@listadoDocumentoAsociado'); 


Route::any('mostrarDocumentosDisponibles','PoliticasController@mostrarDocumentoDisponible'); 

Route::any('relacionarDocumento','PoliticasController@relacionarDocumentos'); 


Route::any('eliminarRelacion','PoliticasController@eliminarRelacionDoc'); 


Route::any('proFaltantes','PoliticasController@proFaltante'); 
Route::any('polFaltantes','PoliticasController@polFaltante'); 

Route::any('proDesa','PoliticasController@proDes'); 
Route::any('polDesa','PoliticasController@polDes'); 