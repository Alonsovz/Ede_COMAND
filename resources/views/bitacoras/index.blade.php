@extends('layouts.template')

@section('css')
    <link rel="stylesheet" type="text/css" href="../css/pnotify.custom.min.css">

    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
@stop


@section('enunciado')
    Bitacora
@stop

@section('modulo')
    Bitacora
@stop

@section('submodulo')
    Index
@stop

@section('contenido')
  <div class="row" id="boardbitacora" style="height: 400px;">
      <div class="col-lg-12">
          <div class="ibox">
              <div class="ibox-title">
                  <h5></h5>
                  <div class="ibox-tools">
                      <button class="btn btn-success btn-lg btn-outline" id="btn_nuevabitacora"><i class="fa fa-plus"></i> Nueva bitacora</button>
                  </div>
              </div>
              <div class="ibox-content">

                  <div class="m-b-lg">


                      <div class="m-t-md">

                          <div class="pull-right hidden ">
                              <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-comments"></i> </button>
                              <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-user"></i> </button>
                              <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-list"></i> </button>
                              <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-pencil"></i> </button>
                              <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-print"></i> </button>
                              <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-cogs"></i> </button>
                          </div>

                          <h2> <i class="fa fa-book"></i> Bitacoras <b></b></h2>



                      </div>

                  </div>

                  <div class="table-responsive">
                      <table class="table  table-hover dataTables-example1">
                          <thead class="" style="background-color: lightgrey">
                          <th style="border: 1px solid black">Id de bitacora</th>
                          <th style="border: 1px solid black">Ticket</th>
                          <th style="border: 1px solid black">Descripcion</th>
                          <th style="border:solid 1px black">Tiempo dedicado</th>
                          <th style="border: 1px solid black">Fecha de bitacora</th>



                          </thead>
                          <tbody>
                            @foreach($bitacoras as $bitacora)

                                <tr>
                                    <td style="width: 20px">
                                         <b>{{$bitacora->id}}</b>
                                    </td>
                                    <td style="width: 20px">
                                        <i class="fa fa-ticket"></i> {{$bitacora->ticket_id}}
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


                                </tr>
                            @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="row hidden" id="nuevabitacora">

  </div>

  <div class="row" id="detallesbitacora">

  </div>

@stop

@section('scripts')
    <!--funciones para datatables-->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>

    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="../js/funciones/lenguajeDataTable.js"></script>




    <!-- funciones para los mensajes de alerta -->
    <script type="text/javascript" src='../js/pnotify.custom.min.js'></script>

    <script src="../js/funciones/bitacoras.js"></script>

@stop