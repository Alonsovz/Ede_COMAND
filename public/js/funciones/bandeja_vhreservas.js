$(document).ready(function(){
    //EVENTOS PARA LAS BANDEJAS
    $('#btn_enviadas').click(function(){
        $('#p_recibidas').removeClass('hidden');
        $('#p_aprobadas').addClass('hidden');
        $('#p_denegadas').addClass('hidden');
    });

    $('#btn_aprobadas').click(function(){
        $('#p_recibidas').addClass('hidden');
        $('#p_aprobadas').removeClass('hidden');
        $('#p_denegadas').addClass('hidden');
    });

    $('#btn_denegadas').click(function(){
        $('#p_recibidas').addClass('hidden');
        $('#p_aprobadas').addClass('hidden');
        $('#p_denegadas').removeClass('hidden');
    });



    //evento para cancelar una reserva
    $('.cancelarreserva').click(function(){
        var id = this.id;
        $.ajax({
            url: "vh_cancelarreserva",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function (data) {
                new PNotify({
                    title:'Muy bien',
                    text:'Reserva cancelada exitosamente!',
                    type:'success'
                });

                location.reload();
            }

        });
    });
});