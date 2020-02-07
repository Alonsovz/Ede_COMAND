@extends('layouts.template')


@section('css')

@stop

@section('contenido')
    <div class="row">
        <div class="col-lg-12">
            <h2 style="color:blue;"><b>Procedimiento de control de Erogaciones</b></h2>
      
            <p style="color:green; font-size:21px;
            font-weight:bold;">Genera tu sello</p>
            <br>
            <div id="alertasello" class="hidden alert-danger alert"><i class="fa fa-exclamation"></i> Favor rellenar los campos para generar el sello correcto</div>
        </div>
        <div class="col-lg-3">
            <div class="form-group"><label  style="font-size:20px;">Centros de costos</label>
                <select name="" id="centrocostos" class="form-control"
                style="width:100%;">
                    <option value="Selecciona">Selecciona tu cc..</option>
                    @foreach($centrocostos as $cc)
                        <option value="{{$cc->id}}">{{$cc->id}}. {{$cc->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label  style="font-size:20px;">Tipo de tarifario</label>
                <select name="" id="tipoactividad" class="form-control" style="width:100%;">
                    <option value="Selecciona" set selected>Selecciona un tipo tarifario..</option>
                    @foreach($tipostarifarios as $tt)
                        <option value="{{$tt->id}}">{{$tt->id}}. {{$tt->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3 hidden" id="gastos">
            <label  style="font-size:20px;">Tipo  de gasto</label>
            <div class="form-group">
                <select name="" id="tipotarifario" class="form-control" style="width:100%;">

                </select>
            </div>
        </div>


        <div class="col-lg-3 hidden" id="gastosgg">
            <label  style="font-size:20px;">Clasificación del gasto</label>
            <div class="form-group">
                <select name="" id="tipogasto" class="form-control" style="width:100%;">
                <option value="Selecciona" set selected>Selecciona..</option>
                    @foreach($tipoGastosGG as $gg)
                        <option value="{{$gg->estructura31_id}}">{{$gg->estructura31_id}}. {{$gg->estructura31_nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        
        <div class="col-lg-2 ">
            <div class="form-group">
                <button id="btn_generarsello" class="btn btn-success hidden"><i class="fa fa-plus-circle"></i> Generar</button>
                <button id="btn_nuevosello"
                class="btn  btn-warning hidden"><i class="fa fa-plus-circle"></i> Nuevo sello</button>
            </div>
        </div>

      
        <div class="col-md-8 hidden" id="tablasello">
        <br><br> <br><br>

            <div class="row" style="border: 2px solid black;">
            <h2 style="text-align:center;font-weight:bold;
            color:#027D7D;"><i class="fa fa-info-circle"></i> Sello Generado</h2>
            
            <div class="col-md-5">
            
            <table class="table table-striped " style="color: black; font-weight: bold;
            text-align:center;margin-left:20px;">
                <thead>

                </thead>
                <tbody>
                <tr>
                    <td style="border: solid 1px black">C.COSTO</td>
                    <td style="border: solid 1px black" id="tbl_cc"></td>
                </tr>
                
                <tr>
                    <td style="border: solid 1px black">TGASTO</td>
                    <td style="border: solid 1px black" id="tbl_tg"></td>
                </tr>

                <tr>
                    <td style="border: solid 1px black">T.TARIF</td>
                    <td style="border: solid 1px black" id="tbl_tt"></td>
                </tr>

               


                

                </tbody>
                <tfoot class="hidden">
                <tr>

                </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-2" ></div>
        <div class="col-md-5" >
        <center> <a style="color:#EB4304;
           font-weight:bold;font-size:15px;">
          
            Favor escribir en la factura o CCF y a la par del sello
             de la siguiente forma:</a></center>
                <br>
                <table class="table table-striped " style="color: black; font-weight: bold;
            text-align:center;margin-left:10px;">
                <thead>

                </thead>
                <tbody>
                <tr>
                    <td style="border: solid 1px black">Cla.Gasto.</td>
                    <td style="border: solid 1px black" id="tbl_gg"></td>
                </tr>
                </tbody>
                <tfoot class="hidden">
                <tr>

                </tr>
                </tfoot>
            </table>
        </div>
            <br><br>
        </div>
        </div>
    </div>

@stop

@section('scripts')
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script src="js/funciones/dashboard.js"></script>
@stop