


<div class="col-md-6" id="{{$centrocosto->id}}">

    <div class="ibox" style="border: solid lightgrey 1px">
        <div class="ibox-title">
            <h5><b>{{$centrocosto->nombre}}</b></h5>
            <div class="ibox-tools">

                <a class="close-link">
                    <i class="fa fa-times" id="{{$centrocosto->id}}"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">
            <table class='dataTables-example1 table table-hover table-bordered table-mail dataTables-example' style="color:black;">
                <thead class=''>
                <tr style="background-color: lightgrey">
                    <th  style='border:solid grey 1px; width: 600px'>Categoria</th>
                    <th  style='border:solid grey 1px; width: 600px'>Insumo</th>
                    <th  style='border:solid grey 1px; width: 600px'>UM</th>
                    <th class='text-center' style='border:solid grey 1px; width: 10px'>Existencia</th>
                </tr>
                </thead>
                <tbody id='cuerpotabla'>
                @foreach($insumos as $insumo)
                    <tr>
                        <td style="border:solid grey 1px">{{$insumo->categoria}}</td>
                        <td style="border:solid grey 1px">{{$insumo->insumo}}</td>
                        <td style="border:solid grey 1px">{{$insumo->unidad}}</td>
                        <td style="border:solid grey 1px" class="text-center existencia">{{$insumo->existencia}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td style="border:solid grey 1px" ></td>
                    <td style="border:solid grey 1px" ></td>
                    <td style="border:solid grey 1px" ></td>
                    <td style="border:solid grey 1px" ></td>
                </tr>
                <tr>
                    <td style="border:solid grey 1px" ></td>
                    <td style="border:solid grey 1px" ></td>
                    <td style="border:solid grey 1px" ></td>
                    <td style="border:solid grey 1px" ></td>
                </tr>
                <tr style="background-color: lightgrey">
                    <td style="border:solid grey 1px" ></td>
                    <td style="border:solid grey 1px" ></td>
                    <td style="border:solid grey 1px"  class='text-right text-success'><b>TOTAL DE INSUMOS</b></td>
                    <td style="border:solid grey 1px"  class='text-center' id='totalinsumos'><b>{{$suma->suma}}</b></td>
                </tr>
                </tfoot>

            </table>
        </div>

    </div>

</div>




    <!--funciones para el lenguaje de las datatables-->


    <script>
        $('.fa-times').click(function(){
            var id = this.id;
            $("#"+id+"").remove();
        });
    </script>




