<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	  

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body >
		
		@foreach($permiso as $p)
		<div style="border: 1px solid gray; font-size: 7" id="content" class="row" >
			<div class="panel panel-default">
				<!-- Default panel contents -->
			
				<div class="panel-heading">
				<img src="images/EDESAL.png" width="200" height="50">
				<p class="text-center">Solicitud de Permiso por Ausencia de Laboral</p>
					<p class="text-center"><b>COORDINACION DE RECURSOS HUMANOS</b></p>
				</div>
			
			
				<!-- Table -->
				<table class="table  table-hover">
					
					<tbody>
						<tr>
							<td><b>DATOS GENERALES DEL EMPLEADO</b></td><td></td><td></td><td></td>
						</tr>
						<tr>
							<td>Nombre Empleado:</td>
							<td>{{$p->empleado}}</td>
							<td>Codigo del Empleado:</td>
							<td></td>
						</tr>
						<tr>
							<td><b>TIPO DE PERMISO</b></td><td></td><td></td><td></td>
						</tr>
						<tr>
							<td>Tipo de permiso seleccionado:</td>
							<td>{{$p->tipopermiso}}</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><b>DIAS DE PERMISO</b></td><td></td><td></td><td></td>
						</tr>
						<tr>
							<td>Horario de inicio:</td>
							<td>
								<?php
                                        $date=date_create($p->fechainicio);
                                        echo date_format($date,"d/m/Y H:i");
                                    ?>
							</td>
							<td>Horario de finalizacion:</td>
							<td>
								<?php
                                        $date=date_create($p->fechafin);
                                        echo date_format($date,"d/m/Y H:i");
								?>
							</td>
						</tr>

						<tr>
							<td><b>MOTIVO DEL PERMISO LABORAL</b></td><td></td><td></td><td></td>
						</tr>
						<tr>
							<td>{{$p->motivopermiso}}</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><b>RECURSOS HUMANOS</b></td><td></td><td></td><td></td>
						</tr>
						<tr>
							<td>Goce de sueldo:</td>
							@if($p->gocesueldo==0)
								<td>NO</td>
							@else
								<td>SI</td>
							@endif
							<td>Constancia:</td>
							@if($p->constancia==0)
								<td>NO</td>
							@else
								<td>SI</td>
							@endif
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		@endforeach






		

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
 		<script src="Hello World"></script>
	</body>
</html>