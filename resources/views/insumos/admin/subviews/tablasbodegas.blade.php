

<div class="col-md-12" id="{{$bodega->codigo}}">
    <div class="ibox" >
        <div class="ibox-title">
            <h2 style="color: black;"><b>Bodega: </b>{{$bodega->codigo}} </h2>
            <div class="ibox-tools">
                <a class="close-link">
                    <i class="fa fa-times" id="{{$bodega->codigo}}"></i>
                </a>
            </div>
            <br>

                <div class="col-lg-2" style="background-color: white; color: black;"><h3>Buena condicion</h3></div>
                <div class="col-lg-2" style="background-color: lightsalmon; color: black;"><h3>Deteriorado</h3></div>
                <div class="col-lg-2" style="background-color: lightcoral; color: black;"><h3>Arruinado</h3></div>
                <div class="col-lg-2" style="background-color: lightgreen; color: black;"><h3>Proceso de baja</h3></div>


        </div>

        <div class="ibox-content">
            <table class="dataTables-example1 table table-hover table-mail dataTables-example tablamovimientos" id="" style="color: black; font-size: 11px">
                <thead id="header" class="">
                <tr style="background-color: lightgrey;">


                    <th class="text-center" style="border:  solid black 1px;">ID</th>
                    <th class="text-center" style="border:  solid black 1px;">Activo</th>
                    <th class="text-center" style="border:  solid black 1px;">Bodega</th>
                    <th class="text-center" style="border:  solid black 1px;">Marca</th>
                    <th class="text-center" style="border:  solid black 1px;">Modelo</th>
                    <th class="text-center" style="border:  solid black 1px;">Color</th>
                    <th class="text-center" style="border:  solid black 1px;">Estado</th>
                    <th class="text-center" style="border:  solid black 1px;">Vida util</th>

                </tr>
                </thead>
                <tbody>
                @foreach($insumos as $insumo)
                    @if($insumo->estadoactivo=="Proceso de baja" || $insumo->estadoactivo=="Activa" || $insumo->estadoactivo=="No activa")
                        @if($insumo->vidautil=="Deteriorado")
                            <tr style="background-color: lightsalmon">
                                <td style="border:  solid black 1px;" class="">{{$insumo->id}}</td>
                                <td style="border:  solid black 1px;" class="">{{$insumo->tipo_activo}}</td>
                                <td style="border:  solid black 1px;" class="text-center">{{$insumo->bodega}}</td>
                                <td class="text-center" style="border:  solid black 1px;">{{$insumo->marca}}</td>
                                <td class="text-center" style="border:  solid black 1px;"> {{$insumo->modelo}}</td>
                                <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->color}}</b></td>
                                <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->estadoactivo}}</b></td>
                                @if($insumo->vidautil=='Arruinado')
                                    <td  class="text-center" style="border:  solid black 1px; background: lightcoral;"><b>{{$insumo->vidautil}}</b></td>
                                @else
                                    <td class="text-center" style="border:  solid black 1px;">{{$insumo->vidautil}}</td>
                                @endif
                            </tr>
                        @elseif($insumo->vidautil=="Arruinado")
                            <tr style="background-color: lightcoral">
                                <td style="border:  solid black 1px;" class="">{{$insumo->id}}</td>
                                <td style="border:  solid black 1px;" class="">{{$insumo->tipo_activo}}</td>
                                <td style="border:  solid black 1px;" class="text-center">{{$insumo->bodega}}</td>
                                <td class="text-center" style="border:  solid black 1px;">{{$insumo->marca}}</td>
                                <td class="text-center" style="border:  solid black 1px;"> {{$insumo->modelo}}</td>
                                <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->color}}</b></td>
                                <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->estadoactivo}}</b></td>
                                @if($insumo->vidautil=='Arruinado')
                                    <td  class="text-center" style="border:  solid black 1px; background: lightcoral;"><b>{{$insumo->vidautil}}</b></td>
                                @else
                                    <td class="text-center" style="border:  solid black 1px;">{{$insumo->vidautil}}</td>
                                @endif
                            </tr>
                            @elseif($insumo->vidautil=="Buena condicion")
                            <tr>
                                <td style="border:  solid black 1px;" class="">{{$insumo->id}}</td>
                                <td style="border:  solid black 1px;" class="">{{$insumo->tipo_activo}}</td>
                                <td style="border:  solid black 1px;" class="text-center">{{$insumo->bodega}}</td>
                                <td class="text-center" style="border:  solid black 1px;">{{$insumo->marca}}</td>
                                <td class="text-center" style="border:  solid black 1px;"> {{$insumo->modelo}}</td>
                                <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->color}}</b></td>
                                <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->estadoactivo}}</b></td>
                                @if($insumo->vidautil=='Arruinado')
                                    <td  class="text-center" style="border:  solid black 1px; background: lightcoral;"><b>{{$insumo->vidautil}}</b></td>
                                @else
                                    <td class="text-center" style="border:  solid black 1px;">{{$insumo->vidautil}}</td>
                                @endif
                            </tr>
                            @elseif($insumo->estadoactivo=="Proceso de baja")
                            <tr style="background-color: lightgreen">
                                <td style="border:  solid black 1px;" class="">{{$insumo->id}}</td>
                                <td style="border:  solid black 1px;" class="">{{$insumo->tipo_activo}}</td>
                                <td style="border:  solid black 1px;" class="text-center">{{$insumo->bodega}}</td>
                                <td class="text-center" style="border:  solid black 1px;">{{$insumo->marca}}</td>
                                <td class="text-center" style="border:  solid black 1px;"> {{$insumo->modelo}}</td>
                                <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->color}}</b></td>
                                <td style="border:  solid black 1px;" class="text-center"><b>{{$insumo->estadoactivo}}</b></td>
                                @if($insumo->vidautil=='Arruinado')
                                    <td  class="text-center" style="border:  solid black 1px; background: lightcoral;"><b>{{$insumo->vidautil}}</b></td>
                                @else
                                    <td class="text-center" style="border:  solid black 1px;">{{$insumo->vidautil}}</td>
                                @endif
                            </tr>
                        @endif
                    @endif
                @endforeach
                </tbody>
                <tfoot id="footer" class="hidden">
                <tr>
                    <th>Codigo</th>
                    <th>Insumo</th>
                    <th>Sin asignar</th>
                    <th>Estado</th>
                    <th>Acccion</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


<script>
    $('.fa-times').click(function(){
        var id = this.id;
        $("#"+id+"").remove();
    });
</script>