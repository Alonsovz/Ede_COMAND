<link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">
<link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
<link rel="stylesheet" type="text/css" href="../css/plugins/datapicker/datepicker3.css">
<link rel="stylesheet" type="text/css" href="../css/plugins/clockpicker/clockpicker.css">

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">

                <div class="ibox-tools">
                    <a class="collapse-link">

                    </a>

                </div>
            </div>
            <div class="ibox-content">


                <form class="form-horizontal" id="frm_nuevabitacora">
                    <h1 style="margin-bottom: 30px"><i class="fa fa-file-text"></i> Nueva bitacora </h1>

                    <div class="form-group"><label class="col-lg-2 control-label">Ticket de bitacora</label>

                        <div class="col-lg-3">
                            <input id="ticket" readonly="readonly" value="{{$ticket->id}}"  type="text" placeholder="" class="form-control">

                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                        <div class="col-lg-5">
                            <textarea class="form-control" name="" id="descripcion" cols="30" rows="5"></textarea>

                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Tiempo dedicado</label>

                        <div class="col-lg-2">
                            <input class="form-control" min="0.25" step="0.25" type="number" id="tiempodedicado">
                        </div>
                    </div>


                        <div class="form-group" id="data_1">
                            <label style="margin-right: 15px" class="col-lg-2 control-label">Fecha de bitacora</label>
                            <div class="input-group date col-lg-2" >
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input  type="text" id="fechabitacora" name="fechabitacora" class="form-control" value="">
                            </div>
                        </div>



                    <div class="form-group" >
                        <div class="col-lg-offset-2 col-lg-10">
                            <button id="regresarbandeja" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Regresar a bandeja</button>
                            <button class="btn btn-sm btn-primary" id="btn_registrarbitacora" type="button"><i class="fa fa-save"></i> Registrar bitacora</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="ibox-footer" id="iboxfooter">
                <h1 style="margin-bottom: 15px"><i class="fa fa-align-left"></i> Lineas de bitacora</h1>
                <table class="table  table-hover dataTables-example2 tablabitacoras">
                    <thead class="hidden">
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>

                    </thead>
                    <tbody>
                    @foreach($bitacoras as $bitacora)

                        <tr>
                            <td style="width: 20px">
                                <a class="text-success" href=""><i class="fa fa-ticket"></i> {{$bitacora->ticket_id}}</a>
                            </td>
                            <td style="width: 150px">
                                {{$bitacora->descripcion}}
                            </td>
                            <td style="width: 20px">
                                <i class="fa fa-clock-o"></i>
                                <?php
                                $tiempo = $bitacora->tiempodedicado;
                                $operacion = $tiempo*60;
                                echo $operacion.' minutos'
                                ?>
                            </td>
                            <td style="width: 15px">
                                <i class="fa fa-calendar"></i>
                                <?php
                                $fecha = date_create($bitacora->fechabitacora);
                                echo date_format($fecha,'d/m/Y');

                                ?>
                            </td>
                            <td class="hidden" style="width: 15px;"></td>
                            <td style="width: 15px" class="hidden">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive hidden">

</div>



<!-- funciones para calendario -->
<script type="text/javascript" src='../js/plugins/datapicker/bootstrap-datepicker.js'></script>
<!-- funciones para registrar los tiempos de los permisos por medio de la libreria clockpicker-->
<script type="text/javascript" src='../js/plugins/clockpicker/clockpicker.js'></script>
<!--funciones para el lenguaje de las datatables-->
<script src="../js/plugins/dataTables/datatables.min.js"></script>
<script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>


<script src="../js/funciones/bitacoras.js"></script>
<script type="text/javascript" src="../js/funciones/clockanddate.js"></script>
