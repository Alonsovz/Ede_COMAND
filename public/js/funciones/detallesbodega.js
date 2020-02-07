$(document).ready(function(){

    //evento para baja
    $('.btn_iniciarbaja').click(function(){
        $.getJSON('procesobac',{ha:this.id},function(data){
            if(data===true)
            {
                new PNotify({
                    title:'Muy bien',
                    text:'Proceso de baja iniciado con exito',
                    type:'success'
                });

                $('#btn_insertarfila').removeClass('hidden');
                $('#alertaestado').addClass('hidden');
                //location.reload();
            }
        });
    });
});