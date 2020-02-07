@extends('layouts.template')


@section('css')
    <link rel="stylesheet" type="text/css" href="../css/plugins/dataTables/datatables.min.css">
@stop

@section('contenido')
   <div class="row">
       <div class="col-lg-12">
           <div class="ibox">
               <div class="ibox-title" style="background-color: deepskyblue;">
                   <h2><i class="fa fa-ticket"></i> Servicios y Req. / En proceso de TI</h2>
               </div>
               <div class="ibox-content">
                   <div class="row">
                       @foreach($ticketsproceso as $t)
                           <div class="col-md-3">
                               <div class="ibox" style="border: solid 1px lightgrey">
                                   <div class="ibox-title" style="background-color: white">
                                       <h3 style="color:black" class="text-left"><i class="fa fa-user"></i> <strong>{{$t->empleado}}</strong></h3>
                                       <div class="ibox-tools">
                                       </div>
                                   </div>
                                   <div class="ibox-content" style="height: 100px;">

                                       <strong>{{$t->conteo}}</strong> tickets en proceso...<br><br>
                                       <button style="border:solid black 1px;" id="{{$t->idusuario}}" class=" ticketdetalle btn btn-xs  btn-default"><i class="fa fa-ticket"></i> <strong>  tickets</strong></button>
                                       <button style="border:solid black 1px;" id="{{$t->idusuario}}" class=" pull-right btn btn-xs bitacoradetalle  btn-default"><i class="fa fa-file-text"></i> <strong>  bitacoras</strong></button>
                                   </div>


                               </div>
                           </div>
                       @endforeach
                   </div>
                   <div class="row">
                       <div class="col-md-3">
                           <button class="hidden btn btn-default btn-outline btn-lg" id="ocultar"><i class="fa fa-angle-up"></i> Ocultar</button>
                       </div>
                   </div>
               </div>

               <div style="height: 400px; overflow: scroll; overflow-x: hidden" class="ibox-footer hidden " id="footer">

                   <br><br>
               </div>
           </div>
       </div>
   </div>
@stop

@section('scripts')
    <script src="js/plugins/dataTables/datatables.min.js"></script>
    <!--funciones para el lenguaje de las datatables-->
    <script type="text/javascript" src="js/funciones/lenguajeDataTable.js"></script>


    <script>
        $(document).ready(function(){



            $('.ticketdetalle').click(function(){

                $('#footer').empty();
                $('#ocultar').removeClass('hidden');
                $.ajax({
                    url:'userticketdetalle',
                    data:{usuario:this.id},
                    type:'post',
                    datatype:'json',
                    success:function(data)
                    {
                        $('#footer').slideDown().removeClass('hidden').append(data);
                    }
                });
            });

            $('#ocultar').click(function(){
                $('#footer').slideUp('slow');
                $('#ocultar').addClass('hidden');
            });


            //evento para poder mostrar la bitacora de los ticket
            $('.bitacoradetalle').click(function(){
                $('#footer').empty();
                $('#ocultar').removeClass('hidden');
                $.ajax({
                    url:'bitacoradetalles',
                    datatype:'json',
                    type:'post',
                    data:{usuario:this.id},
                    success:function(data)
                    {
                        $('#footer').slideDown().removeClass('hidden').append(data);
                    }

                });
            });

        });
    </script>
@stop