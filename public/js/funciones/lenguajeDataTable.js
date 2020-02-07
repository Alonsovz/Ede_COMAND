



$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var vehiculo = parseInt( $('#vehiculo').val(), 10 );
        var vh = parseFloat( data[1] ) || 0;


        if(  isNaN( vehiculo ) || vehiculo===vh)
        {
            return true;
        }
        return false;
    }
);

jQuery(document).ready(function($) {

    var table = $('.dataTables-example1').DataTable({
        "order": [[ 0, "desc" ]],
        "autoWidth": true,
        "language": {
            "lengthMenu": " _MENU_ Resultados por pagina",
            "search":         "Buscar:",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando resultados _PAGE_ de _PAGES_",
            "infoEmpty": "No se encontraron resultados",
            "infoFiltered": "(Filtrados de un total de _MAX_  Registros)",
            "paginate": {
                "first":      "Primero",
                "last":       "Ulitmo",
                "next":       ">",
                "previous":   "<"
            }


        }
    });

    var table2 = $('.dataTables-example2').DataTable({
        "order": [[ 0, "desc" ]],

        "language": {
            "lengthMenu": " _MENU_ Solicitudes por pagina",
            "search":         "Buscar:",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando resultados _PAGE_ de _PAGES_",
            "infoEmpty": "No se encontraron resultados",
            "infoFiltered": "(Filtrados de un total de _MAX_  Solicitudes)",
            "paginate": {
                "first":      "Primero",
                "last":       "Ulitmo",
                "next":       ">",
                "previous":   "<"
            }


        }
    });





    $('#vehiculo').keyup( function() {
        table.draw();
        table2.draw();
    } );


});