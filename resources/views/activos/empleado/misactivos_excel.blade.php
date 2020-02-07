<!doctype html>
<html lang="en">
<head>

    <title></title>


</head>
<body>
<p style="font-family: Tahoma, Helvetica, Arial"><img  src="C:\xampp\htdocs\COMANDA\public\images\edesal1.png" alt=""></p>
<p style="font-family: font-family: Tahoma, Helvetica, Arial"><b style="font-size: 25px; margin-left: 275px">MIS ACTIVOS</b></p>


<div>
    <h5><b style="font-family: Tahoma, Helvetica, Arial">Listado de activos asignados a la fecha</b></h5>
    <h5 style="font-weight: 100"><b style="font-family: Tahoma, Helvetica, Arial">Usuario:</b> {{$usuario->nombre}} {{$usuario->apellido}}</h5>
    <h5 style="font-weight: 100"><b style="font-family: Tahoma, Helvetica, Arial">Fecha de impresion:</b> <?php echo date('d/m/Y H:i') ?></h5>
    <table id="tbl_kilometrajes" class="" style="color: black;margin-top: 20px; font-size: 12px;" >
        <thead id="header" class="">
        <tr >
            <th class="text-center" style="border: solid 1px grey;">Activo</th>
            <th class="text-center" style="border: solid 1px grey;">Marca</th>
            <th class="text-center" style="border: solid 1px grey;">Modelo</th>
            <th class="text-center" style="border: solid 1px grey;">Color</th>
            <th class="text-center" style="border: solid 1px grey;">Ubicacion</th>
            <th class="text-center" style="border: solid 1px grey;">Fecha</th>

        </tr>
        </thead>
        <tbody>
        @foreach($activos as $a)
            <tr style="">
                <td >{{$a->tipo_activo}}</td>
                <td >{{$a->marca}}</td>
                <td >{{$a->modelo}}</td>
                <td >{{$a->color}}</td>
                <td >{{$a->ubicacion}}</td>
                @if($a->fecha)
                    <td ><?php $fecha = date_create($a->fecha); echo date_format($fecha,'d/m/Y') ?></td>
                @else
                    <td >N/A</td>
                @endif

            </tr>

        @endforeach
        </tbody>

    </table>
</div>


</body>
</html>