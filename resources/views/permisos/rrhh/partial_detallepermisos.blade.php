<link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">


        <table class="dataTables-example1 table-responsive table table-hover table-mail dataTables-example">
            <thead id="header" class="">
            <tr style="background-color: lightgrey">
                <th class="text-center" style="border:solid 1px black; width: 50px; ">Empleado</th>
                <th class="text-center" style="border:solid 1px black; width: 15px; ">Enfermedad</th>
                <th class="text-center" style="border:solid 1px black; width: 15px; ">Consulta Medica</th>
                <th class="text-center" style="border:solid 1px black; width: 15px; ">Accidente Laboral</th>
                <th class="text-center" style="border:solid 1px black; width: 15px; ">Req. Judicial</th>
                <th class="text-center" style="border:solid 1px black; width: 15px; ">Matrimonio</th>
                <th class="text-center" style="border:solid 1px black; width: 15px; ">Maternidad/Paternidad</th>
                <th class="text-center" style="border:solid 1px black; width: 15px; ">Vacaciones</th>
                <th class="text-center" style="border:solid 1px black; width: 15px; ">Otro</th>
                <th class="text-center" style="border:solid 1px black; width: 15px; ">Tiempo libre remunerado</th>
                <th class="text-center" style="border:solid 1px black; width: 15px; ">Tiempo libre no remunerado</th>
                <th class="text-center" style="border:solid 1px black; width: 15px; ">Defuncion</th>
                <th class="text-center" style="border:solid 1px black; width: 15px; ">Tiempo Compensado</th>
            </tr>
            </thead>
            <tbody>
            @foreach($detalles as $detalle)
                <tr>
                    <td style="border: solid 1px black; width: 50px"><strong>{{$detalle->Empleado}}</strong></td>
                    <td style="border: solid 1px black; width: 15px" class="text-center">{{$detalle->Enfermedad}}</td>
                    <td style="border: solid 1px black; width: 15px" class="text-center">{{$detalle->Consulta_medica}}</td>
                    <td style="border: solid 1px black; width: 15px" class="text-center">{{$detalle->Accidente_laboral}}</td>
                    <td style="border: solid 1px black; width: 15px" class="text-center">{{$detalle->Requerimiento_judicial}}</td>
                    <td style="border: solid 1px black; width: 15px" class="text-center">{{$detalle->Matrimonio}}</td>
                    <td style="border: solid 1px black; width: 15px" class="text-center">{{$detalle->Maternidad_Paternidad}}</td>
                    <td style="border: solid 1px black; width: 15px" class="text-center">{{$detalle->Vacaciones}}</td>
                    <td style="border: solid 1px black; width: 15px" class="text-center">{{$detalle->Otro}}</td>
                    <td style="border: solid 1px black; width: 15px" class="text-center">{{$detalle->Tiempo_libre_remunerado}}</td>
                    <td style="border: solid 1px black; width: 15px" class="text-center">{{$detalle->Tiempo_libre_no_remunerado}}</td>
                    <td style="border: solid 1px black; width: 15px" class="text-center">{{$detalle->Defunsion}}</td>
                    <td style="border: solid 1px black; width: 15px" class="text-center">{{$detalle->Tiempo_compensado}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot id="footer" class="hidden">

            </tfoot>
        </table>


    <script src="../js/plugins/dataTables/datatables.min.js"></script>

    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>