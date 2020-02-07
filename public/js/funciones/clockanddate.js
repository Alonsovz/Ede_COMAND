jQuery(document).ready(function($) {
    //inicializamos los input de tipo datepicker
            $('#data_1 .input-group.date').datepicker({

                        todayBtn: "linked",
                        keyboardNavigation: false,
                        forceParse: false,
                        calendarWeeks: true,
                        autoclose: true,
                        format: "dd/mm/yyyy"
                    });
            //-------------------------------------------


             //inicializamos los input de tipo datepicker
            $('#data_2 .input-group.date').datepicker({

                        todayBtn: "linked",
                        keyboardNavigation: false,
                        forceParse: false,
                        calendarWeeks: true,
                        autoclose: true,
                        format: "dd/mm/yyyy"
                    });
            //-------------------------------------------



            //inicializamos los input de tipo clocpicker
             $('.clockpicker').clockpicker();
});