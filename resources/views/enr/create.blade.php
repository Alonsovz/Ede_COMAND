@extends('layouts.template')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@stop

@section('enunciado')
    ENR
@stop

@section('modulo')
    ENR
@stop

@section('submodulo')
    <b>Nuevo calculo</b>
@stop

@section('contenido')
    <div class="row " id="frm_enrcalculo">
        <div class="col-md-12">
            <div class="ibox" >
                <div class="ibox-title"><b><i class="fa fa-money"></i> Nuevo calculo de ENR</b></div>
                <div class="ibox-content" style="background-color: lightgrey; padding-left: 50px" >
                    <form class="form-horizontal" action="">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="">NIS:</label>
                                    <input type="text" class="form-control" id="txt_nis">
                                    <br>
                                    <button type="button" id="btn_buscarnis" class="btn-primary btn"><i class="fa fa-search"></i> Buscar</button>

                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="ibox-footer hidden divcalculoenr">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1"> Formulario para calculo</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-2"> Lecturas</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane active">
                                        <div class="ibox-footer " id="" style="padding-left: 25px">
                                            <form class="form-horizontal" id="frm_solicitudpermiso">
                                                <div class="row">
                                                    <h2>Datos Generales</h2>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Usuario:</label>
                                                            <input autocomplete="off" id="usuario"   name="nombrecompleto" type="text"  class="form-control" required title="Campo obligatorio">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" style="margin-left: 10px">
                                                        <div class="form-group">
                                                            <label>Medidor antiguo:</label>
                                                            <input autocomplete="off" id="medidor"   name="nombrecompleto" type="text"  class="form-control" required title="Campo obligatorio">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>OT Inspección Tecnica:</label>
                                                            <input autocomplete="off" id="otinspeccion"   name="nombrecompleto" type="text"  class="form-control" required title="Campo obligatorio">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" style="margin-left: 10px">
                                                        <div class="form-group">
                                                            <label>OT  cambio de medidor dañado:</label>
                                                            <input autocomplete="off" id="otcambiomedidor"   name="nombrecompleto" type="text"  class="form-control" required title="Campo obligatorio">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tarifa:</label>
                                                            <input autocomplete="off" id="tarifa"    name="nombrecompleto" type="text"  class="form-control" required title="Campo obligatorio">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" style="margin-left: 10px">
                                                        <div class="form-group">
                                                            <label>N° medidor instalado:</label>
                                                            <input autocomplete="off" id="medidorinstalado"   name="nombrecompleto" type="text"  class="form-control" required title="Campo obligatorio">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-2" >
                                                        <div class="form-group">
                                                            <label for="">Fecha de regularización:</label>
                                                            <div class='input-group date' id='fecharegularizacion'>
                                                                <input id="regularizacion" type='text' class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>





                                                <div id="barra_progreso" class="hidden row">
                                                    <h3>Enviando...</h3>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="83"
                                                             aria-valuemin="0" aria-valuemax="100" style="width:83%">
                                                            80%
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                        <div style="border-top: solid 2px lightgrey;padding-left: 25px;" class="ibox-footer hidden divcalculoenr" >
                                            <form action="" class="form-horizontal">

                                                <div class="row">
                                                    <h2>Datos Calculo ENR</h2>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tipo de calculo:</label>
                                                            <select class="form-control" name="" id="tipocalculo">
                                                                <option value=""></option>
                                                                <option value="Anterior">Anterior</option>
                                                                <option value="Posterior">Posterior</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" style="margin-left: 10px">
                                                        <div class="form-group">
                                                            <label>N° de dias historico:</label>
                                                            <select  class="form-control" name="" id="diashistoricos">
                                                                <option value=""></option>
                                                                <option value="60">60</option>
                                                                <option value="61">61</option>
                                                                <option value="62">62</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <h3>Periodo historico de consumos</h3>
                                                    <div class="col-lg-2" style="margin-left: 10px">
                                                        <div class="form-group">
                                                            <label for="">Desde:</label>
                                                            <div class='input-group date' id='datetimepicker2'>
                                                                <input id="desdehistorico" type='text' class="form-control" />
                                                                <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2" style="margin-left: 10px">
                                                        <div class="form-group">
                                                            <label for="">Hasta:</label>
                                                            <div class='input-group date' id='datetimepicker3'>
                                                                <input id="hastahistorico" type='text' class="form-control" />
                                                                <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>

                                                            </div>


                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="row">
                                                    <button type="button" id="sumatoria" class="btn btn-warning " style="border: solid 1px black;margin-left: 10px  "><i class="fa fa-calculator"></i> Sumar lecturas</button>
                                                </div>

                                                <div class="row hidden" id="promediosuma" style="margin-top: 15px">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Sumatoria nuevas lecturas:</label>
                                                            <input  autocomplete="off" id="sumalecturas"    name="sumalecturas" type="text"  class="form-control " >
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" style="margin-left: 10px">
                                                        <div class="form-group">
                                                            <label>Promedio diario de consumo:</label>
                                                            <input  autocomplete="off" id="promedioconsumo"    name="sumalecturas" type="text"  class="form-control " >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Dias retroactivo:</label>
                                                            <input autocomplete="off" id="diasretroactivo"    name="sumalecturas" type="text"  class="form-control" required title="Campo obligatorio">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" style="margin-left: 10px">
                                                        <div class="form-group">
                                                            <label>Consumo Estimado:</label>
                                                            <input autocomplete="off" id="consumoestimado"    name="sumalecturas" type="text"  class="form-control" required title="Campo obligatorio">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top: 10px">
                                                    <h3>Periodo Retroactivo de cobro ENR</h3>
                                                    <div class="col-lg-2" style="margin-left: 10px">
                                                        <div class="form-group">
                                                            <label for="">Desde:</label>
                                                            <div class='input-group date' id='datetimepicker4'>
                                                                <input id="desderetroactivo" type='text' class="form-control" />
                                                                <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2" style="margin-left: 10px">
                                                        <div class="form-group">
                                                            <label for="">Hasta:</label>
                                                            <div class='input-group date' id='datetimepicker5'>
                                                                <input id="hastaretroactivo" type='text' class="form-control" />
                                                                <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Consumo Registrado:</label>
                                                            <input autocomplete="off" id="consumoregistrado"    name="sumalecturas" type="text"  class="form-control" required title="Campo obligatorio">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" style="margin-left: 10px">
                                                        <div class="form-group">
                                                            <label>Monto Kwh ENR:</label>
                                                            <input autocomplete="off" id="montokwhenr"    name="sumalecturas" type="text"  class="form-control" required title="Campo obligatorio">
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                    <div id="tab-2" class="tab-pane">
                                        <table class="table table-responsive table-bordered">
                                            <thead>
                                                <tr >
                                                    <th style="background-color: black; color: white;" class="text-center">Periodo</th>
                                                    <th style="background-color: black; color: white;" class="text-center">Medidor</th>
                                                    <th style="background-color: black; color: white;" class="text-center">Lectura anterior</th>
                                                    <th style="background-color: black; color: white;" class="text-center">Lectura actual</th>
                                                    <th style="background-color: black; color: white;" class="text-center">Consumo</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodylecturas">

                                            </tbody>
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
@stop

@section('scripts')
    <script src="../js/plugins/fullcalendar/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/funciones/enr.js"></script>
@endsection