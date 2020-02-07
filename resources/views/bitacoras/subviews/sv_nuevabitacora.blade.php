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
                        <button id="mibitacora" class="btn btn-danger btn-lg btn-outline"><i class="fa fa-arrow-left"></i> Bitacoras</button>
                    </a>

                </div>
            </div>
            <div class="ibox-content">


               <div class="row">
                   <div class="col-lg-7">
                       <form class="form-horizontal" id="frm_nuevabitacora">
                           <h1><i class="fa fa-file-text"></i> Nueva bitacora </h1><br><br>

                           <div class="form-group"><label class="col-lg-2 control-label">Ticket de bitacora</label>

                               <div class="col-lg-3">
                                   <input id="ticket" readonly="readonly"  type="text" placeholder="" class="form-control">
                                   <button type="button"  id="btn_buscarticket" style="margin-top: 5px" class="btn btn-xs btn-warning">Buscar ticket</button>
                               </div>
                           </div>

                           <div class="form-group"><label class="col-lg-2 control-label">Descripcion</label>

                               <div class="col-lg-8">
                                   <textarea class="form-control" name="" id="descripcion" cols="30" rows="5"></textarea>

                               </div>
                           </div>

                           <div class="form-group"><label class="col-lg-2 control-label">Tiempo dedicado</label>

                               <div class="col-lg-2">
                                   <input class="form-control" step="0.25" type="number" id="tiempodedicado">
                               </div>
                           </div>


                           <div class="form-group" id="data_1">
                               <label style="margin-right: 15px" class="col-lg-2 control-label">Fecha de bitacora</label>
                               <div class="input-group date col-lg-3" >
                                   <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                   <input  type="text" id="fechabitacora" name="fechabitacora" class="form-control" value="">
                               </div>
                           </div>



                           <div class="form-group" >
                               <div class="col-lg-offset-2 col-lg-10">
                                   <button class="btn btn-sm btn-primary" id="btn_registrarbitacora" type="button"> <i class="fa fa-save"></i> Registrar bitacora</button>
                               </div>
                           </div>
                       </form>
                   </div>
                   <div class="col-lg-4" style="overflow: auto;height: 500px;" id="lineas">
                       <h1><i class="fa fa-align-left"></i> Lineas de bitacora</h1>
                       <table id="tbl_lineas" class="table table-responsive table-bordered">
                           <thead>
                               <th style="width: 225px;">Descripcion</th>
                               <th class="text-center" style="width: 20px"><i class="fa fa-calendar"></i></th>
                           </thead>
                           <tbody id="lineas">

                           </tbody>
                       </table>
                   </div>
               </div>

            </div>
        </div>
    </div>
</div>

<div class="table-responsive hidden">

</div>

<div class="modal inmodal fade" id="tablatickets" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Modal title</h4>
                <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div id="funciona" class="hidden">
    <table class="table  table-hover dataTables-example2 tablatickets ">
        <thead class="" style="background-color: lightgrey">
        <th style="border: solid 1px black;">Estado</th>
        <th style="border: solid 1px black;">Ticket</th>
        <th style="border: solid 1px black;">Titulo</th>
        <th style="border: solid 1px black;">Descripcion</th>
        <th style="border: solid 1px black;">Solicitante</th>
        <th style="border: solid 1px black;">Fecha de sol.</th>
        <th style="border: solid 1px black;">Adjuntar</th>

        </thead>
        <tbody>
        @foreach($tickets as $ticket)
            @if($ticket->estado=='En proceso')
            <tr>

                <td class="issue-info" style="width: 60px">
                    <small>
                        {{$ticket->id}}
                    </small>
                </td>
                <td class="" style="width: 15px">
                    @if($ticket->estado=='Enviado')
                        <span class="label label-primary">Enviado</span>
                    @elseif($ticket->estado=='Recibido')
                        <span class="label label-warning">Recibido</span>
                    @elseif($ticket->estado=='En proceso')
                        <span class="label label-info">En proceso</span>
                    @elseif($ticket->estado=='Solucionado')
                        <span class="label label-success">Recibido</span>
                    @elseif($ticket->estado=='Cerrado')
                        <span class="label label-danger">Cerrado</span>

                    @endif
                </td>
                <td class="issue-info" style="width: 60px">
                    <small>
                        {{$ticket->titulo}}
                    </small>
                </td>
                <td style="width: 60px">
                    {{$ticket->descripcion}}
                </td>
                <td class="issue-info" style="width: 30px">
                    <a href="">
                        <i class="fa fa-user"></i>
                    </a>
                    <small>{{$ticket->nombresolicitante}} {{$ticket->apellidosolicitante}}</small>
                </td>
                <td style="width: 30px">
                    <small>
                        <b>
                            <?php
                            $date = date_create($ticket->fechasolicitud);
                            echo date_format($date,'d/m/Y');
                            ?>
                        </b>
                    </small>
                </td>
                <td class="text-right" style="width: 60px">
                    <button id="{{$ticket->id}}" class="btn btn-white btn-md adjuntar"><i class="fa fa-download"></i> Adjuntar</button>
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>


<!-- funciones para calendario -->
<script src="../js/plugins/fullcalendar/moment.min.js"></script>
<script type="text/javascript" src='../js/plugins/datapicker/bootstrap-datepicker.js'></script>
<!-- funciones para registrar los tiempos de los permisos por medio de la libreria clockpicker-->
<script type="text/javascript" src='../js/plugins/clockpicker/clockpicker.js'></script>
<!--funciones para el lenguaje de las datatables-->
<script src="../js/plugins/dataTables/datatables.min.js"></script>
<script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>


<script src="../js/funciones/bitacoras.js"></script>
<script type="text/javascript" src="../js/funciones/clockanddate.js"></script>
