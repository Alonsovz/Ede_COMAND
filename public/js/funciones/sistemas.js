$(document).ready(function(){

    //evento para poder mostrar el formulario de nuevo sistema
    $('#btn_nuevosistema').click(function(){
       $('.ibox-content').slideUp('slow');
       $('.ibox-footer').slideDown('slow').removeClass('hidden');

    });



    //evento para guardar sistema
    $('#btn_guardarsistema').click(function(){
       $.ajax({
           url:'savesistema',
           type:'post',
           datatype:'json',
           data:{nombre:$('#nombresistema').val(),descripcion:$('#descripcionsistema').val()},
           success:function(data)
           {
               if(data==="success")
               {
                   new PNotify({
                       title:'muy bien',
                       text:'sistema ingresado con exito!',
                       type:'success'
                   });


                   document.getElementById('frm_sistema').reset();
                   location.href = 'sistemas';
               }
               else
               {
                   new PNotify({
                       title:'error',
                       text:'ocurrio un error mientras se guardaba la informacion del sistema',
                       type:'error'
                   });
               }
           }

       });
    });



    //evento para poder editar un sistema
    $('#tbl_sistemas').on('click','.btn_editarsistema',function(){

        document.getElementById('frm_edicionsistema').reset();

        //realizamos la solicitud de los datos del sistema
       $.getJSON('editsistema',{id:this.id},function(data){

           //recorremos y rellenamos los campos para la edicion
           $.each(data,function(index){
              $('#ed_nombre').val(data[index].nombre);
              $('#ed_descripcion').val(data[index].descripcion);
              $('.btn_guardaredicion').attr('id',data[index].id);
           });
       }) ;
    });







    //evento para guardar la edicion
    $('.btn_guardaredicion').click(function(){
        var id = this.id;

        $.getJSON('updatesistema',{id:id,nombre:$('#ed_nombre').val(),descripcion:$('#ed_descripcion').val()},function(data){
            if(data==="success")
            {
                new PNotify({
                    title:'muy bien',
                    text:'informacion actualizada con exito',
                    type:'success'
                });
                location.reload();
            }
            else
            {
                new PNotify({
                    title:'error',
                    text:'ocurrio un error mientras se actualizaba la informacion',
                    type:'error'
                });
            }
        });
    });







});